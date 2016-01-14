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

    public function getAllPaging($where = [], $number_pagination) {
        $where['del_flg'] = 1;
        return \App\Channels::where($where)->paginate($number_pagination);
    }
}
