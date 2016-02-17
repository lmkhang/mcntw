<?php

namespace App\Http\Controllers\Dashboard\Channels;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;

class Channels extends Controller
{
    //Sessions
    //daily_channel_access_token
    //daily_channel_refresh_token
    //daily_channel_uid

    public function __construct()
    {
        parent::__construct();
        //check sign contract?
        if ($this->_user['sign_contract'] == 0) {
            //set Flash Message
            $this->setFlash('message', 'Please sign contract before using full feature of dashboard!');
            $this->_stop = true;
            $this->_redirectTo = '/dashboard/sign_contract';
        }

        //Active page
        $this->_active = 'channels';

        //page url
        $this->_page_url = '/dashboard/channels';
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-09
     * DASHBOARD HOME
     */
    public function index()
    {
        //Check Status
        if ($this->_stop) {
            return Redirect::intended(url($this->_redirectTo));
        }

        //set Title for PAGE
        $this->_page_title = 'Channel Management';

        //get Info of Dailymotion's API
        $daily['api_key'] = \App\Config::where(['prefix' => 'daily', 'name' => 'api_key_channel', 'del_flg' => 1])->get()[0]['value'];
        $daily['url_callback'] = \App\Config::where(['prefix' => 'daily', 'name' => 'url_callback_channel', 'del_flg' => 1])->get()[0]['value'];
        $daily['url_oauth'] = 'http://www.dailymotion.com/logout?urlback=' . urlencode(str_replace(array('{API_KEY}', '{URL_CALLBACK}'), array($daily['api_key'], url($daily['url_callback'])), \App\Config::where(['prefix' => 'daily', 'name' => 'url_add_channel', 'del_flg' => 1])->get()[0]['value']));

        //Get channel list
        $channel_get = new \App\Channels;
        $number_pagination = \App\Config::where(['prefix' => 'site', 'name' => 'pagination', 'del_flg' => 1])->get()[0]['value'];
        $channels_paging = $channel_get->getAllPaging([
            'user_id' => $this->_user_id
        ], $number_pagination);

        //get URL STATS
        $url_stats = \App\Config::where(['prefix' => 'daily', 'name' => 'url_stats', 'del_flg' => 1])->get()[0]['value'];

        return view('dashboard.channels.index', [
            'user' => $this->_user,
            'name' => $this->getName(),
            'page_title' => $this->_page_title,
            'active' => $this->_active,
            'daily' => $daily,
            'number_pagination' => $number_pagination,
            'channels_paging' => $channels_paging,
            'channel_label_status' => config('constant.channel_label_status'),
            'channel_status' => config('constant.channel_status'),
            'url_stats' => $url_stats,
            'no' => 1,
        ]);
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-15
     * Getting and Processing registration from Daily API
     *
     */
    public function callback_daily_channel(Request $request)
    {

        $get = $request->all();

        if (isset($get['code']) && $get['code'] != '') {

            $code = $get['code'];
            $api_key = \App\Config::where(['prefix' => 'daily', 'name' => 'api_key_channel', 'del_flg' => 1])->get()[0]['value'];
            $api_secret = \App\Config::where(['prefix' => 'daily', 'name' => 'api_secret_channel', 'del_flg' => 1])->get()[0]['value'];
            $url_callback = \App\Config::where(['prefix' => 'daily', 'name' => 'url_callback_channel', 'del_flg' => 1])->get()[0]['value'];
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
                $session->set('daily_channel_access_token', $response['access_token']);
                $session->set('daily_channel_refresh_token', $response['refresh_token']);
                $session->set('daily_channel_uid', $response['uid']);

                //get status
                $status = config('constant.channel_status');

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
                $channel_get = new \App\Channels;
                $channel = $channel_get->getChannel($session->get('daily_channel_uid'));
                if (!$channel) {
                    //Insert
                    $channel = new \App\Channels;
                    $channel->user_id = $this->_user_id;
                    $channel->daily_channel_id = $session->get('daily_channel_uid');
                    $channel->daily_channel_username = $response_auth['username'];
                    $channel->daily_channel_name = $response_auth['screenname'];
                    $channel->email = $response_auth['email'];
                    $channel->save();

                    //set Flash Message
                    $this->setFlash('message', 'Add New Channel Successfully!');
                    return Redirect::intended($this->_page_url)->with('message', 'Add New Channel Successfully!');
                } else if ($channel && $channel->user_id == $this->_user_id) {
                    //checking user was changed from dailymotion -> update
                    if ($response_auth['username'] != $channel->daily_channel_username) {
                        $old_username = $channel->daily_channel_username;
                        $channel->daily_channel_username = $response_auth['username'];
                        $channel->save();
                        //set Flash Message
                        $this->setFlash('message', 'The system updated username for your channel from: ' . $old_username . ' to: ' . $response_auth['username']);
                        return Redirect::intended($this->_page_url)->with('message', 'We updated username for your channel: ' . $response_auth['username']);
                    } else {
                        //set Flash Message
                        $this->setFlash('message', 'This channel had been added by you!. This channel is ' . $status[$channel->status]);
                        return Redirect::intended($this->_page_url)->with('message', 'This channel had been added by you!. This channel is ' . $status[$channel->status]);
                    }
                } else if ($channel && $channel->user_id != $this->_user_id) {
                    //set Flash Message
                    $this->setFlash('message', 'This channel had been added by other person!');
                    return Redirect::intended($this->_page_url)->with('message', 'This channel had been added by other person!');
                }

            }
        }
        //set Flash Message
        $this->setFlash('message', 'Error!');
        return Redirect::intended($this->_page_url)->with('message', 'Error!');
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-02-01
     * Detail about income and expenditure of channel
     */
    public function detail($daily_channel_id)
    {
        //Check Status
        if ($this->_stop) {
            return Redirect::intended(url($this->_redirectTo));
        }

        //set Title for PAGE
        $this->_page_title = 'Detail of A Channel';

        //check owning channel
        $channel_get = new \App\Channels;
        $_channel = $channel_get->getUserIdByChannelId($daily_channel_id);
        if (!$_channel || $_channel['user_id'] != $this->_user_id) {
            //set Flash Message
            $this->setFlash('message', 'You do not own that channel!');
            return Redirect::intended($this->_page_url)->with('message', 'You do not own that channel!');
        }

        //get income and expenditure list
        //Get income-expenditure list
        $channel_in_ex_get = new \App\ChannelIncome;
        $number_pagination = \App\Config::where(['prefix' => 'site', 'name' => 'pagination', 'del_flg' => 1])->get()[0]['value'];
        $channel_in_ex = $channel_in_ex_get->getAllPaging([
            'channel_income.user_id' => $this->_user_id,
            'channel_income.daily_channel_id' => $daily_channel_id,
        ], $number_pagination);

        return view('dashboard.channels.detail', [
            'user' => $this->_user,
            'name' => $this->getName(),
            'page_title' => $this->_page_title,
            'active' => $this->_active,
            'number_pagination' => $number_pagination,
            'daily_channel_name' => $_channel['daily_channel_name'],
            'channel_in_ex' => $channel_in_ex,
            'in_expen_type' => config('constant.in_expen_type'),
            'in_exp_action' => config('constant.in_exp_action'),
        ]);
    }
}
