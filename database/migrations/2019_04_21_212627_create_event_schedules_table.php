<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('location_id')->unsigned();
            $table->bigInteger('event_id')->unsigned();
            $table->integer('lodging_id')->unsigned();
            $table->string('register_title')->nullable();
            $table->string('register_url', 255)->nullable();
            $table->string('mi_title')->nullable();
            $table->string('mi_url', 255)->nullable();
            $table->boolean('visible');
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
            
            
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('lodging_id')->references('id')->on('lodgings');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_schedules');
    }
}
