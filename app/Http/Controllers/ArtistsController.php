<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Repositories\Photos\PhotoAWS;
use App\Http\Requests\Artist\ArtistStoreRequest;
use App\Http\Requests\Artist\ArtistUpdateRequest;
use App\Http\Requests\Artist\ArtistUploadPhotoRequest;

class ArtistsController extends Controller
{
    public function index() {
        $artists = Artist::getFilteredArtists();
        return response()->json(['data' => $artists], 200);
    }

    public function search() {
        $searchStr = "";

        if (request()->has('q'))
            $searchStr = '%' . request()->input('q') . '%';

        $artists = Artist::where('name', 'like', $searchStr)
                ->orderBy('name', 'asc')
                ->paginate(20);

        return response()->json(['data' => $artists], 200);
    }

    public function store(ArtistStoreRequest $request) {
        $attributes = $request->validated();
        $artist = Artist::create($attributes);
        return response()->json(['data' => $artist, 'message' => 'Artist created'], 201);
    }

    public function show(Artist $artist) {
        $artist->events->load('venue');
        return response()->json(['data' => $artist], 200);
    }

    public function update(ArtistUpdateRequest $request, Artist $artist) {
        $attributes = $request->validated();
        $artist->update($attributes);
        $artist->events->load('venue');
        return response()->json(['data' => $artist, 'message' => 'Artist updated'], 200);
    }

    public function destroy(Artist $artist) {
        $artist->delete();
        return response()->json(['data' => $artist, 'message' => 'Artist deleted'], 200);
    }

    public function export() {
        $artists = Artist::getFilteredArtists(true);
        return $this->createExport($artists, "artists");
    }

    public function list() {
        $artists = Artist::select('id', 'name')->get();
        return response()->json(['data' => $artists], 200);
    }

    public function uploadPhoto(ArtistUploadPhotoRequest $request, Artist $artist) {
        $attributes = $request->validated();
        $paws = new PhotoAWS($artist, $attributes);
        $paws->uploadPhoto($attributes);
        $artist->events->load('venue');
        return response()->json(['data' => $artist, 'message' => 'Artist updated'], 200);
    }
}
