<?php

use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('medicine_groups')->insert([
        	'name' => 'Allopathy',
        	'status' => '1',
        ]);
        DB::table('medicine_groups')->insert([
        	'name' => 'Homeopathy',
        	'status' => '1',
        ]);
    }
}
