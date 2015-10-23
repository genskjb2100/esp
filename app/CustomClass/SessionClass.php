<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace ESP\CustomClass;

use Session;
/**
 * Description of SessionClass
 *
 * @author genesis.gallardo
 */
class SessionClass {
    //put your code here
    
    public static function isSessionActive(){
        return (!Session::has('id') && Session::get('role_id') != '1')? TRUE: FALSE;
    }
}
