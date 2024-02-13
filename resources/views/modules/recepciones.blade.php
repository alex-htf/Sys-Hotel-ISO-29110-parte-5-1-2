@extends('master')

@section('content')

    
<!-- App hero header starts -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <b><span>VISTA GENERAL DE RECEPCIÓN</span></b>
    </h3>
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-right-from-bracket"></i> Recepción</li>
        </ol>
    </nav>

</div>
<!-- App Hero header ends -->

<div class="app-body" style="margin-top:-8.5rem !important;height: calc(103vh - 202px);">
    <div class="row mb-3">
        <div class="col-lg-4 col-md-6 col-6">
            <div class="form-group d-flex align-items-center gap-3">
                <label for="ubicacionRecepcionBuscar" style="font-size:14px;">Ubicación:</label>
                <select name="ubicacionRecepcionBuscar" id="ubicacionRecepcionBuscar" class="form-control">
                    <option value="_all_">--Seleccione--</option>
                    @isset($ubicaciones)
                        @foreach ($ubicaciones as $ubi)
                            <option value="{{$ubi['ubicacion_id']}}">{{$ubi['ubicacion']}}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
    </div>

        <section class="recepciones">
            @if(isset($habitaciones) && count($habitaciones) > 0)

                @include('data.load_recepciones_data')

            @else 
            
                <h4><center>No hay Habitaciones registradas</center></h4>

            @endif

        </div>
</div>

<!-- Modal Detalle -->
<div class="modal fade" id="ModalDetalleHabitacion" tabindex="-1" aria-labelledby="exampleModalLabel"
    data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header" style="background-color:#00368e !important; color:#fff !important;">
                <h5 class="modal-title" id="tituloModalHabitacion">Detalle Habitación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limpiarModalHabitaciónD()"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                <div class="row">
                    <div class="col-6">
                        <div class="mt-2" id="imagenHabitacionDetalle">

                        </div>

                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-xl-12 col-md-12">
                                <div class="form-group p-1">
                                    <label for="habitacionD"> Habitación: </label><br>
                                    <input type="text" class="form-control" id="habitacionD" name="habitacionD" readonly>
                                </div>
                            </div>

                            <div class="col-xl-12 col-md-12">
                                <div class="form-group p-1">
                                    <label for="txtNestudiante"> Detalles: </label><br>
                                    <textarea name="DetallesHD" id="DetallesHD" cols="50" rows="5" readonly></textarea>
                                </div>
                            </div>

                            <div class="col-xl-12 col-md-12">
                                <div class="form-group p-1">
                                    <label for="txtPrecio"> Precio: </label><br>
                                    <span id="txtPrecio" style="font-size:32px;font-weight:bold;"></span>
                                    <!-- <input type="text" class="form-control" id="txtPrecio" name="txtPrecio" readonly> -->
                                </div>
                            </div>
                            <!-- <div class="col-12 mt-2">
                                <h6 class="m-0 font-weight-bold mb-3">Tarifas de la Habitación</h6> 
                                <div class="TableHDetalle">
                                    <div class="table-responsive">
                                    <table class="table table-striped table-sm text-center align-middle" id="tableHDetails">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tarifa</th>
                                            <th>Precio</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div> -->
                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limpiarModalHabitaciónD()">Cerrar</button>
            </div>
        
        </div>
    </div>
</div>
<!-- Fin Modal Detalle -->

<!-- Modal Limpieza -->
<div class="modal fade" id="ModalLimpiezaHabitacion" tabindex="-1" aria-labelledby="exampleModalLabel"
    data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header" style="background-color:#00368e !important; color:#fff !important;">
                <h5 class="modal-title" id="tituloModalLimpiezaHabitacion">TERMINAR LA LIMPIEZA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limpiarModalHabitaciónL()"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                <div class="row">
                   
                    <div class="col-xl-12 col-md-12">
                        <div class="form-group p-1">
                            <label for="habitacionL"> Habitación: </label><br>
                            <input type="hidden" class="form-control" id="hddhabitacion_idL" name="hddhabitacion_idL" readonly>
                            <input type="text" class="form-control" id="habitacionL" name="habitacionL" readonly>
                        </div>
                    </div>

                    <div class="col-xl-12 col-md-12">
                        <div class="form-group p-1">
                            <label for="CategoriaL"> Categoría: </label><br>
                            <input type="text" class="form-control" id="CategoriaL" name="CategoriaL" readonly>
                        </div>
                    </div>

                    <div class="col-xl-12 col-md-12">
                        <div class="form-group p-1">
                            <label for="DetallesHL"> Detalles: </label><br>
                            <textarea name="DetallesHL" id="DetallesHL" class="form-control" cols="50" rows="5" readonly></textarea>
                        </div>
                    </div>
                   
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limpiarModalHabitaciónL()">Cerrar</button>
                <button type="button" class="btn btn-dark btnHabitacionLimpieza">Finalizar Limpieza</button>

            </div>
        
        </div>
    </div>
