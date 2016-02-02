<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use \Symfony\Component\HttpFoundation\Session\Session as SS;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $SS = null;
    protected $_admin_id = '';
    protected $_username = '';
    protected $_email = '';
    protected $_stop = false;
    protected $_redirectTo = '';
    public $_admin = null;
    protected $_page_title = '';
    protected $_active = '';
    protected $_page_url = '';

    public function __construct()
    {
        $this->SS = new SS();
        //get User's Session
        $this->getSessionAdmin();
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-10
     * Get Session of User
     */
    protected function getSessionAdmin()
    {
        if ($this->isLoggedAdmin()) {
            $this->_admin_id = $this->getSession('ad_admin_id');
            $this->_username = $this->getSession('ad_username');
            $this->_email = $this->getSession('ad_email');
            $admin = new \App\Admin();
            $this->_admin = $admin->getAccount($this->_admin_id);
        }
    }

    /**
     * @author: lmkhang - skype
     * @date: 2015-12-30
     * Set Flash
     */
    protected function setFlash($key, $value)
    {
        $this->SS->getFlashBag()->add($key, $value);
    }

    /**
     * @author: lmkhang
     * @date: 2015-12-30
     * Get Flash
     */
    public function getFlash($key)
    {
        $value = $this->SS->getFlashBag()->get($key);
        return isset($value[0]) && $value[0] ? $value[0] : '';
    }

    /**
     * @author: lmkhang
     * @date: 2015-12-30
     * Has Flash
     */
    public function hasFlash($key)
    {
        return $this->SS->getFlashBag()->has($key);
    }

    /**
     * @author: lmkhang
     * @date: 2015-12-30
     * Set Session
     */
    protected function setSession($key, $value)
    {
        $this->SS->set($key, $value);
    }

    /**
     * @author: lmkhang
     * @date: 2015-12-30
     * Get Session
     */
    protected function getSession($key)
    {
        return $this->SS->get($key);
    }

    /**
     * @author: lmkhang
     * @date: 2015-12-30
     * Has Session
     */
    protected function hasSession($key)
    {
        return $this->SS->has($key);
    }

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

        //htmlspecialchars
        $text = htmlspecialchars($text);
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
     * @date: 2016-01-04
     * Checking existed account
     */

    protected function checkAccount($info)
    {
        //Check isLogged
        if ($this->isLoggedAdmin()) {
            die;
        }
        //Message
        $result = null;

        //Check Username
        if (isset($info['account']) && $info['account'] && isset($info['password']) && $info['password']) {
            $salt = \App\Config::where(['prefix' => 'admin', 'name' => 'salt', 'del_flg' => 1])->get()[0]['value'];
            $password = $this->encryptString($info['password'], $salt);

            $admin = new \App\Admin();
            $result = $admin->checkAccount($info['account'], $password);
        }

        return $result;
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-04-01
     * Set session after login
     * ad_admin_id, ad_username, ad_email
     *
     */
    protected function setLogSession($admin)
    {
        //Check isLogged
        if ($this->isLoggedAdmin()) {
            die;
        }
        $this->setSession('ad_admin_id', $admin['admin_id']);
        $this->setSession('ad_username', $admin['username']);
        $this->setSession('ad_email', $admin['email']);
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-04
     * isLogged
     */
    public function isLoggedAdmin()
    {
        $logged = false;
        if ($this->hasSession('ad_admin_id') && $this->hasSession('ad_username') && $this->hasSession('ad_email')) {
            $logged = true;
        }
        return $logged;
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-04
     * get User's Name
     */
    public function getName()
    {
        return htmlspecialchars_decode($this->_admin['first_name'] . ' ' . $this->_admin['last_name']);
    }

    /**
     * decrypt ID ( Channel + Video ID )
     * @param $encrypted_string
     * @param $encryption_key
     * @return string
     */
    public static function ytb_decrypt($encrypted_string, $encryption_key)
    {
        //process \: replace \ to /
        $encrypted_string = str_replace("mcenterntw", "/", $encrypted_string);

        $decoded_64 = base64_decode($encrypted_string);
        $td = mcrypt_module_open('rijndael-256', '', 'ecb', '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $encryption_key, $iv);
        $decrypted_data = mdecrypt_generic($td, $decoded_64);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return trim($decrypted_data);
    }

    /**
     * encrypt ( Channel + Video ID )
     * @param $pure_string
     * @param $encryption_key
     * @return string
     */
    public static function ytb_encrypt($pure_string, $encryption_key)
    {
        $td = mcrypt_module_open('rijndael-256', '', 'ecb', '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $encryption_key, $iv);
        $encrypted_data = mcrypt_generic($td, $pure_string);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $encoded_64 = base64_encode($encrypted_data);
        //process /: replace / to \
        $encoded_64 = str_replace("/", "mcenterntw", $encoded_64);
        return trim($encoded_64);
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-02-01
     * $type: 1=> Plus; 2=> Minus
     * $action: 1=> System; 2=>People
     */
    protected function historyInExp($user_id, $money, $reason = '', $type = 1, $action = 1)
    {
        //initial USERSTATS
        $user_stats_get = new \App\UserStats;
        $user_stats = $user_stats_get->getAccount($user_id);

        //insert history
        $user_history = new \App\UserIncomeExpenditure;
        $user_history->user_id = $user_id;
        $user_history->amount = $money;
        $user_history->type = $type;
        $user_history->date = date('Y-m-d H:i:s');
        $user_history->action = $action;
        $user_history->reason = $reason;

        if ($type == 1) {
            $user_stats->total = floatval($user_stats->total + $money);
        } else if ($type == 2) {
            $user_stats->total = floatval($user_stats->total - $money);
        }

        $user_history->save();
        $user_stats->save();
    }
}
