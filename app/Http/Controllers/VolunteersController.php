<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use App\Models\VolunteerShift;
use App\Repositories\Photos\PhotoAWS;
use App\Http\Requests\Volunteer\VolunteerStoreRequest;
use App\Http\Requests\Volunteer\VolunteerUpdateRequest;
use App\Http\Requests\Volunteer\VolunteerUploadPhotoRequest;
use App\Http\Requests\Volunteer\VolunteerMergeRequest;
use Illuminate\Http\Request;
use DB;
use Log;

class VolunteersController extends Controller
{
    public function index() {
        $volunteers = Volunteer::getFilteredVolunteers();
        return response()->json(['data' => $volunteers], 200);
    }

    public function search() {
        $searchStr = "";

        if (request()->has('q'))
            $searchStr = '%' . request()->input('q') . '%';

        $volunteers = Volunteer::where('first_name', 'like', $searchStr)
            ->orWhere('last_name', 'like', $searchStr)
            ->orWhere('address_line_1', 'like', $searchStr)
            ->orWhere('address_line_2', 'like', $searchStr)
            ->orWhere('city', 'like', $searchStr)
            ->orWhere('country_text', 'like', $searchStr)
            ->orWhere('state_text', 'like', $searchStr)
            ->orWhere('email', 'like', $searchStr)
            ->orWhere('phone', 'like', $searchStr)
            ->paginate(20);

        return response()->json(['data' => $volunteers], 200);
    }

    public function show(Volunteer $volunteer) {
        // had to hack it here, it didn't want to sort by shift.start_date using relation
        $volunteer_shifts = $volunteer->VolunteerShifts()
        ->with(['shift' => function($q) {
            $q->with('artist');
            $q->with('event');
            $q->with('venue');
        }])
        ->get()
        ->sortByDesc('shift.start_date')
        ->flatten()
        ->toArray();
        $volunteer->emails;
        $volunteer->volunteer_shifts = $volunteer_shifts;
        return response()->json(['data' => $volunteer], 200);
    }

    public function store(VolunteerStoreRequest $request) {
        $attributes = $request->validated();
        $volunteers = Volunteer::create($attributes);
        return response()->json(['data' => $volunteers, 'message' => 'Volunteer created'], 201);
    }


    public function update(VolunteerUpdateRequest $request, Volunteer $volunteer) {
        $attributes = $request->validated();
        $volunteer->update($attributes);
        $volunteer->VolunteerShifts->load(['shift.event', 'shift.venue']);
        $volunteer->emails;
        return response()->json(['data' => $volunteer, 'message' => 'Volunteer updated'], 200);
    }

    public function destroy(Volunteer $volunteer) {
        $volunteer->delete();
        return response()->json(['data' => $volunteer, 'message' => 'Volunteer deleted'], 200);
    }

    public function export() {
        $volunteers = Volunteer::getFilteredVolunteers(true);
        $volunteers->load('country');
        return $this->createExport($volunteers, "volunteers");
    }

    public function list() {
        $volunteers = Volunteer::select('id', 'first_name', 'last_name')->get();
        return response()->json(['data' => $volunteers], 200);
    }

    public function pendingVolunteers() {
        $volunteers = Volunteer::getPendingVolunteers();
        return response()->json(['data' => $volunteers], 200);
    }

    public function uploadPhoto(VolunteerUploadPhotoRequest $request, Volunteer $volunteer) {
        $attributes = $request->validated();
        $paws = new PhotoAWS($volunteer, $attributes);
        $paws->uploadPhoto($attributes);
        $volunteer->VolunteerShifts->load(['shift.event', 'shift.venue']);
        $volunteer->emails;
        return response()->json(['data' => $volunteer, 'message' => 'Volunteer updated'], 200);
    }

    public function merge(VolunteerMergeRequest $request, Volunteer $volunteer) {
        $attributes = $request->validated();

        DB::beginTransaction();
        try {
            //update foreign keys with destination id
            VolunteerShift::where('volunteer_id', '=', $attributes['id'])->update(['volunteer_id' => $attributes['destination_id']]);

            //overlay destination volunteer with source volunteer data
            if ($attributes['overwrite']) {
                $destinationVolunteer = Volunteer::findOrFail($attributes['destination_id']);
                $destinationVolunteer->state_id = $volunteer->state_id;
                $destinationVolunteer->country_id = $volunteer->country_id;
                $destinationVolunteer->first_name = $volunteer->first_name;
                $destinationVolunteer->last_name = $volunteer->last_name;
                $destinationVolunteer->address_line_1 = $volunteer->address_line_1;
                $destinationVolunteer->address_line_2 = $volunteer->address_line_2;
                $destinationVolunteer->city = $volunteer->city;
                $destinationVolunteer->postal_code = $volunteer->postal_code;
                $destinationVolunteer->country_text = $volunteer->country_text;
                $destinationVolunteer->state_text = $volunteer->state_text;
                $destinationVolunteer->email = $volunteer->email;
                $destinationVolunteer->phone = $volunteer->phone;
                $destinationVolunteer->gender = $volunteer->gender;
                $destinationVolunteer->tshirt_size = $volunteer->tshirt_size;
                $destinationVolunteer->blocked = $volunteer->blocked;
                $destinationVolunteer->blocked_at = $volunteer->blocked_at;
                $destinationVolunteer->created_at = $volunteer->created_at;
                $destinationVolunteer->updated_at = $volunteer->updated_at;
                $destinationVolunteer->deleted_at = $volunteer->deleted_at;
                $destinationVolunteer->old_id = $volunteer->old_id;
                $destinationVolunteer->photo_url = $volunteer->photo_url;
                $destinationVolunteer->update();
            }

            $volunteer->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json(['data' => $volunteer, 'message' => 'Volunteer merged'], 200);
    }

    public function massDelete(Request $request) {
        //we are passed a volunteer shift and delete the attached volunteer
        $attributes = $request->validate([
            "volunteerShifts"    => "array",
            "volunteerShifts.*"  => "integer",
        ]);

        foreach ($attributes['volunteerShifts'] as $vs) {
            $volunteerShift = VolunteerShift::find($vs);
            if ($volunteerShift) {
                $volunteerShift->volunteer()->delete();
            }
        }

        return response()->json(['data' => $attributes['volunteerShifts'], 'message' => 'Volunteers deleted'], 200);
    }

}
