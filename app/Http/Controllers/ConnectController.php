<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConnectController extends Controller
{
    // Método para mostrar la vista de inicio de sesión
    public function getLogin()
    {
        // Retorna la vista 'login'
        return view('login');
    }
}
