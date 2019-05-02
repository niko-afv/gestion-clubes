<?php

namespace App\Http\Controllers\Events;

use App\Event;
use App\Events\ActivatedEventEvent;
use App\Events\CreatedEventEvent;
use App\Events\DeactivatedEventEvent;
use App\Field;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveEventRequest;
use App\Member;
use App\Unit;
use App\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

        event(new CreatedEventEvent($oEvent));

        return redirect()->route('events_list');
    }

    public function toggle($event){
        $oEvent = tap(Event::find($event), function($event){
            $event->toggle();
        });
        $activeText = ($oEvent->active == 1)?'activado':'desactivado';
        ($oEvent->active == 1)?event(new ActivatedEventEvent($oEvent)):event(new DeactivatedEventEvent($oEvent));

        return response()->json([
            'isActived' => $oEvent->active,
            'message' => 'El Evento '. $oEvent->name . ' ha sido '. $activeText . ' exitosamente'
        ]);
    }

    public function showInscribe($event_id){
        $event = Event::find($event_id);
        $club = Auth::user()->member->institutable;
        return view('modules.events.inscribe',[
            'event' => $event,
            'club' => $club
        ]);
    }

    public function inscribe(Request $request, Event $event){
        if($request->type == 'unit'){
            $unit = Unit::find($request->id);
            $event->units()->save($unit);
            foreach ($unit->members as $member){
                $event->members()->save($member);
            }
            $message = 'La unidad <strong>'. $unit->name . '</strong> fue insrita al evento <strong>'. $event->name . '</strong> exitosamente';
        }elseif ($request->type == 'member'){
            $member = Member::find($request->id);
            $event->members()->save($member);
            $message = '<strong>'. $member->name . '</strong> se ha inscrito al evento <strong>'. $event->name . '</strong> exitosamente';
        }

        $event->clubs()->save(Auth::user()->member->institutable);

        return response()->json([
            'error' => false,
            'participate' => 1,
            'message' => $message
        ]);
    }

    public function unsubscribe(Request $request, Event $event){
        if($request->type == 'unit'){
            $unit = Unit::find($request->id);
            $event->units()->detach($unit->id);
            foreach ($unit->members as $member){
                $event->members()->detach($member->id);
            }
            $message = 'La unidad <strong>'. $unit->name . '</strong> ya no está insrita al evento <strong>'. $event->name . '</strong>';
        }elseif ($request->type == 'member'){
            $member = Member::find($request->id);
            $event->members()->detach($member->id);
            $message = '<strong>'. $member->name . '</strong> ya no está insrita al evento <strong>'. $event->name . '</strong>';
        }


        return response()->json([
            'error' => false,
            'participate' => 0,
            'message' => $message
        ]);
    }
}