<?php

namespace App\Observers;

use Mail;
use App\Models\Shift;
use App\Models\ShiftSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Log;

class ShiftObserver
{
    public function created(Shift $shift)
    {
        //if array of schedules passed in insert them into shift_schedules, otherwise default to shift data
        if ($shift->event->teams) {
            if (request()->has('shift_schedules')) {
                foreach (request()->get('shift_schedules') as $schedule  ) {
                    $schedule = ShiftSchedule::create([
                        'shift_id' => $shift->id,
                        'start_date' => $schedule['start_date'],
                        'end_date' => $schedule['end_date'],
                        'doors' => $schedule['doors'],
                        'check_in' => $schedule['check_in'],
                    ]);
                }
            }
            else {
                $schedule = ShiftSchedule::create([
                    'shift_id' => $shift->id,
                    'start_date' => request()->get('start_date'),
                    'end_date' => request()->get('end_date'),
                    'doors' => request()->get('doors'),
                    'check_in' => request()->get('check_in')
                ]);
            }
        }
    }

    public function deleted(Shift $shift)
    {
        //
    }

    public function restored(Shift $shift)
    {
        //
    }

    public function forceDeleted(Shift $shift)
    {
        //
    }

    public function saving(Shift $shift)
    {
    }
}
