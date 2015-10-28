<?php namespace ESP;

use Illuminate\Database\Eloquent\Model;
use DB;

class LoginAttempts extends Model {

	//
 	protected $table = 'login_attempts';
    protected $primaryKey = 'id';

    protected $fillable = ['attempt_status', 'ip', 'attempts', 'failed_last_login', 'success_last_login', 'username', 'login_page_name'];

    public function scopeIP($query, $ip) {
        return $query->where('ip', '=', $ip);
    }

    public function scopeUsername($query, $username) {
        return $query->where('username', '=', $username);
    }

    public function scopeLastLogin($query, $date) {
        return $query->where('last_login', 'LIKE', "$date%");
    }

    public function scopeClientEmail($query, $client_email) {
        return $query->where('username', '=', $client_email);
    }
}
