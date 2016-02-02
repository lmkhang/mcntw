<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;
use Mail;

class Setting extends AdminController
{
    //
    public function __construct()
    {
        parent::__construct();

        //Active page
        $this->_active = 'setting';

        //page url
        $this->_page_url = '/adminntw/setting';
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-11
     * Profile
     */
    public function index()
    {

        //set Title for PAGE
        $this->_page_title = 'Setting';

        //get list
        $setting_get = new \App\Config;
        $setting = $setting_get->getAll(
            [
                'show' => 1,
                'del_flg' => 1
            ]
        );

        return view('admin.setting.index', [
            'admin' => $this->_admin,
            'name' => $this->getName(),
            'page_title' => $this->_page_title,
            'active' => $this->_active,
            'setting' => $setting,
        ]);
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-12
     * Save Change
     */
    public function change(Request $request)
    {

        //Post
        $post = $request->all();

        //Trim
        $setting = $this->trim_all($post);

        foreach ($setting['id'] as $id) {
//            echo $id. ' - '.$setting['setting_'.$id].'<br/>';
            $setting_get = \App\Config::find($id);
            $setting_get->value = $setting['setting_' . $id];
            $setting_get->save();
        }

        //set Flash Message
        $this->setFlash('message', 'Save successfully!');
        return redirect()->back()->with('message', 'Save successfully!');

    }
}
