<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class GracePeriodsTableSeeder extends Seeder
{
    public function run()
    {
        // TestDummy::times(20)->create('App\Post');
         DB::table('grace_periods')->insert([
        	array('grace_period_value' => '00:00:00', 'display' => 'none', 'grace_period_add_timestamp' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0),
    	]);
    }
}
