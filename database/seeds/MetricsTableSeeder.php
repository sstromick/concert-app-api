<?php

use Illuminate\Database\Seeder;

class MetricsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('metrics')->delete();
        $metrics = array(
            array(
                'id' => 1,
                'metric_type' => 'shift',
                'name' => 'Attendance (approximate)',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 2,
                'metric_type' => 'shift',
                'name' => 'CO2 (Artist) tons',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 3,
                'metric_type' => 'shift',
                'name' => 'CO2 (Fan) tons',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 4,
                'metric_type' => 'shift',
                'name' => 'Gals of BioD',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 5,
                'metric_type' => 'shift',
                'name' => 'Compost lbs',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 6,
                'metric_type' => 'shift',
                'name' => 'Gals Recycled',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 7,
                'metric_type' => 'shift',
                'name' => 'NALGENE Bottles Distributed',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 8,
                'metric_type' => 'shift',
                'name' => 'Water Gallons Distributed',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 9,
                'metric_type' => 'shift',
                'name' => 'Bottles Avoided at Events',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 10,
                'metric_type' => 'shift',
                'name' => 'Groups',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 11,
                'metric_type' => 'shift',
                'name' => 'Volunteers Confirmed',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 12,
                'metric_type' => 'shift',
                'name' => 'Volunteers Onsite',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 13,
                'metric_type' => 'shift',
                'name' => 'Volunteer Hours',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 14,
                'metric_type' => 'shift',
                'name' => 'Onsite Fan Actions',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 15,
                'metric_type' => 'shift',
                'name' => 'Online Fan Actions',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 16,
                'metric_type' => 'shift',
                'name' => '$ Raised (total fan donations)',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 17,
                'metric_type' => 'shift',
                'name' => '$ Raised Online (total fan donations)',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 18,
                'metric_type' => 'shift',
                'name' => '$ We Donated to Other Groups',
                'created_at' => date("Y-m-d H:i:s")
            ),
            array(
                'id' => 19,
                'metric_type' => 'shift',
                'name' => '# Farms Supported',
                'created_at' => date("Y-m-d H:i:s")
            ),
        );

        DB::table('metrics')->insert($metrics);
    }
}
