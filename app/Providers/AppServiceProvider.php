<?php

namespace App\Providers;

use DB;
use Log;
use App\Models\Tag;
use App\Models\Note;
use App\Models\Event;
use App\Models\Shift;
use App\Models\Contact;
use App\Models\VolunteerShift;
use App\Observers\TagObserver;
use App\Observers\NoteObserver;
use App\Observers\EventObserver;
use App\Observers\ShiftObserver;
use App\Observers\ContactObserver;
use Illuminate\Support\ServiceProvider;
use App\Observers\VolunteerShiftObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
/*
DB::listen(function($query) {
    Log::info(
        $query->sql,
        $query->bindings,
        $query->time
    );
});
*/
        Event::observe(EventObserver::class);
        Shift::observe(ShiftObserver::class);
        VolunteerShift::observe(VolunteerShiftObserver::class);
        Note::observe(NoteObserver::class);
        Tag::observe(TagObserver::class);
        Contact::observe(ContactObserver::class);
    }
}
