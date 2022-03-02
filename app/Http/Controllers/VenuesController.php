<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Venue;
use App\Models\Event;
use App\Models\Shift;
use App\Repositories\Photos\PhotoAWS;
use App\Http\Requests\Venue\VenueMergeRequest;
use App\Http\Requests\Venue\VenueStoreRequest;
use App\Http\Requests\Venue\VenueUpdateRequest;
use App\Http\Requests\Venue\VenueUploadPhotoRequest;
use DB;

class VenuesController extends Controller
{
    public function index() {
        $venues = Venue::getFilteredVenues();
        return response()->json(['data' => $venues], 200);
    }

    public function search() {
        $searchStr = "";

        if (request()->has('q'))
            $searchStr = '%' . request()->input('q') . '%';

        $venues = Venue::where('name', 'like', $searchStr)
            ->orWhere('address_1', 'like', $searchStr)
            ->orWhere('address_2', 'like', $searchStr)
            ->orWhere('postal_code', 'like', $searchStr)
            ->orWhere('city', 'like', $searchStr)
            ->orWhere('country_text', 'like', $searchStr)
            ->orWhere('state_text', 'like', $searchStr)
            ->orWhere('website', 'like', $searchStr)
            ->orWhere('phone', 'like', $searchStr)
            ->paginate(20);

        return response()->json(['data' => $venues], 200);
    }

    public function store(VenueStoreRequest $request) {
        $attributes = $request->validated();
        $venue = Venue::create($attributes);
        return response()->json(['data' => $venue, 'message' => 'Venue created'], 201);
    }

    public function show(Venue $venue) {
        $venue->contacts;
        $venue->load('shifts');
        $venue->load('shifts.event');
        $venue->load('shifts.artist');
        $venue->load('shifts.event.artist');
        $venue->events->load('artist');
        return response()->json(['data' => $venue], 200);
    }

    public function update(VenueUpdateRequest $request, Venue $venue) {
        $attributes = $request->validated();
        $venue->update($attributes);
        $venue->contacts;
        $venue->events->load('artist');
        return response()->json(['data' => $venue, 'message' => 'Venue updated'], 200);
    }

    public function destroy(Venue $venue) {
        $venue->delete();
        return response()->json(['data' => $venue, 'message' => 'Venue deleted'], 200);
    }

    public function export() {
        $venues = Venue::getFilteredVenues(true);
        $venues->load('country');
        return $this->createExport($venues, "venues");
    }

    public function list() {
        $venues = Venue::select('id', 'name')->get();
        return response()->json(['data' => $venues], 200);
    }

    public function uploadPhoto(VenueUploadPhotoRequest $request, Venue $venue) {
        $attributes = $request->validated();
        $paws = new PhotoAWS($venue, $attributes);
        $paws->uploadPhoto($attributes);
        $venue->contacts;
        $venue->events->load('artist');
        return response()->json(['data' => $venue, 'message' => 'Venue updated'], 200);
    }

    public function merge(VenueMergeRequest $request, Venue $venue) {
        $attributes = $request->validated();

        DB::beginTransaction();
        try {
            //update foreign keys with destination id
            Event::where('venue_id', '=', $attributes['id'])->update(['venue_id' => $attributes['destination_id']]);
            Shift::where('venue_id', '=', $attributes['id'])->update(['venue_id' => $attributes['destination_id']]);

            //overlay destination volunteer with source volunteer data
            if ($attributes['overwrite']) {
                $destinationVenue = Venue::findOrFail($attributes['destination_id']);
                $destinationVenue->state_id = $venue->state_id;
                $destinationVenue->country_id = $venue->country_id;
                $destinationVenue->name = $venue->name;
                $destinationVenue->address_1 = $venue->address_1;
                $destinationVenue->address_2 = $venue->address_2;
                $destinationVenue->city = $venue->city;
                $destinationVenue->postal_code = $venue->postal_code;
                $destinationVenue->country_text = $venue->country_text;
                $destinationVenue->state_text = $venue->state_text;
                $destinationVenue->website = $venue->website;
                $destinationVenue->phone = $venue->phone;
                $destinationVenue->capacity = $venue->capacity;
                $destinationVenue->compost = $venue->compost;
                $destinationVenue->recycling_foh = $venue->recycling_foh;
                $destinationVenue->recycling_single_stream_foh = $venue->recycling_single_stream_foh;
                $destinationVenue->recycling_sorted_foh = $venue->recycling_sorted_foh;
                $destinationVenue->recycling_boh = $venue->recycling_boh;
                $destinationVenue->recycling_single_stream_boh = $venue->recycling_single_stream_boh;
                $destinationVenue->recycling_sorted_boh = $venue->recycling_sorted_boh;
                $destinationVenue->water_station = $venue->water_station;
                $destinationVenue->village_location = $venue->village_location;
                $destinationVenue->water_source = $venue->water_source;
                $destinationVenue->time_zone = $venue->time_zone;
                $destinationVenue->created_at = $venue->created_at;
                $destinationVenue->updated_at = $venue->updated_at;
                $destinationVenue->deleted_at = $venue->deleted_at;
                $destinationVenue->old_id = $venue->old_id;
                $destinationVenue->photo_url = $venue->photo_url;

                $destinationVenue->update();
            }

            $venue->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json(['data' => $venue, 'message' => 'Venue merged'], 200);
    }
}
