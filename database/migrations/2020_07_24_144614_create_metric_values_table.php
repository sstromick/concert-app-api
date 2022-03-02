<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetricValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metric_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('metric_id')->unsigned();
            $table->bigInteger('metricable_id')->unsigned();
            $table->string('metricable_type');
            $table->decimal('value', 9, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['metric_id', 'metricable_id', 'metricable_type']);

            $table->foreign('metric_id')->references('id')->on('metrics')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metric_values');
    }
}
