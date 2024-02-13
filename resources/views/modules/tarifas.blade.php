@extends('master')

@section('content')

<!-- App hero header starts -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <span>Mantenimiento de Tarifas</span>
    </h3>
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item" aria-current="page"><i class="fa-solid fa-database"></i> Mantenimiento Habitaciones</li>
            <li class="breadcrumb-item active" aria-current="page">Tarifas</li>
        </ol>
    </nav>

</div>
<!-- App Hero header ends -->

<div class="app-body" style="margin-top:-8.5rem !important;height: calc(103vh - 202px);">

    <div class="row">
        <div class="col-xl-12 d-flex justify-content-end">
            <div class="form-group">
            <button type="button" class="btn btn-success btn-fw" data-bs-toggle="modal" data-bs-target="#ModalTarifa"><img src="{{ url('assets/images/add.png') }}" alt="agregar" width="25px"> Agregar Tarifa</button>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xxl-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <section class="tarifas">
                        @if(isset($tarifas) && count($tarifas) > 0)
                                
                            @include('data.load_tarifa_data')
                        
                        @else 
                            <div class="table-responsive">
                                <table class="table align-middle table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Tarifa</th>
                                            <th scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center" colspan="3">No se encontraron registros</td>
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
<div class="modal fade" id="ModalTarifa" tabindex="-1" aria-labelledby="exampleModalLabel"
    data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header" style="background-color:#00368e !important; color:#fff !important;">
            <h5 class="modal-title" id="tituloModalTarifa">Agregar Tarifa</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limpiarModalTarifa()"></button>
        </div>
        <form action="#" method="POST" id="formTarifa">
            @csrf
            <input type="hidden" name="tarifa_id" id="tarifa_id">
            <div class="modal-body p-4 bg-light">
                <div class="my-2">
                    <label for="curso">Tarifa:</label>
                    <input type="text" name="tarifa" id="tarifa" class="form-control" placeholder="Tarifa" required>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limpiarModalTarifa()">Cerrar</button>
            <button type="submit" id="btnTarifa" class="btn btn-success">Agregar Tarifa</button>
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
                loadcategorias(page);
            }
        }
    });

    $(function (){

        $(document).on('click', '.tarifas .pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            loadTarifas(page);
        });

        window.limpiarModalTarifa = function()
        {   
            $('#tituloModalTarifa').html('Agregar Tarifa');
            $("#formTarifa")[0].reset();
            $("#btnTarifa").text('Registrar Tarifa');
            $('#tarifa_id').val("");
        }

        function loadTarifas(page)
        {
            let url='';
            url=$('meta[name=app-url]').attr("content")  + "/tarifas?page="+page;

            $.ajax({
                url: url,
                method:'GET',
            }).done(function (data) {
                $('.tarifas').html(data);
            }).fail(function () {
                console.log("Failed to load data!");
            });
        }

        $("#formTarifa").submit(function(e) {
            event.preventDefault();
            let hddtarifa_id = $('#tarifa_id').val();
            //valida si el campo tarifa_id esta vacío
            if(hddtarifa_id!="")
            {
                ActualizarTarifa(hddtarifa_id);
            }
            else 
            {
                GuardarTarifa();
            }
        });

        //Ajax para registrar Categoria
        window.GuardarTarifa = function()
        {
            $("#btnTarifa").prop('disabled', true);
            $("#btnTarifa").text('Registrando');
            let url = $('meta[name=app-url]').attr("content") + "/tarifas";
            let data = $('#formTarifa').serialize();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                data: data,
                success: function(response) {
                    $("#btnTarifa").prop('disabled', false);
                    $("#btnTarifa").text('Registrar Categoría');
                    if(response.code == "200")
                    {
                           
                            $("#ModalTarifa").modal('hide');
                            limpiarModalTarifa();
                            loadTarifas();

                            Swal.fire({
                                icon: 'success',
                                title: 'ÉXITO!',
                                text: 'Se ha registrado la Tarifa correctamente'
                            });
                    }
                    else  if(response.code == "422")
                    {
                            let errors = response.errors;
                            console.log(errors);
                            if (typeof errors.categoria !== 'undefined' || typeof errors.categoria !== "") 
                            {
                                categoriavalidation = '<li>' + errors.categoria + '</li>';
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'ERROR...',
                                html: '<ul>'+
                                        categoriavalidation  + 
                                        '</ul>'
                            });
                    }
                    else 
                    {
                        Swal.fire({
                                icon: 'error',
                                title: 'ERROR!',
                                text: 'Ha ocurrido un error al intentar registrar la categoría!'
                            });
                    }
                }
            })

        }

        window.mostrarTarifa = function(tarifa_id) 
        {
            url=$('meta[name=app-url]').attr("content") + "/tarifas/" +tarifa_id;
            $("#ModalTarifa").modal('show');
            $.ajax({
                url: url,
                method:'GET'
            }).done(function (data) {
                $('#tituloModalTarifa').html('EDITAR TARIFA: ' +data.tarifa);
                $('#tarifa_id').val(tarifa_id);
                $('#tarifa').val(data.tarifa);
                $('#btnTarifa').text('Actualizar Tarifa');
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        }

        window.ActualizarTarifa = function(tarifa_id)
        {
            $("#btnTarifa").prop('disabled', true);
            $("#btnTarifa").text('Actualizando');
            let url = $('meta[name=app-url]').attr("content") + "/tarifas/" + tarifa_id;
            let data = $('#formTarifa').serialize();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "PUT",
                data: data,
                success: function(response) {
                    $("#btnTarifa").prop('disabled', false);
                    $("#btnTarifa").text('Actualizar Tarifa');
                    if(response.code == "200")
                    {
                            
                            $("#ModalTarifa").modal('hide');
                            limpiarModalTarifa();
                            loadTarifas();

                            Swal.fire({
                                icon: 'success',
                                title: 'ÉXITO!',
                                text: 'Se ha actualizado la Tarifa correctamente'
                            });
                    }
                    else if(response.code == "422")
                    {
                        let errors = response.errors;
                        if (typeof errors.tarifa !== 'undefined' || typeof errors.tarifa !== "") 
                        {
                            tarifavalidation = '<li>' + errors.tarifa + '</li>';
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            html: '<ul>'+
                            tarifavalidation  + 
                                    '</ul>'
                        });
                    }
                },
                error: function(response) {
                    $("#btnTarifa").prop('disabled', false);
    
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'Se ha producido un error al intentar actualizar el registro!'
                    })
                }
            });
        }

        window.eliminarTarifa = function(tarifa_id)
        {
            Swal.fire({
                icon: 'warning',
                title: 'Está seguro de eliminar la Tarifa?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: "#EB1010",
                confirmButtonText: `Eliminar`,
                cancelButtonText: `Cancelar`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = $('meta[name=app-url]').attr("content") +  "/tarifas/"  + tarifa_id;
                        let data = {
                            tarifa_id: tarifa_id
                        };
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: url,
                            type: "DELETE",
                            data: data,
                            success: function(response) {
                                if(response.code == "200")
                                {
                                    loadTarifas();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'ÉXITO!',
                                        text: 'Se ha eliminado la tarifa correctamente'
                                    });
                                }
                            },
                            error: function(response) {                
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ERROR...',
                                    text: 'Se ha producido un error al intentar eliminar el registro!'
                                })
                            }
                        });
                    }
                })
        }

        window.desactivarTarifa = function(tarifa_id)
        {
            Swal.fire({
                icon: 'warning',
                title: 'Está seguro de desactivar la Tarifa?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: "#EB1010",
                confirmButtonText: `Desactivar`,
                cancelButtonText: `Cancelar`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = $('meta[name=app-url]').attr("content") + "/tarifas" +  "/desactivar/" + tarifa_id;
                        let data = {
                            tarifa_id: tarifa_id
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
                                    loadTarifas();
                                   
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'ÉXITO!',
                                        text: 'Se ha desactivado la Tarifa correctamente'
                                    });
                                    // document.location.reload(true)
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
        }

        window.activarTarifa = function(tarifa_id)
        {
            Swal.fire({
                icon: 'warning',
                title: 'Está seguro de activar la Tarifa?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: "#EB1010",
                confirmButtonText: `Activar`,
                cancelButtonText: `Cancelar`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = $('meta[name=app-url]').attr("content") +  "/tarifas" +  "/activar/" + tarifa_id;
                        let data = {
                            tarifa_id: tarifa_id
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
                                    loadTarifas();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'ÉXITO!',
                                        text: 'Se ha activado la tarifa correctamente'
                                    });
                                    // document.location.reload(true)
                                }
                            },
                            error: function(response) {                    
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ERROR...',
                                    text: 'Se ha producido un error al intentar activar el registro!'
                                })
                            }
                        });
                    }
                })
        }

    });
</script>

@endsection