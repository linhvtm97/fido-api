<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'name', 'code',
    ];

    public function doctor(){
        return $this->belongsTo('App\Doctor');
    }
}
