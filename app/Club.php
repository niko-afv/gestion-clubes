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

    /*
    public function scopeDirector($query, $club){
        return $query->
        join('member_position', 'member.id', '=', 'member_position.member_id')->
        where('club_id',$club)->where('member_position.position_id',1);
    }
    */

    public function director(){
        return $this->hasOne(Member::class);
    }

    public function zone(){
        return $this->belongsTo(Zone::class);
    }
}
