<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Validator; // Importa las clases DB y Validator
use App\Models\Habitacion; // Importa el modelo Habitacion

class HomeController extends Controller
{
    // Constructor de la clase
    public function __construct()
    {
        // Aplica el middleware 'auth' a todos los métodos de este controlador
        $this->middleware('auth');
    }

    // Método para obtener el panel de control (dashboard)
    public function getDashboard()
    {
        // Contar el total de habitaciones en la base de datos
        $totalHabitaciones = DB::table('habitaciones')->count();

        // Contar el total de habitaciones disponibles (estado = 1)
        $totalHabitacionesdisponibles = DB::table('habitaciones')->where('estado', 1)->count();

        // Contar el total de habitaciones ocupadas (estado = 2)
        $totalHabitacionesocupadas = DB::table('habitaciones')->where('estado', 2)->count();

        // Contar el total de habitaciones en limpieza (estado = 3)
        $totalHabitacioneslimpieza = DB::table('habitaciones')->where('estado', 3)->count();

        // Ruta para el enlace de retorno en el panel de control
        $ruta = '/';

        // Retorna la vista 'dashboard' con los datos obtenidos
        return view('dashboard', compact('totalHabitaciones', 'totalHabitacionesdisponibles', 'totalHabitacionesocupadas', 'totalHabitacioneslimpieza', 'ruta'));
    }

    // Método para mostrar la página de error 404 (no encontrado)
    public function get404NotFound()
    {
        // Retorna la vista '404'
        return view('404');
    }
}
