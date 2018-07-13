<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LotteryEdition extends Model
{
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
}
