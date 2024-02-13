@extends('master')

@section('content')


<!-- App hero header starts -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <span>Mantenimiento de Clientes</span>
    </h3>
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-users"></i> Clientes</li>
        </ol>
    </nav>

</div>
<!-- App Hero header ends -->

<div class="app-body" style="margin-top:-8.5rem !important;height: calc(103vh - 202px);">

    <div class="row mb-3  d-flex align-items-center">
        <div class="col-xl-12">
            <div class="form-group">
                <h5 class="mb-3">Buscar por:</h5>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="txtNombreB" style="font-size:14px;">Tipo Documento: </label>
                <select name="tipoDocCLienteB" id="tipoDocCLienteB" class="form-control">
                    <option value="_all_">--Seleccione--</option>
                    @isset($tipo_doc)
                        @foreach ($tipo_doc as $td)
                            <option value="{{$td['tipo_documento_id']}}">{{$td['tipo']}}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>

       
        <div class="col-xl-6 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="txtNroDocBuscar" style="font-size:14px;">Nro Documento: </label>
                <input type="text" class="form-control" id="txtNroDocBuscar" name="txtNroDocBuscar" placeholder="Nombre del Usuario...">
            </div>
        </div>
        
    </div>

    <div class="row mt-3">
        <div class="col-xxl-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <section class="clientes">
                        @if(isset($clientes) && count($clientes) > 0)
                                
                            @include('data.load_clientes_data')
                        
                        @else 
                            <div class="table-responsive">
                                <table class="table align-middle table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tipo Documento</th>
                                            <th>Nro Documento</th>
                                            <th>Nombre</th>
                                            {{-- <th>Razón Social</th> --}}
                                            <th>Dirección</th></th>
                                            <th>Telefóno</th>
                                            <th>Email</th>
                                            <th>Acciones</th>
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
<div class="modal fade" id="ModalCliente" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header" style="background-color:#00368e !important; color:#fff !important;">
            <h5 class="modal-title" id="tituloModalCliente">Actualizar Cliente</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limpiarModalCliente()"></button>
        </div>
        <form action="#" method="POST" id="formCliente">
            @csrf
            <input type="hidden" name="cliente_id" id="cliente_id">
            <div class="modal-body p-4 bg-light">
                <div class="my-2">
                    <label for="cliente">Cliente:</label>
                    <input type="text" name="cliente" id="cliente" class="form-control" placeholder="Nombre Cliente" required>
                </div>
                {{-- <div class="my-2">
                    <label for="razon_social">Razón Social:</label>
                    <input type="text" name="razon_social" id="razon_social" class="form-control" placeholder="Razón Social" required>
                </div> --}}
                <div class="my-2">
                    <label for="tipoDocumentoCliente">Tipo Documento:</label>
                    <select class="form-control" name="tipoDocumentoCliente" id="tipoDocumentoCliente">
                        <option value="">--Seleccione Tipo Documento--</option>
                        @isset($tipo_doc)
                            @foreach ($tipo_doc as $td)
                                <option value="{{$td['tipo_documento_id']}}">{{$td['tipo']}}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div class="my-2">
                    <label for="nro_documento">Número Documento:</label>
                    <input type="text" name="nro_documento" id="nro_documento" class="form-control" placeholder="Nro Documento" required>
                </div>
                <div class="my-2">
                    <label for="direccionCliente">Dirección:</label>
                    <input type="text" name="direccionCliente" id="direccionCliente" class="form-control" placeholder="Dirección Cliente" required>
                </div>
                <div class="my-2">
                    <label for="tel_Cliente">Teléfono:</label>
                    <input type="text" name="tel_Cliente" id="tel_Cliente" class="form-control" placeholder="Teléfono" required>
                </div>
                <div class="my-2">
                    <label for="email_cliente">Email:</label>
                    <input type="text" name="email_cliente" id="email_cliente" class="form-control" placeholder="Email" required>
                </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limpiarModalCliente()">Cerrar</button>
            <button type="button" id="btnCliente" class="btn btn-success">Actualizar Cliente</button>
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

        $(document).on('click', '.clientes .pagination a', function(event){
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                // console.log(page);
                loadclientes(page);
        });

        $('#tipoDocCLienteB').on('change', function (e ){
            url=$('meta[name=app-url]').attr("content") + "/clientes";
            let nrodoc = $('#txtNroDocBuscar').val();
            $.ajax({
                url: url,
                method:'GET',
                data: {tipo_doc: this.value, nrodoc: nrodoc}
            }).done(function (data) {
                $('.clientes').html(data);
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        });

        $('#txtNroDocBuscar').on('keyup', function(e){
            url=$('meta[name=app-url]').attr("content") + "/clientes";
            let tipodoc = $('#tipoDocCLienteB').val(); 
            $.ajax({
                url: url,
                method:'GET',
                data: {tipo_doc: tipodoc, nrodoc: this.value}
            }).done(function (data) {
                $('.clientes').html(data);
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        });

        function loadclientes(page)
        {
            let url='';
            url=$('meta[name=app-url]').attr("content")  + "/clientes?page="+page;

            $.ajax({
                url: url,
                method:'GET',
            }).done(function (data) {
                $('.clientes').html(data);
            }).fail(function () {
                console.log("Failed to load data!");
            });
        }

        function limpiarModalCliente()
        {
            $('#tituloModalCliente').html('Actualizar Cliente');
            $('#cliente_id').val("");
            $('#cliente').val("");
            $('#razon_social').val("");
            $('#tipoDocumentoCliente').val("");
            $('#nro_documento').val("");
            $('#direccionCliente').val("");
            $('#tel_Cliente').val("");
            $('#email_cliente').val("");
        }
        
        window.mostrarCliente = function(cliente_id) 
        {
            url=$('meta[name=app-url]').attr("content") + "/clientes/" +cliente_id;
            $("#ModalCliente").modal('show');
            $('#cliente_id').val("");
            $.ajax({
                url: url,
                method:'GET'
            }).done(function (data) {
                console.log(data);
                $('#tituloModalCliente').html('Actualizar Cliente: ' +data.nombre);
                $('#cliente_id').val(cliente_id);
                $('#cliente').val(data.nombre);
                $('#razon_social').val(data.razon_social);
                $('#tipoDocumentoCliente').val(data.tipo_documento_id);
                $('#nro_documento').val(data.documento);
                $('#direccionCliente').val(data.direccion);
                $('#tel_Cliente').val(data.telefono);
                $('#email_cliente').val(data.email);
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        }

        // $("#formCliente").submit(function(e) {
        $('#btnCliente').click(function(event){
            event.preventDefault();
            // console.log('ra');
            let cliente_id = $('#cliente_id').val();
            $("#btnCliente").prop('disabled', true);
            let url = $('meta[name=app-url]').attr("content") + "/updatecliente/" + cliente_id;
            let dataE = new FormData($("#formCliente")[0]); 
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
                    $("#btnCliente").prop('disabled', false);
                    if(response.code == "200")
                    {
                            
                            $("#ModalCliente").modal('hide');
                            limpiarModalCliente();
                            loadclientes();

                            Swal.fire({
                                icon: 'success',
                                title: 'ÉXITO!',
                                text: 'Se ha actualizado el Cliente correctamente'
                            });
                    }
                    else if(response.code == "422")
                    {
                        let errors = response.errors;
                        let ClienteValidation = '';

                        $.each(errors, function(index, value) {

                            if (typeof value !== 'undefined' || typeof value !== "") 
                            {
                                ClienteValidation += '<li>' + value + '</li>';
                            }

                        }); 

                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            html: '<ul>'+
                            ClienteValidation  + 
                                    '</ul>'
                        });
                    }

                    else if(response.code == "423")
                    {
                        Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'El Número de Documento para ese tipo de Documento ya ha sido registrado!'
                    })
                    }
                },
                error: function(response) {
                    $("#btnCliente").prop('disabled', false);
    
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'Se ha producido un error al intentar actualizar el registro!'
                    })
                }
            });
        });

    });


    </script>

@endsection