<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['star', 'like','patient_id', 'doctor_id', 'review','patient_avatar', 'patient_name'];

}
