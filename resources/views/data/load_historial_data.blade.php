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
            @if(count($dataHistorial) > 0)

                @php($i=1)                 
                @foreach($dataHistorial as $key => $dh)
                <?php $parameter=$dh->proceso_id;?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td class="font-weight-bold">{{ $dh->habitacion }}</td>
                        <td class="text-muted">{{ $dh->categoria }}</td>
                        <td class="text-muted">{{ $dh->ubicacion }}</td>
                        <td class="text-muted">{{ $dh->cliente }}</td>
                        <td class="text-muted">{{ $dh->tipo }}</td>
                        <td class="text-muted">{{ $dh->documento }}</td>
                        <td class="text-muted">{{ $dh->total }}</td>
                        @if($dh->estado_pago == 1)
                            <td><label class="badge bg-success">Pagado</label></td>
                        @elseif($dh->estado_pago == 2)
                           <td><label class="badge bg-danger">Falta Pagar</label></td>
                        @endif
                       
                        <td>
                            <div class="btn-group" role="group">
                              
                                <a data-bs-toggle="collapse" href="#demo{{$i}}" role="button" aria-expanded="false" aria-controls="collapseExample"><img src="{{ url('assets/images/more.png') }}" title="Ver más Detalles" style="cursor: pointer; height:24px; width:24px;"></a>
                 
                                @if($dh->estado == 0)
                                    <a href="{{ route('comprobante_pdf', ['proceso_id' => $dh->proceso_id]) }}" target="_blank" id="btnImprimir" style="border-radius:120px" title="Imprimir Comprobante"><span class="icon text-white-50"><img src="{{ url('assets/images/print.png') }}" width="24px"></span></a>
                                @endif
                                
                            
                            </div>
                        </td>
                    </tr>

                    <tr class="collapse" id="demo{{$i}}">
                        <td colspan="12">
                           
                                <table class="table align-middle table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Fecha de Entrada</th>
                                            <th scope="col">Fecha de Salida</th>
                                            <th scope="col">Cant.Noches</th>
                                            <th scope="col">Cant.Personas</th>
                                            <th scope="col">Observaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-muted">{{ $dh->fecha_entrada }}</td>
                                            <td class="text-muted">{{ $dh->fecha_salida }}</td>
                                            <th scope="row">{{ $dh->cant_noches }}</th>
                                            <td class="text-muted">{{$dh->cant_personas}}</td>
                                            <td class="text-muted">{{$dh->observaciones}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                        </td>
                    </tr>

                    @php($i++)
                @endforeach

            @else 
            
                <tr>
                    <td align="center" colspan="10">No se encontraron registros</td>
                </tr>

            @endif
    
        </tbody>
    </table>


    {{ $dataHistorial->onEachSide(1)->links('partials.my-paginate') }}

</div>
