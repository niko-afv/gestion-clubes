<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['name', 'category_id', 'code', 'evaluation_items'];

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function category(){
        return $this->belongsTo(ActivityCategory::class);
    }
}
