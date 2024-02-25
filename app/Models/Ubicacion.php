<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'ubicaciones';

    // Clave primaria de la tabla
    protected $primaryKey = 'ubicacion_id';

    // Campos que se pueden asignar de manera masiva
    protected $fillable = ['ubicacion', 'estado', 'created_at', 'updated_at'];

    // Método para obtener todas las ubicaciones activas
    public static function getUbicaciones()
    {
        // Obtener las ubicaciones activas ordenadas alfabéticamente por nombre
        $ubicaciones = Ubicacion::where('estado', 1)->orderBy('ubicacion', 'ASC')->get();

        return $ubicaciones;
    }
}
