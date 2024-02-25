<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;
    // Nombre de la tabla en la base de datos
    protected $table = 'configuraciones';
    // Clave primaria de la tabla
    protected $primaryKey = 'configuracion_id';
    // Desactiva la gestión automática de timestamps
    public $timestamps = false;
    // Campos que pueden ser asignados masivamente
    protected $fillable = ['nombre', 'variable', 'valor', 'created_at', 'updated_at'];
    // Método para obtener todas las configuraciones
    public static function get_Configuraciones()
    {
        // Selecciona todas las configuraciones ordenadas por id
        $data = Configuracion::select('configuracion_id', 'nombre', 'variable', 'valor')
            ->orderBy('configuracion_id', 'asc')
            ->get();
        return $data;
    }

    // Método para obtener el valor de una configuración por su variable
    public static function get_valorxvariable($variable)
    {
        // Busca el valor de la configuración según la variable especificada
        $data = Configuracion::select('valor')
            ->where('variable', $variable)
            ->first();
        return $data;
    }
}
