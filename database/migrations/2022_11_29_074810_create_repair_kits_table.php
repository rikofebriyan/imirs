<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateRepairKitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_kits', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('master_spare_part_id');
            $table->string('item_code');
            $table->string('item_name');
            $table->string('description');
            $table->integer('maker');
            $table->integer('qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('repair_kits');
    }
}
