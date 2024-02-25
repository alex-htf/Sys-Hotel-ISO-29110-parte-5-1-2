<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator; // Importa la clase Validator
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    // Constructor de la clase
    public function __construct()
    {
        // Aplica el middleware 'guest' a todos los métodos de este controlador, excepto 'getLogout'
        $this->middleware('guest')->except('getLogout');
    }

    // Método para mostrar el formulario de inicio de sesión
    public function getLogin()
    {
        // Retorna la vista 'login'
        return view('login');
    }

    // Método para procesar el formulario de inicio de sesión
    public function postLogin(Request $request)
    {
        // Reglas de validación para los campos del formulario
        $rules = [
            'LoginUsuario' => 'required',
            'LoginPassword' => 'required|min:6',
        ];

        // Mensajes de error personalizados para las reglas de validación
        $messages = [
            'LoginUsuario.required' => 'El usuario es requerido',
            'LoginPassword.required' => 'La contraseña es requerida',
            'LoginPassword.min' => 'La contraseña debe tener mínimo 6 caracteres',
        ];

        // Validar la solicitud con las reglas y mensajes definidos
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validación falla, redirige de vuelta con los errores
        if ($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error.')->with('typealert', 'danger');
        else:
            // Crear credenciales para la autenticación
            $credentials = (['usuario' => $request->input('LoginUsuario'), 'password' => $request->input('LoginPassword'), 'estado' => 1]);

            // Intentar autenticar al usuario con las credenciales proporcionadas
            if (Auth::attempt($credentials)):
                $request->session()->regenerate(); // Regenerar la sesión después de la autenticación exitosa
                return redirect()->route('dashboard'); // Redirigir al usuario al panel de control
            else:
                // Si las credenciales son incorrectas, volver al formulario de inicio de sesión con un mensaje de error
                return back()->with('message', 'Las credenciales son incorrectas.')->with('typealert', 'danger');
            endif;
        endif;
    }

    // Método para cerrar sesión del usuario
    public function getLogout(Request $request)
    {
        Auth::logout(); // Cerrar sesión
        $request->session()->invalidate(); // Invalidar la sesión
        $request->session()->regenerateToken(); // Regenerar el token de sesión
        return redirect('/'); // Redirigir al usuario a la página de inicio
    }
}
