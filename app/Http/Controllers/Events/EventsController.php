<?php

namespace App\Http\Controllers\Events;

use App\Activity;
use App\ActivityCategory;
use App\Club;
use App\Event;
use App\Events\ActivatedEventEvent;
use App\Events\CreatedEventEvent;
use App\Events\DeactivatedEventEvent;
use App\Events\UpdatedEventEvent;
use App\Field;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminEventsRequest;
use App\Http\Requests\AdminUsersRequest;
use App\Http\Requests\AsClubRequest;
use App\Http\Requests\EventSuscribeRequest;
use App\Http\Requests\SaveEventRequest;
use App\Member;
use App\Position;
use App\Registration;
use App\Unit;
use App\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Morrislaptop\Firestore\DocumentReference;
use Morrislaptop\Firestore\Firestore;

class EventsController extends Controller
{
    public function index(){
        if( isAdmin(Auth::user() ) ) {
            $events = Event::all();
        }elseif( isFieldLeader( Auth::user() ) || isZoneLeader(Auth::user() ) ){
            $events = Auth::user()->member->institutable->allAvaliableEvents();
        }elseif( isClubLeader( Auth::user() ) ){
            $events = Auth::user()->member->institutable->avaliablesByZonesEvents();
        }else{
            abort(403, 'Unauthorized action.');
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

    public function create(AdminEventsRequest $request){
        $zones = Zone::all();
        $fields = Field::all();
        return view('modules.events.form', [
            'zones' => $zones,
            'fields' => $fields
        ]);
    }

    public function showUpdate(AdminEventsRequest $request, Event $event){
        $zones = Zone::all()->diff($event->zones);
        $fields = Field::all();
        $categories = ActivityCategory::all();
        $positions = Position::all();
        return view('modules.events.form', [
            'event' => $event,
            'zones' => $zones,
            'fields' => $fields,
            'categories' => $categories,
            'positions' => $positions
        ]);
    }

    public function save(SaveEventRequest $request){
        $oEvent = Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'start' => Carbon::create($request->start)->format('Y/m/d'),
            'end' => Carbon::create($request->end)->format('Y/m/d')
        ]);
        if ($request->has('zones') && Auth::user()->profile->level < 3){
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


        if ($request->has('zones') && Auth::user()->profile->level < 3){
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

    public function toggle(AdminEventsRequest $request , Event $event){

        if ( !$event->active && !$event->isRegistrable()){
            return response()->json([
                'error' => true,
                'isActived' => $event->active,
                'message' => 'Para activar este evento, debe asignarle Valores de inscripción'
            ]);
        }


        $oEvent = tap($event, function($event){
            $event->toggle();
        });
        $activeText = ($oEvent->active == 1)?'activado':'desactivado';
        ($oEvent->active == 1)?event(new ActivatedEventEvent($oEvent)):event(new DeactivatedEventEvent($oEvent));

        return response()->json([
            'isActived' => $oEvent->active,
            'message' => 'El Evento '. $oEvent->name . ' ha sido '. $activeText . ' exitosamente'
        ]);
    }

    public function showInscribe(AsClubRequest $request, Event $event){
        if (!$event->active){
            return redirect(route('events_list'))->with('error', 'El Evento no está activo aún');
        }
        $participants = collect([]);
        $club = Auth::user()->member->institutable;
        $participant = $event->participants()->where('eventable_id', $club->id)->where('eventable_type','App\Club');
        $snapshot = null;
        if($participant->count() && $participant->first()->snapshot){
            $participants = $this->getRegistrations($event, $club);
        }

        return view('modules.events.inscribe',[
            'event' => $event,
            'club' => $club,
            'snapshot' => $snapshot,
            'participants' => $participants
        ]);
    }

    public function inscribe(Request $request, Event $event){
        $unit_ids = [];
        $member_ids = [];

        $club_id = Auth::user()->member->institutable->id;
        $participant = $event->participants()->where('eventable_id', $club_id)->where('eventable_type', 'App\Club')->first();
        if($participant){
            $units = $this->getUnits($participant->snapshot);
            $members = $this->getMembers($participant->snapshot);
            if ( count($units) > 0 )
                $unit_ids = $units;
            if ( count($members) > 0 )
                $member_ids = $members;
        }else{
            // create participant object
            $event->clubs()->save(Auth::user()->member->institutable);
            $participant = $event->participants()->where('eventable_id', $club_id)->where('eventable_type', 'App\Club')->first();
        }


        if($request->type == 'unit'){
            $unit_ids[] = $request->id;
            $unit = Unit::find($request->id);
            $event->units()->save($unit);
            foreach ($unit->members as $member){
                $event->members()->save($member);
            }
            $message = 'La unidad <strong>'. $unit->name . '</strong> fue inscrita al evento <strong>'. $event->name . '</strong> exitosamente';

        }elseif ($request->type == 'member'){
            $member_ids[] = $request->id;
            $member = Member::find($request->id);
            $event->members()->save($member);
            $message = '<strong>'. $member->name . '</strong> se ha inscrito al evento <strong>'. $event->name . '</strong> exitosamente';
        }
        $club = Auth::user()->member->institutable()->with([
            'units' => function ($query) use ($unit_ids){
                $query->whereIn('id', $unit_ids);
            },
            'members' => function ($query) use ($member_ids){
                $query->whereIn('id', $member_ids);
            },
            'members.positions',
            'units.members',
            'units.members.positions',
        ])->first();

        $participant->snapshot = $club->toJson();
        $participant->save();

        //dd($event->clubs()->where('clubs.id',Auth::user()->member->institutable->id)->count());
        if($event->clubs()->where('clubs.id',Auth::user()->member->institutable->id)->count() == 0){
            $event->clubs()->save(Auth::user()->member->institutable);
        }

        return response()->json([
            'error' => false,
            'participate' => 1,
            'message' => $message,
            'participants' => $this->getRegistrations($event, $club)
        ]);
    }

    public function unsubscribe(Request $request, Event $event){

        $club_id = Auth::user()->member->institutable->id;
        $participant = $event->participants()->where('eventable_id', $club_id)->where('eventable_type', 'App\Club')->first();
        $unit_ids = $this->getUnits($participant->snapshot);
        $member_ids = $this->getMembers($participant->snapshot);

        if($request->type == 'unit'){
            $unit_ids = array_diff($unit_ids, array($request->id));
            $unit = Unit::find($request->id);
            $event->units()->detach($unit->id);
            foreach ($unit->members as $member){
                $event->members()->detach($member->id);
            }
            $message = 'La unidad <strong>'. $unit->name . '</strong> ya no está inscrito(a) al evento <strong>'. $event->name . '</strong>';
        }elseif ($request->type == 'member'){
            $member_ids = array_diff($member_ids, array($request->id));
            $member = Member::find($request->id);
            $event->members()->detach($member->id);
            $message = '<strong>'. $member->name . '</strong> ya no está inscrita al evento <strong>'. $event->name . '</strong>';
        }

        $club = Auth::user()->member->institutable()->with([
            'units' => function ($query) use ($unit_ids){
                $query->whereIn('id', $unit_ids);
            },
            'members' => function ($query) use ($member_ids){
                $query->whereIn('id', $member_ids);
            },
            'members.positions',
            'units.members',
            'units.members.positions',
        ])->first();
        $participant->snapshot = $club->toJson();
        $participant->save();

        return response()->json([
            'error' => false,
            'participate' => 0,
            'message' => $message,
            'participants' => $this->getRegistrations($event, $club)
        ]);
    }

    public function finishInscribe(Request $request){
        if ($request->confirmation == true){
            $club = Club::find($request->club);
            $participation =$club->participations()->create([
                'event_id' => $request->event
            ]);
            $data = $this->getRegistrations(Event::find($request->event), $club);
            $invoice = $participation->invoice()->create([
                'total' => $data->get('total'),
                'subtotal' => $data->get('total')
            ]);
            foreach ($data->get('items') as $item){
                $invoice->invoiceLines()->create([
                    'description' => $item['description'],
                    'quantity' => $item['count'],
                    'price' => $item['price'],
                ]);
            }

            return response()->json([
                'error' => false
            ]);
        }
    }

    public function removeZone(AdminEventsRequest $request, Event $event){
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

    public function removeActivity(AdminEventsRequest $request, Event $event){
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

    public function addActivity(AdminEventsRequest $request, Event $event){
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

    public function addRegistration(AdminEventsRequest $request, Event $event){
        if($request->registration_type == 1 && $event->registrations()->where('type',1)->count() > 0){
            return response()->json([
                'error' => true,
                'message' => 'Cada evento solo puede tener una suscripción general.'
            ]);
        }
        $registration = $event->registrations()->create([
            'type' => $request->registration_type,
            'price' => $request->price,
            'position_id' => ($request->has('position_id'))?$request->position_id:null,
            'places_limit' => $request->general_limit,
            'places_by_club_limit' => $request->by_club_limit
        ]);

        return response()->json([
            'error' => false,
            'data' => $registration,
            'message' => 'El valor se ha creado con éxito'
        ]);
    }

    public function removeRegistration(AdminEventsRequest $request, Event $event){
        $registration = Registration::find($request->registration_id);
        $response = $registration->delete();

        if ($response){
            $error = false;
            $message ='El valor de inscripción ha sido eliminado con éxito.';
        }

        return response()->json([
            'error'=> $error,
            'message' => $message
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

    public function sync(AdminUsersRequest $request,Firestore $firestore, Event $event){
        $fsEvents = $firestore->collection('events');

        if( is_null($event->firestore_reference)){
            $event->firestore_reference = Str::random(20);
        }

        $newFsEvent = $fsEvents->document($event->firestore_reference);
        $snapshot = $newFsEvent->set([
            'databaseID' => $event->id,
            'name' => $event->name,
            'active' => $event->active,
            'address' => '',
            'description' => $event->description,
            'startDate' => $event->start,
            'endDate' => $event->end,
            'image' => url(Storage::url($event->image))

        ])->snapshot();
        $event->save();

        foreach ($event->activities as $activity){
            $fsActivities = $firestore->collection('activities');

            if( is_null($activity->firestore_reference)){
                $activity->firestore_reference = Str::random(20);
            }

            $newFsActivity = $fsActivities->document($activity->firestore_reference);
            $data = [
                'databaseID' => $activity->id,
                'name' => $activity->name,
                'description' => $activity->description,
                'code' => $activity->code,
                'eventName' => $event->name,
                'categoryName' => $activity->category->name,
                'order' => 1,
                'event' => '/events/'.$event->firestore_reference
            ];
            $items = [];
            $dbitems = json_decode($activity->evaluation_items);
            foreach ($dbitems as $item){
                $items[$item->name] = $item->points;
            }
            $data['items'] = $items;
            $newFsActivity->set($data);
            $activity->save();
        }



        $clubs = $event->clubs()->has('participations')->get();
        foreach ($clubs as $club){
            $fsClubs = $firestore->collection('clubs');
            if( is_null($club->firestore_reference)){
                $club->firestore_reference = Str::random(20);
                $club->save();
            }
            $newFsClub = $fsClubs->document($club->firestore_reference);
            $data = [
                'databaseID' => $club->id,
                'name' => $club->name,
                'active' => ($club->active == 1)?true:false,
                'zoneName' => $club->zone->name
            ];
            $newFsClub->set($data);



            $units = $this->getUnits($club->pivot->snapshot);
            foreach ($units as $unit){
                $oUnit = Unit::find($unit);
                $fsUnits = $firestore->collection('units');

                if( is_null($oUnit->firestore_reference)){
                    $oUnit->firestore_reference = Str::random(20);
                    $oUnit->save();
                }
                $newFsUnit = $fsUnits->document($oUnit->firestore_reference);
                $data = [
                    'databaseID' => $oUnit->id,
                    'name' => $oUnit->name,
                    'code' => $oUnit->code,
                    'clubName' => $oUnit->club->name,
                    'zoneName' => $oUnit->club->zone->name,
                    'active' => true,
                    'image' => '',
                    'count_members' => $oUnit->members->count(),
                    'club' => '/clubs/'.$club->firestore_reference
                ];
                $newFsUnit->set($data);

                $fsUnitsEvents = $firestore->collection('unitsInEvents');
                $found = false;
                foreach ($fsUnitsEvents->documents()->rows() as $participation){
                    $data = $participation->data();
                    if ( $data['unit'] instanceof DocumentReference){
                        continue;
                    }

                    if ($data['unit'] == '/units/'.$oUnit->firestore_reference){
                        $found = true;
                        break;
                    }
                }

                if ($found == false){
                    $newFsUnitEvent = $fsUnitsEvents->document(Str::random(20));
                    $data = [
                        'clubName' => $club->name,
                        'event' => '/events/'.$event->firestore_reference,
                        'unit' => '/units/'.$oUnit->firestore_reference,
                        'unitName' => $oUnit->name
                    ];
                    $newFsUnitEvent->set($data);
                }

            }


        }

        $data = $snapshot->data();
        return response()->json([
            'error' => false,
            'data' => $data,
            'message' => 'El <strong> evento ' . $data['name']. '</strong> se ha sicnronizado con éxito.'
        ]);

    }

    public function clubs(AdminEventsRequest $request,Event $event){
        return view('modules.events.clubs_list',[
            'event' => $event
        ]);
    }

    public function deleteConfirmation(AdminEventsRequest $request,Event $event, Club $club){
        $response = $club->participations()->where('event_id', $event->id)->delete();
        if ($response != 0){
            $error = false;
            $message = 'Has liberado la inscrición del club '. $club->name;
        }else{
            $error = true;
            $message = 'Hubo un problema para liberar la inscripción del club '. $club->name;
        }
        return response()->json([
            'error' => $error,
            'message' => $message
        ]);
    }

    public function clubDetail(AdminEventsRequest $request, Event $event, Club $club){
        $data = [];
        if ($club->hasParticipation($event->id)){
            $participation = $club->participations()->with(['club', 'event', 'club.participants'])->where('event_id', $event->id)->first();
            $participant = $participation->club->participants()->where('event_id', $event->id)->first();
            $members_participate = collect($this->getAllMembers($participant->pivot->snapshot))->count();
            $members_no_participate = $club->members->count() - $members_participate;
            $total = $this->getRegistrations($event, $club)->get('total');
            $data['participation'] = $participation;
            $data['members_participate'] = $members_participate;
            $data['members_no_participate'] = $members_no_participate;
            $data['total'] = $total;
            $data['participation_status'] = $participation->status;
        }
        $participant = $event->participants()->where('eventable_id', $club->id)->where('eventable_type','App\Club');
        $snapshot = null;
        if($participant->count() && $participant->first()->snapshot){
            $participants = $this->getRegistrations($event, $club);
            $data['participants'] = $participants;
        }


        $data['event'] = $event;
        $data['club'] = $club;

        return view('modules.events.club_detail',$data);
    }

    public function uploadLogo(AdminEventsRequest $request){
        $file = $request->file('file');
        $base_derectory = 'public/';
        $local_derectory = 'images';
        $file_name = Str::slug($file->getClientOriginalName()) . '.'. $file->getClientOriginalExtension();
        $local_path_to_file = $local_derectory . '/' . $file_name;
        $path = $file->storeAs($base_derectory . $local_derectory, $file_name);
        $file_path = storage_path('app/'.$path);

        $oEvent = Event::find($request->event_id);
        $oEvent->image = $local_path_to_file;
        $oEvent->save();

        return response()->json([
            'error' => false,
            'file_path' => Storage::url($local_path_to_file)
        ]);
    }






    public function getUnits($snapshot){
        $units_list = [];
        $units = $this->__getUnits($snapshot);
        if ($units){
            foreach ($units as $unit){
                $units_list[] = $unit->id;
            }
        }
        return $units_list;
    }
    public function getMembers($snapshot){
        $members_list = [];
        $members = $this->__getMembers($snapshot);
        if ($members){
            foreach ($members as $member){
                $members_list[] = $member->id;
            }
        }
        return $members_list;
    }
    public function __getMembers($snapshot){
        $snapshot = \GuzzleHttp\json_decode($snapshot);
        if ($snapshot->members) {
            return $snapshot->members;
        }
        return [];
    }
    public function __getUnits($snapshot){
        $snapshot = \GuzzleHttp\json_decode($snapshot);
        if ($snapshot->units){
            return $snapshot->units;
        }
        return false;
    }
    public function getMembersFromUnits($units){
        $members = [];
        if ($units){
            foreach ($units as $unit){
                $unit_members = $unit->members;
                foreach ($unit_members as $member){
                    $members[] = $member;
                }
            }
        }
        return $members;
    }
    public function getAllMembers($snapshot){
        $members = $this->__getMembers($snapshot);
        $unit_members = $this->getMembersFromUnits($this->__getUnits($snapshot));
        return array_merge($members, $unit_members);
    }
    public function getRegistrations($event, $club){
        $participant =$event->participants()->where('eventable_id', $club->id)->where('eventable_type', 'App\Club')->whereNotNull('snapshot');
        $snapshot = $participant->first()->snapshot;
        $members = collect($this->getAllMembers($snapshot));

        $grouped = $members->mapToGroups(function ($item, $key) use ($event){
            $preference_registrations = $event->registrations()->preference();
            $positions = $item->positions;
            foreach ($positions as $position){
                $registration_position = $preference_registrations->where('position_id', $position->id)->first();
                if($registration_position){
                    return [$position->id => $item->name];
                }
            }
            return [0 => $item->name];
        });

        $grouped_with_price = collect();
        foreach ($event->registrations as $registration){
            foreach ($grouped as $key => $participants) {
                if ($registration->type == 2) {
                    if ($registration->position->id == $key) {
                        $grouped_with_price[$key] = collect([
                            'price' => $registration->price,
                            'count' => $participants->count(),
                            'subtotal' => ($registration->price * $participants->count()),
                            'description' => Position::find($key)->name
                        ]);
                    }
                } else {
                    $grouped_with_price[$key] = collect([
                        'price' => $registration->price,
                        'count' => $participants->count(),
                        'subtotal' => ($registration->price * $participants->count()),
                        'description' => 'General'
                    ]);
                }
            }
        }

        return collect([
            'total' => $grouped_with_price->sum('subtotal'),
            'items' => $grouped_with_price
        ]);
    }
}