<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['star', 'patient_id', 'doctor_id', 'review'];

    protected $hidden = ['created_at', 'updated_at'];
    
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
