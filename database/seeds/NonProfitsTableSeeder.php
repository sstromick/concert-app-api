<?php

use Illuminate\Database\Seeder;

class NonProfitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('non_profits')->delete();

        $non_profits = array(
            array(
                'id' => 1,
                'state_id' => 1,
                'country_id' => 1,
                'name' => 'sam smith',
                'address_line_1' => 'addr 1',
                'address_line_2' => 'addr 2',
                'city' => 'Brunswick',
                'postal_code' => '04011',
                'country_text' => 'United States',
                'state_text' => 'ME',
                'website' => 'http://google.com',
                'created_at' => date("Y-m-d H:i:s"),
            ),
        );

        DB::table('non_profits')->insert($non_profits);
    }
}
