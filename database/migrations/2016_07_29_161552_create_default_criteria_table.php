<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaultCriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_criteria', function (Blueprint $table) {
            $table->increments('id');
            $table->text('criteria_name');
            $table->string('criteria_rating_value_1');
            $table->string('criteria_rating_value_2');
            $table->string('criteria_rating_value_3');
            $table->string('criteria_rating_value_4');
            $table->string('criteria_rating_value_5');
            $table->string('criteria_rating');
            $table->softDeletes();
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
        Schema::drop('default_criteria');
    }
}
