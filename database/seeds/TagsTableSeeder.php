<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->delete();

        $tags = array(
            array(
                'id' => 1,
                'tagable_id' => 1,
                'tagable_type' => "App\Models\Contact",
                'content' => "test tag 1",
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 2,
                'tagable_id' => 1,
                'tagable_type' => "App\Models\Contact",
                'content' => "test tag 2",
                'created_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 3,
                'tagable_id' => 1,
                'tagable_type' => "App\Models\Event",
                'content' => "test tag 3",
                'created_at' => date("Y-m-d H:i:s"),
            ),
        );

        DB::table('tags')->insert($tags);
    }
}
