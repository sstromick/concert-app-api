<?php

use Illuminate\Database\Seeder;

class ApiKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $keys = array(
            array(
                'id' => 1,
                'api_key' => '5DhDchmozV5FWaXId6Z2',
                'created_at' => date("Y-m-d H:i:s"),
            ),
        );

        DB::table('api_keys')->insert($keys);
    }
}
