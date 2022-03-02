<?php

use Illuminate\Database\Seeder;

class VolunteerShiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('volunteer_shifts')->delete();

        $shifts = array(
            array(
                'id' => 1,
                'shift_id' => 1,
                'volunteer_id' => 1,
                'accepted' => false,
                'created_at' => date("Y-m-d H:i:s"),
            ),
        );

        DB::table('volunteer_shifts')->insert($shifts);
    }
}
