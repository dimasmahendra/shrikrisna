<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerMeasurementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_measurement', function (Blueprint $table) {
            $table->id();
            $table->integer('id_measurement');
            $table->integer('id_master_category_details');
            $table->string('value')->nullable();
            $table->string('option')->nullable();
            $table->timestamps();

            $table->foreign('id_measurement')->references('id')->on('measurement');
            $table->foreign('id_master_category_details')->references('id')->on('master_category_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_measurement');
    }
}