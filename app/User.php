<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $fillable = [
        'name', 'email', 'group_id', 'status', 'fk_refference', 'user_active_check', 'user_reset_token'
    ];

    protected $hidden = ['password', ];

    public function groups()
    {
        return $this->hasOne('App\Group');
    }
}
