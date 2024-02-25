@extends('master')

@section('content')

<!-- App hero header starts -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <b><span>RECEPCION SALIDA</span></b>
    </h3>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/recepcion') }}"><i
                        class="fa-solid fa-right-from-bracket"></i>Recepción</a></li>
            <li class="breadcrumb-item active" aria-current="page">Procesar</li>
        </ol>
    </nav>

</div>
<!-- App Hero header ends -->
<div class="app-body" style="margin-top:-8.5rem !important;height: calc(103vh - 210px);">
    <div class="row">
        <div class="col-md-4 col-12 mb-3">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title">Datos de la Habitación</h5>
                </div>
                <div class="card-body">
                    <div class="card-text">
                        <div class="row">
                            <div class="col-12 py-2"><b>Habitación:</b> &nbsp; &nbsp;
                                &nbsp;{{$dataRecepcion->habitacion}}</div>
                            <div class="col-12 py-2"><b>Categoría:</b> &nbsp; &nbsp; &nbsp;{{$dataRecepcion->categoria}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12 mb-3">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title">Datos del cliente</h5>
                </div>
                <div class="card-body">
                    <div class="card-text">
                        <div class="row">
                            <div class="col-12 py-2"><b>Nombre Cliente:</b> &nbsp; &nbsp;
                                &nbsp;{{$dataRecepcion->cliente}}</div>
                            <div class="col-12 py-2"><b>Email Cliente:</b> &nbsp; &nbsp; &nbsp;{{$dataRecepcion->email}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12 mb-3">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title">Ingreso y Salida</h5>
                </div>
                <div class="card-body">
                    <div class="card-text">
                        <div class="row">
                            <div class="col-12 py-2"><b>Fecha y Hora de Entrada :</b>&nbsp; &nbsp;
                                &nbsp;{{$dataRecepcion->fecha_entrada}} </div>
                            <div class="col-12 py-2"><b>Fecha y Hora de Salida :</b>&nbsp; &nbsp;
                                &nbsp;{{$dataRecepcion->fecha_salida}} </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <form method="POST" action="{{ url('recepcion/generar_comprobante') }}" id="formGenerar">
                @csrf
                <div class="table-responsive">
                    <input type="hidden" name="hddproceso_id" id="hddproceso_id" value="{{$dataRecepcion->proceso_id}}">
                    <input type="hidden" name="hddestado_pago" id="hddestado_pago"
                        value="{{$dataRecepcion->estado_pago}}"></td>
                    <table class="table table-bordered align-middle table-hover m-0" border="2">
                        <thead>
                            <tr>
                                <th style="background-color:#9098A2;">#</th>
                                <th colspan="5" style="background-color:#9098A2;">Costo de Alojamiento</th>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>Costo de Habitación</th>
                                <th>Cantidad de Noches</th>
                                <th>Cantidad de Personas</th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <tr>
                                <td>1</td>
                                <td>{{$dataRecepcion->precio}}</td>
                                <td>{{$dataRecepcion->cant_noches}}</td>
                                <td>{{$dataRecepcion->cant_personas}}</td>
                                <td colspan="2"><input type="number" name="total" id="total" class="form-control"
                                        readonly value="{{$dataRecepcion->total}}"></td>
                            </tr>
                            <tr>
                                <td align="center" colspan="3"><b>Observaciones</b></td>
                                <td colspan="3">{{$dataRecepcion->observaciones}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="background-color:#9098A2;" align="center" colspan="5">
                                    <p style="font-size:18px;"><b>TOTAL</b></p>
                                </td>
                                <td style="font-size:18px;" align="center">{{$dataRecepcion->total}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <div>
                        <div>
                            <a class="btn btn-danger btn-icon-split" href="{{ url('/recepcion') }}">
                                <span class="icon text-white-50"><i class="fas fa-times fa-lg"></i></span>
                                <span class="text">Cancelar</span>
                            </a>
                            <button type="submit" class="btn btn-success btn-fw" id="btnGenerar">
                                <span class="icon text-white-50"><i class="fas fa-print fa-lg"></i></span>
                                <span class="text">Generar Comprobante</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @endsection

    @section('scripts')
    <script>
        $('#cbotipopago').on('change', function () {
            let cbotipopago = $(this).val();
            if (cbotipopago == 1) {
                $('#nrooperacionfinal').css("display", "none");
            }
            else {
                $('#nrooperacionfinal').css("display", "block");
            }
        });

        $('#btnGenerar').click(function (event) {
            event.preventDefault();
            let hddproceso_id = $('#hddproceso_id').val();
            $(this).prop('disable', true);
            if (hddproceso_id != "") {
                let url = $('meta[name=app-url]').attr("content") + "/recepcion/generar_comprobante";
                let formData = new FormData($("#formGenerar")[0]);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $(this).prop('disable', false);
                        console.log(response);
                        if (response.code == "200") {
                            window.location = response.url;

                        }
                        else if (response.code == "421") {
                            Swal.fire({
                                icon: 'error',
                                title: 'ERROR...',
                                text: 'Debe seleccionar un tipo de pago!'
                            })
                        }
                        else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ERROR...',
                                text: 'Se ha producido un error al intentar generar el comprobante!'
                            })
                        }
                    },
                    error: function (response) {
                        $(this).prop('disable', false);

                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            text: 'Se ha producido un error al intentar generar el comprobante!'
                        })
                    }
                });
            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR...',
                    text: 'Se ha producido un error al intentar generar el comprobante!'
                })
            }
        });
    </script>

    @endsection