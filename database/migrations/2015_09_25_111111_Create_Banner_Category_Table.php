<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBannerCategoryTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('banner_category')) {
            Schema::create('banner_category', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 200)->unique();
                $table->text('description');
                $table->smallInteger('status')->default(1);
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

        if (Schema::hasTable('banner_category')) {
            Schema::drop('banner_category');
        }
    }
}
