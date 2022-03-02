<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Shift;
use App\Models\Volunteer;
use App\Models\VolunteerShift;
use App\Http\Requests\VolunteerShift\VolunteerShiftStoreRequest;
use App\Http\Requests\VolunteerShift\VolunteerShiftUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;

class VolunteerShiftsController extends Controller
{
    public function index() {
        $shifts = VolunteerShift::getFilteredVolunteerShifts();
        $shifts->load('volunteer');
        return response()->json(['data' => $shifts], 200);
    }

    public function getPendingShifts() {
        $shifts = $this->findPendingShifts();

        return response()->json(['data' => $shifts], 200);
    }

    public function findPendingShifts() {
        if (request()->has('event-id')) {
            $shifts = Event::with(['shifts.VolunteerShifts' => function ($query) {
                    $query->where('pending', 1);
                }])
                ->whereHas('shifts.VolunteerShifts', function ($query) {
                    $query->where('pending', 1);
                })
                ->whereIn('id', explode(",", request()->input('event-id')))
//                ->whereIn('id', array(request()->input('event-id')))
                ->paginate(10);
            }
        else {
            $shifts = Event::with('shifts.VolunteerShifts')
                ->whereHas('shifts.VolunteerShifts', function ($query) {
                    $query->where('pending', 1);
                })
                ->paginate(10);
        }
        return $shifts;
    }

    public function getVolunteerShiftsByVolunteer() {
        $shifts = VolunteerShift::with('shift', 'shift.event', 'shift.event.venue', 'shift.venue')
            ->where("volunteer_id", "=", request()->input('volunteer-id'))
            ->get()
            ->sortByDesc('shift.start_date');
        /*
        if (request()->has('volunteer-id')) {
            $shifts = DB::table('volunteer_shifts')
                        ->join('shifts', 'shift_id', "=", "shifts.id")
                        ->join('events', 'event_id', "=", "events.id")
                        ->leftjoin('venues', 'shifts.venue_id', "=", "venues.id")
                        ->leftjoin('shift_schedules', 'shifts.id', "=", "shift_schedules.shift_id")
                        ->select('shifts.name as shift_name', 'shifts.id as shift_id', 'shifts.start_date', 'shifts.end_date', 'shifts.doors', 'shifts.check_in', 'venues.name as venue_name', 'venues.city as venue_city', 'venues.state_text as venue_state_text', 'events.name as event_name','events.id as event_id', 'events.teams as teams')
                        ->where('volunteer_id', request('volunteer-id'))
                        ->get();
        }
*/
        return response()->json(['data' => $shifts], 200);
    }

    public function store(VolunteerShiftStoreRequest $request) {
        //if no shift_id then this is a teams event, determine which shift to use
        if (!$request->has('shift_id')) {
            $shifts = Shift::where('event_id', request('event_id'))->get();
            $minVolunteerShiftsCount = 9999999;
            $shift_id = null;
            foreach ($shifts as $s) {
                $currentCount = $s->VolunteerShifts->count();

                if ($currentCount < $minVolunteerShiftsCount) {
                    $minVolunteerShiftsCount = $currentCount;
                    $shift_id = $s->id;
                }
            }
        }


        // if no volunteer_id sent in, check if one exists based on email.
        // If a volunteer already exists, use it.... otherwise create one
        if (!$request->has('volunteer_id')) {
            $volunteer = Volunteer::where('email', request('email'))->first();
            if (!$volunteer) {
                $volunteer = Volunteer::create($request->except(['shift_id', 'event_id','note']));
            }
        }

        if ($volunteer) {
            if ($request->has('shift_id'))
                $attributes = array_merge($request->validated(), ['volunteer_id' => $volunteer->id]);
            else
                $attributes = array_merge($request->validated(), ['volunteer_id' => $volunteer->id], ['shift_id' => $shift_id]);
        }
        else {
            if ($request->has('shift_id'))
                $attributes = $request->validated();
            else
                $attributes = array_merge($request->validated(), ['shift_id' => $shift_id]);
        }
        //remove volunteer fields prior to volunteer_shifts insert
        unset($attributes['event_id']);
        unset($attributes['country_id']);
        unset($attributes['state_id']);
        unset($attributes['first_name']);
        unset($attributes['last_name']);
        unset($attributes['address_line_1']);
        unset($attributes['address_line_2']);
        unset($attributes['city']);
        unset($attributes['postal_code']);
        unset($attributes['country_text']);
        unset($attributes['state_text']);
        unset($attributes['email']);
        unset($attributes['phone']);
        unset($attributes['gender']);
        unset($attributes['tshirt_size']);
        unset($attributes['blocked']);

        $shifts = VolunteerShift::create($attributes);

        return response()->json(['data' => $shifts, 'message' => 'Volunteer Shift created'], 201);

    }

