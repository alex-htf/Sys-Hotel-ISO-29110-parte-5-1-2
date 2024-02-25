@extends('master')

@section('content')

@php 
// Asigna el valor de 'proceso_id' desde la variable $dataFactura
    $proceso_id = $dataFactura->proceso_id; 
@endphp

<!-- Encabezado de la aplicación -->
<div class="app-hero-header d-flex justify-content-between"> 
    <!-- Breadcrumb para navegación -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <!-- Enlaces de navegación -->
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/recepcion') }}"><i class="fa-solid fa-right-from-bracket"></i>Recepción</a></li>
            <li class="breadcrumb-item active" aria-current="page">Comprobante</li>
        </ol>
    </nav>
</div>
<!-- App Hero header ends -->
<!-- Cuerpo de la aplicación -->
<div class="app-body" style="margin-top:-8.5rem !important;height: calc(103vh - 210px);"> 

<div class="row align-items-center">
    <div class="col-lg-9 col-md-8 col-12 mb-3">
        <div class="card shadow">
            <div class="card-body">
                <div class="card-text">
                    <span style="font-size:24px;"><b>Imprimir Comprobante</b></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-12 mb-3">
        <div class="d-flex justify-content-end">
            <!-- Botón para volver a la página de recepción -->
            <a class="btn btn-secondary btn-lg btn-icon-split" href="{{ url('/recepcion') }}" title="Volver a Recepción">
                <span class="icon text-white-50"><i class="fas fa-times"></i></span> <!-- Ícono para volver -->
                <span class="text">Volver a Recepción</span> <!-- Leyenda del botón -->
            </a>
            <!-- Botón para imprimir el comprobante en formato PDF -->
            <a href="{{ route('comprobante_pdf', ['proceso_id' => $proceso_id]) }}" target="_blank"
                class="btn btn-success btn-lg btn-fw btn-gray ms-3" id="btnImprimir" title="Imprimir Comprobante">
                <span class="icon text-white-50"><i class="fas fa-print"></i></span> <!-- Ícono para imprimir -->
                <span class="text">Imprimir</span> <!-- Leyenda del botón -->
            </a>
        </div>
    </div>
</div>



    <div class="row mt-3">
        <div class="col-12 mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <div class="card-text">
                        <div class="row">
                            <!-- Detalles del comprobante -->
                            <?php 
                                // Conversión de fechas y detalles del comprobante
                                $fecha_ingreso = date('d-m-Y h:i:s', strtotime($dataFactura->fecha_entrada));
                                $fecha_salida = date('M', strtotime($dataFactura->fecha_entrada));
                            ?>
                            <div class="col-lg-4 col-md-7 col-12 py-2">
                                <!-- Sección de detalles del comprobante -->
                                <h6>DETALLES:</h6>
                                <!-- Detalles específicos del comprobante -->
                                <p>COMPROBANTE SALIDA RECEPCIÓN</p>
                                <p>Fecha de Ingreso: {{$diaIngreso}} de {{$mesIngresoEspañol}} del {{$añoIngreso}} a las
                                    <?php echo date('h:i:s', strtotime($dataFactura->fecha_entrada)); ?>
                                </p>
                                <p>Fecha de Salida: {{$diaSalida}} de {{$mesSalidaEspañol}} del {{$añoSalida}} a las
                                    <?php echo date('h:i:s', strtotime($dataFactura->fecha_salida)); ?>
                                </p>
                            </div>
                            <!-- Datos de la empresa -->
                            <div class="col-lg-4 col-md-5 col-12 py-2">
                                <h6>DATOS DE LA EMPRESA:</h6>
                                <!-- Detalles de la empresa (nombre, RUC, dirección, teléfono, email) -->
                                <p>HOTEL: {{$nombreHotel->valor}}</p>
                                <p>RUC: {{$rucHotel->valor}}</p>
                                <p>DIRECCION: {{$direccionHotel->valor}}</p>
                                <p>TELEFONO: {{$telHotel->valor}}</p>
                                <p>EMAIL: {{$emailHotel->valor}}</p>
                            </div>
                            <!-- Detalles del cliente -->
                            <div class="col-lg-4 col-md-5 col-12 py-2">
                                <h6>CLIENTE:</h6>
                                <!-- Detalles del cliente (nombre, documento, dirección, teléfono) -->
                                <p>Nombre: {{$dataFactura->cliente}}</p>
                                <p>Documento: {{$dataFactura->tipo}} - {{$dataFactura->documento}}</p>
                                <p>Direccion: {{$dataFactura->direccion}}</p>
                                <p>Teléfono: {{$dataFactura->telefono}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- Tabla de costos de alojamiento -->
                        <table class="table align-middle table-hover m-0">
                            <thead>
                                <tr>
                                    <th style="background-color:#9098A2;">#</th>
                                    <th colspan="3" style="background-color:#9098A2;">Costo de Alojamiento</th>
                                </tr>
                                <tr>
                                    <!-- Encabezados de la tabla -->
                                    <th scope="col">CANT.</th>
                                    <th scope="col">DESCRIPCION</th>
                                    <th scope="col">P.UNITARIO</th>
                                    <th scope="col">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- Detalles de costos de alojamiento -->
                                    <td align="center">1</td>
                                    <td align="center">Alojamiento de la habitación {{$dataFactura->habitacion}}</td>
                                    <td align="center">$ {{$dataFactura->total}}</td>
                                    <td align="center">$ {{$dataFactura->total}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table align-middle table-hover m-0">
                            <tbody>
                                <tr>
                                    <td style="background-color:#9098A2;" align="center" colspan="1">
                                        <p style="font-size:14px; margin-bottom:1px;"><b>TOTAL</b></p>
                                    </td>
                                    <!-- Cálculo del total -->
                                    <td align="center">$
                                        <?php echo round($dataFactura->total,2) ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
</script>
@endsection 
