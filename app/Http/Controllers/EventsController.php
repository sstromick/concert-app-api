<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Event;
use App\Models\Shift;
use Illuminate\Http\Request;
use App\Repositories\Photos\PhotoAWS;
use App\Http\Requests\Event\EventStoreRequest;
use App\Http\Requests\Event\EventUpdateRequest;
use App\Http\Requests\Event\EventUploadPhotoRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;
use DB;

class EventsController extends Controller
{
    public function index() {
        $events = Event::getFilteredEvents();
        $events->load('artist');
        $events->load('venue');
        return response()->json(['data' => $events], 200);
    }

    public function search() {
        $searchStr = "";

        if (request()->has('q'))
            $searchStr = '%' . request()->input('q') . '%';

        $events = Event::where('name', 'like', $searchStr)
                ->orWhere('contact_name', 'like', $searchStr)
                ->orWhereHas('artist', function ($query) use ($searchStr) {
                    $query->where('name', 'like', $searchStr);})
                ->orWhereHas('venue', function ($query) use ($searchStr) {
                    $query->where('name', 'like', $searchStr);})
                ->orderBy('start_date', 'asc')
                ->paginate(20);

        $events->load('artist');
        $events->load('venue');

        return response()->json(['data' => $events], 200);
    }

    public function searchNoPaginate() {
        $events = Event::getFilteredEvents(true);
        $events->load('artist');
        $events->load('venue');
        return response()->json(['data' => $events], 200);
    }

    public function store(EventStoreRequest $request) {
        $attributes = $request->validated();
        $event = Event::create($attributes);
        return response()->json(['data' => $event, 'message' => 'Event created'], 201);
    }

    public function show(Event $event) {
        $event->shifts->load('venue');
        $event->load('artist');
        $event->load('venue');
        return response()->json(['data' => $event], 200);
    }

    public function update(EventUpdateRequest $request, Event $event) {
        $attributes = $request->validated();
        $event->update($attributes);
        $event->load('artist');
        $event->load('venue');
        return response()->json(['data' => $event, 'message' => 'Event updated'], 200);
    }

    public function destroy(Event $event) {
        $event->delete();
        return response()->json(['data' => $event, 'message' => 'Event deleted'], 200);
    }

    public function export(Request $request) {
        $ids = explode(",", $request->input("filter")['id']);
        $events = Event::setEagerLoads([])->with(['artist', 'venue', 'contacts'])->whereIn("id", $ids)->get();

        return $this->createEventExport($events, "events");
    }

    public function list() {
        $events = Event::select('id', 'name', 'artist_id', 'venue_id')->without('shifts')->get();
        $events->load('artist');
        $events->load('venue');
        return response()->json(['data' => $events], 200);
    }

    public function uploadPhoto(EventUploadPhotoRequest $request, Event $event) {
        $attributes = $request->validated();
        $paws = new PhotoAWS($event, $attributes);
        $paws->uploadPhoto($attributes);
        $event->load('artist');
        $event->load('venue');
        return response()->json(['data' => $event, 'message' => 'Event updated'], 200);
    }

    protected function exportEventMetrics(&$item, &$data, &$row, $metricEventHeadings, $firstTime=false)
    {
        $query = "select name, value from metric_values a, metrics b where a.metric_id = b.id and a.metricable_id = " . $item['id'] . " and a.metricable_type = 'Event' and active=1 and metric_type='Event'";

        if ($firstTime) {
            foreach ($metricEventHeadings as $heading) {
                array_push($data[0], $heading->name);
            }
        }

        $metrics = DB::select(DB::raw($query));
        if (count($metrics)) {
            foreach ($metrics as $metric) {
                $row[] = $metric->value;
            }
        }
        else {
            foreach ($metricEventHeadings as $heading) {
                $row[] = "";
            }
        }
    }

