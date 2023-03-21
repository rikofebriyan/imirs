<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateMasterSparePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_spare_parts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('item_code');
            $table->string('item_name');
            $table->string('description');
            $table->integer('qty');
            $table->integer('price');
            $table->string('status');
            $table->string('wh_code');
            $table->string('rack_code');
            $table->integer('order_point');
            $table->integer('order_qty');
            $table->integer('account_no');
            $table->string('code_item_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('master_spare_parts');
    }
}
