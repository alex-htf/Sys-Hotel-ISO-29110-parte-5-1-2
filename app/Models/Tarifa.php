<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    use HasFactory;

    protected $table = 'tarifas';

    protected $primaryKey = 'tarifa_id';

    protected $fillable = ['tarifa','estado','created_at', 'update_at'];
}
