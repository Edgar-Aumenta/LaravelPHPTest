<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageUpdateVersionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_update_version', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('version_code')->unique();
            $table->string('version_name');
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
        Schema::dropIfExists('package_update_version');
    }
}
