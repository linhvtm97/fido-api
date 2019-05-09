<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name', 'email', 'phone_number', 'gender', 'birthday', 'avatar', 'address_id', 'id_number','id_number_place', 'id_number_date'
    ];

    protected $hidden = [
        'created_at','updated_at', 'updated_by_user', 'created_by_user'
    ];
    
    public function users()
    {
        return $this->morphMany(User::class, 'usable');
    }

    public function address()
    {
        return $this->belongsTo('App\Address', 'address_id');
    }
}
