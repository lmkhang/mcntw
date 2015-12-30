<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;
use Redirect;

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
}
