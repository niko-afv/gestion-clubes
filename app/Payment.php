<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['amount', 'voucher', 'verified'];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function verified(){
        return tap($this)->update([
            'verified' => 1
        ]);
    }

    public function notVerified(){
        return tap($this)->update([
            'verified' => 0
        ]);
    }
}
