<?php

use Illuminate\Database\Seeder;

class GenericSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('generic_names')->insert([
        	'name' => 'Paracetamol',
        	'status' => '1',
        ]);
        DB::table('generic_names')->insert([
        	'name' => 'Omeprazole',
        	'status' => '1',
        ]);
    }
}
