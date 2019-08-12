<?php

namespace App\Traits;

use App\Member;

Trait Dirigible
{
    public function director(){
        return $this->morphOne(Member::class, 'institutable')->whereHas('positions', function($query){
            $query->where('positions.id',1);
        });
    }

    public function hasDirector(){
        return $this->director()->count();
    }

    public function directive(){
        return $this->members()->whereHas('positions',function($query){
            $query->whereIn('positions.id',[1,2,3,4,5,6,8]);
        });
    }
}