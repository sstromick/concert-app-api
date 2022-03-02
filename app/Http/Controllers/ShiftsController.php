<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\ShiftSchedule;
use App\Http\Requests\Shift\ShiftStoreRequest;
use App\Http\Requests\Shift\ShiftUpdateRequest;
use Log;

class ShiftsController extends Controller
{
    public function index() {
        $shifts = Shift::getFilteredShifts();
        $shifts->load('event');
        $shifts->load('event.artist');
        $shifts->load('artist');
        $shifts->load('venue');
        return response()->json(['data' => $shifts], 200);
    }

    public function search() {
        $searchStr = "";
        $eventId = "";

        if (request()->has('q'))
            $searchStr = '%' . request()->input('q') . '%';

        if (request()->has('event'))
            $eventId = request()->input('event');

        $shifts = Shift::where('name', 'like', $searchStr)
                ->where("event_id", "=", $eventId)
                ->orWhereHas('event', function ($query) use ($searchStr) {
                    $query->where('name', 'like', $searchStr);})
                ->orWhereHas('artist', function ($query) use ($searchStr) {
                    $query->where('name', 'like', $searchStr);})
                ->orWhereHas('venue', function ($query) use ($searchStr) {
                        $query->where('name', 'like', $searchStr)
                        ->orWhere('city', 'like', $searchStr);
                    })
                ->orderBy('start_date', 'asc')
                ->paginate(20);

        $shifts->load('event');
        $shifts->load('artist');
        $shifts->load('venue');

        return response()->json(['data' => $shifts], 200);
    }

    public function searchAll() {
        $shifts = Shift::getFilteredShiftsAll(true);
        $shifts->load('event');
        $shifts->load('artist');
        $shifts->load('venue');
        return response()->json(['data' => $shifts], 200);
    }
    public function store(ShiftStoreRequest $request) {
        $attributes = $request->validated();
        $shift = Shift::create($attributes);
        return response()->json(['data' => $shift, 'message' => 'Shift created'], 201);
    }

    public function show(Shift $shift) {
        $shift->load('event');
        $shift->load('artist');
        $shift->load('venue');
        return response()->json(['data' => $shift], 200);
    }

    public function update(ShiftUpdateRequest $request, Shift $shift) {
        $attributes = $request->validated();
        $shift->update($attributes);
        $shift->load('event');
        $shift->load('artist');
        $shift->load('venue');

        if ($shift->event->teams) {
            if (request()->has('shift_schedules')) {
                foreach (request()->get('shift_schedules') as $s  ) {
                    if (isset($s['id'])) {
                        $schedule = ShiftSchedule::find($s['id']);
                        if ($schedule) {
                            $schedule->start_date = $s['start_date'];
                            $schedule->end_date = $s['end_date'];
                            $schedule->doors = $s['doors'];
                            $schedule->check_in = $s['check_in'];
                            $schedule->save();
                        }
                    }
                    else {
                        $schedule = ShiftSchedule::create([
                            'shift_id' => $shift->id,
                            'start_date' => $s['start_date'],
                            'end_date' => $s['end_date'],
                            'doors' => $s['doors'],
                            'check_in' => $s['check_in'],
                        ]);
                    }
                }
            }
        }

        $shift->refresh();

        return response()->json(['data' => $shift, 'message' => 'Shift updated'], 200);
    }

    public function destroy(Shift $shift) {
        $shift->delete();
        return response()->json(['data' => $shift, 'message' => 'Shift deleted'], 200);
    }

    public function export() {
        $shifts = Shift::getFilteredShifts(true);
        return $this->createExport($shifts, "shifts");
    }

    public function list() {
        $shifts = Shift::select('id', 'name')->get();
        return response()->json(['data' => $shifts], 200);
    }
}
