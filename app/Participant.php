<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = ['eventable_id', 'eventable_type', 'snapshot'];

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function club(){
        return $this->belongsTo(Club::class);
    }
}
