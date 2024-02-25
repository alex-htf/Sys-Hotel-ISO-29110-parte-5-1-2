@extends('master')

@section('content')

<!-- App hero header starts -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <b><span>PROCESAR RECEPCIÓN</span></b>
    </h3>

    <!-- Breadcrumbs para la navegación -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/recepcion') }}"><i class="fa-solid fa-right-from-bracket"></i>Recepción</a></li>
            <li class="breadcrumb-item active" aria-current="page">Procesar</li>
        </ol>
    </nav>
</div>

<div class="app-body" style="margin-top:-8.5rem !important;height: calc(103vh - 202px);">
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title">Datos de la Habitación</h5>
            </div>
            <div class="card-body">
                <div class="card-text">
                    <div class="row">
                        <div class="col-md-6 col-12 py-2"><b>Nombre:</b> &nbsp; &nbsp;
                            &nbsp;{{$dataHabitacion->habitacion}}</div>
                        <div class="col-md-6 col-12 py-2"><b>Categoría:</b> &nbsp; &nbsp;
                            &nbsp;{{$dataHabitacion->categoria}}</div>
                        <div class="col-md-6 col-12 py-2"><b>Detalles:</b> &nbsp; &nbsp;
                            &nbsp;{{$dataHabitacion->detalles}}</div>
                        <div class="col-md-6 col-12 py-2"><b>Estado:</b>&nbsp; &nbsp; &nbsp;
                            @if($dataHabitacion->estado == 1) 
                                <label class="badge bg-success">Disponible</label>
                            @elseif($dataHabitacion->estado == 2) 
                                <label class="badge bg-danger">Ocupado</label>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulario para procesar la recepción -->
