<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Validator, Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()  
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        //
          
        $nusuario = isset($request->usuario) ? $request->usuario : '';

        $usuarios = User::getUsers($nusuario);

        $ruta = 'usuarios';

        if ($request->ajax()):
            return view('data.load_usuarios_data', compact('usuarios', 'ruta'));
        endif;

        return view('modules.usuarios', compact('usuarios', 'ruta'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $ruta = 'usuarios';

        return view('modules.crud-usuarios', compact('ruta'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        if (!$request->ajax()):
            return redirect('/admin/usuarios');
        endif;

        $rules = [
            'nombreUsuario' => 'required',
            'apellidoUsuario' => 'required',
            'emailUsuario' => 'required|email',
            'txtUsuario' => 'required|unique:users,usuario',
            'contraseniaUsuario'=>'required|min:6',
            'confirmarContraseniaUsuario'=>'required|min:6|same:contraseniaUsuario'
        ];
        
        $messages = [
            'nombreUsuario.required' => 'El Nombre del Usuario es requerido',
            'apellidoUsuario.required' => 'El Apellido del Usuario es requerido',
            'emailUsuario.required' => 'El Email del Usuario es requerido',
            'emailUsuario.email' => 'El Email del Usuario debe ser una dirección Válida',
            'txtUsuario.required' => 'El campo Usuario es requerido',
            'txtUsuario.unique' => 'Ya existe el Usuario',
            'contraseniaUsuario.required' => 'El Campo Contraseña es requerido',
            'contraseniaUsuario.min' => 'La contraseña debe contener al menos 6 carácteres',
            'confirmarContraseniaUsuario.required' => 'Es necesario confirmar la contraseña',
            'confirmarContraseniaUsuario.min' => 'La confirmación de contraseña debe contener al menos 6 carácteres',
            'confirmarContraseniaUsuario.same' => 'Las contraseñas no coinciden.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:
            $fileName= '';
            if ($request->hasFile('fotoUsuario')):
                $file = $request->fotoUsuario->getClientOriginalName();
        
                $fileName = time() . '.' . $request->fotoUsuario->getClientOriginalExtension();
                $pathtmp = public_path('img/usuarios/');

                if (!file_exists($pathtmp)):
                    mkdir($pathtmp, 0777, true);
                endif;
            endif;    

            $data = [
                "nombres" =>trim($request->nombreUsuario),
                "apellidos" =>trim($request->apellidoUsuario),
                "usuario"=>trim($request->txtUsuario),
                "email"=>trim($request->emailUsuario),
                "direccion"=>trim($request->direccionUsuario),
                "telefono"=>trim($request->telefonoUsuario),
                "foto" => $fileName,
                "password" => Hash::make(trim($request->input('contraseniaUsuario'))),
                "estado" => 1,
                "created_at" => now(),
                "remember_token" => Str::random(10)
            ];

            if(User::create($data)):
                if ($request->hasFile('fotoUsuario')):
                    $request->fotoUsuario->move($pathtmp, $fileName);
                endif;
                return response()->json(['msg'=>'sucess', 'code' => '200', 'url'=>url('/usuarios')]);
            else: 
                return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
            endif;


        endif;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $dataU = User::where('user_id', $id)->first();

        if($dataU == NULL):
            return redirect('/usuarios');
        endif;

        $usuario = User::where('user_id', $id)->first();

        $ruta = 'usuarios';

        return view('modules.crud-usuarios', compact('usuario', 'ruta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        if (!$request->ajax()):
            return redirect('/usuarios');
        endif;

        $rules = [
            'nombreUsuario' => 'required',
            'apellidoUsuario' => 'required',
            'emailUsuario' => 'required|email',
            'txtUsuario' => 'required|unique:users,usuario,'.$id.',user_id',
        ];
        
        $messages = [
            'nombreUsuario.required' => 'El Nombre del Usuario es requerido',
            'apellidoUsuario.required' => 'El Apellido del Usuario es requerido',
            'emailUsuario.required' => 'El Email del Usuario es requerido',
            'emailUsuario.email' => 'El Email del Usuario debe ser una dirección Válida',
            'txtUsuario.required' => 'El campo Usuario es requerido',
            'txtUsuario.unique' => 'Ya existe el Usuario',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:
            
            $passwordEditar = '';

            if($request->contraseniaUsuario != "" || $request->confirmarContraseniaUsuario != ""):
                if(strlen($request->contraseniaUsuario) >=6 || strlen($request->confirmarContraseniaUsuario) >=6):
                    if(trim($request->contraseniaUsuario) === trim($request->confirmarContraseniaUsuario)):
                        $passwordEditar = Hash::make($request->input('contraseniaUsuario'));
                    else:
                        return response()->json(['errors'=>$validator->errors(), 'code' => '424']);
                        exit;
                    endif;
                else:
                    return response()->json(['errors'=>$validator->errors(), 'code' => '423']);
                    exit;
                endif;
               
            else:
                $passwordEditar = $request->contaseniaUsuarioActual;
            endif;

            $fileName= $request->fotoActualUsuario;

            if ($request->hasFile('fotoUsuario')):
                $file = $request->fotoUsuario->getClientOriginalName();
        
                $fileName = time() . '.' . $request->fotoUsuario->getClientOriginalExtension();
                $pathtmp = public_path('img/usuarios/');

                if (!file_exists($pathtmp)):
                    mkdir($pathtmp, 0777, true);
                endif;
            endif;    

            $usuario = User::find($id);

            $data = [
                "nombres" =>trim($request->nombreUsuario),
                "apellidos" =>trim($request->apellidoUsuario),
                "usuario"=>trim($request->txtUsuario),
                "email"=>trim($request->emailUsuario),
                "direccion"=>trim($request->direccionUsuario),
                "telefono"=>trim($request->telefonoUsuario),
                "foto" => $fileName,
                "password" => $passwordEditar,
                "estado" => 1,
                "updated_at" => now()
            ];

            if($usuario->update($data)):

                if ($request->hasFile('fotoUsuario')):
                    $request->fotoUsuario->move($pathtmp, $fileName);
                endif;
                
                return response()->json(['msg'=>'sucess', 'code' => '200', 'url'=>url('/usuarios')]);

            else:
                return response()->json(['errors'=>$validator->errors(), 'code' => '425']);

            endif;

        endif;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        //
        if (!$request->ajax()):
            return redirect('/usuarios');
        endif;

        User::destroy($id);

        return response()->json(['msg'=>'sucess', 'code' => '200']);
    
    }

    public function activar(Request $request, $user_id)
    {
        if (!$request->ajax()):
            return redirect('/usuarios');
        endif;
        $user = User::find($user_id);
        $data = [
            "estado"=>1,
        ];
        if($user->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif;    
    }
    
    public function desactivar(Request $request, $user_id)
    {
        if (!$request->ajax()):
            return redirect('/usuarios');
        endif;
        $user = User::find($user_id);
        $data = [
            "estado"=>0,
        ];
        if($user->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif;    
    }

}
