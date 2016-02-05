<?php

namespace App\Http\Controllers\Admin\Channels;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use Redirect;

class Channels extends AdminController
{
    //Sessions
    //daily_channel_access_token
    //daily_channel_refresh_token
    //daily_channel_uid

    public function __construct()
    {
        parent::__construct();

        //Active page
        $this->_active = 'channels';

        //page url
        $this->_page_url = '/adminntw/channels';
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-09
     * DASHBOARD HOME
     */
    public function index()
    {

        //set Title for PAGE
        $this->_page_title = 'Channel Management';

        //Get channel list
        $channel_get = new \App\Channels;
        $number_pagination = \App\Config::where(['prefix' => 'site', 'name' => 'pagination', 'del_flg' => 1])->get()[0]['value'];
        $channels_paging = $channel_get->getAllPaging([], $number_pagination);

        //get URL STATS
        $url_stats = \App\Config::where(['prefix' => 'daily', 'name' => 'url_stats', 'del_flg' => 1])->get()[0]['value'];

        return view('admin.channels.index', [
            'admin' => $this->_admin,
            'name' => $this->getName(),
            'page_title' => $this->_page_title,
            'active' => $this->_active,
            'number_pagination' => $number_pagination,
            'channels_paging' => $channels_paging,
            'channel_label_status' => config('constant.channel_label_status'),
            'channel_status' => config('constant.channel_status'),
            'url_stats' => $url_stats,
        ]);
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-09
     * Change status
     */

    public function change_status($channel_id, $status, $date = '')
    {
        $channel_get = new \App\Channels;
        $channel = $channel_get->getChannelById($channel_id);
        if (!$channel) {
            //set Flash Message
            $this->setFlash('message', 'This channel is deactivated!');
            return redirect()->back()->with('message', 'This channel is deactivated!');
        }

        //Status
        $status_list = config('constant.channel_status');
        $old_status = $channel->status;

        $channel->status = $status;
        if ($status == 1) {
            $date = $date ? $date : date('Y-m-d');
            $channel->approved_at = $date;
        }
        /*else {
            $channel->approved_at = null;
        }*/
        $channel->save();

        //set Flash Message
        $this->setFlash('message', 'This status of ' . $channel->daily_channel_name . ' channel is changed from ' . $status_list[$old_status] . ' to ' . $status_list[$status]);
        return redirect()->back()->with('message', 'This status of ' . $channel->daily_channel_name . ' channel is changed from ' . $status_list[$old_status] . ' to ' . $status_list[$status]);
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
        if (!$_channel) {
            //set Flash Message
            $this->setFlash('message', 'The channel is not existed!');
            return Redirect::intended($this->_page_url)->with('message', 'The channel is not existed!');
        }

        //get income and expenditure list
        //Get income-expenditure list
        $channel_in_ex_get = new \App\ChannelIncome;
        $number_pagination = \App\Config::where(['prefix' => 'site', 'name' => 'pagination', 'del_flg' => 1])->get()[0]['value'];
        $channel_in_ex = $channel_in_ex_get->getAllPagingForAdmin([
            'channel_income.daily_channel_id' => $daily_channel_id,
        ], $number_pagination);

        return view('admin.channels.detail', [
            'admin' => $this->_admin,
            'name' => $this->getName(),
            'page_title' => $this->_page_title,
            'active' => $this->_active,
            'number_pagination' => $number_pagination,
            'daily_channel_name' => $_channel['daily_channel_name'],
            'channel_in_ex' => $channel_in_ex,
            'in_expen_status' => config('constant.in_expen_status'),
            'in_exp_action' => config('constant.in_exp_action'),
        ]);
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-02-03
     * Remove
     */

    public function remove($channel_id)
    {
        $channel_get = new \App\Channels;
        $channel = $channel_get->getChannelById($channel_id);
        if (!$channel) {
            //set Flash Message
            $this->setFlash('message', 'This channel is deactivated!');
            return redirect()->back()->with('message', 'This channel is deactivated!');
        }

        $channel_get = \App\Channels::find($channel_id);
        $channel_get->delete();

        //set Flash Message
        $this->setFlash('message', $channel->daily_channel_name . ' channel is removed');
        return redirect()->back()->with('message', $channel->daily_channel_name . ' channel is removed');
    }
}