<form action="#" id="formProceso" method="POST">
    <div class="row">
        <!-- Datos del cliente -->
        <div class="col-md-6 col-12 mt-4">
            <h5 class="text-center">Datos del Cliente</h5>
            <div class="card shadow">
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Selección del tipo de documento -->
                        <div class="col-12">
                            <div class="input-group">
                                <span class="input-group-text">Tipo Documento:</span>
                                <input type="hidden" name="hddhabitacion_id" id="hddhabitacion_id" value="{{$habitacionid}}">
                                <select name="tipo_documento" id="tipo_documento" class="form-control">
                                    <option value="">--SELECCIONE--</option>
                                    <!-- Opciones de tipos de documentos -->
                                    @if(isset($tipodocs) && count($tipodocs) > 0)
                                    @foreach($tipodocs as $td)
                                    <option value="{{$td->tipo_documento_id}}">{{$td->tipo}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <!-- Ingreso del número de documento -->
                        <div class="col-12 mt-3">
                            <div class="input-group">
                                <span class="input-group-text">Nro Documento:</span>
                                <input type="text" class="form-control" id="num_doc" name="num_doc" placeholder="Número del Documento">
                                <!-- Botón para buscar el cliente -->
                                <button class="btn btn-dark" id="btnsearchCliente"><i class="fas fa-search"></i></button>
                            </div>
                        </div>

                        <!-- Campos para mostrar los datos del cliente -->
                        <div class="col-12 mt-3">
                            <div class="input-group">
                                <span class="input-group-text">Nombres:</span>
                                <input type="text" class="form-control" id="nomCliente" name="nomCliente" placeholder="Nombres del Cliente" readonly>
                            </div>
                        </div>
                        <!-- Dirección del cliente -->
                        <div class="col-12">
                            <div class="input-group mt-3">
                                <span class="input-group-text">Dirección:</span>
                                <input type="text" class="form-control" id="direCliente" name="direCliente" placeholder="Dirección del Cliente" readonly>
                            </div>
                        </div>
                        <!-- Teléfono del cliente -->
                        <div class="col-12">
                            <div class="input-group mt-3">
                                <span class="input-group-text">Teléfono:</span>
                                <input type="text" class="form-control" id="telCliente" name="telCliente" placeholder="Teléfono del Cliente" readonly>
                            </div>
                        </div>
                        <!-- Email del cliente -->
                        <div class="col-12">
                            <div class="input-group mt-3">
                                <span class="input-group-text">Email:</span>
                                <input type="text" class="form-control" id="emailCliente" name="emailCliente" placeholder="Email del Cliente" readonly>
                            </div>
                        </div>
                        <!-- Observaciones sobre el cliente -->
                        <div class="col-12">
                            <div class=" mt-3">
                                <label>Observaciones:</label>
                                <textarea name="observacionesCliente" id="observacionesCliente" cols="30" class="form-control" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Datos del alojamiento -->
        <div class="col-md-6 col-12 mt-4">
            <h5 class="text-center">Datos del Alojamiento</h5>
            <div class="card shadow">
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Precio -->
                        <div class="tarifaDIV mt-4 col-12">
                            <div class="row">
                                <!-- Precio por noche -->
                                <div class="col-md-6 col-12">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-regular fa-money-bill-1"></i>&nbsp;Precio:</span>
                                        <input type="number" id="pricetarifa" name="pricetarifa" class="form-control" value="{{$dataHabitacion->precio}}" readonly>
                                        <input type="hidden" id="hddpricet" name="hddpricet" value="{{$dataHabitacion->precio}}">
                                    </div>
                                </div>
                                <!-- Cantidad de noches -->
                                <div class="col-md-6 col-12">
                                    <div class="input-group">
                                        <span class="input-group-text">Cantidad de Noches:</span>
                                        <input type="number" class="form-control" id="cantidadnoches" name="cantidadnoches" value="1" min="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Cantidad de personas -->
                        <div class="col-12 mt-4">
                            <div class="input-group">
                                <span class="input-group-text">Cantidad de Personas:</span>
                                <input type="number" id="cantidadpersonas" name="cantidadpersonas" class="form-control" value="1" min="1">
                            </div>
                        </div>
                        <!-- Fecha de salida -->
                        <div class="col-md-7 col-12 mt-4">
                            <div class="input-group">
                                <span class="input-group-text">Fecha de salida:</span>
                                <input type="date" class="form-control" name="fechaSalida" min="{{ \Carbon\Carbon::now('America/Guayaquil')->format('Y-m-d') }}" value="{{ \Carbon\Carbon::now('America/Guayaquil')->format('Y-m-d') }}">
                            </div>
                        </div>
                        <!-- Hora de salida -->
                        <div class="col-md-5 col-12 mt-4">
                            <div class="input-group">
                                <span class="input-group-text">Hora de salida:</span>
                                <input type="time" class="form-control" name="horasalida" min="{{ \Carbon\Carbon::now('America/Guayaquil')->format('H:i') }}" value="{{ \Carbon\Carbon::now('America/Guayaquil')->format('H:i') }}">
                            </div>
                        </div>
                        <!-- Total a pagar -->
                        <div class="col-12 mt-4 ">
                            <div class="input-group d-flex align-items-center">
                                <h4>TOTAL A PAGAR:</h4>&nbsp;&nbsp;
                                <span id="lblTotal" style="font-size: 2.35rem; font-weight:bold; padding-bottom:12px;" class="px-2">{{$dataHabitacion->precio}}</span>
                                <input type="hidden" name="totalpricef" id="totalpricef" value="{{$dataHabitacion->precio}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Botones de acción -->
            <div class="mt-4">
                <div class="form-group">
                    <!-- Botón para cancelar el proceso -->
                    <a class="btn btn-danger btn-icon-split" href="{{ url('/recepcion') }}"> <span class="icon text-white-50">
                        <img src="{{ url('assets/images/cancel.png') }}" width="24px"></span><span class="text">Cancelar</span></a>
                    <!-- Botón para registrar el ingreso del cliente -->
                    @if($dataHabitacion->estado == 1)
                    <button type="submit" class="btn btn-success btn-fw" id="guardarProceso" disabled><span class="icon text-white-50">
                        <img src="{{ url('assets/images/save.png') }}" width="24px"></span><span class="text">Registrar Ingreso</span></button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>
</div>

@endsection

@section('scripts')

<!-- Scripts para la funcionalidad de la página -->
<script>
// Función para buscar cliente al hacer clic en el botón
$('#btnsearchCliente').click(function (event) {
    event.preventDefault();
    let tipodoc = $('#tipo_documento').val();
    let numdoc = $('#num_doc').val();
    if (tipodoc == "") {
        // Mostrar mensaje de error si no se selecciona el tipo de documento
        Swal.fire({
            icon: 'error',
            title: 'ERROR...',
            text: 'Debe seleccionar el tipo de documento!'
        });
    }
    else {
        // Realizar la búsqueda del cliente
        let url = $('meta[name=app-url]').attr("content") + "/search_cliente/";
        $.ajax({
            url: url,
            method: 'GET',
            data: {
                tipodoc: tipodoc,
                numdoc: numdoc,
            },
        }).done(function (response) {
            $("#guardarProceso").prop("disabled", false);
            if ($.isEmptyObject(response)) {
                // Si el cliente no está registrado, mostrar mensaje de error
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR...',
                    text: 'El Cliente no está registrado!'
                })
                // Limpiar campos de datos del cliente
                $('#nomCliente').val("");
                $("#nomCliente").prop('readonly', false);
                $('#razonsocialCiente').val("");
                $("#razonsocialCiente").prop('readonly', false);
                $('#direCliente').val("");
                $("#direCliente").prop('readonly', false);
                $('#telCliente').val("");
                $("#telCliente").prop('readonly', false);
                $('#emailCliente').val("");
                $("#emailCliente").prop('readonly', false);
                $('#observacionesCliente').val("");
            }
            else {
                // Mostrar los datos del cliente encontrado
                $('#nomCliente').val(response.nombre);
                $('#razonsocialCiente').val(response.razon_social);
                $('#direCliente').val(response.direccion);
                $('#telCliente').val(response.telefono);
                $('#emailCliente').val(response.email);
                $('#observacionesCliente').val(response.observaciones);
            }
        }).fail(function () {
            console.log("Error al cargar los datos");
        });
    }
});

