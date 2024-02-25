<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Validator, Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UsuarioController extends Controller
{
    /**
     * Muestra una lista de recursos.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Obtiene el parámetro de búsqueda de usuario, si existe
        $nusuario = isset($request->usuario) ? $request->usuario : '';

        // Obtiene la lista de usuarios según el parámetro de búsqueda
        $usuarios = User::getUsers($nusuario);

        // Ruta para la vista
        $ruta = 'usuarios';

        // Si es una petición Ajax, devuelve la vista de carga de datos de usuarios
        if ($request->ajax()) {
            return view('data.load_usuarios_data', compact('usuarios', 'ruta'));
        }

        // Si no es una petición Ajax, devuelve la vista de módulo de usuarios
        return view('modules.usuarios', compact('usuarios', 'ruta'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        // Ruta para la vista
        $ruta = 'usuarios';

        // Devuelve la vista del formulario para crear usuarios
        return view('modules.crud-usuarios', compact('ruta'));
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        // Si no es una petición Ajax, redirecciona
        if (!$request->ajax()) {
            return redirect('/admin/usuarios');
        }

        // Reglas de validación para el formulario de creación
        $rules = [
            'nombreUsuario' => 'required|max:100|regex:/^[a-zA-Z\s]+$/',
            'apellidoUsuario' => 'required|max:100|regex:/^[a-zA-Z\s]+$/',
            'txtUsuario' => 'required|unique:users,usuario',
            'emailUsuario' => 'required|email',
            'direccionUsuario' => 'required|max:100',
            'telefonoUsuario' => 'required|digits_between:7,12',
            'contraseniaUsuario' => 'required|min:6',
            'confirmarContraseniaUsuario' => 'required|min:6|same:contraseniaUsuario'
        ];

        // Mensajes de validación personalizados
        $messages = [
            'nombreUsuario.required' => 'El Nombre de Usuario es requerido',
            'nombreUsuario.max' => 'El campo Nombre de Usuario debe tener hasta 100 caracteres',
            'nombreUsuario.regex' => 'El campo Nombre de Usuario debe contener solo letras',
            'apellidoUsuario.required' => 'El Apellido de Usuario es requerido',
            'apellidoUsuario.max' => 'El campo Apellido de Usuario debe tener hasta 100 caracteres',
            'apellidoUsuario.regex' => 'El campo Apellido de Usuario debe contener solo letras',
            'txtUsuario.required' => 'El Identificador de Usuario es requerido',
            'txtUsuario.unique' => 'El Identificador de Usuario ya existe',
            'emailUsuario.required' => 'El Correo Electrónico es requerido',
            'emailUsuario.email' => 'El campo de Correo Electrónico debe tener un formato válido',
            'direccionUsuario.required' => 'La Dirección del Usuario es requerida',
            'direccionUsuario.max' => 'La Dirección del Usuario debe tener hasta 100 caracteres',
            'telefonoUsuario.required' => 'El Teléfono del Usuario es requerido',
            'telefonoUsuario.digits_between' => 'El Teléfono del Usuario debe contener de 7 a 12 dígitos',
            'contraseniaUsuario.required' => 'El Campo Contraseña es requerido',
            'contraseniaUsuario.min' => 'La contraseña debe contener al menos 6 caracteres',
            'confirmarContraseniaUsuario.required' => 'Es necesario confirmar la contraseña',
            'confirmarContraseniaUsuario.min' => 'La confirmación de contraseña debe contener al menos 6 caracteres',
            'confirmarContraseniaUsuario.same' => 'Las contraseñas no coinciden'
        ];

        // Realiza la validación del formulario
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validación falla, devuelve los errores
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'code' => '422']);
        } else {
            // Inicializa el nombre del archivo de la foto
            $fileName = '';

            // Si se cargó un archivo de foto, procesa y guarda la foto
            if ($request->hasFile('fotoUsuario')) {
                $file = $request->fotoUsuario->getClientOriginalName();
                $fileName = time() . '.' . $request->fotoUsuario->getClientOriginalExtension();
                $pathtmp = public_path('img/usuarios/');

                // Si no existe la carpeta de destino, la crea
                if (!file_exists($pathtmp)) {
                    mkdir($pathtmp, 0777, true);
                }
            }

            // Datos del nuevo usuario
            $data = [
                "nombres" => trim($request->nombreUsuario),
                "apellidos" => trim($request->apellidoUsuario),
                "usuario" => trim($request->txtUsuario),
                "email" => trim($request->emailUsuario),
                "direccion" => trim($request->direccionUsuario),
                "telefono" => trim($request->telefonoUsuario),
                "foto" => $fileName,
                "password" => Hash::make(trim($request->input('contraseniaUsuario'))),
                "estado" => 1,
                "created_at" => now(),
                "remember_token" => Str::random(10)
            ];

            // Crea el nuevo usuario en la base de datos
            if (User::create($data)) {
                // Si se cargó una foto, la guarda en la carpeta de destino
                if ($request->hasFile('fotoUsuario')) {
                    $request->fotoUsuario->move($pathtmp, $fileName);
                }
                // Devuelve una respuesta de éxito
                return response()->json(['msg' => 'sucess', 'code' => '200', 'url' => url('/usuarios')]);
            } else {
                // Si falla la creación, devuelve los errores
                return response()->json(['errors' => $validator->errors(), 'code' => '425']);
            }
        }
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(string $id)
    {
        // No implementado
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(string $id)
    {
        // Obtiene los datos del usuario a editar
        $dataU = User::where('user_id', $id)->first();
        // Si no se encuentra el usuario, redirecciona
        if ($dataU == NULL) {
            return redirect('/usuarios');
        }
        // Obtiene los datos del usuario
        $usuario = User::where('user_id', $id)->first();
        // Ruta para la vista
        $ruta = 'usuarios';
        // Devuelve la vista del formulario para editar usuarios
        return view('modules.crud-usuarios', compact('usuario', 'ruta'));
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, string $id)
    {
        // Si no es una petición Ajax, redirecciona
        if (!$request->ajax()) {
            return redirect('/usuarios');
        }
        // Reglas de validación para el formulario de edición
        $rules = [
            'nombreUsuario' => 'required|max:100|regex:/^[a-zA-Z\s]+$/',
            'apellidoUsuario' => 'required|max:100|regex:/^[a-zA-Z\s]+$/',
            'txtUsuario' => 'required|unique:users,usuario,' . $id . ',user_id',
            'emailUsuario' => 'required|email',
            'direccionUsuario' => 'required|max:100',
            'telefonoUsuario' => 'required|digits_between:7,12',
            'contraseniaUsuario' => 'required|min:6',
            'confirmarContraseniaUsuario' => 'required|min:6|same:contraseniaUsuario'
        ];
        // Mensajes de validación personalizados
        $messages = [
            'nombreUsuario.required' => 'El Nombre de Usuario es requerido',
            'nombreUsuario.max' => 'El campo Nombre de Usuario debe tener hasta 100 caracteres',
            'nombreUsuario.regex' => 'El campo Nombre de Usuario debe contener solo letras',
            'apellidoUsuario.required' => 'El Apellido de Usuario es requerido',
            'apellidoUsuario.max' => 'El campo Apellido de Usuario debe tener hasta 100 caracteres',
            'apellidoUsuario.regex' => 'El campo Apellido de Usuario debe contener solo letras',
            'txtUsuario.required' => 'El Identificador de Usuario es requerido',
            'txtUsuario.unique' => 'El Identificador de Usuario ya existe',
            'emailUsuario.required' => 'El Correo Electrónico es requerido',
            'emailUsuario.email' => 'El campo de Correo Electrónico debe tener un formato válido',
            'direccionUsuario.required' => 'La Dirección del Usuario es requerida',
            'direccionUsuario.max' => 'La Dirección del Usuario debe tener hasta 100 caracteres',
            'telefonoUsuario.required' => 'El Teléfono del Usuario es requerido',
            'telefonoUsuario.digits_between' => 'El Teléfono del Usuario debe contener de 7 a 12 dígitos',
            'contraseniaUsuario.required' => 'El campo Contraseña es requerido',
            'contraseniaUsuario.min' => 'La contraseña debe contener al menos 6 caracteres',
            'confirmarContraseniaUsuario.required' => 'Es necesario confirmar la contraseña',
            'confirmarContraseniaUsuario.min' => 'La confirmación de contraseña debe contener al menos 6 caracteres',
            'confirmarContraseniaUsuario.same' => 'Las contraseñas no coinciden'
        ];

        // Realiza la validación del formulario
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validación falla, devuelve los errores
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'code' => '422']);
        } else {
            // Inicializa la contraseña a editar
            $passwordEditar = '';

            // Si se ingresó una nueva contraseña
            if ($request->contraseniaUsuario != "" || $request->confirmarContraseniaUsuario != "") {
                // Verifica que las contraseñas coincidan y tengan al menos 6 caracteres
                if (strlen($request->contraseniaUsuario) >= 6 || strlen($request->confirmarContraseniaUsuario) >= 6) {
                    if (trim($request->contraseniaUsuario) === trim($request->confirmarContraseniaUsuario)) {
                        $passwordEditar = Hash::make($request->input('contraseniaUsuario'));
                    } else {
                        // Si las contraseñas no coinciden, devuelve un error
                        return response()->json(['errors' => $validator->errors(), 'code' => '424']);
                        exit;
                    }
                } else {
                    // Si las contraseñas no tienen al menos 6 caracteres, devuelve un error
                    return response()->json(['errors' => $validator->errors(), 'code' => '423']);
                    exit;
                }
            } else {
                // Si no se ingresó una nueva contraseña, se mantiene la contraseña actual
                $passwordEditar = $request->contaseniaUsuarioActual;
            }

            // Inicializa el nombre del archivo de la foto
            $fileName = $request->fotoActualUsuario;

            // Si se cargó una nueva foto
            if ($request->hasFile('fotoUsuario')) {
                $file = $request->fotoUsuario->getClientOriginalName();
                $fileName = time() . '.' . $request->fotoUsuario->getClientOriginalExtension();
                $pathtmp = public_path('img/usuarios/');

                // Si no existe la carpeta de destino, la crea
                if (!file_exists($pathtmp)) {
                    mkdir($pathtmp, 0777, true);
                }
            }

            // Obtiene el usuario a actualizar
            $usuario = User::find($id);

            // Datos actualizados del usuario
            $data = [
                "nombres" => trim($request->nombreUsuario),
                "apellidos" => trim($request->apellidoUsuario),
                "usuario" => trim($request->txtUsuario),
                "email" => trim($request->emailUsuario),
                "direccion" => trim($request->direccionUsuario),
                "telefono" => trim($request->telefonoUsuario),
                "foto" => $fileName,
                "password" => $passwordEditar,
                "estado" => 1,
                "updated_at" => now()
            ];

            // Actualiza los detalles del usuario en la base de datos
            if ($usuario->update($data)) {
                // Si se cargó una foto, la guarda en la carpeta de destino
                if ($request->hasFile('fotoUsuario')) {
                    $request->fotoUsuario->move($pathtmp, $fileName);
                }
                // Devuelve una respuesta de éxito
                return response()->json(['msg' => 'sucess', 'code' => '200', 'url' => url('/usuarios')]);
            } else {
                // Si falla la actualización, devuelve los errores
                return response()->json(['errors' => $validator->errors(), 'code' => '425']);
            }
        }
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(Request $request, string $id)
    {
        // Si no es una petición Ajax, redirecciona
        if (!$request->ajax()) {
            return redirect('/usuarios');
        }
        // Elimina el usuario de la base de datos
        User::destroy($id);
        // Devuelve una respuesta de éxito
        return response()->json(['msg' => 'sucess', 'code' => '200']);
    }

    /**
     * Activa el usuario especificado.
     */
    public function activar(Request $request, $user_id)
    {
        // Si no es una petición Ajax, redirecciona
        if (!$request->ajax()) {
            return redirect('/usuarios');
        }
        // Encuentra al usuario a activar
        $user = User::find($user_id);
        // Datos a actualizar
        $data = [
            "estado" => 1,
        ];
        // Actualiza el estado del usuario en la base de datos
        if ($user->update($data)) {
            // Devuelve una respuesta de éxito
            return response()->json(['msg' => 'sucess', 'code' => '200']);
        }
    }

    /**
     * Desactiva el usuario especificado.
     */
    public function desactivar(Request $request, $user_id)
    {
        // Si no es una petición Ajax, redirecciona
        if (!$request->ajax()) {
            return redirect('/usuarios');
        }
        // Encuentra al usuario a desactivar
        $user = User::find($user_id);
        // Datos a actualizar
        $data = [
            "estado" => 0,
        ];
        // Actualiza el estado del usuario en la base de datos
        if ($user->update($data)) {
            // Devuelve una respuesta de éxito
            return response()->json(['msg' => 'sucess', 'code' => '200']);
        }
    }
}
