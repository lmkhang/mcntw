<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //
    protected $table = 'admin';
    protected $primaryKey = 'admin_id';

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-10
     * Get account by admin_id
     */
    public function getAccount($admin_id = '')
    {
        return \App\Admin::whereRaw('`group` = ? AND del_flg = ? AND admin_id = ? ', [1, 1, $admin_id])->first();
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-10
     * check account
     */
    public function checkAccount($account = '', $password = '')
    {
        return \App\Admin::select('admin_id', 'username', 'email')->whereRaw('`group` = ? AND del_flg = ? AND ( username = ? OR email = ? ) AND `password` = ? ', [1, 1, $account, $account, $password])->first();
    }
}
