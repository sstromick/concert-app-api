<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteer_shifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shift_id')->unsigned();
            $table->bigInteger('volunteer_id')->unsigned();
            $table->boolean('attended')->default(false);
            $table->boolean('waitlist')->default(false);
            $table->boolean('accepted')->default(false);
            $table->dateTime('accepted_at')->nullable();
            $table->boolean('declined')->default(false);
            $table->dateTime('declined_at')->nullable();
            $table->boolean('confirmed')->default(false);
            $table->dateTime('confirmed_at')->nullable();
            $table->boolean('pending')->default(true);
            $table->string('roll_call')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('shift_id')->references('id')->on('shifts')->onUpdate('cascade');
            $table->foreign('volunteer_id')->references('id')->on('volunteers')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volunteer_shifts');
    }
}
