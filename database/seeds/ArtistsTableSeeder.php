<?php

use Illuminate\Database\Seeder;

class ArtistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('artists')->delete();

        $artists = array(
            array(
                'id' => 1,
                'name' => 'Steve',
                'photo_url' => 'url',
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 2,
                'name' => 'Bob',
                'photo_url' => 'url',
                'created_at' => date("Y-m-d H:i:s"),
            ),
        );

        DB::table('artists')->insert($artists);
    }
}
