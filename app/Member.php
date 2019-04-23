<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = ['name', 'dni', 'email', 'phone', 'birth_date', 'institutable_id','institutable_type'];

    public function positions(){
        return $this->belongsToMany(Position::class,'member_positions');
    }

    public function institutable(){
        return $this->morphTo();
    }
}
