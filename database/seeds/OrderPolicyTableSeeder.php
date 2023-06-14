<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_policy')->insert([
        	'policy' => "Delivery",
        	'slug' => "delivery"
        ]);

        DB::table('order_policy')->insert([
            'policy' => "Pickup in-store",
            'slug' => "pickup"
        ]);
    }
}
