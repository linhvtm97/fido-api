<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'name', 'description', 'image', 'doctor_id'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function doctor()
    {
        return $this->belongsTo('App\Doctor', 'doctor_id');
    }
}
