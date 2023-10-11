<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorageFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_measurement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_customer');
            $table->integer('id_measurement')->nullable();
            $table->text('path');
            $table->smallInteger('order')->nullable();
            $table->smallinteger('status');
            $table->timestamps();

            $table->foreign('id_customer')->references('id')->on('customer');
            $table->foreign('id_measurement')->references('id')->on('measurement');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_measurement');
    }
}
