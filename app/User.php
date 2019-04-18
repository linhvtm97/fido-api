<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends Authenticatable
{
    use AuthenticableTrait;
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'group_id', 'status', 'user_active_check', 'password'
    ];

    protected $hidden = ['password', 'created_at', 'updated_at'];

    public function groups()
    {
        return $this->hasOne('App\Group');
    }
}
