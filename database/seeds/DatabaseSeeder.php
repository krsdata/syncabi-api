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
	            'first_name' => 'admin',
	            'email' => 'admin@admin.com',
	            'password' => bcrypt('123456'),
        	]);
		}

        if (Schema::hasTable('admin'))
        {
            DB::table('admin')->insert([ 
                'email' => 'admin@admin.com',
                'password' => bcrypt('123456'),
            ]);
        } 

         
    }
}
