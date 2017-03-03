<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorporateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporate_profiles', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('company_name');
            $table->integer('userID');
            $table->string('user_email');
            $table->integer('companyID');
            $table->string('company_url');
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
        Schema::drop('corporate_profiles');
    }
}
