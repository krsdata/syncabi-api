<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasTable('users'))
		{
		    DB::table('users')->insert([
	            'name' => 'admin',
	            'email' => 'admin@admin.com',
	            'password' => bcrypt('secret'),
        	]);
		} 
         
    }
}
