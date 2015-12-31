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
Route::post('/register', 'Common@register');
Route::post('/user/checking', 'Ajax@checkRegister');

//Logout
Route::get('/logout', 'HomeController@logout');

//Callback From Daily API
Route::get('/dailymotion/register', 'HomeController@callback_daily');

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

