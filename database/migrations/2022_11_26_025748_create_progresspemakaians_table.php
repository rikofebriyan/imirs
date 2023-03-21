<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateProgresspemakaiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progresspemakaians', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('form_input_id');
            $table->string('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->string('description')->nullable();
            $table->string('maker')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('price')->nullable();
            $table->string('total_price')->nullable();
            $table->string('status_part')->nullable();
            $table->string('quotation')->nullable();
            $table->string('nomor_pp')->nullable();
            $table->string('nomor_po')->nullable();
            $table->dateTime('estimasi_kedatangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('progresspemakaians');
    }
}
