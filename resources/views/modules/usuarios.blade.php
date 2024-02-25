@extends('master')

@section('content')

<!-- Encabezado de la aplicación -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <span>Mantenimiento del Usuario</span>
    </h3>

    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-user"></i> Usuario</li>
        </ol>
    </nav>
</div>

<div class="app-body" style="margin-top:-8.5rem !important;height: calc(103vh - 202px);">
    <div class="row mt-3">
        <div class="col-xxl-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <section class="usuarios">
                        <!-- Verificación de si hay usuarios -->
                        @if(isset($usuarios) && count($usuarios) > 0)
                            <!-- Incluir datos de usuarios -->
                            @include('data.load_usuarios_data')
                            @else
                            <!-- Tabla de usuarios vacía -->
                            <div class="table-responsive">
                                <table class="table align-middle table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Email</th>
                                            <th>Dirección</th>
                                            <th>Teléfono</th>
                                            <th>Usuario</th>
                                            <th>Foto</th>
                                            <th>Editar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center" colspan="8">No se encontraron registros</td>
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

@endsection

@section('scripts')

<script>
    // Función para cargar usuarios mediante AJAX
    $(window).on('hashchange', function () {
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            } else {
                loadusuarios(page);
            }
        }
    });

    $(document).on('click', '.usuarios .pagination a', function (event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        loadusuarios(page);
    });

    function loadusuarios(page) {
        let url = '';
        let txtNombreBuscar = $('#txtNombreB').val();
        url = $('meta[name=app-url]').attr("content") + "/usuarios?page=" + page;
        $.ajax({
            url: url,
            method: 'GET',
            data: { usuario: txtNombreBuscar }
        }).done(function (data) {
            $('.usuarios').html(data);
        }).fail(function () {
            console.log("No se pudo cargar los datos!");
        });
    }

</script>
@endsection
