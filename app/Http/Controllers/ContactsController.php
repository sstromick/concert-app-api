<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\ContactMaster;
use App\Http\Requests\Contact\ContactStoreRequest;
use App\Http\Requests\Contact\ContactUpdateRequest;
use Log;

class ContactsController extends Controller
{
    public function index() {
        $contacts = Contact::getFilteredContacts();
        $contacts->load('ContactMaster');
        $contacts->load('venue');
        $contacts->load('nonprofit');
        return response()->json(['data' => $contacts], 200);
    }

    public function search() {
        $searchStr = "";

        if (request()->has('q'))
            $searchStr = '%' . request()->input('q') . '%';

        $contacts = Contact::where('name', 'like', $searchStr)
                ->orWhere('title', 'like', $searchStr)
                ->orWhere('email', 'like', $searchStr)
                ->orWhere('phone', 'like', $searchStr)
                ->paginate(20);

        $contacts->load('venue');
        $contacts->load('nonprofit');
        return response()->json(['data' => $contacts], 200);
    }

    public function store(ContactStoreRequest $request) {
        $attributes = $request->validated();

        //check if contact email already exists, if so use it... otherwise create one
        $contactMaster = ContactMaster::where('email', request('email'))->first();
        if (!$contactMaster) {
            $contactMaster = ContactMaster::create($request->only(['name', 'title','email', 'phone']));
        }

        $attributes = array_merge($request->validated(), ['contact_master_id' => $contactMaster->id]);

        $contact = Contact::create($attributes);
        $contact->load('ContactMaster');

        return response()->json(['data' => $contact, 'message' => 'Contact created'], 201);
    }

    public function show(Contact $contact) {
        $contact->contactable;
        return response()->json(['data' => $contact], 200);
    }

    public function update(ContactUpdateRequest $request, Contact $contact) {
        $cm = $contact->ContactMaster();
        $cm->update($request->only(['name', 'title','email', 'phone']));
        $contact = $contact->fresh();

        return response()->json(['data' => $contact, 'message' => 'Contact updated'], 200);
    }

    public function destroy(Contact $contact) {
        $contact->delete();
        return response()->json(['data' => $contact, 'message' => 'Contact deleted'], 200);
    }


    public function export() {
        $contacts = Contact::getFilteredContacts(true);
        return $this->createExport($contacts, "contacts");
    }

    public function list() {
        $contacts = Contact::select('id', 'name')->get();
        return response()->json(['data' => $contacts], 200);
    }
}
