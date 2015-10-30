<?php namespace ESP;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $primaryKey = 'id';
	protected $fillable = ['username', 'email', 'password', 'client_email', 'client_password', 'first_name', 'last_name', 'skype', 'phone', 'position', 'user_auth', 'nickname', 'birthdate', 'hidden', 'refresh', 'expand_all', 'work_from_home', 'office_id'];
	protected $guarded = ['id'];
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function scopeUsername($query, $username){
		return $query->where('username', '=', $username);
	}

	public function scopePassword($query, $password){
		return $query->where('password', '=', $password);
	}

	public static function get_employee_username_password($username, $password) {
		return DB::table('users as u')
				->join('role_user as ur', 'ur.user_id', '=', 'u.id')
				->select('u.*','ur.role_id')
				->where('ur.role_id', '=', 3)
				->where('u.username', '=', $username)
				->where('u.password', '=', $password)
				->first();
	}

	public static function getByUsername($username){
		return DB::table('users')->select('*')->where('username', '=', $username)->first();
	}

}
