<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class Ajax extends AdminController
{

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-15
     * Adjust income of members
     */
    public function member_adjust(Request $request)
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $post = $request->all();
            $post = $this->trim_all($post);

            $rs = [
                'error' => true,
            ];

            if ($post['user_id'] && $post['amount'] && $post['amount'] > 0 && $post['reason'] && $post['type']) {
                //process data
                $rs['error'] = $this->historyInExp($post['user_id'], $post['amount'], $post['reason'], $post['type'], 2, $post) ? false : true;

                $user_stats_get = new \App\UserStats;
                $user_stats = $user_stats_get->getAccount($post['user_id']);
                $rs['user_id'] = $user_stats['user_id'];
                $rs['total'] = $user_stats['total'];
                $rs['last_income'] = date('Y-m-d H:i:s');
            }

            header('Content-Type: application/json');
            echo json_encode($rs);
            exit;
        }
    }
}
