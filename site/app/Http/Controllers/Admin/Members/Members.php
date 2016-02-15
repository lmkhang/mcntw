<?php

namespace App\Http\Controllers\Admin\Members;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use Redirect;

class Members extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        //Active page
        $this->_active = 'members';

        //page url
        $this->_page_url = '/adminntw/members';
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-15
     * Members HOME
     */
    public function index()
    {
        /*echo convert_number_to_words(str_replace(array(','), array(''), number_format(222220, 0)), 'vn');
        die;*/
        //set Title for PAGE
        $this->_page_title = 'Members';

        //Get income-expenditure list
        $user_get = new \App\User;
        $number_pagination = \App\Config::where(['prefix' => 'site', 'name' => 'pagination', 'del_flg' => 1])->get()[0]['value'];
        $user_in_ex = $user_get->getAllPaging([], $number_pagination);

        //get info payment
        $currency = \App\Config::where(['prefix' => 'payment', 'name' => 'currency', 'del_flg' => 1])->get()[0]['value'];
        $tax_pay_bank = \App\Config::where(['prefix' => 'payment', 'name' => 'tax_pay_bank', 'del_flg' => 1])->get()[0]['value'];

        return view('admin.members.index', [
            'admin' => $this->_admin,
            'name' => $this->getName(),
            'page_title' => $this->_page_title,
            'active' => $this->_active,
            'user_in_ex' => $user_in_ex,
            'in_expen_type' => config('constant.in_expen_type'),
            'currency' => $currency,
            'tax_pay_bank' => $tax_pay_bank,
        ]);
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-15
     * Member detail
     */
    public function detail($user_id)
    {

        //set Title for PAGE
        $this->_page_title = 'Members';

        //check user id existed
        $user_get = new \App\User;
        $user = $user_get->getAccount($user_id);

        if (!$user) {
            //set Flash Message
            $this->setFlash('message', 'The user is not existed!');
            return Redirect::intended($this->_page_url)->with('message', 'The user is not existed!');
        }

        //Get income-expenditure list
        $user_in_ex_get = new \App\UserIncomeExpenditure;
        $number_pagination = \App\Config::where(['prefix' => 'site', 'name' => 'pagination', 'del_flg' => 1])->get()[0]['value'];
        $user_in_ex = $user_in_ex_get->getAllPaging([
            'user_income_expenditure.user_id' => $user_id,
            'user_income_expenditure.status' => 1,
        ], $number_pagination);

        return view('admin.members.detail', [
            'admin' => $this->_admin,
            'name' => $user['full_name'] ? $user['full_name'] : $user['first_name'] . ' ' . $user['last_name'],
            'page_title' => $this->_page_title,
            'active' => $this->_active,
            'number_pagination' => $number_pagination,
            'user' => $user,
            'user_in_ex' => $user_in_ex,
            'in_expen_type' => config('constant.in_expen_type'),
            'in_exp_action' => config('constant.in_exp_action'),
        ]);
    }
}
