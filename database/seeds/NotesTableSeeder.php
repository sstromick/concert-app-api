<?php

use Illuminate\Database\Seeder;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('notes')->delete();
      $notes = array(
                array('id' => 1, 'user_id' => 1, 'noteable_id' => 1, 'noteable_type' => 'App\Models\Event', 'content' => 'test content', 'created_at' => date("Y-m-d H:i:s")),
  );
            DB::table('notes')->insert($notes);
    }
}
