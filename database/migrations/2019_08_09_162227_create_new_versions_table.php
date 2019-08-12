<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_versions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('version_code')->unique();
            $table->string('version_name');
            $table->string('version_url', 255)->nullable();
            $table->boolean('current_version')->default(false);
            $table->timestamp('release_date');
            $table->integer('estimate_size');
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();

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
        Schema::dropIfExists('new_versions');
    }
}
