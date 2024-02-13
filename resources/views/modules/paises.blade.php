@extends('master')

@section('content')

    <div class="table-responsive">
        <table class="table">
            <thead>
                <th>#</th>
                <th>Pais</th>
                <th>Estado</th>
            </thead>
            <tbody>
                @foreach($paises as $pais)
                    <tr>
                        <td>{{$pais->pais_id}}</td>
                        <td>{{$pais->pais}}</td>
                        <td>{{$pais->estado}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection


modelo y las rutas