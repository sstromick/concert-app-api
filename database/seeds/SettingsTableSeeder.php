<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $settings = array(
                array('id' => 1, 'name' => "confirmation-url", 'value' => "http://reverb-wp.hopsie.org/confirmation", 'created_at' => date("Y-m-d H:i:s")),
                array('id' => 2, 'name' => "thank-you-url", 'value' => "http://reverb-wp.hopsie.org/thank-you/", 'created_at' => date("Y-m-d H:i:s")),
  );
            DB::table('settings')->insert($settings);
    }
}
