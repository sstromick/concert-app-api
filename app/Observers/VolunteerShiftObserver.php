<?php

namespace App\Observers;

use Mail;
use App\Models\VolunteerShift;
use App\Models\EmailTemplate;
use App\Models\Email;
use App\Models\Setting;
use App\Mail\VolunteerAccepted;
use Carbon\Carbon;
use Log;
use App\Traits\Helpers;

class VolunteerShiftObserver
{
    use Helpers;
    /**
     * Handle the volunteer shift "created" event.
     *
     * @param  \App\VolunteerShift  $volunteerShift
     * @return void
     */
    public function created(VolunteerShift $volunteerShift)
    {
        if ($volunteerShift->accepted) {
            $volunteerShift->accepted_at = Carbon::Now();
            if ($volunteerShift->volunteer->email)
                Mail::to($volunteerShift->volunteer->email)->send(new VolunteerAccepted());
        }
    }

    /**
     * Handle the volunteer shift "updated" event.
     *
     * @param  \App\VolunteerShift  $volunteerShift
     * @return void
     */
    public function updated(VolunteerShift $volunteerShift)
    {
        if ( $volunteerShift->isDirty('accepted') ) {
            if ($volunteerShift->accepted) {
                if ($volunteerShift->volunteer->email) {
                    $this->sendEmail($volunteerShift, "Acceptance");
                }
            }
        }

        if ( $volunteerShift->isDirty('declined') ) {
            if ($volunteerShift->declined) {
                if ($volunteerShift->volunteer->email)
                    $this->sendEmail($volunteerShift, "Declined");
            }
        }

        if ( $volunteerShift->isDirty('waitlist') ) {
            if ($volunteerShift->waitlist) {
                if ($volunteerShift->volunteer->email)
                    $this->sendEmail($volunteerShift, "Wait List");
            }
        }

    }


    /**
     * Handle the volunteer shift "deleted" event.
     *
     * @param  \App\VolunteerShift  $volunteerShift
     * @return void
     */
    public function deleted(VolunteerShift $volunteerShift)
    {
        //
    }

    /**
     * Handle the volunteer shift "restored" event.
     *
     * @param  \App\VolunteerShift  $volunteerShift
     * @return void
     */
    public function restored(VolunteerShift $volunteerShift)
    {
        //
    }

    /**
     * Handle the volunteer shift "force deleted" event.
     *
     * @param  \App\VolunteerShift  $volunteerShift
     * @return void
     */
    public function forceDeleted(VolunteerShift $volunteerShift)
    {
        //
    }

    public function saving(VolunteerShift $volunteerShift)
    {
        if ( $volunteerShift->isDirty('accepted') ) {
            if ($volunteerShift->accepted) {
                $volunteerShift->accepted_at = Carbon::Now();
            }

            $volunteerShift->declined = false;
            $volunteerShift->waitlist = false;
            $volunteerShift->confirmed = false;
            $volunteerShift->pending = false;
        }

        else if ( $volunteerShift->isDirty('declined') ) {
            if ($volunteerShift->declined) {
                $volunteerShift->declined_at = Carbon::Now();
            }

            $volunteerShift->accepted = false;
            $volunteerShift->confirmed = false;
            $volunteerShift->waitlist = false;
            $volunteerShift->pending = false;
        }

        else if ( $volunteerShift->isDirty('pending') ) {
            $volunteerShift->accepted = false;
            $volunteerShift->confirmed = false;
            $volunteerShift->waitlist = false;
            $volunteerShift->declined = false;
        }

        else if ( $volunteerShift->isDirty('confirmed') ) {
            if ($volunteerShift->confirmed) {
                $volunteerShift->confirmed_at = Carbon::Now();
            }

            $volunteerShift->declined = false;
            $volunteerShift->waitlist = false;
            $volunteerShift->pending = false;
        }

        else if ( $volunteerShift->isDirty('waitlist') ) {
            $volunteerShift->declined = false;
            $volunteerShift->accepted = false;
            $volunteerShift->confirmed = false;
            $volunteerShift->pending = false;
        }
    }

}
