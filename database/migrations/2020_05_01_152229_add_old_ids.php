<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOldIds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->integer('old_id')->unsigned()->nullable();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->integer('old_id')->unsigned()->nullable();
        });

        Schema::table('non_profits', function (Blueprint $table) {
            $table->integer('old_id')->unsigned()->nullable();
        });

        Schema::table('shifts', function (Blueprint $table) {
            $table->integer('old_id')->unsigned()->nullable();
        });

        Schema::table('venues', function (Blueprint $table) {
            $table->integer('old_id')->unsigned()->nullable();
        });

        Schema::table('volunteer_shifts', function (Blueprint $table) {
            $table->integer('old_id')->unsigned()->nullable();
        });

        Schema::table('volunteers', function (Blueprint $table) {
            $table->integer('old_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn('old_id');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('old_id');
        });

        Schema::table('non_profits', function (Blueprint $table) {
            $table->dropColumn('old_id');
        });

        Schema::table('shifts', function (Blueprint $table) {
            $table->dropColumn('old_id');
        });

        Schema::table('venues', function (Blueprint $table) {
            $table->dropColumn('old_id');
        });

        Schema::table('volunteer_shifts', function (Blueprint $table) {
            $table->dropColumn('old_id');
        });

        Schema::table('volunteers', function (Blueprint $table) {
            $table->dropColumn('old_id');
        });
    }
}
