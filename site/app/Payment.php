<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $primaryKey = 'user_id';

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-20
     * Get all banks
     */
    public function getPaymentInfomation($user_id)
    {
        return \App\Payment::whereRaw('del_flg = ? AND user_id = ?', [1, $user_id])->first();
    }
}
