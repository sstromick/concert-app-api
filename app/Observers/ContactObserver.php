<?php

namespace App\Observers;

use App\Models\Contact;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ContactObserver
{
    public function created(Contact $contact)
    {
    }

    public function deleted(Contact $contact)
    {
        //
    }

    public function restored(Contact $contact)
    {
        //
    }

    public function forceDeleted(Contact $contact)
    {
        //
    }

    public function saving(Contact $contact)
    {
        if ( $contact->isDirty('contactable_type') ) {
            $contains = Str::contains($contact->contactable_type, 'App\\Models\\');
            if ($contains) {
                $contact->contactable_type = $contact->contactable_type;
            } else {
                $contact->contactable_type = "App\\Models\\" . $contact->contactable_type;
            }
        }
    }
}
