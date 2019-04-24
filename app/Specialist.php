<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialist extends Model
{
    protected $fillable = [
        'name', 'description',
    ];
    public function doctor(){
        return $this->belongsTo('App\Doctor');
    }
}
