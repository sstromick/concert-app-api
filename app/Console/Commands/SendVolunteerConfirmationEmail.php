<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Shift;
use App\Models\VolunteerShift;
use Log;
use DB;
use App\Traits\Helpers;

class SendVolunteerConfirmationEmail extends Command
{
    use Helpers;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'volunteer:confirmation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send out volunteer confirmation emails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //get shifts starting in 14 days
        $shifts = Shift::whereDate('start_date', Carbon::now()->addDays(14))
        ->get();

        //if approved send out confirmation email
        foreach ($shifts as $shift) {
            foreach ($shift->VolunteerShifts as $vs) {
                if ($vs->accepted)
                    $this->sendEmail($vs, "Confirmation");
            }
        }
    }
}
