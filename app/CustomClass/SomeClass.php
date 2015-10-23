<?php
namespace ESP\CustomClass;

use ESP\CustomClass\SubFolder\SubClass;
use Session;

class Someclass extends SubClass {
	
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