<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use Redirect;

class Home extends AdminController
{
    //
    public function __construct()
    {
        parent::__construct();

        //Active page
        $this->_active = 'home';

        //page url
        $this->_page_url = '/adminntw';
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-15
     * DASHBOARD HOME
     */
    public function index()
    {

        //set Title for PAGE
        $this->_page_title = 'Home';

        //Get income-expenditure list
        $user_get = new \App\User;
        $number_pagination = \App\Config::where(['prefix' => 'site', 'name' => 'pagination', 'del_flg' => 1])->get()[0]['value'];
        $user_in_ex = $user_get->getAllPaging([], $number_pagination);

        //get money
        $user_stats_get = new \App\UserStats;
        $total_income = $user_stats_get->getIncomeAllAccount();

        return view('admin.home.index', [
            'admin' => $this->_admin,
            'name' => $this->getName(),
            'page_title' => $this->_page_title,
            'active' => $this->_active,
            'total_income' => $total_income,
            'user_in_ex' => $user_in_ex,
            'in_expen_status' => config('constant.in_expen_status'),
        ]);
    }
}
