<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterCategoryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_category_details', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('id_master_category')->index();
            $table->smallInteger('order');
            $table->string('description');
            $table->integer('total_rows');
            $table->smallInteger('is_temporary');
            $table->enum("status", ["active", "nonactive"])->default("active");
            $table->timestamps();

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
        Schema::dropIfExists('master_category_details');
    }
}
