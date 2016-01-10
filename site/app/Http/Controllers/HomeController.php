<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use Facebook\Facebook;

class HomeController extends Controller
{

    /**
     * @author: lmkhang (skype)
     * @date: 2015-12-26
     *
     * Home - Master
     */

    public function index(Request $request)
    {
        $get = $request->all();
        $refer = isset($get['refer']) ? $get['refer'] : '';

        //Preparing link for JOINING US
        $joinus = [
            'logged' => false,
            'url_join' => '',
            'url_logout' => '/logout',
        ];
        //get Info of Site
        $description = \App\Config::where(['prefix' => 'site', 'name' => 'description', 'del_flg' => 1])->get()[0]['value'];
        $keywords = \App\Config::where(['prefix' => 'site', 'name' => 'keywords', 'del_flg' => 1])->get()[0]['value'];
        $skype = \App\Config::where(['prefix' => 'social_ntw', 'name' => 'skype', 'del_flg' => 1])->get()[0]['value'];
        $fb = \App\Config::where(['prefix' => 'social_ntw', 'name' => 'fb', 'del_flg' => 1])->get()[0]['value'];
        $google = \App\Config::where(['prefix' => 'social_ntw', 'name' => 'google', 'del_flg' => 1])->get()[0]['value'];
        $pinterest = \App\Config::where(['prefix' => 'social_ntw', 'name' => 'pinterest', 'del_flg' => 1])->get()[0]['value'];
        $twitter = \App\Config::where(['prefix' => 'social_ntw', 'name' => 'twitter', 'del_flg' => 1])->get()[0]['value'];
        $tumblr = \App\Config::where(['prefix' => 'social_ntw', 'name' => 'tumblr', 'del_flg' => 1])->get()[0]['value'];
        $dribbble = \App\Config::where(['prefix' => 'social_ntw', 'name' => 'dribbble', 'del_flg' => 1])->get()[0]['value'];
        $contact_email = \App\Config::where(['prefix' => 'site', 'name' => 'contact_email', 'del_flg' => 1])->get()[0]['value'];

        $site = [
            'description' => $description,
            'keywords' => $keywords,
            'contact_email' => $contact_email,
            'urlhome' => config('app.url'),
            'refer' => $refer,
            'message' => $this->hasFlash('message') ? $this->getFlash('message') : '',
        ];

        $socialntw = [
            'skype' => $skype,
            'fb' => $fb,
            'google' => $google,
            'pinterest' => $pinterest,
            'twitter' => $twitter,
            'tumblr' => $tumblr,
            'dribbble' => $dribbble
        ];

        $daily = ['url_join' => ''];
        $fbook = ['url_join' => '', 'url_callback' => '', 'api_key' => ''];
        $google = ['url_join' => ''];


        //Check Logged
        if ($this->isLogged()) {
            $joinus['logged'] = true;
        } else {
            //get Info of Dailymotion's API
            $daily['api_key'] = \App\Config::where(['prefix' => 'daily', 'name' => 'api_key', 'del_flg' => 1])->get()[0]['value'];
            $daily['url_callback'] = \App\Config::where(['prefix' => 'daily', 'name' => 'url_callback', 'del_flg' => 1])->get()[0]['value'];
//        $daily['url_join'] = 'http://www.dailymotion.com/logout?urlback=' . urlencode(str_replace(array('{API_KEY}', '{URL_CALLBACK}'), array($daily['api_key'], $site['urlhome'] . $daily['url_callback']), \App\Config::where(['prefix' => 'daily', 'name' => 'url_join', 'del_flg' => 1])->get()[0]['value']));
            $daily['url_join'] = str_replace(array('{API_KEY}', '{URL_CALLBACK}'), array($daily['api_key'], $site['urlhome'] . $daily['url_callback']), \App\Config::where(['prefix' => 'daily', 'name' => 'url_join', 'del_flg' => 1])->get()[0]['value']);

            //get Info of FB's API
            $fbook['api_key'] = \App\Config::where(['prefix' => 'fb', 'name' => 'api_key', 'del_flg' => 1])->get()[0]['value'];
            $fbook['api_secret'] = \App\Config::where(['prefix' => 'fb', 'name' => 'api_secret', 'del_flg' => 1])->get()[0]['value'];
            $fbook['scope'] = \App\Config::where(['prefix' => 'fb', 'name' => 'scope', 'del_flg' => 1])->get()[0]['value'];
            $fbook['url_callback'] = \App\Config::where(['prefix' => 'fb', 'name' => 'url_callback', 'del_flg' => 1])->get()[0]['value'];

            $fb = new Facebook([
                'app_id' => $fbook['api_key'],
                'app_secret' => $fbook['api_secret'],
            ]);

            $helper = $fb->getRedirectLoginHelper();

            $permissions = explode(',', $fbook['scope']); // Optional permissions
            $fbook['url_join'] = htmlspecialchars($helper->getLoginUrl(config('app.url') . $fbook['url_callback'], $permissions));

            //get Info of Google's API
            $google['api_key'] = \App\Config::where(['prefix' => 'google', 'name' => 'api_key', 'del_flg' => 1])->get()[0]['value'];
            $google['client_id'] = \App\Config::where(['prefix' => 'google', 'name' => 'client_id', 'del_flg' => 1])->get()[0]['value'];
            $google['client_secret'] = \App\Config::where(['prefix' => 'google', 'name' => 'client_secret', 'del_flg' => 1])->get()[0]['value'];
            $google['scope'] = \App\Config::where(['prefix' => 'google', 'name' => 'scope', 'del_flg' => 1])->get()[0]['value'];
            $google['url_callback'] = \App\Config::where(['prefix' => 'google', 'name' => 'url_callback', 'del_flg' => 1])->get()[0]['value'];

            $client_id = $google['client_id'];
            $client_secret = $google['client_secret'];
            $redirect_uri = config('app.url') . $google['url_callback'];
            $simple_api_key = $google['api_key'];

            //Create Client Request to access Google API
            $client = new \Google_Client();
            $client->setApplicationName("PHP Google OAuth Login Example");
            $client->setClientId($client_id);
            $client->setClientSecret($client_secret);
            $client->setRedirectUri($redirect_uri);
            $client->setDeveloperKey($simple_api_key);
            $client->addScope(explode(',', $google['scope']));

            //Send Client Request
            $objOAuthService = new \Google_Service_Oauth2($client);

            //Get User Data from Google Plus
            //If New, Insert to Database
            if (!$client->getAccessToken()) {
                $google['url_join'] = $client->createAuthUrl();
            }
        }

        return view('home.index')->with(
            [
                'joinus' => $joinus,
                'site' => $site,
                'socialntw' => $socialntw,
                'daily' => $daily,
                'fbook' => $fbook,
                'google' => $google,
            ]
        );
    }
}