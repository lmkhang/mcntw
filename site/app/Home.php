<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $table = 'home';
    protected $primaryKey = 'home_id';

    public function getKey($where = [])
    {
        $home_get = \App\Home::where($where);

        $home = $home_get->first();

        return $home;
    }

    public function getAll($where = [])
    {
        $home_get = \App\Home::where($where);

        $home = $home_get->get();

        return $home;
    }

}
