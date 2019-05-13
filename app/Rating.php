<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['star', 'like', 'report','patient_id', 'doctor_id', 'review','patient_avatar', 'patient_name'];

    public function doctor()
    {
        return $this->belongsTo('App\Doctor', 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo('App\Patient', 'patient_id');
    }
}
