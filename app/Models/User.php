<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Los atributos que pueden ser asignados masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'nombres',
        'apellidos',
        'usuario',
        'email',
        'direccion',
        'telefono',
        'foto',
        'password',
        'estado',  
        'oculto',
        'created_at',
        'updated_at'
    ];

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * La clave primaria asociada con la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * Indica si el modelo debería tener timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Los atributos que deben ser ocultados para la serialización.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser lanzados a tipos de datos específicos.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed'
    ];

    /**
     * Obtener usuarios basados en el criterio dado.
     *
     * @param  string  $nusuario
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getUsers($nusuario = '')
    {
        // Selecciona todos los usuarios
        $usuarios = User::select('users.*');

        // Filtra por nombres o apellidos que coincidan parcialmente con el término de búsqueda
        if (isset($nusuario) && $nusuario != ''):
            $usuarios->where('users.nombres', 'LIKE', '%' . $nusuario . '%') ->orWhere('users.apellidos', 'LIKE', '%' . $nusuario . '%');
        endif;  

        // Ordena los usuarios por apellidos en orden ascendente y los paginas
        $usuarios = $usuarios->orderBy('users.apellidos', 'ASC')->paginate(10);

        return $usuarios;
    }
}
