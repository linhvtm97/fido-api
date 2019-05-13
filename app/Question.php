<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question_content', 'answer', 'patient_id', 'doctor_id',  'created_at', 'updated_at'
    ];

    public function doctor()
    {
        return $this->belongsTo('App\Doctor', 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo('App\Patient', 'patient_id');
    }
}
