<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class LotteryType extends Model
{
    use LogsActivity;
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

   	public function hasEdition()
    {
        if($this->has_edition){
            $class = 'success';
            $status = 'с тиражом';
        } else {
            $class = 'metal';
            $status = 'без тиража';
        }
        return '<span class="m-badge m-badge--'.$class.' m-badge--wide">'.$status.'</span>';
    }
}