<?php

namespace App\Http\Controllers;

use App\Club;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'actived_clubs' => Club::where('active', 1)->count(),
            'deactived_clubs' => Club::where('active', 0)->count(),
        ];
        return view('home', $data);
    }
}
