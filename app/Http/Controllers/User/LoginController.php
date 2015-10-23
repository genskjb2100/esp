<?php namespace ESP\Http\Controllers\User;

use ESP\Http\Requests;
use ESP\Http\Controllers\Controller;
use ESP\CustomClass\LDAP\adLDAP;
use Illuminate\Support\Facades\Redirect;

use ESP\LoginAttempts;
use ESP\CustomClass\SomeClass;

// for DB connection. Edit also .env file in /var/www/laravel
use DB;
use Auth;
use Request;
use Session;
use View;
use Paginator;
use DateTime;


class LoginController extends Controller {

	var $messages = array('invalid' => 'Invalid Username or Password.',
										'disabled' => 'Your account is currently disabled. Please contact HR.',
										'valid' => 'Your account is validated.',
									);
	var $response_text;
	var $response_status;

	var $login_status = TRUE;
	var $activeStatusCode = array(
								512,	//Enabled Account
								544,	//Enabled, Password Not Required
								66048,	//Enabled, Password Doesn't Expire
								66080,	//Enabled, Password Doesn't Expire & Not Required
								262656,	//Enabled, Smartcard Required
								262688,	//Enabled, Smartcard Required, Password Not Required
								328192,	//Enabled, Smartcard Required, Password Doesn't Expire
								328224,	//Enabled, Smartcard Required, Password Doesn't Expire & Not Required
							);
	var $inactiveStatusCode = array(
								514,	//Disabled Account
								546,	//Disabled, Password Not Required
								66050,	//Disabled, Password Doesn't Expire
								66082,	//Disabled, Password Doesn't Expire & Not Required
								262658,	//Disabled, Smartcard Required
								262690,	//Disabled, Smartcard Required, Password Not Required
								328194,	//Disabled, Smartcard Required, Password Doesn't Expire
								328226,	//Disabled, Smartcard Required, Password Doesn't Expire & Not Required
							);
	var $ip;

	public function __construct() {
		// Important. Set the timezone to PH Manila GMT +8 hours
		date_default_timezone_set('Asia/Manila');
		$ipadd = new SomeClass();
		$this->ip = $ipadd->getIpAddress();
	}

	public function authenticate(){
		
		$isAccountActive = FALSE;
		$adldap = new adLDAP();
		$username = Request::input('username');
		$password = md5(Request::input('password'));
		
		$authUser = $adldap->authenticate($username, Request::input('password'));
		/*$accountStatus = $adldap->user()->info($username, array('UserAccountControl'))[0]['useraccountcontrol'][0];

		if(in_array($accountStatus, $activeAccountStatusCode) && !in_array($accountStatus, $inactiveAccountStatusCode)):
			$isAccountActive = TRUE;
		else:
			$isAccountActive = FALSE;
		endif;*/

		if($authUser && $this->login_status):
			
		else:
			$this->_check_failed_login_duration($username);
			//return array("status" => FALSE, "message" => $this->messages['invalid']);
			return array("status" => $this->response_status, "message" => $this->response_text);
		endif;
	}

	private function _check_failed_login_duration($username) {
		//fla is alias for failed_login_attempts
        $date_today = date("Y-m-d");
        $fla = LoginAttempts::IP($this->ip)->Username($username)->orderBy('attempts', 'DESC')->first();
        
        if($fla):
        	$attempts = $fla->attempts;
        	$elapsed_minute = $this->_getElapsedMinute($fla->failed_last_login);

        	if ($attempts >= 10):
        		if($elapsed_minute >= 30):

        		else:
        			$this->_saveLoginAttempt($username, ++$attempts,"blocked");	
        			$this->response_text = "Max Login Attempts Reached. Please try again after 30 minutes.";
        			$this->response_status = "failed";
        		endif;
        	else:
        		$this->_saveLoginAttempt($username, ++$attempts,"");
        	endif;
        else:
        	$this->_saveLoginAttempt($username, 1, "");
        endif;

    }


    private function _saveLoginAttempt($username, $attempts, $status){
    	$la = LoginAttempts::firstorcreate([
    		"username" => $username,
    		"ip" => $this->ip,
    		]);
    	$pla = LoginAttempts::where("login_attempt_id", "=", $la->login_attempt_id)->update(array('attempt_status' => $status, 'failed_last_login' => date("Y-m-d H:i:s"), 'attempts' => $attempts, 'login_page_name' => 'user'));
    }

    private function _getElapsedMinute($from){
    	$date1 = new DateTime($from);
        $date2 = new DateTime();
        $diff = $date2->diff($date1);
		//$elapsed = $diff->format('%a days %h hours %i minutes %S seconds');
        return $diff->format('%i');
    }

}
