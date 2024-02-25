@extends('master')

@section('content')

<!-- Encabezado de la aplicación -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <b><span>VISTA GENERAL DE RECEPCIÓN</span></b>
    </h3>

    <!-- Breadcrumb de navegación -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i>Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i
                    class="fa-solid fa-right-from-bracket"></i>Recepción</li>
        </ol>
    </nav>
</div>

<div class="app-body" style="margin-top:-8.5rem !important;height: calc(103vh - 202px);">
    <div class="row mb-3">
        <div class="col-lg-4 col-md-6 col-6">
            <div class="form-group d-flex align-items-center gap-3">
                <label for="ubicacionRecepcionBuscar" style="font-size:14px;">Ubicación:</label>
                <!-- Selector de ubicación -->
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

    <!-- Sección de recepciones -->
    <section class="recepciones">
        @if(isset($habitaciones) && count($habitaciones) > 0)
        <!-- Incluye datos de las recepciones -->
        @include('data.load_recepciones_data')
        @else
        <h4>
            <center>No hay Habitaciones registradas</center>
        </h4>
        @endif
    </section>
</div>
</div>

<<!-- Modal Detalle -->
<div class="modal fade" id="ModalDetalleHabitacion" tabindex="-1" aria-labelledby="exampleModalLabel"
    data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#00368e !important; color:#fff !important;">
                <h5 class="modal-title" id="tituloModalHabitacion">Detalle Habitación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    onclick="limpiarModalHabitaciónD()"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="row">
                    <div class="col-6">
                        <div class="mt-2" id="imagenHabitacionDetalle"></div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-xl-12 col-md-12">
                                <div class="form-group p-1">
                                    <label for="habitacionD"> Habitación: </label><br>
                                    <input type="text" class="form-control" id="habitacionD" name="habitacionD"
                                        readonly>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    onclick="limpiarModalHabitaciónD()">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Función para cargar las recepciones según la ubicación seleccionada
    $('#ubicacionRecepcionBuscar').on('change', function (e) {
        url = $('meta[name=app-url]').attr("content") + "/recepcion";
        $.ajax({
            url: url,
            method: 'GET',
            data: { ubicacion: this.value }
        }).done(function (data) {
            $('.recepciones').html(data);
        }).fail(function () {
            console.log("Error al cargar los datos");
        });
    });

    // Función para limpiar el contenido del modal de detalle
    function limpiarModalHabitaciónD() {
        $('#imagenHabitacionDetalle').html("");
        $('#habitacionD').val("");
        $('#DetallesHD').html("");
        $('#txtPrecio').html("");
    }

    // Función para obtener los detalles de una habitación
    function getDetalles(habitacion_id) {
        url = $('meta[name=app-url]').attr("content") + "/habitaciondetails/" + habitacion_id;
        $('#ModalDetalleHabitacion').modal('show');
        $('#imagenHabitacionDetalle').html("");
        $.ajax({
            url: url,
            method: 'GET'
        }).done(function (data) {
            $('#habitacionD').val(data.habitacion);
            $('#DetallesHD').html(data.detalles);
            if (data.imagen) {
                $("#imagenHabitacionDetalle").html(`<img src="img/habitaciones/${data.imagen}" width="350" class="img-fluid img-thumbnail">`);
            }
            else {
                $("#imagenHabitacionDetalle").html(`<img src="assets/images/bed.png" width="350" class="img-fluid img-thumbnail">`);
            }
            $('#txtPrecio').html(data.precio);

        }).fail(function () {
            console.log("Error al cargar los datos");
        });
    };
</script>
@endsection
