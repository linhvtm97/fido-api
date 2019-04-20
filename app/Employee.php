<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name', 'email', 'phone_no_1', 'status', 'id_number', 'id_number_place', 'id_number_date', 'gender',
        'birthday', 'avatar', 'fk_address_id', 'created_by_user', 'employee_no', 'tax_number',
        'active_check', 'passport_no', 'passport_place', 'passport_date', 'start_date'
    ];

    public function users()
    {
        return $this->morphMany(User::class, 'usable');
    }
}
