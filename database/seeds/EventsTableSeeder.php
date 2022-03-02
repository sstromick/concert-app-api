<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->delete();

        $events = array(
            array(
                'id' => 1,
                'artist_id' => 1,
                'venue_id' => 1,
                'name' => 'Event 1',
                'passive' => false,
                'teams' => false,
                'contact_name' => 'Steve Stromick',
                'contact_email' => 'sstromick@gmail.com',
                'contact_phone' => '5555555555',
                'CO2_artist_tonnes' => 100.5,
                'CO2_fans_tonnes' => 44.50,
                'start_date' => Carbon::parse('2020-01-01'),
                'end_date' => Carbon::parse('2020-12-01'),
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 2,
                'artist_id' => 2,
                'venue_id' => 2,
                'name' => 'Event 2',
                'passive' => false,
                'teams' => false,
                'contact_name' => 'Jim Smith',
                'contact_email' => 'jim@gmail.com',
                'contact_phone' => '5555555555',
                'CO2_artist_tonnes' => 100.5,
                'CO2_fans_tonnes' => 44.50,
                'start_date' => Carbon::parse('2020-01-01'),
                'end_date' => Carbon::parse('2020-01-10'),
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 3,
                'artist_id' => 1,
                'venue_id' => 1,
                'name' => 'Event 3',
                'passive' => false,
                'teams' => false,
                'contact_name' => 'Bill Wilson',
                'contact_email' => 'bill@gmail.com',
                'contact_phone' => '5555555555',
                'CO2_artist_tonnes' => 100.5,
                'CO2_fans_tonnes' => 44.50,
                'start_date' => Carbon::parse('2020-01-01'),
                'end_date' => Carbon::parse('2020-04-01'),
                'created_at' => date("Y-m-d H:i:s"),
            ),
        );

        DB::table('events')->insert($events);
    }
}
