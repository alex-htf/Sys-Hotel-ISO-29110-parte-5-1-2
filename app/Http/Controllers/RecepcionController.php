<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Habitacion;
use App\Models\Tipo_Documento;
use App\Models\Persona;
use App\Models\Proceso;
use App\Models\Ubicacion;
use App\Models\Configuracion;
use DB, Validator;
use App\Rules\CedulaEcuatoriana;
use App\Rules\RucEcuatoriano;
use PDF;

class RecepcionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Método para obtener la vista de recepción
    public function getRecepcion(Request $request)
    {
        $ubicacionbuscar = ($request->get('ubicacion')) ? $request->get('ubicacion') : '_all_';
        $habitaciones = Habitacion::getListRecepcionHabitacion($ubicacionbuscar);
        $ubicaciones = Ubicacion::getUbicaciones();
        $ruta = 'recepcion';
        if ($request->ajax()):
            return view('data.load_recepciones_data', compact('habitaciones', 'ubicaciones', 'ruta'));
        endif;
        return view('modules.recepciones', compact('habitaciones', 'ubicaciones', 'ruta'));
    }

    // Método para obtener la vista de proceso de recepción para una habitación específica
    public function getRecepcionProceso($id)
    {
        $verificarEstado = Habitacion::getEstado($id);
        if ($verificarEstado->estado != "1"):
            return redirect('/recepcion');
        endif;
        $dataHabitacion = Habitacion::getDataHabitacion($id);
        $tipodocs = Tipo_Documento::all();
        $habitacionid = $id;
        $ruta = 'recepcion';
        return view('modules.recepcion_proceso', compact('dataHabitacion', 'tipodocs', 'habitacionid', 'ruta'));
    }

    // Método para almacenar los datos de la recepción
    public function store(Request $request)
    {
        if (!$request->ajax()):
            return redirect('/recepcion');
        endif;
        $rules = [
            'tipo_documento' => 'required',
            'nomCliente' => 'required|regex:/^[a-zA-Z\s]+$/|max:100',
            'direCliente' => 'required|max:100',
            'telCliente' => 'required|digits:10',
            'emailCliente' => 'required|email',
            'observacionesCliente' => 'max:150',
            'cantidadnoches' => 'required|min:1',
            'cantidadpersonas' => 'required|min:1',
            'fechaSalida' => 'required',
            'horasalida' => 'required',
        ];

        // Valida si el tipo de documento es pasaporte
        if ($request->tipo_documento == "3"):
            $rules["num_doc"] = "required|regex:/^[a-zA-Z0-9\s]+$/|between:6,15";

        // Valida si el tipo de documento es ruc
        elseif ($request->tipo_documento == "2"):
            $rules["num_doc"] = ['required', new RucEcuatoriano];

        // Valida si el tipo de documento es cedula
        elseif ($request->tipo_documento == "1"):
            $rules["num_doc"] = ['required', new CedulaEcuatoriana];
        endif;

        $messages = [
            'tipo_documento.required' => 'El campo tipo de documento es requerido',
            'nomCliente.required' => 'El campo nombre del cliente es requerido',
            'emailCliente.required' => 'El email debe ser requerido',
            'emailCliente.email' => 'El email del cliente debe ser un formato válido',
            'direCliente.required' => 'La dirección del cliente es requerida',
            'telCliente.required' => 'El Teléfono del Cliente es requerido',
            'telCliente.digits' => 'El Número de documento debe ser númerico de 10 dígitos',
            'cantidadnoches.required' => 'La cantidad de noches es requerida',
            'cantidadnoches.min' => 'La cantidad de noches como mínima es 1',
            'cantidadpersonas.required' => 'La cantidad de Personas es requerida',
            'cantidadpersonas.min' => 'La cantidad de Personas como mínima es 1',
            'fechaSalida.required' => 'La fecha de salida es requerida',
            'horasalida.required' => 'La Hora de salida es requerida',
        ];

        if ($request->tipo_documento == "3"):
            $messages["num_doc.required"] = "el campo número de documento es requerido";
            $messages["num_doc.regex"] = "Debe ingresar un formato válido para pasaporte";
            $messages["num_doc.between"] = "Debe ingresar entre 6 y 15 caracteres";

        elseif ($request->tipo_documento == "2"):
            $messages["num_doc.required"] = "el campo número de documento es requerido";
            $messages["num_doc.digits"] = "El Número de documento debe ser númerico de 13 dígitos";

        elseif ($request->tipo_documento == "1"):
            $messages["num_doc.required"] = "el campo número de documento es requerido";
        endif;

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()):
            return response()->json(['errors' => $validator->errors(), 'code' => '422']);
        else:
            $preciototal = '';
            $preciototalF = '';

            // Verificar si el cliente existe 
            $existClient = DB::table('personas')->where('tipo_documento_id', $request->tipo_documento)->where('documento', $request->num_doc)->count();
            $cliente_id = '';

            if ($existClient > 0):
                $clientinfo = DB::table('personas')->select('persona_id')->where('tipo_documento_id', $request->tipo_documento)->where('documento', $request->num_doc)->first();
                $cliente_id = $clientinfo->persona_id;
            else:
                $dataCliente = [
                    "tipo_documento_id" => $request->tipo_documento,
                    "documento" => $request->num_doc,
                    "nombre" => $request->nomCliente,
                    "direccion" => $request->direCliente,
                    "telefono" => $request->telCliente,
                    "email" => $request->emailCliente,
                    "created_at" => now()
                ];

                if ($cliente = Persona::create($dataCliente)):
                    $cliente_id = $cliente->persona_id;
                else:
                    return response()->json(['errors' => $validator->errors(), 'code' => '425']);
                    exit;
                endif;
            endif;

            // Validar el número de serie;
            $preciototal = $request->hddpricet * $request->cantidadnoches;
            $preciototalF = $preciototal * $request->cantidadpersonas;
            $fecha = $request->fechaSalida;
            $hora = $request->horasalida;
            $fechaSalida = $fecha . ' ' . $hora;

            $dataProceso = [
                "habitacion_id" => $request->hddhabitacion_id,
                "cliente_id" => $cliente_id,
                "cant_noches" => $request->cantidadnoches,
                "cant_personas" => $request->cantidadpersonas,
                "total" => number_format((float) $preciototalF, 2, '.', ''),
                "fecha_entrada" => now(),
                "fecha_salida" => $fechaSalida,
                "observaciones" => $request->observacionesCliente,
                "estado" => '1',
                "created_at" => now()
            ];

            if (Proceso::create($dataProceso)):
                Habitacion::habitacionOcupada($request->hddhabitacion_id);
                return response()->json(['msg' => 'sucess', 'code' => '200', 'url' => url('/recepcion')]);
            else:
                return response()->json(['errors' => $validator->errors(), 'code' => '425']);
            endif;
        endif;
    }

    // Método para obtener la vista de proceso de salida para una habitación específica
    public function getProcesoSalida($id)
    {
        $verificarEstado = Habitacion::getEstado($id);
        // validamos si la habitación esta ocupada
        if ($verificarEstado->estado != "2"):
            return redirect('/recepcion');
        endif;

        $dataRecepcion = Proceso::getRecepcionData($id);
        $ruta = 'recepcion';
        if ($dataRecepcion == NULL):
            return redirect('/recepcion');
        endif;
        return view('modules.recepcion_salida', compact('dataRecepcion', 'ruta'));
    }

    // Método para generar el comprobante de salida
    public function generarComprobante(Request $request)
    {
        $proceso_id = $request->hddproceso_id;
        self::udptGenComprobante($proceso_id);
        return response()->json(['msg' => 'sucess', 'code' => '200', 'url' => url('/recepcion/comprobante/' . $proceso_id)]);
    }

    // Método para actualizar el estado del proceso y marcar como generado el comprobante
    public function udptGenComprobante($proceso_id)
    {
        $habitacioniD = Proceso::getHabitacionProcesoId($proceso_id);
        $hdisponible = Habitacion::habitacionDisponible($habitacioniD->habitacion_id);
        $proceso = Proceso::find($proceso_id);

        $data = [
            "estado" => 0,
        ];
        $proceso->update($data);
    }

    // Método para mostrar el comprobante generado
    public function postComprobante($proceso_id)
    {
        $estadoProceso = Proceso::select('estado')->where('proceso_id', $proceso_id)->first();
        if ($estadoProceso->estado != "0"):
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

        $nombreHotel = Configuracion::get_valorxvariable('nombre_hotel');
        $rucHotel = Configuracion::get_valorxvariable('ruc');
        $direccionHotel = Configuracion::get_valorxvariable('direccion_hotel');
        $telHotel = Configuracion::get_valorxvariable('telefono_hotel');
        $emailHotel = Configuracion::get_valorxvariable('email_hotel');

        $ruta = 'recepcion';

        return view('modules.comprobante', compact(
            'dataFactura',
            'diaIngreso',
            'mesIngresoEspañol',
            'añoIngreso',
            'diaSalida',
            'mesSalidaEspañol',
            'añoSalida',
            'nombreHotel',
            'rucHotel',
            'direccionHotel',
            'telHotel',
            'emailHotel',
            'ruta'
        ));
    }

    // Método para obtener la lista de historial de recepciones
    public function getListHistorial(Request $request)
    {
        $categoriabuscar = ($request->get('categoria')) ? $request->get('categoria') : '_all_';
        $ubicacionbuscar = ($request->get('ubicacion')) ? $request->get('ubicacion') : '_all_';
        $categorias = Categoria::getCategorias();
        $ubicaciones = Ubicacion::getUbicaciones();
        $dataHistorial = Proceso::getDataHistorial($categoriabuscar, $ubicacionbuscar);
        $ruta = 'historial';

        if ($request->ajax()):
            return view('data.load_historial_data', compact('dataHistorial', 'categorias', 'ubicaciones'));
        endif;
        return view('modules.historial-recepcion', compact('dataHistorial', 'categorias', 'ubicaciones', 'ruta'));
    }

    // Método para obtener el nombre del mes en español
    public function mesEspañol($mes)
    {
        $mesEspañol = '';
        switch ($mes) {
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
