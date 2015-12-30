<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Mail;
use Redirect;
use Validator;
use App\Http\Libraries;

class Common extends Controller
{
    //
    /**
     * @author: lmkhang - skype
     * @date: 2015-12-27
     * Send Mail
     *
     */
    public function sendmail(Request $request)
    {
        $post = $request->all();
        $mail = $post['mail'];
        // note, to use $subject within your closure below you have to pass it along in the "use (...)" clause.

        $to_info = config('mail.from');
        $to_address = $to_info['address'];
        $to_name = $to_info['name'];
        $from_address = $mail['email'];
        $from_name = $mail['full_name'] . ' <' . $from_address . '>';
        $subject = $mail['subject'];
        $text = $from_name . '<hr>' . $mail['message'];
//        $pathToFile = config('app.url') . '/download/Fashion.pdf';

        Mail::send('emails.contact', array(
            'subject' => $subject,
            'message' => $text,
        ), function ($message) use ($to_address, $to_name, $from_address, $from_name, $subject, $text) {
            // note: if you don't set this, it will use the defaults from config/mail.php
            $message->from($from_address, $from_name);
//            $message->attach($pathToFile);
            $message->to($to_address, $to_name)
                ->subject($subject)
                ->setBody($text);
        });
        return Redirect::intended('/')->with('message', 'Sent successfully!');
    }

    /**
     * @author: lmkhang - skype
     * @date: 2015-12-30
     * Register USER
     */
    public function register(Request $request)
    {
        //Post
        $post = $request->all();
        $register = $post['register'];

        //Trim
        $register = $this->trim_all($register);

        //Setup validation
        $validator = Validator::make(
            $register,
            [
                'email' => 'required|email|min:5|max:100',
                'password' => 'required|min:5|max:50',
                'repeat_password' => 'required|same:password',
                'first_name' => 'required|min:2|max:50',
                'last_name' => 'required|min:2|max:50',
            ]
        );

        // Optionally customize this version using new ->after()
        /*$validator->after(function() use ($validator) {
            // Do more validation

            $validator->errors()->add('field', 'new error');
        });*/

        //Checking
        if ($validator->fails()) {
            // The given data did not pass validation
//            $session = new \Symfony\Component\HttpFoundation\Session\Session();
//            $session->set('messages', $validator->errors());
            return redirect()->back();
        }

        //Success
        unset($register['repeat_password']);
        $match = new Libraries\Math();
        $register['refer'] = $match->to_base(rand(1000, 3000) . substr(time(), 3, 10) . rand(1000, 3000), 62).$match->to_base(rand(1000, 3000) . substr(time(), 3, 10) . rand(1000, 3000), 62);

        $salt = \App\Config::where(['prefix' => 'site', 'name' => 'salt', 'del_flg' => 1])->get()[0]['value'];

        $user = new \App\User;
        $user->refer = $register['refer'];
        $user->from_refer = $register['from_refer'];
        $user->password = md5($register['password'] . $salt);
        $user->first_name = $register['first_name'];
        $user->last_name = $register['last_name'];
        $user->email = $register['email'];
        $user->save();

        return Redirect::intended('/')->with('message', 'Register successfully!');
    }
}
