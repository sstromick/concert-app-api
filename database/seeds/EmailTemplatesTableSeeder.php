<?php

use Illuminate\Database\Seeder;

class EmailTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('emails')->delete();
        DB::table('email_templates')->delete();

        $templates = array(
            array(
                'id' => 1,
                'event_id' => null,
                'shift_id' => null,
                'subject' => 'Welcome to the REVERB + [ARTIST] Volunteer Team!',
                'body' => 'Hello [FIRST NAME],

Thank you for applying to volunteer with REVERB!

We would like to officially offer you a place on the volunteer team for the following show:

[ARTIST] - [TOUR]
[SHOW DATE]

[VENUE NAME]
[VENUE ADDRESS]
[VENUE CITY STATE]

REVERB will send a Confirmation Email two weeks before the show with additional details including meeting time and onsite coordinator contact information. If the show is less than two weeks away, you will receive the email shortly.

<strong>IMPORTANT: You will receive a confirmation link in that email, so please keep an eye out for it and make sure you respond!</strong>

In the meantime, follow our social media on Facebook @REVERB, or on Instagram and Twitter @reverb_org!

Thanks again, and welcome to the team!

Paige & REVERB',
                'event_type' => 'Acceptance',
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 2,
                'event_id' => null,
                'shift_id' => null,
                'subject' => 'REVERB + [ARTIST] Volunteer Application – Wait List',
                'body' => 'Hello [FIRST NAME],

Thank you for applying to volunteer with REVERB.

The following team has been filled; we are unable to offer you a place on at this time:

[ARTIST] - [TOUR]
[SHOW DATE]
[VENUE NAME]
[VENUE CITY STATE]

We know you\'d be a great addition to the team, so you have been placed on the wait list for this show. If we are able to add additional volunteers or have cancellations, we will let you know.

Paige & REVERB',
                'event_type' => 'Wait List',
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 3,
                'event_id' => null,
                'shift_id' => null,
                'subject' => 'REVERB + [ARTIST] Volunteer Application',
                'body' => 'Hello [FIRST NAME],

Thank you for applying to volunteer with REVERB. Unfortunately, we are not able to offer you a spot on the following volunteer team:

[ARTIST] - [TOUR]
[SHOW DATE]
[VENUE NAME]
[VENUE CITY STATE]

There are limited places on the team; we are not able to work with every interested volunteer.

Thanks again.

REVERB',
                'event_type' => 'Declined',
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 4,
                'event_id' => null,
                'shift_id' => null,
                'subject' => 'REVERB + [ARTIST] Volunteer Team: Event Information',
                'body' => '*** Please click this link: [CONFIRMATION LINK] to confirm or decline your spot on the volunteer team for the show listed below ***

       Hello [FIRST NAME],

Thank you again for volunteering with REVERB! Please read this email carefully. And don\'t forget to click the confirmation link above!

<strong>SHOW DETAILS</strong>
        [ARTIST] - [TOUR]
        [SHOW DATE]
        [VENUE NAME]
        [VENUE ADDRESS]
        [VENUE CITY STATE]

 <strong>ARRIVAL TIME</strong>
        [CHECK IN TIME]

 <strong>MEETING PLAN</strong>

 Onsite Coordinator:

        [CONTACT NAME]
        [CONTACT PHONE]

On the day of the show, the onsite coordinator will send an email with specific meeting instructions. Do not try to enter the venue or speak with venue staff about entering until connecting with the onsite coordinator.

Please don\'t reach out to the onsite coordinator prior to the day of the event. If you need to contact them on showday, text is best. Remember they are meeting many people at once - thanks for your patience!

Please note that all volunteers must arrive on time. Late arrivals cannot be accommodated and will forfeit their place on the volunteer team as well as their pass to the show.

<strong>PARKING</strong>
Volunteers are responsible for their own parking. Check public transport options, as well as the venue website - they usually have recommendations about where to park.

<strong>WHAT TO BRING AND WEAR</strong>
We will provide a volunteer t-shirt to wear while volunteering. Other than that, feel free to wear whatever you\'d like! Dress for the weather (sunscreen, rain gear, etc.). We recommend closed-toed, comfortable shoes.

Reusable water bottles are encouraged - we follow venue rules regarding what can be brought in to the show, so please check with the venue if unsure. Volunteers may store belongings in the REVERB tent, though we are not responsible for lost or stolen items.

Plan to have a snack or light meal before arriving - we prefer volunteers not eat in the Action Village. Volunteers may purchase venue food after their shift ends.

<strong>PASSES</strong>
The onsite coordinator will have work passes granting access to the venue to volunteer and to watch the headlining artist perform from the GA/Lawn section. If the venue is seated only, volunteers will be assigned a seat. We do not know where seats are located until the night of the show.

Volunteer shifts end just before the headlining act goes on stage.

<strong>VOLUNTEER TASKS</strong>
Volunteers go through orientation with the onsite coordinator including introductions to REVERB, any partnering nonprofits, and the Action Village activations. Volunteers are assigned to an activation from the time doors open until just before the headliner goes onstage:

[TOUR TASKS]

Please feel free to get in touch with us via <a href="mailto:volunteer@reverb.org">volunteer@reverb.org</a> with any questions! Our mission would not be possible without volunteers!

Thanks again, and HAVE FUN,

Paige & REVERB',
                'event_type' => 'Confirmation',
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 5,
                'event_id' => null,
                'shift_id' => null,
                'subject' => 'REVERB + [ARTIST] Volunteer Team: Event Reminder!',
                'body' => 'Hi Team!

Reminder that REVERB volunteers are meeting at the following time and location:

[ARTIST] – [TOUR]
[SHOW DATE] @ [CHECK IN TIME]

[VENUE NAME]
[VENUE ADDRESS]
[VENUE CITY STATE]

Your show day contact is:

[CONTACT NAME]
[CONTACT PHONE]

Thanks, and have fun!

P.S. We\'re counting on volunteers to be there. If you need to cancel please email <a href="mailto:volunteer@reverb.org">volunteer@reverb.org</a> with your name, the date of the show, and the name of the tour.',
                'event_type' => 'Reminder',
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 6,
                'event_id' => null,
                'shift_id' => null,
                'subject' => 'Thank you for Volunteering with REVERB + [ARTIST]!',
                'body' => 'Hello [FIRST NAME],

Thank you again for volunteering with REVERB at [ARTIST] - [TOUR]! We hope you met some great people, felt good about volunteering to encourage fans to take action for people and the planet, and saw an amazing show! We couldn\'t accomplish our mission without you, and we hope to see you again!

THANK YOU!

Paige & REVERB',
                'event_type' => 'Thank You',
                'created_at' => date("Y-m-d H:i:s"),
            ),
        );

        DB::table('email_templates')->insert($templates);

    }
}
