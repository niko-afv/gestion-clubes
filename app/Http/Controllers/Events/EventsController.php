<?php

namespace App\Http\Controllers\Events;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveEventRequest;
use App\User;
use App\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel;

class EventsController extends Controller
{
    public function index(){
        $events = Auth::user()->member->institutable->avaliableEvents();
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
        return view('modules.events.form', [
            'zones' => $zones
        ]);
    }

    public function save(SaveEventRequest $request){

        Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'start' => Carbon::create($request->start)->format('Y/m/d'),
            'end' => Carbon::create($request->end)->format('Y/m/d'),
            'eventable_id' => $request->zone,
            'eventable_type' => '\App\Zone'
        ]);
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