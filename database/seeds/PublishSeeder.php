<?php

use Illuminate\Database\Seeder;

class PublishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('publish_names')->insert([
            'name' => 'Publish',
            
        ]);
        DB::table('publish_names')->insert([
            'name' => 'Unpublish',
            
        ]);
        
    }
}
