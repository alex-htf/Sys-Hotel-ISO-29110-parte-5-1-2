<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $table = 'ubicaciones';

    protected $primaryKey = 'ubicacion_id';

    protected $fillable = ['ubicacion','estado','created_at', 'update_at'];

    public static function getUbicaciones()
    {
        $ubicaciones = Ubicacion::where('estado',1)->orderby('ubicacion','ASC')->get();

        return $ubicaciones;
    }
}
