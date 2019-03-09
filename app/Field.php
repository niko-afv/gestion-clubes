<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public function regional(){
        return $this->morphMany(Group::class, 'groupable')->where('type_id','3');
    }
}
