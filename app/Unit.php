<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['name', 'description', 'club_id'];

    public function groupable(){
        return $this->morphTo();
    }

    public function members(){
        return $this->hasMany(Member::class);
    }
}
