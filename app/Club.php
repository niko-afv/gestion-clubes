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
        return $this->morphOne(Member::class, 'institutable')->whereHas('position', function($query){
            $query->where('positions.id',1);
        });;
    }

    public function members(){
        return $this->morphMany(Member::class, 'institutable');
    }

    public function zone(){
        return $this->belongsTo(Zone::class);
    }

    public function units(){
        return $this->morphMany(Group::class, 'groupable')->where('type_id','1');
    }

    public function directive(){
        return $this->morphMany(Group::class, 'groupable')->where('type_id','2');
    }
}
