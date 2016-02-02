<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'configuration';
    protected $primaryKey = 'config_id';
    public $timestamps = false;

    public function getAll($where = [])
    {
        $user_in_ex = \App\Config::where($where);

        $user_in_ex = $user_in_ex->get();

        return $user_in_ex;
    }
}
