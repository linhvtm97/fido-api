<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name', 'email', 'phone_no_1', 'status', 'id_number', 'id_number_place', 'id_number_date', 'gender',
        'birthday', 'avatar', 'fk_address_id', 'fk_employee_id', 'created_by_user', 'doctor_no', 'specialist',
        'hospital_name', 'passport_no', 'passport_place', 'passport_date'
    ];

}