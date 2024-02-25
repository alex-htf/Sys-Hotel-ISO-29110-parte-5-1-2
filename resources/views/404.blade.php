@extends('master')
@section('content')

<!-- App hero header starts -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <b><span>Página No Encontrada</span></b>
    </h3>
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-ban"></i> Página no Encontrada</li>
        </ol>
    </nav>
</div>
<!-- App Hero header ends -->

<div class="app-body" style="margin-top:-8.5rem !important;height: calc(103vh - 202px);">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex justify-content-center">
                    <div class="card-body text-center">
                        <h2 class="mt-4 mb-4">Lo Sentimos</h2>
                        <img class="img-fluid" src="{{asset('assets/images/404.png')}}" alt="Página No Encontrada" title="Página No Encontrada" style="width: 268px; height: auto; transition: all 0.25s ease 0s;" />
                        <p class="mt-4 mb-4" style="font-size:24px;">No hemos podido encontrar el contenido que estas buscando</p>
                        <a class="btn btn-dark btn-lg bradius mt-4" href="{{ url('/') }}">Volver al Inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection