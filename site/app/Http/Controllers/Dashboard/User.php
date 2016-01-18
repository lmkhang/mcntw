<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;
use Mail;

class User extends Controller
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
        $this->_active = 'profile';
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-11
     * Profile
     */
    public function profile()
    {
        //Check Status
        if ($this->_stop) {
            return Redirect::intended(url($this->_redirectTo));
        }

        //set Title for PAGE
        $this->_page_title = 'Profile';

        $countries = config('constant.countries');

        return view('dashboard.profile.index', [
            'user' => $this->_user,
            'name' => $this->getName(),
            'page_title' => $this->_page_title,
            'active' => $this->_active,
            'countries' => $countries,
        ]);
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-12
     * Save Change
     */
    public function profile_change(Request $request)
    {

        //Check Status
        if ($this->_stop) {
            return Redirect::intended(url($this->_redirectTo));
        }

        //All countries' code in the world
        $countries = config('constant.countries');

        //Post
        $post = $request->all();
        $profile = $post['profile'];

        //Trim
        $profile = $this->trim_all($profile);

        //upper case for country
        if (isset($profile['country'])) {
            $profile['country'] = strtoupper($profile['country']);
        }

        //Setup validation
        $validator = Validator::make(
            $profile,
            [
                'first_name' => 'required|min:2|max:50',
                'last_name' => 'required|min:2|max:50',
                'country' => 'required',
            ]
        );

        //Checking
        if ($validator->fails() || !array_key_exists($profile['country'], $countries)) {
            //set Flash Message
            $this->setFlash('message', 'Errors!');
            return redirect()->back();
        }

        //set Title for PAGE
        $this->_page_title = 'Profile';

        //Save profile
        $this->_user->first_name = $profile['first_name'];
        $this->_user->last_name = $profile['last_name'];
        $this->_user->country = $profile['country'];
        $this->_user->about = htmlspecialchars($profile['about']);
        $this->_user->save();

        //set Flash Message
        $this->setFlash('message', 'Save successfully!');
        return Redirect::intended(url('/dashboard/profile'))->with('message', 'Save successfully!');

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

        $registration_system = config('constant.registration');
        //Checking
        if ($validator->fails() || $this->_user->registration_system != $registration_system['site']) {
            //set Flash Message
            $this->setFlash('message', 'Errors!');
            return redirect()->back();
        }

        //set Title for PAGE
        $this->_page_title = 'Profile';

        //Save profile
        $salt = \App\Config::where(['prefix' => 'site', 'name' => 'salt', 'del_flg' => 1])->get()[0]['value'];
        $this->_user->password = $this->encryptString($profile['password'], $salt);;
        $this->_user->save();

        //set Flash Message
        $this->setFlash('message', 'Change password successfully!');
        return Redirect::intended(url('/dashboard/profile'))->with('message', 'Change password successfully!');

    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-18
     * Change payment (bank or paypal)
     */
    public function payment_change(Request $request)
    {

    }
}
