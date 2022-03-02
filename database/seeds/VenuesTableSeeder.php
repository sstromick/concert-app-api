<?php

use Illuminate\Database\Seeder;

class VenuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->delete();
        DB::table('venues')->delete();

        $venues = array(
            array(
                'id' => 1,
                'state_id' => 1,
                'country_id' => 1,
                'name' => 'test venue',
                'address_1' => 'addr 1',
                'address_2' => 'addr 2',
                'city' => 'Brunswick',
                'postal_code' => '04011',
                'country_text' => 'United States',
                'state_text' => 'Maine',
                'website' => 'http://google.com',
                'phone' => '8037603232',
                'capacity' => 100,
                'compost' => false,
                'recycling_foh' => false,
                'recycling_single_stream_foh' => false,
                'recycling_sorted_foh' => false,
                'recycling_boh' => false,
                'recycling_single_stream_boh' => false,
                'recycling_sorted_boh' => false,
                'water_station' => false,
                'village_location' => 'lorem ipsum',
                'water_source' => 'lorem ipsum',
                'time_zone' => 'Eastern',
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 2,
                'state_id' => 1,
                'country_id' => 1,
                'name' => 'test venue2',
                'address_1' => 'addr 1',
                'address_2' => 'addr 2',
                'city' => 'Brunswick',
                'postal_code' => '04011',
                'country_text' => 'United States',
                'state_text' => 'Maine',
                'website' => 'http://google.com',
                'phone' => '8037603232',
                'capacity' => 100,
                'compost' => false,
                'recycling_foh' => false,
                'recycling_single_stream_foh' => false,
                'recycling_sorted_foh' => false,
                'recycling_boh' => false,
                'recycling_single_stream_boh' => false,
                'recycling_sorted_boh' => false,
                'water_station' => false,
                'village_location' => 'lorem ipsum',
                'water_source' => 'lorem ipsum',
                'time_zone' => 'Eastern',
                'created_at' => date("Y-m-d H:i:s"),
            ),
        );

        DB::table('venues')->insert($venues);

        $contacts = array(
            array(
                'id' => 1,
                'venue_id' => 1,
                'non_profit_id' => 1,
                'name' => 'test contact',
                'title' => 'addr 1',
                'email' => 'sstromick@gmail.com',
                'phone' => '8037603232',
                'created_at' => date("Y-m-d H:i:s"),
            ),
        );

        DB::table('contacts')->insert($contacts);
    }
}
