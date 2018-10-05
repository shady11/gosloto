<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $connection = 'mysql';

    protected $table = 'reports';

    protected $guarded = ['id'];

    public function getUser()
    {
        return $this->belongsTo('App\Models\User', 'user')->first();
    }

    public function getCreatedDate()
    {
        $fullDate = $this->created_at;
        $date = date('d-m-Y', strtotime($fullDate));
        return $date;
    }

    public function getCreatedTime()
    {
        $fullDate = $this->created_at;
        $time = date('G:i', strtotime($fullDate));
        return $time;
    }
}
