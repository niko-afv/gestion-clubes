<?php

namespace App\Http\Controllers\Fields;

use App\Club;
use App\Events\AddedClubDirectorEvent;
use App\Events\AddedMemberEvent;
use App\Events\AddedUserEvent;
use App\Events\CreatedUnitEvent;
use App\Events\DeletedMemberEvent;
use App\Events\RemovedClubDirectorEvent;
use App\Events\UpdatedMemberEvent;
use App\Events\UpdatedUnitEvent;
use App\Http\Requests\AddFieldMemberRequest;
use App\Http\Requests\AdminEventsRequest;
use App\Http\Requests\AsRegionalRequest;
use App\Http\Requests\MyClubRequest;
use App\Http\Requests\SaveUserRequest;
use App\Imports\SGCMembersImport;
use App\Imports\SGCToMembersImport;
use App\Profile;
use App\Unit;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddMemberRequest;
use App\Http\Requests\AddUnitRequest;
use App\Member;
use App\Position;
use App\User;
use App\Zone;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Matrix\Exception;
use Morrislaptop\Firestore\Firestore;

class MyFieldController extends Controller
{

    public function index(AsRegionalRequest $request){
        $field = Auth::user()->member->institutable;
        return view('modules.fields.detail',[
            'field' => $field
        ]);
    }

    public function showAddMember(AsRegionalRequest $request){
        $breadcrumb = collect([
            route('home') => 'Principal',
            route('my_field') => Auth::user()->member->institutable->name ,
            'active' => 'Nuevo Miembro'
        ]);
        $position = Position::all();
        return view('modules.fields.member_form', [
            'positions' => $position,
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function saveMember(AddFieldMemberRequest $request){

        $oMember = Member::create([
            'name' => $request->name,
            'birth_date' => Carbon::create($request->birthdate)->format('Y/m/d'),
            'email' => $request->email,
            'phone' => $request->phone,
            'dni' => $request->dni,
            'institutable_id' => Auth::user()->member->institutable->id,
            'institutable_type' => 'App\\Field',
            'active' => 1
        ]);

        event(new AddedMemberEvent($oMember));

        if ($request->has('positions')){
            foreach ($request->positions as $position_id){
                $oMember->positions()->save(Position::find($position_id));
            }
        }

        return redirect(route('my_field'));
    }

    public function showUserForm(AsRegionalRequest $request, Member $member){
        $profiles = Profile::all();
        return view('modules.fields.user_form', [
            'profiles' => $profiles,
            'member' => $member
        ]);
    }

    public function saveUser(SaveUserRequest $request, Member $member){
        $data = [
            'email' => $member->email,
            'name' => $member->name,
            'password' => Hash::make($request->password),
            'active' => 1
        ];
        if (isset($member->user)){
            $oUser = User::find($member->user()->update($data));
        }else{
            $oUser = $member->user()->create($data);
        }

        event(new AddedUserEvent($oUser));

        return redirect(route('my_field'));
    }

    public function showUpdateMember(AsRegionalRequest $request, Member $member){
        $breadcrumb = collect([
            route('home') => 'Principal',
            route('my_field') => Auth::user()->member->institutable->name ,
            'active' => 'Modificar Miembro'
        ]);
        $newarray = [];
        foreach ($member->positions as $position){
            $newarray[] = $position->id;
        }

        $position = Position::all()->except($newarray)->all();
        return view('modules.fields.member_form', [
            'positions' => $position,
            'member' => $member,
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function updateMember(AddFieldMemberRequest $request, Member $member){
        $member->name = $request->name;
        $member->birth_date = Carbon::create($request->birthdate)->format('Y/m/d');
        $member->email = $request->email;
        $member->phone = $request->phone;
        $member->dni = $request->dni;
        $member->save();

        event(new UpdatedMemberEvent($member));

        if ($request->has('positions')){
            foreach ($request->positions as $position_id){
                $member->positions()->save(Position::find($position_id));
            }
        }

        return redirect(route('my_field'));
    }

    public function removePosition(MyClubRequest $request, Member $member){
        $member->positions()->detach([$request->position]);
        $response = $member->save();

        if ($response){
            $error = false;
            $message ='El cargo fue desviculado con éxito.';
        }else{
            $error = true;
            $message ='Ocurrió un problema al intentar desvincular el cargo del miembro.';
        }


        return response()->json([
            'error'=> $error,
            'message' => $message
        ]);
    }

    public function removeMember(MyClubRequest $request, Unit $unit){
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

    public function deleteMember(MyClubRequest $request){
        $member = Member::find($request->member_id);
        $response = $member->delete();

        event(new DeletedMemberEvent($member));

        if ($response){
            $error = false;
            $message ='El miembro <strong>' . $member->name . '</strong> fue eliminado con éxito.';
        }else{
            $error = true;
            $message ='Ocurrió un problema al intentar eliminar a <strong>' . $member->name . '</strong> del sistema.';
        }


        return response()->json([
            'error'=> $error,
            'message' => $message
        ]);
    }
}