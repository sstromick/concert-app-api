<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('artist_id')->unsigned();
            $table->bigInteger('venue_id')->unsigned();
            $table->string('name');
            $table->boolean('passive')->default(false);
            $table->boolean('teams')->default(false);
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->decimal('CO2_artist_tonnes', 8, 2)->nullable();
            $table->decimal('CO2_fans_tonnes', 8, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('venue_id')->references('id')->on('venues')->onUpdate('cascade');
            $table->foreign('artist_id')->references('id')->on('artists')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
