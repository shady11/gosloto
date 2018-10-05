<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LotteryEditionTicket extends Model
{
    public function scopeFromTable($query, $tableName)
    {
        $query->from($tableName);
    }
}