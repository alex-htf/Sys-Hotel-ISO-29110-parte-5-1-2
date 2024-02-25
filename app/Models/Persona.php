<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'personas';

    // Clave primaria de la tabla
    protected $primaryKey = 'persona_id';

    // Campos que se pueden llenar con asignación en masa
    protected $fillable = ['persona_id', 'tipo_documento_id', 'documento', 'nombre', 'razon_social', 'direccion', 'telefono', 'email', 'observaciones', 'created_at', 'updated_at'];

    // Método estático para obtener la información de un cliente por tipo y número de documento
    public static function getClienteInfo($tipo, $num)
    {
        // Busca y devuelve la primera persona que coincida con el tipo de documento y el número
        $cliente = Persona::where('tipo_documento_id', $tipo)->where('documento', $num)->first();
        return $cliente;
    }

    // Método estático para obtener una lista de clientes filtrados por tipo y número de documento
    public static function getClienteList($tipodoc, $nrodoc)
    {
        // Consulta para seleccionar los campos de persona y el tipo de documento
        $cliente = Persona::select(
            'personas.persona_id',
            'personas.tipo_documento_id',
            'personas.documento',
            'personas.nombre',
            'personas.direccion',
            'personas.telefono',
            'personas.email',
            'td.tipo as tipo_documento'
        )
        ->join('tipo_documentos as td', function ($join) {
            $join->on('personas.tipo_documento_id', '=', 'td.tipo_documento_id');
        });

        // Aplica filtros si se proporcionan
        if (isset($tipodoc) && $tipodoc != '_all_'):
            $cliente->where('personas.tipo_documento_id', $tipodoc);
        endif;

        if (isset($nrodoc) && $nrodoc != ''):
            $cliente->where('personas.documento', 'LIKE', '%' . $nrodoc . '%');
        endif;

        // Ordena los resultados por nombre y los devuelve paginados
        $cliente = $cliente->orderBy('nombre', 'ASC')->paginate(10);
        return $cliente;
    }
}
