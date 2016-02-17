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
    public function index(Request $request)
    {

        //set Title for PAGE
        $this->_page_title = 'Channel Management';

        //get
        $gets = $request->all();
        $gets = $this->trim_all($gets);
        $filter = isset($gets['filter']) ? $gets['filter'] : [];
        //unset if dont choose
        $filter_temp = $filter;
        foreach ($filter_temp as $k => $v) {
            if (!$v) {
                unset($filter[$k]);
            }
        }

        //Get channel list
        $channel_get = new \App\Channels;
        $number_pagination = \App\Config::where(['prefix' => 'site', 'name' => 'pagination', 'del_flg' => 1])->get()[0]['value'];
        $channels_paging = $channel_get->getAllPaging($filter, $number_pagination);

        //get URL STATS
        $url_stats = \App\Config::where(['prefix' => 'daily', 'name' => 'url_stats', 'del_flg' => 1])->get()[0]['value'];

        //get user list
        $user_get = new \App\User;
        $users = $user_get->getAllPaging([
            'user.status' => 1,
            'user.del_flg' => 1,
            'user.sign_contract' => 1,
        ]);

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
            'users' => $users,
            'filter' => $filter,
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
            'owner_user_id' => $_channel['user_id'],
            'channel_in_ex' => $channel_in_ex,
            'in_expen_type' => config('constant.in_expen_type'),
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

    /**
     * @author: lmkhang - skype
     * @date: 2016-02-17
     * Change status - Multiple
     */

    public function change_multi(Request $request)
    {

        //post
        $post = $this->trim_all($request->all());
        $channel_ids = isset($post['channel_ids']) ? $post['channel_ids'] : [];

        $msg = 'Please choose at least ONE channel';
        $channel_get = new \App\Channels;
        foreach ($channel_ids as $k => $ch) {
            //check existed
            $channel_get = \App\Channels::find($ch);
            if (!$channel_get) {
                continue;
            }

            //delete
            $channel_get->delete();

            $msg = 'Decline successfully';
        }

        //set Flash Message
        $this->setFlash('message', $msg);
        return redirect()->back()->with('message', $msg);
    }
}
