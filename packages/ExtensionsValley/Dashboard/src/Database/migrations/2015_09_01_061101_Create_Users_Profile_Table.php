<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersProfileTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_profile')) {
            Schema::create('user_profile', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unique();
                $table->string('first_name', 255);
                $table->string('last_name', 255);
                $table->text('address', 255);
                $table->text('street', 255);
                $table->string('media')->nullable();
                $table->string('city', 255);
                $table->string('state', 255);
                $table->string('zip');
                $table->string('mobile');
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

        if (Schema::hasTable('user_profile')) {
            Schema::drop('user_profile');
        }
    }
}
