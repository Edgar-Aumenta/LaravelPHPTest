<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsNewVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_versions', function (Blueprint $table) {
            $table->string('readme_url', 255)->nullable();
            $table->string('update_guide_url', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('new_versions', function (Blueprint $table) {
            $table->dropColumn([
                'readme_url',
                'update_guide_url'
            ]);
        });
    }
}
