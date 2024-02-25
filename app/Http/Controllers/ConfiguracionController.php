<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;
use App\Rules\RucEcuatoriano;


class ConfiguracionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Método para obtener los datos de configuración
    public function getDataConfiguracion()
    {
        // Obtener todas las configuraciones
        $configuraciones = Configuracion::get_Configuraciones();
        $ruta = 'configuraciones';
        // Retornar la vista con los datos de configuración
        return view('modules.configuraciones', compact('configuraciones', 'ruta'));
    }

    // Método para almacenar las configuraciones actualizadas
    public function storeconfiguraciones(Request $request)
    {
        // Obtener los IDs y valores de configuración del formulario
        $configuracion_id = $request->configuracion_id;
        $valor = $request->valor;
        // Iterar sobre cada configuración para actualizarla
        foreach ($configuracion_id as $key => $c) {
            // Verificar si el ID de configuración está presente
            if (isset($configuracion_id[$key])) {
                // Encontrar la configuración por su ID
                $configuracion = Configuracion::find($c);
                // Definir los datos a actualizar
                $data = [
                    "valor" => $valor[$key],
                    "usuario_modifica" => $request->usuario,
                    "fecha_modifica" => now()
                ];
                // Actualizar la configuración con los nuevos datos
                $configuracion->update($data);
            }
        }
        // Retornar una respuesta JSON indicando el éxito de la operación
        return response()->json(['msg' => 'sucess', 'code' => '200', 'url' => url('/configuraciones')]);
    }
}
