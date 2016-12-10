<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('gen_settings')) {
            Schema::create('gen_settings', function (Blueprint $table) {
                $table->increments('id');
                $table->string('settings_key', 255)->unique();
                $table->string('settings_value', 255);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        if (Schema::hasTable('gen_settings')) {
            Schema::drop('gen_settings');
        }
    }
}
