<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name', 'email', 'phone_number', 'status', 'id_number', 'id_number_place', 'id_number_date', 'gender',
        'birthday', 'avatar', 'address_id', 'employee_id', 'created_by_user', 'doctor_no', 'specialist_id',
        'sub_specialist_id','hospital_name', 'passport_no', 'passport_place', 'passport_date', 'description',
        'experience', 'office','address_details', 'longtatude', 'latitude', 'actived', 'title', 'rating'
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
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function ratings(){
        return $this->hasMany(Rating::class)->orderBy('id', 'desc');
    }
    public function questions(){
        return $this->hasMany(Question::class)->orderBy('id', 'desc');
    }
}
