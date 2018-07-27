<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Setting extends Model
{
    use LogsActivity;
    
    protected $connection = 'mysql';

    protected $table = 'settings';

    protected $guarded = ['id'];

    public function getBody()
    {
    	return json_decode($this->body);
    }
}
