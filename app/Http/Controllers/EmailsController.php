<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\Contact;
use App\Models\NonProfitShift;
use App\Models\Volunteer;
use App\Http\Requests\Email\EmailStoreRequest;
use App\Http\Requests\Email\EmailUpdateRequest;
use Mail;
use Illuminate\Http\Request;
use Log;

class EmailsController extends Controller
{
    public function index() {
        $emails = Email::getFilteredEmails();
        $emails->load('event');
        $emails->load('EmailTemplate');
        $emails->load('NonProfitShift');
        $emails->load('VolunteerShift');
        return response()->json(['data' => $emails], 200);
    }

    public function search() {
        $searchStr = "";

        if (request()->has('q'))
            $searchStr = '%' . request()->input('q') . '%';

        $emails = Email::where('email', 'like', $searchStr)
                ->orWhere('subject', 'like', $searchStr)
                ->orWhereHas('event', function ($query) use ($searchStr) {
                    $query->where('name', 'like', $searchStr);})
                ->paginate(20);

        return response()->json(['data' => $emails], 200);
    }

    public function store(EmailStoreRequest $request) {
        $attributes = $request->validated();
        $emails = Email::create($attributes);
        return response()->json(['data' => $emails, 'message' => 'Email created'], 200);
    }

    public function show(Email $email) {
        return response()->json(['data' => $email], 201);
    }

    public function update(EmailUpdateRequest $request, Email $email) {
        $attributes = $request->validated();
        $email->update($attributes);
        return response()->json(['data' => $email, 'message' => 'Email updated'], 200);
    }

    public function destroy(Email $email) {
        $email->delete();
        return response()->json(['data' => $email, 'message' => 'Email deleted'], 200);
    }

    public function sendOnDemanEmails(Request $request) {
        $attributes = $request->validate([
            "contact_ids"    => "array",
            "contact_ids.*"  => "integer",
            "volunteer_ids"    => "array",
            "volunteer_ids.*"  => "integer",
            "nonprofit_ids"    => "array",
            "nonprofit_ids.*"  => "integer",
            "addresses"    => "array",
            "addresses.*.*"  => "string",
            "subject"  => "required|string",
            "body"  => "required|string",
        ]);

        //loop through requested contact id's and send emails
        if ($request['contact_ids']) {
            foreach($request['contact_ids'] as $id)
            {
                $contact = Contact::find($id);

                if ($contact)
                    $this->sendEmail($contact->email, $request);
            }
        }

        //loop through requested volunteer id's and send emails
        if ($request['volunteer_ids']) {
            foreach($request['volunteer_ids'] as $id)
            {
                $volunteer = Volunteer::find($id);

                if ($volunteer)
                    $this->sendEmail($volunteer->email, $request);
            }
        }

        //loop through requested non-profit id's and send emails
        if ($request['nonprofit_ids']) {
            foreach($request['nonprofit_ids'] as $id)
            {
                $nonprofit = NonProfitShift::find($id);

                if ($nonprofit)
                    $this->sendEmail($nonprofit->email, $request);
            }
        }

        //loop through requested email addresses and send emails
        if ($request['addresses']) {
            foreach($request['addresses'] as $addr)
            {
                $this->sendEmail($addr['email'], $request);
            }
        }

        return response()->json(['data' => $attributes, 'message' => 'Emails Sent'], 200);
    }

    //This function will send an on demand email and insert it into the Emails table
    public function sendEmail($to, $request) {
        $delivered = true;
        $error = "";

        $data = [
                'subject' => $request->input('subject'),
                'body'    => $request->input('body'),
                'to'      => $to
            ];

        try {
            Mail::send([], [], function ($message) use ($data) {
                $message->to($data['to'])
                    ->subject($data['subject'])
                    ->setBody($data['body'], 'text/html');
            });
        }
        catch (\Exception $e) {
            $delivered = false;
            $error = $e->getMessage();
        }

        $emailObj = new Email;

        if ($request->input('event_id'))
            $emailObj->event_id = $request->input('event_id');

        if ($request->input('email_template_id'))
            $emailObj->event_id = $request->input('email_template_id');

        if ($request->input('non_profit_shift_id'))
            $emailObj->event_id = $request->input('non_profit_shift_id');

        if ($request->input('volunteer_shift_id'))
            $emailObj->event_id = $request->input('volunteer_shift_id');

        $emailObj->email = $to;
        $emailObj->subject = $request->input('subject');
        $emailObj->body = $request->input('body');
        $emailObj->delivered = $delivered;

        if (!$delivered)
            $emailObj->error = $error;

        $emailObj->save();

    }

    public function export() {
        $emails = Email::getFilteredEmails(true);
        $emails->load('NonProfitShift');
        $emails->load('VolunteerShift');
        $emails->load('EmailTemplate');
        $emails->load('event');
        return $this->createExport($emails, "emails");
    }
}
