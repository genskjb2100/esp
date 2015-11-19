<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // TestDummy::times(20)->create('App\Post');
         DB::table('users')->insert([
        	array('client_email' => 'karl.mitmannsgruber@emapta.com', 'client_password' => md5('1234qwer'), 'first_name' => 'karl', 'last_name' => 'mitmannsgruber')
    	]);
    }
}
