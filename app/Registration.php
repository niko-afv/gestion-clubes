<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{

    protected $fillable = ['type', 'price', 'position_id', 'places_limit', 'places_by_club_limit'];

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function position(){
        return $this->belongsTo(Position::class);
    }
}
