<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class Channels extends Model
{
    //
    protected $table = 'channel';
    protected $primaryKey = 'channel_id';

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-15
     * Get channel
     */
    public function getChannel($daily_channel_id = '')
    {
        return \App\Channels::whereRaw('del_flg = ? AND daily_channel_id = ? ', [1, $daily_channel_id])->first();
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-24
     * Get account by channel id
     */
    public function getUserIdByChannelId($channel_id = '')
    {
        return \App\Channels::whereRaw('del_flg = ? AND daily_channel_id = ? ', [1, $channel_id])->first();
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-24
     * Get account by channel id
     */
    public function getChannelForImport($channel_id = '', $date_record)
    {
        $date_record = date('Y-m-d H:i:s', strtotime($date_record));
        return \App\Channels::whereRaw('del_flg = ? AND approved_at <= ? AND daily_channel_id = ?', [1, $date_record, $channel_id])->first();
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-15
     * Get channel
     */
    public function getChannelById($channel_id = '')
    {
        return \App\Channels::whereRaw('del_flg = ? AND channel_id = ? ', [1, $channel_id])->first();
    }

    public function getAllPaging($where = [], $number_pagination = '')
    {
        $where['del_flg'] = 1;

        $channels = null;

        //Split username of channel
        $where_temp = $where;
        foreach ($where_temp as $k => $v) {
            //username
            if (isset($where_temp['daily_channel_username']) && $where_temp['daily_channel_username']) {
                $channels = \App\Channels::where('daily_channel_username', 'LIKE', '%' . $v . '%');
                break;
            }
        }

        if ($channels == null) {
            $channels = \App\Channels::where($where);
        }


        if ($number_pagination) {

            $channels = $channels->paginate($number_pagination);
            foreach (Input::except('page') as $input => $value) {
                $channels->appends($input, $value);
            }
        } else {
            $channels = $channels->get();
        }

        return $channels;
    }
}
