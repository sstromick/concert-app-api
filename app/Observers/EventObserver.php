<?php

namespace App\Observers;

use App\Models\Event;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Log;

class EventObserver
{
    public function created(Event $event)
    {
        $templates = EmailTemplate::whereNull('event_id')->whereNull('shift_id')->get();

        foreach ($templates as $template) {
            EmailTemplate::create([
                'event_id' => $event->id,
                'subject' => $template->subject,
                'body' => $template->body,
                'event_type' => $template->event_type
            ]);
        }
    }

    public function deleted(Event $event)
    {
        //
    }

    public function restored(Event $event)
    {
        //
    }

    public function forceDeleted(Event $event)
    {
        //
    }

    public function saving(Event $event)
    {
        //
    }
}
