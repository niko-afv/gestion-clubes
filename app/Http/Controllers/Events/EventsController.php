<?php

namespace App\Http\Controllers\Events;

use App\Activity;
use App\ActivityCategory;
use App\Event;
use App\Events\ActivatedEventEvent;
use App\Events\CreatedEventEvent;
use App\Events\DeactivatedEventEvent;
use App\Events\UpdatedEventEvent;
use App\Field;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveEventRequest;
use App\Member;
use App\Unit;
use App\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Morrislaptop\Firestore\Firestore;

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

    public function showUpdate(Event $event){
        $zones = Zone::all();
        $fields = Field::all();
        $categories = ActivityCategory::all();
        return view('modules.events.form', [
            'event' => $event,
            'zones' => $zones,
            'fields' => $fields,
            'categories' => $categories
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

    public function update(SaveEventRequest $request, Event $event){
        $event->name = $request->name;
        $event->description = $request->description;
        $event->start = Carbon::create($request->start)->format('Y/m/d');
        $event->end = Carbon::create($request->end)->format('Y/m/d');
        $event->save();


        if ($request->has('zones') && Auth::user()->profile->level == 1){
            foreach ($request->zones as $zone_id){
                $event->zones()->save(Zone::find($zone_id));
            }
        }elseif($request->has('fields') && Auth::user()->profile->level == 0){
            foreach ($request->fields as $field_id){
                $event->fields()->save(Field::find($field_id));
            }
        }

        event(new UpdatedEventEvent($event));

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

        //dd($event->clubs()->where('clubs.id',Auth::user()->member->institutable->id)->count());
        if($event->clubs()->where('clubs.id',Auth::user()->member->institutable->id)->count() == 0){
            $event->clubs()->save(Auth::user()->member->institutable);
        }

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

    public function removeZone(Request $request, Event $event){
        $response = $event->zones()->detach([$request->zone]);

        if ($response){
            $error = false;
            $message ='La zona <strong>' . $event->name . '</strong> fue desviculada con éxito del evento.';
        }


        return response()->json([
            'error'=> $error,
            'message' => $message
        ]);
    }

    public function removeActivity(Request $request, Event $event){
        $activity = Activity::find($request->activity);
        $response = $activity->delete();

        //$response = $event->activities()->dissi([$request->activity]);

        if ($response){
            $error = false;
            $message ='La actividad <strong>' . $activity->name . '</strong> fue desviculada con éxito del evento.';
        }

        return response()->json([
            'error'=> $error,
            'message' => $message
        ]);
    }

    public function addActivity(Request $request, Event $event){
        $activity = $event->activities()->create([
            'name' => $request->activity_name,
            'category_id' => $request->activity_category,
            'code' => $this->generateCode($request->activity_name),
            'evaluation_items' => json_encode($request->items)
        ]);

        return response()->json([
            'error' => false,
            'data' => $activity
        ]);
    }

    public function generateCode($name){
        do{
            $code  = '';
            $code .= strtoupper(substr($name, '0','2'));
            $code .= rand(10,99);
            $code .= Str::random(4);
            $code = strtoupper($code);
        }while (Activity::where('code',$code)->count() > 0);

        return $code;
    }

    public function sync(Firestore $firestore, Event $event){
        $fsEvents = $firestore->collection('events');
        $newFsEvent = $fsEvents->document(Str::random(20));
        $snapshot = $newFsEvent->set([
            'databaseID' => $event->id,
            'name' => $event->name,
            'active' => $event->active,
            'address' => '',
            'description' => $event->description,
            'startDate' => $event->start,
            'EndDate' => $event->date,
            'image' => $event->image

        ])->snapshot();


        foreach ($event->activities as $activity){
            $fsActivities = $firestore->collection('activities');
            $newFsActivity = $fsActivities->document(Str::random(20));
            $data = [
                'databaseID' => $activity->id,
                'name' => $activity->name,
                'description' => $activity->description,
                'code' => $activity->code,
                'eventName' => $event->name,
                'categoryName' => $activity->category->name,
                'order' => 1
            ];
            $items = [];
            $dbitems = json_decode($activity->evaluation_items);
            foreach ($dbitems as $item){
                $items[$item->name] = $item->points;
            }
            $data['items'] = $items;
            $newFsActivity->set($data);
        }

        $data = $snapshot->data();
        return response()->json([
            'error' => false,
            'data' => $data,
            'message' => 'El <strong> evento ' . $data['name']. '</strong> se ha sicnronizado con éxito.'
        ]);
    }
}