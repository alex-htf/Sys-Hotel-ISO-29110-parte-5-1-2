<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Habitacion;
use App\Models\Tipo_Documento;
use App\Models\Tarifas_Habitaciones;
use App\Models\Tipo_Pago;
use App\Models\Tipo_Comprobante;
use App\Models\Persona;
use App\Models\Proceso;
use App\Models\Ubicacion;
use App\Models\Configuracion;
use DB, Validator;
use PDF;

class RecepcionController extends Controller
{
    //

    public function __construct()  
    {
        $this->middleware('auth');
    }
    

    public function getRecepcion(Request $request)
    {
        $ubicacionbuscar = ($request->get('ubicacion')) ? $request->get('ubicacion') : '_all_';

        $habitaciones = Habitacion::getListRecepcionHabitacion($ubicacionbuscar);

        $ubicaciones = Ubicacion::getUbicaciones();

        $ruta = 'recepcion';

        if($request->ajax()):
            return view('data.load_recepciones_data', compact('habitaciones', 'ubicaciones','ruta'));
        endif;

        return view('modules.recepciones', compact('habitaciones', 'ubicaciones', 'ruta'));
    }

    public function getRecepcionProceso($id)
    {
        $verificarEstado= Habitacion::getEstado($id);
        
        if($verificarEstado->estado != "1"):
            return redirect('/recepcion');
        endif;

        $dataHabitacion = Habitacion::getDataHabitacion($id);
        $tipodocs  = Tipo_Documento::all();
        $tipopags  = Tipo_Pago::all();
        // $tarifashab = Tarifas_Habitaciones::getListTarifas($id);
        // $tipocomprobante = Tipo_Comprobante::all();
        $habitacionid= $id;

        $ruta = 'recepcion';

        return view('modules.recepcion_proceso', compact('dataHabitacion', 'tipodocs', 'tipopags','habitacionid', 'ruta'));   
    }

