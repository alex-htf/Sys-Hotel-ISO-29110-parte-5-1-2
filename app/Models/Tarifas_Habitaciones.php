<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarifas_Habitaciones extends Model
{
    use HasFactory;

    protected $table = 'habitaciones_tarifas';

    protected $primaryKey = 'habitacion_tarifa_id';

    protected $fillable = ['habitacion_id','tarifa_id','precio','created_at', 'updated_at'];

    public static function getListTarifas($id)
    {
        $habitacion = Tarifas_Habitaciones::select('habitaciones_tarifas.habitacion_tarifa_id','habitaciones_tarifas.habitacion_id',
                                                    'habitaciones_tarifas.tarifa_id','habitaciones_tarifas.precio','t.tarifa as tarifa')
                                            ->Join('tarifas as t', function($join)
                                            {
                                                $join->on('habitaciones_tarifas.tarifa_id', '=', 't.tarifa_id');
                                            })
                                           ->where('habitacion_id',$id)->orderby('t.tarifa','ASC')->paginate(10);
        return $habitacion;
    }
}
