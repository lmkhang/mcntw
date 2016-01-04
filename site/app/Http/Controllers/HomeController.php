<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;

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

        //get Info of API
        $daily['api_key'] = \App\Config::where(['prefix' => 'daily', 'name' => 'api_key', 'del_flg' => 1])->get()[0]['value'];
        $daily['url_callback'] = \App\Config::where(['prefix' => 'daily', 'name' => 'url_callback', 'del_flg' => 1])->get()[0]['value'];
        $daily['url_join'] = 'http://www.dailymotion.com/logout?urlback=' . urlencode(str_replace(array('{API_KEY}', '{URL_CALLBACK}'), array($daily['api_key'], $site['urlhome'] . $daily['url_callback']), \App\Config::where(['prefix' => 'daily', 'name' => 'url_join', 'del_flg' => 1])->get()[0]['value']));


//        $urlHome = config('app.url');
        $session = new \Symfony\Component\HttpFoundation\Session\Session();

        //Check Logged
        if ($this->isLogged()) {
            $joinus['logged'] = true;
        } else {
//            $joinus['url_join'] = str_replace(array('{API_KEY}', '{URL_CALLBACK}'), array($api_key, $urlHome . $url_callback), $url_oauth);
        }

        return view('home.index')->with(
            [
                'joinus' => $joinus,
                'site' => $site,
                'socialntw' => $socialntw,
                'daily' => $daily,
            ]
        );
    }
}