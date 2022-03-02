<?php

namespace App\Http\Controllers;

use App\Models\NonProfitShift;
use App\Http\Requests\NonProfitShift\NonProfitShiftStoreRequest;
use App\Http\Requests\NonProfitShift\NonProfitShiftUpdateRequest;
use Illuminate\Http\Request;

class NonProfitShiftsController extends Controller
{
    public function index() {
        $shifts = NonProfitShift::getFilteredNonProfitShifts();
        $shifts->load('NonProfit');
        return response()->json(['data' => $shifts], 200);
    }

    public function store(NonProfitShiftStoreRequest $request) {
        $attributes = $request->validated();
        $shifts = NonProfitShift::create($attributes);
        return response()->json(['data' => $shifts, 'message' => 'NonProfit Shift created'], 201);
    }

    public function show(NonProfitShift $nonprofitshift) {
        return response()->json(['data' => $nonprofitshift], 200);
    }

    public function update(NonProfitShiftUpdateRequest $request, NonProfitShift $nonprofitshift) {
        $attributes = $request->validated();
        $nonprofitshift->update($attributes);
        return response()->json(['data' => $nonprofitshift, 'message' => 'NonProfit Shift updated'], 200);
    }

    public function destroy(NonProfitShift $nonprofitshift) {
        $nonprofitshift->delete();
        return response()->json(['data' => $nonprofitshift, 'message' => 'NonProfit Shift deleted'], 200);
    }

    public function export() {
        $shifts = NonProfitShift::getFilteredNonProfitShifts();
        return $this->createExport($shifts, "nonprofit-shifts");
    }

    public function updateShifts(Request $request) {
        $attributes = $request->validate([
            "shift_id"  => "integer",
            "added_nonprofits"    => "array",
            "added_nonprofits.*"  => "integer",
            "deleted_nonprofits"    => "array",
            "deleted_nonprofits.*"  => "integer",
        ]);

        //loop through requested added_nonprofits id's and create a record
        if ($request['added_nonprofits']) {
            foreach($request['added_nonprofits'] as $id)
            {
                $shift = NonProfitShift::create(['shift_id' => $request['shift_id'], 'non_profit_id' => $id]);
            }
        }

        //loop through requested deleted_nonprofits id's and delete
        if ($request['deleted_nonprofits']) {
            foreach($request['deleted_nonprofits'] as $id)
            {
                $shift = NonProfitShift::where('id',$id)->delete();
            }
        }

        return response()->json(['data' => $attributes, 'message' => 'Nonprofit Shifts Updted'], 200);

    }
}
