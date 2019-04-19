<?php

namespace App\Http\Controllers\Auth;

use App\Club;
use App\Http\Requests\ClubActivateRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\ClubActivationConfirm;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function showRegistrationForm()
    {
        $clubes = Club::disabled()->get();

        return view('auth.activate', [
            'clubes' => $clubes
        ]);
    }

    public function register(RegisterRequest $request){
        $error      = false;
        $msg        = '';
        $email      = $request->get('email');
        $password   = $request->get('password');
        $club       = $request->get('club');

        $oUser = new User();
        $oClub = Club::findOrFail($club);

        $oUser->name             =  $oClub->director->name;
        $oUser->email            =  $oClub->director->email;
        $oUser->password         =  \Hash::make($password);

        if(!$error){
            $oUser->save();
            $oClub->member_id = $oUser->id;
            $oClub->active = 1;
            $oClub->activation_token = null;
            $oClub->save();

            return redirect('/login')->with(['alert'=>true,'type'=>'success', 'msg'=>'El Club de Conquistadores '. $oClub->name .' ha sido activado con éxito!.']);
        }else{
            return redirect('/register')->with(['alert'=>true,'type'=>'danger', 'msg'=> $msg]);
        }
    }

    public function confirmActivation($token){
        $oClub = Club::where('activation_token',$token)->first();
        return view('auth.confirm', [
            'club' => $oClub
        ]);
    }


    public function activate(ClubActivateRequest $request){
        $token = Str::random(50);
        $oClub = Club::find($request->club);
        $message = "";
        $error = false;

        if(!$oClub->hasToken()){
            $oClub->activation_token = $token;
            $oClub->save();
            Mail::queue(new ClubActivationConfirm($oClub));
            $message = "Se ha enviado un email de confirmación al director del Club.";
        }else{
            $error = true;
            $message = "Este club ya tiene un intento de activación pendiente y debe completarse mediante el email enviado al director.";
        }

        return response()->json([
            'error' => $error,
            'message' => $message
        ]);
    }
}
