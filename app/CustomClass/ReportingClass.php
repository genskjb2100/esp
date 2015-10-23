<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ESP\CustomClass;

use DB;
use Auth;
use Request;
use Session;
use View;
use Paginator;
use ESP\Client;
/**
 * Description of ReportingClass
 *
 * @author genesis.gallardo
 */
class ReportingClass {

    public function __construct() {
        // Important. Set the timezone to PH Manila GMT +8 hours
        date_default_timezone_set('Asia/Manila');
    }
    
    protected static $per_page = 15;
    
    public static function getAllAttendance() {
        $records = DB::table('time_registry as tr')
                    ->select(DB::raw("tr.time_registry_id, CONCAT(u.first_name, ' ', u.last_name) as full_name, "
                            . "tr.start_timestamp, tr.finish_timestamp, FLOOR((tr.finish_timestamp - tr.start_timestamp) / 60) as total_minutes, "
                            . "FLOOR((tr.finish_timestamp - tr.start_timestamp) / 3600) as total_hours, c.company_name as company"))
                    ->join('users as u', 'u.user_id', '=', 'tr.user_id')
                    ->join('user_company as uc', 'uc.user_id', '=', 'u.user_id')
                    ->join('company as c', 'c.company_id', '=', 'uc.company_id')
                    ->where('tr.status', 'Finish Day')
                    ->orderBy('tr.time_registry_id', 'ASC')
                   ->paginate(self::$per_page);
        return $records;
    }
    
    public static function getUsers(){
       return DB::table('users as u')
                            ->join('user_roles as ur', 'u.user_id','=', 'ur.user_id')
                            ->select(DB::raw("CONCAT(u.first_name, ' ', u.last_name) as full_name, u.user_id"))
                            ->where('ur.role_id', 3)
                            ->orderBy('u.first_name', 'ASC')
                            ->distinct()
                            ->get();
    }
    
    public static function getCompanies(){
        return DB::table("company as c")
                            ->select("c.company_id", "c.company_name")
                            ->orderBy("c.company_name", "ASC")
                            ->distinct()
                            ->get();
    }
    
    public function getAttendanceBy($what) {
        
    }

    public static function getMyEmployees($company_id, $client_id){
        
       /* return DB::table('users as u')
                        ->select(DB::raw("u.user_id, CONCAT(u.first_name, ' ', u.last_name) as full_name, o.office_name,"
                                . "(SELECT start_timestamp from time_registry where user_id = u.user_id order by time_registry_id DESC Limit 1) as start_timestamp,"
                                . "(SELECT status from time_registry where user_id = u.user_id order by time_registry_id DESC Limit 1) as status,"
                                . "(SELECT notes from time_registry where user_id = u.user_id order by time_registry_id DESC Limit 1) as notes,"
                                . "(SELECT finish_timestamp from time_registry where user_id = u.user_id order by time_registry_id DESC Limit 1) as finish_timestamp"))
                        ->join('user_company as uc', 'uc.user_id', '=', 'u.user_id')
                        ->join('company_office as co', 'co.company_id', '=', 'uc.company_id')
                        ->join('offices as o', 'o.office_id', '=', 'co.office_id')
                        ->where('uc.company_id', $company_id)
                        ->groupBy('u.user_id')
                        ->distinct()   
                        ->get();*/
        $com = Client::get_company_names($client_id); 
        if (count($com) > 0):
            // loop to get per company of the client
            foreach ($com as $k => $v):
                $emp = Client::get_employees($v->company_id);
                if(!empty($emp)):
                    foreach($emp as $x):
                        $time_reg = Client::get_time_registry($x->user_id);
                        print_r($x);
                        print_r($time_reg);
                        //print_r(@$time_reg[0]->display_name);
                        //echo self::get_employee_status($time_reg, $v->company_name ). "<br/>";
                    endforeach;
                endif;
            endforeach;
        endif;

    }

    public static function get_employee_status($res3, $company_name) {
        
        if (count($res3) > 0) {
            
            $start_time = date("g:i a", $res3[0]->start_timestamp);
            $start_date = date("M j, Y D", $res3[0]->start_timestamp);
            $finish_time = '-';
            $finish_date = '-';
            $flexi = $res3[0]->flexi;
            $grace_period_value = $res3[0]->grace_period_value;
            $grace_period_add_timestamp = $res3[0]->grace_period_add_timestamp;
            
            $hours = $res3[0]->hours;
            $minutes = $res3[0]->minutes;
            $seconds = $res3[0]->seconds;
            $grace_period_id = $res3[0]->grace_period_id;
            $grace_period_value = $res3[0]->grace_period_value;
            
            if (!is_null($res3[0]->finish_timestamp)) {
                $finish_time = date("g:i a", $res3[0]->finish_timestamp);
            }
            if (!is_null($res3[0]->finish_timestamp)) {
                $finish_date = date("M j, Y D", $res3[0]->finish_timestamp);
            }
            
            $mon_start_time = strtotime($res3[0]->mon_start);
            $tue_start_time = strtotime($res3[0]->tue_start);
            $wed_start_time = strtotime($res3[0]->wed_start);
            $thur_start_time = strtotime($res3[0]->thu_start);
            $fri_start_time = strtotime($res3[0]->fri_start);
            $sat_start_time = strtotime($res3[0]->sat_start);
            $sun_start_time = strtotime($res3[0]->sun_start);
            
            $day_today = strtolower(date('D')) . '_start';
            //$any_start_time = strtotime($row[$day_today . 'Start']);
            $any_start_time = strtotime($res3[0]->$day_today);
            
            $start_timestamp = $res3[0]->start_timestamp;
            $finish_timestamp = $res3[0]->finish_timestamp;
            
            //$staff_logged_in_time = $row['StartTimeStamp']; // in time() format
            $today_ymd = date("Y-m-d");
            
            if ($today_ymd == date('Y-m-d', $start_timestamp)) {
                
                if ($start_timestamp > $any_start_time) {
                    if ($finish_time == '-') {
                        $h_status = 'in_office';
                    } else {
                        $h_status = 'logged_out';
                    }
                    
                } else {
                    // check if the staff logged out already
                    if ($finish_time == '-') {
                        $h_status = 'in_office';
                    } else {
                        $h_status = 'logged_out';
                    }
                }
                
            } else {
                
                $any_start_time_with_grace = $any_start_time + $hours * $minutes * $seconds;
                $plus_grace_period = $start_timestamp + $hours * $minutes * $seconds; // add 13 hours
                $added_13hrs = date('Y-m-d H:i:s', $plus_grace_period);
                $current_time = time();
                
                if (time() < $any_start_time_with_grace) {
                    $h_status = 'unavailable';
                } else {
                    //$h_status = 'late';
                    // check if the employee is flexi or not
                    if ($flexi == '1') {
                        $h_status = 'flexi';
                    } else {
                        $h_status = 'late';
                    }
                    
                    $temp_val = strtolower(str_replace(" ", "_", $company_name));
                    $company_name_header[] = str_replace("&", "and", $temp_val);
                }
            }
            return $h_status;
        }
    }

}
