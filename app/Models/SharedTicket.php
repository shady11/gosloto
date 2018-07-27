<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SharedTicket extends Model
{
    use LogsActivity;
    protected $connection = 'mysql';

    protected $table = 'shared_tickets';

    protected $guarded = ['id'];

    public function getUser()
    {
      return $this->belongsTo('App\Models\User', 'user')->first();
    }

    public function getSharedUser()
    {
      return $this->belongsTo('App\Models\User', 'shared_user')->first();
    }

    public function getLottery()
    {
        return $this->belongsTo('App\Models\Lottery', 'lottery')->first();
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
