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

        //get info payment
        $currency = \App\Config::where(['prefix' => 'payment', 'name' => 'currency', 'del_flg' => 1])->get()[0]['value'];
        $tax_pay_bank = \App\Config::where(['prefix' => 'payment', 'name' => 'tax_pay_bank', 'del_flg' => 1])->get()[0]['value'];

        //get Stats
        $home_get = new \App\Home;
        $gross_amount = $home_get->getKey([
            'prefix' => 'stats',
            'name' => 'gross_amount',
            'del_flg' => 1,
        ])->value;
        $net_mount = $home_get->getKey([
            'prefix' => 'stats',
            'name' => 'net_mount',
            'del_flg' => 1,
        ])->value;
        $pay_amount = $home_get->getKey([
            'prefix' => 'stats',
            'name' => 'pay_amount',
            'del_flg' => 1,
        ])->value;
        $blocked_mount = $home_get->getKey([
            'prefix' => 'stats',
            'name' => 'blocked_mount',
            'del_flg' => 1,
        ])->value;
        $hold_amount = $home_get->getKey([
            'prefix' => 'stats',
            'name' => 'hold_amount',
            'del_flg' => 1,
        ])->value;

        $home = [
            'gross_amount' => $gross_amount,
            'net_mount' => $net_mount,
            'pay_amount' => $pay_amount,
            'blocked_mount' => $blocked_mount,
            'hold_amount' => $hold_amount,
        ];

        return view('admin.home.index', [
            'admin' => $this->_admin,
            'name' => $this->getName(),
            'page_title' => $this->_page_title,
            'active' => $this->_active,
            'user_in_ex' => $user_in_ex,
            'in_expen_status' => config('constant.in_expen_status'),
            'currency' => $currency,
            'tax_pay_bank' => $tax_pay_bank,
            'home' => $home,
        ]);
    }
}
