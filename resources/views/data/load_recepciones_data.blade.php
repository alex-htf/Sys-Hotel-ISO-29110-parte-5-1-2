<div class="row">
    @foreach($habitaciones as $hab)

        <?php $parameter=$hab->habitacion_id;?>
        <div class="col-lg-2 col-6 p-2">

            @if($hab->estado == 1)
                <div class="card text-bg-success">
                    <div class="card-header d-flex justify-content-between" style="background-color: RGBA(var(--bs-success-rgb), var(--bs-bg-opacity, 1)) !important;">
                        <h6 class="card-title">Disponible</h6>
                        <a  href="{{ url('recepcion_proceso/'.$parameter) }}"><i class="fa-solid fa-circle-arrow-left" style="color:white;"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="card-text text-center p-1" style="font-size: 1.2rem;">
                        <h6>{{$hab->categoria}}</h6>
                            <a style="color:white; text-decoration:none; cursor:pointer;" onclick="getDetalles(<?php echo "'".$parameter."'"; ?>);"><i class="fa-solid fa-bed"></i> {{$hab->habitacion}}</a>
                        </div>
                    </div>
                </div>

            @elseif($hab->estado == 2)
                <div class="card text-bg-danger">
                    <div class="card-header d-flex justify-content-between" style="background-color: RGBA(var(--bs-danger-rgb), var(--bs-bg-opacity, 1)) !important;">
                        <h6 class="card-title">Ocupado</h6>
                        <a href="{{ url('proceso_salida/'.$parameter) }}"><i class="fa-solid fa-circle-arrow-right" style="color:white;"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="card-text text-center p-2" style="font-size: 1.2rem;">
                            <h6>{{$hab->categoria}}</h6>
                            <h6>{{$hab->cliente}}</h6>
                        </div>
                    </div>
                </div>

            @elseif($hab->estado == 3)
                <div class="card text-bg-sky">
                    <div class="card-header d-flex justify-content-between" style="background-color: RGBA(var(--bs-sky-rgb), var(--bs-bg-opacity, 1)) !important;">
                        <h6 class="card-title">Limpieza:</h6>
                        <a style="cursor:pointer;" onclick="terminarLimpieza(<?php echo "'".$parameter."'"; ?>);"><i class="fa-solid fa-pump-soap" style="color:white;"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="card-text text-center p-1" style="font-size: 1.2rem;">
                            <h6>{{$hab->categoria}}</h6>
                            <h5>{{$hab->habitacion}}</h5>
                        </div>
                    </div>
                </div>

            @endif

        </div>

    @endforeach
</div>