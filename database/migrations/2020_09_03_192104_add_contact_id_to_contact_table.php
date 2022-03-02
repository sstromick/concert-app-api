<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactIdToContactTable extends Migration {
    public function up() {
        Schema::table('contacts', function (Blueprint $table) {
            $table->bigInteger('contact_master_id')->unsigned();
            $table->foreign('contact_master_id')->references('id')->on('contact_masters');
        });
    }

    public function down() {
        Schema::table('contacts', function (Blueprint $table) {
            //
        });
    }
}
