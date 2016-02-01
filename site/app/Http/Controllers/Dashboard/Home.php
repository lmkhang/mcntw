<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;

class Home extends Controller
{
    //
    public function __construct()
    {
        parent::__construct();
        //check sign contract?
        if ($this->_user['sign_contract'] == 0) {
            //set Flash Message
            $this->setFlash('message', 'Please sign contract before using full feature of dashboard!');
            $this->_stop = true;
            $this->_redirectTo = '/dashboard/sign_contract';
        }

        //Active page
        $this->_active = 'dashboard';
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-09
     * DASHBOARD HOME
     */
    public function index()
    {
        //Check Status
        if ($this->_stop) {
            return Redirect::intended(url($this->_redirectTo));
        }

        //set Title for PAGE
        $this->_page_title = 'Home';

        //Get income-expenditure list
        $user_in_ex_get = new \App\UserIncomeExpenditure;
        $number_pagination = \App\Config::where(['prefix' => 'site', 'name' => 'pagination', 'del_flg' => 1])->get()[0]['value'];
        $user_in_ex = $user_in_ex_get->getAllPaging([
            'user_income_expenditure.user_id' => $this->_user_id
        ], $number_pagination);

        //get money
        $user_stats_get = new \App\UserStats;
        $user_stats = $user_stats_get->getAccount($this->_user_id);

        //min PAY
        $minpay = \App\Config::where(['prefix' => 'payment', 'name' => 'minpay', 'del_flg' => 1])->get()[0]['value'];

        return view('dashboard.home.index', [
            'user' => $this->_user,
            'name' => $this->getName(),
            'page_title' => $this->_page_title,
            'active' => $this->_active,
            'user_stats' => $user_stats,
            'number_pagination' => $number_pagination,
            'user_in_ex' => $user_in_ex,
            'in_expen_status' => config('constant.in_expen_status'),
            'in_exp_action' => config('constant.in_exp_action'),
            'minpay' => $minpay,
        ]);
    }
}
