<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('states')->delete();
      DB::table('countries')->delete();
      $countries = array(
array('id' => 1,'ISO2' => 'US','name' => 'United States','created_at' => date("Y-m-d H:i:s")),
array('id' => 2,'ISO2' => 'GB','name' => 'United Kingdom','created_at' => date("Y-m-d H:i:s")),
);
            DB::table('countries')->insert($countries);
      }
}
