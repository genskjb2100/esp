<?php
namespace ESP\CustomClass;
use Session;

class Someclass {
	
	public function getIpAddress(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
	}

    public static function checkUserInfo($userinfo, $messages){

        try {
            if (!isset($userinfo[0]['displayname'][0]) 
                or !isset($userinfo[0]['mail'][0]) 
                or !isset($userinfo[0]['company'][0]) 
                or !isset($userinfo[0]['physicaldeliveryofficename'][0]) 
                or !isset($userinfo[0]['givenname'][0]) 
                or !isset($userinfo[0]['sn'][0])):
                $data = array("response_status" => false,
                            "response_text" => $messages['contact_it']
                        );
            else:
                $data = NULL;
            endif;
        } catch (Exception $e) {
            $data = array("response_status" => false,
                        "response_text" => $messages['contact_hr']
                    );
        }
        return $data;
    }

    public static function userInitSession($user_info){
        // put client details in Session
        Session::put('user_id', $user_info['user_id']);
        Session::put('user_email', $user_info['user_email']);
        Session::put('user_password', $user_info['user_password']);
        Session::put('nickname', $user_info['nickname']);
        Session::put('role_id', $user_info['role_id']);
        Session::put('hidden', $user_info['disabled']);
        Session::put('work_from_home', $user_info['work_from_home']);
        Session::put('username', $user_info['username']);
    }

    public function clientInitSession($data){
        $client_username = $data->username;
        
        $client_id = $data->user_id;
        $client_email = $data->client_email;
        $client_password = $data->client_password;
        $display_name = $data->display_name;
        $disabled = $data->disabled;
        $hidden = $data->hidden;
        $company_id = $data->company_id;
        $company_name = $data->company_name;
        
        // put client details in Session
        Session::put('client_id', $client_id);
        Session::put('client_email', $client_email);
        Session::put('client_password', $client_password);
        Session::put('company_name', $company_name);
        
        Session::put('display_name', $display_name);
        Session::put('company_id', $company_id);
        Session::put('role_id', '2');
        Session::put('hidden', $hidden);
    }
   
}

?>