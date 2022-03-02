<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    public function run()
    {
      DB::table('states')->delete();
  $states = array(
                array('id' => 1, 'name' => 'Alabama', 'abbreviation' => 'AL', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 2, 'name' => 'Alaska', 'abbreviation' => 'AK', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 3, 'name' => 'Arizona', 'abbreviation' => 'AZ', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 4, 'name' => 'Arkansas', 'abbreviation' => 'AR', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 5, 'name' => 'California', 'abbreviation' => 'CA', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 6, 'name' => 'Colorado', 'abbreviation' => 'CO', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 7, 'name' => 'Connecticut', 'abbreviation' => 'CT', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 8, 'name' => 'Delaware', 'abbreviation' => 'DE', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 9, 'name' => 'District of Columbia', 'abbreviation' => 'DC', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 10, 'name' => 'Florida', 'abbreviation' => 'FL', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 11, 'name' => 'Georgia', 'abbreviation' => 'GA', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 12, 'name' => 'Hawaii', 'abbreviation' => 'HI', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 13, 'name' => 'Idaho', 'abbreviation' => 'ID', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 14, 'name' => 'Illinois', 'abbreviation' => 'IL', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 15, 'name' => 'Indiana', 'abbreviation' => 'IN', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 16, 'name' => 'Iowa', 'abbreviation' => 'IA', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 17, 'name' => 'Kansas', 'abbreviation' => 'KS', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 18, 'name' => 'Kentucky', 'abbreviation' => 'KY', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 19, 'name' => 'Louisiana', 'abbreviation' => 'LA', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 20, 'name' => 'Maine', 'abbreviation' => 'ME', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 21, 'name' => 'Maryland', 'abbreviation' => 'MD', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 22, 'name' => 'Massachusetts', 'abbreviation' => 'MA', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 23, 'name' => 'Michigan', 'abbreviation' => 'MI', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 24, 'name' => 'Minnesota', 'abbreviation' => 'MN', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 25, 'name' => 'Mississippi', 'abbreviation' => 'MS', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 26, 'name' => 'Missouri', 'abbreviation' => 'MO', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 27, 'name' => 'Montana', 'abbreviation' => 'MT', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 28, 'name' => 'Nebraska', 'abbreviation' => 'NE', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 29, 'name' => 'Nevada', 'abbreviation' => 'NV', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 30, 'name' => 'New Hampshire', 'abbreviation' => 'NH', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 31, 'name' => 'New Jersey', 'abbreviation' => 'NJ', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 32, 'name' => 'New Mexico', 'abbreviation' => 'NM', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 33, 'name' => 'New York', 'abbreviation' => 'NY', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 34, 'name' => 'North Carolina', 'abbreviation' => 'NC', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 35, 'name' => 'North Dakota', 'abbreviation' => 'ND', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 36, 'name' => 'Ohio', 'abbreviation' => 'OH', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 37, 'name' => 'Oklahoma', 'abbreviation' => 'OK', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 38, 'name' => 'Oregon', 'abbreviation' => 'OR', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 39, 'name' => 'Pennsylvania', 'abbreviation' => 'PA', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 40, 'name' => 'Rhode Island', 'abbreviation' => 'RI', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 41, 'name' => 'South Carolina', 'abbreviation' => 'SC', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 42, 'name' => 'South Dakota', 'abbreviation' => 'SD', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 43, 'name' => 'Tennessee', 'abbreviation' => 'TN', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 44, 'name' => 'Texas', 'abbreviation' => 'TX', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 45, 'name' => 'Utah', 'abbreviation' => 'UT', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 46, 'name' => 'Vermont', 'abbreviation' => 'VT', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 47, 'name' => 'Virginia', 'abbreviation' => 'VA', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 48, 'name' => 'Washington', 'abbreviation' => 'WA', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 49, 'name' => 'West Virginia', 'abbreviation' => 'WV', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 50, 'name' => 'Wisconsin', 'abbreviation' => 'WI', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s")),
                array('id' => 51, 'name' => 'Wyoming', 'abbreviation' => 'WY', 'country_id' => 1,'created_at' => date("Y-m-d H:i:s"))
  );
            DB::table('states')->insert($states);
      }
}
