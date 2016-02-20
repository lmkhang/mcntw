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
        $payment_method = config('constant.payment_method');
        $payment_notice = \App\Config::where(['prefix' => 'site', 'name' => 'payment_notice', 'del_flg' => 1])->get()[0]['value'];
        $banks_get = new \App\Banks;
        $banks = $banks_get->getAll();
        $payment_get = new \App\Payment;
        $payment = $payment_get->getPaymentInfomation($this->_user_id);

        //Get STATE of PAYMENT
        $payment_state = \App\Config::where(['prefix' => 'payment', 'name' => 'lock', 'del_flg' => 1])->get()[0]['value'];

        return view('dashboard.profile.index', [
            'user' => $this->_user,
            'name' => $this->getName(),
            'page_title' => $this->_page_title,
            'active' => $this->_active,
            'countries' => $countries,
            'payment_method' => $payment_method,
            'banks' => $banks,
            'payment_notice' => $payment_notice,
            'payment' => $payment,
            'payment_state' => $payment_state,
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
        //Check Status
        if ($this->_stop) {
            return Redirect::intended(url($this->_redirectTo));
        }

        //Get STATE of PAYMENT
        $payment_state = \App\Config::where(['prefix' => 'payment', 'name' => 'lock', 'del_flg' => 1])->get()[0]['value'];

        if($payment_state==1){
            //Locked
            $this->setFlash('message', 'Cannot edit your payment while paying. This feature is locked temporarily.');
            return redirect()->back();
        }

        //Post
        $post = $request->all();
        $payment = $post['payment'];

        //Trim
        $payment = $this->trim_all($payment);

        //get method
        $payment_method = config('constant.payment_method');
        $method = $payment['method'];

        $arr_check = [];
        //Bank
        if ($method == 1) {
            $arr_check = [
                'bank' => 'required',
                'number_bank' => 'required|min:5|max:50',
                'first_name' => 'required|min:2|max:50',
                'last_name' => 'required|min:2|max:50',
                'address' => 'required|min:1|max:250',
                'ward' => 'required|min:1|max:250',
                'district' => 'required|min:1|max:250',
                'city' => 'required|min:2|max:250',
                'phone' => 'required|min:9|max:14',
                'contact_email' => 'required|min:5|max:100|email'
            ];
        } else if ($method == 2) {
            $arr_check = [
                'paypal_email' => 'required|min:5|max:100|email'
            ];
        }

        //Setup validation
        $validator = Validator::make(
            $payment,
            $arr_check
        );

        //Checking
        if ($validator->fails()) {
            //set Flash Message
//            $this->setFlash('errors',  $validator->errors()->toArray());
            $this->setFlash('message', 'Please type all information correctly for your payment method! <' . $payment_method[$method] . '>');
            return redirect()->back();
        }

        //Insert or Update
        $payment_get = new \App\Payment;
        $payment_obj = $payment_get->getPaymentInfomation($this->_user_id);

        if (!$payment_obj) {
            $payment_obj = $payment_get;
            $payment_obj->user_id = $this->_user_id;
        }

        $payment_obj->payment_method = $method;
        if ($method == 1) {
            //Bank
            $payment_obj->bank_id = $payment['bank'];
            $payment_obj->id_number_bank = $payment['number_bank'];
            $payment_obj->phone = $payment['phone'];
            $payment_obj->last_name = $payment['last_name'];
            $payment_obj->mid_name = isset($payment['mid_name']) ? $payment['mid_name'] : '';
            $payment_obj->first_name = $payment['first_name'];
            $payment_obj->address = $payment['address'];
            $payment_obj->ward = $payment['ward'];
            $payment_obj->district = $payment['district'];
            $payment_obj->city = $payment['city'];
            $payment_obj->contact_email = $payment['contact_email'];
        } else if ($method == 2) {
            //Paypal
            $payment_obj->paypal_email = $payment['paypal_email'];
        }

        $payment_obj->save();

        //set Flash Message
        $this->setFlash('message', 'Update payment method <' . $payment_method[$method] . '> successfully!');
        return redirect()->back()->with('message', 'Update payment method <' . $payment_method[$method] . '> successfully!');
    }
}
