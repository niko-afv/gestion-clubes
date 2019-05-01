<?php

namespace App\Http\Controllers\Events;

use App\Event;
use App\Field;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveEventRequest;
use App\Zone;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{
    public function index(){
        if(Auth::user()->profile->level == 0){
            $events = Auth::user()->member->institutable->AllAvaliableEvents();
        }else{
            $events = Auth::user()->member->institutable->avaliablesByZonesEvents();
        }

        return view('modules.events.list', [
            'events' => $events
        ]);
    }

    public function detail(Event $event){
        return view('modules.events.detail',[
            'event' => $event
        ]);
    }

    public function create(){
        $zones = Zone::all();
        $fields = Field::all();
        return view('modules.events.form', [
            'zones' => $zones,
            'fields' => $fields
        ]);
    }

    public function save(SaveEventRequest $request){

        $oEvent = Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'start' => Carbon::create($request->start)->format('Y/m/d'),
            'end' => Carbon::create($request->end)->format('Y/m/d')
        ]);

        if ($request->has('zones') && Auth::user()->profile->level == 1){
            foreach ($request->zones as $zone_id){
                    $oEvent->zones()->save(Zone::find($zone_id));
                }
        }elseif($request->has('fields') && Auth::user()->profile->level == 0){
            foreach ($request->fields as $field_id){
                $oEvent->fields()->save(Field::find($field_id));
            }
        }

        return redirect()->route('events_list');
    }

    public function toggle($event){
        $oEvent = tap(Event::find($event), function($event){
            $event->toggle();
        });
        $activeText = ($oEvent->active == 1)?'activado':'desactivado';

        return response()->json([
            'isActived' => $oEvent->active,
            'message' => 'El Evento '. $oEvent->name . ' ha sido '. $activeText . ' exitosamente'
        ]);
    }
}