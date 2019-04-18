<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $fillable = [
        'name', 'email', 'group_id', 'status', 'user_active_check', 'password'
    ];

    protected $hidden = ['password', 'created_at', 'updated_at'];

    public function groups()
    {
        return $this->hasOne('App\Group');
    }
}
