<?php

namespace App\Http\Controllers\Clubs;

use App\Club;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminEventsRequest;
use App\Http\Requests\AdminUsersRequest;
use App\Imports\ClubsImport;
use App\Imports\MembersImport;
use App\Unit;
use App\Zone;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Maatwebsite\Excel\Excel;
use Morrislaptop\Firestore\Firestore;
use Morrislaptop\Firestore\Query;

class ClubsListController extends Controller
{
    public function index(AdminEventsRequest $request){
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