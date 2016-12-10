<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModuleManagerTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('module_positions')) {
            Schema::create('module_positions', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('module_id');
                $table->string('module_title', 255);
                $table->string('module_name', 255);
                $table->string('vendor',255);
                $table->string('layout',255);
                $table->text('params');
                $table->text('custom_html')->nullable();
                $table->text('pages');
                $table->string('position',255);
                $table->smallInteger('ordering')->default(0);
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

        if (Schema::hasTable('module_positions')) {
            Schema::drop('module_positions');
        }
    }
}
