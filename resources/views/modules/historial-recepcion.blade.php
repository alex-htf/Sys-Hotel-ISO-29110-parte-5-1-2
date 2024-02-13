@extends('master')

@section('content')

<!-- App hero header starts -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <span>Historial de Recepción</span>
    </h3>
    
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

        <div class="col-xl-4 col-md-6 col-sm-12 mt-2">
            <div class="form-group">
                <label for="estadoPagoCBO" style="font-size:14px;">Estado de Pago:</label>
                <select name="estadoPagoCBO" id="estadoPagoCBO" class="form-control">
                    <option value="_all_">--Seleccione--</option>
                    <option value="1">Pagado</option>
                    <option value="2">Falta Pagar</option>
                </select>
            </div>
        </div>

    </div>

    <div class="row mt-3">
        <div class="col-xxl-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <section class="historial">
                        @if(isset($dataHistorial) && count($dataHistorial) > 0)
                                
                            @include('data.load_historial_data')
                        
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
                                            <th scope="col">Tipo Doc</th>
                                            <th scope="col">Nro Doc</th>
                                            <th scope="col">Importe</th>
                                            <th scope="col">Estado Pago</th>
                                            <th scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center" colspan="10">No se encontraron registros</td>
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

        $(document).on('click', '.historial .pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            loadhistorial(page);
        });

        $('#categoriaHabitacionB').on('change', function (e ){
            url=$('meta[name=app-url]').attr("content") + "/recepcion/historial";
            let ubicacionh = $('#ubicacionHabitacionB').val();
            let estadopagoh = $('#estadoPagoCBO').val(); 
            $.ajax({
                url: url,
                method:'GET',
                data: {categoria: this.value, ubicacion: ubicacionh, estado_pago: estadopagoh}
            }).done(function (data) {
                $('.historial').html(data);
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        });

        $('#ubicacionHabitacionB').on('change', function (e ){
            url=$('meta[name=app-url]').attr("content") + "/recepcion/historial";
            let categoriah = $('#categoriaHabitacionB').val();
            let estadopagoh2 = $('#estadoPagoCBO').val(); 
            $.ajax({
                url: url,
                method:'GET',
                data: {categoria: categoriah, ubicacion: this.value, estado_pago: estadopagoh2}
            }).done(function (data) {
                $('.historial').html(data);
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        });

        $('#estadoPagoCBO').on('change', function (e ){
            url=$('meta[name=app-url]').attr("content") + "/recepcion/historial";
            let categoriah2 = $('#categoriaHabitacionB').val();
            let ubicacionh2 = $('#ubicacionHabitacionB').val();
            $.ajax({
                url: url,
                method:'GET',
                data: {categoria: categoriah2, ubicacion: ubicacionh2, estado_pago: this.value}
            }).done(function (data) {
                $('.historial').html(data);
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        });

        function loadhistorial(page)
        {
            let url='';
            url=$('meta[name=app-url]').attr("content")  + "/recepcion/historial?page="+page;

            $.ajax({
                url: url,
                method:'GET',
            }).done(function (data) {
                $('.historial').html(data);
            }).fail(function () {
                console.log("Failed to load data!");
            });
        }


    });

</script>

    
@endsection

