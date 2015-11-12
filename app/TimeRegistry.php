<?php namespace ESP;

use Illuminate\Database\Eloquent\Model;

class TimeRegistry extends Model {

	//
	protected $table = 'time_registries';
	protected $primaryKey = 'time_registry_id';

	protected $fillable = ['status', 'start_timestamp', 'end_timestamp', 'user_id', 'status_id', 'ip'];

	public function scopeUserId($query, $user_id){
		return $query->where('user_id', '=', $user_id);
	}
}
