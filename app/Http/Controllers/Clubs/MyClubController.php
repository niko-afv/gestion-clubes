<?php

namespace App\Http\Controllers\Clubs;

use App\Club;
use App\Http\Controllers\Controller;
use App\Imports\ClubsImport;
use App\Imports\MembersImport;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel;

class MyClubController extends Controller
{
    public function index(){
        $club = Auth::user()->member->institutable;

        return view('modules.clubes.detail',[
            'club' => $club
        ]);
    }
}