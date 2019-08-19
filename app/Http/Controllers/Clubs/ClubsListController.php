<?php

namespace App\Http\Controllers\Clubs;

use App\Club;
use App\Events\AddedClubDirectorEvent;
use App\Events\RemovedClubDirectorEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminEventsRequest;
use App\Http\Requests\AdminUsersRequest;
use App\Http\Requests\AsRegionalRequest;
use App\Imports\ClubsImport;
use App\Imports\MembersImport;
use App\Member;
use App\Position;
use App\Unit;
use App\Zone;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Maatwebsite\Excel\Excel;
use Morrislaptop\Firestore\Firestore;
use Morrislaptop\Firestore\Query;

class ClubsListController extends Controller
{
    public function index(AsRegionalRequest $request){
        $clubes = Club::all();
        return view('modules.clubes.list', [
            'clubes' => $clubes
        ]);
    }

    public function detail(Club $club){
        return view('modules.clubes.detail',[
            'club' => $club
        ]);
    }

    public function import(){
        $excel = App::make(Excel::class);
        //$excel->import(new ClubsImport(), storage_path('app/import/clubes_import.csv'));
        //$excel->import(new MembersImport(), storage_path('app/import/members_import.csv'));

        return redirect(route('clubes_list'))->with('success', 'All good!');
    }

    public function unidades(){
        $unidades = Unit::all();
        return view('modules.unidades.list', [
            'unidades' => $unidades
        ]);
    }



    public function showAddClub(AsRegionalRequest $request){
        $zones = Zone::all();
        return view('modules.fields.club_form', [
            'zones' => $zones
        ]);
    }

    public function saveClub(AsRegionalRequest $request){

        $oClub = Club::create([
            'name' => $request->name,
            'logo' => '',
            'photo' => '',
            'zone_id' => $request->zone,
            'field_id' => Auth::user()->member->institutable_id
        ]);
        //event(new AddedClub($oClub));

        return redirect(route('clubes_list'));
    }

    public function showAddClubDirector(AsRegionalRequest $request, Club $club){
        $breadcrumb = collect([
            route('home') => 'Principal',
            route('clubes_list') => 'Clubes',
            route('club_detail', $club->id) => $club->name ,
            'active' => 'Añadir Director'
        ]);

        $positions = Position::where('id',1)->get();

        return view('modules.fields.member_form', [
            'positions' => $positions,
            'breadcrumb' => $breadcrumb,
            'club' => $club
        ]);
    }

    public function saveClubDirector(AsRegionalRequest $request){
        $oMember = Member::create([
            'name' => $request->name,
            'birth_date' => Carbon::create($request->birthdate)->format('Y/m/d'),
            'email' => $request->email,
            'phone' => $request->phone,
            'dni' => $request->dni,
            'institutable_id' => $request->club,
            'institutable_type' => 'App\\Club',
            'active' => 1
        ]);
        $oMember->positions()->save(Position::find(1));
        event(new AddedClubDirectorEvent($oMember));


        return redirect(route('club_detail', $request->club));
    }

    public function setAsDirector(AsRegionalRequest $request, Club $club, Member $new_director){
        if($club->hasDirector()){
            $old_director = $club->director;
            $old_director->positions()->detach([1]);
            event(new RemovedClubDirectorEvent($old_director));
        }

        $new_director->positions()->attach(1);
        event(new AddedClubDirectorEvent($new_director));

        return response()->json([
            'error'=> false,
            'message' => ' El nuevo director del Club ' . $club->name . ' es ' . $new_director->name . '.'
        ]);
    }

    public function sync(AdminUsersRequest $request, Firestore $firestore, Club $club){
        //$fsZone = $firestore->collection('zones')->document($club->zone->firestore_reference);
        $fsClubs = $firestore->collection('clubs');
        $newFsClub = $fsClubs->document(Str::random(20));
        $snapshot = $newFsClub->set([
            'databaseID' => $club->id,
            'name' => $club->name,
            'active' => $club->active,
            'zoneName' => $club->zone->name
        ])->snapshot();


        foreach ($club->units as $unit){
            $fsUnits = $firestore->collection('units');
            $newFsUnit = $fsUnits->document(Str::random(20));
            $data = [
                'databaseID' => $unit->id,
                'name' => $unit->name,
                'code' => $unit->code,
                'clubName' => $unit->club->name,
                'zoneName' => $unit->club->zone->name,
                'active' => true,
                'image' => '',
                'count_members' => $unit->members->count()
            ];

            $newFsUnit->set($data);
        }

        $data = $snapshot->data();
        return response()->json([
            'error' => false,
            'data' => $data,
            'message' => 'El <strong> Club ' . $data['name']. '</strong> se ha sicnronizado con éxito.'
        ]);
    }
}