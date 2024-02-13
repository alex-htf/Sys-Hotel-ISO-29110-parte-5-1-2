<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habitacion;
use App\Models\Tarifa;
use App\Models\Tarifas_Habitaciones;

use DB, Validator;

class TarifaHabitacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()  
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //
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
            return redirect('/habitaciones');
        endif;

        $rules = [
            'habitacion_id' => 'required',
            'tarifa_id'=>'required',
            'precio' => 'required|numeric',
        ];

        $messages = [
            'habitacion_id.required' => 'El código de la Habitación es requerido',
            'tarifa_id.required' => 'El campo Tarifa de la Habitación es requerido',
            'precio.required' => 'El Precio de la tarifa para la habitación son requeridos',
            'precio.numeric' => 'El campo Precio debe ser de tipo númerico',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:

            $existTarifaperHab = DB::table('habitaciones_tarifas')->where('habitacion_id', $request->habitacion_id)->where('tarifa_id',$request->tarifa_id)->count();
            
            if($existTarifaperHab > 0):
                return response()->json(['errors'=>$validator->errors(), 'code' => '426']);
            else:
                $data = [
                    "habitacion_id"=>$request->habitacion_id,
                    "tarifa_id"=>$request->tarifa_id,
                    "precio" => trim($request->precio),
                    "created_at"=>now()
                ];

                if(Tarifas_Habitaciones::create($data)):
                    return response()->json(['msg'=>'sucess', 'code' => '200']);
                else: 
                    return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
                endif;

            endif;
        endif;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $habitaciontarifa = Tarifas_Habitaciones::find($id);
        return response()->json($habitaciontarifa);
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
            'habitacion_id' => 'required',
            'tarifa_id'=>'required',
            'precio' => 'required|numeric',
        ];

        $messages = [
            'habitacion_id.required' => 'El código de la Habitación es requerido',
            'tarifa_id.required' => 'El campo Tarifa de la Habitación es requerido',
            'precio.required' => 'El Precio de la tarifa para la habitación son requeridos',
            'precio.numeric' => 'El campo Precio debe ser de tipo númerico',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:

            $existTarifaperHab = DB::table('habitaciones_tarifas')->where('habitacion_id', $request->habitacion_id)->where('tarifa_id',$request->tarifa_id)->whereNotIn('habitacion_tarifa_id',[$request->habitaciontarifa_id])->count();

            if($existTarifaperHab >  0):
                return response()->json(['errors'=>$validator->errors(), 'code' => '426']);
            else:
                $Tarifas_Habitaciones = Tarifas_Habitaciones::find($request->habitaciontarifa_id);

                $data = [
                    "habitacion_id"=>$request->habitacion_id,
                    "tarifa_id"=>$request->tarifa_id,
                    "precio" => trim($request->precio),
                    "created_at"=>now()
                ];

                if($Tarifas_Habitaciones->update($data)):
                    return response()->json(['msg'=>'sucess', 'code' => '200']);
                else: 
                    return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
                endif;

            endif;
    
        endif;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Tarifas_Habitaciones::destroy($id);

        return response()->json(['msg'=>'sucess', 'code' => '200']);
    }

    public function listarTarifasHabitaciones($id, Request $request)
    {
        $dataHab = Habitacion::select('habitacion')->where('habitacion_id',$id)->first();

        $tarifas = Tarifa::where('estado',1)->orderby('tarifa','ASC')->get();
        $tarifas_habitacion = Tarifas_Habitaciones::getListTarifas($id);
        $habitacion_id = $id;

        if ($request->ajax()) {
            return view('data.load_habitacion_tarifa_data', compact('dataHab','tarifas', 'tarifas_habitacion','habitacion_id'));
        }

        // return view('admin.almacen.subcategorias',$data);
        return view('modules.habitaciones_tarifas', compact('dataHab','tarifas', 'tarifas_habitacion','habitacion_id'));
    }
}
