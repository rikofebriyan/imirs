<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateCodePartRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('code_part_repairs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('category');
            $table->integer('number');
            $table->string('code_part_repair');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('code_part_repairs');
    }
}
