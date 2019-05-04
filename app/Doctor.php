<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name', 'email', 'phone_number', 'status', 'id_number', 'id_number_place', 'id_number_date', 'gender',
        'birthday', 'avatar', 'address_id', 'fk_employee_id', 'created_by_user', 'doctor_no', 'specialist_id',
        'sub_specialist_id','hospital_name', 'passport_no', 'passport_place', 'passport_date', 'description',
        'experience', 'address_details', 'longtatude', 'latitude', 
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'updated_by_user', 'created_by_user'
    ];
    public function users()
    {
        return $this->morphMany(User::class, 'usable');
    }

    public function certificates()
    {
        return $this->hasMany('App\Certificate');
    }
    public function address(){
        return $this->belongsTo(Address::class, 'address_id');
    }
    public function specialist(){
        return $this->belongsTo(Specialist::class, 'specialist_id');
    }
    public function sub_specialist(){
        return $this->belongsTo(Specialist::class, 'sub_specialist_id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class, 'fk_employee_id');
    }
    public function ratings(){
        return $this->hasMany(Rating::class);
    }
}
