<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStats extends Model
{
    protected $table = 'user_stats';
    protected $primaryKey = 'user_id';
}
