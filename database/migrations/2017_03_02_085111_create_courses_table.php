<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('course_name');
            $table->string('course_code');
            $table->string('course_type');
            $table->string('course_meeting_days');
            $table->string('course_meeting_time');
            $table->string('course_textbook');
            $table->text('course_description');
            $table->integer('student_id')->unsigned();
            $table->integer('professior_id')->unsigned();
            $table->foreign('professior_id')->references('id')->on('users');
            $table->foreign('student_id')->references('id')->on('users');
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
        Schema::drop('courses');
    }
}
