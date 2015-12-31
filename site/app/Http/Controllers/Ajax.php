<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class Ajax extends Controller
{
    //
    /**
     * @author: lmkhang - skype
     * @date: 2015-12-31
     * Checking some attributes: email, from refer.
     */
    public function checkRegister(Request $request)
    {
        //Message
        $message = '';

        $post = $request->all();
        $info = $this->trim_all($post['register']);
        //Query
        //Check Email
        $user = \App\User::select('user_id')->whereRaw('status = ? AND del_flg = ? AND email = ?', [1, 1, $info['email']])->first();

        $email_exists = false;
        if ($user) {
            $email_exists = $user->exists;
            if (!$message && $email_exists) {
                $email_exists = true;
                $message = 'Someone already has that username. Try another?';
            }
        }

        //Check Refer
        $ref_exists = true;
        if ($info['from_refer']) {
            $ref = \App\User::select('user_id')->whereRaw('status = ? AND del_flg = ? AND refer = ?', [1, 1, $info['from_refer']])->first();
            if (!$message && !$ref) {
                $ref_exists = false;
                $message = 'Referrer is not available';
            }
        }

        header('Content-Type: application/json');
        echo json_encode([
            'message' => $message,
        ]);
        exit;
    }
}
