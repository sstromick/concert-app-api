<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('state_id')->unsigned();
            $table->bigInteger('country_id')->unsigned();
            $table->string('name');
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country_text')->nullable();
            $table->string('state_text')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->integer('capacity')->unsigned()->default(0);
            $table->boolean('compost')->default(false);
            $table->boolean('recycling_foh')->default(false);
            $table->boolean('recycling_single_stream_foh')->default(false);
            $table->boolean('recycling_sorted_foh')->default(false);
            $table->boolean('recycling_boh')->default(false);
            $table->boolean('recycling_single_stream_boh')->default(false);
            $table->boolean('recycling_sorted_boh')->default(false);
            $table->boolean('water_station')->default(false);
            $table->text('village_location')->nullable();
            $table->text('water_source')->nullable();
            $table->string('time_zone')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venues');
    }
}
