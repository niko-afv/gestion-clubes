<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['total', 'subtotal', 'paid'];

    public function invoiceLines(){
        return $this->hasMany(InvoiceLine::class);
    }

    public function participation(){
        return $this->belongsTo(Participation::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function verified(){
        return tap($this)->update([
            'paid' => 1
        ]);
    }

    public function notVerified(){
        return tap($this)->update([
            'paid' => 0
        ]);
    }
}
