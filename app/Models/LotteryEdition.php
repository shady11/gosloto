<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class LotteryEdition extends Model
{
    use LogsActivity;
    protected $connection = 'mysql';

    protected $table = 'lottery_editions';

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

    public function hasSupervisor($id)
    {
        $hasLotteriesWithEditions = DB::table('lottery_edition_'.$this->lottery_type.'_'.$this->number)->where('supervisor', $id)->get();
        if($hasLotteriesWithEditions->isNotEmpty()) return true; else return false;
    }

    public function totalTickets(){
        $totalTickets = DB::table('lottery_edition_'.$this->lottery_type.'_'.$this->number)->get();
        return $totalTickets;
    }

    public function sharedTickets(){
        $sharedTickets = DB::table('lottery_edition_'.$this->lottery_type.'_'.$this->number)->whereNotNull('supervisor')->get();
        return $sharedTickets;
    }

    public function sharedTicketsToUser(){
        $sharedTickets = DB::table('lottery_edition_'.$this->lottery_type.'_'.$this->number)->whereNotNull('user')->get();
        return $sharedTickets;
    }

    public function soldTickets(){
        $soldTickets = DB::table('lottery_edition_'.$this->lottery_type.'_'.$this->number)->whereNotNull('sold_date')->get();
        return $soldTickets;
    }

    public function returnedTickets(){
        $returnedTickets = DB::table('lottery_edition_'.$this->lottery_type.'_'.$this->number)->where('return', true)->get();
        return $returnedTickets;
    }

    public function sharedToSupervisorTickets($id){
        $tickets = DB::table('lottery_edition_'.$this->lottery_type.'_'.$this->number)->where('supervisor', $id)->get();
        return $tickets;
    }
}
