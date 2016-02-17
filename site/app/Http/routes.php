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
Route::get('/', [
    'as' => 'home_page', 'uses' => 'HomeController@index'
]);

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
Route::get('/logout', [
    'as' => 'logout', 'uses' => 'User@logout'
]);

//Forgot Password
Route::post('/forgot', 'User@forgot');
Route::post('/user/checking/forgot', 'Ajax@forgot');

//Callback From Daily API
Route::get('/dailymotion/register', 'User@callback_daily');

//Callback From FB API
Route::get('/facebook/register', 'User@callback_facebook');

//Callback From GG API
Route::get('/google/register', 'User@callback_google');


// ===============================================
// DASHBOARD SECTION =================================
// ===============================================
Route::group(array('prefix' => 'dashboard', 'namespace' => 'Dashboard', 'as' => 'dashboard', 'middleware' => 'check_auth'), function () {
    // Home
    Route::get('/', [
        'as' => 'home_dashboard', 'uses' => 'Home@index'
    ]);
    // Sign Contract
    Route::get('/sign_contract', [
        'as' => 'sign_contract', 'uses' => 'Unverify@sign_contract'
    ]);

    Route::post('/sign_contract/send', [
        'as' => 'sign_contract_send', 'uses' => 'Unverify@send'
    ]);

    Route::post('/checking/sign_contract', [
        'as' => 'sign_contract_checking', 'uses' => 'Ajax@checkSignContract'
    ]);

    Route::get('/payment/sign_contract/active/{code}', [
        'as' => 'sign_contract_active', 'uses' => 'Unverify@activeSignContract'
    ]);

    //Profile
    Route::get('/profile', [
        'as' => 'profile', 'uses' => 'User@profile'
    ]);

    Route::post('/profile/change', [
        'as' => 'profile_change', 'uses' => 'User@profile_change'
    ]);

    Route::post('/profile/change/password', [
        'as' => 'profile_change_password', 'uses' => 'User@profile_change_password'
    ]);

    Route::post('/payment/change', [
        'as' => 'payment_change', 'uses' => 'User@payment_change'
    ]);

    //Channel
    Route::group(array('prefix' => 'channels', 'namespace' => 'Channels', 'as' => 'channels'), function () {
        //Home
        Route::get('/', [
            'as' => 'channels', 'uses' => 'Channels@index'
        ]);
        //Callback From Daily API
        Route::get('/dailymotion/add', [
            'as' => 'add_new_channels', 'uses' => 'Channels@callback_daily_channel'
        ]);
        //Detail
        Route::get('/{daily_channel_id}/detail', [
            'as' => 'channel_detail', 'uses' => 'Channels@detail'
        ]);

    });


});


// ===============================================
// ADMIN SECTION =================================
// ===============================================
//Create pws
Route::get('/adminntw/create_pwd/{pwd}', [
    'as' => 'adminntw_create_pwd', 'uses' => 'Admin@create_pwd'
]);

// Login
Route::get('/adminntw/login', [
    'as' => 'adminntw_login', 'uses' => 'Admin@index'
]);

Route::post('/adminntw/checking/login', [
    'as' => 'adminntw_checking_login', 'uses' => 'Ajax@admin_login'
]);

Route::post('/adminntw/login', [
    'as' => 'adminntw_login_action', 'uses' => 'Admin@login'
]);

Route::get('/adminntw/logout', [
    'as' => 'adminntw_logout', 'uses' => 'Admin@logout'
]);

Route::group(array('prefix' => 'adminntw', 'namespace' => 'Admin', 'as' => 'adminntw', 'middleware' => 'check_admin_auth'), function () {


    // Home
    Route::get('/', [
        'as' => 'home_dashboard', 'uses' => 'Home@index'
    ]);
    // Sign Contract
    Route::get('/sign_contract', [
        'as' => 'sign_contract', 'uses' => 'Unverify@sign_contract'
    ]);

    Route::post('/sign_contract/send', [
        'as' => 'sign_contract_send', 'uses' => 'Unverify@send'
    ]);

    Route::post('/checking/sign_contract', [
        'as' => 'sign_contract_checking', 'uses' => 'Ajax@checkSignContract'
    ]);

    Route::get('/payment/sign_contract/active/{code}', [
        'as' => 'sign_contract_active', 'uses' => 'Unverify@activeSignContract'
    ]);

    //Profile
    Route::get('/profile', [
        'as' => 'profile', 'uses' => 'User@profile'
    ]);

    Route::post('/profile/change', [
        'as' => 'profile_change', 'uses' => 'User@profile_change'
    ]);

    Route::post('/profile/change/password', [
        'as' => 'profile_change_password', 'uses' => 'User@profile_change_password'
    ]);

    //Setting
    Route::get('/setting', [
        'as' => 'setting', 'uses' => 'Setting@index'
    ]);

    Route::post('/setting/change', [
        'as' => 'setting_change', 'uses' => 'Setting@change'
    ]);

    //Channel
    Route::group(array('prefix' => 'channels', 'namespace' => 'Channels', 'as' => 'channels'), function () {
        //Home
        Route::get('/', [
            'as' => 'channels', 'uses' => 'Channels@index'
        ]);
        //Callback From Daily API
        Route::get('/dailymotion/add', [
            'as' => 'add_new_channels', 'uses' => 'Channels@callback_daily_channel'
        ]);


        //Change status of channel
        Route::get('/status/{channel_id}/{status}/{date}', [
            'as' => 'channel_change_status', 'uses' => 'Channels@change_status'
        ]);

        //Decline status of channel
        Route::post('/change_multi', [
            'as' => 'channel_change_multi', 'uses' => 'Channels@change_multi'
        ]);

        //Detail
        Route::get('/{daily_channel_id}/detail', [
            'as' => 'channel_detail', 'uses' => 'Channels@detail'
        ]);

        //Remove
        Route::get('/remove/{channel_id}', [
            'as' => 'channel_remove', 'uses' => 'Channels@remove'
        ]);

    });

    //Statistics
    Route::group(array('prefix' => 'stats', 'namespace' => 'Stats', 'as' => 'stats'), function () {
        //Home
        Route::get('/', [
            'as' => 'stats', 'uses' => 'Stats@index'
        ]);

        Route::post('/import', [
            'as' => 'stats_import', 'uses' => 'Stats@import'
        ]);

        Route::get('/update', [
            'as' => 'stats_update', 'uses' => 'Stats@update'
        ]);

        Route::get('/detail', [
            'as' => 'stats_detail', 'uses' => 'Stats@detail'
        ]);

    });

    //Member
    Route::group(array('prefix' => 'members', 'namespace' => 'Members', 'as' => 'members'), function () {
        //Home
        Route::get('/', [
            'as' => 'members_home', 'uses' => 'Members@index'
        ]);

        //Detail
        Route::get('/{user_id}/detail', [
            'as' => 'members_detail', 'uses' => 'Members@detail'
        ]);

    });

    //Adjust
    Route::post('/member/adjust', [
        'as' => 'member_adjust', 'uses' => 'Ajax@member_adjust'
    ]);

});

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


