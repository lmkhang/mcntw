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
        foreach ($csvArray as $k => $row) {

            if ($checkDate && isset($row['date']) && ($year . '-' . $month) != date('Y-m', strtotime($row['date']))) {
                continue;
            }

            if ($channel_ids && isset($row['channel_id']) && count($channel_ids) > 0 && !in_array($row['channel_id'], $channel_ids)) {
                continue;
            }
            //get user id by channel id
            $channel_get = new \App\Channels;
            $_channel = $channel_get->getUserIdByChannelId($row['channel_id']);
            if ($_channel) {
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
                    if (!isset($income[$earningDate->daily_channel_id]['info'])) {
                        $income[$earningDate->daily_channel_id]['info'] = [
                            'user_id' => $_channel->user_id,
                            'type' => 1,
                            'date' => date('Y-m-d', strtotime($earningDate->earning_date)),
                        ];
                        $income[$earningDate->daily_channel_id]['income'] = $money;
                    } else {
                        $income[$earningDate->daily_channel_id]['income'] = $income[$earningDate->daily_channel_id]['income'] + $money;
                    }


                } catch (\Exception $ex) {

                }
            }
        }

        $user_income = [];
        //Insert Income
        if ($income && count($income) > 0) {
            foreach ($income as $channel_id => $in) {
                try {
                    $in_expen = new \App\ChannelIncomeExpenditure;
                    $in_expen->user_id = $in['info']['user_id'];
                    $in_expen->daily_channel_id = $channel_id;
                    $in_expen->amount = $in['income'];
                    $in_expen->type = $in['info']['type'];
                    $in_expen->date = $in['info']['date'];
                    $in_expen->save();

                    //update income
                    if (!isset($user_income[$in_expen->user_id])) {
                        $user_income[$in_expen->user_id] = 0;
                    }
                    $user_income[$in_expen->user_id] += $in['income'];

                } catch (\Exception $ex) {

                }
            }
        }

        //Update $ for user
        foreach ($user_income as $user_id => $income) {
            if ($income > 0) {
                $this->historyInExp($user_id, $income);
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
     * @date: 2016-02-01
     * $type: 1=> Plus; 2=> Minus
     * $action: 1=> System; 2=>People
     */
    private function historyInExp($user_id, $income, $reason = '', $type = 1, $action = 1)
    {
        //initial USERSTATS
        $user_stats_get = new \App\UserStats;
        $user_stats = $user_stats_get->getAccount($user_id);

        if ($type == 1) {
            //insert history
            $user_history = new \App\UserIncomeExpenditure;
            $user_history->user_id = $user_id;
            $user_history->amount = $income;
            $user_history->type = $type;
            $user_history->date = date('Y-m-d H:i:s');
            $user_history->action = $action;
            $user_history->reason = $reason;


            $user_stats->total = floatval($user_stats->total + $income);

        } else if ($type == 2) {
            $user_stats->total = floatval($user_stats->total - $income);
        }

        $user_history->save();
        $user_stats->save();
    }
}
