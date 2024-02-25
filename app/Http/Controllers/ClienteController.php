<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Tipo_Documento;
use DB, Validator;
use App\Rules\CedulaEcuatoriana;
use App\Rules\RucEcuatoriano;

class ClienteController extends Controller
{
    // Obtiene la información del cliente
    public function getClienteInfo(Request $request)
    {
        $cliente = Persona::getClienteInfo($request->tipodoc, $request->numdoc);
        return response()->json($cliente);
    }

    // Lista los clientes con filtros de búsqueda
    public function lisClient(Request $request)
    {
        $tipodocbuscar = ($request->get('tipo_doc')) ? $request->get('tipo_doc') : '_all_';
        $nrodocbuscar = ($request->get('nrodoc')) ? $request->get('nrodoc') : '';

        $clientes = Persona::getClienteList($tipodocbuscar, $nrodocbuscar);
        $tipo_doc = Tipo_Documento::all();

        $ruta = 'clientes';

        if ($request->ajax()):
            return view('data.load_clientes_data', compact('clientes', 'tipo_doc', 'ruta'));
        endif;

        return view('modules.clientes', compact('clientes', 'tipo_doc', 'ruta'));
    }

    // Obtiene la información de un cliente específico
    public function getClientefind($id)
    {
        $cliente = Persona::find($id);
        return response()->json($cliente);
    }

    // Actualiza la información de un cliente
    public function udpateClient($id, Request $request)
    {
        // Redirige si la solicitud no es AJAX
        if (!$request->ajax()):
            return redirect('/clientes');
        endif;

        // Reglas de validación para la actualización del cliente
        $rules = [
            'cliente' => 'required|max:100|regex:/^[a-zA-Z\s]+$/',
            'tipoDocumentoCliente' => 'required',
            'direccionCliente' => 'required|max:100',
            'tel_Cliente' => 'required|digits_between:7,12',
            'email_cliente' => 'required|email'
        ];

        // Validación específica para diferentes tipos de documento
        if ($request->tipoDocumentoCliente == "3"):
            $rules["nro_documento"] = "required|max:20";
        elseif ($request->tipoDocumentoCliente == "2"):
            $rules["nro_documento"] = ['required', new RucEcuatoriano];
        elseif ($request->tipoDocumentoCliente == "1"):
            $rules["nro_documento"] = ['required', new CedulaEcuatoriana];
        endif;

        // Mensajes de error personalizados
        $messages = [
            'cliente.required' => 'El campo Cliente es requerido',
            'cliente.max' => 'El campo Cliente debe tener hasta 100 caracteres',
            'cliente.regex' => "El nombre de cliente debe contener solo letras",
            'tipoDocumentoCliente.required' => 'El Tipo de Documento es requerido',
            'direccionCliente.required' => 'La Dirección del Cliente es requerida',
            'direccionCliente.max' => 'La Dirección del Cliente debe tener hasta 100 caracteres',
            'tel_Cliente.required' => 'El Teléfono del Cliente es requerido',
            'tel_Cliente.digits_between' => 'El Teléfono del Cliente debe contener de 7 a 12 dígitos',
            'email_cliente.required' => 'El campo Email es requerido',
            'email_cliente.email' => 'El campo Email debe tener un formato válido'
        ];

        // Validación específica para cada tipo de documento
        if ($request->tipoDocumentoCliente == "3"):
            $messages["nro_documento.required"] = "El campo Número de Documento es requerido";
            $messages["nro_documento.max"] = "El campo Número de Documento debe tener hasta 20 caracteres";
        elseif ($request->tipoDocumentoCliente == "2"):
            $messages["nro_documento.required"] = "El campo Número de Documento es requerido";
            $messages["nro_documento.digits"] = "El campo Número de Documento debe tener 13 dígitos";
        elseif ($request->tipoDocumentoCliente == "1"):
            $messages["nro_documento.required"] = "El campo Número de Documento es requerido";
        endif;

        // Validación de campos
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validación falla, devuelve los errores
        if ($validator->fails()):
            return response()->json(['errors' => $validator->errors(), 'code' => '422']);
        else:
            // Comprueba si ya existe un cliente con el mismo tipo y número de documento
            $existsClienteTipoNroDoc = DB::table('personas')->where('tipo_documento_id', $request->tipoDocumentoCliente)
                ->where('documento', $request->nro_documento)->whereNotIn('persona_id', [$request->cliente_id])->count();

            // Si existe, devuelve un error
            if ($existsClienteTipoNroDoc > 0):
                return response()->json(['errors' => $validator->errors(), 'code' => '423']);
            else:
                // Actualiza la información del cliente
                $cliente = Persona::find($request->cliente_id);
                $data = [
                    "tipo_documento_id" => $request->tipoDocumentoCliente,
                    "documento" => $request->nro_documento,
                    "nombre" => $request->cliente,
                    "direccion" => $request->direccionCliente,
                    "telefono" => $request->tel_Cliente,
                    "email" => $request->email_cliente,
                    "updated_at" => now()
                ];

                // Si la actualización es exitosa, devuelve un mensaje de éxito
                if ($cliente->update($data)):
                    return response()->json(['msg' => 'sucess', 'code' => '200']);
                else:
                    return response()->json(['errors' => $validator->errors(), 'code' => '425']);
                endif;
            endif;
        endif;
    }
}
