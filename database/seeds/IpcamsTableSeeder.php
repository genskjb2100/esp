<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class IpcamsTableSeeder extends Seeder
{
    public function run()
    {
        // TestDummy::times(20)->create('App\Post');
         DB::table('Ipcams')->insert([
        	array('ip' => '10.80.49.24', 'user' => 'jonel', 'password' => 'password1'),
    	]);
    }
}
