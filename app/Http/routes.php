<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*user route collection */
Route::get('/', function(){
	if (Auth::check()):
        return redirect('user/dashboard');
    else:
        return View::make('user.user_login');
    endif;
});
Route::get('/user/login/', function(){
	return redirect('/');
});
Route::any('/user/', function(){
	return redirect('/');
});
Route::any('/user/request_amendment', 'User\DashboardController@request_amendment');
Route::get('user/dashboard', 'User\DashboardController@index');
Route::post('user/time_entry', 'User\DashboardController@time_entry');
Route::post('/user/login', 'User\LoginController@authenticate');

Route::get('/logout', function(){
	Auth::logout();
	Session::flush();
	return redirect('/');
});
Route::get('/user/logout/', function(){
	return redirect('/logout');
});
Route::get('/client/logout/', function(){
	return redirect('/logout');
});



Route::get('/testldap/', 'User\DashboardController@testLdap');

Route::get('/client/', 'Client\LoginController@index');
Route::post('/client/login', 'Client\LoginController@authenticate');
Route::get('/client/dashboard', function(){
	print_r(Session::all());
});
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
