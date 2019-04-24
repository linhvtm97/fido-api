<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name', 'email', 'phone_number', 'gender', 'birthday', 'avatar', 'fk_address_id', 'id_number',
    ];

    protected $hidden = [
        'created_at','updated_at', 'updated_by_user', 'created_by_user'
    ];
    
    public function users()
    {
        return $this->morphMany(User::class, 'usable');
    }
}
