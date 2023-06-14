<?php

use Illuminate\Database\Seeder;

class CatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
        	'name' => 'Tablet',
        	'status' => '1',
        ]);
        DB::table('categories')->insert([
        	'name' => 'Capsule',
        	'status' => '1',
        ]);
        DB::table('categories')->insert([
        	'name' => 'Syrup',
        	'status' => '1',
        ]);
        DB::table('categories')->insert([
        	'name' => 'Drop',
        	'status' => '1',
        ]);
        DB::table('categories')->insert([
        	'name' => 'Injection',
        	'status' => '1',
        ]);
        DB::table('categories')->insert([
        	'name' => 'Saline',
        	'status' => '1',
        ]);
        DB::table('categories')->insert([
        	'name' => 'Suppository',
        	'status' => '1',
        ]);
    }
}
