<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Comprobante extends Model
{
    use HasFactory;

    protected $table = 'tipo_comprobantes';

    protected $primaryKey = 'tipo_comprobante_id';

    protected $fillable = ['tipo_comprobante_id','comprobante', 'estado'];
}
