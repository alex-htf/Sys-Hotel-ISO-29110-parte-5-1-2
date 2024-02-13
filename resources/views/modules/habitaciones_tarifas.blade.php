@extends('master')

@section('content')

<!-- App hero header starts -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <span>Mantenimiento de Tarifas para la Habitación "{{ $dataHab->habitacion }}"</span>
    </h3>
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item" aria-current="page"><i class="fa-solid fa-database"></i> Mantenimiento Habitaciones</li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ url('/habitaciones') }}">Habitación</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tarifa Habitación</li>
        </ol>
    </nav>

</div>
<!-- App Hero header ends -->

<div class="app-body" style="margin-top:-8.5rem !important;height: calc(103vh - 202px);">

    <div class="row">
        <div class="col-xl-12 d-flex justify-content-end">
            <div class="form-group">
            <button type="button" class="btn btn-success btn-fw" data-bs-toggle="modal" data-bs-target="#ModalHabitacionTarifa"><img src="{{ url('assets/images/add.png') }}" alt="agregar" width="25px"> Agregar Tarifa Habitación</button>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xxl-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <section class="habitaciones_tarifas">
                        @if(isset($tarifas_habitacion) && count($tarifas_habitacion) > 0)
                                
                            @include('data.load_habitacion_tarifa_data')
                        
                        @else 
                            <div class="table-responsive">
                                <table class="table align-middle table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Tarifa</th>
                                            <th scope="col">Precio</th>
                                            <th scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center" colspan="4">No se encontraron registros</td>
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
<div class="modal fade" id="ModalHabitacionTarifa" tabindex="-1" aria-labelledby="exampleModalLabel"
    data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header" style="background-color:#00368e !important; color:#fff !important;">
            <h5 class="modal-title" id="tituloModalHabitacionTarifa">Agregar Tarifa</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limpiarModalHabitacionTarifa()"></button>
        </div>
        <form action="#" method="POST" id="formHabitacionTarifa">
            @csrf
            <input type="hidden" name="habitacion_id" id="habitacion_id" value="{{$habitacion_id}}">
            <input type="hidden" name="habitaciontarifa_id" id="habitaciontarifa_id">
            <div class="modal-body p-4 bg-light">
                <div class="my-2">
                    <label for="curso">Tarifa:</label>
                    <select name="tarifa_id" id="tarifa_id" class="form-control">
                        <option value="_all_">--Seleccione--</option>
                        @isset($tarifas)
                            @foreach ($tarifas as $ta)
                                <option value="{{$ta['tarifa_id']}}">{{$ta['tarifa']}}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div class="my-2">
                    <label for="curso">Precio:</label>
                    <input type="number" name="precio" id="precio" class="form-control" placeholder="Precio" required>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limpiarModalHabitacionTarifa()">Cerrar</button>
            <button type="submit" id="btnHabitacionTarifa" class="btn btn-success">Registrar Tarifa</button>
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
                loadhabitacionestarifas(page);
            }
        }
    });

    $(function (){

$(document).on('click', '.habitaciones_tarifas .pagination a', function(event){
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    loadhabitacionestarifas(page);
});



window.limpiarModalHabitacionTarifa = function()
{   
    $('#tituloModalHabitacionTarifa').html('Agregar Tarifa');
    $('#habitaciontarifa_id').val("");
    $('#tarifa_id').val("_all_");
    $('#precio').val("");
    $("#btnHabitacionTarifa").text('Registrar Tarifa');
}

function loadhabitacionestarifas(page)
{
    let url='';
    url=$('meta[name=app-url]').attr("content")  + "/habitaciones/ver_tarifas/"+<?php echo $habitacion_id; ?>+"?page="+page;

    $.ajax({
        url: url,
        method:'GET',
    }).done(function (data) {
        $('.habitaciones_tarifas').html(data);
    }).fail(function () {
        console.log("Failed to load data!");
    });
}

$("#formHabitacionTarifa").submit(function(e) {
    event.preventDefault();
    let hddhabitaciontarifa_id = $('#habitaciontarifa_id').val();
    //valida si el campo tarifa_id esta vacío
    if(hddhabitaciontarifa_id!="")
    {
        ActualizarHabitacionTarifa(hddhabitaciontarifa_id);
    }
    else 
    {
        GuardarHabitacionTarifa();
    }
});

//Ajax para registrar Categoria
window.GuardarHabitacionTarifa = function()
{
    $("#btnHabitacionTarifa").prop('disabled', true);
    $("#btnHabitacionTarifa").text('Registrando');
    let url = $('meta[name=app-url]').attr("content") + "/habitaciones/tarifas";

    let data = new FormData($("#formHabitacionTarifa")[0]); 
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        type: "POST",
        data: data,
        processData: false,
        contentType: false,
        success: function(response) {
            $("#btnHabitacionTarifa").prop('disabled', false);
            $("#btnHabitacionTarifa").text('Registrar Tarifa');
            if(response.code == "200")
            {
                    $("#ModalHabitacionTarifa").modal('hide');
                    limpiarModalHabitacionTarifa();
                    loadhabitacionestarifas();

                    Swal.fire({
                        icon: 'success',
                        title: 'ÉXITO!',
                        text: 'Se ha registrado la Tarifa de la Habitación correctamente'
                    });
            }
            else  if(response.code == "422")
            {
                let errors = response.errors;
                let HabitacionTarifaValidation = '';

                $.each(errors, function(index, value) {

                if (typeof value !== 'undefined' || typeof value !== "") 
                {
                    HabitacionTarifaValidation += '<li>' + value + '</li>';
                }

                }); 


                Swal.fire({
                    icon: 'error',
                    title: 'ERROR...',
                    html: '<ul>'+
                    HabitacionTarifaValidation  + 
                            '</ul>'
                });
            }
            else  if(response.code == "426")
            {
                Swal.fire({
                        icon: 'error',
                        title: 'ERROR!',
                        text: 'Ya existe la tarifa para esta habitación!'
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

window.mostrarHabitacionTarifa = function(hddhabitaciontarifa_id) 
{
    url=$('meta[name=app-url]').attr("content") + "/habitaciones/tarifas/" +hddhabitaciontarifa_id;
    $("#ModalHabitacionTarifa").modal('show');
    $.ajax({
        url: url,
        method:'GET'
    }).done(function (data) {
        $('#tituloModalHabitacionTarifa').html('EDITAR HABITACION TARIFA: ' +data.habitacion);
        $('#habitaciontarifa_id').val(hddhabitaciontarifa_id);
        $('#habitacion_id').val(data.habitacion_id);
        $('#tarifa_id').val(data.tarifa_id);
        $('#precio').val(data.precio);
        $('#btnHabitacionTarifa').text('Actualizar Tarifa');
    }).fail(function () {
        console.log("Error al cargar los datos");
    });
}

window.ActualizarHabitacionTarifa = function(hddhabitaciontarifa_id)
{
    $("#btnHabitacionTarifa").prop('disabled', true);
    $("#btnHabitacionTarifa").text('Actualizando');
    let url = $('meta[name=app-url]').attr("content") + "/habitaciones/tarifas/" + hddhabitaciontarifa_id;
    let dataE = new FormData($("#formHabitacionTarifa")[0]); 
    dataE.append('_method', 'PUT');
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
            $("#btnHabitacionTarifa").prop('disabled', false);
            $("#btnHabitacionTarifa").text('Actualizar Tarifa');
            if(response.code == "200")
            {
                    
                    $("#ModalHabitacionTarifa").modal('hide');
                    limpiarModalHabitacionTarifa();
                    loadhabitacionestarifas();


                    Swal.fire({
                        icon: 'success',
                        title: 'ÉXITO!',
                        text: 'Se ha actualizado la Tarifa para la Habitación correctamente'
                    });
            }
            else if(response.code == "422")
            {
                let errors = response.errors;
                let HabitacionValidation = '';

                $.each(errors, function(index, value) {

                    if (typeof value !== 'undefined' || typeof value !== "") 
                    {
                        HabitacionValidation += '<li>' + value + '</li>';
                    }

                }); 

                Swal.fire({
                    icon: 'error',
                    title: 'ERROR...',
                    html: '<ul>'+
                    HabitacionValidation  + 
                            '</ul>'
                });
            }
            else  if(response.code == "426")
            {
                Swal.fire({
                        icon: 'error',
                        title: 'ERROR!',
                        text: 'Ya existe la tarifa para esta habitación!'
                    });
            }
        },
        error: function(response) {
            $("#btnHabitacion").prop('disabled', false);

            Swal.fire({
                icon: 'error',
                title: 'ERROR...',
                text: 'Se ha producido un error al intentar actualizar el registro!'
            })
        }
    });
}

window.eliminarHabitacionTarifa = function(hddhabitaciontarifa_id)
{
    Swal.fire({
        icon: 'warning',
        title: 'Está seguro de eliminar la Tarifa para la Habitación?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonColor: "#EB1010",
        confirmButtonText: `Eliminar`,
        cancelButtonText: `Cancelar`,
        }).then((result) => {
            if (result.isConfirmed) {
                let url = $('meta[name=app-url]').attr("content") +  "/habitaciones/tarifas/"  + hddhabitaciontarifa_id;
                let data = {
                    hddhabitaciontarifa_id: hddhabitaciontarifa_id
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
                            loadhabitacionestarifas();

                            Swal.fire({
                                icon: 'success',
                                title: 'ÉXITO!',
                                text: 'Se ha eliminado la tarifa de la Habitación correctamente'
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

});


</script>

@endsection