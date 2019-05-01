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

    public function events(){
        return $this->morphToMany(Event::class, 'eventable');
    }

    public function generateCode(){
        if(! is_null($this->code)){
            return $this;
        }
        do{
            $code  = '';
            $code .= strtoupper(substr($this->club->name, '0','2'));
            $code .= rand(10,99);
            $code .= strtoupper(substr($this->club->zone->name,0,2));
            var_dump($code);
        }while (\App\Unit::where('code',$code)->count() > 0);

        $this->code = $code;
        return $this;
    }

    public function participate(){
        return ($this->events()->where('event_id',9)->count())?true:false;
    }
}
