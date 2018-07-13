<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LotteryType extends Model
{
    protected $connection = 'mysql';

    protected $table = 'lottery_types';

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
}