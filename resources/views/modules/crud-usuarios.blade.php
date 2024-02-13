@extends('master')

@section('content')

<!-- App hero header starts -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <span>Formulario nuevo usuario</span>
    </h3>
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ url('/usuarios') }}"><i class="fas fa-user"></i> Usuarios</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Crear Usuario</li>
        </ol>
    </nav>

</div>
<!-- App Hero header ends -->

<div class="app-body" style="margin-top:-8.5rem !important;height: calc(103vh - 202px);">

    <div class="row">

    <div class="col-12">
        <div class="card">

            <form method="POST" action="{{ url('usuarios') }}" enctype="multipart/form-data" id="formUsuario">

                @csrf

                <div class="card-body">

                    <h3 class="card-title mt-3 mb-3">Datos del Usuario</h3>

                    <div class="form-group row mb-3">

                        <div class="col-md-6 col-sm-12">
                            <input type="hidden" name="hddusuario_id" id="hddusuario_id" value="{{ isset($usuario) ? $usuario->user_id : '' }}">
                            <label for="nombreUsuario"><b> Nombres:</b></label>
                            <input type="text" class="form-control ml-2" id="nombreUsuario"  name="nombreUsuario" placeholder="Ingrese el Nombre del Usuario.." value="{{ isset($usuario) ? $usuario->nombres : '' }}">
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <label for="apellidoUsuario"><b> Apellidos:</b></label>
                            <input type="text" class="form-control ml-2" id="apellidoUsuario"  name="apellidoUsuario" placeholder="Ingrese el Apellido del USuarios.." value="{{ isset($usuario) ? $usuario->apellidos : '' }}">
                        </div>

                    </div>

                    <div class="form-group row mb-3">

                        <div class="col-md-6 col-sm-12">
                        <label for="emailUsuario"><b> Email:</b></label>
                        <input type="text" class="form-control ml-2" id="emailUsuario"  name="emailUsuario" placeholder="Ingrese el Email del Usuario.." value="{{ isset($usuario) ? $usuario->email : '' }}">
                        </div>

                        <div class="col-md-6 col-sm-12">
                        <label for="direccionUsuario"><b>Direccion:</b></label>
                        <input type="text" class="form-control ml-2" id="direccionUsuario"  name="direccionUsuario" placeholder="Ingrese la dirección del USuarios.." value="{{ isset($usuario) ? $usuario->direccion : '' }}">
                        </div>

                    </div>

                    <div class="form-group row mb-3">

                        <div class="col-md-6 col-sm-12">
                            <label for="telefonoUsuario"><b>Teléfono:</b></label>
                            <input type="text" class="form-control ml-2" id="telefonoUsuario"  name="telefonoUsuario" placeholder="Ingrese el Teléfono del Usuario.." value="{{ isset($usuario) ? $usuario->telefono : '' }}">
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <label for="txtUsuario"><b>Usuario:</b></label>
                            <input type="text" class="form-control ml-2" id="txtUsuario"  name="txtUsuario" placeholder="Ingrese el Usuario.." value="{{ isset($usuario) ? $usuario->usuario : '' }}">
                        </div>

                    </div>

                    <div class="form-group row mb-3">

                    <div class="col-md-6 col-sm-12">
                    <label for="contraseniaUsuario"><b><span style="color:#AB0505;">(*)</span> Contraseña:</b></label>
                    <input type="password" class="form-control ml-2" id="contraseniaUsuario"  name="contraseniaUsuario" placeholder="Ingrese la Contraseña del Usuario.." 
                    @isset($usuario)
                    data-toggle="tooltip" data-placement="top" title="Ingrese la nueva contraseña si desea modificarla, caso contrario dejarla en blanco"
                    @endisset
                    >
                    <input type="hidden" name="contaseniaUsuarioActual" id="contaseniaUsuarioActual" value="{{ isset($usuario) ? $usuario->password : '' }}">
                    <small class="text-muted  ml-2"><span style="color:#AB0505;">Las contraseñas no deben contener espacios en blanco</span></small>
                    </div>

                    <div class="col-md-6 col-sm-12">
                    <label for="confirmarContraseniaUsuario"><b><span style="color:#AB0505;">(*)</span> Confirmar Contraseña:</b></label>
                    <input type="password" class="form-control ml-2" id="confirmarContraseniaUsuario"  name="confirmarContraseniaUsuario" placeholder="Ingrese el Usuario.."
                    @isset($usuario)
                    data-toggle="tooltip" data-placement="top" title="confirme la contraseña si desea modificarla, caso contrario dejarla en blanco"
                    @endisset
                    >
                    <small class="text-muted  ml-2"><span style="color:#AB0505;">Las contraseñas no deben contener espacios en blanco</span></small>
                    </div>

                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-md-6 col-12">
                            <label for="fotoUsuario"><b>&nbsp;&nbsp;Foto:</b></label>
                            <input type="file" name="fotoUsuario" id="fotoUsuario" class="form-control">
                            @if(isset($usuario->foto))
                                <input type="hidden" name="fotoActualUsuario" id="fotoActualUsuario" value="{{$usuario->foto}}">
                            @endif
                        </div>
                    
                    </div>

                    <div  id="fotoUsuario_preview" class="form-group row">

                        <div class="col-6">
                            @if(isset($usuario) && $usuario->foto!="")

                                <img src="{{URL::asset('img/usuarios/'.$usuario->foto)}}" width="350" class="img-fluid img-thumbnail">

                            @endif
                        </div>

                    </div>  

                </div>

                <div class="card-footer">
                    <div class="form-group">

                        <a class="btn btn-danger btn-icon-split" href="{{ url('/usuarios') }}"> <span class="icon text-white-50"><img src="{{ url('assets/images/cancel.png') }}" width="24px"></span><span class="text">Cancelar</span></a>
                        <button type="submit" class="btn btn-success btn-fw" id="guardarUsuario"><span class="icon text-white-50"><img src="{{ url('assets/images/save.png') }}" width="24px"></span><span class="text">Guardar</span></button> 
                                            
                    </div>
                </div>

            </form>

        </div>
    </div>

    </div>

