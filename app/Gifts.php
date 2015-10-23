<?php namespace ESP;

use Illuminate\Database\Eloquent\Model;
use DB;

class Gifts extends Model {

	//
	protected $primaryKey = 'gift_id';

	protected $fillable = ['gift_name', 'description', 'hidden', 'img_path', 'img_thumb', 'price', 'visible'];

}
