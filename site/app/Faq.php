<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faq';
    protected $primaryKey = 'faq_id';
    public $timestamps = false;

    public function getAll($where = [])
    {
        $faq_get = \App\Faq::where($where);

        return $faq_get->get();
    }
}
