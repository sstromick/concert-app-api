<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('event_id')->unsigned()->nullable();
            $table->bigInteger('email_template_id')->unsigned()->nullable();
            $table->bigInteger('non_profit_shift_id')->unsigned()->nullable();
            $table->bigInteger('volunteer_shift_id')->unsigned()->nullable();
            $table->string('email');
            $table->string('subject');
            $table->text('body');
            $table->boolean('delivered')->default(false);
            $table->text('error')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('email_template_id')->references('id')->on('email_templates')->onUpdate('cascade');
            $table->foreign('non_profit_shift_id')->references('id')->on('non_profit_shifts')->onUpdate('cascade');
            $table->foreign('volunteer_shift_id')->references('id')->on('volunteer_shifts')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails');
    }
}
