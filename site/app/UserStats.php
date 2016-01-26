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
    public function getIncomeAllAccount()
    {
        return \App\UserStats::whereRaw('status = ? AND del_flg = ?', [1, 1])->sum('total');
    }

}
