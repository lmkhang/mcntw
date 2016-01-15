<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;
use Mail;

class User extends AdminController
{
    //
    public function __construct()
    {
        parent::__construct();

        //Active page
        $this->_active = 'profile';

        //page url
        $this->_page_url = '/adminntw/profile';
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-11
     * Profile
     */
    public function profile()
    {

        //set Title for PAGE
        $this->_page_title = 'Profile';

        return view('admin.profile.index', [
            'admin' => $this->_admin,
            'name' => $this->getName(),
            'page_title' => $this->_page_title,
            'active' => $this->_active,
        ]);
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-12
     * Save Change
     */
    public function profile_change(Request $request)
    {

        //Post
        $post = $request->all();
        $profile = $post['profile'];

        //Trim
        $profile = $this->trim_all($profile);

        //Setup validation
        $validator = Validator::make(
            $profile,
            [
                'first_name' => 'required|min:2|max:50',
                'last_name' => 'required|min:2|max:50',
            ]
        );

        //Checking
        if ($validator->fails()) {
            //set Flash Message
            $this->setFlash('message', 'Errors!');
            return redirect()->back();
        }

        //set Title for PAGE
        $this->_page_title = 'Profile';

        //Save profile
        $this->_admin->first_name = $profile['first_name'];
        $this->_admin->last_name = $profile['last_name'];
        $this->_admin->save();

        //set Flash Message
        $this->setFlash('message', 'Save successfully!');
        return Redirect::intended(url('/adminntw/profile'))->with('message', 'Save successfully!');

    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-12
     * Change password
     */
    public function profile_change_password(Request $request)
    {

        //Check Status
        if ($this->_stop) {
            return Redirect::intended(url($this->_redirectTo));
        }

        //Post
        $post = $request->all();
        $profile = $post['profile'];

        //Trim
        $profile = $this->trim_all($profile);

        //Setup validation
        $validator = Validator::make(
            $profile,
            [
                'password' => 'required|min:5|max:50',
                'confirm_password' => 'required|same:password',
            ]
        );

        //Checking
        if ($validator->fails()) {
            //set Flash Message
            $this->setFlash('message', 'Errors!');
            return redirect()->back();
        }

        //set Title for PAGE
        $this->_page_title = 'Profile';

        //Save profile
        $salt = \App\Config::where(['prefix' => 'admin', 'name' => 'salt', 'del_flg' => 1])->get()[0]['value'];
        $this->_admin->password = $this->encryptString($profile['password'], $salt);;
        $this->_admin->save();

        //set Flash Message
        $this->setFlash('message', 'Change password successfully!');
        return Redirect::intended(url('/adminntw/profile'))->with('message', 'Change password successfully!');

    }
}
