<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;

class ConfiguracionController extends Controller
{
    //
    public function __construct()  
    {
        $this->middleware('auth');
    }

    public function getDataConfiguracion()
    {
        $configuraciones = Configuracion::get_Configuraciones();
        $ruta = 'configuraciones';
        return view('modules.configuraciones', compact('configuraciones', 'ruta'));
    }

    public function storeconfiguraciones(Request $request)
    {
        $configuracion_id = $request->configuracion_id;
        $valor = $request->valor;

        foreach($configuracion_id as $key=>$c):
              if(isset($configuracion_id[$key])):
                $configuracion = Configuracion::find($c);
                $data = [
                    "valor" => $valor[$key],
                    "usuario_modifica" => $request->usuario,
                    "fecha_modifica" => now()
                ];
                
                $configuracion->update($data);
              endif;
        endforeach;

        return response()->json(['msg'=>'sucess', 'code' => '200', 'url'=>url('/configuraciones')]);
    }


}
