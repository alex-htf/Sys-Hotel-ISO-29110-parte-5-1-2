<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Validator;
use App\Models\Ubicacion;
use App\Models\Habitacion;

class UbicacionController extends Controller
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
        // $tarifas = Tarifa::orderBy('tarifa','ASC')->paginate(10);
        $estadoUbicacion = $request->get('estado');

        $ubicaciones = Ubicacion::select('ubicacion_id','ubicacion','estado','created_at');

        if (isset($estadoUbicacion) && $estadoUbicacion!='_all_'):
            $ubicaciones->where('estado',$estadoUbicacion );
        endif;

        $ubicaciones = $ubicaciones->orderBy('ubicacion','ASC')->paginate(10);

        $ruta = 'ubicaciones';

        if ($request->ajax()):
            return view('data.load_ubicaciones_data', compact('ubicaciones', 'ruta'));
        endif;

        return view('modules.ubicaciones', compact('ubicaciones', 'ruta'));
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
            return redirect('/ubicaciones');
        endif;

        $rules = [
            'ubicacion'=>'required|max:40|unique:ubicaciones'
        ];

        $messages = [
            'ubicacion.required' => 'El campo Ubicación es requerido',
            'ubicacion.max' => 'El campo Ubicación debe contener como máximo 40 carácteres',
            'ubicacion.unique' => 'La Ubicación ya existe',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:
            $data = [
                "ubicacion"=>trim($request->ubicacion),
                "estado" => 1,
                "created_at"=>now()
            ];

            if(Ubicacion::create($data)):
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
        $ubicacion = Ubicacion::find($id);
        return response()->json($ubicacion);
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
            return redirect('/ubicaciones');
        endif;

        $rules = [
            'ubicacion'=>'required|max:40|unique:ubicaciones,ubicacion,'.$id.',ubicacion_id'
        ];

        $messages = [
            'ubicacion.required' => 'El campo Ubicación es requerido',
            'ubicacion.max' => 'El campo Ubicación debe contener como máximo 40 carácteres',
            'ubicacion.unique' => 'La Ubicación ya existe',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:

            $ubicacion = Ubicacion::find($request->ubicacion_id);

            $data = [
                "ubicacion"=>trim($request->ubicacion),
                "estado" => 1,
                "updated_at"=>now()
            ];

            if($ubicacion->update($data)):
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
        //
        $ubicacionesregistradasHb = DB::table('habitaciones')->where('ubicacion_id', $id)->count();

        if($ubicacionesregistradasHb > 0):
            return response()->json(['errors'=>$validator->errors(), 'code' => '423']);
        else: 
            Ubicacion::destroy($id);

            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif;

    }

    public function activar($ubicacion_id)
    {
        $ubicacion = Ubicacion::find($ubicacion_id);
        $data = [
            "estado"=>1,
        ];
        if($ubicacion->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif;    
    }

    public function desactivar( $ubicacion_id)
    {
        $ubicacion = Ubicacion::find($ubicacion_id);
        $data = [
            "estado"=>0,
        ];
        if($ubicacion->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif;    
    }

}
