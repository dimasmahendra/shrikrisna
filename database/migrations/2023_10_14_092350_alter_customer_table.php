<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer', function($table)
        {
            $table->string('nomor_ktp')->nullable()->change();
            $table->string('phone_number')->nullable()->change();
            $table->string('institution')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('notes')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->string('nomor_ktp')->nullable(false)->change();
            $table->string('phone_number')->nullable(false)->change();
            $table->string('institution')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
            $table->string('notes')->nullable(false)->change();
        });
    }
}
