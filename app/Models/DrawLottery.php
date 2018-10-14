<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class DrawLottery extends Model
{
    use LogsActivity;

    protected $connection = 'mysql';

    protected $table = 'draw_lotteries';

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

    public function getNameSlugged()
    {
        return str_slug(str_limit($this->name, 20), '_');
    }

    public function getDraws()
    {
        return $this->hasMany('App\Models\Draw', 'lottery_id');
    }
}
