<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'categorias';

    // Nombre de la clave primaria en la tabla
    protected $primaryKey = 'categoria_id';

    // Atributos que pueden ser asignados en masa
    protected $fillable = ['categoria', 'descripcion', 'estado', 'created_at', 'updated_at']; // Corrección aquí

    // Método estático para obtener todas las categorías activas
    public static function getCategorias()
    {
        // Consulta para obtener todas las categorías activas, ordenadas alfabéticamente
        $categorias = Categoria::where('estado', 1)->orderBy('categoria', 'ASC')->get();

        // Retorna el resultado de la consulta
        return $categorias;
    }
}