</div>

@endsection

@section('scripts')

    <script>
        
        $('#guardarUsuario').click(function(event){
            event.preventDefault();
            let hddusuario_id = $('#hddusuario_id').val();
            if(hddusuario_id!="")
            {
                actualizarUsuario(hddusuario_id);
            }
            else 
            {
                guardarUsuario();
            }
        });

        $('#fotoUsuario').change(function(){   
            $('#fotoUsuario_preview').html("");
        });

        window.guardarUsuario = function(){
            $("#guardarUsuario").prop('disabled', true);
            $("#guardarUsuario").text('Guardando...');
            let url = $('meta[name=app-url]').attr("content") + "/usuarios";
            let formData = new FormData($("#formUsuario")[0]); 
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                data: formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success: function(response) {
                    $("#guardarUsuario").prop('disabled', false);
                    $("#guardarUsuario").text('Guardar');
                    if(response.code == "200")
                    {   
                            Swal.fire({
                            icon: 'success',
                            title: 'ÉXITO!',
                            text: 'Se ha registrado el Usuario correctamente',
                            showCancelButton: false,
                            allowOutsideClick: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location = response.url;
                                }
                            });

                    }
                    else  if(response.code == "422")
                    {
                        let errors = response.errors;
                        let usuarioValidation = '';

                        $.each(errors, function(index, value) {

                            if (typeof value !== 'undefined' || typeof value !== "") 
                            {
                                usuarioValidation += '<li>' + value + '</li>';
                            }

                        }); 

                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            html: '<ul>'+
                                usuarioValidation  + 
                                    '</ul>'
                        });
                    }
                },
                error: function(response) {
                    $("#guardarUsuario").prop('disabled', false);

                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'Se ha producido un error al intentar guardar el registro!'
                    })
                }
            });
        }

        window.actualizarUsuario = function(hddusuario_id)
        {
            $("#guardarUsuario").prop('disabled', true);
            $("#guardarUsuario").text('Guardando...');
            let url = $('meta[name=app-url]').attr("content") + "/usuarios/" + hddusuario_id;
            let FormDataUsuarioEditar = new FormData($("#formUsuario")[0]); 
            FormDataUsuarioEditar.append('_method', 'PUT');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                enctype: 'multipart/form-data',
                data: FormDataUsuarioEditar,
                processData: false,  
                contentType: false,  
                success: function(response) {
                    $("#guardarUsuario").prop('disabled', false);
                    $("#guardarUsuario").text('Guardar');
                    if(response.code == "200")
                    {   
                            Swal.fire({
                            icon: 'success',
                            title: 'ÉXITO!',
                            text: 'Se ha actualizado el Usuario correctamente',
                            showCancelButton: false,
                            allowOutsideClick: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location = response.url;
                                }
                            });

                    }
                    else  if(response.code == "422")
                    {
                            let errors = response.errors;
                            let usuarioValidation = '';

                            $.each(errors, function(index, value) {

                                if (typeof value !== 'undefined' || typeof value !== "") 
                                {
                                    usuarioValidation += '<li>' + value + '</li>';
                                }

                            }); 

                            Swal.fire({
                                icon: 'error',
                                title: 'ERROR...',
                                html: '<ul>'+
                                usuarioValidation  + 
                                        '</ul>'
                            });
                    }
                    else if(response.code=="423")
                    {
                        Swal.fire({
                                icon: 'error',
                                title: 'ERROR!',
                                text: 'La contraseña debe tener un mínimo de 6 carácteres'
                            });
                    }
                    else if(response.code=="424")
                    {
                        Swal.fire({
                                icon: 'error',
                                title: 'ERROR!',
                                text: 'Las Contraseñas no coinciden!'
                            });
                    }
                },
                error: function(response) {
                    $("#guardarUsuario").prop('disabled', false);
                    $("#guardarUsuario").text('Guardar');
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'Se ha producido un error al intentar guardar el registro!'
                    })
                }
            });
        }

    </script>

@endsection