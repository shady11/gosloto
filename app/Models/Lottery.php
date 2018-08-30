<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Lottery extends Model
{
    use LogsActivity;
    
    protected $connection = 'mysql';

    protected $table = 'lotteries';

    protected $guarded = ['id'];

    public function getStatus()
    {
      if($this->active){
        $class = 'success';
        $status = 'активный';
      } else {
      $class = 'metal';
        $status = 'неактивный';
      }
      return '<span class="m-badge m-badge--'.$class.' m-badge--wide">'.$status.'</span>';
    }
    public function getLotteryType()
    {
      return $this->belongsTo('App\Models\LotteryType', 'lottery_type')->first();
    }

    public function getAvailableTickets()
    {
      $count = 0;
      foreach ($this->getSharedTickets as $key => $row) {
        $count += $row->count;
      }
      return $this->count - $count;
    }
    public function getSharedTickets()
    {
      return $this->hasMany('App\Models\SharedTicket', 'lottery');
    }
    public function getSoldTickets()
    {
      return $this->hasMany('App\Models\SoldTicket', 'lottery');
    }
}
