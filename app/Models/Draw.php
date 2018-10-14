<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\DB;

class Draw extends Model
{
    use LogsActivity;

    protected $connection = 'mysql';

    protected $table = 'draws';

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

    public function getLottery()
    {
        return $this->belongsTo('App\Models\DrawLottery', 'lottery_id');
    }

    public function getOwner()
    {

    }

//    Tickets

    public function getTotalTickets()
    {
        return DB::table($this->getLottery->getNameSlugged().'_'.$this->draw_number)->orderBy('ticket_number', 'asc')->get();
    }

    public function getTotalSupervisorTickets($id)
    {
        return DB::table($this->getLottery->getNameSlugged().'_'.$this->draw_number)->where('supervisor_id', $id)->orderBy('ticket_number', 'asc')->get();
    }

    public function getSharedTicketsToSupervisor()
    {
        return DB::table($this->getLottery->getNameSlugged().'_'.$this->draw_number)->where('status', '>', '0')->whereNotNull('supervisor_id')->get();
    }

    public function getSharedTicketsToSeller()
    {
        return DB::table($this->getLottery->getNameSlugged().'_'.$this->draw_number)->where('status', 2)->whereNotNull('seller_id')->get();
    }

    public function getSoldTickets()
    {
        return DB::table($this->getLottery->getNameSlugged().'_'.$this->draw_number)->where('status', 3)->whereNotNull('sold_at')->get();
    }

    public function getSoldTicketsBySupervisor($id)
    {
        return DB::table($this->getLottery->getNameSlugged().'_'.$this->draw_number)->where('supervisor_id', $id)->where('status', 3)->whereNotNull('sold_at')->get();
    }

    public function getSoldTicketsBySeller()
    {
        return DB::table($this->getLottery->getNameSlugged().'_'.$this->draw_number)->where('status', 3)->whereNotNull('sold_at')->get();
    }

    public function getReturnedTickets()
    {
        return DB::table($this->getLottery->getNameSlugged().'_'.$this->draw_number)->where('status', 4)->whereNotNull('returned_at')->get();
    }

    public function hasSupervisor($id)
    {
        $drawTickets = DB::table($this->getLottery->getNameSlugged().'_'.$this->draw_number)->where('supervisor_id', $id)->get();
        if($drawTickets->isNotEmpty()) return true; else return false;
    }

//    Scopes
    public function scopeLottery($query, $id)
    {
        return $query->where('lottery_id', $id);
    }
}
