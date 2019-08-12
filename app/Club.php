<?php

namespace App;

use App\Traits\Composable;
use App\Traits\Dirigible;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use Composable;
    use Dirigible;

    protected $fillable = ['name','logo', 'photo', 'field_id', 'zone_id', 'active'];

    public function scopeActivated($query){
        return $query->where('active',1);
    }

    public function scopeOrdered($query){
        return $query->orderBy('name','ASC');
    }

    public function scopeDisabled($query){
        return $query->where('active',0);
    }

    public function zone(){
        return $this->belongsTo(Zone::class);
    }

    public function units(){
        return $this->hasMany(Unit::class);
    }

    public function supportTeam(){
        return $this->members()->whereHas('positions',function($query){
            $query->whereIn('positions.id',[9,10]);
        });
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
