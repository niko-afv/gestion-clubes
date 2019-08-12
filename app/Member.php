<?php

namespace App;

use Carbon\Carbon;
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

    public function user(){
        return $this->hasOne(User::class);
    }

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    public function scopeLoose($query){
        return $query->whereNull('unit_id');
    }

    // Can be added to unit, don't have important position
    public function scopeUnitable($query){
        return $query->whereHas('positions',function($query){
            $query->whereIn('positions.id',[7,8]);
        })->orDoesntHave('positions');
    }


    public function age(){
        return Carbon::parse($this->birth_date)->age;
    }

    public function events(){
        return $this->morphToMany(Event::class, 'eventable');
    }

    public function participate($event_id){
        return ($this->events()->where('event_id',$event_id)->count())?true:false;
    }


    public function getName(){
        $name = explode(' ', $this->name);
        if (count($name) <=2){
            return $this->name;
        }elseif (count($name) >=3){
            return $name[0] . ' ' . $name[2];
        }
    }
}
