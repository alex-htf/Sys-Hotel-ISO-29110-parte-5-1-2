<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Habitacion extends Model
{
    use HasFactory;

    protected $table = 'habitaciones';
    protected $primaryKey = 'habitacion_id';
    protected $fillable = ['categoria_id', 'ubicacion_id', 'habitacion', 'imagen', 'detalles', 'precio', 'estado', 'created_at', 'update_at'];

    // Método para obtener la lista de habitaciones para la recepción
    public static function getListRecepcionHabitacion($ubicacionBuscar)
    {
        // Construir la consulta para obtener la lista de habitaciones
        $habitaciones = Habitacion::select('habitaciones.habitacion_id', 'habitaciones.habitacion', 'habitaciones.detalles', 'habitaciones.precio', 'habitaciones.estado', 'c.categoria as categoria', 'p.nombre as cliente')
            ->Join('categorias as c', function ($join) {
                $join->on('habitaciones.categoria_id', '=', 'c.categoria_id');
            })
            ->leftJoin('procesos as pro', function ($join) {
                $join->on('pro.habitacion_id', '=', 'habitaciones.habitacion_id');
                $join->where('pro.estado', 1);
            })
            ->leftJoin('personas as p', function ($join) {
                $join->on('p.persona_id', '=', 'pro.cliente_id');
            });

        // Filtrar por ubicación si se proporciona
        if (isset($ubicacionBuscar) && $ubicacionBuscar != '_all_') {
            $habitaciones->where('habitaciones.ubicacion_id', $ubicacionBuscar);
        }

        // Ordenar las habitaciones por número de habitación
        $habitaciones = $habitaciones->orderBy('habitaciones.habitacion', 'ASC')->get();

        return $habitaciones;
    }

    // Método para obtener la lista de habitaciones con filtrado y paginación
    public static function getListHabitaciones($habitacionbuscar, $categoriabuscar, $estadocategoria)
    {
        // Construir la consulta para obtener la lista de habitaciones
        $habitaciones = Habitacion::select(
            'habitaciones.habitacion_id',
            'habitaciones.habitacion',
            'habitaciones.imagen',
            'u.ubicacion as ubicacion',
            'habitaciones.detalles',
            'habitaciones.precio',
            'habitaciones.estado',
            'habitaciones.created_at',
            'c.categoria as categoria'
        )
            ->Join('categorias as c', function ($join) {
                $join->on('habitaciones.categoria_id', '=', 'c.categoria_id');
            })
            ->Join('ubicaciones as u', function ($join) {
                $join->on('habitaciones.ubicacion_id', '=', 'u.ubicacion_id');
            });

        // Aplicar filtros según los parámetros proporcionados
        if (isset($habitacionbuscar) && $habitacionbuscar != '') {
            $habitaciones->where('habitaciones.habitacion', 'LIKE', '%' . $habitacionbuscar . "%");
        }

        if (isset($categoriabuscar) && $categoriabuscar != '_all_') {
            $habitaciones->where('habitaciones.categoria_id', $categoriabuscar);
        }

        if (isset($estadocategoria) && $estadocategoria != '_all_') {
            $habitaciones->where('habitaciones.estado', $estadocategoria);
        }

        // Ordenar y paginar los resultados
        $habitaciones = $habitaciones->orderBy('habitaciones.habitacion', 'ASC')->paginate(10);

        return $habitaciones;
    }

    // Método para obtener los datos de una habitación específica
    public static function getDataHabitacion($id)
    {
        // Obtener los datos de la habitación según su ID
        $habitacion = Habitacion::select('habitaciones.habitacion_id', 'habitaciones.habitacion', 'c.categoria as categoria', 'habitaciones.detalles', 'habitaciones.precio', 'habitaciones.estado')
            ->Join('categorias as c', function ($join) {
                $join->on('habitaciones.categoria_id', '=', 'c.categoria_id');
            })
            ->where('habitaciones.habitacion_id', $id)
            ->first();

        return $habitacion;
    }

    // Métodos adicionales para manipular el estado de la habitación, obtener información sobre la imagen, etc.
    // Método para obtener la imagen de la habitación
    public static function getImgHabitacion($id)
    {
        $habitacion = Habitacion::select('imagen')
            ->where('habitacion_id', $id)
            ->first();
        return $habitacion;
    }

    // Método para obtener los detalles de una habitación específica
    public static function habitaciondetails($id)
    {
        $arrayHabitacion = Habitacion::select('habitacion_id', 'habitacion', 'detalles', 'imagen', 'precio')
            ->where('habitacion_id', $id)
            ->first()->toArray();
        return $arrayHabitacion;
    }

    // Método para marcar una habitación como disponible
    public static function habitacionDisponible($id)
    {
        $data = [
            "estado" => 1
        ];
        Habitacion::where('habitacion_id', $id)
            ->update($data);
    }

    // Método para marcar una habitación como ocupada
    public static function habitacionOcupada($id)
    {
        $data = [
            "estado" => 2
        ];
        Habitacion::where('habitacion_id', $id)
            ->update($data);
    }
    // Método para obtener el estado de una habitación específica
    public static function getEstado($id)
    {
        $estado = Habitacion::select('habitacion', 'estado')->where('habitacion_id', $id)->first();
        return $estado;
    }
}
