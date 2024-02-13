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
     * Display a listing of the resource.
     */
    public function __construct()  
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        //
        $habitacionbuscar = ($request->get('habitacion')) ? $request->get('habitacion') : '';
        $categoriabuscar = ($request->get('categoria')) ? $request->get('categoria') : '_all_';
        $estadocategoria = ($request->get('estado')) ? $request->get('estado') : '_all_';
        
        $categorias = Categoria::getCategorias();
        $ubicaciones = Ubicacion::getUbicaciones();
        $habitaciones = Habitacion::getListHabitaciones($habitacionbuscar, $categoriabuscar, $estadocategoria);

        $ruta = 'habitaciones';

        if($request->ajax()):
            return view('data.load_habitaciones_data', compact('categorias','habitaciones', 'ubicaciones', 'ruta'));
        endif;

        return view('modules.habitaciones', compact('categorias','habitaciones', 'ubicaciones', 'ruta'));
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
            'habitacion'=>'required|unique:habitaciones|numeric',
            'categoriaHabitacion' => 'required',
            'ubicacionHabitacion' => 'required',
            'detalles' => 'required',
            'precio' => 'required|numeric',
        ];

        $messages = [
            'habitacion.required' => 'El campo Habitación es requerido',
            'habitacion.numeric' => 'El campo Habitación debe ser de tipo númerico',
            'habitacion.unique' => 'La Habitación ya ha sido registrada',
            'categoriaHabitacion.required' => 'El campo Categoría de la Habitación es requerido',
            'ubicacionHabitacion.required' => 'El campo Ubicación de la Habitación es requerido',
            'detalles.required' => 'los Detalles de la habitación son requeridos',
            'precio.required' => 'El Precio de la tarifa para la habitación son requeridos',
            'precio.numeric' => 'El campo Precio debe ser de tipo númerico'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:
            $fileName= '';
            if ($request->hasFile('imagen')):
                $file = $request->imagen->getClientOriginalName();
        
                $fileName = time() . '.' . $request->imagen->getClientOriginalExtension();
                $pathtmp = public_path('img/habitaciones/');

                if (!file_exists($pathtmp)):
                    mkdir($pathtmp, 0777, true);
                endif;
            endif;    

            $data = [
                "categoria_id"=>$request->categoriaHabitacion,
                "ubicacion_id"=>$request->ubicacionHabitacion,
                "habitacion" => $request->habitacion,
                "imagen" => $fileName,
                "detalles"=>trim($request->detalles),
                "precio"=>$request->precio,
                "estado" => 1,
                "created_at"=>now()
            ];

            if(Habitacion::create($data)):
                if ($request->hasFile('imagen')):
                    $request->imagen->move($pathtmp, $fileName);
                endif;
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
        $habitacion = Habitacion::find($id);
        return response()->json($habitacion);
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
            return redirect('/habitaciones');
        endif;

        $rules = [
            'habitacion'=>'required|numeric|unique:habitaciones,habitacion,'.$id.',habitacion_id',
            'categoriaHabitacion' => 'required',
            'ubicacionHabitacion' => 'required',
            'detalles' => 'required',
            'precio' => 'required|numeric',
        ];

        $messages = [
            'habitacion.required' => 'El campo Habitación es requerido',
            'habitacion.numeric' => 'El campo Habitación debe ser de tipo númerico',
            'habitacion.unique' => 'La Habitación ya ha sido registrada',
            'categoriaHabitacion.required' => 'El campo Categoría de la Habitación es requerido',
            'ubicacionHabitacion.required' => 'El campo Ubicación de la Habitación es requerido',
            'detalles.required' => 'los Detalles de la habitación son requeridos',
            'precio.required' => 'El Precio de la tarifa para la habitación son requeridos',
            'precio.numeric' => 'El campo Precio debe ser de tipo númerico'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:

            $habitacion = Habitacion::find($request->habitacion_id);

            if ($request->hasFile('imagen')) {
                $fileName = time() . '.' . $request->imagen->getClientOriginalExtension();
                $pathtmp = public_path('img/habitaciones/');
            } else {
                $fileName = $request->imagen_habitacion;
            }

            $data = [
                "categoria_id"=>$request->categoriaHabitacion,
                "habitacion" => $request->habitacion,
                "imagen" => $fileName,
                "detalles"=>trim($request->detalles),
                "precio"=>$request->precio,
                "estado" => 1,
                "updated_at"=>now()
            ];

            if($habitacion->update($data)):
                if ($request->hasFile('imagen')):
                    $request->imagen->move($pathtmp, $fileName);
                    if ($request->imagen) {
                        File::delete(public_path('img/habitaciones/' . $request->imagen_habitacion));
                    }
                 endif;
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
        $hab = Habitacion::getImgHabitacion($id);

        Habitacion::destroy($id);

        $file = public_path('img/habitaciones/' . $hab['imagen']);

        if (file_exists($file)):
            File::delete($file);
        endif;

        return response()->json(['msg'=>'sucess', 'code' => '200']);
    }

    // public function limpieza($habitacion_id)
    // {
    //     $habitacion = Habitacion::find($habitacion_id);
    //     $data = [
    //         "estado"=>3,
    //     ];
    //     if($habitacion->update($data)):
    //         return response()->json(['msg'=>'sucess', 'code' => '200']);
    //     endif;    
    // }

    // public function mantenimiento($habitacion_id)
    // {
    //     $habitacion = Habitacion::find($habitacion_id);
    //     $data = [
    //         "estado"=>4,
    //     ];
    //     if($habitacion->update($data)):
    //         return response()->json(['msg'=>'sucess', 'code' => '200']);
    //     endif;    
    // }

    public function disponible($habitacion_id)
    {
        $habitacion = Habitacion::find($habitacion_id);
        $data = [
            "estado"=>1,
        ];
        if($habitacion->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif;    
    }

    public function ocupado($habitacion_id)
    {
        $habitacion = Habitacion::find($habitacion_id);
        $data = [
            "estado"=>2,
        ];
        if($habitacion->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif;    
    }

    public function habitaciondetails($id)
    {
        $emp = Habitacion::habitaciondetails($id);
        return response()->json($emp);
    }

    public function habitacionInfo($id)
    {
        $habi = Habitacion::getDataHabitacion($id);
        return response()->json($habi);
    }

}
