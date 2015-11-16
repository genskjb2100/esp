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
use ESP\TimeAmmendment;


// for DB connection. Edit also .env file in /var/www/laravel
use DB;
use Auth;
use Request;
use Session;
use View;
use Paginator;
use DateTime;
use Crypt;


class DashboardController extends Controller {

    var $start_timestamp_forgot;
    var $sched_status = array(
                            'STARTED' => 'You have already signed in for today. You can only sign out for today.',
                            'FORGOT_LOGOUT' => '',
                            'FINISHED' => '',
                            'FINISHED_ONCE' => 'You have already signed in and out for today. You can only sign in and out once a day. ',
                            'FINISHED_FORGOT'=> '',
                            'TO_START' => '',
                            'DEFAULT' => '',
                        );
	public function __construct() {
		// Important. Set the timezone to PH Manila GMT +8 hours
		date_default_timezone_set('Asia/Manila');
         //print_r(Session::all());
		
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
        $view['time_records'] = TimeRegistry::get_time_ammendments($user_id);
        //echo "<pre>";print_r($view['time_records']);exit();
		return $view;
	}

    public function request_amendment(){
       
        $data = $this->_prepareAmendmentData();
        foreach($data as $record):
            $ta = TimeAmmendment::create($record);
        endforeach;
        return array("status" => "success", "msg" => "Your request has been sent and ready for review from the client.", "callback_data" => $data);
    }

    private function _prepareAmendmentData(){
        //print_r(Request::all());
        $data = array();
        foreach(Request::get('tr_id') as $i => $val):
            $data[$i]['time_registry_id'] = Crypt::decrypt($val);
            $data[$i]['user_id'] = Session::get('user_id');
            $data[$i]['status'] = 'pending';
        endforeach;
        foreach(Request::get('original_start') as $i => $val):
            $data[$i]['original_start'] = $val;
        endforeach;
        foreach(Request::get('original_end') as $i => $val):
            $data[$i]['original_end'] = $val;
        endforeach;
        foreach(Request::get('ammended_start') as $i => $val):
            $data[$i]['ammended_start'] = $val;
        endforeach;
        foreach(Request::get('ammended_end') as $i => $val):
            $data[$i]['ammended_finish'] = $val;
        endforeach;
        foreach(Request::get('user_notes') as $i => $val):
            $data[$i]['user_notes'] = $val;
        endforeach;
        return $data;
    }

    public function testLdap(){
        $ad = new adLDAP();
        //$ad->user()->modify("genesis.gallardo", array("email" => "Genesis.Gallardo@emapta.com"));
        $results = $ad->user()->info("angelique.torrano");
        echo "<pre>"; print_r($results);

    }

    public function time_entry(){
        try {
            $tr_id = Crypt::decrypt(Request::get('tr_id'));
        } catch (DecryptException $e) {
            return array("status" => "failed", "msg" => $e);
        }

        if(empty($tr_id) && Request::input('what') == 1):    
            $time_entry = TimeRegistry::create([
                    'status' => 'start day',
                    'start_timestamp' => date('Y-m-d H:i:s'),
                    'user_id' => Session::get('user_id'),
                    'status_id' => 2,
                    'ip' => $_SERVER['REMOTE_ADDR'],
                ]);
            Session::set('my_start_timestamp', $time_entry->start_timestamp);

            return array("status" => "success", "msg" => $this->sched_status['STARTED'], "op_what" => "STARTED", "tr_id" => Crypt::encrypt($time_entry->time_registry_id));

        elseif(!empty($tr_id) && Request::input('what') == 0):
            $today = date("Y-m-d");
            $end_time = date('Y-m-d H:i:s');

            $this->sched_status['FINISHED_FORGOT'] = "Successfully Logged Out at " . date("H:i:s A", strtotime($end_time));
            
            if(date("Y-m-d", strtotime(Session::get('my_start_timestamp'))) == $today):
                $i = "FINISHED_ONCE";
                $ret_tr_id = Crypt::encrypt($tr_id);
            else:
                $i = "FINISHED_FORGOT";
                $ret_tr_id = Crypt::encrypt(NULL);
            endif;
            TimeRegistry::where('time_registry_id',$tr_id)->update(['status' => 'finish day', 'end_timestamp' => $end_time, 'status_id' => 4, 'ip' => $_SERVER['REMOTE_ADDR']]);    
            return array("status" => "success", "msg" => $this->sched_status[$i], "op_what" => $i, "tr_id" => $ret_tr_id);
        else:
            return array("status" => "failed", "msg" => "Unable to process request!");
        endif;
    }

    private function _getRegistry($user_id){
        $TimeRegistry = TimeRegistry::UserId($user_id)->orderBy('start_timestamp','desc')->first();
        $data['forgot_logout'] = FALSE;
        $data['start_timestamp_forgot'] = '';
        $data['today'] = date("Y-m-d");
        $data['time'] = time();
        $data['time_registry_id'] = NULL;
        if(count($TimeRegistry) > 0):
            $data['status'] = strtolower($TimeRegistry->status);	
            $data['time_registry_id'] = $TimeRegistry->time_registry_id;
            $data['start_day'] = date("Y-m-d", strtotime($TimeRegistry->start_timestamp));
            $data['plus13_timestamp'] = strtotime($TimeRegistry->start_timestamp) + 13*60*60; // add 6
            Session::set('my_start_timestamp', $data['start_day']);
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
                $this->sched_status['FORGOT_LOGOUT'] = 'You did not finish time last <b>'.$data['start_timestamp_forgot'].'</b>. ';
            elseif($data['status'] == 'finish day' && $data['finish_day'] == $data['today'] && $data['start_day'] != $data['today']):
                $data['op_what'] = 'FINISHED';
                $data['forgot_logout'] = FALSE;
            elseif($data['status'] == 'finish day' && $data['finish_day'] == $data['today']):
                $data['op_what'] = 'FINISHED_ONCE';
                $data['forgot_logout'] = FALSE;
            else:
                $data['op_what'] = 'TO_START';
                $data['time_registry_id'] = NULL;
            endif;
        else:
            $data['op_what'] = 'TO_START';
            $data['time_registry_id'] = NULL;
            $data['forgot_logout'] = FALSE;
        endif;

        if(($data['op_what'] == "FINISHED" && $data['finish_day'] == $data['today']) || $data['op_what'] == "FORGOT_LOGOUT"):
            $data['op_what'] = "TO_START";
            $data['time_registry_id'] = NULL;
        endif;
        return $data;
    }
}