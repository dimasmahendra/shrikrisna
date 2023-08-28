<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeasurementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurement', function (Blueprint $table) {
            $table->id();
            $table->integer('id_customer');
            $table->integer('id_master_category');
            $table->date('measurement_date');
            $table->integer('status');
            $table->timestamps();

            $table->foreign('id_customer')->references('id')->on('customer');
            $table->foreign('id_master_category')->references('id')->on('master_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('measurement');
    }
}
