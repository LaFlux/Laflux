<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenuTypeTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('menu_types')) {
            Schema::create('menu_types', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title', 255)->unique();
                $table->string('position',255);
                $table->smallInteger('status')->default(1);
                $table->smallInteger('is_all_page')->default(0);
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

        if (Schema::hasTable('menu_types')) {
            Schema::drop('menu_types');
        }
    }
}
