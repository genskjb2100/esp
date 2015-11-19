<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ModuleTableSeeder extends Seeder
{
    public function run()
    {
        // TestDummy::times(20)->create('App\Post');
        DB::table('Modules')->insert([
        	array("module_name" => "User_Dashboard"),
        	array("module_name" => "User_Overtime_Application"),
        	array("module_name" => "User_Leave_Credits"),
        	array("module_name" => "User_Leave_Application"),
        	array("module_name" => "User_Payslip"),
        	array("module_name" => "User_Application_Leave_Status"),
        	array("module_name" => "User_Calendar"),
        	array("module_name" => "User_Bandwidth_Utilization"),
        	array("module_name" => "User_App_and_Browsing_History"),
        	array("module_name" => "User_Induction_Survey_Questions"),
        	array("module_name" => "User_Client_Specific_Orientation"),
        	array("module_name" => "User_Joke_of_the_Day"),
        	array("module_name" => "User_Event_Invites"),
        	array("module_name" => "User_Career_Questions"),
        	array("module_name" => "Client_Dashboard"),
        	array("module_name" => "Client_User"),
        	array("module_name" => "Client_Gifts"),
        	array("module_name" => "Client_Shop"),
        	array("module_name" => "Client_Connectivity"),
        	array("module_name" => "Client_Company_Contacts"),
        	array("module_name" => "Client_FAQ"),
        	array("module_name" => "Client_IT_Support"),
        	array("module_name" => "Client_HR"),
        	array("module_name" => "Client_Finance"),
        	array("module_name" => "Client_Escalations"),

    	]);
    }
}
