<?php

namespace App\Traits;

use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Setting;
use App\Models\EmailTemplate;
use App\Models\Email;
use App\Models\VolunteerShift;
use Log;
use Mail;

trait Helpers
{
    protected function createExport($collection, $filename)
    {
        //column headings
        $data[] = array_keys($collection->first()->getOriginal());

        $updatedForeignKeyIndexes = [];

        //data rows
        foreach($collection->toArray() as $item) {
            $row = [];
            foreach ($item as $key => $value) {

                //relational data
                if (is_array($value)) {
                    //if header row has same field with _id suffix then include name field
                    $i = array_search($key.'_id',$data[0]);
                    if ($i) {
                        //save index in header row so we cna update heading at end
                        if (!in_array($i, $updatedForeignKeyIndexes)) {
                            array_push($updatedForeignKeyIndexes, $i);
                        }
                        //update realational id column with object name
                        $row[$i] = $value['name'];
                    }
                }
                else {
                    $row[] = $value;
                }
            }
            $data[] = $row;
        }

        foreach ($updatedForeignKeyIndexes as $index) {
            $data[0][$index] = str_replace("_id", "", $data[0][$index]);
        }

        return new StreamedResponse(
            function () use ($data) {
                $handle = fopen('php://output', 'w');
                foreach ($data as $row) {
                    fputcsv($handle, $row);
                }
                fclose($handle);
            },
            200,
            [
                'Content-type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename=' . $filename . '.csv'
            ]
        );

    }

    protected function sendEmail(VolunteerShift $volunteerShift, $type)
    {
        $setting = Setting::where('name', '=', 'confirmation-url')->first();

        //see if a template existis for shift
        $template = EmailTemplate::where('shift_id', '=', $volunteerShift->shift_id)->where('event_type', "=", $type)->get();

        //if not a template for shift, get event template
        if (!$template->count()) {
            $template = EmailTemplate::where('event_id', '=', $volunteerShift->shift->event_id)->whereNull('shift_id')->where('event_type', "=", $type)->get();
        }

        $venueName = "";
        $venueAddress = "";
        $venueCityState = "";
        $venueLink = "";
        if ($volunteerShift->shift->venue) {
            $venueName = $volunteerShift->shift->venue->name;
            $venueCityState = $volunteerShift->shift->venue->city . ", " . $volunteerShift->shift->venue->state_text;
            $venueLink = $volunteerShift->shift->venue->website;
            if ($volunteerShift->shift->venue->address_2)
                $venueAddress = $volunteerShift->shift->venue->address_1 . "<br>" . $volunteerShift->shift->venue->address_2;
            else
                $venueAddress = $volunteerShift->shift->venue->address_1;
        }
        else if ($volunteerShift->shift->event->venue) {
            $venueName = $volunteerShift->shift->event->venue->name;
            $venueCityState = $volunteerShift->shift->event->venue->city . ", " . $volunteerShift->shift->event->venue->state_text;
            $venueLink = $volunteerShift->shift->event->venue->website;
            if ($volunteerShift->shift->event->venue->address_2)
                $venueAddress = $volunteerShift->shift->event->venue->address_1 . "<br>" . $volunteerShift->shift->event->venue->address_2;
            else
                $venueAddress = $volunteerShift->shift->event->venue->address_1;
        }


        $artist = "";
        if ($volunteerShift->shift->artist)
            $artist = $volunteerShift->shift->artist->name;
        else if ($volunteerShift->shift->event->artist)
            $artist = $volunteerShift->shift->event->artist->name;

        if ($volunteerShift->shift->event->teams) {
            $shift_date = "";
            foreach ($volunteerShift->shift->ShiftSchedules as $schedule) {
                $shift_date .= "<br>" . Carbon::parse($schedule->start_date)->format('m/d/Y') . ' - ' . Carbon::parse($schedule->end_date)->format('m/d/Y');
            }
        }
        else {
            $shift_date = Carbon::parse($volunteerShift->shift->start_date)->format('m/d/Y') . ' - ' . Carbon::parse($volunteerShift->shift->end_date)->format('m/d/Y');
        }

        $replacements = array(
            'FIRST NAME' => $volunteerShift->volunteer->first_name,
            'LAST NAME' => $volunteerShift->volunteer->last_name,
            'EVENT' => $volunteerShift->shift->event->name,
            'ARTIST' => $artist,
            'SHIFT DATE' => $shift_date,
            'VENUE NAME' => $venueName,
            'VENUE ADDRESS' => $venueAddress,
            'VENUE CITY STATE' => $venueCityState,
            'VENUE LINK' => $venueLink,
            'CHECK IN TIME' => $volunteerShift->shift->check_in,
            'CONTACT NAME' => $volunteerShift->shift->event->contact_name,
            'CONTACT PHONE' => $this->format_phone($volunteerShift->shift->event->contact_phone),
            'CONTACT EMAIL' => $volunteerShift->shift->event->contact_email,
            //backwards compatibility for old field names
            'TOUR' => $volunteerShift->shift->event->name,
            'SHOW DATE' => $shift_date,
            'CONFIRMATION LINK' => '<a href="' . $setting->value . '?id=' . $volunteerShift->id .'">' . $setting->value . '</a>'
        );

        if ($template->count()) {
            $data = [
                'subject' => $this->replaceTokens($replacements, $template[0]->subject),
                'body'    => nl2br($this->replaceTokens($replacements, $template[0]->body)),
                'to'      => $volunteerShift->volunteer->email
            ];

            try {
                Mail::send([], [], function ($message) use ($data) {
                    $message->to($data['to'])
                        ->subject($data['subject'])
                        ->setBody($data['body'], 'text/html');
                });

                Email::create([
                    "event_id"     => $volunteerShift->shift->event_id,
                    "email_template_id" => $template[0]->id,
                    "volunteer_shift_id" => $volunteerShift->id,
                    "email"     => $data['to'],
                    "subject"   => $data['subject'],
                    "body"      => $data['body'],
                    "delivered" => true,
                ]);
            }
            catch (\Exception $e) {
                Email::create([
                    "event_id"     => $volunteerShift->shift->event_id,
                    "email_template_id" => $template[0]->id,
                    "volunteer_shift_id" => $volunteerShift->id,
                    "email"     => $data['to'],
                    "subject"   => $data['subject'],
                    "body"      => $data['body'],
                    "delivered" => false,
                    "error"     => $e->getMessage(),
                ]);
            }
        }
    }

    protected function replaceTokens($replacements, $text)
    {
        foreach($replacements as $find => $replace)
        {
            $text = preg_replace('/\[' . preg_quote($find, '/') . '\]/', $replace, $text);
        }

        return $text;
    }

    protected function format_phone($phone)
    {
        $phone = preg_replace("/^\d/", "", $phone);

        if(strlen($phone) == 7)
            return preg_replace("/(\d{3})(\d{4})/", "$1-$2", $phone);
        elseif(strlen($phone) == 10)
            return preg_replace("/(\d{3})(\d{3})(\d{4})/", "($1) $2-$3", $phone);
        else
            return $phone;
    }
}
