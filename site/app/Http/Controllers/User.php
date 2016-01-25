<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use Mail;
use Validator;
use App\Http\Libraries;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class User extends Controller
{
    /**
     * @author: lmkhang - skype
     * @date: 2015-12-28
     * Logout
     * site_email, site_user_id, registration_system
     */
    public function logout()
    {
        //Check isLogged
        if (!$this->isLogged()) {
            die;
        }

        $session = new \Symfony\Component\HttpFoundation\Session\Session();
        if ($session->has('site_email')) {
            $session->remove('site_email');
        }

        if ($session->has('site_user_id')) {
            $session->remove('site_user_id');
        }

        if ($session->has('site_registration_system')) {
            $session->remove('site_registration_system');
        }

        //Daily
        if ($session->has('daily_login_access_token') && $session->has('daily_login_refresh_token') && $session->has('daily_login_uid')) {
            $session->remove('daily_login_access_token');
            $session->remove('daily_login_refresh_token');
            $session->remove('daily_login_uid');
        }

        //FB
        if ($session->has('fb_access_token')) {
            $session->remove('fb_access_token');
        }

        //Google
        if ($session->has('google_access_token')) {
            $session->remove('google_access_token');
        }
        //set Flash Message
        $this->setFlash('message', 'Logout!');
        return Redirect::intended('/')->with('message', 'Logout!');
    }

    /**
     * @author: lmkhang - skype
     * @date: 2015-12-28
     * Logout
     * site_email, site_user_id, registration_system
     */
    public function login(Request $request)
    {
        //Check isLogged
        if ($this->isLogged()) {
            die;
        }

        $post = $request->all();
        $info = $this->trim_all($post['login']);

        $registration_system = config('constant.registration');

        $username = $this->checkAccount($info, $registration_system['site']);

        //set Session
        if ($username) {
            //Set Session
            $this->setLogSession(
                [
                    'email' => $username->email,
                    'user_id' => $username->user_id,
                    'registration_system' => $username->registration_system
                ]
            );
        }

        //set Flash Message
        $this->setFlash('message', 'Login!');
        return Redirect::intended('/')->with('message', 'Login!');
    }

    /**
     * @author: lmkhang - skype
     * @date: 2015-12-28
     * Getting and Processing registration from Daily API
     *
     */
    public function callback_daily(Request $request)
    {
        //Check isLogged
        if ($this->isLogged()) {
            die;
        }

        $get = $request->all();

        if (isset($get['code']) && $get['code'] != '') {

            $code = $get['code'];
            $api_key = \App\Config::where(['prefix' => 'daily', 'name' => 'api_key', 'del_flg' => 1])->get()[0]['value'];
            $api_secret = \App\Config::where(['prefix' => 'daily', 'name' => 'api_secret', 'del_flg' => 1])->get()[0]['value'];
            $url_callback = \App\Config::where(['prefix' => 'daily', 'name' => 'url_callback', 'del_flg' => 1])->get()[0]['value'];
            $get_token = \App\Config::where(['prefix' => 'daily', 'name' => 'get_token', 'del_flg' => 1])->get()[0]['value'];
            $urlHome = config('app.url');

            $data = [
                'grant_type' => 'authorization_code',
                'client_id' => $api_key,
                'client_secret' => $api_secret,
                'redirect_uri' => $urlHome . $url_callback,
                'code' => $code,
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $get_token);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, count($data));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            $response = curl_exec($ch);
            $error = curl_error($ch);

            curl_close($ch);

            $response = json_decode($response, true);

            if (isset($response['access_token'])) {
                //set Dailymotion Login SESSION
                $session = new \Symfony\Component\HttpFoundation\Session\Session();
                $session->set('daily_login_access_token', $response['access_token']);
                $session->set('daily_login_refresh_token', $response['refresh_token']);
                $session->set('daily_login_uid', $response['uid']);

                //get Info
                $url_get_info = str_replace(['{USER_ID}'], [$response['uid']], \App\Config::where(['prefix' => 'daily', 'name' => 'url_get_info', 'del_flg' => 1])->get()[0]['value']);
                $ch = curl_init();
                $data_auth = [
                    'access_token' => $response['access_token']
                ];

                curl_setopt($ch, CURLOPT_URL, $url_get_info);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POST, count($data_auth));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_auth);

                $response_auth = curl_exec($ch);
                $error_auth = curl_error($ch);

                curl_close($ch);

                $response_auth = json_decode($response_auth, true);

                //Check existed account
                $registration_system = config('constant.registration');
                $user = $this->checkAccountSNS(['username' => $response_auth['username']], $registration_system['dailymotion']);
                if (!$user) {
                    //insert
                    $match = new Libraries\Math();
                    $register['refer'] = $match->to_base(rand(10, 30) . substr(time(), 5, 10) . rand(10, 30), 62) . $match->to_base(rand(100, 300) . substr(time(), 5, 10) . rand(100, 300), 62) . $match->to_base(rand(100, 300) . substr(time(), 5, 10) . rand(100, 300), 62);

                    //from_refer
                    if ($this->hasFlash('refer')) {
                        $register['from_refer'] = $this->getFlash('refer');
                    } else {
                        $register['from_refer'] = 'no_refer';
                    }
                    $message_refer = $this->checkUserAttributes($register);

                    $user = new \App\User;
                    $user->refer = $register['refer'];
                    $user->from_refer = !$message_refer ? $register['from_refer'] : '';
                    $user->username = $response_auth['username'];
                    $user->country = $response_auth['country'];
                    $user->first_name = $response_auth['first_name'];
                    $user->last_name = $response_auth['last_name'];
                    $user->full_name = $response_auth['fullname'];
                    $user->gavatar = str_replace('\\', '', $response_auth['avatar_120_url']);
                    $user->email = '';//$response_auth['email'];
                    $user->del_flg = 1;
                    $user->registration_system = $registration_system['dailymotion'];
                    $user->save();

                    //Insert User Stats
                    $user_stats = new \App\UserStats;
                    $user_stats->user_id = $user->user_id;
                    $user_stats->total = 0;
                    $user_stats->del_flg = $user->del_flg;
                    $user_stats->save();
                }

                //Set Session
                $this->setLogSession(
                    [
                        'email' => $user->email,
                        'user_id' => $user->user_id,
                        'registration_system' => $user->registration_system
                    ]
                );
                //set Flash Message
                $this->setFlash('message', 'Login!');
                return Redirect::intended('/')->with('message', 'Login!');
            }
        }
        //set Flash Message
        $this->setFlash('message', 'Error!');
        return Redirect::intended('/')->with('message', 'Error!');
    }

    /**
     * @author: lmkhang - skype
     * @date: 2015-12-28
     * Getting and Processing registration from FB API
     *
     */
    public function callback_facebook(Request $request)
    {
        //Check isLogged
        if ($this->isLogged()) {
            die;
        }

        //get Info of Dailymotion's API
        $fbook['api_key'] = \App\Config::where(['prefix' => 'fb', 'name' => 'api_key', 'del_flg' => 1])->get()[0]['value'];
        $fbook['api_secret'] = \App\Config::where(['prefix' => 'fb', 'name' => 'api_secret', 'del_flg' => 1])->get()[0]['value'];
        $fbook['scope'] = \App\Config::where(['prefix' => 'fb', 'name' => 'scope', 'del_flg' => 1])->get()[0]['value'];
        $fbook['url_callback'] = \App\Config::where(['prefix' => 'fb', 'name' => 'url_callback', 'del_flg' => 1])->get()[0]['value'];

        $fb = new Facebook([
            'app_id' => $fbook['api_key'],
            'app_secret' => $fbook['api_secret'],
            'default_graph_version' => 'v2.5',
        ]);

        $helper = $fb->getJavaScriptHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (FacebookResponseException $e) {
            // When Graph returns an error
            return Redirect::intended('/')->with('message', 'Hacking!!!!');
        } catch (FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (!isset($accessToken)) {
            echo 'No cookie set or no OAuth data could be obtained from cookie.';
            exit;
        }

        // Logged in
        if ($accessToken) {
            //set Facebook Login SESSION
            $session = new \Symfony\Component\HttpFoundation\Session\Session();
            $session->set('fb_access_token', (string)$accessToken);

            //get Info of User
            $fb->setDefaultAccessToken((string)$accessToken);

            #These will fall back to the default access token
            try {
                $res = $fb->get('/me?fields=id,name,email,first_name,last_name');
            } catch (FacebookSDKException $e) {
                echo $e->getMessage();
            }
            $user_get = $res->getGraphObject();

            //Check existed account
            $registration_system = config('constant.registration');
            $user = $this->checkAccountSNS(['username' => $user_get->getField('id')], $registration_system['facebook']);
            if (!$user) {
                //insert
                $match = new Libraries\Math();
                $register['refer'] = $match->to_base(rand(10, 30) . substr(time(), 5, 10) . rand(10, 30), 62) . $match->to_base(rand(100, 300) . substr(time(), 5, 10) . rand(100, 300), 62) . $match->to_base(rand(100, 300) . substr(time(), 5, 10) . rand(100, 300), 62);

                //from_refer
                if ($this->hasFlash('refer')) {
                    $register['from_refer'] = $this->getFlash('refer');
                } else {
                    $register['from_refer'] = 'no_refer';
                }
                $message_refer = $this->checkUserAttributes($register);

                $user = new \App\User;
                $user->refer = $register['refer'];
                $user->from_refer = !$message_refer ? $register['from_refer'] : '';
                $user->username = $user_get->getField('id');
                $user->first_name = $user_get->getField('first_name');
                $user->last_name = $user_get->getField('last_name');
                $user->full_name = $user_get->getField('name');
                $user->email = '';//$user_get->getField('email');
                $user->del_flg = 1;
                $user->registration_system = $registration_system['facebook'];
                $user->save();

                //Insert User Stats
                $user_stats = new \App\UserStats;
                $user_stats->user_id = $user->user_id;
                $user_stats->total = 0;
                $user_stats->del_flg = $user->del_flg;
                $user_stats->save();
            }

            //Set Session
            $this->setLogSession(
                [
                    'email' => $user->email,
                    'user_id' => $user->user_id,
                    'registration_system' => $user->registration_system
                ]
            );
            //set Flash Message
            $this->setFlash('message', 'Login!');
            return Redirect::intended('/')->with('message', 'Login!');
        }

        //set Flash Message
        $this->setFlash('message', 'Error!');
        return Redirect::intended('/')->with('message', 'Error!');
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-05
     * Getting and Processing registration from GG API
     *
     */
    public function callback_google()
    {
        //Check isLogged
        if ($this->isLogged()) {
            die;
        }

        $session = new \Symfony\Component\HttpFoundation\Session\Session();
        //get Info of Google's API
        $google['api_key'] = \App\Config::where(['prefix' => 'google', 'name' => 'api_key', 'del_flg' => 1])->get()[0]['value'];
        $google['client_id'] = \App\Config::where(['prefix' => 'google', 'name' => 'client_id', 'del_flg' => 1])->get()[0]['value'];
        $google['client_secret'] = \App\Config::where(['prefix' => 'google', 'name' => 'client_secret', 'del_flg' => 1])->get()[0]['value'];
        $google['scope'] = \App\Config::where(['prefix' => 'google', 'name' => 'scope', 'del_flg' => 1])->get()[0]['value'];
        $google['url_callback'] = \App\Config::where(['prefix' => 'google', 'name' => 'url_callback', 'del_flg' => 1])->get()[0]['value'];

        //Create Client Request to access Google API
        $client = new \Google_Client();
        $client->setApplicationName("Media Center Network");
        $client->setClientId($google['client_id']);
        $client->setClientSecret($google['client_secret']);
        $client->setRedirectUri(config('app.url') . $google['url_callback']);
        $client->setDeveloperKey($google['api_key']);
        $client->addScope(explode(',', $google['scope']));

        //Send Client Request
        $objOAuthService = new \Google_Service_Oauth2($client);

        //Authenticate code from Google OAuth Flow
        //Add Access Token to Session
        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            //set Facebook Login SESSION
            $session->set('google_access_token', $client->getAccessToken());
            return redirect(filter_var(config('app.url') . $google['url_callback'], FILTER_SANITIZE_URL));
        }

        //Set Access Token to make Request
        if ($session->has('google_access_token')) {
            $client->setAccessToken($session->get('google_access_token'));
        }

        //Get User Data from Google Plus
        //If New, Insert to Database
        if ($client->getAccessToken()) {

            $userData = $objOAuthService->userinfo->get();
            $user_get = get_object_vars($userData);

            if ($user_get && is_array($user_get)) {
                //Check existed account
                $registration_system = config('constant.registration');
                $user = $this->checkAccountSNS(['username' => $user_get['id']], $registration_system['google']);

                if (!$user) {
                    //insert
                    $match = new Libraries\Math();
                    $register['refer'] = $match->to_base(rand(10, 30) . substr(time(), 5, 10) . rand(10, 30), 62) . $match->to_base(rand(100, 300) . substr(time(), 5, 10) . rand(100, 300), 62) . $match->to_base(rand(100, 300) . substr(time(), 5, 10) . rand(100, 300), 62);

                    //from_refer
                    if ($this->hasFlash('refer')) {
                        $register['from_refer'] = $this->getFlash('refer');
                    } else {
                        $register['from_refer'] = 'no_refer';
                    }
                    $message_refer = $this->checkUserAttributes($register);

                    $user = new \App\User;
                    $user->refer = $register['refer'];
                    $user->from_refer = !$message_refer ? $register['from_refer'] : '';
                    $user->username = $user_get['id'];
                    $user->first_name = $user_get['givenName'];
                    $user->last_name = $user_get['familyName'];
                    $user->full_name = $user_get['name'];
                    $user->email = '';//$user_get['email'];
                    $user->gavatar = $user_get['picture'];
//                    $user->country = strtoupper($user_get['locale']);
                    $user->del_flg = 1;
                    $user->registration_system = $registration_system['google'];
                    $user->save();

                    //Insert User Stats
                    $user_stats = new \App\UserStats;
                    $user_stats->user_id = $user->user_id;
                    $user_stats->total = 0;
                    $user_stats->del_flg = $user->del_flg;
                    $user_stats->save();
                }

                //Set Session
                $this->setLogSession(
                    [
                        'email' => $user->email,
                        'user_id' => $user->user_id,
                        'registration_system' => $user->registration_system
                    ]
                );
                //set Flash Message
                $this->setFlash('message', 'Login!');
//                return Redirect::intended('/')->with('message', 'Register successfully!');
            }
        }
//        return Redirect::intended('/')->with('message', 'Back Home!');
        if (!$this->hasFlash('message')) {
            //set Flash Message
            $this->setFlash('message', 'Error!');
        }
        return redirect('/');
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-04
     * Activating User
     */
    public function activate_registration($code)
    {
        //Check isLogged
        if ($this->isLogged()) {
            die;
        }

        $hours = \App\Config::where(['prefix' => 'site', 'name' => 'active_expire', 'del_flg' => 1])->get()[0]['value'];
        $date = date('Y-m-d H:i:s', strtotime("-" . $hours . " hours", time()));
        $code = $code ? $this->trim($code) : '';
        if ($code) {

            $registration_system = config('constant.registration');

            $username = \App\User::select('user_id', 'email', 'registration_system')->whereRaw('registration_system = ? AND status = ? AND del_flg = ? AND active_code = ? AND ? <= DATE_FORMAT(`created_at`, "%Y-%m-%d %T")', [$registration_system['site'], 1, 0, $code, "'" . $date . "'"])->first();
            if ($username) {
                //Check existed email
                $message = $this->checkUserAttributes(['email' => $username->email], $registration_system['site']);
                if (!$message) {
                    //Activate Account
                    $username->del_flg = 1;
                    $username->active_code = '';
                    $username->save();

                    //Update User Stats
                    $user_stats = \App\UserStats::find($username['user_id']);
                    $user_stats->del_flg = 1;
                    $user_stats->save();

                    //Set Session
                    $this->setLogSession(
                        [
                            'email' => $username->email,
                            'user_id' => $username->user_id,
                            'registration_system' => $username->registration_system
                        ]
                    );
                    //set Flash Message
                    $this->setFlash('message', 'Activate successfully!');
                    return Redirect::intended('/')->with('message', 'Activate successfully!');
                }
            }
        }
        //Error..
        //do something

    }

    /**
     * @author: lmkhang - skype
     * @date: 2015-12-30
     * Register USER
     */
    public function create_registration(Request $request)
    {
        //Check isLogged
        if ($this->isLogged()) {
            die;
        }

        //Post
        $post = $request->all();
        $register = $post['register'];

        //Trim
        $register = $this->trim_all($register);

        //Setup validation
        $validator = Validator::make(
            $register,
            [
                'username' => 'required|min:5|max:50',
                'pin_code' => 'required|min:6|max:6|digits:6',
                'email' => 'required|email|min:5|max:100',
                'password' => 'required|min:5|max:50',
                'repeat_password' => 'required|same:password',
                'first_name' => 'required|min:2|max:50',
                'last_name' => 'required|min:2|max:50',
            ]
        );

        // Optionally customize this version using new ->after()
        /*$validator->after(function() use ($validator) {
            // Do more validation

            $validator->errors()->add('field', 'new error');
        });*/

        //Checking
        if ($validator->fails()) {
            // The given data did not pass validation
//            $session = new \Symfony\Component\HttpFoundation\Session\Session();
//            $session->set('messages', $validator->errors());
            //set Flash Message
            $this->setFlash('message', 'Errors!');
            return redirect()->back();
        }

        //Check some existed attributes
        $registration_system = config('constant.registration');
        $msg_attributes = $this->checkUserAttributes($register, $registration_system['site']);
        if ($msg_attributes) {
            //set Flash Message
            $this->setFlash('message', 'Errors!');
            return redirect()->back();
        }

        //Success
        unset($register['repeat_password']);
        $match = new Libraries\Math();
        $register['refer'] = $match->to_base(rand(10, 30) . substr(time(), 5, 10) . rand(10, 30), 62) . $match->to_base(rand(100, 300) . substr(time(), 5, 10) . rand(100, 300), 62) . $match->to_base(rand(100, 300) . substr(time(), 5, 10) . rand(100, 300), 62);

        $salt = \App\Config::where(['prefix' => 'site', 'name' => 'salt', 'del_flg' => 1])->get()[0]['value'];

        $user = new \App\User;
        $user->refer = $register['refer'];
        $user->from_refer = $register['from_refer'];
        $user->password = $this->encryptString($register['password'], $salt);
        $user->username = $register['username'];
        $user->pin_code = $this->encryptString($register['pin_code'], $salt);
        $user->active_code = $match->to_base(rand(10, 30) . substr(time(), 5, 10) . rand(10, 30), 62) . $this->encryptString(rand(111, 999) . rand(1111, 9999), $salt) . $this->encryptString(time(), $salt) . $match->to_base(rand(10, 30) . substr(time(), 5, 10) . rand(10, 30), 62);
        $user->first_name = $register['first_name'];
        $user->last_name = $register['last_name'];
        $user->email = $register['email'];
        $user->save();

        //Insert User Stats
        $user_stats = new \App\UserStats;
        $user_stats->user_id = $user->user_id;
        $user_stats->total = 0;
        $user_stats->save();

        //Send mail
        $this->_sendmail_registration($user);

        //set Flash Message
        $this->setFlash('message', 'Please confirm from email ' . $register['email'] . '!');
        return Redirect::intended('/')->with('message', 'Please confirm from email ' . $register['email'] . '!');
    }

    /**
     * @author: lmkhang - skype
     * @date: 2015-12-27
     * Send Mail
     *
     */
    private function _sendmail_registration($user)
    {
        //Check isLogged
        if ($this->isLogged()) {
            die;
        }

        $active_link = config('app.url') . '/user/active/' . $user->active_code;
        $sender_info = config('constant.confirmation');

        $to_address = $user->email;
        $to_name = $user->first_name . ' ' . $user->last_name;
        $from_address = $sender_info['email'];
        $from_name = $sender_info['name'];
        $subject = $sender_info['subject'];
        $content = str_replace(array('{full_name}', '{activated_link}'), array($to_name, $active_link), $sender_info['content']);
        $pathToFile = config('app.url') . '/download/term_of_site.pdf';

        try {
            Mail::send('emails.contact', array(
                'subject' => $subject,
                'message' => $content,
            ), function ($message) use ($to_address, $to_name, $from_address, $from_name, $subject, $content, $pathToFile) {
                // note: if you don't set this, it will use the defaults from config/mail.php
                $message->from($from_address, $from_name);
                $message->attach($pathToFile);
                $message->to($to_address, $to_name)
                    ->subject($subject)
                    ->setBody($content);
            });
        } catch (\Exception $e) {

        }
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-08
     * Forgot Password
     */
    public function forgot(Request $request)
    {
        //Check isLogged
        if ($this->isLogged()) {
            die;
        }

        //Post
        $post = $request->all();
        $forgot = $post['forgot'];

        //Trim
        $forgot = $this->trim_all($forgot);

        //Setup validation
        $validator = Validator::make(
            $forgot,
            [
                'email' => 'required|email|min:5|max:100',
            ]
        );

        // Optionally customize this version using new ->after()
        /*$validator->after(function() use ($validator) {
            // Do more validation

            $validator->errors()->add('field', 'new error');
        });*/

        //Checking
        if ($validator->fails()) {
            // The given data did not pass validation
//            $session = new \Symfony\Component\HttpFoundation\Session\Session();
//            $session->set('messages', $validator->errors());
            //set Flash Message
            $this->setFlash('message', 'Errors!');
            return redirect()->back();
        }

        //Check some existed attributes
        $registration_system = config('constant.registration');
        $msg_attributes = $this->checkUserAttributes($forgot, $registration_system['site']);
        if (!$msg_attributes) {
            //set Flash Message
            $this->setFlash('message', 'Errors!');
            return redirect()->back();
        }

        //Success
        $user = new \App\User();
        $user = $user->getAccountByEmail($forgot['email']);

        if ($user) {
            $salt = \App\Config::where(['prefix' => 'site', 'name' => 'salt', 'del_flg' => 1])->get()[0]['value'];

            $pwd = rand(1111111, 999999999);
            $user->password = $this->encryptString($pwd, $salt);
            $user->save();

            //Send mail
            $this->_sendmail_forgot($user, $pwd);
        }

        //set Flash Message
        $this->setFlash('message', 'Please check password in email ' . $forgot['email'] . '!');
        return Redirect::intended('/')->with('message', 'Please check password in email ' . $forgot['email'] . '!');
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-08
     * Send Mail - Forgot Password
     *
     */
    private function _sendmail_forgot($user, $pwd)
    {
        //Check isLogged
        if ($this->isLogged()) {
            die;
        }

        $sender_info = config('constant.forgot');

        $to_address = $user->email;
        $to_name = $user->first_name . ' ' . $user->last_name;
        $from_address = $sender_info['email'];
        $from_name = $sender_info['name'];
        $subject = $sender_info['subject'];
        $content = str_replace(array('{full_name}', '{password}'), array($to_name, $pwd), $sender_info['content']);

        try {
            Mail::send('emails.contact', array(
                'subject' => $subject,
                'message' => $content,
            ), function ($message) use ($to_address, $to_name, $from_address, $from_name, $subject, $content) {
                // note: if you don't set this, it will use the defaults from config/mail.php
                $message->from($from_address, $from_name);
                $message->to($to_address, $to_name)
                    ->subject($subject)
                    ->setBody($content);
            });
        } catch (\Exception $e) {

        }
    }
}
