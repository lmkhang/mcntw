<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//Home
Route::get('/', 'HomeController@index');

//Send mail
Route::post('/sendmail', 'Common@sendmail');

//Register
Route::post('/register', 'User@create_registration');
Route::post('/user/checking', 'Ajax@check_registration');
Route::post('/user/checking/login', 'Ajax@check_login');
Route::get('/user/active/{code}', 'User@activate_registration');

//Login
Route::post('/login', 'User@login');

//Logout
Route::get('/logout', 'User@logout');

//Callback From Daily API
Route::get('/dailymotion/register', 'User@callback_daily');
Route::get('/dailymotion/add', 'User@callback_daily_channel');

//Callback From FB API
Route::get('/facebook/register', 'User@callback_facebook');

//Callback From GG API
Route::get('/google/register', 'User@callback_google');
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});


