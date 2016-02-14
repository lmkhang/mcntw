<?php

namespace App\Http\Controllers\Admin\Stats;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use Mockery\CountValidator\Exception;
use Redirect;
use Illuminate\Support\Facades\Input;
use Validator;

class Stats extends AdminController
{
    //Sessions

    public function __construct()
    {
        parent::__construct();

        //Active page
        $this->_active = 'stats';

        //page url
        $this->_page_url = '/adminntw/stats';
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-09
     * STATISTICS HOME
     */
    public function index()
    {
        //set Title for PAGE
        $this->_page_title = 'Statistics';

        //get all channels
        $channel_get = new \App\Channels;
        $channels = $channel_get->getAllPaging([
            'status' => 1
        ]);

        return view('admin.stats.index', [
            'admin' => $this->_admin,
            'name' => $this->getName(),
            'page_title' => $this->_page_title,
            'active' => $this->_active,
            'channels' => $channels,
        ]);
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-18
     * Import data from CSV
     */
    public function import(Request $request)
    {
        $post = $request->all();
        $filter = $post['filter'];
        $channel_ids = isset($filter['channel_id']) ? $filter['channel_id'] : [];

        $path = config('constant.path.csv');

        $csv = Input::file('csv_file');
        //Setup validation
        $validator = Validator::make(
            $post,
            [
                'csv_file' => 'required',
            ]
        );

        if ($validator->fails()) {
            //set Flash Message
            $this->setFlash('message', 'Please choose at least a csv file!');
            return redirect()->back()->with('message', 'Please choose at least a csv file!');
        }

        //Path
        $destinationPath = storage_path($path);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 777);
        }
        $original_name = $csv->getClientOriginalName();

        //Upload
        $csv->move($destinationPath, $csv->getClientOriginalName());
        $file = $destinationPath . '/' . $original_name;

        if (!file_exists($file)) {
            //set Flash Message
            $this->setFlash('message', 'Error saving the file');
            return redirect()->back()->with('message', 'Error saving the file');
        }

        //Read CSV
        $csvArray = ImportCSV2Array($file);

        //check input date
        $checkDate = false;
        $year = '';
        $month = '';
        if ($filter['month']) {
            try {
                list($month, $year) = explode('/', $filter['month']);
                $checkDate = checkdate($month, 1, $year);
            } catch (\Exception $ex) {

            }
        }

        $income = [];
        $channel_objects = [];
        foreach ($csvArray as $k => $row) {

            if ($checkDate && isset($row['date']) && ($year . '-' . $month) != date('Y-m', strtotime($row['date']))) {
                continue;
            }

            if ($channel_ids && isset($row['channel_id']) && count($channel_ids) > 0 && !in_array($row['channel_id'], $channel_ids)) {
                continue;
            }
            //get user id by channel id
            if (!isset($channel_objects[$row['channel_id']])) {
                $channel_get = new \App\Channels;
                $channel_objects[$row['channel_id']] = $channel_get->getChannelForImport($row['channel_id'], $row['date']);
            }
            $_channel = $channel_objects[$row['channel_id']];

            if ($_channel) {
                $_date = date('Y-m', strtotime($row['date']));
                try {
                    //New Payment
                    $earningDate = new \App\EarningDate;
                    $earningDate->daily_channel_id = isset($row['channel_id']) ? $row['channel_id'] : '';
                    $earningDate->daily_channel_username = isset($row['channel_username']) ? $row['channel_username'] : '';
                    $earningDate->parent_username = isset($row['parent_username']) ? $row['parent_username'] : '';
                    $earningDate->earning_date = isset($row['date']) ? $row['date'] : '';
                    $earningDate->estimated_earnings = isset($row['estimated_earnings']) ? $row['estimated_earnings'] : '';
                    $earningDate->impressions = isset($row['impressions']) ? $row['impressions'] : '';
                    $earningDate->save();

                    $money = $earningDate->estimated_earnings;
                    if (!isset($income[$earningDate->daily_channel_id][$_date]['info'])) {
                        $income[$earningDate->daily_channel_id][$_date]['info'] = [
                            'user_id' => $_channel->user_id,
                            'type' => 1,
                            'date' => date('Y-m-d', strtotime($earningDate->earning_date)),
                        ];
                        $income[$earningDate->daily_channel_id][$_date]['income'] = $money;
                        $income[$earningDate->daily_channel_id][$_date]['status'] = $_channel->status;
                    } else {
                        $income[$earningDate->daily_channel_id][$_date]['income'] = $income[$earningDate->daily_channel_id][$_date]['income'] + $money;
                    }


                } catch (\Exception $ex) {

                }
            }
        }

        $user_income = [];
        $income_valid = 1;
        //Insert Income
        if ($income && count($income) > 0) {
            foreach ($income as $channel_id => $dates) {
                foreach ($dates as $_date_ => $in) {
                    try {
                        $income_valid = 1;//valid
                        if ($in['status'] == 4) {
                            //blocked
                            $income_valid = 2;//invalid
                        }
                        $channel_income = new \App\ChannelIncome;
                        $channel_income->user_id = $in['info']['user_id'];
                        $channel_income->daily_channel_id = $channel_id;

                        $_amount = $this->net_amount($in['income']);
//                    $channel_income->amount = $in['income'];
                        $channel_income->amount = $_amount['amount'];
                        $channel_income->original_amount = $_amount['original_amount'];
                        $channel_income->commission = $_amount['commission'];
                        $channel_income->tax_from_daily = $_amount['tax_from_daily'];

                        $channel_income->status = $in['status'];
                        $channel_income->type = $in['info']['type'];
                        $channel_income->date = $_date_ . '-01';
                        $channel_income->save();

                        //update income
                        if (!isset($user_income[$channel_income->user_id][$_date_][$income_valid])) {
                            $user_income[$channel_income->user_id][$_date_][$income_valid]['income'] = 0;
                            $user_income[$channel_income->user_id][$_date_][$income_valid]['date'] = $_date_;
                            $user_income[$channel_income->user_id][$_date_][$income_valid]['type'] = $income_valid;
                        }
                        $user_income[$channel_income->user_id][$_date_][$income_valid]['income'] += $in['income'];

                    } catch (\Exception $ex) {

                    }
                }
            }
        }

        //Update $ for user
        //1: valid, 2: invalid
        foreach ($user_income as $user_id => $date) {
            foreach ($date as $_date_ => $income_valid) {
                foreach ($income_valid as $_type => $r) {
                    if ($r['income'] > 0) {
                        try {
                            $this->historyInExp($user_id, $r['income'], 'Processed by System', 1, 1, ['is_import' => 1, 'date' => $r['date']], $r['type']);
                        } catch (\Exception $ex) {

                        }
                    }
                }
            }
        }

        //delete file
        unlink($file);

        //set Flash Message
        $this->setFlash('message', 'Imported data');
        return redirect()->back()->with('message', 'Imported data');
    }

