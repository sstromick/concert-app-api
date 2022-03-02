<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShiftSchedule;
use App\Http\Requests\ShiftSchedule\ShiftScheduleStoreRequest;
use App\Http\Requests\ShiftSchedule\ShiftScheduleUpdateRequest;
use Log;

class ShiftSchedulesController extends Controller
{
    public function index() {
        $schedules = ShiftSchedule::getFilteredShiftSchedules();
        return response()->json(['data' => $schedules], 200);
    }

    public function store(ShiftScheduleStoreRequest $request) {
        $attributes = $request->validated();
        $schedule = ShiftSchedule::create($attributes);
        return response()->json(['data' => $schedule, 'message' => 'Shift Schedule created'], 201);
    }

    public function show(ShiftSchedule $shiftschedule) {
        return response()->json(['data' => $shiftschedule], 200);
    }

    public function update(ShiftScheduleUpdateRequest $request, ShiftSchedule $shiftschedule) {
        $attributes = $request->validated();
        $shiftschedule->update($attributes);
        return response()->json(['data' => $shiftschedule, 'message' => 'Shift Schedule updated'], 200);
    }

    public function destroy(ShiftSchedule $shiftschedule) {
        $shiftschedule->delete();
        return response()->json(['data' => $shiftschedule, 'message' => 'Shift deleted'], 200);
    }

    public function export() {
        $schedules = ShiftSchedule::getFilteredShiftSchedules();
        return $this->createExport($schedules, "shift schedules");
    }
}
