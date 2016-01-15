<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Redirect;
use Validator;

class Admin extends AdminController
{
    /**
     * @author: lmkhang (skype)
     * @date: 2016-01-15
     *
     * Create password for admin
     */
    public function create_pwd($pwd)
    {
        //create password
        $salt = \App\Config::where(['prefix' => 'admin', 'name' => 'salt', 'del_flg' => 1])->get()[0]['value'];
        echo $this->encryptString($pwd, $salt);
        die;
    }

    /**
     * @author: lmkhang (skype)
     * @date: 2016-01-15
     *
     * Admin login
     */

    public function index()
    {
        //check islogged
        if ($this->isLoggedAdmin()) {
            //set Flash Message
            $this->setFlash('message', 'Logged!');
            return Redirect::intended('/adminntw')->with('message', 'Logged!');
        }

        $site = [
            'urlhome' => config('app.url'),
            'message' => $this->hasFlash('message') ? $this->getFlash('message') : '',
        ];

        return view('admin.templates.login')->with(
            [
                'page_title' => 'Login',
                'site' => $site,
            ]
        );
    }

    /**
     * @author: lmkhang (skype)
     * @date: 2016-01-15
     * Action: Admin login
     */
    public function login(Request $request)
    {
        //check islogged
        if ($this->isLoggedAdmin()) {
            //set Flash Message
            $this->setFlash('message', 'Logged!');
            return Redirect::intended('/adminntw')->with('message', 'Logged!');
        }

        $post = $request->all();
        $info = $this->trim_all($post['login']);

        //Setup validation
        $validator = Validator::make(
            $info,
            [
                'account' => 'required|min:5|max:100',
                'password' => 'required|min:5|max:50',
            ]
        );


        //Checking
        if ($validator->fails()) {
            // The given data did not pass validation
            //set Flash Message
            $this->setFlash('message', 'Errors!');
            return redirect()->back();
        }

        $salt = \App\Config::where(['prefix' => 'admin', 'name' => 'salt', 'del_flg' => 1])->get()[0]['value'];
        $pwd = $this->encryptString($info['password'], $salt);

        $admin_get = new \App\Admin;
        $admin = $admin_get->checkAccount($info['account'], $pwd);

        //set Session
        if (!$admin) {
            //set Flash Message
            $this->setFlash('message', 'This account is not available!');
            return redirect()->back()->with('message', 'This account is not available!');
        }

        //set Session
        $this->setLogSession($admin->toArray());

        //set Flash Message
        $this->setFlash('message', 'Login successfully!');
        return Redirect::intended('/adminntw')->with('message', 'Login successfully!');
    }

    /**
     * @author: lmkhang (skype)
     * @date: 2016-01-15
     * Action: Admin logout
     */
    public function logout()
    {
        //Check isLogged
        if (!$this->isLoggedAdmin()) {
            die;
        }

        if ($this->hasSession('ad_admin_id')) {
            $this->SS->remove('ad_admin_id');
        }

        if ($this->hasSession('ad_username')) {
            $this->SS->remove('ad_username');
        }

        if ($this->hasSession('ad_email')) {
            $this->SS->remove('ad_email');
        }

        //set Flash Message
        $this->setFlash('message', 'Logout!');
        return Redirect::intended('/adminntw')->with('message', 'Logout!');
    }
}
