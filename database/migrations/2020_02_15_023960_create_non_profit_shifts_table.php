<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonProfitShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_profit_shifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shift_id')->unsigned();
            $table->bigInteger('non_profit_id')->unsigned();
            $table->string('contact_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('item')->nullable();
            $table->decimal('item_actions', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('shift_id')->references('id')->on('shifts')->onUpdate('cascade');
            $table->foreign('non_profit_id')->references('id')->on('non_profits')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('non_profit_shifts');
    }
}
