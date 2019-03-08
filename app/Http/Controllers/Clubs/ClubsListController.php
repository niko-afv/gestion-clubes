<?php

namespace App\Http\Controllers\Clubs;

use App\Club;
use App\Http\Controllers\Controller;
use App\Imports\ClubsImport;
use App\Imports\MembersImport;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Excel;

class ClubsListController extends Controller
{
    public function index(){
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
}