    public function store(Request $request)
    {
        if (!$request->ajax()):
            return redirect('/recepcion');
        endif;

        $rules = [
            'tipo_documento'=>'required',
            'num_doc' => 'required|min:8',
            'nomCliente' => 'required',
            // 'razonsocialCiente' => 'required',
            // 'tarifa_hab' => 'required',
            'cantidadnoches' => 'required|min:1',
            'cantidadpersonas' => 'required|min:1',
            // 'Tipo_comprobante' => 'required',
            'estado_pago' => 'required',
            'fechaSalida'=>'required',
            'horasalida' => 'required',
        ];

        $messages = [
            'tipo_documento.required' => 'El campo tipo de documento es requerido',
            'num_doc.required' => 'El Campo Número de Documento debe ser requerido',
            'num_doc.min' => 'El Campo Número de Documento debe tener como mínimo 8 carácteres',
            'nomCliente.required' => 'El campo nombre del cliente es requerido',
            // 'razonsocialCiente.required' => 'El campo razon social es requerido',
            // 'tarifa_hab.required' => 'La tarifa de la habitación es requerida',
            'cantidadnoches.required' => 'La cantidad de noches es requerida',
            'cantidadnoches.min' => 'La cantidad de noches como mínima es 1',
            'cantidadpersonas.required' => 'La cantidad de Personas es requerida',
            'cantidadpersonas.min' => 'La cantidad de Personas como mínima es 1',
            // 'Tipo_comprobante.required' => 'El tipo de comprobante es requerido',
            'estado_pago.required' => 'El estado de pago es requerido',
            'fechaSalida.required' => 'La fecha de salida es requerida',
            'horasalida.required' => 'La Hora de salida es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:

            // $serie = '';
            $tipopago = '';
            $noperacion = '';
            $preciototal = '';
            $preciototalF = '';

            if($request->estado_pago == "1"):
                if($request->tipo_pago == ""):
                    return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
                    exit;
                elseif($request->tipo_pago == "1"):
                    $tipopago = $request->tipo_pago;
                endif;
            endif;

            // if($request->estado_pago == "1"):
            //     if($request->tipo_pago == ""):
            //         return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
            //         exit;
            //     elseif($request->tipo_pago == "1"):
            //         $tipopago = $request->tipo_pago;
            //     elseif($request->tipo_pago == "2" || $request->tipo_pago == "3"):
            //         $tipopago = $request->tipo_pago;
            //         if($request->nro_operacion == ""):
            //             return response()->json(['errors'=>$validator->errors(), 'code' => '426']);
            //             exit;
            //         else:
            //             $noperacion = $request->nro_operacion;
            //         endif;
            //     endif;
            // endif;

            //Verificar si el cliente existe 
            $existClient = DB::table('personas')->where('tipo_documento_id', $request->tipo_documento)->where('documento',$request->num_doc)->count();
            
            $cliente_id='';
           
            if($existClient>0):
                $clientinfo = DB::table('personas')->select('persona_id')->where('tipo_documento_id', $request->tipo_documento)->where('documento',$request->num_doc)->first();
                $cliente_id = $clientinfo->persona_id;
            else:

                $dataCliente = [
                    "tipo_documento_id"=>$request->tipo_documento,
                    "documento" => $request->num_doc,
                    "nombre" => $request->nomCliente,
                    // "razon_social"=>$request->razonsocialCiente,
                    "direccion" => $request->direCliente,
                    "telefono" => $request->telCliente,
                    "email" => $request->emailCliente,
                    // "observaciones" => $request->observacionesCliente,
                    "created_at"=>now()
                ];

                if($cliente = Persona::create($dataCliente)):
                    $cliente_id = $cliente->persona_id;
                else:
                    return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
                    exit;
                endif;
    
            endif;

            // Validar si es BOleta o Factura
            // if($request->Tipo_comprobante == 1):
            //     // 1 es Factura
            //     $serie = 'F001';
            //     $nrosexist = DB::table('procesos')->where('tipo_comprobante_id','1')->count();
            //     if($nrosexist>1):
            //         $ultimocomprobantenum = Proceso::getmaxNumDoc('1'); 
            //         $newnumcomprobante =   (int) $ultimocomprobantenum + 1;
            //         $numcomprobante = str_pad($newnumcomprobante, 8, "0", STR_PAD_LEFT);  
            //     else:
            //         $numcomprobante = '00000001';
            //     endif;

            // elseif($request->Tipo_comprobante == 2):
            //     // 2 es Boleta
            //     $serie = 'B001';
            //     $nrosexist = DB::table('procesos')->where('tipo_comprobante_id','2')->count();
            //     if($nrosexist>1):
            //         $ultimocomprobantenum = Proceso::getmaxNumDoc('2'); 
            //         $newnumcomprobante =   (int) $ultimocomprobantenum + 1;
            //         $numcomprobante = str_pad($newnumcomprobante, 8, "0", STR_PAD_LEFT);  
            //     else:
            //         $numcomprobante = '00000001';
            //     endif;
            // endif;

            // Validar el número de serie;

            $preciototal = $request->hddpricet * $request->cantidadnoches;
            $preciototalF = $preciototal * $request->cantidadpersonas;
            // echo $request->horasalida;exit;
            $fecha = $request->fechaSalida;
            $hora = $request->horasalida;
            $fechaSalida = $fecha.' '.$hora;

            $dataProceso = [
                "habitacion_id"=>$request->hddhabitacion_id,
                "cliente_id"=>$cliente_id,
                // "tarifa_id"=>$request->tarifa_hab,
                // "tipo_comprobante_id"=>$request->Tipo_comprobante,
                // "serie"=>$serie,
                // "numero"=>$numcomprobante,
                // "precio" => number_format((float)$request->hddpricet, 2, '.', ''),
                "cant_noches" => $request->cantidadnoches,
                "cant_personas" => $request->cantidadpersonas,
                "total" => number_format((float)$preciototalF, 2, '.', ''),
                "fecha_entrada" => now(),
                "fecha_salida" =>$fechaSalida,
                // "toallas" => $request->toallastxt,
                "estado_pago" => $request->estado_pago,
                "tipo_pago" => $tipopago,
                "nro_operacion" => $noperacion,
                "observaciones" => $request->observacionesCliente,
                "estado" => '1',
                "created_at" => now()
            ];

            if(Proceso::create($dataProceso)):
                Habitacion::habitacionOcupada($request->hddhabitacion_id);
                return response()->json(['msg'=>'sucess', 'code' => '200', 'url'=>url('/recepcion')]);
            else: 
                return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
            endif;

        endif;

    }

    public function getProcesoSalida($id)
    {
        $verificarEstado= Habitacion::getEstado($id);
        $tipopags  = Tipo_Pago::all();
        //validamos si la habitación esta ocupada
        if($verificarEstado->estado != "2"):
            return redirect('/recepcion');
        endif;
        
        $dataRecepcion = Proceso::getRecepcionData($id);

        $ruta = 'recepcion';

        if($dataRecepcion == NULL):
            return redirect('/recepcion');
        endif;
        
        return view('modules.recepcion_salida', compact('dataRecepcion', 'tipopags', 'ruta'));
    }  

    public function generarComprobante(Request $request)
    {
        $proceso_id = $request->hddproceso_id;
        $tipopago = $request->cbotipopago;
        // $nrooperacionfinal = $request->nrooperacionfinal;
        $nrooperacionfinal = '';
        $estadopago = $request->hddestado_pago;
        if($estadopago == "1"):

          self::udptGenComprobante($proceso_id, $tipopago, $nrooperacionfinal,$estadopago);
          return response()->json(['msg'=>'sucess', 'code' => '200', 'url'=>url('/recepcion/comprobante/'.$proceso_id)]);

        elseif ($estadopago == "2"):

            if($tipopago == ""):

                return response()->json(['code' => '421']);
            elseif($tipopago == "1"):

                self::udptGenComprobante($proceso_id, $tipopago, $nrooperacionfinal, $estadopago);
                return response()->json(['msg'=>'sucess', 'code' => '200', 'url'=>url('/recepcion/comprobante/'.$proceso_id)]);
                
        //     else:

        //         if($nrooperacionfinal == ""):

        //             return response()->json(['code' => '422']);
        //         else:

        //            self::udptGenComprobante($proceso_id, $tipopago, $nrooperacionfinal, $estadopago);
        //            return response()->json(['msg'=>'sucess', 'code' => '200', 'url'=>url('/recepcion/comprobante/'.$proceso_id)]);

        //         endif;
                
            endif;
        
        else:
            return response()->json(['code' => '425']);
        endif;

       
    }

    public function udptGenComprobante($proceso_id, $tipopago, $nrooperacionfinal, $estadopago)
    {
        $habitacioniD = Proceso::getHabitacionProcesoId($proceso_id);
        $hdisponible = Habitacion::habitacionDisponible($habitacioniD->habitacion_id);

        $proceso = Proceso::find($proceso_id);

        $data = [
            "estado"=>0,
        ];

        if($estadopago == 2):
            $data["tipo_pago"] = $tipopago;
            // $data["nro_operacion"] = $nrooperacionfinal;
        endif;
        
        $proceso->update($data);
    }

    public function postComprobante($proceso_id)
    {
        $estadoProceso = Proceso::select('estado')->where('proceso_id', $proceso_id)->first();

        if($estadoProceso->estado != "0"):
            return redirect('/recepcion');
        endif;

        $dataFactura = Proceso::getDataFactura($proceso_id);

        $fechaIngreso = $dataFactura->fecha_entrada;
        $fechaSalida = $dataFactura->fecha_salida;

        $diaIngreso = date('d', strtotime($fechaIngreso));
        $mesIngreso = date('m', strtotime($fechaIngreso));
        $mesIngresoEspañol = self::mesEspañol($mesIngreso);
        $añoIngreso = date('Y', strtotime($fechaIngreso));
        $diaSalida = date('d', strtotime($fechaSalida));
        $mesSalida = date('m', strtotime($fechaSalida));
        $mesSalidaEspañol = self::mesEspañol($mesSalida);
        $añoSalida = date('Y', strtotime($fechaSalida));

        $nombreHotel =  Configuracion::get_valorxvariable('nombre_hotel');
        $rucHotel =  Configuracion::get_valorxvariable('ruc');
        $direccionHotel =  Configuracion::get_valorxvariable('direccion_hotel');
        $telHotel =  Configuracion::get_valorxvariable('telefono_hotel');
        $emailHotel =  Configuracion::get_valorxvariable('email_hotel');
        // $iva =  Configuracion::get_valorxvariable('iva');

        $ruta = 'recepcion';

        return view('modules.comprobante', compact('dataFactura', 'diaIngreso', 'mesIngresoEspañol', 'añoIngreso','diaSalida','mesSalidaEspañol','añoSalida', 'nombreHotel','rucHotel','direccionHotel', 'telHotel', 'emailHotel', 'ruta'));

    }

    public function getListHistorial(Request $request)
    {
        $categoriabuscar = ($request->get('categoria')) ? $request->get('categoria') : '_all_';
        $ubicacionbuscar = ($request->get('ubicacion')) ? $request->get('ubicacion') : '_all_';
        $estadopagobuscar = ($request->get('estado_pago')) ? $request->get('estado_pago') : '_all_';

        $categorias = Categoria::getCategorias();
        $ubicaciones = Ubicacion::getUbicaciones();
        $dataHistorial = Proceso::getDataHistorial($categoriabuscar, $ubicacionbuscar, $estadopagobuscar);

        $ruta = 'historial';

        if($request->ajax()):
            return view('data.load_historial_data', compact('dataHistorial', 'categorias', 'ubicaciones'));
        endif;

        return view('modules.historial-recepcion', compact('dataHistorial', 'categorias', 'ubicaciones', 'ruta'));
    }


    public function mesEspañol($mes)
    {
        $mesEspañol = ''; 
        switch($mes)
        {   
            case "01":
                $mesEspañol = "Enero";
                break;
            case "02":
                $mesEspañol = "Febrero";
                break;
            case "03":
                $mesEspañol = "Marzo";
                break;
            case "04":
                $mesEspañol = "Abril";  
                break;
            case "05":
                $mesEspañol = "Mayo";  
                break;
            case "06":
                $mesEspañol = "Junio";  
                break;
            case "07":
                $mesEspañol = "Julio";  
                break;
            case "08":
                $mesEspañol = "Agosto";  
                break;
            case "09":
                $mesEspañol = "Setiembre";  
                break;
            case "10":
                $mesEspañol = "Octubre";  
                break;
            case "11":
                $mesEspañol = "Noviembre";  
                break;
            case "12":
                $mesEspañol = "Diciembre";  
                break;
        
        }
        return $mesEspañol;
    }

}
