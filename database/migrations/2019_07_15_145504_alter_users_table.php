<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'first_name');
            $table->string('last_name')->nullable();
            $table->string('username');
            $table->string('website')->nullable();
            $table->boolean('send_notifications')->default(true);
            $table->string('url_image')->nullable();
            $table->string('url_image_thumbnail')->nullable();
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('zip');
            $table->string('country');
            $table->string('day_phone');
            $table->boolean('tos')->default(false);
            $table->string('company');
            $table->boolean('enable')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('first_name', 'name');
            $table->dropColumn(['last_name',
                                'username',
                                'website',
                                'send_notifications',
                                'url_image',
                                'url_image_thumbnail',
                                'address_1',
                                'address_2',
                                'city',
                                'state',
                                'zip',
                                'country',
                                'day_phone',
                                'tos',
                                'company',
                                'enable']);
        });
    }
}
