<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SoldTicket extends Model
{   
	use LogsActivity; 
	
    protected $connection = 'mysql';

    protected $table = 'sold_tickets';

    protected $guarded = ['id'];
}
