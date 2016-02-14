<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStats extends Model
{
    protected $table = 'user_stats';
    protected $primaryKey = 'user_id';

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-10
     * Get account by User_id
     */
    public function getAccount($user_id = '')
    {
        return \App\UserStats::whereRaw('status = ? AND del_flg = ? AND user_id = ? ', [1, 1, $user_id])->first();
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-10
     * Get all account by User_id
     */
    public function getAmountAllAccount($where = [], $column)
    {
        $where['status'] = 1;
        $where['del_flg'] = 1;

        return \App\UserStats::where($where)->sum($column);
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-02-05
     * Get all amount of all user < min pay
     */
    public function getHoldAmount()
    {
        //min PAY
        $minpay = \App\Config::where(['prefix' => 'payment', 'name' => 'minpay', 'del_flg' => 1])->get()[0]['value'];

        return \App\UserStats::whereRaw('status = ? AND del_flg = ? AND total < ? ', [1, 1, $minpay])->sum('total');
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-02-05
     * Get all amount of all user >= min pay
     */
    public function getPayAmount()
    {
        //min PAY
        $minpay = \App\Config::where(['prefix' => 'payment', 'name' => 'minpay', 'del_flg' => 1])->get()[0]['value'];

        return \App\UserStats::whereRaw('status = ? AND del_flg = ? AND total >= ? ', [1, 1, $minpay])->sum('total');
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-02-05
     * Get all amount of all user >= min pay
     */
    public function getPaidAmount()
    {
        return \App\UserIncomeExpenditure::whereRaw('status = ? AND action = ? AND is_payment = ?', [1, 2, 1])->sum('original_amount');
    }
}
