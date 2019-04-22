<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public function regional(){
        return $this->morphMany(Group::class, 'groupable')->where('type_id','3');
    }

    public function zones(){
        return $this->hasMany(Zone::class);
    }

    public function avaliableEvents(){
        $zones = $this->zones;
        $zones_ids = [];
        foreach ($zones as $zone){
            $zones_ids[] = $zone->id;
        }
        return Event::byZone($zones_ids)->byField($this->id)->get();
    }
}
