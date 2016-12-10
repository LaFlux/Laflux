<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExtensionManagerTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('extension_manager')) {
            Schema::create('extension_manager', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->string('vendor', 255);
                $table->string('description', 255)->nullable();
                $table->string('version', 5);
                $table->smallInteger('is_paid')->default(0);
                $table->smallInteger('status')->default(1);
                $table->string('package_type', 50);
                $table->string('icon', 255)->nullable();
                $table->string('update_url', 255)->nullable();
                $table->string('author', 255)->nullable();
                $table->string('website', 255)->nullable();
                $table->string('contact_email', 255)->nullable();
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

        if (Schema::hasTable('extension_manager')) {
            Schema::drop('extension_manager');
        }
    }
}
