<?php

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EmailTemplate;
use App\Models\Setting;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $keys = array(
            array(
                'id' => 1,
                'api_key' => '5DhDchmozV5FWaXId6Z2',
                'created_at' => date("Y-m-d H:i:s"),
            ),
        );

        DB::table('api_keys')->insert($keys);

      $settings = array(
                array('id' => 1, 'name' => "confirmation-url", 'value' => "http://reverb-wp.hopsie.org/confirmation", 'created_at' => date("Y-m-d H:i:s")),
                array('id' => 2, 'name' => "thank-you-url", 'value' => "http://reverb-wp.hopsie.org/thank-you/", 'created_at' => date("Y-m-d H:i:s")),
  );
            DB::table('settings')->insert($settings);

*/
        $templates = array(
            array(
                'id' => 1,
                'event_id' => null,
                'shift_id' => null,
                'subject' => 'Welcome to the REVERB volunteer team!',
                'body' => 'Dear [FIRST NAME],

Thank you for applying to volunteer with REVERB!

We would like to officially offer you a place on the volunteer team for the following show:

[ARTIST] - [TOUR]
[SHOW DATE]

[VENUE NAME]
[VENUE ADDRESS]
[VENUE CITY STATE]

You’ll receive another email from us 2 weeks before the show (if the show is more than two weeks away, if not you will receive it shortly) with additional details including when to meet, where to go, and who to contact when you get there. <strong>You WILL need to click a confirmation link in that email so we know that you are still available, so please keep an eye out for it!</strong>

In the meantime, check out our <a href="http://www.facebook.com/reverb">Facebook</a> page to see photos from the road! You can also email us at <a href="mailto:volunteer@reverb.org">volunteer@reverb.org</a> if you have any questions.

Thanks again, and welcome to the team!',
                'event_type' => 'Acceptance',
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 2,
                'event_id' => null,
                'shift_id' => null,
                'subject' => 'REVERB volunteer application update – wait list',
                'body' => 'Dear [FIRST NAME],

Thank you for applying to volunteer with REVERB.

Unfortunately, the following show has been filled and we are unable to offer you a place on the volunteer team at this time:

[ARTIST] - [TOUR]
[SHOW DATE]
[VENUE NAME]
[VENUE CITY STATE]

However, we think you would be a great addition to the team and we have put you on the wait list for this show. If we are able to add additional volunteers or have any cancellations, we will be in touch!

Thank you again for your support!',
                'event_type' => 'Wait List',
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 3,
                'event_id' => null,
                'shift_id' => null,
                'subject' => 'REVERB volunteer application',
                'body' => 'Dear [FIRST NAME],

Thank you for applying to volunteer with REVERB.

Unfortunately, the following show has been filled and we are unable to offer you a place on the volunteer team at this time:

[ARTIST] - [TOUR]
[SHOW DATE]
[VENUE NAME]
[VENUE CITY STATE]

We have a limited number of places on each volunteer team and we regret that we are not able to work with every interested volunteer. Please feel free to reapply for another show in the future.

Thank you again for your support!',
                'event_type' => 'Declined',
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 4,
                'event_id' => null,
                'shift_id' => null,
                'subject' => 'REVERB Volunteer Team: Event Information',
                'body' => '*** Please click this link: [CONFIRMATION LINK] to confirm or decline your spot on the volunteer team for the show listed below. To confirm, you must still be interested and available for volunteer, have read the requirements, and can arrive on time. ***

       Dear [FIRST NAME],

Thank you again for volunteering with REVERB! Please read through everything carefully, and <strong>don\'t forget to click the link above to confirm you have received this information</strong>. Unconfirmed volunteers will be replaced with volunteers from the wait list, so please respond as soon as you can.

<strong>SHOW DETAILS</strong>
        [ARTIST] - [TOUR]
        [SHOW DATE]
        [VENUE NAME]
        [VENUE ADDRESS]
        [VENUE CITY STATE]

 <strong>ARRIVAL TIME</strong>
        [CHECK IN TIME]

Please note that because we have limited staff, we need all volunteers to arrive on time. Late arrivals unfortunately cannot be accommodated and will forfeit their place on the volunteer team as well as their pass to the show.

<strong>CHECK IN</strong><br>
You will be meeting the following Reverb staffer OUTSIDE the main entrance of the venue:

        [CONTACT NAME]
        [CONTACT PHONE]


If you do not see the Reverb staffer when you arrive please call them at the number listed above. Remember that they are meeting a lot of people, so if you don\'t get an answer wait a minute or two and try again. Please do not leave a voicemail, thanks!

Additionally, please do not try to enter the venue on your own or speak with venue staff about entering as this generally tends to cause unnecessary confusion.

<strong>PARKING</strong>
Volunteers are responsible for their own parking. Check the venue website [VENUE WEBPAGE] - they usually have recommendations about where to park, as well as public transit options.

<strong>WHAT TO BRING AND WEAR</strong>
Close-toed shoes are recommended. You will be on your feet for a couple of hours so wear something comfy!

We will provide you with a volunteer t-shirt to wear during your shift and to take home afterwards, but otherwise please feel free to wear whatever you\'d like.

<strong>WORK PASS</strong>
The Reverb staffer you meet at check in will have your work pass, which will grant you access to the venue to volunteer. This pass will also allow you to watch the headlining artist from the general admission area of the venue.

Your volunteer shift will end just before the headlining act goes on stage.

<strong>VOLUNTEER TASKS</strong>
Volunteers will be assisting with several activities! When you arrive, you will go through a training session with our REVERB staffer, then you will help out with one of these tasks from the time that doors open until just before the headliner goes onstage:

[TOUR TASKS]

Please feel free to get in touch with us via <a href="mailto:volunteer@reverb.org">volunteer@reverb.org</a> if you have any questions, and thank you again for your help! We\'re looking forward to working with all of you!',
                'event_type' => 'Confirmation',
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 5,
                'event_id' => null,
                'shift_id' => null,
                'subject' => 'REVERB Volunteer Team: Event Reminder – TOMORROW!',
                'body' => 'Hi everyone!

One last reminder that REVERB volunteers will be meeting tomorrow at the following time and location:

[ARTIST] – [TOUR]
[SHOW DATE] @ [CHECK IN TIME]

[VENUE NAME]
[VENUE ADDRESS]
[VENUE CITY STATE]

Your show day contact is:

[CONTACT NAME]
[CONTACT PHONE]

Thanks, and have fun!

P.S. We’re counting on you all to be there, but if you need to cancel for ANY reason, please let me know ASAP by emailing [VOLUNTEER EMAIL] with your name, the date of the show, and the tour you are volunteering for. The day of the show is pretty hectic for our onsite staff and we want to make sure the information they have is as accurate as possible. Thank you!',
                'event_type' => 'Reminder',
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 6,
                'event_id' => null,
                'shift_id' => null,
                'subject' => 'Thank you for Volunteering!',
                'body' => 'Hello [FIRST NAME],

Thank you again for volunteering with REVERB at [ARTIST] - [TOUR]! We hope you met some great people, felt good about volunteering to promote sustainability in music, and saw an amazing show! We couldn’t accomplish our mission without you, and we hope to see you again!

THANK YOU!

Paige and Team REVERB',
                'event_type' => 'Thank You',
                'created_at' => date("Y-m-d H:i:s"),
            ),
        );

        DB::table('email_templates')->insert($templates);

        $templates = EmailTemplate::whereNull('event_id')->whereNull('shift_id')->get();

        $events = Event::all();

        foreach ($events as $event) {
            foreach ($templates as $template) {
                EmailTemplate::create([
                    'event_id' => $event->id,
                    'subject' => $template->subject,
                    'body' => $template->body,
                    'event_type' => $template->event_type
                ]);
            }
        }
    }
}
