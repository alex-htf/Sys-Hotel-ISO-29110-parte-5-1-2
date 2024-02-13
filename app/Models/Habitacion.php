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

    protected $fillable = ['categoria_id','ubicacion_id','habitacion','imagen','detalles','precio','estado','created_at', 'update_at'];

    public static function getListRecepcionHabitacion($ubicacionBuscar)
    {
        // $habitaciones = Habitacion::orderBy('habitaciones.habitacion', 'ASC')->get();
        $habitaciones = Habitacion::select('habitaciones.habitacion_id','habitaciones.habitacion','habitaciones.detalles','habitaciones.precio','habitaciones.estado',
                                            'c.categoria as categoria','p.nombre as cliente')
                                    ->Join('categorias as c', function($join)
                                    {
                                        $join->on('habitaciones.categoria_id', '=', 'c.categoria_id');
                                    })
                                    ->leftJoin('procesos as pro', function($join)
                                    {
                                        $join->on('pro.habitacion_id', '=', 'habitaciones.habitacion_id');
                                        $join->where('pro.estado',1);
                                    })
                                    ->leftJoin('personas as p', function($join)
                                    {
                                        $join->on('p.persona_id', '=', 'pro.cliente_id');
                                    });

                                    if (isset($ubicacionBuscar) && $ubicacionBuscar!='_all_'):
                                        $habitaciones->where('habitaciones.ubicacion_id',$ubicacionBuscar );
                                    endif;

                                    $habitaciones = $habitaciones->orderBy('habitaciones.habitacion', 'ASC')->get();
        return $habitaciones;
    }

    public static function getListHabitaciones($habitacionbuscar, $categoriabuscar, $estadocategoria)
    {
        $habitaciones = Habitacion::select('habitaciones.habitacion_id','habitaciones.habitacion','habitaciones.imagen','u.ubicacion as ubicacion',
                                        'habitaciones.detalles','habitaciones.precio','habitaciones.estado','habitaciones.created_at','c.categoria as categoria')
                                        ->Join('categorias as c', function($join)
                                        {
                                            $join->on('habitaciones.categoria_id', '=', 'c.categoria_id');
                                        })
                                        ->Join('ubicaciones as u', function($join)
                                        {
                                            $join->on('habitaciones.ubicacion_id', '=', 'u.ubicacion_id');
                                        }); 
                                        
                                        if (isset($habitacionbuscar) && $habitacionbuscar != ''):
                                            $habitaciones ->where('habitaciones.habitacion','LIKE','%'.$habitacionbuscar."%");
                                        endif;     
                                
                                        if (isset($categoriabuscar) && $categoriabuscar!='_all_'):
                                            $habitaciones->where('habitaciones.categoria_id',$categoriabuscar );
                                        endif;

                                        
                                        if (isset($estadocategoria) && $estadocategoria!='_all_'):
                                            $habitaciones->where('habitaciones.estado',$estadocategoria );
                                        endif;


                                       $habitaciones = $habitaciones->orderBy('habitaciones.habitacion', 'ASC')->paginate(10);
 
        return $habitaciones;
                                    
    }

    public static function getDataHabitacion($id)
    {
        $habitacion = Habitacion::select('habitaciones.habitacion_id', 'habitaciones.habitacion','c.categoria as categoria','habitaciones.detalles','habitaciones.precio','habitaciones.estado')
                                    ->Join('categorias as c', function($join)
                                    {
                                        $join->on('habitaciones.categoria_id', '=', 'c.categoria_id');
                                    })
                                    ->where('habitaciones.habitacion_id',$id)
                                    ->first();
        return $habitacion;

    }

    public static function getImgHabitacion($id)
    {
        $habitacion = Habitacion::select('imagen')
                                    ->where('habitacion_id',$id)
                                    ->first();
        return $habitacion;
    }

    public static function habitaciondetails($id)
    {
        $arrayHabitacion = Habitacion::select('habitacion_id','habitacion','detalles','imagen','precio')
                                    ->where('habitacion_id',$id)
                                    ->first()->toArray();

        // $tarifasxhabitacion = DB::table('habitaciones_tarifas as ht')
        //                     ->select('ht.habitacion_tarifa_id','ht.habitacion_id','t.tarifa as tarifa','ht.precio','ht.habitacion_id')
        //                     ->leftJoin('tarifas as t', function($join)
        //                     {
        //                         $join->on('ht.tarifa_id', '=', 't.tarifa_id');
        //                         $join->where('t.estado',1);
        //                     })
        //                     ->where('ht.habitacion_id', $id)->orderBy('tarifa','ASC')->get()->toArray();

        // $arrayHabitacion['tarifas'] = $tarifasxhabitacion;

        return $arrayHabitacion;
                            
    }

    public static function habitacionDisponible($id)
    {
        $data = [
            "estado" => 1
        ];
        Habitacion::where('habitacion_id', $id)
                        ->update($data);
    }

    public static function habitacionOcupada($id)
    {
        $data = [
            "estado" => 2
        ];
        Habitacion::where('habitacion_id', $id)
                        ->update($data);
    }

    public static function habitacionLimpieza($id)
    {
        $data = [
            "estado" => 3
        ];
        Habitacion::where('habitacion_id', $id)
                        ->update($data);
    }
    
    
    public static function getEstado($id)
    {
        $estado = Habitacion::select('habitacion','estado')->where('habitacion_id',$id)->first();
        return $estado;
    }

}
