<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateProgresstrialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progresstrials', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('item_check_id')->nullable();
            $table->integer('form_input_id')->nullable();
            $table->integer('standard_pengecekan_id')->nullable();
            $table->string('operation')->nullable();
            $table->string('standard_pengecekan_min')->nullable();
            $table->string('standard_pengecekan_max')->nullable();
            $table->string('unit_measurement')->nullable();
            $table->string('actual_pengecekan')->nullable();
            $table->string('judgement')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('progresstrials');
    }
}
