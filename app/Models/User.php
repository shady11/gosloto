<?php

namespace App\Models;

use App\Models\Lottery;
use App\Models\LotteryEdition;
use App\Models\SharedTicket;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, LogsActivity, HasApiTokens;

    protected $connection = 'mysql';

    protected $table = 'users';

    protected $hidden = ['password', 'remember_token'];

    protected $guarded = ['id'];

    public function getFullName()
    {
    	return $this->name.' '.$this->lastname;
    }
    public function getUserType()
    {
    	return $this->belongsTo('App\Models\UserType', 'type')->first();
    }
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

    public function getLotteriesWithEdition()
    {
      $editionsResult = array();
      $editions = LotteryEdition::where('active', true)->get();
      foreach ($editions as $key => $row) {
        $hasLotteriesWithEditions = DB::table('lottery_edition_'.$row->lottery_type.'_'.$row->number)->where('user', $this->id)->get();
        $row->user_tickets_count = count($hasLotteriesWithEditions);
        if($hasLotteriesWithEditions->isNotEmpty()){
          $editionsResult[] = $row;
        }
      }
      return $editionsResult;
    }

    public function getLotteries()
    {
      $lotteriesResult = array();
      $lotteries = Lottery::where('active', true)->get();
      foreach ($lotteries as $key => $row) {
        $sharedTickets = SharedTicket::where('user', $this->id)->where('lottery', $row->id)->first();
        if($sharedTickets){
          $lotteriesResult[] =$row;
        }
      }
      return $lotteriesResult;
    }
}
