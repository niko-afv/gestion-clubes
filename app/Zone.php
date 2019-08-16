<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    public function field(){
        return $this->belongsTo(Field::class);
    }

    public function events(){
        return $this->morphToMany(Event::class, 'eventable','participants');
    }

    public function clubs(){
        return $this->hasMany(Club::class);
    }
}
