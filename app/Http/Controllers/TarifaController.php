<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Validator;
use App\Models\Tarifa;

class TarifaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()  
    {
        $this->middleware('auth');
    }
    
    public function index(Request  $request)
    {
        //
        $tarifas = Tarifa::orderBy('tarifa','ASC')->paginate(10);

        if ($request->ajax()):
            return view('data.load_tarifa_data', compact('tarifas'));
        endif;

        return view('modules.tarifas', compact('tarifas'));
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
            return redirect('/tarifas');
        endif;

        $rules = [
            'tarifa'=>'required|max:40|unique:tarifas'
        ];

        $messages = [
            'tarifa.required' => 'El campo Tarifa es requerido',
            'tarifa.max' => 'El campo Tarifa debe contener como máximo 40 carácteres',
            'tarifa.unique' => 'La tarifa ya existe',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:

            $data = [
                "tarifa"=>trim($request->tarifa),
                "estado" => 1,
                "created_at"=>now()
            ];

            if(Tarifa::create($data)):
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
        $tarifa = Tarifa::find($id);
        return response()->json($tarifa);
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
            return redirect('/tarifas');
        endif;

        $rules = [
            'tarifa'=>'required|max:40|unique:tarifas,tarifa,'.$id.',tarifa_id'
        ];

        $messages = [
            'tarifa.required' => 'El campo Tarifa es requerido',
            'tarifa.max' => 'El campo Tarifa debe contener como máximo 40 carácteres',
            'tarifa.unique' => 'La Tarifa ya existe',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:

            $tarifa = Tarifa::find($id);

            $data = [
                "tarifa"=>trim($request->tarifa),
                "estado" => 1,
                "updated_at"=>now()
            ];

            if($tarifa->update($data)):
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
        Tarifa::destroy($id);

        return response()->json(['msg'=>'sucess', 'code' => '200']);
    }

    public function activar($tarifa_id)
    {
        $tarifa = Tarifa::find($tarifa_id);
        $data = [
            "estado"=>1,
        ];
        if($tarifa->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif;    
    }

    public function desactivar( $tarifa_id)
    {
        $tarifa = Tarifa::find($tarifa_id);
        $data = [
            "estado"=>0,
        ];
        if($tarifa->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif;    
    }
}
