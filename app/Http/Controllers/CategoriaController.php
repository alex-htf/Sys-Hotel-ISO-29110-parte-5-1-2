<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Validator;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()  
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        //
        $categoriabuscar = $request->get('categoria');
        $estadocategoria = $request->get('estado');
        $categorias = Categoria::select('categoria_id','categoria','descripcion','estado','created_at');
        if (isset($categoriabuscar) && $categoriabuscar != ''):
            $categorias ->where('categoria','LIKE','%'.$categoriabuscar."%");
        endif;     

        if (isset($estadocategoria) && $estadocategoria!='_all_'):
            $categorias->where('estado',$estadocategoria );
        endif;
        $categorias = $categorias->orderBy('categoria','ASC')->paginate(10);

        $ruta = 'categorias';

        if ($request->ajax()):
            return view('data.load_categorias_data', compact('categorias', 'ruta'));
        endif;

        return view('modules.categorias', compact('categorias', 'ruta'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        if (!$request->ajax()):
            return redirect('/categorias');
        endif;

        $rules = [
            'categoria'=>'required|max:40|unique:categorias'
        ];

        $messages = [
            'categoria.required' => 'El campo Categoria es requerido',
            'categoria.max' => 'El campo Categoria debe contener como máximo 40 carácteres',
            'categoria.unique' => 'La categoría ya existe',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:

            $data = [
                "categoria"=>trim($request->categoria),
                "descripcion"=>$request->descripcion,
                "estado" => 1,
                "created_at"=>now()
            ];

            if(Categoria::create($data)):
                return response()->json(['msg'=>'sucess', 'code' => '200']);
            else: 
                return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
            endif;
        endif;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $categoria = Categoria::find($id);
        return response()->json($categoria);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        if (!$request->ajax()):
            return redirect('/categorias');
        endif;

        $rules = [
            'categoria'=>'required|max:40|unique:categorias,categoria,'.$id.',categoria_id'
        ];

        $messages = [
            'categoria.required' => 'El campo Categoria es requerido',
            'categoria.max' => 'El campo Categoria debe contener como máximo 40 carácteres',
            'categoria.unique' => 'La categoría ya existe',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:

            $categoria = Categoria::find($request->categoria_id);

            $data = [
                "categoria"=>trim($request->categoria),
                "descripcion"=>$request->descripcion,
                "estado" => 1,
                "updated_at"=>now()
            ];

            if($categoria->update($data)):
                return response()->json(['msg'=>'sucess', 'code' => '200']);
            else: 
                return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
            endif;
        endif;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoriasregistradasHb = DB::table('habitaciones')->where('categoria_id', $id)->count();

        if($categoriasregistradasHb > 0):
            return response()->json(['errors'=>$validator->errors(), 'code' => '423']);
        else: 
            Categoria::destroy($id);

            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif;

    
    }

    public function activar($categoria_id)
    {
        $categoria = Categoria::find($categoria_id);
        $data = [
            "estado"=>1,
        ];
        if($categoria->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif;    
    }

    public function desactivar( $categoria_id)
    {
        $categoria = Categoria::find($categoria_id);
        $data = [
            "estado"=>0,
        ];
        if($categoria->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif;    
    }
}
