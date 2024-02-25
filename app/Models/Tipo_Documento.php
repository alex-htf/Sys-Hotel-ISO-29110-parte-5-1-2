<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Documento extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'tipo_documentos';

    // Nombre de la columna que actúa como clave primaria
    protected $primaryKey = 'tipo_documento_id';

    // Columnas que se pueden llenar con asignación en masa
    protected $fillable = ['tipo_documento_id', 'tipo'];
}
