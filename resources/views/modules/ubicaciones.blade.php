@extends('master')

@section('content')

<!-- App hero header starts -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <span>Mantenimiento de Ubicaciones</span>
    </h3>
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item" aria-current="page"><i class="fa-solid fa-database"></i> Mantenimiento Habitaciones</li>
            <li class="breadcrumb-item active" aria-current="page">Ubicación</li>
        </ol>
    </nav>

</div>
<!-- App Hero header ends -->



<div class="app-body" style="margin-top:-8.5rem !important;height: calc(103vh - 202px);">

    <div class="row mb-3 d-flex align-items-center">
        <div class="col-xl-12">
            <div class="form-group">
                <h5 class="mb-3">Buscar por:</h5>
            </div>
        </div>

        <div class="col-xl-5 col-md-6 col-sm-12">
            <div class="form-group d-flex align-items-center gap-3">
                <label for="estadoUbicacionesBuscar" style="font-size:14px;">Estado:</label>
                <select name="estadoUbicacionesBuscar" id="estadoUbicacionesBuscar" class="form-control">
                    <option value="_all_">--Seleccione--</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 col-sm-12 d-flex justify-content-start">
            <div class="form-group">
                <button type="button" class="btn btn-success btn-fw" data-bs-toggle="modal" data-bs-target="#ModalUbicacion"><img src="{{ url('assets/images/add.png') }}" alt="agregar" width="25px"> Agregar Ubicación</button>
            </div>
      
        </div>
        
    </div>

    <div class="row mt-3">
        <div class="col-xxl-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <section class="ubicaciones">
                        @if(isset($ubicaciones) && count($ubicaciones) > 0)
                                
                            @include('data.load_ubicaciones_data')
                        
                        @else 
                            <div class="table-responsive">
                                <table class="table align-middle table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Ubicación</th>
                                            <th scope="col">Estado</th>
                                            <th scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center" colspan="4">No se encontraron registros</td>
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


  <!-- Modal Agregar -->
