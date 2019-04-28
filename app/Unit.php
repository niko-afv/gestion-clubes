<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['name', 'description', 'club_id'];

    public function club(){
        return $this->belongsTo(Club::class);
    }

    public function members(){
        return $this->hasMany(Member::class);
    }
}
