<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateProgressrepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progressrepairs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('form_input_id')->nullable();
            $table->string('place_of_repair')->nullable();
            $table->text('analisa')->nullable();
            $table->text('action')->nullable();
            $table->string('pic_repair')->nullable();
            $table->dateTime('plan_start_repair')->nullable();
            $table->dateTime('plan_finish_repair')->nullable();
            $table->dateTime('actual_start_repair')->nullable();
            $table->dateTime('actual_finish_repair')->nullable();
            $table->float('total_time_repair')->nullable();
            $table->integer('labour_cost')->nullable();
            $table->string('subcont_name')->nullable();
            $table->string('judgement')->nullable();
            $table->string('quotation')->nullable();
            $table->integer('subcont_cost')->nullable();
            $table->integer('lead_time')->nullable();
            $table->string('time_period')->nullable();
            $table->string('nomor_pp')->nullable();
            $table->string('reason_revision')->nullable();
            $table->dateTime('plan_start_revision')->nullable();
            $table->dateTime('plan_finish_revision')->nullable();
            $table->dateTime('notified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('progressrepairs');
    }
}
