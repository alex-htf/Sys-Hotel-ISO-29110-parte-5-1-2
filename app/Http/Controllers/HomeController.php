<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Validator;
use App\Models\Habitacion;

class HomeController extends Controller
{
    //
    public function __construct()  
    {
        $this->middleware('auth');
    }
    
    public function getDashboard()
    {
        $totalHabitaciones = DB::table('habitaciones')->count();

        $totalHabitacionesdisponibles = DB::table('habitaciones')->where('estado',1)->count();

        $totalHabitacionesocupadas = DB::table('habitaciones')->where('estado',2)->count();

        $totalHabitacioneslimpieza = DB::table('habitaciones')->where('estado',3)->count();

        $ruta = '/';

        return view('dashboard', compact('totalHabitaciones', 'totalHabitacionesdisponibles', 'totalHabitacionesocupadas', 'totalHabitacioneslimpieza', 'ruta'));
    }

    public function get404NotFound()
    {
        return view('404');
    }

}
