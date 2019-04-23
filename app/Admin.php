<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'name', 'description', 'phone_number'
    ];

    public function users()
    {
        return $this->morphMany(User::class, 'usable');
    }
}
