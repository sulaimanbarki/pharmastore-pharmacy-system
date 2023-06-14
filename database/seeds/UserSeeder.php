<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'users_role_id' => 1,
        	'isAdmin' => 1,
        	'firstname' => "Super",
            'lastname' => "Admin",
            'image' => "default.png",
        	'email' => "super@admin.com",
        	'password' => Hash::make("12345678"),
        	'phone' => "88088088080",
        	'status' => "1"
        ]);
    }
}
