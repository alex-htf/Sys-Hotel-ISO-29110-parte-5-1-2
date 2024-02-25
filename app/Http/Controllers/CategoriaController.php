<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Validator; // Importación de clases necesarias
use App\Models\Categoria; // Importación del modelo Categoria

class CategoriaController extends Controller
{
    /**
     * Constructor de la clase.
     * Se ejecuta al instanciar la clase y aplica el middleware de autenticación a todos los métodos.
     */
    public function __construct()  
    {
        $this->middleware('auth');
    }
    
    /**
     * Muestra una lista de recursos.
     * Recibe una solicitud HTTP y devuelve una vista con la lista de categorías.
     */
    public function index(Request $request)
    {
        // Obtener parámetros de búsqueda
        $categoriabuscar = $request->get('categoria');
        $estadocategoria = $request->get('estado');
        
        // Obtener las categorías desde la base de datos
        $categorias = Categoria::select('categoria_id','categoria','descripcion','estado','created_at');
        
        // Aplicar filtros si existen
        if (isset($categoriabuscar) && $categoriabuscar != '') {
            $categorias->where('categoria','LIKE','%'.$categoriabuscar."%");
        }

        if (isset($estadocategoria) && $estadocategoria!='_all_') {
            $categorias->where('estado',$estadocategoria);
        }
        
        // Paginar los resultados y ordenar alfabéticamente
        $categorias = $categorias->orderBy('categoria','ASC')->paginate(10);

        // Ruta para la paginación
        $ruta = 'categorias';

        // Si la solicitud es AJAX, retornar los datos en formato JSON
        if ($request->ajax()) {
            return view('data.load_categorias_data', compact('categorias', 'ruta'));
        }

        // Retornar vista con las categorías y la ruta de paginación
        return view('modules.categorias', compact('categorias', 'ruta'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     * Este método no se está utilizando actualmente.
     */
    public function create()
    {
        // 
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     * Recibe una solicitud HTTP con los datos de la nueva categoría y los almacena en la base de datos.
     */
    public function store(Request $request)
    {
        // Si no es una solicitud AJAX, redireccionar
        if (!$request->ajax()) {
            return redirect('/categorias');
        }
        
        // Reglas de validación para los campos de la categoría
        $rules = [
            'categoria'=>'required|max:40|unique:categorias',
            'descripcion'=>'required|max:225'
        ];

        // Mensajes de error personalizados para las reglas de validación
        $messages = [
            'categoria.required' => 'El campo Categoría es obligatorio',
            'categoria.max' => 'El campo Categoría debe contener como máximo 40 caracteres',
            'categoria.unique' => 'La categoría ya existe',
            'descripcion.required' => 'El campo Descripción es obligatorio',
            'descripcion.max' => 'El campo Descripción debe contener como máximo 255 caracteres'
        ];

        // Validar los datos de la solicitud con las reglas y mensajes definidos
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validación falla, retornar los errores en formato JSON
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        } else {
            // Si la validación es exitosa, crear la nueva categoría en la base de datos
            $data = [
                "categoria"=>trim($request->categoria),
                "descripcion"=>$request->descripcion,
                "estado" => 1,
                "created_at"=>now()
            ];

            if (Categoria::create($data)) {
                return response()->json(['msg'=>'success', 'code' => '200']);
            } else { 
                return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
            }
        }
    }

    /**
     * Muestra el recurso especificado.
     * Recibe el ID de la categoría y retorna los detalles de la misma en formato JSON.
     */
    public function show(string $id)
    {
        // Buscar la categoría por su ID y retornar los detalles en formato JSON
        $categoria = Categoria::find($id);
        return response()->json($categoria);
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     * Este método no se está utilizando actualmente.
     */
    public function edit(string $id)
    {
        // 
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     * Recibe una solicitud HTTP con los datos actualizados de la categoría y los actualiza en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        // Si no es una solicitud AJAX, redireccionar
        if (!$request->ajax()) {
            return redirect('/categorias');
        }

        // Reglas de validación para los campos de la categoría
        $rules = [
            'categoria'=>'required|max:40|unique:categorias,categoria,'.$id.',categoria_id',
            'descripcion'=>'required|max:225'
        ];

        // Mensajes de error personalizados para las reglas de validación
        $messages = [
            'categoria.required' => 'El campo Categoría es obligatorio',
            'categoria.max' => 'El campo Categoría debe contener como máximo 40 caracteres',
            'categoria.unique' => 'La categoría ya existe',
            'descripcion.required' => 'El campo Descripción es obligatorio',
            'descripcion.max' => 'El campo Descripción debe contener como máximo 255 caracteres'
        ];

        // Validar los datos de la solicitud con las reglas y mensajes definidos
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validación falla, retornar los errores en formato JSON
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        } else {
            // Si la validación es exitosa, buscar la categoría por su ID y actualizar los datos en la base de datos
            $categoria = Categoria::find($request->categoria_id);
            $data = [
                "categoria"=>trim($request->categoria),
                "descripcion"=>$request->descripcion,
                "estado" => 1,
                "updated_at"=>now()
            ];

            if ($categoria->update($data)) {
                return response()->json(['msg'=>'success', 'code' => '200']);
            } else {
                return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
            }
        }
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     * Recibe el ID de la categoría y elimina la categoría de la base de datos si no tiene relaciones.
     */
    public function destroy(string $id)
    {
        // Contar cuántas habitaciones están asociadas a esta categoría
        $categoriasregistradasHb = DB::table('habitaciones')->where('categoria_id', $id)->count();

        // Si hay habitaciones asociadas, retornar un error
        if ($categoriasregistradasHb > 0) {
            return response()->json(['errors'=>$validator->errors(), 'code' => '423']);
        } else {
            // Si no hay habitaciones asociadas, eliminar la categoría de la base de datos
            Categoria::destroy($id);
            return response()->json(['msg'=>'success', 'code' => '200']);
        }
    }

    /**
     * Activa la categoría especificada.
     * Recibe el ID de la categoría y actualiza su estado a activo.
     */
    public function activar($categoria_id)
    {
        // Buscar la categoría por su ID y actualizar su estado a activo
        $categoria = Categoria::find($categoria_id);
        $data = [
            "estado"=>1,
        ];
        if ($categoria->update($data)) {
            return response()->json(['msg'=>'success', 'code' => '200']);
        }
    }

    /**
     * Desactiva la categoría especificada.
     * Recibe el ID de la categoría y actualiza su estado a inactivo.
     */
    public function desactivar($categoria_id)
    {
        // Buscar la categoría por su ID y actualizar su estado a inactivo
        $categoria = Categoria::find($categoria_id);
        $data = [
            "estado"=>0,
        ];
        if ($categoria->update($data)) {
            return response()->json(['msg'=>'success', 'code' => '200']);
        }
    }
}
