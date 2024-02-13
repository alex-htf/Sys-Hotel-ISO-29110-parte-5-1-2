<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $primaryKey = 'categoria_id';

    protected $fillable = ['categoria','descripcion','estado','created_at', 'update_at'];

    public static function getCategorias()
    {
        $categorias = Categoria::where('estado',1)->orderby('categoria','ASC')->get();

        return $categorias;
    }
}
