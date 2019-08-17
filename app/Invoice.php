<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['total', 'subtotal'];

    public function invoiceLines(){
        return $this->hasMany(InvoiceLine::class);
    }

    public function club_participation(){
        return $this->belongsTo(Participation::class);
    }
}
