<div class="table-responsive">
    <!-- Tabla receptiva para mostrar datos -->
    <table class="table align-middle table-hover m-0">
        <thead>
            <!-- Encabezados de columna -->
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
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            <!-- Verificar si hay datos en el reporte -->
            @if(count($reporteData) > 0)
            <!-- Inicialización de variables -->
            @php($i=1)
            @php($totalreporte=0)
            <!-- Iteración sobre los datos del reporte -->
            @foreach($reporteData as $key => $rd)
            <tr>
                <!-- Número de fila -->
                <td>{{ $i }}</td>
                <td class="font-weight-bold">{{ $rd->habitacion }}</td>
                <td class="font-weight-bold">{{ $rd->cliente }}</td>
                <td class="font-weight-bold">{{ $rd->tipo }}</td>
                <td class="font-weight-bold">{{ $rd->documento }}</td>
                <td class="font-weight-bold">{{ $rd->cant_noches }}</td>
                <td class="font-weight-bold">{{ $rd->cant_personas }}</td>
                <td class="font-weight-bold">{{ $rd->fecha_entrada }}</td>
                <td class="font-weight-bold">{{ $rd->fecha_salida }}</td>
                <td class="font-weight-bold">{{ $rd->total }}</td>
            </tr>
            <!-- Actualización del total del reporte -->
            @php($totalreporte+=$rd->total)
            @php($i++)
            @endforeach
            <!-- Fila para mostrar el total -->
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="font-weight-bold" style="font-size: 18px; text-align: center;"><b>Total:</b></td>
                <td class="font-weight-bold" style="font-size: 18px;"><b>{{ number_format($totalreporte, 2, '.', '') }}</b></td>
            </tr>
            <!-- Fin de verificación de datos en el reporte -->
            @else
            <!-- Mensaje si no hay datos en el reporte -->
            <tr>
                <td style="text-align:center; vertical-align:middle;" colspan="10">No se encontraron datos!!</td>
            </tr>
            <!-- Fin de la condición de datos en el reporte -->
            @endif
        </tbody>
    </table>
</div>
