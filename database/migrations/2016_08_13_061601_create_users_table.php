<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) 
        {
            $table->increments('userID');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('password');
            $table->string('temp_password');
            $table->string('deviceID');
            $table->text('device_token');
            $table->text('remember_token');
            $table->tinyInteger('status')->default(0);
            $table->integer('positionID')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
