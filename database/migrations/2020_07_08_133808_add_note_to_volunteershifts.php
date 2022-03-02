<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoteToVolunteershifts extends Migration
{
    public function up()
    {
        Schema::table('volunteer_shifts', function (Blueprint $table) {
            $table->text('note')->nullable();
        });
    }

    public function down() {
        Schema::table('volunteer_shifts', function (Blueprint $table) {
            $table->dropColumn(['note']);
        });
    }
}
