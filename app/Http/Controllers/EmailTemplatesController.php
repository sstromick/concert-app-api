<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Http\Requests\EmailTemplate\EmailTemplateStoreRequest;
use App\Http\Requests\EmailTemplate\EmailTemplateUpdateRequest;
use Log;

class EmailTemplatesController extends Controller
{
    public function getEventTemplates() {
        $templates = EmailTemplate::where("event_id", "=", request()->input("event-id"))->whereNull("shift_id")->get();
        $templates->load('event');
        $templates->load('shift');

        return response()->json(['data' => $templates], 200);
    }

    public function index() {
        $templates = EmailTemplate::getFilteredEmailTemplates();
        $templates->load('event');
        $templates->load('shift');

        $returnData = [];
        for ($i=0; $i<count($templates); $i++) {
            //global default templates
            if (is_null($templates[$i]->event_id) && is_null($templates[$i]->shift_id))
                array_push($returnData, $templates[$i]);
            else {
                if (is_null($templates[$i]->shift_id)) {
                    $found = false;
                    for ($j=$i+1; $j<count($templates); $j++) {
                        if ($templates[$j]->event_type == $templates[$i]->event_type && $templates[$j]->event_id == $templates[$i]->event_id ) {
                            $found = true;
                        }
                    }
                    if (!$found)
                        array_push($returnData, $templates[$i]);
                }
                if (is_null($templates[$i]->shift_id)) {
                    $found = false;
                    for ($j=$i+1; $j<count($templates); $j++) {
                        if ($templates[$j]->event_type == $templates[$i]->event_type && $templates[$j]->event_id == $templates[$i]->event_id ) {
                            $found = true;
                        }
                    }
                    if (!$found)
                        array_push($returnData, $templates[$i]);
                }
                else
                    array_push($returnData, $templates[$i]);
            }
        }

        return response()->json(['data' => $returnData], 200);
    }

    public function store(EmailTemplateStoreRequest $request) {
        $attributes = $request->validated();

        //update if template already exists, else create a new one
        if (request()->has("shift_id")) {
            $template = EmailTemplate::where("event_id", "=", request()->input("event_id"))->where("shift_id", "=", request()->input("shift_id"))->where("event_type", "=", request()->input("event_type"))->first();
        }
        else {
            $template = EmailTemplate::where("event_id", "=", request()->input("event_id"))->where("event_type", "=", request()->input("event_type"))->first();
        }

        if ( $template ) {
            $template->update($attributes);
        }
        else {
            $template = EmailTemplate::create($attributes);
        }

        return response()->json(['data' => $template, 'message' => 'Email Template created'], 201);
    }

    public function show(EmailTemplate $emailtemplate) {
        $emailtemplate->emails;
        return response()->json(['data' => $emailtemplate], 200);
    }

    public function update(EmailTemplateUpdateRequest $request, EmailTemplate $emailtemplate) {
        $attributes = $request->validated();
        $emailtemplate->update($attributes);
        $emailtemplate->emails;
        return response()->json(['data' => $emailtemplate, 'message' => 'Email Template updated'], 200);
    }

    public function destroy(EmailTemplate $emailtemplate) {
        $emailtemplate->delete();
        return response()->json(['data' => $emailtemplate, 'message' => 'Email Template deleted'], 200);
    }

    public function export() {
        $templates = EmailTemplate::getFilteredEmailTemplates();
        return $this->createExport($templates, "templates");
    }

    public function list() {
        $templates = EmailTemplate::select('id', 'event_id', 'shift_id', 'event_type', 'subject')->get();
        return response()->json(['data' => $templates], 200);
    }
}
