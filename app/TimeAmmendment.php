<?php namespace ESP;

use Illuminate\Database\Eloquent\Model;

class TimeAmmendment extends Model {

	protected $table = 'time_ammendments';
	protected $primaryKey = 'time_ammendment_id';

	protected $fillable = ['status', 'original_start', 'original_finish', 'ammended_start', 'ammended_finish', 'user_notes', 'time_registry_id', 'hr_comments', 'user_id'];

}
