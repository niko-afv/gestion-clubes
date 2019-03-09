<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function groupable(){
        return $this->morphTo();
    }

    public function members(){
        return $this->morphMany(Member::class, 'groupable');
    }
}
