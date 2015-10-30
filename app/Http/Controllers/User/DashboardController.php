<?php namespace ESP\Http\Controllers\User;

use ESP\Http\Requests;
use ESP\Http\Controllers\Controller;
use ESP\CustomClass\LDAP\adLDAP;
use Illuminate\Support\Facades\Redirect;

use ESP\LoginAttempts;
use ESP\CustomClass\SomeClass;
use ESP\User;
/*use ESP\Company;
use ESP\Offices;
use ESP\CompanyOffice;
use ESP\CompanyUser;
use ESP\RoleUser;*/
use ESP\Schedule;
use ESP\TimeRegistry;


// for DB connection. Edit also .env file in /var/www/laravel
use DB;
use Auth;
use Request;
use Session;
use View;
use Paginator;
use DateTime;


class DashboardController extends Controller {

	public function __construct() {
		// Important. Set the timezone to PH Manila GMT +8 hours
		date_default_timezone_set('Asia/Manila');
		
	}

	public function index(){
		if (!Auth::check()) {
			return redirect('/');
		}

		//add validation to enable/disable the Start/Finish Day buttons - one time login only per day
		$start_day_disabled = '';
		$finish_day_disabled = '';
		$user_id = Session::get('user_id');

		$TimeRegistry = TimeRegistry::UserId($user_id)->orderBy('start_timestamp','desc')->first();
		//echo $TimeRegistry->count();
		//echo "<pre>"; print_r($TimeRegistry); exit();
		
		$data['forgot_logout'] = FALSE;
		$data['start_timestamp_forgot'] = '';
		$data['today'] = date("Y-m-d");
		$data['time'] = time();

		if($TimeRegistry->count()):
			$data['status'] = $TimeRegistry->status;	
			
			$data['start_day'] = date("Y-m-d", strtotime($TimeRegistry->start_timestamp));
			$data['plus13_timestamp'] = strtotime($TimeRegistry->start_timestamp) + 13*60*60; // add 6
			
			$data['finish_day'] = strtotime($TimeRegistry->end_timestamp);
			$data['finish_day'] = ($data['finish_day']) ? date("Y-m-d", $data['finish_day']): $data['finish_day'];

			$data['full_start_date'] = date("Y-m-d H:i:s", strtotime($TimeRegistry->start_timestamp));

			if("start day" == $data['status'] && !$data['finish_day'] && $data['time'] < $data['plus13_timestamp']):
				$data['finish_day_disabled'] == FALSE;
				$data['forgot_logout'] = FALSE;
			elseif("start day" == $data['status'] && !$data['finish_day'] && $data['time'] > $data['plus13_timestamp']):
				
			endif;


		endif;

		//echo "<pre>"; print_r($data); exit();
		$view = View::make('user.dashboard');
		return $view;
	}

}