<?php namespace ESP;

use Illuminate\Database\Eloquent\Model;
use DB;
class TimeRegistry extends Model {

	//
	protected $table = 'time_registries';
	protected $primaryKey = 'time_registry_id';

	protected $fillable = ['status', 'start_timestamp', 'end_timestamp', 'user_id', 'status_id', 'ip'];

	public function scopeUserId($query, $user_id){
		return $query->where('user_id', '=', $user_id);
	}
	public static function get_time_ammendments($user_id) {
		
		$qry3 = "
			SELECT tr.time_registry_id, tr.user_id, tr.status, tr.start_timestamp, tr.end_timestamp, ta.time_ammendment_id, 
			ta.status 'ta_status', ta.original_start, ta.original_finish, ta.ammended_start, 
			ta.ammended_finish, ta.user_notes, ta.hr_comments  
			FROM time_registries tr 
			LEFT JOIN time_ammendments ta ON tr.time_registry_id = ta.time_registry_id 
			WHERE tr.user_id = '$user_id' 
			AND (tr.status = 'Finish Day' OR ( tr.status = 'start day' AND DATE_FORMAT(tr.start_timestamp, '%Y-%m-%d') != CURDATE()))
			GROUP BY tr.start_timestamp 
			ORDER BY tr.time_registry_id DESC LIMIT 7;
		";
		$res3 = DB::select($qry3);
		return $res3;
	}
}
