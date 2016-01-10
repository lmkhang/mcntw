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
    public function check_registration(Request $request)
    {
        //Check isLogged
        if ($this->isLogged()) {
            die;
        }
        $post = $request->all();
        $info = $this->trim_all($post['register']);
        $registration_system = config('constant.registration');

        $message = $this->checkUserAttributes($info, $registration_system['site']);

        header('Content-Type: application/json');
        echo json_encode([
            'message' => $message,
        ]);
        exit;
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-04
     * Checking login
     */
    public function check_login(Request $request)
    {
        if ($this->isLogged()) {
            die;
        }
        $message = 'This account is not available';
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $post = $request->all();
            $info = $this->trim_all($post['login']);

            $registration_system = config('constant.registration');

            $username = $this->checkAccount($info, $registration_system['site']);

            //set Session
            if ($username) {
                $message = '';
            }

            header('Content-Type: application/json');
            echo json_encode([
                'message' => $message,
            ]);
            exit;
        }
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-04
     * Checking login
     */
    public function forgot(Request $request)
    {
        if ($this->isLogged()) {
            die;
        }
        $message = 'This email is not available';
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $post = $request->all();
            $info = $this->trim_all($post['forgot']);

            $registration_system = config('constant.registration');
            if ($this->checkUserAttributes($info, $registration_system['site'])) {
                $message = '';
            }

            header('Content-Type: application/json');
            echo json_encode([
                'message' => $message
            ]);
            exit;
        }
    }
}
