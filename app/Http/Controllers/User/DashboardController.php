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

    var $start_timestamp_forgot;
    var $sched_status = array(
                            'STARTED' => 'You have already signed in for today. You can only sign out for today.',
                            'FORGOT_LOGOUT' => '',
                            'FINISHED' => '',
                            'FINISHED_ONCE' => 'You have already signed in and out for today. You can only sign in and out once a day. ',
                            'TO_START' => '',
                        );
	public function __construct() {
		// Important. Set the timezone to PH Manila GMT +8 hours
		date_default_timezone_set('Asia/Manila');
		
	}

	public function index(){
		if (!Auth::check()) {
			return redirect('/');
		}

		//add validation to enable/disable the Start/Finish Day buttons - one time login only per day
        
		$user_id = Session::get('user_id');
        $data = $this->_getRegistry($user_id);
        $data['location'] = 'Manila';
        //echo "<pre>"; print_r($this->sched_status);exit();        
		$view = View::make('user.dashboard')->with($data);
        $view['sched_status'] = $this->sched_status;
		return $view;
	}
    public function testLdap(){
        $ad = new adLDAP();
        //$ad->user()->modify("genesis.gallardo", array("email" => "Genesis.Gallardo@emapta.com"));
        $results = $ad->user()->info("angelique.torrano");
        echo "<pre>"; print_r($results);

    }
    private function _getRegistry($user_id){
        $TimeRegistry = TimeRegistry::UserId($user_id)->orderBy('start_timestamp','desc')->first();
        $data['forgot_logout'] = FALSE;
        $data['start_timestamp_forgot'] = '';
        $data['today'] = date("Y-m-d");
        $data['time'] = time();

        if(count($TimeRegistry) > 0):
            $data['status'] = strtolower($TimeRegistry->status);	

            $data['start_day'] = date("Y-m-d", strtotime($TimeRegistry->start_timestamp));
            $data['plus13_timestamp'] = strtotime($TimeRegistry->start_timestamp) + 13*60*60; // add 6

            $data['finish_day'] = strtotime($TimeRegistry->end_timestamp);
            $data['finish_day'] = ($data['finish_day']) ? date("Y-m-d", $data['finish_day']): $data['finish_day'];

            $data['full_start_date'] = date("Y-m-d H:i:s", strtotime($TimeRegistry->start_timestamp));

            if("start day" == $data['status'] && ((!$data['finish_day'] && $data['time'] < $data['plus13_timestamp']) || ($data['start_day'] ==  $data['today']))):
                $data['op_what'] = 'STARTED';
                $data['forgot_logout'] = FALSE;
            elseif("start day" == $data['status'] && !$data['finish_day'] && $data['time'] > $data['plus13_timestamp']):
                $data['forgot_logout'] = TRUE;
                $data['op_what'] = 'FORGOT_LOGOUT';
                $data['start_timestamp_forgot'] = date("g:i a l M j", strtotime($TimeRegistry->start_timestamp));
                $this->sched_status['FORGOT_LOGOUT'] = 'You did not finish time last <b>'.$data['start_timestamp_forgot'].'</b>. Please click finish day.';
            elseif($data['status'] == 'finish day' && $data['finish_day'] == $data['today'] && $data['start_day'] != $data['today']):
                $data['op_what'] = 'FINISHED';
                $data['forgot_logout'] = FALSE;
            elseif($data['status'] == 'finish day' && $data['finish_day'] == $data['today']):
                $data['op_what'] = 'FINISHED_ONCE';
                $data['forgot_logout'] = FALSE;
            endif;
        else:
             $data['op_what'] = 'TO_START';
             $data['forgot_logout'] = FALSE;
        endif;
        return $data;
    }
}