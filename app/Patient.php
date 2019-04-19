<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name', 'email', 'phone_no_1', 'gender', 'birthday', 'avatar', 'fk_address_id', 'id_number',
    ];
}