    protected function exportAddShifts(&$item, &$data, &$row)
    {
        $shifts = Shift::where("event_id",$item['id'])->get();
        $shifts->load('artist');
        $shifts->load('venue');

        $saveRow = $row;
        foreach ($shifts->toArray() as $shift) {
            $row[] = $shift['start_date'];
            $row[] = $shift['end_date'];
            $row[] = $shift['doors'];
            $row[] = $shift['check_in'];
            if (isset($shift['artist']))
                $row[] = $shift['artist']['name'];
            else
                $row[] = "";

            if (isset($shift['venue'])) {
                $row[] = $shift['venue']['name'];
                $row[] = $shift['venue']['city'];
            }
            else {
                $row[] = "";
                $row[] = "";
            }

            $numAccepted = 0;
            $numAttended = 0;
            $numConfirmed = 0;
            if (isset($shift['volunteer_shifts'])) {
                foreach ($shift['volunteer_shifts'] as $vs) {
                    if ($vs['accepted'])
                        $numAccepted++;
                    if ($vs['confirmed'])
                        $numConfirmed++;
                    if ($vs['attended'])
                        $numAttended++;
                }
            }
            $row[] = $numAccepted;
            $row[] = $numConfirmed;
            $row[] = $numAttended;

            $shiftNonProfits = [];
            foreach ($shift['non_profit_shifts'] as $npShift) {
                array_push($shiftNonProfits, $npShift['non_profit']['name']);
            }
            $row[] = implode(', ', $shiftNonProfits);

            $data[] = $row;
            $row = $saveRow;
        }
    }

    protected function createEventExport($collection, $filename)
    {
        //column headings
        $data[0] = array("id", "artist", "venue", "name", "passive", "teams", "start_date", "end_date", "created_at", "updated_at", "deleted_at", "contact_name");

        //data rows
        $firstTime = true;

        foreach($collection->toArray() as $item) {
            $row = [];
            if (isset($item['id']))
                $row[] = $item['id'];
            else
                $row[] = "";

            if (isset($item['artist']['name']))
                $row[] = $item['artist']['name'];
            else
                $row[] = "";

            if (isset($item['venue']['name']))
                $row[] = $item['venue']['name'];
            else
                $row[] = "";

            if (isset($item['name']))
                $row[] = $item['name'];
            else
                $row[] = "";

            if (isset($item['passive']))
                $row[] = $item['passive'];
            else
                $row[] = "";

            if (isset($item['teams']))
                $row[] = $item['teams'];
            else
                $row[] = "";

            if (isset($item['start_date']))
                $row[] = $item['start_date'];
            else
                $row[] = "";

            if (isset($item['end_date']))
                $row[] = $item['end_date'];
            else
                $row[] = "";

            if (isset($item['created_at']))
                $row[] = $item['created_at'];
            else
                $row[] = "";

            if (isset($item['updated_at']))
                $row[] = $item['updated_at'];
            else
                $row[] = "";

            if (isset($item['deleted_at']))
                $row[] = $item['deleted_at'];
            else
                $row[] = "";

            if (isset($item['contacts'][0]['contact_master']['name'])) {
                $row[] = $item['contacts'][0]['contact_master']['name'];
            }
            else {
                $row[] = "";
            }

            $firstTime = false;

            $this->exportAddShifts($item, $data, $row);
        }

        array_push($data[0], "shift_start_date");
        array_push($data[0], "shift_end_date");
        array_push($data[0], "doors");
        array_push($data[0], "check_in");
        array_push($data[0], "shift_artist");
        array_push($data[0], "shift_venue");
        array_push($data[0], "shift_city");
        array_push($data[0], "num_accepted");
        array_push($data[0], "num_confirmed");
        array_push($data[0], "num_attended");
        array_push($data[0], "nonprofits");


        return new StreamedResponse(
            function () use ($data) {
                $handle = fopen('php://output', 'w');
                foreach ($data as $row) {
                    fputcsv($handle, $row);
                }
                fclose($handle);
            },
            200,
            [
                'Content-type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename=' . $filename . '.csv'
            ]
        );

    }
}
