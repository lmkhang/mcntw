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

        return view('admin.home.index', [
            'admin' => $this->_admin,
            'name' => $this->getName(),
            'page_title' => $this->_page_title,
            'active' => $this->_active,
        ]);
    }
}
