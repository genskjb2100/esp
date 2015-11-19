<?php namespace ESP\Http\Controllers\Client;

use ESP\Http\Requests;
use ESP\Http\Controllers\Controller;

// for DB connection. Edit also .env file in /var/www/laravel
use DB;
use Auth;
use Request;
use Session;
use View;
use Paginator;
use DateTime;

use ESP\User;

class LoginController extends Controller {

	var $response_text;
	var $response_status;

	public function index(){
		if (Auth::check()):
			return redirect('client/dashboard');
		else:
			$view = View::make('client.client_login');
			return $view;
		endif;
	}

	public function authenticate()
	{
		$u = Request::get('username');
		$p = Request::get('password');
		$g = User::ClientUsername($u)->ClientPassword(md5($p))->get();
		if(!empty($u) && !empty($p)):
			if($g->count() > 0):
				$this->response_text = "Login Successful";
				$this->response_status = "Success";
				Auth::login(User::find($g[0]->id));
				$this->_setSession($g[0]);
				//print_r(Session::get(''));
				//print_r($g[0]->id);
			else:
				$this->response_text = "Invalid Email/Password";
				$this->response_status = "Failed";
			endif;
		else:
			$this->response_text = "Email and password are required.";
			$this->response_status = "Failed";
		endif;

		return array("status" => $this->response_status, "msg" => $this->response_text);
		//print_r($g[0]->roles[0]->role_name);
	}

	private function _setSession($data){
		$ret = array("client_email" => $data->client_email,
						"user_id" => $data->id,
						"display_name" => $data->nickname,
						"first_name" => $data->first_name,
						"last_name" => $data->last_name,
						"roles" => $data->roles
				);
		Session::put($ret);
		//return $ret;
	}
}
