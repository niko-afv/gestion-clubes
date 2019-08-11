<?php

namespace App\Traits;

Trait ToggableModel
{
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