<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    use HasFactory;

    protected $table = 'procesos';

    protected $primaryKey = 'proceso_id';

    protected $fillable = ['habitacion_id', 'cliente_id', 'precio', 'cant_noches', 'cant_personas', 'total', 'fecha_entrada', 'fecha_salida', 'observaciones', 'estado', 'created_at', 'update_at'];

    public static function getmaxNumDoc($tipo_comprobante)
    {
        $proceso = Proceso::where('tipo_comprobante', $tipo_comprobante)->max('numero');
        return $proceso;
    }

    public static function getRecepcionData($id)
    {
        $recepcionData = Proceso::select('procesos.proceso_id', 'procesos.habitacion_id', 'procesos.cliente_id', 'p.nombre as cliente', 'p.email as email', 'procesos.fecha_entrada', 'procesos.fecha_salida', 'h.precio as precio', 'procesos.cant_noches', 'procesos.cant_personas', 'procesos.observaciones', 'procesos.estado', 'procesos.total', 'c.categoria as categoria', 'h.habitacion as habitacion')
            ->leftJoin('personas as p', 'procesos.cliente_id', '=', 'p.persona_id')
            ->leftJoin('habitaciones as h', 'procesos.habitacion_id', '=', 'h.habitacion_id')
            ->leftJoin('categorias as c', 'h.categoria_id', '=', 'c.categoria_id')
            ->where('procesos.habitacion_id', $id)
            ->where('procesos.estado', 1)
            ->first();

        return $recepcionData;
    }

    public static function getHabitacionProcesoId($id)
    {
        $data = Proceso::select('habitacion_id')->where('proceso_id', $id)->first();

        return $data;
    }

    public static function getDataFactura($proceso_id)
    {
        $data = Proceso::select('procesos.proceso_id', 'procesos.habitacion_id', 'procesos.cliente_id', 'p.nombre as cliente', 'p.email as email', 'p.direccion as direccion', 'p.tipo_documento_id', 'td.tipo as tipo', 'p.documento as documento', 'p.telefono as telefono', 'h.habitacion as habitacion', 'procesos.total', 'procesos.fecha_entrada', 'procesos.fecha_salida')
            ->leftJoin('personas as p', 'procesos.cliente_id', '=', 'p.persona_id')
            ->leftJoin('tipo_documentos as td', 'p.tipo_documento_id', '=', 'td.tipo_documento_id')
            ->leftJoin('habitaciones as h', 'procesos.habitacion_id', '=', 'h.habitacion_id')
            ->where('procesos.proceso_id', $proceso_id)
            ->where('procesos.estado', 0)
            ->first();

        return $data;
    }

    public static function getReporteData($fdesde, $fhasta)
    {
        $data = Proceso::select('procesos.proceso_id', 'procesos.habitacion_id', 'procesos.cliente_id', 'p.nombre as cliente', 'p.email as email', 'p.direccion as direccion', 'p.tipo_documento_id', 'td.tipo as tipo', 'p.documento as documento', 'p.telefono as telefono', 'h.habitacion as habitacion', 'procesos.total', 'procesos.fecha_entrada', 'procesos.fecha_salida', 'procesos.cant_noches', 'procesos.cant_personas')
            ->leftJoin('personas as p', 'procesos.cliente_id', '=', 'p.persona_id')
            ->leftJoin('tipo_documentos as td', 'p.tipo_documento_id', '=', 'td.tipo_documento_id')
            ->leftJoin('habitaciones as h', 'procesos.habitacion_id', '=', 'h.habitacion_id')
            ->whereDate('procesos.fecha_entrada', '>=', $fdesde)
            ->whereDate('procesos.fecha_salida', '<=', $fhasta)
            ->orderBy('procesos.created_at', 'DESC')
            ->get();

        return $data;
    }

    public static function getDataHistorial($categoria, $ubicacion)
    {
        $data = Proceso::select('procesos.proceso_id', 'procesos.habitacion_id', 'c.categoria as categoria', 'u.ubicacion as ubicacion', 'procesos.cliente_id', 'p.nombre as cliente', 'p.email as email', 'p.direccion as direccion', 'p.tipo_documento_id', 'td.tipo as tipo', 'p.documento as documento', 'p.telefono as telefono', 'h.habitacion as habitacion', 'procesos.total', 'procesos.fecha_entrada', 'procesos.fecha_salida', 'procesos.cant_noches', 'procesos.cant_personas', 'procesos.estado', 'procesos.observaciones')
            ->leftJoin('personas as p', 'procesos.cliente_id', '=', 'p.persona_id')
            ->leftJoin('tipo_documentos as td', 'p.tipo_documento_id', '=', 'td.tipo_documento_id')
            ->leftJoin('habitaciones as h', 'procesos.habitacion_id', '=', 'h.habitacion_id')
            ->leftJoin('categorias as c', 'h.categoria_id', '=', 'c.categoria_id')
            ->leftJoin('ubicaciones as u', 'h.ubicacion_id', '=', 'u.ubicacion_id');

        if (isset($categoria) && $categoria != '_all_') {
            $data->where('h.categoria_id', $categoria);
        }

        if (isset($ubicacion) && $ubicacion != '_all_') {
            $data->where('h.ubicacion_id', $ubicacion);
        }

        $data = $data->orderBy('procesos.fecha_entrada', 'DESC')
            ->paginate(10);

        return $data;
    }
}
