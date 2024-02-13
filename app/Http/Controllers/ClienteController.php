<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Tipo_Documento;
use DB, Validator;

class ClienteController extends Controller
{
    //
    public function getClienteInfo(Request $request)
    {
        $cliente = Persona::getClienteInfo($request->tipodoc, $request->numdoc);
        return response()->json($cliente);
    }

    public function lisClient(Request $request)
    {
        $tipodocbuscar = ($request->get('tipo_doc')) ? $request->get('tipo_doc') : '_all_';
        $nrodocbuscar = ($request->get('nrodoc')) ? $request->get('nrodoc') : '';

        $clientes = Persona::getClienteList($tipodocbuscar, $nrodocbuscar);
        $tipo_doc = Tipo_Documento::all();

        $ruta = 'clientes';

        if($request->ajax()):
            return view('data.load_clientes_data', compact('clientes', 'tipo_doc', 'ruta'));
        endif;

        return view('modules.clientes', compact('clientes', 'tipo_doc', 'ruta'));
    }

    public function getClientefind($id)
    {
        $cliente = Persona::find($id);
        return response()->json($cliente);
    }
    
    public function udpateClient($id, Request $request)
    {
        if (!$request->ajax()):
            return redirect('/clientes');
        endif;
        
        $rules = [
            'cliente'=>'required',
            // 'razon_social' => 'required',
            'tipoDocumentoCliente' => 'required',
            'nro_documento' => 'required',
            'direccionCliente' => 'required',
            'tel_Cliente' => 'required',
            'email_cliente' => 'required',
        ];

        $messages = [
            'cliente.required' => 'El campo Cliente es requerido',
            // 'razon_social.required' => 'El Campo Razón Social es requerido',
            'tipoDocumentoCliente.required' => 'El Tipo de Documento es requerido',
            'nro_documento.required' => 'El Número de Documento es requerido',
            'direccionCliente.required' => 'La Dirección del Cliente es requerida',
            'tel_Cliente.required' => 'El Teléfono del Cliente es requerido',
            'email_cliente.numeric' => 'El campo Email es requerido'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:

            $existsClienteTipoNroDoc = DB::table('personas')->where('tipo_documento_id', $request->tipoDocumentoCliente)->where('documento',$request->nro_documento)->whereNotIn('persona_id',[$request->cliente_id])->count();

            if($existsClienteTipoNroDoc > 0):
                return response()->json(['errors'=>$validator->errors(), 'code' => '423']);
            else:
                $cliente = Persona::find($request->cliente_id);

                $data = [
                    "tipo_documento_id"=>$request->tipoDocumentoCliente,
                    "documento"=>$request->nro_documento,
                    "nombre"=>$request->cliente,
                    // "razon_social"=>$request->razon_social,
                    "direccion"=>$request->direccionCliente,
                    "telefono" => $request->tel_Cliente,
                    "email" => $request->email_cliente,
                    "updated_at"=>now()
                ];

                if($cliente->update($data)):
                    return response()->json(['msg'=>'sucess', 'code' => '200']);
                else: 
                    return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
                endif;
            endif;
           
        endif;

    }
}
