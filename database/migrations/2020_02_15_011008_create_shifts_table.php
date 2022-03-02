<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('event_id')->unsigned();
            $table->bigInteger('artist_id')->unsigned();
            $table->bigInteger('venue_id')->unsigned();
            $table->string('name');
            $table->date('start_date')->nullable();;
            $table->date('end_date')->nullable();
            $table->time('doors')->nullable();
            $table->time('check_in')->nullable();
            $table->decimal('hours_worked', 8, 2)->nullable();;
            $table->integer('volunteer_cap')->unsigned()->nullable();;
            $table->string('item')->default('bottle')->nullable();;
            $table->decimal('item_sold', 8, 2)->nullable();;
            $table->decimal('item_bof_free', 8, 2)->nullable();;
            $table->decimal('item_revenue_cash', 8, 2)->nullable();;
            $table->decimal('item_revenue_cc', 8, 2)->nullable();;
            $table->decimal('biod_gallons', 8, 2)->nullable();;
            $table->decimal('compost_gallons', 8, 2)->nullable();;
            $table->decimal('water_foh_gallons', 8, 2)->nullable();;
            $table->decimal('water_boh_gallons', 8, 2)->nullable();;
            $table->integer('farms_supported')->unsigned()->nullable();;
            $table->decimal('tickets_sold', 8, 2)->nullable();;
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('event_id')->references('id')->on('events')->onUpdate('cascade');
            $table->foreign('artist_id')->references('id')->on('artists')->onUpdate('cascade');
            $table->foreign('venue_id')->references('id')->on('venues')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shifts');
    }
}
