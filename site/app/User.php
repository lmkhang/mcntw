<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        $user = \App\User::select('user_id')->whereRaw('status = ? AND del_flg = ? AND user_id <> ? AND email = ? ', [1, 1, $user_id, $email])->first();
        if ($user) {
            return true;
        }
        return false;
    }
}
