<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Redirect;
use Mail;
use Validator;
use App\Http\Libraries;

class Unverify extends Controller
{
    //
    public function __construct()
    {
        parent::__construct();
        //check sign contract
        if ($this->_user['sign_contract'] == 1) {
            //set Flash Message
            $this->setFlash('message', 'Signed contract!');
            $this->_stop = true;
            $this->_redirectTo = '/dashboard';
        }

        //Active page
        $this->_active = 'sign_contract';
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-10
     * Sign contract Page
     */
    public function sign_contract()
    {
        //Check Status
        if ($this->_stop) {
            return Redirect::intended(url($this->_redirectTo));
        }

        //set Title for PAGE
        $this->_page_title = 'Verify Email';

        //contract_file
        $contract_file = \App\Config::where(['prefix' => 'site', 'name' => 'contract_file', 'del_flg' => 1])->get()[0]['value'];

        return view('dashboard.home.sign_contract', [
            'user' => $this->_user,
            'name' => $this->getName(),
            'page_title' => $this->_page_title,
            'active' => $this->_active,
            'contract_file' => $contract_file,
        ]);
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-10
     * Send payment_email
     */
    public function send(Request $request)
    {
        //Check Status
        if ($this->_stop) {
            return Redirect::intended(url($this->_redirectTo));
        }

        $post = $request->all();
        $sign_contract = $this->trim_all($post['sign_contract']);

        //Setup validation
        $validator = Validator::make(
            $sign_contract,
            [
                'email' => 'required|email|min:5|max:100',
                'agree' => 'required',
            ]
        );

        //Checking
        if ($validator->fails()) {
            // The given data did not pass validation
            //set Flash Message
            $this->setFlash('message', 'Errors!');
            return redirect()->back();
        }

        $user = new \App\User();
        if ($user->checkExistedPaymentEmail($this->_user_id, $sign_contract['email'])) {
            //set Flash Message
            $this->setFlash('message', 'This email is not available!');
            return Redirect::intended(url('/dashboard'));
        }

        //contract_file
        $contract_file = \App\Config::where(['prefix' => 'site', 'name' => 'contract_file', 'del_flg' => 1])->get()[0]['value'];

        //Create confirmation link
        $match = new Libraries\Math();
        $salt = \App\Config::where(['prefix' => 'site', 'name' => 'salt', 'del_flg' => 1])->get()[0]['value'];
        $this->_user->confirm_payment_code = $match->to_base(rand(10, 30) . substr(time(), 5, 10) . rand(10, 30), 62) . $this->encryptString(rand(111, 999) . rand(1111, 9999), $salt) . $this->encryptString(time(), $salt) . $match->to_base(rand(10, 30) . substr(time(), 5, 10) . rand(10, 30), 62);
        $this->_user->payment_email = $sign_contract['email'];
        $this->_user->contract_file = $contract_file;
        $this->_user->save();
        //Send mail
        $this->_sendMailSignContract();

        //set Flash Message
        $this->setFlash('message', 'Please confirm payment from email ' . $sign_contract['email'] . '!');
        return Redirect::intended('/dashboard/sign_contract')->with('message', 'Please confirm from email ' . $sign_contract['email'] . '!');
    }

    private function _sendMailSignContract()
    {
        $salt = \App\Config::where(['prefix' => 'site', 'name' => 'salt', 'del_flg' => 1])->get()[0]['value'];
        $confirm_link = config('app.url') . '/dashboard/payment/sign_contract/active/' . $this->ytb_encrypt(time() . '---' . $this->_user->confirm_payment_code . '---' . $this->_user->payment_email, $salt);
        $sender_info = config('constant.confirm_payment');

        $to_address = $this->_user->payment_email;
        $to_name = $this->getName();
        $from_address = $sender_info['email'];
        $from_name = $sender_info['name'];
        $subject = $sender_info['subject'];
        $content = str_replace(array('{full_name}', '{confirm_link}'), array($to_name, $confirm_link), $sender_info['content']);
//        $pathToFile = url('/download/contract_mcn_28_12_2015.pdf');

        try {
            Mail::send('emails.contact', array(
                'subject' => $subject,
                'message' => $content,
            ), function ($message) use ($to_address, $to_name, $from_address, $from_name, $subject, $content) {
                // note: if you don't set this, it will use the defaults from config/mail.php
                $message->from($from_address, $from_name);
//                $message->attach($pathToFile);
                $message->to($to_address, $to_name)
                    ->subject($subject)
                    ->setBody($content);
            });
        } catch (\Exception $e) {

        }
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-10
     * Active sign contract
     */
    public function activeSignContract($code)
    {
        //Check Status
        if ($this->_stop) {
            return Redirect::intended(url($this->_redirectTo));
        }

        $hours = \App\Config::where(['prefix' => 'site', 'name' => 'active_expire', 'del_flg' => 1])->get()[0]['value'];
        $salt = \App\Config::where(['prefix' => 'site', 'name' => 'salt', 'del_flg' => 1])->get()[0]['value'];
        //Check valid
        $decryptString = '';
        try {
            $decryptString = $this->ytb_decrypt($code, $salt);
            list($create_date, $confirm_payment_code, $emailGet) = explode('---', $decryptString);
        } catch (\Exception $e) {
            //set Flash Message
            $this->setFlash('message', 'The code is not valid!');
            return Redirect::intended('/dashboard/sign_contract')->with('message', 'The code is not valid!');
        }


        if (!$decryptString || !$confirm_payment_code || !$emailGet) {
            //set Flash Message
            $this->setFlash('message', 'The code is not valid!');
            return Redirect::intended('/dashboard/sign_contract')->with('message', 'The code is not valid!');
        }

        //Check Email is existed
        if ($this->_user->payment_email != $emailGet) {
            //set Flash Message
            $this->setFlash('message', 'The code is not match with email which had signed!');
            return Redirect::intended('/dashboard/sign_contract')->with('message', 'The code is not match with email which had signed contract!');
        }

        //check code
        $now = time();
        $compareTime = $now - ($hours * 60 * 60);
        if (($this->_user->confirm_payment_code != $confirm_payment_code) || ($compareTime > $create_date)) {
            //set Flash Message
            $this->setFlash('message', 'The code is not valid or expired!');
            return Redirect::intended('/dashboard/sign_contract')->with('message', 'The code is not valid or expired!');
        }

        //check existed email
        $user_check_pm = new \App\User();
        if ($user_check_pm->checkExistedPaymentEmail($this->_user_id, $this->_user->payment_email)) {
            //set Flash Message
            $this->setFlash('message', 'The payment email had been activated by other person!');
            return Redirect::intended('/dashboard/sign_contract')->with('message', 'The payment email had been activated by other person!');
        }

        //Good status
        $this->_user->sign_contract = 1;
        $this->_user->confirm_payment_code = '';
        $this->_user->save();

        //Send mail - congrats
        $this->_sendMailSignContractCongrats();

        //set Flash Message
        $this->setFlash('message', $this->getName() . ' signed contract successfully: ' . $this->_user->payment_email);
        return Redirect::intended('/dashboard')->with('message', $this->getName() . ' signed contract successfully: ' . $this->_user->payment_email);
    }

    private function _sendMailSignContractCongrats()
    {
        $sender_info = config('constant.confirm_payment_success');

        $to_address = $this->_user->payment_email;
        $to_name = $this->getName();
        $from_address = $sender_info['email'];
        $from_name = $sender_info['name'];
        $subject = $sender_info['subject'];
        $content = str_replace(array('{full_name}'), array($to_name), $sender_info['content']);
        $pathToFile = url($this->_user->contract_file);

        try {
            Mail::send('emails.contact', array(
                'subject' => $subject,
                'message' => $content,
            ), function ($message) use ($to_address, $to_name, $from_address, $from_name, $subject, $content, $pathToFile) {
                // note: if you don't set this, it will use the defaults from config/mail.php
                $message->from($from_address, $from_name);
                $message->attach($pathToFile);
                $message->to($to_address, $to_name)
                    ->subject($subject)
                    ->setBody($content);
            });
        } catch (\Exception $e) {

        }
    }
}
