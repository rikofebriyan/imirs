<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateStandardPengecekansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standard_pengecekans', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('master_spare_part_id');
            $table->integer('item_pengecekan_id');
            $table->string('operation');
            $table->string('standard_pengecekan_min');
            $table->string('standard_pengecekan_max');
            $table->string('unit_measurement');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('standard_pengecekans');
    }
}
