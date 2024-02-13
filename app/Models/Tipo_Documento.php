<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Documento extends Model
{
    use HasFactory;

    protected $table = 'tipo_documentos';

    protected $primaryKey = 'tipo_documento_id';

    protected $fillable = ['tipo_documento_id','tipo'];
}
