<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class RoleTableSeeder extends Seeder
{
    public function run()
    {
        // TestDummy::times(20)->create('App\Post');
        DB::table('roles')->insert([
        	array('role_name' => 'admin'),
        	array('role_name' => 'client'),
        	array('role_name' => 'user')
    	]);
    }
}
