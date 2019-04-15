<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $fillable = [
        'name', 'email', 'group_id', 'status', 'password'
    ];

    protected $hidden = ['password'];
}
