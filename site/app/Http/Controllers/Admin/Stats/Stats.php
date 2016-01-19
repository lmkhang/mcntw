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

        foreach ($csvArray as $k => $row) {

            if ($checkDate && isset($row['date']) && ($year . '-' . $month) != date('Y-m', strtotime($row['date']))) {
                continue;
            }

            if ($channel_ids && isset($row['channel_id']) && count($channel_ids) > 0 && !in_array($row['channel_id'], $channel_ids)) {
                continue;
            }
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
            } catch (\Exception $ex) {

            }
        }

        //delete file
        unlink($file);

        //set Flash Message
        $this->setFlash('message', 'Imported data');
        return redirect()->back()->with('message', 'Imported data');
    }
}
