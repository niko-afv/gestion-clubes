<?php

namespace App\Http\Controllers\Clubs;

use App\Club;
use App\Unit;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddMemberRequest;
use App\Http\Requests\AddUnitRequest;
use App\Http\Requests\RegisterRequest;
use App\Imports\ClubsImport;
use App\Imports\MembersImport;
use App\Member;
use App\Position;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

    public function addMember(){
        $position = Position::all();
        return view('modules.clubes.member_form', [
            'positions' => $position
        ]);
    }

    public function saveMember(AddMemberRequest $request){

        $oMember = Member::create([
            'name' => $request->name,
            'birth_date' => Carbon::create($request->birthdate)->format('Y/m/d'),
            'email' => $request->email,
            'phone' => $request->phone,
            'dni' => $request->dni,
            'institutable_id' => $request->club_id,
            'institutable_type' => 'App\\Club',
            'active' => 1
        ]);
        return redirect(route('my_club'));
    }


    public function showAddUnit(){
        $members = Auth::user()->member->institutable->members()->loose()->get();
        return view('modules.clubes.unit_form', [
            'members' => $members
        ]);
    }

    public function showUpdateUnit(Unit $unit){
        $members = Auth::user()->member->institutable->members()->loose()->get();
        return view('modules.clubes.unit_form', [
            'members' => $members,
            'unit' => $unit
        ]);
    }

    public function saveUnit(AddUnitRequest $request){

        $oUnit = Unit::create([
            'name' => $request->name,
            'description' => $request->description,
            'club_id' => $request->club_id
        ]);

        foreach ($request->members as $member_id){
            $oUnit->members()->save(Member::find($member_id));
        }
        return redirect(route('my_club'));
    }

    public function updateUnit(AddUnitRequest $request, Unit $oUnit){
        $oUnit->name = $request->name;
        $oUnit->description = $request->description;
        $oUnit->save();

        foreach ($request->members as $member_id){
            $oUnit->members()->save(Member::find($member_id));
        }

        return redirect(route('my_club'));
    }

    public function removeMember(Request $request, Unit $unit){
        $oMember = Member::find($request->member)->unit()->dissociate();
        $response = $oMember->save();

        if ($response){
            $error = false;
            $message ='El miembro <strong>' . $oMember->name . '</strong> fue desviculado con éxito de la unidad.';
        }else{
            $error = true;
            $message ='Ocurrió un problema al intentar desvincular a <strong>' . $oMember->name . '</strong> de la unidad.';
        }


        return response()->json([
            'error'=> $error,
            'message' => $message
        ]);
    }
}