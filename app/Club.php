<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $fillable = ['name','logo', 'photo', 'field_id', 'zone_id', 'active'];


    public function hasDirector(){
        return $this->director()->count();

    }

    public function scopeActivated($query){
        return $query->where('active',1);
    }

    public function scopeDisabled($query){
        return $query->where('active',0);
    }

    public function director(){
        return $this->morphOne(Member::class, 'institutable')->whereHas('positions', function($query){
            $query->where('positions.id',1);
        });;
    }

    public function members(){
        return $this->morphMany(Member::class, 'institutable')->orderBy('name');
    }

    public function zone(){
        return $this->belongsTo(Zone::class);
    }

    public function units(){
        return $this->hasMany(Unit::class);
    }


    public function directive(){
        return $this->morphMany(Member::class, 'institutable')->whereHas('position', function($query){
            $query->whereIn('positions.id',[1,2,3,4,5,6,8]);
        });;
    }

    public function hasToken(){
        return !is_null($this->activation_token);
    }


    public function avaliableEvents(){
        return Event::byZone([$this->zone_id])->byField($this->field_id)->get();
    }

    public function avaliablesByZonesEvents(){
        $events = $this->zone->events;
        return $events->unique('id');
    }
}
