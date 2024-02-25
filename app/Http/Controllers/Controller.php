<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    // Usa el trait AuthorizesRequests, que proporciona métodos para autorización de solicitudes
    use AuthorizesRequests;

    // Usa el trait ValidatesRequests, que proporciona métodos para validación de solicitudes
    use ValidatesRequests;
}
