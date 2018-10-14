<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class InstantLottery extends Model
{
    use LogsActivity;

    protected $connection = 'mysql';

    protected $table = 'instant_lotteries';

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

    public function getAvailableTickets()
    {
        $count = 0;
        foreach ($this->getSharedTickets as $key => $row) {
            $count += $row->tickets_count;
        }
        return $this->tickets_count - $count;
    }

    public function getSharedTickets()
    {
        return $this->hasMany('App\Models\SharedTicket', 'lottery_id');
    }

    public function hasSupervisor($id)
    {
        $sharedTickets = SharedTicket::where('supervisor_id', $id)->get();
        if($sharedTickets->isNotEmpty()) return true; else return false;
    }
}
