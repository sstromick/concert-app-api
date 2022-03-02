<?php

namespace App\Observers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteObserver
{
    public function created(Note $note)
    {
    }

    public function deleted(Note $note)
    {
        //
    }

    public function restored(Note $note)
    {
        //
    }

    public function forceDeleted(Note $note)
    {
        //
    }

    public function saving(Note $note)
    {
        if ( $note->isDirty('noteable_type') ) {
            $note->noteable_type = "App\\Models\\" . $note->noteable_type;
        }
    }
}
