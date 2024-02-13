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
                <li class="breadcrumb-item"><a href="{{ url('/recepcion') }}"><i class="fa-solid fa-right-from-bracket"></i> Recepción</a></li>
                <li class="breadcrumb-item active" aria-current="page">Procesar</li>
            </ol>
        </nav>

    </div>
    <!-- App Hero header ends -->
    <div class="app-body"style="margin-top:-8.5rem !important;height: calc(103vh - 210px);">

        <div class="row">

            <div class="col-md-4 col-12 mb-3">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="card-title">Datos de la Habitación</h5>
                    </div>
                    <div class="card-body">
                        <div class="card-text">
                            <div class="row">
                                    <div class="col-12 py-2"><b>Habitación:</b> &nbsp; &nbsp; &nbsp;{{$dataRecepcion->habitacion}}</div>
                                    <div class="col-12 py-2"><b>Categoría:</b> &nbsp; &nbsp; &nbsp;{{$dataRecepcion->categoria}}</div>
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
                                <div class="col-12 py-2"><b>Nombre Cliente:</b> &nbsp; &nbsp; &nbsp;{{$dataRecepcion->cliente}}</div>
                                <div class="col-12 py-2"><b>Email Cliente:</b> &nbsp; &nbsp; &nbsp;{{$dataRecepcion->email}}</div>
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
                                <div class="col-12 py-2"><b>Fecha y Hora de Entrada :</b>&nbsp; &nbsp; &nbsp;{{$dataRecepcion->fecha_entrada}} </div>
                                <div class="col-12 py-2"><b>Fecha y Hora de Entrada :</b>&nbsp; &nbsp; &nbsp;{{$dataRecepcion->fecha_salida}} </div>
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
                    <input type="hidden" name="hddestado_pago" id="hddestado_pago" value="{{$dataRecepcion->estado_pago}}"></td>
                    <table class="table table-bordered align-middle table-hover m-0" border="2">
                        <thead>
                            <tr>
                                <th style="background-color:#9098A2;">#</th>
                                <th colspan="5" style="background-color:#9098A2;">Costo de Alojamiento</th>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>Costo por Tarifa</th>
                                <th>Cant. noches</th>
                                <th>Cant. personas</th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <tr>
                                <td>1</td>
                                <td>{{$dataRecepcion->precio}}</td>
                                <td>{{$dataRecepcion->cant_noches}}</td>
                                <td>{{$dataRecepcion->cant_personas}}</td>
                                <td colspan="2"><input type="number" name="total" id="total" class="form-control" readonly value="{{$dataRecepcion->total}}"></td>
                            </tr>
                            <tr>
                                <td  align="center" colspan="2"><b>Observaciones</b></td>
                                <td colspan="2">{{$dataRecepcion->observaciones}}</td>
                                <td  align="center"><b>Estado</b></td>
                                <td align="center">@if($dataRecepcion->estado_pago == 1)<p style="color:#0C2071;font-size:20px;"><b>PAGADO</b></p> @elseif($dataRecepcion->estado_pago == 2)<p style="color:red;font-size:20px;"><b>FALTA PAGAR</b></p> @endif</td>
                            </tr>
                            @if($dataRecepcion->estado_pago == 1)
                            <tr>
                                <td  align="center" colspan="2"><b>Tipo de Pago:</b></td>
                                <td>{{$dataRecepcion->pago}}</td>
                                <td  align="center" colspan="3"></td>
                                {{-- <td  align="center" colspan="3"><b>Número de Operación:</b></td> --}}
                                {{-- <td>{{$dataRecepcion->nro_operacion}}</td> --}}
                            </tr>
                            @elseif($dataRecepcion->estado_pago == 2)
                            <tr>
                                <td  align="center" colspan="2"><b>Tipo de Pago:</b></td>
                                <td><select name="cbotipopago" id="cbotipopago" class="form-control">
                                    <option value="">--Seleccione--</option>
                                        @if(isset($tipopags) && count($tipopags) > 0)
                                            @foreach($tipopags as $tp)
                                                <option value="{{$tp->tipo_pago_id}}">{{$tp->pago}}</option>
                                            @endforeach
                                        @endif
                                </select>
                                {{-- <td  align="center" colspan="2"><b>Número de Operación:</b></td>
                                <td><input type="text" class="form-control" name="nrooperacionfinal" id="nrooperacionfinal" required style="display: none;"></td> --}}
                            </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="background-color:#9098A2;" align="center" colspan="5"><p style="font-size:14px;"><b>TOTAL</b></p> </td>
                                <td align="center">{{$dataRecepcion->total}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <div>
                        <a class="btn btn-danger btn-icon-split" href="{{ url('/recepcion') }}"> <span class="icon text-white-50"><img src="{{ url('assets/images/cancel.png') }}" width="24px"></span><span class="text">Cancelar</span></a>
                        <button type="submit" class="btn btn-success btn-fw" id="btnGenerar"><span class="icon text-white-50"><img src="{{ url('assets/images/print.png') }}" width="24px"></span><span class="text">Generar Comprobante</span></button>
                        <!-- <a href="{{ url('recepcion/generar_comprobante/'.$dataRecepcion->proceso_id) }}" class="btn btn-success btn-fw" id="guardarProceso"><span class="icon text-white-50"><img src="{{ url('assets/images/print.png') }}" width="24px"></span><span class="text">Generar Comprobante</span></a>  -->
                    </div>
                </div>

                </div>

            </form>

        </div>

    </div>

@endsection

@section('scripts')


    <script>

        $('#cbotipopago').on('change', function() {
            let cbotipopago = $(this).val();
            if(cbotipopago == 1)
            {
               $('#nrooperacionfinal').css("display", "none"); 
            }
            else 
            {
                $('#nrooperacionfinal').css("display", "block"); 
            }
        });

        $('#btnGenerar').click(function(event){
            event.preventDefault();
            let hddproceso_id = $('#hddproceso_id').val();
            $(this).prop('disable',true);
            if(hddproceso_id !="")
            {
                let url = $('meta[name=app-url]').attr("content") + "/recepcion/generar_comprobante";
                let formData = new FormData($("#formGenerar")[0]); 
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: "POST",
                    data: formData,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,  // tell jQuery not to set contentType
                    success: function(response) {
                        $(this).prop('disable',false);
                        console.log(response);
                        if(response.code == "200")
                        {   
                            window.location = response.url;

                        }
                        else if(response.code == "421")
                        {
                            Swal.fire({
                                icon: 'error',
                                title: 'ERROR...',
                                text: 'Debe seleccionar un tipo de pago!'
                            }) 
                        }
                        // else if(response.code == "422")
                        // {
                        //     Swal.fire({
                        //         icon: 'error',
                        //         title: 'ERROR...',
                        //         text: 'Debe Ingresar un Número de Operación!'
                        //     }) 
                        // }
                        else 
                        {
                            Swal.fire({
                                icon: 'error',
                                title: 'ERROR...',
                                text: 'Se ha producido un error al intentar generar el comprobante!'
                            })
                        }
                    },
                    error: function(response) {
                        $(this).prop('disable',false);

                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            text: 'Se ha producido un error al intentar generar el comprobante!'
                        })
                    }
                });
            }
            else 
            {
                Swal.fire({
                    icon: 'error',
                    title: 'ERROR...',
                    text: 'Se ha producido un error al intentar generar el comprobante!'
                })
            }
        });

    </script>

@endsection