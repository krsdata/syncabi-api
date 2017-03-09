<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessorProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professor_profiles', function (Blueprint $table) {
            $table->increments('id');
             $table->string('office_hours');
            $table->string('location');
            $table->text('email');
            $table->integer('professior_id')->unsigned();
            $table->foreign('professior_id')->references('id')->on('users');
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
        Schema::drop('professor_profiles');
    }
}
