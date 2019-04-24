<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name', 'email', 'phone_number', 'status', 'id_number', 'id_number_place', 'id_number_date', 'gender',
        'birthday', 'avatar', 'address_id', 'fk_employee_id', 'created_by_user', 'doctor_no', 'specialist_id',
        'hospital_name', 'passport_no', 'passport_place', 'passport_date'
    ];

    public function users()
    {
        return $this->morphMany(User::class, 'usable');
    }

    public function address(){
        return $this->hasOne('App\Address', 'address_id');
    }

}
