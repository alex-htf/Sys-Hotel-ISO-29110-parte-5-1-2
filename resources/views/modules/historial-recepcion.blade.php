@extends('master')

@section('content')

<!-- App hero header starts -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <span>Historial de Recepción</span>
    </h3>
    
    <!-- Breadcrumb navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-table-list"></i> Historial de Recepción</li>
        </ol>
    </nav>
</div>
<!-- App Hero header ends -->

<div class="app-body" style="margin-top:-8.5rem !important;height: calc(103vh - 202px);">
    <div class="row mb-3">
        <!-- Dropdown para seleccionar categoría de habitación -->
        <div class="col-xl-4 col-md-6 col-sm-12 mt-2">
            <div class="form-group">
                <label for="categoriaHabitacionB" style="font-size:14px;">Categoría:</label>
                <select name="categoriaHabitacionB" id="categoriaHabitacionB" class="form-control">
                    <option value="_all_">--Seleccione--</option>
                    @isset($categorias)
                        @foreach ($categorias as $cat)
                            <option value="{{$cat['categoria_id']}}">{{$cat['categoria']}}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>

        <!-- Dropdown para seleccionar ubicación de habitación -->
        <div class="col-xl-4 col-md-6 col-sm-12 mt-2">
            <div class="form-group">
                <label for="ubicacionHabitacionB" style="font-size:14px;">Ubicación:</label>
                <select name="ubicacionHabitacionB" id="ubicacionHabitacionB" class="form-control">
                    <option value="_all_">--Seleccione--</option>
                    @isset($ubicaciones)
                        @foreach ($ubicaciones as $ub)
                            <option value="{{$ub['ubicacion_id']}}">{{$ub['ubicacion']}}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <!-- Historial de recepción -->
        <div class="col-xxl-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <section class="historial">
                        <!-- Si hay datos en el historial, cargarlos -->
                        @if(isset($dataHistorial) && count($dataHistorial) > 0)
                            @include('data.load_historial_data')
                        <!-- Si no hay datos en el historial, mostrar mensaje -->
                        @else 
                            <div class="table-responsive">
                                <table class="table align-middle table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Habitación</th>
                                            <th scope="col">Categoría</th>
                                            <th scope="col">Ubicación</th>
                                            <th scope="col">Cliente</th>
                                            <th scope="col">Tipo de Documento</th>
                                            <th scope="col">Número de Documento</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Acciones</th>
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

@endsection

@section('scripts')

<script>
    // Detectar cambios en el hash de la URL
    $(window).on('hashchange',function(){
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            } else{
                loadhistorial(page);
            }
        }
    });

    $(function (){
        // Cargar historial al hacer clic en la paginación
        $(document).on('click', '.historial .pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            loadhistorial(page);
        });

        // Filtrar historial por categoría de habitación
        $('#categoriaHabitacionB').on('change', function (e ){
            // Obtener URL base
            url=$('meta[name=app-url]').attr("content") + "/recepcion/historial";
            // Obtener valor seleccionado en el dropdown de ubicación
            let ubicacionh = $('#ubicacionHabitacionB').val();
            $.ajax({
                url: url,
                method:'GET',
                // Enviar datos de categoría y ubicación seleccionadas
                data: {categoria: this.value, ubicacion: ubicacionh}
            }).done(function (data) {
                // Mostrar resultados en la sección de historial
                $('.historial').html(data);
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        });

        // Filtrar historial por ubicación de habitación
        $('#ubicacionHabitacionB').on('change', function (e ){
            // Obtener URL base
            url=$('meta[name=app-url]').attr("content") + "/recepcion/historial";
            // Obtener valor seleccionado en el dropdown de categoría
            let categoriah = $('#categoriaHabitacionB').val();
            $.ajax({
                url: url,
                method:'GET',
                // Enviar datos de categoría y ubicación seleccionadas
                data: {categoria: categoriah, ubicacion: this.value}
            }).done(function (data) {
                // Mostrar resultados en la sección de historial
                $('.historial').html(data);
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        });

        // Función para cargar historial según la página
        function loadhistorial(page)
        {
            let url='';
            // Obtener URL base
            url=$('meta[name=app-url]').attr("content")  + "/recepcion/historial?page="+page;
            $.ajax({
                url: url,
                method:'GET',
            }).done(function (data) {
                // Mostrar resultados en la sección de historial
                $('.historial').html(data);
            }).fail(function () {
                console.log("Failed to load data!");
            });
        }
    });
</script>

@endsection
