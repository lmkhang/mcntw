<?php

namespace App\Http\Controllers\Admin\Stats;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use Redirect;

class Stats extends AdminController
{
    //Sessions

    public function __construct()
    {
        parent::__construct();

        //Active page
        $this->_active = 'stats';

        //page url
        $this->_page_url = '/adminntw/stats';
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-09
     * STATISTICS HOME
     */
    public function index()
    {

        //set Title for PAGE
        $this->_page_title = 'Statistics';

        return view('admin.stats.index', [
            'admin' => $this->_admin,
            'name' => $this->getName(),
            'page_title' => $this->_page_title,
            'active' => $this->_active,
        ]);
    }
}
