<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'description', 'groupable_id', 'groupable_type', 'type_id'];

    public function groupable(){
        return $this->morphTo();
    }

    public function members(){
        return $this->morphMany(Member::class, 'groupable');
    }
}
