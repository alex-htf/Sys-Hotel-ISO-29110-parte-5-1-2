@extends('master')

@section('content')

<!-- Encabezado de la aplicación comienza -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <span>Configuración</span>
    </h3>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-gears"></i> Configuración</li>
        </ol>
    </nav>
</div>

<div class="app-body" style="margin-top:-8.5rem !important;height: calc(103vh - 202px);">

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <!-- Formulario para enviar la configuración -->
                <form method="POST" action="{{ url('admin/configuraciones') }}" enctype="multipart/form-data"
                    id="formConfiguraciones">
                    @csrf
                    <div class="card-body">
                        <!-- Título del formulario -->
                        <h3 class="card-title">Listado de Parámetros de Configuración</h3>
                        <div class="form-group row mt-3">
                            <!-- Itera sobre cada configuración -->
                            @foreach($configuraciones as $c)
                            <div class="col-md-4 col-sm-12 mt-3">
                                <div class="form-group"
                                    style="background:#eee;border:1px solid #ddd;padding:15px 36px;overflow:hidden;">
                                    <label><b>{{$c->nombre}}:</b></label>
                                    <input type='text' class="form-control" name="valor[]" style="width:90%;"
                                        value="{{$c->valor!="" ? $c->valor : ''}}" />
                                    <input type="hidden" name="configuracion_id[]" value="{{$c->configuracion_id}}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <!-- Botón para guardar la configuración con un ícono -->
                        <center>
                            <button type="submit" class="btn btn-dark btn-icon-split text-muted" id="guardarConfiguraciones">
                                <span class="icon text-muted-150"><i class="fas fa-save fa-lg"></i></span>
                                <span class="text">Guardar</span>
                            </button>
                        </center>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>

    // Función para manejar el clic en el botón de guardar configuraciones
    $('#guardarConfiguraciones').click(function (event) {
        event.preventDefault();
        $("#guardarConfiguraciones").prop('disabled', true);
        // Obtener la URL de la aplicación
        let url = $('meta[name=app-url]').attr("content") + "/configuraciones";
        // Crear un objeto FormData con los datos del formulario
        let formData = new FormData($("#formConfiguraciones")[0]);
        // Realizar una petición AJAX para guardar la configuración
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
                $("#guardarConfiguraciones").prop('disabled', false);
                // Si la respuesta es exitosa, mostrar un mensaje de éxito y redirigir
                if (response.code == "200") {
                    Swal.fire({
                        icon: 'success',
                        title: 'ÉXITO!',
                        text: 'Se ha guardado la Configuración correctamente',
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
                // Si hay un error en la respuesta, mostrar un mensaje de error
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'Se ha producido un error al intentar guardar el registro!'
                    });
                }
            },
            // Si hay un error en la petición, mostrar un mensaje de error
            error: function (response) {
                $("#guardarConfiguraciones").prop('disabled', false);
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
