<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paises extends Model
{
    use HasFactory;
    
    protected $table = 'paises'; //nombre de la tabla

    protected $primaryKey = 'pais_id';  //id de la tabla

    protected $fillable = ['pais','estado','created_at', 'update_at']; //campos que se llenan

}
