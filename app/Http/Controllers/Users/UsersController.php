<?php

namespace App\Http\Controllers\Users;

use App\Events\ActivatedUserEvent;
use App\Events\DeactivatedUserEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUsersRequest;
use App\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index(AdminUsersRequest $request){
        return view('modules.users.list', [
            'usuarios' => User::all()
        ]);
    }

    public function toggle(AdminUsersRequest $request ,$user){
        $oUser = tap(User::find($user), function($user){
            $user->toggle();
        });
        $activeText = ($oUser->active == 1)?'activado':'desactivado';
        ($oUser->active == 1)?event(new ActivatedUserEvent($oUser)):event(new DeactivatedUserEvent($oUser));

        return response()->json([
            'isActived' => $oUser->active,
            'message' => 'El Usuario '. $oUser->name . ' ha sido '. $activeText . ' exitosamente'
        ]);
    }
}