<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMaster;
use App\Http\Requests\ContactMaster\ContactMasterStoreRequest;
use App\Http\Requests\ContactMaster\ContactMasterUpdateRequest;
use Log;

class ContactMastersController extends Controller
{
    public function index() {
        $contacts = ContactMaster::getFilteredContactMasters();
        $contacts->load('contacts');
        return response()->json(['data' => $contacts], 200);
    }

    public function search() {
        $searchStr = "";

        if (request()->has('q'))
            $searchStr = '%' . request()->input('q') . '%';

        $contacts = ContactMaster::where('name', 'like', $searchStr)
                ->orWhere('title', 'like', $searchStr)
                ->orWhere('email', 'like', $searchStr)
                ->orWhere('phone', 'like', $searchStr)
                ->paginate(20);

        $contacts->load('contacts');
        return response()->json(['data' => $contacts], 200);
    }

    public function store(ContactMasterStoreRequest $request) {
        $attributes = $request->validated();
        $contact = ContactMaster::create($attributes);
        return response()->json(['data' => $contact, 'message' => 'Contact created'], 201);
    }

    public function show(ContactMaster $contactmaster) {
        $contactmaster->contactable;
        return response()->json(['data' => $contactmaster], 200);
    }

    public function update(ContactMasterUpdateRequest $request, ContactMaster $contactmaster) {
        $attributes = $request->validated();
        $contactmaster->update($attributes);
        return response()->json(['data' => $contactmaster, 'message' => 'Contact updated'], 200);
    }

    public function destroy(ContactMaster $contactmaster) {
        $contactmaster->delete();
        return response()->json(['data' => $contactmaster, 'message' => 'Contact deleted'], 200);
    }


    public function export() {
        $contacts = ContactMaster::getFilteredContactMasters(true);
        return $this->createExport($contacts, "contacts");
    }

    public function list() {
        $contacts = ContactMaster::select('id', 'name')->get();
        return response()->json(['data' => $contacts], 200);
    }
}
