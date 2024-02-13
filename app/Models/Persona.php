<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';

    protected $primaryKey = 'persona_id';

    protected $fillable = ['persona_id','tipo_documento_id','documento','nombre','razon_social','direccion','telefono','email','observaciones','created_at', 'update_at'];

    public static function getClienteInfo($tipo, $num)
    {
        $cliente = Persona::where('tipo_documento_id',$tipo)->where('documento',$num)->first();
        return $cliente;
    }

    public static function getClienteList($tipodoc, $nrodoc)
    {
        $cliente = Persona::select('personas.persona_id','personas.tipo_documento_id','personas.documento','personas.nombre',
                               'personas.direccion','personas.telefono','personas.email','td.tipo as tipo_documento')
                                ->Join('tipo_documentos as td', function($join)
                                {
                                    $join->on('personas.tipo_documento_id', '=', 'td.tipo_documento_id');
                                });

                                if (isset($tipodoc) && $tipodoc!='_all_'):
                                    $cliente->where('personas.tipo_documento_id',$tipodoc );
                                endif;

                                if (isset($nrodoc) && $nrodoc!=''):
                                    $cliente->where('personas.documento','LIKE','%'.$nrodoc.'%');
                                endif;
                        


                                $cliente = $cliente->orderBy('nombre','ASC')->paginate(10);
        return $cliente;                  
    }

}
