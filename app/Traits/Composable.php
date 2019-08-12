<?php

namespace App\Traits;

use App\Member;

Trait Composable
{
    public function members(){
        return $this->morphMany(Member::class, 'institutable')->orderBy('name');
    }
}