// Función para calcular el total a pagar según la cantidad de noches
$("#cantidadnoches").bind('keyup mouseup', function () {
    let cantnoches = $(this).val();
    let cantper = $('#cantidadpersonas').val();
    let hddpriceval = $('#hddpricet').val();
    if (cantnoches != "" && cantnoches > 0) {
        let price = $('#pricetarifa').val();
        let totalpagar = cantnoches * price;
        let totalpagar2 = totalpagar * cantper;
        $('#lblTotal').html(totalpagar2);
    }
    else {
        $('#lblTotal').html(hddpriceval);
    }
});

// Función para calcular el total a pagar según la cantidad de personas
$("#cantidadpersonas").bind('keyup mouseup', function () {
    let cantpersonas = $(this).val();
    let price2 = $('#hddpricet').val();
    let cantnoches2 = $('#cantidadnoches').val();
    if (cantpersonas > 0 && cantpersonas != "") {
        if (price2 != '') {
            let sutotal = price2 * cantnoches2;
            let totalf = sutotal * cantpersonas;
            $('#lblTotal').html(totalf);
        }
    }
    else {
        $('#lblTotal').html(price2);
    }
});

// Función para enviar el formulario de proceso
$("#formProceso").submit(function (e) {
    event.preventDefault();
    $("#guardarProceso").prop('disabled', true);
    $("#guardarProceso").text('Registrando...');
    let url = $('meta[name=app-url]').attr("content") + "/recepcion";
    let data = new FormData($("#formProceso")[0]);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        type: "POST",
        data: data,
        processData: false,
        contentType: false,
        success: function (response) {
            $("#guardarProceso").prop('disabled', false);
            $("#guardarProceso").text('Registrar Ingreso');
            if (response.code == "200") {
                // Si se registra correctamente, mostrar mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: 'ÉXITO!',
                    text: 'Se ha registrado la información correctamente',
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
            else if (response.code == "422") {
                // Si hay errores de validación, mostrar mensaje de error con detalles
                let errors = response.errors;
                let procesoValidation = '';
                $.each(errors, function (index, value) {
                    if (typeof value !== 'undefined' || typeof value !== "") {
                        procesoValidation += '<li>' + value + '</li>';
                    }
                });
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR...',
                    html: '<ul>' + procesoValidation + '</ul>'
                });
            }
        },
        error: function (response) {
            // Si hay un error en la solicitud, mostrar mensaje de error
            $("#guardarProceso").prop('disabled', false);
            Swal.fire({
                icon: 'error',
                title: 'ERROR...',
                text: 'Se ha producido un error al intentar guardar el registro!'
            });
        }
    });
});

</script>
@endsection
