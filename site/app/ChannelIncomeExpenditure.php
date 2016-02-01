<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChannelIncomeExpenditure extends Model
{
    protected $table = 'channel_income_expenditure';
    protected $primaryKey = null;
    public $incrementing = false;

    public function getAllPaging($where = [], $number_pagination = '')
    {
        $channel_in_ex = \App\ChannelIncomeExpenditure::select('channel_income_expenditure.*', 'channel.daily_channel_username', 'channel.daily_channel_name')->join('channel', function($join){
            $join->on('channel.daily_channel_id', '=', 'channel_income_expenditure.daily_channel_id')
            ->on('channel.user_id', '=', 'channel_income_expenditure.user_id');
        })->where($where)->orderBy('channel_income_expenditure.date', 'desc');

        if ($number_pagination) {
            $channel_in_ex = $channel_in_ex->paginate($number_pagination);
        } else {
            $channel_in_ex = $channel_in_ex->get();
        }

        return $channel_in_ex;
    }

    public function getAllPagingForAdmin($where = [], $number_pagination = '')
    {
        $channel_in_ex = \App\ChannelIncomeExpenditure::select('channel_income_expenditure.*', 'channel.daily_channel_username', 'channel.daily_channel_name')->join('channel', function($join){
            $join->on('channel.daily_channel_id', '=', 'channel_income_expenditure.daily_channel_id');
        })->where($where)->orderBy('channel_income_expenditure.date', 'desc');

        if ($number_pagination) {
            $channel_in_ex = $channel_in_ex->paginate($number_pagination);
        } else {
            $channel_in_ex = $channel_in_ex->get();
        }

        return $channel_in_ex;
    }
}
