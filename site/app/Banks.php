<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banks extends Model
{
    protected $table = 'm_banks';
    protected $primaryKey = null;
    public $incrementing = false;

    /**
     * @author: lmkhang - skype
     * @date: 2016-01-20
     * Get all banks
     */
    public function getAll()
    {
        return \App\Banks::whereRaw('del_flg = ?', [1])->get();
    }
}
