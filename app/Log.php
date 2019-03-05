<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ['log_type_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function log_type(){
        return $this->belongsTo(LogType::class);
    }
}
