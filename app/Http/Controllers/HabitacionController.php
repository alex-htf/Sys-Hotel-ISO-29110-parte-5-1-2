<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Validator;
use App\Models\Categoria;
use App\Models\Ubicacion;
use App\Models\Habitacion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class HabitacionController extends Controller
{
    /**
     * Constructor para HabitacionController.
     * Aplicando el middleware 'auth' para proteger las rutas.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar una lista de recursos.
     */
    public function index(Request $request)
    {
        // Obtener parámetros de búsqueda desde la solicitud
        $habitacionbuscar = ($request->get('habitacion')) ? $request->get('habitacion') : '';
        $categoriabuscar = ($request->get('categoria')) ? $request->get('categoria') : '_all_';
        $estadocategoria = ($request->get('estado')) ? $request->get('estado') : '_all_';

        // Obtener categorías y ubicaciones
        $categorias = Categoria::getCategorias();
        $ubicaciones = Ubicacion::getUbicaciones();

        // Obtener lista filtrada de habitaciones
        $habitaciones = Habitacion::getListHabitaciones($habitacionbuscar, $categoriabuscar, $estadocategoria);

        $ruta = 'habitaciones'; // Ruta para solicitudes AJAX

        // Comprobar si la solicitud es AJAX y devolver datos en consecuencia
        if ($request->ajax()):
            return view('data.load_habitaciones_data', compact('categorias', 'habitaciones', 'ubicaciones', 'ruta'));
        endif;

        // Devolver vista con datos
        return view('modules.habitaciones', compact('categorias', 'habitaciones', 'ubicaciones', 'ruta'));
    }

    /**
     * Mostrar el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        //
    }

    /**
     * Almacenar un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        // Redireccionar si no es una solicitud AJAX
        if (!$request->ajax()):
            return redirect('/habitaciones');
        endif;

        // Reglas y mensajes de validación
        $rules = [
            'habitacion' => 'required|digits_between:1,4|unique:habitaciones',
            'categoriaHabitacion' => 'required',
            'ubicacionHabitacion' => 'required',
            'detalles' => 'required|max:150',
            'precio' => 'required|digits_between:1,3'
        ];

        $messages = [
            'habitacion.required' => 'El campo Habitación es obligatorio',
            'habitacion.digits_between' => 'El campo Habitación debe tener entre 1 y 4 dígitos',
            'habitacion.unique' => 'La Habitación ya existe',
            'categoriaHabitacion.required' => 'El campo Categoría de la Habitación es obligatorio',
            'ubicacionHabitacion.required' => 'El campo Ubicación de la Habitación es obligatorio',
            'detalles.required' => 'El campo Detalles es obligatorio',
            'detalles.max' => 'El campo Detalles debe tener hasta 150 caracteres',
            'precio.required' => 'El campo Precio de la habitación es obligatorio',
            'precio.digits_between' => 'El campo Precio debe tener hasta 3 dígitos'
        ];

        // Validar entrada
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validación falla, devolver respuesta de error
        if ($validator->fails()):
            return response()->json(['errors' => $validator->errors(), 'code' => '422']);
        else:
            // Si la validación pasa, manejar datos
            $fileName = '';

            // Si hay un archivo cargado, manejarlo
            if ($request->hasFile('imagen')):
                $file = $request->imagen->getClientOriginalName();

                // Generar nombre de archivo y almacenar el archivo
                $fileName = time() . '.' . $request->imagen->getClientOriginalExtension();
                $pathtmp = public_path('img/habitaciones/');

                if (!file_exists($pathtmp)):
                    mkdir($pathtmp, 0777, true);
                endif;
            endif;

            // Formar un array de datos para almacenar en la base de datos
            $data = [
                "categoria_id" => $request->categoriaHabitacion,
                "ubicacion_id" => $request->ubicacionHabitacion,
                "habitacion" => $request->habitacion,
                "imagen" => $fileName,
                "detalles" => trim($request->detalles),
                "precio" => $request->precio,
                "estado" => 1,
                "created_at" => now()
            ];

            // Intentar crear el registro en la base de datos
            if (Habitacion::create($data)):
                // Mover el archivo cargado a la ubicación designada
                if ($request->hasFile('imagen')):
                    $request->imagen->move($pathtmp, $fileName);
                endif;
                return response()->json(['msg' => 'success', 'code' => '200']);
            else:
                return response()->json(['errors' => $validator->errors(), 'code' => '425']);
            endif;
        endif;
    }

    /**
     * Mostrar el recurso especificado.
     */
    public function show(string $id)
    {
        //
        $habitacion = Habitacion::find($id);
        return response()->json($habitacion);
    }

    /**
     * Mostrar el formulario para editar el recurso especificado.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Actualizar el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, string $id)
    {
        // Redireccionar si no es una solicitud AJAX
        if (!$request->ajax()):
            return redirect('/habitaciones');
        endif;

        // Reglas y mensajes de validación
        $rules = [
            'habitacion' => 'required|digits_between:1,4|unique:habitaciones,habitacion,' . $id . ',habitacion_id',
            'categoriaHabitacion' => 'required',
            'ubicacionHabitacion' => 'required',
            'detalles' => 'required|max:150',
            'precio' => 'required'
        ];

        $messages = [
            'habitacion.required' => 'El campo Habitación es obligatorio.',
            'habitacion.digits_between' => 'El campo Habitación debe tener entre 1 y 4 dígitos',
            'habitacion.unique' => 'El valor del campo Habitación ya ha sido registrado',
            'categoriaHabitacion.required' => 'El campo Categoría de la Habitación es obligatorio',
            'ubicacionHabitacion.required' => 'El campo Ubicación de la Habitación es obligatorio',
            'detalles.required' => 'El campo Detalles es obligatorio',
            'detalles.max' => 'El campo Detalles debe tener hasta 150 caracteres',
            'precio.required' => 'El campo Precio de la habitación es obligatorio'
        ];

        // Validar entrada
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validación falla, devolver respuesta de error
        if ($validator->fails()):
            return response()->json
            (['errors' => $validator->errors(), 'code' => '422']);
        else:
            // Si la validación pasa, manejar datos
            $habitacion = Habitacion::find($request->habitacion_id);

            // Si hay un archivo cargado, manejarlo
            if ($request->hasFile('imagen')) {
                $fileName = time() . '.' . $request->imagen->getClientOriginalExtension();
                $pathtmp = public_path('img/habitaciones/');
            } else {
                $fileName = $request->imagen_habitacion;
            }

            // Formar un array de datos para actualizar en la base de datos
            $data = [
                "categoria_id" => $request->categoriaHabitacion,
                "habitacion" => $request->habitacion,
                "ubicacion_id" => $request->ubicacionHabitacion,
                "imagen" => $fileName,
                "detalles" => trim($request->detalles),
                "precio" => $request->precio,
                "estado" => 1,
                "updated_at" => now()
            ];

            // Intentar actualizar el registro en la base de datos
            if ($habitacion->update($data)):
                // Mover el archivo cargado a la ubicación designada y eliminar el archivo anterior
                if ($request->hasFile('imagen')):
                    $request->imagen->move($pathtmp, $fileName);
                    if ($request->imagen) {
                        File::delete(public_path('img/habitaciones/' . $request->imagen_habitacion));
                    }
                endif;
                return response()->json(['msg' => 'success', 'code' => '200']);
            else:
                return response()->json
                (['errors' => $validator->errors(), 'code' => '425']);
            endif;
        endif;
    }

    /**
     * Eliminar el recurso especificado del almacenamiento.
     */
    public function destroy(string $id)
    {
        // Obtener información de la habitación para obtener el nombre del archivo de imagen
        $hab = Habitacion::getImgHabitacion($id);

        // Eliminar la habitación de la base de datos
        Habitacion::destroy($id);

        // Eliminar el archivo de imagen asociado si existe
        $file = public_path('img/habitaciones/' . $hab['imagen']);

        if (file_exists($file)):
            File::delete($file);
        endif;

        // Devolver respuesta de éxito
        return response()->json(['msg' => 'success', 'code' => '200']);
    }

    /**
     * Marcar la habitación como disponible.
     */
    public function disponible($habitacion_id)
    {
        // Buscar la habitación y actualizar su estado
        $habitacion = Habitacion::find($habitacion_id);
        $data = [
            "estado" => 1,
        ];
        if ($habitacion->update($data)):
            return response()->json(['msg' => 'success', 'code' => '200']);
        endif;
    }

    /**
     * Marcar la habitación como ocupada.
     */
    public function ocupado($habitacion_id)
    {
        // Buscar la habitación y actualizar su estado
        $habitacion = Habitacion::find($habitacion_id);
        $data = [
            "estado" => 2,
        ];
        if ($habitacion->update($data)):
            return response()->json(['msg' => 'success', 'code' => '200']);
        endif;
    }

    /**
     * Obtener detalles de la habitación.
     */
    public function habitaciondetails($id)
    {
        // Obtener detalles de la habitación por su ID
        $emp = Habitacion::habitaciondetails($id);
        return response()->json($emp);
    }

    /**
     * Obtener información de la habitación.
     */
    public function habitacionInfo($id)
    {
        // Obtener información de la habitación por su ID
        $habi = Habitacion::getDataHabitacion($id);
        return response()->json($habi);
    }

}
