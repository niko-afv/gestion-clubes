<?php

namespace App;

use App\Traits\Composable;
use App\Traits\Dirigible;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use Composable;
    use Dirigible;

    public function regional(){
        return $this->morphMany(Unit::class, 'groupable')->where('type_id','3');
    }

    public function zones(){
        return $this->hasMany(Zone::class);
    }

    public function events(){
        return $this->morphToMany(Event::class, 'eventable','participants');
    }

    public function avaliablesByZonesEvents(){
        $zones = $this->zones()->with('events')->get();;
        $events = new Collection();
        foreach ($zones as $zone){
            $events[] = $zone->events;
        }
        return $events->collapse()->unique('id');
    }

    public function avaliablesByFieldEvents(){

        return $this->events;
    }

    public function allAvaliableEvents(){
        $events = new Collection();
        $events[] = $this->avaliablesByZonesEvents();
        $events[] = $this->avaliablesByFieldEvents();

        return $events->collapse()->unique('id');
    }

    public function parent(){
        return $this->hasOne(Field::class, 'id','parent_field_id');
    }
}