    public function show(VolunteerShift $volunteershift) {
        return response()->json(['data' => $volunteershift], 200);
    }

    public function update(VolunteerShiftUpdateRequest $request, VolunteerShift $volunteershift) {
        $attributes = $request->validated();
        $volunteershift->update($attributes);
        return response()->json(['data' => $volunteershift, 'message' => 'Volunteer Shift updated'], 200);
    }

    public function destroy(VolunteerShift $volunteershift) {
        $volunteershift->delete();
        return response()->json(['data' => $volunteershift, 'message' => 'Volunteer Shift deleted'], 200);
    }

    public function export() {
        $shifts = VolunteerShift::getFilteredVolunteerShifts();
        return $this->createExport($shifts, "volunteer-shifts");
    }

    public function updateStatus(Request $request) {
        $attributes = $request->validate([
            "accepted_ids"    => "array",
            "accepted_ids.id"  => "integer|nullable",
            "accepted_ids.shift_id"  => "integer|nullable",
            "declined_ids"    => "array",
            "declined_ids.*"  => "integer|nullable",
            "confirmed_ids"    => "array",
            "confirmed_ids.*"  => "integer|nullable",
            "waitlist_ids"    => "array",
            "waitlist_ids.*"  => "integer|nullable",
            "pending_ids"    => "array",
            "pending_ids.*"  => "integer|nullable",
        ]);

        //loop through requested accepted id's and update accepted to true

        if ($request['accepted_ids']) {
            foreach($request['accepted_ids'] as $item)
            {
                $volunteershift = VolunteerShift::find($item['id']);

                if (isset($item['shift_id'])) {
                    if (!$volunteershift->accepted) {
                        $volunteershift->update(['accepted' => true, 'shift_id' => $item['shift_id']]);
                    }
                }
                else {
                    if (!$volunteershift->accepted) {
                        $volunteershift->update(['accepted' => true]);
                    }
                }
            }
        }

        //loop through requested declined id's and update declined to true
        if ($request['declined_ids']) {
            foreach($request['declined_ids'] as $id)
            {
                $volunteershift = VolunteerShift::find($id);
                if (!$volunteershift->declined)
                    $volunteershift->update(['declined' => true]);
            }
        }

        //loop through requested pending id's and update pending to true
        if ($request['pending_ids']) {
            foreach($request['pending_ids'] as $id)
            {
                $volunteershift = VolunteerShift::find($id);
                if (!$volunteershift->pending)
                    $volunteershift->update(['pending' => true]);
            }
        }

        //loop through requested confirmed id's and update confirmed to true
        if ($request['confirmed_ids']) {
            foreach($request['confirmed_ids'] as $id)
            {
                $volunteershift = VolunteerShift::find($id);
                if (!$volunteershift->confirmed)
                    $volunteershift->update(['confirmed' => true]);
            }
        }

        //loop through requested waitlist id's and update waitlist to true
        if ($request['waitlist_ids']) {
            foreach($request['waitlist_ids'] as $id)
            {
                $volunteershift = VolunteerShift::find($id);
                if (!$volunteershift->waitlist) {
                    $volunteershift->update(['waitlist' => true]);
                }
            }
        }

        return response()->json(['data' => $attributes, 'message' => 'Volunteer Shift Updted'], 200);

    }

    public function massDelete(Request $request) {
        $attributes = $request->validate([
            "volunteerShifts"    => "array",
            "volunteerShifts.*"  => "integer",
        ]);

        foreach ($attributes['volunteerShifts'] as $vs) {
            $volunteerShift = VolunteerShift::find($vs);
            if ($volunteerShift) {
                $volunteerShift->delete();
            }
        }

        return response()->json(['data' => $attributes['volunteerShifts'], 'message' => 'Volunteer Shifts deleted'], 200);
    }
}
