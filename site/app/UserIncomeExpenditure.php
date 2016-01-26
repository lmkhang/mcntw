<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserIncomeExpenditure extends Model
{
    protected $table = 'user_income_expenditure';
    protected $primaryKey = null;
    public $incrementing = false;

    public function getAllPaging($where = [], $number_pagination = '')
    {
        $user_in_ex = \App\UserIncomeExpenditure::select('user_income_expenditure.*', 'channel.daily_channel_username', 'channel.daily_channel_name')->join('channel', function($join){
            $join->on('channel.daily_channel_id', '=', 'user_income_expenditure.daily_channel_id')
            ->on('channel.user_id', '=', 'user_income_expenditure.user_id');
        })->where($where)->orderBy('user_income_expenditure.date', 'desc');

        if ($number_pagination) {
            $user_in_ex = $user_in_ex->paginate($number_pagination);
        } else {
            $user_in_ex = $user_in_ex->get();
        }

        return $user_in_ex;
    }
}
