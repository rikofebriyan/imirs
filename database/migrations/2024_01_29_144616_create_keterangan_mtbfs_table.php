<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeteranganMtbfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keterangan_mtbfs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('form_input_id')->nullable();
            $table->string('jenis_penggantian')->nullable();
            $table->string('mau_rekondisi')->nullable();
            $table->string('recondition_sheet')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keterangan_mtbfs');
    }
}
