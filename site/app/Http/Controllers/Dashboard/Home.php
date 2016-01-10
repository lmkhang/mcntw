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

        return view('dashboard.home.index', [
            'user' => $this->_user,
            'name' => $this->getName(),
            'page_title' => $this->_page_title,
            'active' => $this->_active,
        ]);
    }
}
