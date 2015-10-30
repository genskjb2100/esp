<?php namespace ESP;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model {

	//
	protected $table = 'schedules';
	protected $fillable = ['flexi', 'user_id', 'mon_start', 'mon_stop', 'tue_start', 'tue_stop', 'wed_start', 'wed_stop', 'thu_start', 'thu_stop', 'fri_start', 'fri_stop', 'sat_start', 'sat_stop', 'sun_start', 'sun_stop', 'grace_period_id'];
	public $timestamps = false;

}
