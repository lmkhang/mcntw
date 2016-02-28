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
        /*$where_temp = $where;
        foreach ($where_temp as $k => $v) {
            unset($where[$k]);
            $where[$this->table . '.' . $k] = $v;
        }*/

        $amount = 0;
        if (isset($where['amount'])) {
            $amount = $where['amount'];
        }

        $user_in_ex = \App\User::select($this->table . '.*', 'user_stats.total', 'user_stats.updated_at')
            ->join('user_stats', function ($join) use ($amount) {
                $join->on('user_stats.user_id', '=', $this->table . '.user_id')
                    ->where('user_stats.total', '>=', number_format($amount, 0));
            });

        //where
        #del_flg + status
        if (isset($where['del_flg'])) {
            $user_in_ex = $user_in_ex->where($this->table . '.del_flg', '=', $where['del_flg']);
        }
        if (isset($where['status'])) {
            $user_in_ex = $user_in_ex->where($this->table . '.status', '=', $where['status']);
        }

        #user_id
        if (isset($where['user_id'])) {
            $user_in_ex = $user_in_ex->where($this->table .'.user_id', '=', $where['user_id']);
        }

        #full name
        if (isset($where['full_name'])) {
            $user_in_ex = $user_in_ex->whereRaw('full_name LIKE "%' . $where['full_name'] . '%"')
                ->orWhereRaw('CONCAT(first_name, " ", last_name) LIKE "%' . $where['full_name'] . '%"');
        }

        #amount
        /*if (isset($where['amount'])) {
            $user_in_ex = $user_in_ex->having('user_stats.total', '>=', number_format($where['amount'], 2));
        }*/

        //order by
        $user_in_ex = $user_in_ex->orderBy('user_stats.user_id', 'desc');

        if ($number_pagination) {
            $user_in_ex = $user_in_ex->paginate($number_pagination);
            foreach (Input::except('page') as $input => $value) {
                $user_in_ex->appends($input, $value);
            }
        } else {
            $user_in_ex = $user_in_ex->get();
        }

        return $user_in_ex;
    }
}
