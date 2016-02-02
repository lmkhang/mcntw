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
        $where = [
            $this->table . '.del_flg' => 1,
            $this->table . '.user_id' => $user_id,
        ];

        return \App\Payment::select($this->table . '.*', 'm_banks.bank_name')
            ->leftjoin('m_banks', function ($join) {
                $join->on('m_banks.bank_id', '=', 'payment.bank_id');
            })->where($where)->first();
    }
}