<div class="modal fade" id="ModalUbicacion" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#00368e !important; color:#fff !important;">
        <h5 class="modal-title" id="tituloModalUbicacion">Agregar Ubicación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limpiarModalUbicacion()"></button>
      </div>
      <form action="#" method="POST" id="formUbicacion">
        @csrf
        <input type="hidden" name="ubicacion_id" id="ubicacion_id">
        <div class="modal-body p-4 bg-light">
            <div class="my-2">
                <label for="curso">Ubicacion:</label>
                <input type="text" name="ubicacion" id="ubicacion" class="form-control" placeholder="Ubicación" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limpiarModalUbicacion()">Cerrar</button>
          <button type="submit" id="btnUbicacion" class="btn btn-success">Agregar Ubicación</button>
        </div>
      </form>
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
                    loadubicaciones(page);
                }
            }
        });

        
        $(function (){
            
            $(document).on('click', '.ubicaciones .pagination a', function(event){
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                loadubicaciones(page);
            });

            $('#estadoUbicacionesBuscar').on('change', function (e ){
                url=$('meta[name=app-url]').attr("content") + "/ubicaciones";
                $.ajax({
                    url: url,
                    method:'GET',
                    data: {estado: this.value}
                }).done(function (data) {
                    $('.ubicaciones').html(data);
                }).fail(function () {
                    console.log("Error al cargar los datos");
                });
            });


            
            window.limpiarModalUbicacion = function()
            {   
                $('#tituloModalUbicacion').html('Agregar Ubicación');
                $("#formUbicacion")[0].reset();
                $("#btnUbicacion").text('Registrar Ubicación');
                $('#ubicacion_id').val("");
            }

            function loadubicaciones(page)
            {
                let url='';
                let estado = $('#estadoUbicacionesBuscar').val(); 
                url=$('meta[name=app-url]').attr("content")  + "/ubicaciones?page="+page;

                $.ajax({
                    url: url,
                    method:'GET',
                    data: {estado: estado}
                }).done(function (data) {
                    $('.ubicaciones').html(data);
                }).fail(function () {
                    console.log("Failed to load data!");
                });
            }

            $("#formUbicacion").submit(function(e) {
                event.preventDefault();
                let hddubicacion_id = $('#ubicacion_id').val();
                //valida si el campo ubicacion_id esta vacío
                if(hddubicacion_id!="")
                {
                    ActualizarUbicacion(hddubicacion_id);
                }
                else 
                {
                    GuardarUbicacion();
                }
            });

                //Ajax para registrar Categoria
            window.GuardarUbicacion = function()
            {
                $("#btnUbicacion").prop('disabled', true);
                $("#btnUbicacion").text('Registrando');
                $('#ubicacion_id').val("");
                let url = $('meta[name=app-url]').attr("content") + "/ubicaciones";
                const fd = new FormData($("#formUbicacion")[0]); 
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: "POST",
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#btnUbicacion").prop('disabled', false);
                        $("#btnUbicacion").text('Registrar Ubicación');
                        if(response.code == "200")
                        {
                            
                                $("#ModalUbicacion").modal('hide');
                                limpiarModalUbicacion();
                                loadubicaciones();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'ÉXITO!',
                                    text: 'Se ha registrado la Ubicación correctamente'
                                });
                        }
                        else  if(response.code == "422")
                        {
                                let errors = response.errors;
                                console.log(errors);
                                if (typeof errors.ubicacion !== 'undefined' || typeof errors.ubicacion !== "") 
                                {
                                    ubicacionvalidation = '<li>' + errors.ubicacion + '</li>';
                                }
                                
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ERROR...',
                                    html: '<ul>'+
                                    ubicacionvalidation  + 
                                            '</ul>'
                                });
                        }
                        else if(response.code=="426")
                        {
                            Swal.fire({
                                    icon: 'error',
                                    title: 'ERROR!',
                                    text: 'La Ubicación ya Existe!'
                                });
                        }
                        else 
                        {
                            Swal.fire({
                                    icon: 'error',
                                    title: 'ERROR!',
                                    text: 'Ha ocurrido un error al intentar registrar la Ubicación!'
                                });
                        }
                    }
                })

            }

            window.mostrarUbicacion = function(ubicacion_id) 
            {
                url=$('meta[name=app-url]').attr("content") + "/ubicaciones/" +ubicacion_id;
                $("#ModalUbicacion").modal('show');
                $.ajax({
                    url: url,
                    method:'GET'
                }).done(function (data) {
                    $('#tituloModalUbicacion').html('EDITAR CATEGORÍA: ' +data.ubicacion_id);
                    $('#ubicacion_id').val(ubicacion_id);
                    $('#ubicacion').val(data.ubicacion);
                    $('#btnUbicacion').text('Actualizar Ubicación');
                }).fail(function () {
                    console.log("Error al cargar los datos");
                });
            }

            window.ActualizarUbicacion = function(ubicacion_id)
            {
                $("#btnUbicacion").prop('disabled', true);
                $("#btnUbicacion").text('Actualizando');
                let url = $('meta[name=app-url]').attr("content") + "/ubicaciones/" + ubicacion_id;
                let data = $('#formUbicacion').serialize();
                // let FormDataUbicacionEditar = new FormData($("#formUbicacion")[0]); 
                // FormDataUbicacionEditar.append('_method', 'PUT');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: "PUT",
                    data: data,
                    success: function(response) {
                        $("#btnUbicacion").prop('disabled', false);
                        $("#btnUbicacion").text('Actualizar Ubicación');
                        if(response.code == "200")
                        {
                                $("#ModalUbicacion").modal('hide');
                                limpiarModalUbicacion();
                                loadubicaciones();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'ÉXITO!',
                                    text: 'Se ha actualizado la Ubicación correctamente'
                                });
                        }
                        else if(response.code == "422")
                        {
                            let errors = response.errors;
                            console.log(errors);
                            if (typeof errors.ubicacion !== 'undefined' || typeof errors.ubicacion !== "") 
                            {
                                ubicacionvalidation = '<li>' + errors.ubicacion + '</li>';
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'ERROR...',
                                html: '<ul>'+
                                ubicacionvalidation  + 
                                        '</ul>'
                            });
                        }
                    },
                    error: function(response) {
                        $("#btnUbicacion").prop('disabled', false);
        
                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            text: 'Se ha producido un error al intentar actualizar el registro!'
                        })
                    }
                });
            }

            window.eliminarUbicacion = function(ubicacion_id)
            {
                Swal.fire({
                    icon: 'warning',
                    title: 'Está seguro de eliminar la Ubicación?',
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonColor: "#EB1010",
                    confirmButtonText: `Eliminar`,
                    cancelButtonText: `Cancelar`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let url = $('meta[name=app-url]').attr("content") +  "/ubicaciones/"  + ubicacion_id;
                            let data = {
                                ubicacion_id: ubicacion_id
                            };
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: url,
                                type: "DELETE",
                                data: data,
                                success: function(response) {
                                    if(response.code == "200")
                                    {
                                        loadubicaciones();

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'ÉXITO!',
                                            text: 'Se ha eliminado la Ubicación correctamente'
                                        });
                                    }
                                    else if(response.code == "423")
                                    {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'ERROR...',
                                            text: 'No se puede eliminar la ubicación porque existen habitaciones registradas en la ubicación!'
                                        })
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
            }

            window.desactivarUbicacion = function(ubicacion_id)
            {
                Swal.fire({
                    icon: 'warning',
                    title: 'Está seguro de desactivar la Ubicación?',
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonColor: "#EB1010",
                    confirmButtonText: `Desactivar`,
                    cancelButtonText: `Cancelar`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let url = $('meta[name=app-url]').attr("content") + "/ubicaciones" +  "/desactivar/" + ubicacion_id;
                            let data = {
                                ubicacion_id: ubicacion_id
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
                                        loadubicaciones();
                                    
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'ÉXITO!',
                                            text: 'Se ha desactivado la Ubicación correctamente'
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

            window.activarUbicacion = function(ubicacion_id)
            {
                Swal.fire({
                    icon: 'warning',
                    title: 'Está seguro de activar la Ubicación?',
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonColor: "#EB1010",
                    confirmButtonText: `Activar`,
                    cancelButtonText: `Cancelar`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let url = $('meta[name=app-url]').attr("content") +  "/ubicaciones" +  "/activar/" + ubicacion_id;
                            let data = {
                                ubicacion_id: ubicacion_id
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
                                        loadubicaciones();

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'ÉXITO!',
                                            text: 'Se ha activado la Ubicación correctamente'
                                        });
                                        // document.location.reload(true)
                                    }
                                },
                                error: function(response) {                    
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'ERROR...',
                                        text: 'Se ha producido un error al intentar activar el registro!'
                                    })
                                }
                            });
                        }
                    })
            }

        });

    </script>

@endsection