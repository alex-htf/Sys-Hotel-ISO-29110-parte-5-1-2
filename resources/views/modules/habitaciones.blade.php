@extends('master')

@section('content')

<!-- App hero header starts -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <span>Mantenimiento de Habitaciones</span>
    </h3>
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item" aria-current="page"><i class="fa-solid fa-database"></i> Mantenimiento Habitaciones</li>
            <li class="breadcrumb-item active" aria-current="page">Habitaciones</li>
        </ol>
    </nav>

</div>
<!-- App Hero header ends -->

<div class="app-body" style="margin-top:-8.5rem !important;height: calc(103vh - 202px);">

    <div class="row mb-3">
        <div class="col-xl-12">
            <div class="form-group">
                <h5 class="mb-3">Buscar por:</h5>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="txtHabitacionBuscar" style="font-size:14px;">Habitación: </label>
                <input type="text" class="form-control" id="txtHabitacionBuscar" placeholder="Número de Habitación...">
            </div>
        </div>

        <div class="col-xl-4 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="categoriaHabitacionBuscar" style="font-size:14px;">Categoría:</label>
                <select name="categoriaHabitacionBuscar" id="categoriaHabitacionBuscar" class="form-control">
                    <option value="_all_">--Seleccione--</option>
                    @isset($categorias)
                        @foreach ($categorias as $cat)
                            <option value="{{$cat['categoria_id']}}">{{$cat['categoria']}}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="estadoHabitacionBuscar" style="font-size:14px;">Estado:</label>
                <select name="estadoHabitacionBuscar" id="estadoHabitacionBuscar" class="form-control">
                    <option value="_all_">--Seleccione--</option>
                    <option value="1">Disponible</option>
                    <option value="2">Ocupado</option>
                </select>
            </div>
        </div>
        
    </div>

    <div class="row">
        <div class="col-xl-12 d-flex justify-content-end">
            <div class="form-group">
            <button type="button" class="btn btn-success btn-fw" data-bs-toggle="modal" data-bs-target="#ModalHabitacion"><img src="{{ url('assets/images/add.png') }}" alt="agregar" width="25px"> Agregar Habitación</button>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xxl-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <section class="habitaciones">
                        @if(isset($habitaciones) && count($habitaciones) > 0)
                                
                            @include('data.load_habitaciones_data')
                        
                        @else 
                            <div class="table-responsive">
                                <table class="table align-middle table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Imagen</th>
                                            <th scope="col">Habitación</th>
                                            <th scope="col">Categoría</th>
                                            <th scope="col">Ubicación</th>
                                            <th scope="col">Detalle</th>
                                            <th scope="col">Precio</th>
                                            <th scope="col">Estado</th>
                                            <th scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center" colspan="9">No se encontraron registros</td>
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
    <div class="modal fade" id="ModalHabitacion" tabindex="-1" aria-labelledby="exampleModalLabel"
    data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header" style="background-color:#00368e !important; color:#fff !important;">
                <h5 class="modal-title" id="tituloModalHabitacion">Agregar Habitación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limpiarModalHabitación()"></button>
            </div>
            <form action="#" method="POST" id="formHabitacion" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="habitacion_id" id="habitacion_id">
                <input type="hidden" name="imagen_habitacion" id="imagen_habitacion">
                <div class="modal-body p-4 bg-light">
                    <div class="my-2">
                        <label for="curso">Habitación:</label>
                        <input type="text" name="habitacion" id="habitacion" class="form-control" placeholder="Habitación" required>
                    </div>

                    <div class="my-2">
                        <label for="curso">Categoría:</label>
                        <select class="form-control" name="categoriaHabitacion" id="categoriaHabitacion">
                            <option value="">--Seleccione Categoría--</option>
                            @isset($categorias)
                                @foreach ($categorias as $cat)
                                    <option value="{{$cat['categoria_id']}}">{{$cat['categoria']}}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="my-2">
                        <label for="curso">Ubicación:</label>
                        <select class="form-control" name="ubicacionHabitacion" id="ubicacionHabitacion">
                            <option value="">--Seleccione Ubicación--</option>
                            @isset($ubicaciones)
                                @foreach ($ubicaciones as $ubi)
                                    <option value="{{$ubi['ubicacion_id']}}">{{$ubi['ubicacion']}}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>


                    <div class="my-2">
                        <label for="curso">Detalles:</label>
                        <textarea class="form-control ml-2" name="detalles" id="detalles" cols="20" rows="3" placeholder="Ingrese el detalle de la habitación.." required></textarea>
                    </div>

                    <div class="my-2">
                        <label for="curso">Precio:</label>
                        <input type="number" name="precio" id="precio" class="form-control" placeholder="Precio" required>
                    </div>
                    
                    <div class="my-2">
                        <label for="imagen">Imagen:</label>
                        <input type="file" name="imagen" id="imagen" class="form-control">
                    </div>

                    <div class="mt-2" id="imagenpreview">

                    </div>

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limpiarModalHabitación()">Cerrar</button>
                <button type="submit" id="btnHabitacion" class="btn btn-success">Registrar Habitación</button>
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
                loadHabitaciones(page);
            }
        }
    });

    $(function (){

        $(document).on('click', '.habitaciones .pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            loadHabitaciones(page);
        });

        $('#txtHabitacionBuscar').on('keyup', function(e){
            url=$('meta[name=app-url]').attr("content") + "/habitaciones";
            let categoriaBuscar = $('#categoriaHabitacionBuscar').val(); 
            let estadocategoria = $('#estadoHabitacionBuscar').val(); 
            $.ajax({
                url: url,
                method:'GET',
                data: {habitacion: this.value, categoria:categoriaBuscar, estado: estadocategoria}
            }).done(function (data) {
                $('.habitaciones').html(data);
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        });

        
        $('#categoriaHabitacionBuscar').on('change', function (e ){
            url=$('meta[name=app-url]').attr("content") + "/habitaciones";
            let habitacionbuscar = $('#txtHabitacionBuscar').val();
            let estadocategoria = $('#estadoHabitacionBuscar').val(); 
            $.ajax({
                url: url,
                method:'GET',
                data: {habitacion: habitacionbuscar, categoria: this.value, estado: estadocategoria}
            }).done(function (data) {
                $('.habitaciones').html(data);
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        });


        
        $('#estadoHabitacionBuscar').on('change', function (e ){
            url=$('meta[name=app-url]').attr("content") + "/habitaciones";
            let habitacionbuscar = $('#txtHabitacionBuscar').val();
            let categoriaBuscar = $('#categoriaHabitacionBuscar').val(); 
            $.ajax({
                url: url,
                method:'GET',
                data: {habitacion: habitacionbuscar, categoria: categoriaBuscar, estado: this.value}
            }).done(function (data) {
                $('.habitaciones').html(data);
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        });


        window.limpiarModalHabitación = function()
        {   
            $('#tituloModalHabitacion').html('Agregar Habitación');
            $('#habitacion_id').val("");
            $('#categoriaHabitacion').prop('selectedIndex',0);
            $('#ubicacionHabitacion').prop('selectedIndex',0);
            $('#precio').val("");
            $("#formHabitacion")[0].reset();
            $('#imagenpreview').html("");
            $("#btnHabitacion").text('Registrar Habitación');
        }

        function loadHabitaciones(page)
        {
            let url='';
            url=$('meta[name=app-url]').attr("content")  + "/habitaciones?page="+page;

            $.ajax({
                url: url,
                method:'GET',
            }).done(function (data) {
                $('.habitaciones').html(data);
            }).fail(function () {
                console.log("Failed to load data!");
            });
        }

        $("#formHabitacion").submit(function(e) {
            event.preventDefault();
            let hddhabitacion_id = $('#habitacion_id').val();
            //valida si el campo tarifa_id esta vacío
            if(hddhabitacion_id!="")
            {
                ActualizarHabitacion(hddhabitacion_id);
            }
            else 
            {
                GuardarHabitacion();
            }
        });

        //Ajax para registrar Categoria
        window.GuardarHabitacion = function()
        {
            $("#btnHabitacion").prop('disabled', true);
            $('#imagenpreview').html("");
            $("#btnHabitacion").text('Registrando');
            let url = $('meta[name=app-url]').attr("content") + "/habitaciones";

            let data = new FormData($("#formHabitacion")[0]); 
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function(response) {
                    $("#btnHabitacion").prop('disabled', false);
                    $("#btnHabitacion").text('Registrar Habitación');
                    if(response.code == "200")
                    {
                            $("#ModalHabitacion").modal('hide');
                            limpiarModalHabitación();
                            loadHabitaciones();

                            Swal.fire({
                                icon: 'success',
                                title: 'ÉXITO!',
                                text: 'Se ha registrado la Habitación correctamente'
                            });
                    }
                    else  if(response.code == "422")
                    {
                        let errors = response.errors;
                        let HabitacionValidation = '';

                        $.each(errors, function(index, value) {

                        if (typeof value !== 'undefined' || typeof value !== "") 
                        {
                            HabitacionValidation += '<li>' + value + '</li>';
                        }

                        }); 


                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            html: '<ul>'+
                            HabitacionValidation  + 
                                    '</ul>'
                        });
                    }
                    else 
                    {
                        Swal.fire({
                                icon: 'error',
                                title: 'ERROR!',
                                text: 'Ha ocurrido un error al intentar registrar la categoría!'
                            });
                    }
                }
            })
        }

        window.mostrarHabitacion = function(habitacion_id) 
        {
            url=$('meta[name=app-url]').attr("content") + "/habitaciones/" +habitacion_id;
            $("#ModalHabitacion").modal('show');
            $('#imagenpreview').html("");
            $('#habitacion_id').val("");
            $.ajax({
                url: url,
                method:'GET'
            }).done(function (data) {
                console.log(data);
                $('#tituloModalHabitacion').html('EDITAR HABITACIÓN: ' +data.habitacion);
                $('#habitacion_id').val(habitacion_id);
                $('#habitacion').val(data.habitacion);
                $('#categoriaHabitacion').val(data.categoria_id);
                $('#detalles').val(data.detalles);
                $('#precio').val(data.precio);
                if(data.imagen){
                    $('#imagen_habitacion').val(data.imagen);
                    $("#imagenpreview").html(
                        `<img src="img/habitaciones/${data.imagen}" width="140" class="img-fluid img-thumbnail">`);
                }
                $('#btnHabitacion').text('Actualizar Habitación');
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        }

        $('#imagen').change(function(){   
            $('#imagenpreview').html("");
        });

        window.ActualizarHabitacion = function(habitacion_id)
        {
            $("#btnHabitacion").prop('disabled', true);
            $("#btnHabitacion").text('Actualizando');
            let url = $('meta[name=app-url]').attr("content") + "/habitaciones/" + habitacion_id;
            let dataE = new FormData($("#formHabitacion")[0]); 
            dataE.append('_method', 'PUT');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                data: dataE,
                processData: false,
                contentType: false,
                success: function(response) {
                    $("#btnHabitacion").prop('disabled', false);
                    $("#btnHabitacion").text('Actualizar Tarifa');
                    if(response.code == "200")
                    {
                            
                            $("#ModalHabitacion").modal('hide');
                            limpiarModalHabitación();
                            loadHabitaciones();

                            Swal.fire({
                                icon: 'success',
                                title: 'ÉXITO!',
                                text: 'Se ha actualizado la Tarifa correctamente'
                            });
                    }
                    else if(response.code == "422")
                    {
                        let errors = response.errors;
                        let HabitacionValidation = '';

                        $.each(errors, function(index, value) {

                            if (typeof value !== 'undefined' || typeof value !== "") 
                            {
                                HabitacionValidation += '<li>' + value + '</li>';
                            }

                        }); 

                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            html: '<ul>'+
                            HabitacionValidation  + 
                                    '</ul>'
                        });
                    }
                },
                error: function(response) {
                    $("#btnHabitacion").prop('disabled', false);
    
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'Se ha producido un error al intentar actualizar el registro!'
                    })
                }
            });
        }

        window.eliminarHabitacion = function(habitacion_id)
        {
            Swal.fire({
                icon: 'warning',
                title: 'Está seguro de eliminar la Habitación?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: "#EB1010",
                confirmButtonText: `Eliminar`,
                cancelButtonText: `Cancelar`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = $('meta[name=app-url]').attr("content") +  "/habitaciones/"  + habitacion_id;
                        let data = {
                            habitacion_id: habitacion_id
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
                                    loadHabitaciones();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'ÉXITO!',
                                        text: 'Se ha eliminado la Habitación correctamente'
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
        }

        window.OcupadaHabitación = function(habitacion_id)
        {
            Swal.fire({
                icon: 'warning',
                title: 'Está seguro de designar la habitación como Ocupado?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: "#EB1010",
                confirmButtonText: `Aceptar`,
                cancelButtonText: `Cancelar`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = $('meta[name=app-url]').attr("content") + "/habitaciones" +  "/ocupado/" + habitacion_id;
                        let data = {
                            habitacion_id: habitacion_id
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
                                    loadHabitaciones();
                                   
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'ÉXITO!',
                                        text: 'Se ha designado la Habitación como ocupado'
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

        window.DisponibleHabitación = function(habitacion_id)
        {
            Swal.fire({
                icon: 'warning',
                title: 'La habitación esta disponible?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: "#EB1010",
                confirmButtonText: `Aceptar`,
                cancelButtonText: `Cancelar`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = $('meta[name=app-url]').attr("content") +  "/habitaciones" +  "/disponible/" + habitacion_id;
                        let data = {
                            habitacion_id: habitacion_id
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
                                    loadHabitaciones();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'ÉXITO!',
                                        text: 'La habitación esta disponible'
                                    });
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