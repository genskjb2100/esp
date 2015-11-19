<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class OfficesTableSeeder extends Seeder
{
    public function run()
    {
    	 DB::table('offices')->insert([
        	array('office_name' => 'eastwood'),
    	]);
        // TestDummy::times(20)->create('App\Post');
    }
}
