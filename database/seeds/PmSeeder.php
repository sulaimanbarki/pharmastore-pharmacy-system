<?php

use Illuminate\Database\Seeder;

class PmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->insert([
            'type' => 'Card',
            'image' => 'projectImage/payments/card.jpg',
        	'status' => '1',
        ]);
        DB::table('payment_methods')->insert([
            'type' => 'Cash On Delivery',
            'image' => 'projectImage/payments/cash.png',
        	'status' => '1',
        ]);
    }
}
