<div class="table-responsive">
    <table class="table align-middle table-hover m-0">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Habitación</th>
                <th scope="col">Cliente</th>
                <th scope="col">Tipo Documento</th>
                <th scope="col">Documento</th>
                <th scope="col">Cant. Noches</th>
                <th scope="col">Cant. Personas</th>
                <th scope="col">Fecha Entrada</th>
                <th scope="col">Fecha Salida</th>
                <th scope="col">Estado Pago</th>
                <th scope="col">Tipo Pago</th>
                <th scope="col">Importe</th>
            </tr>
        </thead>
        <tbody>
            @if(count($reporteData) > 0)

                @php($i=1)       
                @php($totalreporte=0)            
                @foreach($reporteData as $key => $rd)
                    <tr>
                        <td>{{ $i }}</td>
                        <td class="font-weight-bold">{{ $rd->habitacion }}</td>
                        <td class="font-weight-bold">{{ $rd->cliente }}</td>
                        <td class="font-weight-bold">{{ $rd->tipo }}</td>
                        <td class="font-weight-bold">{{ $rd->documento }}</td>
                        <td class="font-weight-bold">{{ $rd->cant_noches }}</td>
                        <td class="font-weight-bold">{{ $rd->cant_personas }}</td>
                        <td class="font-weight-bold">{{ $rd->fecha_entrada }}</td>
                        <td class="font-weight-bold">{{ $rd->fecha_salida }}</td>
                        @if($rd->estado_pago == 1)
                            <td class="font-weight-bold" style="color: green;font-weight:bold;">PAGADO</td>
                        @else 
                            <td class="font-weight-bold" style="color: red;font-weight:bold;">FALTA PAGAR</td>
                        @endif
                        <td class="font-weight-bold">{{ $rd->pago }}</td>
                        <td class="font-weight-bold">{{ $rd->total }}</td>
                    </tr>
                    @php($totalreporte+=$rd->total)
                    @php($i++)
                @endforeach
                <tr>
                    <td colspan="10" style="text-align:right; vertical-align:middle;"><b>Total:</b></td>
                    <td colspan="2" style="text-align:left; vertical-align:middle;">{{$totalreporte}}</td>
                </tr>

            @else 
                <tr>
                    <td style="text-align:center; vertical-align:middle;" colspan="13">No se encontraron datos!!</td>
                </tr>

            @endif
        </tbody>
    </table>


</div>
