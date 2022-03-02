<?php

use Illuminate\Database\Seeder;

class EmailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('emails')->delete();
/*
        $emails = array(
            array(
                'id' => 1,
                'event_id' => 1,
                'email_template_id' => 1,
                'non_profit_shift_id' => 1,
                'volunteer_shift_id' => 1,
                'email' => 'email',
                'subject' => 'email subject',
                'body' => 'email body',
                'delivered' => true,
                'error' => 'no error',
                'created_at' => date("Y-m-d H:i:s"),
            ),
        );

        DB::table('emails')->insert($emails);
        */
    }
}
