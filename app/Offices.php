<?php namespace ESP;

use Illuminate\Database\Eloquent\Model;

class Offices extends Model {

	//
	protected $table = 'offices';
	protected $primaryKey = 'office_id';
	
	protected $fillable = ['office_name'];
}
