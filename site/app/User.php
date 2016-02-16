<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'user_id';

    //
    public function getAccountByEmail($email)
    {
        return \App\User::select('user_id', 'email', 'first_name', 'last_name')->whereRaw('registration_system = ? AND status = ? AND del_flg = ? AND email = ? ', [1, 1, 1, $email])->first();
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-10
     * Get account by User_id
     */
    public function getAccount($user_id = '')
    {
        return \App\User::whereRaw('status = ? AND del_flg = ? AND user_id = ? ', [1, 1, $user_id])->first();
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-10
     * Check contract of account is verified
     */
    public function checkContractVerify($user_id = '')
    {
        $user = $this->getAccount($user_id);
        if ($user && $user['sign_contract'] == 1) {
            return true;
        }
        return false;
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-10
     * Checking email for signing contract
     */
    public function checkSignContract($user_id = '', $email = '')
    {
        $user = \App\User::select('user_id')->whereRaw('status = ? AND del_flg = ? AND sign_contract = ? AND user_id <> ? AND payment_email = ? ', [1, 1, 0, $user_id, $email])->first();
        if ($user) {
            return true;
        }
        return false;
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-10
     * Checking email for signing contract
     */
    public function checkExistedPaymentEmail($user_id = '', $email = '')
    {
        $user = \App\User::select('user_id')->whereRaw('status = ? AND del_flg = ? AND sign_contract = ? AND user_id <> ? AND payment_email = ? ', [1, 1, 1, $user_id, $email])->first();
        if ($user) {
            return true;
        }
        return false;
    }

    public function getAllPaging($where = [], $number_pagination = '')
    {
        $user_in_ex = \App\User::select($this->table . '.*', 'user_stats.total', 'user_stats.updated_at')
            ->join('user_stats', function ($join) {
                $join->on('user_stats.user_id', '=', $this->table . '.user_id');
            })->where($where)->orderBy('user_stats.user_id', 'desc');

        if ($number_pagination) {
            $user_in_ex = $user_in_ex->paginate($number_pagination);
            foreach (Input::except('page') as $input => $value)
            {
                $user_in_ex->appends($input, $value);
            }
        } else {
            $user_in_ex = $user_in_ex->get();
        }

        return $user_in_ex;
    }
}
