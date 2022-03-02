<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveNameTitleEmailPhoneFromContacts extends Migration {
    public function up() {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('title');
            $table->dropColumn('email');
            $table->dropColumn('phone');
        });
    }

    public function down() {
        Schema::table('contacts', function (Blueprint $table) {
            //
        });
    }
}
