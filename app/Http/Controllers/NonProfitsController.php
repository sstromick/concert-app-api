<?php

namespace App\Http\Controllers;

use App\Models\NonProfit;
use App\Models\NonProfitShift;
use App\Repositories\Photos\PhotoAWS;
use App\Http\Requests\NonProfit\NonProfitMergeRequest;
use App\Http\Requests\NonProfit\NonProfitStoreRequest;
use App\Http\Requests\NonProfit\NonProfitUpdateRequest;
use App\Http\Requests\NonProfit\NonProfitUploadPhotoRequest;
use DB;

class NonProfitsController extends Controller
{
    public function index() {
        $nonprofits = NonProfit::getFilteredNonProfits();
        return response()->json(['data' => $nonprofits], 200);
    }

    public function search() {
        $searchStr = "";

        if (request()->has('q'))
            $searchStr = '%' . request()->input('q') . '%';

        $nonprofits = NonProfit::where('name', 'like', $searchStr)
            ->orWhere('address_line_1', 'like', $searchStr)
            ->orWhere('address_line_2', 'like', $searchStr)
            ->orWhere('city', 'like', $searchStr)
            ->orWhere('postal_code', 'like', $searchStr)
            ->orWhere('country_text', 'like', $searchStr)
            ->orWhere('state_text', 'like', $searchStr)
            ->orWhere('website', 'like', $searchStr)
            ->paginate(20);

        return response()->json(['data' => $nonprofits], 200);
    }

    public function noPaginate() {
        $nonprofits = NonProfit::getFilteredNonProfitsNoPaginate();
        return response()->json(['data' => $nonprofits], 200);
    }

    public function store(NonProfitStoreRequest $request) {
        $attributes = $request->validated();
        $nonprofits = NonProfit::create($attributes);
        return response()->json(['data' => $nonprofits, 'message' => 'NonProfit created'], 201);
    }

    public function show(NonProfit $nonprofit) {
        $nonprofit->NonProfitShifts->load('shift');
        return response()->json(['data' => $nonprofit], 200);
    }

    public function update(NonProfitUpdateRequest $request, NonProfit $nonprofit) {
        $attributes = $request->validated();
        $nonprofit->update($attributes);
        $nonprofit->NonProfitShifts->load('shift');
        return response()->json(['data' => $nonprofit, 'message' => 'NonProfit updated'], 200);
    }

    public function destroy(NonProfit $nonprofit) {
        $nonprofit->delete();
        return response()->json(['data' => $nonprofit, 'message' => 'NonProfit deleted'], 200);
    }

    public function export() {
        $nonprofits = NonProfit::getFilteredNonProfits(true);
        return $this->createExport($nonprofits, "nonprofits");
    }

    public function list() {
        $nonprofits = NonProfit::select('id', 'name')->get();
        return response()->json(['data' => $nonprofits], 200);
    }

    public function uploadPhoto(NonProfitUploadPhotoRequest $request, NonProfit $nonprofit) {
        $attributes = $request->validated();
        $paws = new PhotoAWS($nonprofit, $attributes);
        $paws->uploadPhoto($attributes);
        $nonprofit->NonProfitShifts->load('shift');
        return response()->json(['data' => $nonprofit, 'message' => 'NonProfit updated'], 200);
    }

    public function merge(NonProfitMergeRequest $request, NonProfit $nonprofit) {
        $attributes = $request->validated();

        DB::beginTransaction();
        try {
            //update foreign keys with destination id
            NonProfitShift::where('non_profit_id', '=', $attributes['id'])->update(['non_profit_id' => $attributes['destination_id']]);

            //overlay destination volunteer with source volunteer data
            if ($attributes['overwrite']) {
                $destinationNonprofit = NonProfit::findOrFail($attributes['destination_id']);
                $destinationNonprofit->state_id = $nonprofit->state_id;
                $destinationNonprofit->country_id = $nonprofit->country_id;
                $destinationNonprofit->name = $nonprofit->name;
                $destinationNonprofit->address_line_1 = $nonprofit->address_line_1;
                $destinationNonprofit->address_line_2 = $nonprofit->address_line_2;
                $destinationNonprofit->city = $nonprofit->city;
                $destinationNonprofit->postal_code = $nonprofit->postal_code;
                $destinationNonprofit->country_text = $nonprofit->country_text;
                $destinationNonprofit->state_text = $nonprofit->state_text;
                $destinationNonprofit->website = $nonprofit->website;
                $destinationNonprofit->created_at = $nonprofit->created_at;
                $destinationNonprofit->updated_at = $nonprofit->updated_at;
                $destinationNonprofit->deleted_at = $nonprofit->deleted_at;
                $destinationNonprofit->old_id = $nonprofit->old_id;
                $destinationNonprofit->photo_url = $nonprofit->photo_url;

                $destinationNonprofit->update();
            }

            $nonprofit->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json(['data' => $nonprofit, 'message' => 'Nonprofit merged'], 200);
    }
}
