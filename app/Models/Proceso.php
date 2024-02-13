<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    use HasFactory;

    protected $table = 'procesos';

    protected $primaryKey = 'proceso_id';

    protected $fillable = ['habitacion_id','cliente_id','tarifa_id','tipo_comprobante_id','serie','numero','precio','cant_noches','cant_personas','total','fecha_entrada','fecha_salida','toallas',
                            'estado_pago','tipo_pago','nro_operacion','observaciones','estado','created_at', 'update_at'];

    public static function getmaxNumDoc($tipo_comprobante)
    {
        $proceso = Proceso::where('tipo_comprobante',$tipo_comprobante)->max('numero');
        return $proceso;
    }

    public static function getRecepcionData($id)
    {
        $recepcionData = Proceso::select('procesos.proceso_id','procesos.habitacion_id','procesos.cliente_id','p.nombre as cliente','p.email as email','procesos.fecha_entrada','procesos.fecha_salida','procesos.tipo_pago','tp.pago as pago',
                             'procesos.nro_operacion','h.precio as precio','procesos.cant_noches','procesos.cant_personas','procesos.observaciones','procesos.estado','procesos.total','procesos.estado_pago','c.categoria as categoria','h.habitacion as habitacion')
                             ->leftJoin('tipo_pagos as tp', function($join)
                            {
                                $join->on('procesos.tipo_pago', '=', 'tp.tipo_pago_id');
                            })
                             ->Join('personas as p', function($join)
                            {
                                $join->on('procesos.cliente_id', '=', 'p.persona_id');
                            })
                            ->Join('habitaciones as h', function($join)
                            {
                                $join->on('procesos.habitacion_id', '=', 'h.habitacion_id');
                            })
                            ->Join('categorias as c', function($join)
                            {
                                $join->on('h.categoria_id', '=', 'c.categoria_id');
                            })
                           
                        ->where('procesos.habitacion_id',$id)->where('procesos.estado',1)->first(); 

        return $recepcionData;
    }

    public static function getHabitacionProcesoId($id)
    {
        $data = Proceso::select('habitacion_id')->where('proceso_id', $id)->first();

        return $data;
    }

    public static function getDataFactura($proceso_id)
    {
        $data = Proceso::select('procesos.proceso_id','procesos.habitacion_id','procesos.cliente_id','p.nombre as cliente','p.email as email', 'p.direccion as direccion',
                                'p.tipo_documento_id','td.tipo as tipo','p.documento as documento','p.telefono as telefono','h.habitacion as habitacion','procesos.total', 'procesos.fecha_entrada', 'procesos.fecha_salida')
                                ->Join('personas as p', function($join)
                                {
                                    $join->on('procesos.cliente_id', '=', 'p.persona_id');
                                })
                                ->Join('tipo_documentos as td', function($join)
                                {
                                    $join->on('p.tipo_documento_id', '=', 'td.tipo_documento_id');
                                })
                                ->Join('habitaciones as h', function($join)
                                {
                                    $join->on('procesos.habitacion_id', '=', 'h.habitacion_id');
                                })
                                // ->Join('tipo_comprobantes as tc', function($join)
                                // {
                                //     $join->on('procesos.tipo_comprobante_id', '=', 'tc.tipo_comprobante_id');
                                // })
                                ->where('procesos.proceso_id',$proceso_id)->where('procesos.estado',0)->first(); 

        return $data;
    }

    public static function getReporteData($fdesde, $fhasta)
    {
        $data = Proceso::select('procesos.proceso_id','procesos.habitacion_id','procesos.cliente_id','p.nombre as cliente','p.email as email', 'p.direccion as direccion',
        'p.tipo_documento_id','td.tipo as tipo','p.documento as documento','p.telefono as telefono','h.habitacion as habitacion','procesos.total', 'procesos.fecha_entrada', 'procesos.fecha_salida',
        'procesos.cant_noches', 'procesos.cant_personas', 'procesos.estado_pago', 'procesos.tipo_pago','tp.pago as pago')
        ->leftJoin('tipo_pagos as tp', function($join)
        {
            $join->on('procesos.tipo_pago', '=', 'tp.tipo_pago_id');
        })
        ->Join('personas as p', function($join)
        {
            $join->on('procesos.cliente_id', '=', 'p.persona_id');
        })
        ->Join('tipo_documentos as td', function($join)
        {
            $join->on('p.tipo_documento_id', '=', 'td.tipo_documento_id');
        })
        ->Join('habitaciones as h', function($join)
        {
            $join->on('procesos.habitacion_id', '=', 'h.habitacion_id');
        })
        ->whereDate('procesos.fecha_entrada','>=', $fdesde)
        ->whereDate('procesos.fecha_salida','<=', $fhasta)
        ->orderBy('procesos.created_at','DESC')
        ->get();

        return $data;
    }

    public static function getDataHistorial($categoria, $ubicacion, $estado_pago)
    {
        $data = Proceso::select('procesos.proceso_id','procesos.habitacion_id','c.categoria as categoria','u.ubicacion as ubicacion','procesos.cliente_id','p.nombre as cliente','p.email as email', 'p.direccion as direccion',
        'p.tipo_documento_id','td.tipo as tipo','p.documento as documento','p.telefono as telefono','h.habitacion as habitacion','procesos.total', 'procesos.fecha_entrada', 'procesos.fecha_salida',
        'procesos.cant_noches', 'procesos.cant_personas', 'procesos.estado_pago', 'procesos.tipo_pago','tp.pago as pago', 'procesos.estado', 'procesos.observaciones')
        ->leftJoin('tipo_pagos as tp', function($join)
        {
            $join->on('procesos.tipo_pago', '=', 'tp.tipo_pago_id');
        })
        ->Join('personas as p', function($join)
        {
            $join->on('procesos.cliente_id', '=', 'p.persona_id');
        })
        ->Join('tipo_documentos as td', function($join)
        {
            $join->on('p.tipo_documento_id', '=', 'td.tipo_documento_id');
        })
        ->Join('habitaciones as h', function($join)
        {
            $join->on('procesos.habitacion_id', '=', 'h.habitacion_id');
        })
        ->Join('categorias as c', function($join)
        {
            $join->on('h.categoria_id', '=', 'c.categoria_id');
        })
        ->Join('ubicaciones as u', function($join)
        {
            $join->on('h.ubicacion_id', '=', 'u.ubicacion_id');
        });

        if (isset($categoria) && $categoria!='_all_'):
            $data->where('h.categoria_id',$categoria );
        endif;

        
        if (isset($ubicacion) && $ubicacion!='_all_'):
            $data->where('h.ubicacion_id',$ubicacion );
        endif;

        if (isset($estado_pago) && $estado_pago!='_all_'):
            $data->where('procesos.estado_pago',$estado_pago );
        endif;
        
        $data = $data->orderBy('procesos.fecha_entrada','DESC')
        ->paginate(10);

        return $data;
    }
}
