<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class   Event extends Model
{
    protected $fillable = ['name', 'description', 'start', 'end', 'eventable_id', 'eventable_type'];

    public function eventable(){
        return $this->morphTo();
    }

    public function enable(){
        $this->active = 1;
        $this->save();
    }

    public function disable(){
        $this->active = 0;
        $this->save();
    }

    public function toggle(){
        if ($this->active == 1){
            $this->disable();
        }else{
            $this->enable();
        }
        return $this->active;
    }
}
