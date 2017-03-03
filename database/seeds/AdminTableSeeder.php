<?php
use Illuminate\Database\Seeder;
use Eloquent;
class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
 /*   public function run()
    {

        if (Schema::hasTable('admin'))
        {
            DB::table('admin')->insert([ 
                'email' => 'admin@admin.com',
                'password' => bcrypt('secret'),
            ]);
        } 

    }
*/
   public function run()
    {
        if (Schema::hasTable('admin'))
                {
                    DB::table('admin')->insert([
                    'email' => 'admin@admin.com',
                    'password' => bcrypt('secret'),
                ]);
                } 

    }

}
