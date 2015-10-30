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

Route::get('user/dashboard', 'User\DashboardController@index');

Route::get('/logout', function(){
	Auth::logout();
	return redirect('/');
});

Route::get('/user/logout/', function(){
	return redirect('/logout');
});


Route::post('/user/login', 'User\LoginController@authenticate');






Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
