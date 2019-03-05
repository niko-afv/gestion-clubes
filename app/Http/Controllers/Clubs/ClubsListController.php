<?php

namespace App\Http\Controllers\Clubs;

use App\Club;
use App\Http\Controllers\Controller;

class ClubsListController extends Controller
{
    public function index(){
        $clubes = Club::all();
        return view('modules.clubes.list', [
            'clubes' => $clubes
        ]);
    }
}