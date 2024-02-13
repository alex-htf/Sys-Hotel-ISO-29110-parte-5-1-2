@extends('master')

@section('content')


<!-- App hero header starts -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <span>Mantenimiento de Usuarios</span>
    </h3>
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-user"></i> Usuarios</li>
        </ol>
    </nav>

</div>
<!-- App Hero header ends -->

<div class="app-body" style="margin-top:-8.5rem !important;height: calc(103vh - 202px);">

    <div class="row mb-3  d-flex align-items-center">
        <div class="col-xl-12">
            <div class="form-group">
                <h5 class="mb-3">Buscar por:</h5>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="txtNombreUsuarioB" style="font-size:14px;">Nombre: </label>
                <input type="text" class="form-control" id="txtNombreUsuarioB" name="txtNombreUsuarioB" placeholder="Nombre del Usuario...">
            </div>
        </div>

        <div class="col-xl-6 col-md-6 col-sm-12">
            <div class="form-group mr-20-sm boton-group mt-3">
                   
                <a type="button" class="btn btn-success btn-fw"  href="{{ route('usuarios.create') }}"><img src="{{ url('assets/images/add.png') }}" alt="agregar" width="25px"> Agregar Usuario</a>

            </div>
        </div>
        
    </div>

    <div class="row mt-3">
        <div class="col-xxl-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <section class="usuarios">
                        @if(isset($usuarios) && count($usuarios) > 0)
                                
                            @include('data.load_usuarios_data')
                        
                        @else 
                            <div class="table-responsive">
                                <table class="table align-middle table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Email</th>
                                            <th>Dirección</th>
                                            <th>Teléfono</th></th>
                                            <th>Usuario</th>
                                            <th>Foto</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center" colspan="10">No se encontraron registros</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </section>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')

    <script>

        $(window).on('hashchange',function(){
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else{
                    loadusuarios(page);
                }
            }
        });

        $(document).on('click', '.usuarios .pagination a', function(event){
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                // console.log(page);
                loadusuarios(page);
        });

        function loadusuarios(page)
        {
            let url='';
            let txtNombreBuscar = $('#txtNombreB').val();

            url=$('meta[name=app-url]').attr("content") + "/usuarios?page="+page;

            $.ajax({
                url: url,
                method:'GET',
                data: {usuario: txtNombreBuscar}
            }).done(function (data) {
                $('.usuarios').html(data);
            }).fail(function () {
                console.log("Failed to load data!");
            });
        }

        $('#txtNombreUsuarioB').on('keyup', function(e){
            let usuario = this.value;
            const url=$('meta[name=app-url]').attr("content") + "/usuarios";
            $.ajax({
                headers: 
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                method:'GET',
                data: {usuario: usuario}
            }).done(function (data) {
                $('.usuarios').html(data);
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        });

        function eliminarUsuario(user_id)
        {
            Swal.fire({
                icon: 'warning',
                title: 'Está seguro de eliminar el Usuario?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: "#EB1010",
                confirmButtonText: `Eliminar`,
                cancelButtonText: `Cancelar`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = $('meta[name=app-url]').attr("content") + "/usuarios/"  + user_id;
                        let data = {
                            user_id: user_id
                        };
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: url,
                            type: "DELETE",
                            data: data,
                            success: function(response) {
                                // console.log(response);
                                if(response.code == "200")
                                {
                                    loadusuarios();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'ÉXITO!',
                                        text: 'Se ha eliminado el usuario correctamente'
                                    });
                                }
                            },
                            error: function(response) {                
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ERROR...',
                                    text: 'Se ha producido un error al intentar eliminar el registro!'
                                })
                            }
                        });
                    }
                })
        };

        function desactivarUsuario(user_id)
        {
            Swal.fire({
                    icon: 'warning',
                    title: 'Está seguro de desactivar el Usuario?',
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonColor: "#EB1010",
                    confirmButtonText: `Desactivar`,
                    cancelButtonText: `Cancelar`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let url = $('meta[name=app-url]').attr("content") +  "/usuarios" +  "/desactivar/" + user_id;
                            let data = {
                                user_id: user_id
                            };
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: url,
                                type: "POST",
                                data: data,
                                success: function(response) {
                                    // console.log(response);
                                    if(response.code == "200")
                                    {
                                        loadusuarios();

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'ÉXITO!',
                                            text: 'Se ha desactivado el Usuario correctamente'
                                        });
                                        // document.location.reload(true)
                                    }
                                },
                                error: function(response) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'ERROR...',
                                        text: 'Se ha producido un error al intentar desactivar el registro!'
                                    })
                                }
                            });
                        }
                    })
        }

        function activarUsuario (user_id)
        {
            Swal.fire({
                    icon: 'warning',
                    title: 'Está seguro de activar el Usuario?',
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonColor: "#EB1010",
                    confirmButtonText: `Activar`,
                    cancelButtonText: `Cancelar`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let url = $('meta[name=app-url]').attr("content") + "/usuarios" +  "/activar/" + user_id;
                            let data = {
                                user_id: user_id
                            };
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: url,
                                type: "POST",
                                data: data,
                                success: function(response) {
                                    // console.log(response);
                                    if(response.code == "200")
                                    {
                                        loadusuarios();

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'ÉXITO!',
                                            text: 'Se ha activado el Usuario correctamente'
                                        });
    
                                    }
                                },
                                error: function(response) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'ERROR...',
                                        text: 'Se ha producido un error al intentar desactivar el registro!'
                                    })
                                }
                            });
                        }
                    })
        }

    </script>

@endsection