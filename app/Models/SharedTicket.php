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

    public function getSeller()
    {
      return $this->belongsTo('App\Models\User', 'seller_id');
    }

    public function getSupervisor()
    {
      return $this->belongsTo('App\Models\User', 'supervisor_id');
    }

    public function getOwner()
    {
      return $this->belongsTo('App\Models\User', 'owner_id');
    }

    public function getLottery()
    {
        return $this->belongsTo('App\Models\InstantLottery', 'lottery_id');
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

    public function getSharedSupervisorDate()
    {
        $fullDate = $this->shared_to_supervisor_at;
        $date = date('d-m-Y', strtotime($fullDate));
        return $date;
    }

    public function getSharedSupervisorTime()
    {
        $fullDate = $this->shared_to_supervisor_at;
        $time = date('G:i', strtotime($fullDate));
        return $time;
    }

    public function getSharedSellerDate()
    {
        $fullDate = $this->shared_to_seller_at;
        $date = date('d-m-Y', strtotime($fullDate));
        return $date;
    }

    public function getSharedSellerTime()
    {
        $fullDate = $this->shared_to_seller_at;
        $time = date('G:i', strtotime($fullDate));
        return $time;
    }

    public function hasSupervisor($id)
    {
        if($this->supervisor_id == $id) return true; else return false;
    }
}
