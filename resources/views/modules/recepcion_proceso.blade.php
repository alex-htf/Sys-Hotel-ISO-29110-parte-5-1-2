@extends('master')

@section('content')

<!-- App hero header starts -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <b><span>PROCESAR RECEPCIÓN</span></b>
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


<div class="app-body"style="margin-top:-8.5rem !important;height: calc(103vh - 202px);">

    <div class="row">

        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title">Datos de la Habitación</h5>
                </div>
                <div class="card-body">
                    <div class="card-text">
                        <div class="row">
                            <div class="col-md-6 col-12 py-2"><b>Nombre:</b> &nbsp; &nbsp; &nbsp;{{$dataHabitacion->habitacion}}</div>
                            <div class="col-md-6 col-12 py-2"><b>Categoría:</b> &nbsp; &nbsp; &nbsp;{{$dataHabitacion->categoria}}</div>
                            <div class="col-md-6 col-12 py-2"><b>Detalles:</b> &nbsp; &nbsp; &nbsp;{{$dataHabitacion->detalles}}</div>
                            <div class="col-md-6 col-12 py-2"><b>Estado:</b>&nbsp; &nbsp; &nbsp; @if($dataHabitacion->estado == 1) <label class="badge bg-success">Disponible</label> @elseif($dataHabitacion->estado == 2) <label class="badge bg-danger">Ocupado</label> @endif</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </row>
    
    <form action="#" id="formProceso" method="POST">

        <div class="row">

            <div class="col-md-6 col-12 mt-4">   
                <h5 class="text-center">Datos del Cliente</h5>
                <div class="card shadow">
                    <div class="card-body p-4">
                        <div class="row">

                            <div class="col-12">
                                <div class="input-group">
                                    <span class="input-group-text">Tipo Documento:</span>
                                    <input type="hidden" name="hddhabitacion_id" id="hddhabitacion_id" value="{{$habitacionid}}">
                                    <select name="tipo_documento" id="tipo_documento" class="form-control">
                                        <option value="">--SELECCIONE--</option>
                                        @if(isset($tipodocs) && count($tipodocs) > 0)
                                            @foreach($tipodocs as $td)
                                                <option value="{{$td->tipo_documento_id}}">{{$td->tipo}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            
                            <div class="col-12 mt-3">
                                <div class="input-group">
                                    <span class="input-group-text">Nro Documento:</span>
                                    <input type="number" class="form-control" id="num_doc" name="num_doc" placeholder="Número del Documento" >
                                    <button class="btn btn-dark" id="btnsearchCliente"><i class="fas fa-search"></i></button>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="input-group">
                                    <span class="input-group-text">Nombres:</span>
                                    <input type="text" class="form-control" id="nomCliente" name="nomCliente" placeholder="Nombres del Cliente" readonly>
                                </div>
                            </div>

                            {{-- <div class="col-12">
                                <div class="input-group mt-3">
                                    <span class="input-group-text">Razón Social:</span>
                                    <input type="text" class="form-control" id="razonsocialCiente" name="razonsocialCiente"  placeholder="Razón Social" readonly>
                                </div>
                            </div> --}}

                            <div class="col-12">
                                <div class="input-group mt-3">
                                    <span class="input-group-text">Dirección:</span>
                                    <input type="text" class="form-control" id="direCliente" name="direCliente" placeholder="Dirección del Cliente" readonly>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="input-group mt-3">
                                    <span class="input-group-text">Teléfono:</span>
                                    <input type="text" class="form-control" id="telCliente" name="telCliente" placeholder="Teléfono del Cliente" readonly>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="input-group mt-3">
                                    <span class="input-group-text">Email:</span>
                                    <input type="text" class="form-control" id="emailCliente" name="emailCliente" placeholder="Email del Cliente" readonly>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="input-group mt-3">
                                    <span class="input-group-text">Observaciones:</span>
                                    <input type="text" class="form-control" id="observacionesCliente" name="observacionesCliente" placeholder="Observaciones del Cliente">
                                </div>
                            </div>

                            {{-- <div class="col-12">
                                <div class="input-group mt-3">
                                    <span class="input-group-text">Toallas:</span>
                                    <input type="number" class="form-control" name="toallastxt" id="toallastxt" value="1" min="1">
                                </div>
                            </div> --}}

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-12 mt-4">
                <h5 class="text-center">Datos del Alojamiento</h5>
                <div class="card shadow">
                    <div class="card-body p-4">
                        <div class="row">

                            <!-- <div class="col-12">
                                <div class="input-group">
                                    <span class="input-group-text">Tarifas:</span>
                                    <select name="tarifa_hab" id="tarifa_hab" class="form-control">
                                        <option value="">--SELECCIONE--</option>
                                        @if(isset($tarifashab) && count($tarifashab) > 0)
                                            @foreach($tarifashab as $th)
                                                <option value="{{$th->tarifa_id}}" data-atributo="{{$th->precio}}">{{$th->tarifa}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div> -->

                            <div class="tarifaDIV mt-4 col-12">

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-regular fa-money-bill-1"></i>&nbsp;Precio:</span>
                                            <input type="number" id="pricetarifa" name="pricetarifa" class="form-control" value="{{$dataHabitacion->precio}}" readonly>
                                            <input type="hidden" id="hddpricet" name="hddpricet" value="{{$dataHabitacion->precio}}">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="input-group">
                                            <span class="input-group-text">Cant. de Noches:</span>
                                            <input type="number" class="form-control" id="cantidadnoches" name="cantidadnoches" value="1" min="1">
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                            
                            <div class="col-12 mt-4">
                                <div class="input-group">
                                    <span class="input-group-text">Cantidad de Personas:</span>
                                    <input type="number" id="cantidadpersonas" name="cantidadpersonas" class="form-control" value="1" min="1">
                                </div>
                            </div>

                            <!-- <div class="col-12 mt-4">
                                <div class="input-group">
                                    <span class="input-group-text">Tipo de Comprobante:</span>
                                    <select name="Tipo_comprobante" id="Tipo_comprobante" class="form-control">
                                        <option value="">--SELECCIONE--</option>
                                        @if(isset($tipocomprobante) && count($tipocomprobante) > 0)
                                            @foreach($tipocomprobante as $tc)
                                                <option value="{{$tc->tipo_comprobante_id}}">{{$tc->comprobante}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div> -->

                            <div class="col-12 mt-4">
                                <div class="input-group">
                                    <span class="input-group-text">Estado de Pago:</span>
                                    <select name="estado_pago" id="estado_pago" class="form-control">
                                        <option value="">--SELECCIONE--</option>
                                        <option value="1">Pagado</option>
                                        <option value="2">Falta Pagar</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt-4 tipopagodv" style="display:none;">
                                <div class="input-group">
                                    <span class="input-group-text">Tipo Pago:</span>
                                    <select name="tipo_pago" id="tipo_pago" class="form-control">
                                        <option value="">--SELECCIONE--</option>
                                        @if(isset($tipopags) && count($tipopags) > 0)
                                            @foreach($tipopags as $tp)
                                                <option value="{{$tp->tipo_pago_id}}">{{$tp->pago}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            {{-- <div class="col-12 nro_operadiv" style="display:none;">
                                <div class="input-group mt-3">
                                    <span class="input-group-text">Nro Operación:</span>
                                    <input type="text" class="form-control" id="nro_operacion" name="nro_operacion" placeholder="Ingrese el Número de Operación">
                                </div>
                            </div> --}}

                            <div class="col-md-7 col-12 mt-4">
                                <div class="input-group">
                                    <span class="input-group-text">Fecha de salida:</span>
                                    <input type="date" class="form-control" name="fechaSalida">
                                </div>
                            </div>
                            <div class="col-md-5 col-12 mt-4">
                                <div class="input-group">
                                    <span class="input-group-text">Hora de salida:</span>
                                    <input type="time" class="form-control" name="horasalida">
                                </div>
                                
                            </div>

                            
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

                <div class="mt-4">
                    <div class="form-group">

                        <a class="btn btn-danger btn-icon-split" href="{{ url('/recepcion') }}"> <span class="icon text-white-50"><img src="{{ url('assets/images/cancel.png') }}" width="24px"></span><span class="text">Cancelar</span></a>
                        @if($dataHabitacion->estado == 1)
                            <button type="submit" class="btn btn-success btn-fw" id="guardarProceso"><span class="icon text-white-50"><img src="{{ url('assets/images/save.png') }}" width="24px"></span><span class="text">Registrar Ingreso</span></button> 
                        @endif               
                    </div>
                </div>
            </div>

        </div>

    </form>


</div>


@endsection

@section('scripts')

    <script>
        //buscar Cliente
        $('#btnsearchCliente').click(function(event){
            event.preventDefault();
        
           let tipodoc = $('#tipo_documento').val();
           let numdoc = $('#num_doc').val();

            if(tipodoc == "")
            {
                Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                        text: 'Debe seleccionar el tipo de documento!'
                    })
            }
            else 
            {
                if(numdoc.length < 8)
                {
                    Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                        text: 'El número del documento debe tener como mínimo 8 carácteres!'
                    })
                }
                else 
                {
                    let url = $('meta[name=app-url]').attr("content") + "/search_cliente/";

                    $.ajax({
                        url: url,
                        method:'GET',
                        data: { 
                            tipodoc: tipodoc, 
                            numdoc: numdoc, 
                        },
                    }).done(function (response) {
                        if($.isEmptyObject(response)){
                            Swal.fire({
                                    icon: 'error',
                                    title: 'ERROR...',
                                text: 'El Cliente no está registrado!'
                            })
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
                        else 
                        {
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
            }
           
        });

        $('#estado_pago').on('change', function() {
            let value = $(this).find(":checked").val();
            if(value == 1)
            {   
                $('.tipopagodv').css("display", "block"); 
                $('#tipo_pago').val("");
            }
            else 
            {
                $('.tipopagodv').css("display", "none"); 
                $('#tipo_pago').val("");
                $('.nro_operadiv').css("display", "none"); 
                $('#nro_operacion').val(""); 
            }
        });

        // Seleccionando tipo de pago
        /*$('#tipo_pago').on('change', function() {
            let tipo_pago = $(this).find(":checked").val();
            console.log(tipo_pago);
            if(tipo_pago == "" || tipo_pago == "1")
            {   
                $('.nro_operadiv').css("display", "none"); 
                $('#nro_operacion').val(""); 
            }
            else
            {   $('.nro_operadiv').css("display", "block"); 
               
            }
         
        });*/


        $('#tarifa_hab').on('change', function() {
           let option = $(this).find('option:selected');
           $('#pricetarifa').val("");
           $('#cantidadnoches').val("1");
           let cantper = $('#cantidadpersonas').val();
           $('#hddpricet').val("");
           let total =  option.data('atributo') * 1;
           let totalf = total * cantper;
           if(option.val() != "")
           {
                $('.tarifaDIV').css("display", "block"); 
                $('#hddpricet').val( option.data('atributo'));
                $('#pricetarifa').val( option.data('atributo'));
                $('#cantidadnoches').val("1");
                $('#lblTotal').html(totalf);
           }
           else 
           {
                $('.tarifaDIV').css("display", "none"); 
                $('#pricetarifa').val("");
                $('#hddpricet').val("");
                $('#cantidadnoches').val("1");
                $('#lblTotal').html("0.00");
           }

        });

        $("#cantidadnoches").bind('keyup mouseup', function () {
            let cantnoches = $(this).val();
            let cantper2 = $('#cantidadpersonas').val();
            let hddpriceval = $('#hddpricet').val();    
            if(cantnoches != "" && cantnoches > 0)
            {
                console.log(cantnoches);
                let price = $('#pricetarifa').val();   
                let totalpagar = cantnoches * price;
                let totalpagar2 = totalpagar* cantper2; 
                $('#lblTotal').html(totalpagar2);
            }
            else 
            {
                $('#lblTotal').html(hddpriceval);
            }
           
            // if(cantper2 > 0 || cantper2 != "")
            // {
            //     if(cantnoches > 0 || cantnoches != "")
            //     {
            //         console.log(cantnoches);
            //         let price = $('#pricetarifa').val();   
            //         let totalpagar = cantnoches * price;
            //         let totalpagar2 = totalpagar* cantper2; 
            //         $('#lblTotal').html(totalpagar2);
            //     }
            //     else 
            //     {
            //         $('#lblTotal').html(hddpriceval);
            //     }
            // }
            // else 
            // {
            //     $('#lblTotal').html(hddpriceval);
            // }
          
        });

        $("#cantidadpersonas").bind('keyup mouseup', function () {
            let cantpersonas = $(this).val();
            let price2 = $('#hddpricet').val();   
            let cantnoches2 = $('#cantidadnoches').val();
            if(cantpersonas > 0 && cantpersonas != "")
                {
                if(price2 != '')
                {  
                    let sutotal = price2 * cantnoches2;
                    let totalf = sutotal * cantpersonas;

                    $('#lblTotal').html(totalf);
                }
            }
            else 
            {
                $('#lblTotal').html(price2);
            }
            // if(cantnoches2 > 0 || cantnoches2 != "")
            // {   
            //     if(cantpersonas > 0 || cantpersonas != "")
            //     {
            //         if(price2 != '')
            //         {  
            //             let sutotal = price2 * cantnoches2;
            //             let totalf = sutotal * cantpersonas;

            //             $('#lblTotal').html(totalf);
            //         }
            //     }
            //     else 
            //     {
            //         $('#lblTotal').html(price2);
            //     }
               
            // }
            // else 
            // {
            //     $('#lblTotal').html(price2);
            // }
          
        });
        
        $("#formProceso").submit(function(e) {
            event.preventDefault();
            $("#guardarProceso").prop('disabled', true);
            $("#guardarProceso").text('Registrando...');
            let url = $('meta[name=app-url]').attr("content") + "/recepcion";
            let data =  new FormData($("#formProceso")[0]); 
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                data: data,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success: function(response) {
                    $("#guardarProceso").prop('disabled', false);
                    $("#guardarProceso").text('Registrar Ingreso');
                    if(response.code == "200")
                    {   
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
                    else  if(response.code == "422")
                    {
                        let errors = response.errors;
                        let procesoValidation = '';

                        $.each(errors, function(index, value) {

                            if (typeof value !== 'undefined' || typeof value !== "") 
                            {
                                procesoValidation += '<li>' + value + '</li>';
                            }

                        }); 

                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            html: '<ul>'+
                                procesoValidation  + 
                                    '</ul>'
                        });
                    }
                    else  if(response.code == "425")
                    {
                        Swal.fire({
                                icon: 'error',
                                title: 'ERROR...',
                            text: 'Debe Seleccionar el tipo de pago!'
                        })
                    }
                    else  if(response.code == "426")
                    {
                        Swal.fire({
                                icon: 'error',
                                title: 'ERROR...',
                            text: 'El Número de Operación es requerido!'
                        })
                    }
                },
                error: function(response) {
                    $("#guardarProceso").prop('disabled', false);

                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'Se ha producido un error al intentar guardar el registro!'
                    })
                }
            });
        });

    </script>

@endsection