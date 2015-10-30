<?php namespace ESP;

use Illuminate\Database\Eloquent\Model;

class CompanyOffice extends Model {

	//
	protected $table = 'company_office';
	protected $fillable = ['company_id', 'office_id'];
	public $timestamps = false;
}
