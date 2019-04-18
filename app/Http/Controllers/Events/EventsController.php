<?php

namespace App\Http\Controllers\Events;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Excel;

class EventsController extends Controller
{
    public function index(){
        $events = Event::all();
        return view('modules.events.list', [
            'events' => $events
        ]);
    }

    public function detail(Event $event){
        return view('modules.events.detail',[
            'event' => $event
        ]);
    }

    public function import(){
        $excel = App::make(Excel::class);
        //$excel->import(new ClubsImport(), storage_path('app/import/clubes_import.csv'));
        //$excel->import(new MembersImport(), storage_path('app/import/members_import.csv'));

        return redirect(route('events_list'))->with('success', 'All good!');
    }
}