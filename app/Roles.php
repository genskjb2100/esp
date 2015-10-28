<?php namespace ESP;

use Illuminate\Database\Eloquent\Model;
use DB;

class Roles extends Model {

	//
	protected $primaryKey = 'role_id';

	protected $fillable = ['role_name', 'role_description'];

	public function users(){
		return $this->belongsToMany('user');
	}
}
