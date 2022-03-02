<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('event_id')->unsigned()->nullable();
            $table->bigInteger('shift_id')->unsigned()->nullable();
            $table->string('subject');
            $table->text('body');
            $table->string('event_type');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('event_id')->references('id')->on('events')->onUpdate('cascade');
            $table->foreign('shift_id')->references('id')->on('shifts')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_templates');
    }
}
