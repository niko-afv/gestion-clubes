<?php

namespace App;

use App\Traits\ToggableModel;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use ToggableModel;

    protected $fillable = ['name', 'description', 'start', 'end'];

    public function zones(){
        return $this->morphedByMany(Zone::class,'eventable', 'participants');
    }

    public function fields(){
        return $this->morphedByMany(Field::class,'eventable', 'participants');
    }

    public function clubs(){
        return $this->morphedByMany(Club::class,'eventable', 'participants');
    }

    public function units($club_id = null){
        $query = $this->morphedByMany(Unit::class,'eventable', 'participants');

        if (! is_null($club_id)){
            $query->where('units.club_id', $club_id);
        }
        return $query;
    }

    public function participants(){
        return $this->hasMany(Participant::class);
    }

    public function members($club_id = null, $position_ids = null){
        $query = $this->morphedByMany(Member::class,'eventable', 'participants');

        if (! is_null($club_id)){
            $query->where('members.institutable_id', $club_id);
        }

        if (! is_null($position_ids)){
            $query->whereHas('positions',function($query) use ($position_ids){
                $query->whereIn('positions.id',$position_ids);
            });
        }

        return $query;
    }

    public function logs(){
        return $this->morphMany(Log::class, 'loggable');
    }

    public function activities(){
        return $this->hasMany(Activity::class);
    }

    public function registrations(){
        return $this->hasMany(Registration::class);
    }

    public function scopeByZone($query, $zone_ids){
        return $query;
        return $query->orWhere(function ($query) use($zone_ids){
            $query
                ->wherein('eventable_id', $zone_ids)
                ->where('eventable_type', '\\App\\Zone');
        });
    }

    public function scopeByField($query, $field_id){
        return $query;
        return $query->orWhere([
            ['eventable_id','=', $field_id],
            ['eventable_type', '=','\\App\\Field']
        ]);
    }

    public function isRegistrable(){
        if($this->registrations->count() > 0){
            return true;
        }
        return false;
    }
}
