<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    public function scopeActivated($query){
        return $query->where('active',1);
    }

    public function scopeDisabled($query){
        return $query->where('active',0);
    }
}
