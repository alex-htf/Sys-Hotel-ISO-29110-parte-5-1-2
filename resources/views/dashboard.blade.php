@extends('master')

@section('content')
<!-- App hero header starts -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        Hola usuario: <b>{{Auth::user()->usuario}}</b>
    </h3>
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
        </ol>
    </nav>

</div>
<!-- App Hero header ends -->


<!-- App body starts -->
<div class="app-body">
    <!-- Row start -->
    <div class="row">

        <div class="col-lg-4 col-6">
            <div class="small-box bg-info das-box">
                <div class="inner">
                    <h3>{{$totalHabitaciones}}</h3>
                    <p>Habitaciones Registradas</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-bed-pulse"></i>
                </div>
                <a href="{{url('habitaciones')}}" class="small-box-footer">
                    <strong>Ver más</strong>
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-success das-box">
                <div class="inner">
                    <h3>{{$totalHabitacionesdisponibles}}</h3>
                    <p>Habitaciones Disponibles</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-bed-pulse"></i>
                </div>
                <a href="{{url('habitaciones')}}" class="small-box-footer">
                    <strong>Ver más</strong>
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-danger das-box">
                <div class="inner">
                    <h3>{{$totalHabitacionesocupadas}}</h3>
                    <p>Habitaciones Ocupadas</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-bed-pulse"></i>
                </div>
                <a href="{{url('habitaciones')}}" class="small-box-footer">
                    <strong>Ver más</strong>
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- <div class="col-lg-4 col-6">
            <div class="small-box text-bg-sky das-box">
                <div class="inner">
                    <h3>{{$totalHabitacioneslimpieza}}</h3>
                    <p>Habitaciones en Limpieza</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-bed-pulse"></i>
                </div>
                <a href="{{url('habitaciones')}}" class="small-box-footer">
                    <strong>Ver más</strong>
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div> -->


    </div>
    <!-- Row end -->


</div>
<!-- App body ends -->

@endsection