</div>
<!-- Fin Modal Limpieza -->




@endsection


@section('scripts')

    <script>

        $('#ubicacionRecepcionBuscar').on('change', function (e ){
            url=$('meta[name=app-url]').attr("content") + "/recepcion";
            $.ajax({
                url: url,
                method:'GET',
                data: {ubicacion: this.value}
            }).done(function (data) {
                $('.recepciones').html(data);
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        });

        function limpiarModalHabitaciónD()
        {
            $('#imagenHabitacionDetalle').html("");
            $('#habitacionD').val("");
            $('#DetallesHD').html("");
            $('#txtPrecio').html("");
            // $('#tableHDetails tbody').html("");
        }

        function limpiarModalHabitaciónL()
        {
            $('#habitacionL').val("");
            $('#CategoriaL').val("");
            $('#DetallesHL').val("");
        }

        function getDetalles(habitacion_id)
        {
            url=$('meta[name=app-url]').attr("content") + "/habitaciondetails/" +habitacion_id;
            $('#ModalDetalleHabitacion').modal('show');   
            $('#imagenHabitacionDetalle').html("");  
            // $('#tableHDetails tbody').html("");
            $.ajax({
                url: url,
                method:'GET'
            }).done(function (data) {
                $('#habitacionD').val(data.habitacion);
                $('#DetallesHD').html(data.detalles);
                if(data.imagen){
                    $("#imagenHabitacionDetalle").html(
                        `<img src="img/habitaciones/${data.imagen}" width="350" class="img-fluid img-thumbnail">`);
                }
                else 
                {
                    $("#imagenHabitacionDetalle").html(
                        `<img src="assets/images/bed.png" width="350" class="img-fluid img-thumbnail">`);
                }
                $('#txtPrecio').html(data.precio);
                 // Si la Habitación tiene tarifas registradas
                // let i = 1;
                // if(Object.keys(data.tarifas).length > 0)
                // {
                //     // Si tiene 
                //     $('#tableHDetails tbody').html("");
                //     Object.values(data.tarifas).forEach(val => {
                //     $('#tableHDetails tbody').append('<tr><td>'+i+'</td><td>'+ val.tarifa +' hrs</td><td>'+ val.precio +'</td></tr>')
                //     i++;
                //     });
                // }
                // else 
                // {
                //     // Si no tiene
                //     $('#tableHDetails tbody').append('<tr><td colspan="3"><h6 class="text-center text-secondary my-2">La Habitación no tiene Tarifas Registradas!</h6></td></tr>')
                // }
            }).fail(function () {
                console.log("Error al cargar los datos");
            });   
        };

        function terminarLimpieza(habitacion_id)
        {
            url=$('meta[name=app-url]').attr("content") + "/habitacionInfo/" +habitacion_id;
            $('#ModalLimpiezaHabitacion').modal('show');
            $.ajax({
                url: url,
                method:'GET'
            }).done(function (data) {
                $('#hddhabitacion_idL').val(data.habitacion_id);
                $('#habitacionL').val(data.habitacion);
                $('#CategoriaL').val(data.categoria);
                $('#DetallesHL').val(data.detalles);
            }).fail(function () {
                console.log("Error al cargar los datos");
            });   
        }

        $(document).on('click', '.btnHabitacionLimpieza', function(e) {
            let habid = $('#hddhabitacion_idL').val();
            Swal.fire({
                icon: 'warning',
                title: 'Está seguro de terminar la limpieza para la habitación?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: "#EB1010",
                confirmButtonText: `Aceptar`,
                cancelButtonText: `Cancelar`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = $('meta[name=app-url]').attr("content") +  "/habitaciones" +  "/disponible/" + habid;
                        let data = {
                            habitacion_id: habid
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
                                    Swal.fire({
                                    icon: 'success',
                                    title: 'ÉXITO!',
                                    text: 'Se ha finalizado la Limpieza Correctamente',
                                    showCancelButton: false,
                                    allowOutsideClick: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
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
        });

    </script>

@endsection