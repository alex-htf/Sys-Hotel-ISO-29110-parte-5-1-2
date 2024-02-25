<div class="row">
    @foreach($habitaciones as $hab)
    <!-- Se guarda el ID de la habitación en la variable $parameter -->
    <?php $parameter=$hab->habitacion_id;?> 
    <div class="col-lg-2 col-6 p-2">
        <!-- Si el estado de la habitación es 1 (Disponible) -->
        @if($hab->estado == 1) 
        <div class="card text-bg-success">
            <div class="card-header d-flex justify-content-between"
                style="background-color: RGBA(var(--bs-success-rgb), var(--bs-bg-opacity, 1)) !important;"> 
                <h6 class="card-title">Disponible</h6>
                <a href="{{ url('recepcion_proceso/'.$parameter) }}"><i class="bi bi-bell icono-campana"></i></a>
            </div>
            <div class="card-body">
                <div class="card-text text-center p-1" style="font-size: 1.2rem;">
                    <h6>{{$hab->categoria}}</h6>
                    <a style="color:white; text-decoration:none; cursor:pointer;"
                        onclick="getDetalles(<?php echo "'".$parameter."'"; ?>);"><i class="fa-solid fa-bed"></i>
                        {{$hab->habitacion}}</a> <!-- Nombre de la habitación con un enlace para ver detalles -->
                </div>
            </div>
        </div>
        @endif

        <!-- Si el estado de la habitación es 2 (Ocupado) -->
        @if($hab->estado == 2) 
        <div class="card text-bg-danger">
            <div class="card-header d-flex justify-content-between"
                style="background-color: RGBA(var(--bs-danger-rgb), var(--bs-bg-opacity, 1)) !important;"> <!-- Encabezado de la tarjeta con color rojo -->
                <h6 class="card-title">Ocupado</h6> 
                <a href="{{ url('proceso_salida/'.$parameter) }}"><i class="bi bi-card-checklist icono-campana"></i></a>
            </div>
            <div class="card-body">
                <div class="card-text text-center p-2" style="font-size: 1.2rem;">
                    <h6>{{$hab->categoria}}</h6> 
                    <h6>{{$hab->cliente}}</h6> <!-- Nombre del cliente actualmente alojado en la habitación -->
                </div>
            </div>
        </div>
        @endif
    </div>
    @endforeach
</div>
