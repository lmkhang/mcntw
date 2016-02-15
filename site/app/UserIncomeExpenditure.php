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
        $where_temp = $where;
        foreach ($where_temp as $k => $v) {
            unset($where[$k]);
            $where[$this->table . '.' . $k] = $v;
        }

        $user_in_ex = \App\UserIncomeExpenditure::select($this->table . '.*', 'user.full_name', 'user.first_name', 'user.last_name')
            ->join('user', function ($join) {
                $join->on('user.user_id', '=', $this->table . '.user_id');
            })->where($where)->orderBy($this->table . '.created_at', 'desc');

        if ($number_pagination) {
            $user_in_ex = $user_in_ex->paginate($number_pagination);
        } else {
            $user_in_ex = $user_in_ex->get();
        }

        return $user_in_ex;
    }

}
