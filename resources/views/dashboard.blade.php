@extends('master')

@section('content')

<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">Hola usuario:  <b>{{Auth::user()->usuario}}</b></h3>
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i>Inicio</a></li>
        </ol>
    </nav>
</div>

<div class="app-body">
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
                    <i class="fas fa-list"></i>
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
                    <i class="fas fa-list"></i>
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
                    <i class="fas fa-list"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection