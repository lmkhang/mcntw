<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserIncomeExpenditure extends Model
{
    protected $table = 'user_income_expenditure';
    protected $primaryKey = null;
    public $incrementing = false;

    public function getAllPaging($where = [], $number_pagination = '')
    {
        $user_in_ex = \App\UserIncomeExpenditure::where($where)->orderBy('user_income_expenditure.created_at', 'desc');

        if ($number_pagination) {
            $user_in_ex = $user_in_ex->paginate($number_pagination);
        } else {
            $user_in_ex = $user_in_ex->get();
        }

        return $user_in_ex;
    }

}
