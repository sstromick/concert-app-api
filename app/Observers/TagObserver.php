<?php

namespace App\Observers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagObserver
{
    public function created(Tag $tag)
    {
    }

    public function deleted(Tag $tag)
    {
        //
    }

    public function restored(Tag $tag)
    {
        //
    }

    public function forceDeleted(Tag $tag)
    {
        //
    }

    public function saving(Tag $tag)
    {
        if ( $tag->isDirty('tagable_type') ) {
            $tag->tagable_type = "App\\Models\\" . $tag->tagable_type;
        }
    }
}
