<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('course_name')->nullable();
            $table->string('course_code')->nullable();
            $table->integer('professior_id')->unsigned()->nullable();
            $table->integer('student_id')->unsigned()->nullable();
            $table->foreign('professior_id')->references('id')->on('users')->nullable();
            $table->foreign('student_id')->references('id')->on('users')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::drop('student_courses');
    }
}
