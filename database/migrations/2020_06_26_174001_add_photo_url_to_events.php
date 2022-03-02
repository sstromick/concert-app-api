<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhotoUrlToEvents extends Migration {
    public function up() {
        Schema::table('events', function (Blueprint $table) {
            $table->string('photo_url')->nullable();
        });
    }

    public function down() {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
}
