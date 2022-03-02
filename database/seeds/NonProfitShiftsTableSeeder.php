<?php

use Illuminate\Database\Seeder;

class NonProfitShiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('non_profit_shifts')->delete();

        $shifts = array(
            array(
                'id' => 1,
                'shift_id' => 1,
                'non_profit_id' => 1,
                'contact_name' => 'Same Smith',
                'email' => 'sstromick@gmail.com',
                'phone' => '5555555555',
                'item' => 'item name',
                'item_actions' => 100,
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 2,
                'shift_id' => 1,
                'non_profit_id' => 1,
                'contact_name' => 'Same Smith',
                'email' => 's.stromick@gmail.com',
                'phone' => '5555555555',
                'item' => 'item name',
                'item_actions' => 100,
                'created_at' => date("Y-m-d H:i:s"),
            ),
        );

        DB::table('non_profit_shifts')->insert($shifts);
    }
}
