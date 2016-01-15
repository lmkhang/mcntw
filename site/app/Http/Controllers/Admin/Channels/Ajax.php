<?php

namespace App\Http\Controllers\Admin\Channels;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class Ajax extends AdminController
{
    /**
     * @author: lmkhang - skype
     * @date: 2016-01-10
     * Check email for signing contract
     */
    public function checkSignContract(Request $request)
    {
        //check sign contract
        if ($this->_user['sign_contract'] == 1) {
            //set Flash Message
            die;
        }

        $message = 'This email is not available';
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $post = $request->all();
            $sign_contract = $this->trim_all($post['sign_contract']);

            $user = new \App\User();
            if (!$user->checkExistedPaymentEmail($this->_user_id, $sign_contract['email'])) {
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
