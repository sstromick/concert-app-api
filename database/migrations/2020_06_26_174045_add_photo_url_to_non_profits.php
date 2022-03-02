<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhotoUrlToNonProfits extends Migration {
    public function up() {
        Schema::table('non_profits', function (Blueprint $table) {
            $table->string('photo_url')->nullable();
        });
    }

    public function down() {
        Schema::table('non_profits', function (Blueprint $table) {
            //
        });
    }
}
