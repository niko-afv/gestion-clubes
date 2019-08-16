<?php

namespace App;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model implements Jsonable
{
    protected $table = 'club_participations';
    protected $fillable = ['event_id'];

    public function club(){
        return $this->belongsTo(Club::class);
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }
}
