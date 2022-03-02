<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $users = array(
            array('id' => 1,'first_name' => 'Steve','last_name' => 'Stromick','email' => 'sstromick@gmail.com','password' => 'password','active' => false,'created_at' => date("Y-m-d H:i:s")),
        );
        DB::table('users')->insert($users);
    }
}
