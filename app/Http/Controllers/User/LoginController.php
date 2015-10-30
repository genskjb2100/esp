<?php namespace ESP\Http\Controllers\User;

use ESP\Http\Requests;
use ESP\Http\Controllers\Controller;
use ESP\CustomClass\LDAP\adLDAP;
use Illuminate\Support\Facades\Redirect;

use ESP\LoginAttempts;
use ESP\CustomClass\SomeClass;
use ESP\User;
use ESP\Company;
use ESP\Offices;
use ESP\CompanyOffice;
use ESP\CompanyUser;
use ESP\RoleUser;
use ESP\Schedule;


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
										'contact_hr' => 'Your Active Directory account does not have the required fields. Please contact HR.',
										'contact_it' => 'Your account does not have the required details. Please contact IT.',
										'redirect' => 'Your account is being redirected.',
										'no_remote' => 'You are not authorised to login remotely. If this is incorrect please contact HR.',

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
	var $helpers;
	var $user_info = array();
	var $wfh = FALSE;

	public function __construct() {
		// Important. Set the timezone to PH Manila GMT +8 hours
		date_default_timezone_set('Asia/Manila');
		$ipadd = new SomeClass();
		$helpers = $ipadd;
		$this->ip = $ipadd->getIpAddress();
	}

	public function authenticate(){
		/*if (Request::ajax()):*/
			$isAccountActive = FALSE;
			$adldap = new adLDAP();
			$username = Request::input('username');
			$password = md5(Request::input('password'));
			$authUser = $adldap->authenticate($username, Request::input('password'));

			if($authUser && $this->login_status):
				$user_fields = array(
						'displayname', 'mail','company', 'physicaldeliveryofficename', 'givenname', 'sn'
					);
				
				$this->user_info = $adldap->user()->info($username, $user_fields); //working
				$this->_processUser($username, $password);

				//return array("status" => $this->response_status, "message" => $this->response_text);
			else:
				$this->login_status = FALSE;
				$this->_check_failed_login_duration($username);
				//return array("status" => $this->response_status, "message" => $this->response_text);
			endif;

			//todo WFH. SEARCH FOR VLANS
			if ($this->wfh) :
				// if user is allowed to work from home then check his IP
				$user_ip_address = Request::getClientIp(true);
				$tmpIP = $user_ip_address;
	            $pos = strrpos($tmpIP, '.');
	            $tmpIP = substr($tmpIP, 0, $pos). '.';
				
				$qry2 = "
					SELECT * FROM vlans v 
					INNER JOIN offices o ON v.office_id = o.office_id 
					WHERE subnet like '".$tmpIP."%';
				";
				$res2 = DB::select($qry2);
				
				if (count($res2) == 0 && ip2long($user_ip_address) != ip2long("127.0.0.1")) :
					$this->login_status = FALSE;
					$this->response_text = 'You are not authorised to login remotely. If this is incorrect please contact HR.';
					$this->response_status = 'failed';
					Auth::logout();
					
				endif;
			endif;
			return array("status" => $this->response_status, "message" => $this->response_text);
		/*else:
			return array("status" => $this->response_status, "message" => $this->response_text);
		endif;*/
		
	}

	private function _processUser($username, $password){
		
		$results = User::get_employee_username_password($username, $password);
		if(count($results) > 0):

			$this->user_info = array(
					'username' => $results->username, 
					'user_id' => $results->id, 
					'first_name' => $results->first_name,
					'last_name' => $results->last_name,
					'user_email' => $results->email, 
					'user_password' => $results->password, 
					'nickname' => $results->nickname,
					'disabled' => $results->disabled, 
					'role_id' => $results->role_id,
					'birthdate' => $results->birthdate,
					'hidden' => $results->hidden, 
					'work_from_home' => $results->work_from_home,
				);

			$fla = LoginAttempts::IP($this->ip)->Username($username)->orderBy('attempts', 'DESC')->first();
			if($fla):
				$this->_saveLoginAttempt($username, 1,"", TRUE);
			else:
				$this->_createLoginAttempt($username, 1, "", TRUE);
			endif;

			$this->login_status = TRUE;
			$this->wfh = $results->work_from_home;
			$this->response_text = $this->messages['redirect'];
			$this->response_status = "success";

			$this->_userAuthenticate($this->user_info);

		else:

			$cui = SomeClass::checkUserInfo($this->user_info, $this->messages);			
			if ($cui):
				$this->response_status = $cui['response_status'];
				$this->response_text = $cui['response_text'];
				$this->login_status = false;

			else:
				$userinfo = $this->user_info;
				if (isset($userinfo)):
					$this->user_info = array(
						'username' => $username, 
						'user_password' => $password,
						'user_email' => $userinfo[0]["mail"][0], 
						'nickname' => $userinfo[0]["displayname"][0],
						'first_name' => $userinfo[0]['givenname'][0],
						'last_name' => $userinfo[0]['sn'][0],
					);
					$company = $userinfo[0]["company"][0];
					$office = $userinfo[0]["physicaldeliveryofficename"][0];
					$co = $this->_companyOfficeCreate($company, $office);
					$nUser = $this->_updatePassOrCreateNewUser($username, $password, $co);
					$this->user_info['user_id']	 = $nUser->id;

					$this->_userAuthenticate($this->user_info);
					$this->login_status = true;
				endif;
			endif;
		endif;
	}

	private function _updatePassOrCreateNewUser($username, $password, $co){
		$new_user = User::getByUsername($username);
		if(count($new_user) > 0):
			$this->wfh = $new_user->work_from_home;
			$u = User::find($new_user->id);
			$u->password = $password;
			$u->save();
		else:
			$u = User::firstOrCreate([
				'username' => strtolower($username), 
				'password' => $password, 
				'first_name' => $this->user_info['first_name'], 
				'last_name' => $this->user_info['last_name'], 
				'email' => $this->user_info['user_email'], 
				'nickname' => $this->user_info['nickname'],
				'office_id' => $co->office_id
			]);
			$this->wfh = FALSE;
		endif;
		// insert also schedule
		$s = Schedule::firstOrCreate(['user_id' => $u->id, 'grace_period_id' => 1]);

		// insert also user_roles
		$ur = RoleUser::firstOrCreate([
			'user_id' => $u->id, 
			'role_id' => '3' // hard coded 3 for employee 
		]);
		// insert user_company
		$uc = CompanyUser::firstOrCreate([
			'user_id' => $u->id, 
			'company_id' => $co->company_id
		]);
		return $u;
	}

	private function _companyOfficeCreate($company, $office){
		$c = Company::firstOrCreate(['company_name' => $company]);
		$o = Offices::firstOrCreate(['office_name' => $office]);

		return CompanyOffice::firstOrCreate(['company_id' => $c->company_id, 'office_id' => $o->office_id]);
	}

	private function _userAuthenticate($user_info){
		SomeClass::userInitSession($user_info);
		$user = User::find($user_info['user_id']); // user_id test 1 is mark.tan
		Auth::login($user);
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
        			$this->_saveLoginAttempt($username, 1,"");
        			$this->response_text = $this->messages['invalid'];
        			$this->response_status = "failed";
        		else:
        			$this->_saveLoginAttempt($username, ++$attempts,"blocked");	
        			$this->response_text = "Max Login Attempts Reached. Please try again after 30 minutes.";
        			$this->response_status = "failed";
        		endif;
        	else:
        		$this->_saveLoginAttempt($username, ++$attempts,"");
        		$this->response_text = $this->messages['invalid'];
        		$this->response_status = "failed";
        	endif;
        else:
        	$this->_createLoginAttempt($username, 1, "");
        	$this->response_text = $this->messages['invalid'];
        	$this->response_status = "failed";
        endif;

    }

    private function _saveLoginAttempt($username, $attempts, $status, $success = false){
    	$data = array('attempt_status' => $status, 'attempts' => $attempts, 'login_page_name' => 'user');
    	$ll = ($success) ? 'success_last_login' : 'failed_last_login';
    	$data[$ll] = date("Y-m-d H:i:s");
    	$pla = LoginAttempts::where("username", "=", $username)->update($data);
    }

    private function _createLoginAttempt($username, $attempts, $status, $success = false){
    	$data = array("username" => $username,
    		"ip" => $this->ip,
    		'attempt_status' => $status, 
    		'attempts' => $attempts, 
    		'login_page_name' => 'user');
    	$ll = ($success) ? 'success_last_login' : 'failed_last_login';
    	$data[$ll] = date("Y-m-d H:i:s");

    	$la = LoginAttempts::create($data);
    }

    private function _getElapsedMinute($from){
    	$date1 = new DateTime($from);
        $date2 = new DateTime();
        $diff = $date2->diff($date1);
		//$elapsed = $diff->format('%a days %h hours %i minutes %S seconds');
        return $diff->format('%i');
    }

}
