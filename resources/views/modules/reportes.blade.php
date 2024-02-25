@extends('master')

@section('content')

<!-- Encabezado principal de la aplicación -->
<div class="app-hero-header d-flex justify-content-between">
    <!-- Título -->
    <h3 class="fw-light mb-5">
        <b><span>Reporte Recepción</span></b>
    </h3>

    <!-- Navegación de migas de pan -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-file-invoice"></i> Reportes
            </li>
        </ol>
    </nav>
</div>
<!-- Fin del encabezado principal -->

<!-- Cuerpo de la aplicación -->
<div class="app-body" style="margin-top: -8.5rem !important; height: calc(103vh - 202px);">
    <div class="row">
        <!-- Selector de fecha Desde -->
        <div class="col-xl-6 col-md-6 col-sm-12 px-5 mt-2">
            <div class="form-group">
                <label for="fechaDesde" style="font-size: 14px;">Desde:</label>
                <input type="date" class="form-control" name="fechaDesde" id="fechaDesde" max="{{ \Carbon\Carbon::now('America/Guayaquil')->format('Y-m-d') }}" value="{{ \Carbon\Carbon::now('America/Guayaquil')->format('Y-m-d') }}">
            </div>
        </div>

        <!-- Selector de fecha Hasta -->
        <div class="col-xl-6 col-md-6 col-sm-12 px-5 mt-2">
            <div class="form-group">
                <label for="fechaHasta" style="font-size: 14px;">Hasta:</label>
                <input type="date" class="form-control" name="fechaHasta" id="fechaHasta" max="{{ \Carbon\Carbon::now('America/Guayaquil')->format('Y-m-d') }}" value="{{ \Carbon\Carbon::now('America/Guayaquil')->format('Y-m-d') }}">
            </div>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="row mt-4">
        <div class="col-xl-12 d-flex justify-content-center">
            <div class="form-group">
                <!-- Botón para la vista previa -->
                <button type="button" id="btnPreviewReporte" class="btn btn-info btn-fw">
                    <i class="fas fa-search"></i> Buscar Registros
                </button>

                <!-- Botón para exportar a PDF -->
                <button type="button" id="btnExportarPDF" class="btn btn-dark btn-fw" disabled>
                    <i class="fas fa-file-pdf" ></i> Exportar PDF
                </button>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <!-- Sección para el reporte -->
                    <section class="tblreporte">
                    </section>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Fin del cuerpo de la aplicación -->

@endsection

@section('scripts')
<script> 

    $(function () {
        // Evento click para la vista previa del reporte
        $('#btnPreviewReporte').click(function (event) {
            event.preventDefault();
            let fdesde = $('#fechaDesde').val();
            let fhasta = $('#fechaHasta').val();
            let url = $('meta[name=app-url]').attr("content") + "/reportes/vista_previa";
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    fdesde: fdesde,
                    fhasta: fhasta,
                },
            }).done(function (response) {
                // Manejo de respuesta
                if (response.code == "422") {
                    let errors = response.errors;
                    let reporteValidation = '';
                    $.each(errors, function (index, value) {
                        if (typeof value !== 'undefined' || typeof value !== "") {
                            reporteValidation += '<li>' + value + '</li>';
                        }
                    });
                    // Mostrar errores de validación
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        html: '<ul>' +
                            reporteValidation +
                            '</ul>'
                    });
                } else if (response.code == "423") {
                    // Error si Fecha Desde es mayor que Fecha Hasta
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'La Fecha Desde no debe ser Mayor que la Fecha Hasta!'
                    })
                } else {
                    // Mostrar vista previa del reporte
                    $('.tblreporte').html(response);
                }
                // Activar el botón de "Exportar PDF"
                $('#btnExportarPDF').prop('disabled', false);
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        });

        // Evento click para exportar a PDF
        $(document).on('click', '#btnExportarPDF', function (e) {
            event.preventDefault();
            let fechaD = $('#fechaDesde').val();
            let fechaH = $('#fechaHasta').val();

            if (fechaD == "") {
                // Validación de Fecha Desde requerida
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR!',
                    text: 'La Fecha Desde es requerida'
                });
            } else if (fechaH == "") {
                // Validación de Fecha Hasta requerida
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR!',
                    text: 'La Fecha Hasta es requerida'
                });
            } else {
                if (fechaD > fechaH) {
                    // Validación de rango de fechas
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR!',
                        text: 'La Fecha Desde no debe ser mayor que la Fecha Hasta'
                    });
                } else {
                    // Generar URL para exportar a PDF
                    var url = "{{ route('reportePDF', ['fdesde' => 'fechaD','fhasta' => 'fechaH']) }}";
                    url = url.replace('fechaD', fechaD);
                    url = url.replace('fechaH', fechaH);
                    url = url.replace('&amp;', '&');
                    // Abrir en una nueva ventana
                    window.open(url, '_blank');
                }
            }
        });
    });
</script>
@endsection
