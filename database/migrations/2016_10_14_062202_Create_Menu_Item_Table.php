<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenuItemTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('menu_items')) {
            Schema::create('menu_items', function (Blueprint $table) {
                $table->increments('id');
                $table->string('menu_name', 255);
                $table->string('source',255);
                $table->integer('parent_menu')->default(0);
                $table->integer('menu_type')->default(0);
                $table->smallInteger('status')->default(1);
                $table->smallInteger('is_new_tab')->default(0);
                $table->smallInteger('is_spa')->default(0);
                $table->integer('ordering')->default(0);
                $table->integer('created_by');
                $table->integer('updated_by');
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

        if (Schema::hasTable('menu_items')) {
            Schema::drop('menu_items');
        }
    }
}
