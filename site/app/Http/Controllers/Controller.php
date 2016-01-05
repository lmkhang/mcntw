<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @author: lmkhang
     * @date: 2015-12-30
     * Trim all value from post
     */

    protected function trim($text)
    {
        mb_internal_encoding('UTF-8');
        mb_regex_encoding('UTF-8');

        $text = trim($text);
        $text = preg_replace('/^[ 　]+/u', '', $text);
        $text = preg_replace('/[ 　]+$/u', '', $text);
        return $text;
    }

    protected function trim_all($post)
    {
        if ($post && is_array($post)) {
            foreach ($post as $k => $v) {
                if (is_string($v)) {
                    $v = $this->trim($v);
                } else if (is_array($v)) {
                    $v = $this->trim_all($v);
                }
                $post[$k] = $v;
            }
            return $post;
        }
        return array();
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-03
     * Encrypt string
     */

    protected function encryptString($string, $salt = '')
    {
        return md5($string . $salt);
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-03
     * Checking some attributes: email, from refer.
     */

    protected function checkUserAttributes($info, $registration_system = 1)
    {
        //Check isLogged
        if ($this->isLogged()) {
            die;
        }
        //Message
        $message = '';

        //Check Username
        if (!$message && isset($info['username']) && $info['username']) {
            $username = \App\User::select('user_id')->whereRaw('registration_system = ? AND status = ? AND del_flg = ? AND username = ?', [$registration_system, 1, 1, $info['username']])->first();

            if ($username) {
                if ($username->exists) {
                    $message = 'Someone already has that username. Try another?';
                }
            }
        }

        //Check Email
        if (!$message && isset($info['email']) && $info['email']) {
            $email = \App\User::select('user_id')->whereRaw('registration_system = ? AND status = ? AND del_flg = ? AND email = ?', [$registration_system, 1, 1, $info['email']])->first();

            if ($email) {
                if ($email->exists) {
                    $message = 'Someone already has that email. Try another?';
                }
            }
        }

        //Check Refer
        if (!$message && isset($info['from_refer']) && $info['from_refer']) {
            $ref = \App\User::select('user_id')->whereRaw('registration_system = ? AND status = ? AND del_flg = ? AND refer = ?', [$registration_system, 1, 1, $info['from_refer']])->first();
            if (!$ref) {
                $message = 'Referrer is not available';
            }
        }

        return $message;
    }


    /**
     * @author: lmkhang - skype
     * @date: 2016-01-04
     * Checking existed account
     */

    protected function checkAccount($info, $registration_system = 1)
    {
        //Check isLogged
        if ($this->isLogged()) {
            die;
        }
        //Message
        $result = null;

        //Check Username
        if (isset($info['account']) && $info['account'] && isset($info['password']) && $info['password']) {
            $salt = \App\Config::where(['prefix' => 'site', 'name' => 'salt', 'del_flg' => 1])->get()[0]['value'];
            $password = $this->encryptString($info['password'], $salt);

            $username = \App\User::select('user_id', 'email', 'registration_system')->whereRaw('registration_system = ? AND status = ? AND del_flg = ? AND ( username = ? OR email = ? ) AND password = ? ', [$registration_system, 1, 1, $info['account'], $info['account'], $password])->first();

            $result = $username;
        }

        return $result;
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-04
     * Checking existed account
     */

    protected function checkAccountSNS($info, $registration_system)
    {
        //Check isLogged
        if ($this->isLogged()) {
            die;
        }
        //Message
        $result = null;

        //Check Username
        if (isset($info['email']) && $info['email']) {
            $username = \App\User::select('user_id', 'email', 'registration_system')->whereRaw('registration_system = ? AND status = ? AND del_flg = ? AND email = ? ', [$registration_system, 1, 1, $info['email']])->first();

            $result = $username;
        }

        return $result;
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-04-01
     * Set session after login
     * site_email, site_user_id, registration_system
     *
     */
    protected function setLogSession($user)
    {
        //Check isLogged
        if ($this->isLogged()) {
            die;
        }
        $session = new \Symfony\Component\HttpFoundation\Session\Session();
        $session->set('site_email', $user['email']);
        $session->set('site_user_id', $user['user_id']);
        $session->set('site_registration_system', $user['registration_system']);
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-04
     * isLogged
     */
    public function isLogged()
    {
        $logged = false;
        $session = new \Symfony\Component\HttpFoundation\Session\Session();
        if ($session->has('site_email') && $session->has('site_user_id') && $session->has('site_registration_system')) {
            $logged = true;
        }
        return $logged;
    }

}
