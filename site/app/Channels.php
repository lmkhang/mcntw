<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    public function getChannelForImport($channel_id = '', $exclude_status = 4, $date_record)
    {
        $date_record = date('Y-m-d H:i:s', strtotime($date_record));
        return \App\Channels::whereRaw('status <> ? AND del_flg = ? AND approved_at <= ? AND daily_channel_id = ?', [$exclude_status, 1, $date_record, $channel_id])->first();
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
        $channels = \App\Channels::where($where);

        if ($number_pagination) {
            $channels = $channels->paginate($number_pagination);
        } else {
            $channels = $channels->get();
        }

        return $channels;
    }
}
