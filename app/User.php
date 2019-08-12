<?php

namespace App;

use App\Traits\ToggableModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use ToggableModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile(){
        return $this->belongsTo(Profile::class);
    }

    public function member(){
        return $this->belongsTo(Member::class);
    }

    public function logs(){
        return $this->hasMany(Log::class)->orderBy('created_at','DESC');
    }

    public function lastLogin(){
        if ($this->logs->count() == 0){
            return 'Sin Registro';
        }
        return $this->logs()
            ->where('log_type_id','1')
            ->orderBy('created_at', 'desc')
            ->first()
            ->created_at
            ->diffForHumans();
    }




}
