<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['star', 'patient_id', 'doctor_id', 'review', 'patient_name'];

    protected $hidden = ['created_at', 'updated_at'];

}
