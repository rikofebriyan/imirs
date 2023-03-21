<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateFinishrepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finishrepairs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('form_input_id');
            $table->integer('progressrepair_id');
            $table->string('f_reg_sp');
            $table->dateTime('f_date');
            $table->string('f_item_name');
            $table->string('f_item_type');
            $table->string('f_maker');
            $table->string('f_price');
            $table->string('f_nama_pic');
            $table->string('f_place_of_repair');
            $table->text('f_analisa');
            $table->text('f_action');
            $table->integer('f_subcont_cost');
            $table->integer('f_labour_cost');
            $table->integer('f_seal_kit_cost');
            $table->integer('f_total_cost_repair');
            $table->integer('f_total_cost_saving');

            $table->string('code_part_repair');
            $table->dateTime('delivery_date');
            $table->string('pic_delivery');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('finishrepairs');
    }
}
