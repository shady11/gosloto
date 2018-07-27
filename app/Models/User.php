<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, LogsActivity;

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
}
