<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use \Symfony\Component\HttpFoundation\Session\Session as SS;
use Redirect;
use Mail;
use Validator;

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
    protected function historyInExp($user_id, $money, $reason = '', $type = 1, $action = 1, $post = [])
    {
        $rs = true;
        //get some info
        //min PAY
        $minpay = \App\Config::where(['prefix' => 'payment', 'name' => 'minpay', 'del_flg' => 1])->get()[0]['value'];

        //initial USERSTATS
        $user_stats_get = new \App\UserStats;
        $user_stats = $user_stats_get->getAccount($user_id);

        //if choose payment
        if (count($post) > 0 && isset($post['is_payment']) && $post['is_payment'] == 1 && $type == 2) {
            if ($user_stats->total < $minpay || $post['amount'] < $minpay) {
                $rs = false;
                return $rs;
            }
            //no payment information
            $payment_user_get = new \App\Payment;
            $user_payment = $payment_user_get->getPaymentInfomation($user_id);

            if (!$user_payment) {
                $rs = false;
                return $rs;
            }
        }
        //without payment, only withdraw
        if ($type == 2 && $user_stats->total < $post['amount']) {
            $rs = false;
            return $rs;
        }

        $date = isset($post['date']) ? date('Y-m-d H:i:s', strtotime($post['date'])) : date('Y-m-d H:i:s');
        //insert history
        $user_history = new \App\UserIncomeExpenditure;
        $user_history->user_id = $user_id;
        $user_history->amount = $money;
        $user_history->type = $type;
        $user_history->date = $date;
        $user_history->action = $action;
        $user_history->reason = $reason;

        if ($type == 1) {
            //increase
            $user_stats->total = floatval($user_stats->total + $money);
        } else if ($type == 2) {
            //withdraw, payment
            $user_stats->total = floatval($user_stats->total - $money);
            $this->sendmailPayment($user_id, $money, $date);
        }

        $user_history->save();
        $user_stats->save();
        return $rs;
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-02-02
     * Send mail after paying
     */
    protected function sendmailPayment($user_id, $money, $date)
    {
        //get User
        $user_get = new \App\User;
        $user = $user_get->getAccount($user_id);

        //Payment information
        $info = $this->createPaymentInfo($user);

        $sender_info = config('constant.send_income_expenditure');

        $to_address = $user->payment_email;
        $to_name = $user->full_name ? $user->full_name : $user->first_name . ' ' . $user->last_name;
        $from_address = $sender_info['email'];
        $from_name = $sender_info['name'];
        $subject = str_replace(array('{mm-YYYY}'), array(date('m-Y', strtotime($date))), $sender_info['subject']);
        $content = str_replace(array('{full_name}', '{dd-mm-YYYY}', '{info}', '{full_name_info}', '{amount_info}', '{mm-YYYY}'), array($to_name, date('d-m-Y', strtotime($date)), $info['info'], $info['full_name_info'], $money, date('m-Y', strtotime($date))), $sender_info['content']);

        try {
            Mail::send('emails.contact', array(
                'subject' => $subject,
                'message' => $content,
            ), function ($message) use ($to_address, $to_name, $from_address, $from_name, $subject, $content) {
                // note: if you don't set this, it will use the defaults from config/mail.php
                $message->from($from_address, $from_name);
                $message->to($to_address, $to_name)
                    ->subject($subject)
                    ->setBody($content);
            });
        } catch (\Exception $e) {

        }
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-02-02
     * create info for payment
     */
    public function createPaymentInfo($user)
    {
        $rs = [
            'info' => '',
            'full_name_info' => '',
        ];

        //get payment user
        $payment_user_get = new \App\Payment;
        $user_payment = $payment_user_get->getPaymentInfomation($user->user_id);

        if ($user_payment) {
            $payment_type = config('constant.payment_method');
            $payment_method = $user_payment['payment_method'];
            $type_info = $payment_type[$payment_method];

            $info = '';
            $full_name_info = '';
            if ($user_payment['payment_method'] == 1) {
                //Bank
                $info .= "<br/>" . $type_info . "<br/>";
                $info .= "Bank Name: " . $user_payment['bank_name'] . "<br/>";
                $info .= "Bank ID: " . $user_payment['id_number_bank'] . "<br/>";
                $info .= "Full Name: " . $user_payment['first_name'] . ' ' . $user_payment['last_name'] . ' ' . $user_payment['mid_name'] . "<br/>";
                $info .= "Phone: " . $user_payment['phone'] . "<br/>";
                $info .= "Address: " . $user_payment['address'] . "<br/>";
                $info .= 'Ward: ' . $user_payment['ward'] . "<br/>";
                $info .= 'District: ' . $user_payment['district'] . "<br/>";
                $info .= 'City/Province: ' . $user_payment['city'] . "<br/>";
                $info .= "Contact_email: " . $user_payment['contact_email'] . "<br/>";

                $full_name_info = $user_payment['first_name'] . ' ' . $user_payment['last_name'] . ' ' . $user_payment['mid_name'];
            } else if ($user_payment['payment_method'] == 2) {
                //Paypal
                $info .= "<br/>Paypal<br/>";
                $info .= $user_payment['paypal_email'];
                $full_name_info = $user->full_name ? $user->full_name : $user->first_name . ' ' . $user->last_name;
            }

            $rs = [
                'info' => $info,
                'full_name_info' => $full_name_info,
            ];
        }

        return $rs;
    }
}
