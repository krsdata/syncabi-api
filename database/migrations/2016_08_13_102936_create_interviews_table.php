<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('condidate_name');
            $table->string('interviewerID');
            $table->text('short_description');
            $table->string('criteriaID');
            $table->integer('interview_create_by');
            $table->string('interview_date');
            $table->string('interview_time');
            $table->text('comment');
            $table->string('rating_status');
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
        Schema::drop('interviews');
    }
}
