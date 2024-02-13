@extends('master')

@section('content')

    @php $proceso_id = $dataFactura->proceso_id @endphp
    <!-- App hero header starts -->
    <div class="app-hero-header d-flex justify-content-between">
        <h3 class="fw-light mb-5">
            <!-- <b><span>Imprimir Comprobante</span></b> -->
        </h3>
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/recepcion') }}"><i class="fa-solid fa-right-from-bracket"></i> Recepción</a></li>
                <li class="breadcrumb-item active" aria-current="page">Comprobante</li>
            </ol>
        </nav>

    </div>
    <!-- App Hero header ends -->

    <div class="app-body"style="margin-top:-8.5rem !important;height: calc(103vh - 210px);">

        <div class="row">
            <div class="col-12 mb-3">
                <div class="card shadow">
                  
                    <div class="card-body">
                        <div class="card-text">
                            <div class="row">
                                <div class="col-lg-10 col-md-9 col-12 py-2">
                                    <span style="font-size:30px;"><b>Imprimir Comprobante</b></span>
                                </div>
                                <div class="col-lg 2 col-md-3 col-12 py-2">
                                    <div>
                                        <a class="btn btn-secondary btn-lg btn-icon-split" href="{{ url('/recepcion') }}" style="border-radius:120px" title="Volver a Recepción"> <span class="icon text-white-50"><img src="{{ url('assets/images/cancel.png') }}" width="24px"></span></a>
                                        <a href="{{ route('comprobante_pdf', ['proceso_id' => $proceso_id]) }}" target="_blank" class="btn btn-success btn-lg btn-fw btn-gray" id="btnImprimir" style="border-radius:120px" title="Imprimir Comprobante"><span class="icon text-white-50"><img src="{{ url('assets/images/print.png') }}" width="24px"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">

            <div class="col-12 mb-3">

                <div class="card shadow">

                    <div class="card-body">
                        <div class="card-text">
                            <div class="row">
                                <?php 
                                    $fecha_ingreso = date('d-m-Y h:i:s', strtotime($dataFactura->fecha_entrada));
                                    $fecha_salida = date('M', strtotime($dataFactura->fecha_entrada));
                                ?>
                                <div class="col-lg-4 col-md-7 col-12 py-2">
                                    <h6>DETALLES:</h6>
                                    <p>COMPROBANTE SALIDA RECEPCIÓN</p>
                                    <p>Fecha de Ingreso: {{$diaIngreso}} de {{$mesIngresoEspañol}} del {{$añoIngreso}} a las <?php echo date('h:i:s', strtotime($dataFactura->fecha_entrada)); ?></p>
                                    <p>Fecha de Salida: {{$diaSalida}} de {{$mesSalidaEspañol}} del {{$añoSalida}} a las <?php echo date('h:i:s', strtotime($dataFactura->fecha_salida)); ?></p>

                                </div>
                                <div class="col-lg 4 col-md-5 col-12 py-2">
                                    <h6>DATOS DE LA EMPRESA:</h6>
                                    <p>HOTEL: {{$nombreHotel->valor}}</p>
                                    <p>RUC: {{$rucHotel->valor}}</p>
                                    <p>DIRECCION: {{$direccionHotel->valor}}</p>
                                    <p>TELEFONO: {{$telHotel->valor}}</p>
                                    <p>EMAIL: {{$emailHotel->valor}}</p>
                                </div>
                                <div class="col-lg 4 col-md-5 col-12 py-2">
                                    <h6>CLIENTE:</h6>

                                    {{-- <p>Razón Social: {{$dataFactura->razon_social}}</p> --}}

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
                            <table class="table align-middle table-hover m-0">
                                <thead>
                                    <tr>
                                        <th style="background-color:#9098A2;">#</th>
                                        <th colspan="3" style="background-color:#9098A2;">Costo de Alojamiento</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">CANT.</th>
                                        <th scope="col">DESCRIPCION</th>
                                        <th scope="col">P.UNITARIO</th>
                                        <th scope="col">IMPORTE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
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
                                        <td style="background-color:#9098A2;" align="center" colspan="1"><p style="font-size:14px; margin-bottom:1px;"><b>TOTAL</b></p> </td>
                                        <td align="center">$ <?php echo round($dataFactura->total,2) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- <div class="row mt-3">

            <div class="col-12">
                <div class="row">

                    <div class="col-md-9 col-12"></div>
                    <div class="col-md-3 col-12">
                        <div class="card shadow">

                            <div class="card-body p-5">

                                @php $subtotal = $dataFactura->total / 1.12 @endphp
                                @php $iva = $dataFactura->total - $subtotal; @endphp
                                <p style="font-size:18px;"><b>Sub Total:</b> <?php echo round($subtotal,2) ?></p><br>
                                <p style="font-size:18px;"><b>IVA:</b> <?php echo round($iva,2) ?></p><br>
                                <p style="font-size:18px;"><b>Total:</b> <?php echo round($dataFactura->total,2) ?></p><br>
                                
                            </div>

                        </div>
                      
                    </div>
                   
                </div>
            </div>

        </div> -->

    </div>

@endsection

@section('scripts')

    <script>

  
    </script>

@endsection
