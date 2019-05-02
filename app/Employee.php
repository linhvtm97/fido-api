<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name', 'email', 'phone_no_1', 'status', 'id_number', 'id_number_place', 'id_number_date', 'gender',
        'birthday', 'avatar', 'fk_address_id', 'created_by_user', 'tax_number', 'passport_no', 'passport_place', 'passport_date', 'start_date'
    ];

    protected $hidden = [
        'created_at','updated_at', 'updated_by_user', 'created_by_user'
    ];
    
    public function users()
    {
        return $this->morphMany(User::class, 'usable');
    }
}
