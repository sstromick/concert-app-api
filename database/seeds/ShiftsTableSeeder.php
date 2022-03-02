<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ShiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shift_schedules')->delete();
        DB::table('shifts')->delete();

        $shifts = array(
            array(
                'id' => 1,
                'event_id' => 1,
                'artist_id' => 1,
                'venue_id' => 1,
                'name' => 'Shift 1',
                'start_date' => Carbon::parse('2000-01-01'),
                'end_date' => Carbon::parse('2000-01-01'),
                'doors' => Carbon::now()->format('H:i:s'),
                'check_in' => Carbon::now()->format('H:i:s'),
                'hours_worked' => 8.5,
                'volunteer_cap' => 10,
                'item' => 'bottle',
                'item_sold' => 3.5,
                'item_bof_free' => 17,
                'item_revenue_cash' => 100,
                'item_revenue_cc' => 50.50,
                'biod_gallons' => 12.5,
                'compost_gallons' => 6.3,
                'water_foh_gallons' => 2.2,
                'water_boh_gallons' => 1.1,
                'farms_supported' => 5,
                'tickets_sold' => 10,
                'created_at' => date("Y-m-d H:i:s"),
            ),
        );

        DB::table('shifts')->insert($shifts);

        $schedules = array(
            array(
                'id' => 1,
                'shift_id' => 1,
                'start_date' => Carbon::parse('2000-01-01'),
                'end_date' => Carbon::parse('2000-01-01'),
                'doors' => Carbon::now()->format('H:i:s'),
                'check_in' => Carbon::now()->format('H:i:s'),
                'created_at' => date("Y-m-d H:i:s"),
            ),
        );

        DB::table('shift_schedules')->insert($schedules);
    }
}