    /**
     * @author: lmkhang - skype
     * @date: 2016-05-02
     * Update all Amount: Gross, Net, Blocked, Hold
     */
    public function update()
    {
        //Get Amount
        $user_stats_get = new \App\UserStats;
        #Gross Amount

        #Net Amount
        $net_amount = $user_stats_get->getAmountAllAccount([], 'total');

        #Pay Amount
        $pay_amount = $user_stats_get->getPayAmount();

        #Blocked Amount
        $blocked_amount = $user_stats_get->getAmountAllAccount([], 'loss_total');

        #Hold Amount
        $hold_amount = $user_stats_get->getHoldAmount();

        #Paid Amount
        $paid_amount = $user_stats_get->getPaidAmount();

        //Update Amount
        $home_get = new \App\Home;
        #Gross Amount

        #Net Amount
        $net_amount_get = $home_get->getKey([
            'prefix' => 'stats',
            'name' => 'net_mount',
            'del_flg' => 1,
        ]);
        $net_amount_get->value = $net_amount;
        $net_amount_get->save();

        #Pay Amount
        $pay_amount_get = $home_get->getKey([
            'prefix' => 'stats',
            'name' => 'pay_amount',
            'del_flg' => 1,
        ]);
        $pay_amount_get->value = $pay_amount;
        $pay_amount_get->save();

        #Blocked Amount
        $blocked_amount_get = $home_get->getKey([
            'prefix' => 'stats',
            'name' => 'blocked_mount',
            'del_flg' => 1,
        ]);
        $blocked_amount_get->value = $blocked_amount;
        $blocked_amount_get->save();

        #Hold Amount
        $hold_amount_get = $home_get->getKey([
            'prefix' => 'stats',
            'name' => 'hold_amount',
            'del_flg' => 1,
        ]);
        $hold_amount_get->value = $hold_amount;
        $hold_amount_get->save();

        #Paid Amount
        $paid_amount_get = $home_get->getKey([
            'prefix' => 'stats',
            'name' => 'paid_amount',
            'del_flg' => 1,
        ]);
        $paid_amount_get->value = $paid_amount;
        $paid_amount_get->save();


        //set Flash Message
        $this->setFlash('message', 'Updated successfully!');
        return redirect()->back()->with('message', 'Updated successfully!');
    }
}
