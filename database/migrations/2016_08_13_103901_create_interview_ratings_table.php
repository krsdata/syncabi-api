<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interview_ratings', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('condidateID')->unsigned();;
            $table->integer('interviewerID')->unsigned();
            $table->string('interview_criteriaID');
            $table->string('rating_value');
            $table->decimal('rating', 10, 1);
            $table->string('rating_status');
            $table->text('comment');
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
        Schema::drop('interview_ratings');
    }
}
