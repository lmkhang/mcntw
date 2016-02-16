<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class ChannelIncome extends Model
{
    protected $table = 'channel_income';
    protected $primaryKey = null;
    public $incrementing = false;

    public function getAllPaging($where = [], $number_pagination = '')
    {
        $channel_in_ex = \App\ChannelIncome::select('channel_income.*', 'channel.daily_channel_username', 'channel.daily_channel_name')->join('channel', function($join){
            $join->on('channel.daily_channel_id', '=', 'channel_income.daily_channel_id')
            ->on('channel.user_id', '=', 'channel_income.user_id');
        })->where($where)->orderBy('channel_income.date', 'desc');

        if ($number_pagination) {
            $channel_in_ex = $channel_in_ex->paginate($number_pagination);
            foreach (Input::except('page') as $input => $value)
            {
                $channel_in_ex->appends($input, $value);
            }
        } else {
            $channel_in_ex = $channel_in_ex->get();
        }

        return $channel_in_ex;
    }

    public function getAllPagingForAdmin($where = [], $number_pagination = '')
    {
        $channel_in_ex = \App\ChannelIncome::select('channel_income.*', 'channel.daily_channel_username', 'channel.daily_channel_name')->join('channel', function($join){
            $join->on('channel.daily_channel_id', '=', 'channel_income.daily_channel_id');
        })->where($where)->orderBy('channel_income.date', 'desc');

        if ($number_pagination) {
            $channel_in_ex = $channel_in_ex->paginate($number_pagination);
            foreach (Input::except('page') as $input => $value)
            {
                $channel_in_ex->appends($input, $value);
            }
        } else {
            $channel_in_ex = $channel_in_ex->get();
        }

        return $channel_in_ex;
    }
}
