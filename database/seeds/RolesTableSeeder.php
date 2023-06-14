<?php

use Illuminate\Database\Seeder;
use  Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_roles')->insert([
        	'name' => 'Super Admin',
        	'slug' => 'superadmin',
        ]);
        DB::table('users_roles')->insert([
        	'name' => 'Admin',
        	'slug' => 'admin',
        ]);
        DB::table('users_roles')->insert([
        	'name' => 'Stuff',
        	'slug' => 'stuff',
        ]);
        // DB::table('users_roles')->insert([
        // 	'name' => 'Customer',
        // 	'slug' => 'customer',
        // ]);
    }
}
