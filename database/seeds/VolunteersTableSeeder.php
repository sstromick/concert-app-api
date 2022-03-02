<?php

use Illuminate\Database\Seeder;

class VolunteersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('volunteers')->delete();

        $volunteers = array(
            array(
                'id' => 1,
                'state_id' => 1,
                'country_id' => 1,
                'first_name' => 'sam',
                'last_name' => 'smith',
                'address_line_1' => 'addr 1',
                'address_line_2' => 'addr 2',
                'city' => 'Brunswick',
                'postal_code' => '04011',
                'country_text' => 'United States',
                'state_text' => 'ME',
                'email' => 'sstromick@gmail.com',
                'phone' => '4444444444',
                'gender' => 'male',
                'tshirt_size' => 'large',
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 2,
                'state_id' => 1,
                'country_id' => 1,
                'first_name' => 'sam',
                'last_name' => 'smith',
                'address_line_1' => 'addr 1',
                'address_line_2' => 'addr 2',
                'city' => 'Brunswick',
                'postal_code' => '04011',
                'country_text' => 'United States',
                'state_text' => 'ME',
                'email' => 's.stromick@gmail.com',
                'phone' => '4444444444',
                'gender' => 'male',
                'tshirt_size' => 'large',
                'created_at' => date("Y-m-d H:i:s"),
            ),
        );

        DB::table('volunteers')->insert($volunteers);
    }
}
