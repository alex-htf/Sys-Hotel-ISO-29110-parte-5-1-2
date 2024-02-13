<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest')->except('getLogout');
    }

    public function getLogin()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $rules = [
            'LoginUsuario' => 'required',
            'LoginPassword' => 'required|min:6',
        ];

        $messages = [
            'LoginUsuario.required' => 'El usuario es requerido',
            'LoginPassword.required' => 'La contraseña es requerida',
            'LoginPassword.min' => 'La contrseña debe tener mínimo 6 carácteres',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error.')->with('typealert','danger');
        else:

            $credentials = (['usuario' =>$request->input('LoginUsuario'), 'password'=>$request->input('LoginPassword'), 'estado' => 1]);
            if (Auth::attempt($credentials)):
                $request->session()->regenerate();
                return redirect()->route('dashboard');
            else:
                return back()->with('message','Las credenciales son incorrectas.')->with('typealert','danger');
            endif;

        endif;
    }


    public function getLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
