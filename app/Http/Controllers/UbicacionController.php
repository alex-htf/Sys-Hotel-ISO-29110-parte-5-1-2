<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Validator;
use App\Models\Ubicacion;
use App\Models\Habitacion;

class UbicacionController extends Controller
{
    /**
     * Constructor del controlador, aplica el middleware de autenticación a todas las rutas.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra un listado de ubicaciones con opciones de filtrado.
     */
    public function index(Request $request)
    {
        // Obtiene el estado de la ubicación del request
        $estadoUbicacion = $request->get('estado');

        // Obtiene todas las ubicaciones y las filtra según el estado, si está presente
        $ubicaciones = Ubicacion::select('ubicacion_id', 'ubicacion', 'estado', 'created_at');

        if (isset($estadoUbicacion) && $estadoUbicacion != '_all_'):
            $ubicaciones->where('estado', $estadoUbicacion);
        endif;

        // Ordena las ubicaciones por nombre de ubicación en orden ascendente y paginación
        $ubicaciones = $ubicaciones->orderBy('ubicacion', 'ASC')->paginate(10);

        $ruta = 'ubicaciones';

        // Si es una solicitud AJAX, devuelve la vista de datos de ubicaciones
        if ($request->ajax()):
            return view('data.load_ubicaciones_data', compact('ubicaciones', 'ruta'));
        endif;

        // Si no es una solicitud AJAX, devuelve la vista de ubicaciones completa
        return view('modules.ubicaciones', compact('ubicaciones', 'ruta'));
    }

    /**
     * Muestra el formulario para crear una nueva ubicación.
     */
    public function create()
    {
        //
    }

    /**
     * Almacena una nueva ubicación en la base de datos.
     */
    public function store(Request $request)
    {
        // Si no es una solicitud AJAX, redirige a la página de ubicaciones
        if (!$request->ajax()):
            return redirect('/ubicaciones');
        endif;

        // Reglas de validación
        $rules = [
            'ubicacion' => 'required|max:40|regex:/^[a-zA-Z0-9\s]+$/|unique:ubicaciones'
        ];

        // Mensajes de validación personalizados
        $messages = [
            'ubicacion.required' => 'El campo Ubicación es obligatorio',
            'ubicacion.max' => 'El campo Ubicación debe contener como máximo 40 caracteres',
            'ubicacion.unique' => 'La Ubicación ya existe',
        ];

        // Realiza la validación
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validación falla, devuelve errores de validación
        if ($validator->fails()):
            return response()->json(['errors' => $validator->errors(), 'code' => '422']);
        else:
            // Crea un nuevo registro de ubicación con los datos proporcionados
            $data = [
                "ubicacion" => trim($request->ubicacion),
                "estado" => 1,
                "created_at" => now()
            ];

            // Guarda el registro en la base de datos
            if (Ubicacion::create($data)):
                return response()->json(['msg' => 'success', 'code' => '200']);
            else:
                return response()->json(['errors' => $validator->errors(), 'code' => '425']);
            endif;
        endif;
    }

    /**
     * Muestra los detalles de una ubicación específica.
     */
    public function show(string $id)
    {
        // Busca la ubicación por su ID y la devuelve como JSON
        $ubicacion = Ubicacion::find($id);
        return response()->json($ubicacion);
    }

    /**
     * Muestra el formulario para editar una ubicación.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Actualiza una ubicación específica en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        // Si no es una solicitud AJAX, redirige a la página de ubicaciones
        if (!$request->ajax()):
            return redirect('/ubicaciones');
        endif;

        // Reglas de validación
        $rules = [
            'ubicacion' => 'required|max:40|regex:/^[a-zA-Z0-9\s]+$/|unique:ubicaciones,ubicacion,' . $id . ',ubicacion_id'
        ];

        // Mensajes de validación personalizados
        $messages = [
            'ubicacion.required' => 'El campo Ubicación es requerido',
            'ubicacion.max' => 'El campo Ubicación debe contener como máximo 40 caracteres',
            'ubicacion.unique' => 'La Ubicación ya existe',
        ];

        // Realiza la validación
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validación falla, devuelve errores de validación
        if ($validator->fails()):
            return response()->json(['errors' => $validator->errors(), 'code' => '422']);
        else:
            // Busca la ubicación por su ID
            $ubicacion = Ubicacion::find($request->ubicacion_id);

            // Actualiza los datos de la ubicación
            $data = [
                "ubicacion" => trim($request->ubicacion),
                "estado" => 1,
                "updated_at" => now()
            ];

            // Guarda los cambios en la base de datos
            if ($ubicacion->update($data)):
                return response()->json(['msg' => 'success', 'code' => '200']);
            else:
                return response()->json(['errors' => $validator->errors(), 'code' => '425']);
            endif;
        endif;
    }

    /**
     * Elimina una ubicación específica de la base de datos.
     */
    public function destroy(string $id)
    {
        // Verifica si hay habitaciones registradas con esta ubicación
        $ubicacionesRegistradasHb = DB::table('habitaciones')->where('ubicacion_id', $id)->count();

        // Si hay habitaciones registradas, devuelve un error
        if ($ubicacionesRegistradasHb > 0):
            return response()->json(['errors' => $validator->errors(), 'code' => '423']);
        else:
            // Si no hay habitaciones registradas, elimina la ubicación
            Ubicacion::destroy($id);

            return response()->json(['msg' => 'success', 'code' => '200']);
        endif;
    }

    /**
     * Activa una ubicación específica.
     */
    public function activar($ubicacion_id)
    {
        // Busca la ubicación por su ID y actualiza su estado a activo
        $ubicacion = Ubicacion::find($ubicacion_id);
        $data = [
            "estado" => 1,
        ];
        if ($ubicacion->update($data)):
            return response()->json(['msg' => 'success', 'code' => '200']);
        endif;
    }

    /**
     * Desactiva una ubicación específica.
     */
    public function desactivar($ubicacion_id)
    {
        // Busca la ubicación por su ID y actualiza su estado a inactivo
        $ubicacion = Ubicacion::find($ubicacion_id);
        $data = [
            "estado" => 0,
        ];
        if ($ubicacion->update($data)):
            return response()->json(['msg' => 'success', 'code' => '200']);
        endif;
    }
}
