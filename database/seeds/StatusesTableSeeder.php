<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class StatusesTableSeeder extends Seeder
{
    public function run()
    {
        // TestDummy::times(20)->create('App\Post');
         DB::table('statuses')->insert([
        	array('status_name' => 'late'),
        	array('status_name' => 'in office'),
        	array('status_name' => 'unavailable'),
        	array('status_name' => 'finished'),
        	array('status_name' => 'absent'),
        	array('status_name' => 'sick'),
        	array('status_name' => 'tardy'),
        	array('status_name' => 'investigating'),
    	]);
        
    }
}
