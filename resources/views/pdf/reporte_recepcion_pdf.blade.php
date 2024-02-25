<!DOCTYPE html>
<html>

<head>
    <title>
        Comprobante Recepción
    </title>
    <!-- Incluye el archivo CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<style>
    /* Estilos para la tabla */
    table {
        width: 95%;
        border-collapse: collapse;
        margin: 50px auto;
    }

    /* Estilos para filas impares */
    tr:nth-of-type(odd) {
        background: #eee;
    }

    /* Estilos para encabezados de tabla */
    th {
        background: gray;
        color: white;
        font-weight: bold;
        font-size: 14px; /* Tamaño de fuente ajustado */
    }

    /* Estilos para celdas de tabla */
    td,
    th {
        padding: 10px;
        border: 1px solid #ccc;
        text-align: left;
        font-size: 14px; /* Tamaño de fuente ajustado */
    }

    /* Estilos adicionales para encabezados de tabla */
    .tblreporterecepcion th {
        color: #fff !important;
    }
</style>

<body>

    <!-- Encabezado de la página -->
    <div style="width: 100%; margin: 0 auto; display:flex; align-items:center;">
        <div style="width: 10%; float:left; margin-right: 10px;">
            <!-- Logo -->
            <img src='{{ public_path("assets/images/logo.jpeg") }}' width="50px" height="50px" alt="">
        </div>
        <div style="width: 68%; float: left; margin-right: 5px;">
            <!-- Título del reporte -->
            <center>
                <h2>Reporte Recepción</h2>
            </center>
        </div>
        <div style="width: 22%; float: left;">
            <!-- Fecha del reporte -->
            <p style="font-size:12px;">Fecha del Reporte: @php echo date('d/m/Y'); @endphp</p> <!-- Tamaño de fuente ajustado -->
        </div>
    </div>

    <!-- Tabla de reporte -->
    <table style="position: relative; top: 50px;  width: 100%; margin-bottom:20px;" class="tblreporterecepcion">
        <thead>
            <!-- Encabezados de columna -->
            <tr>
                <th class="font-weight-bold" scope="col">#</th>
                <th class="font-weight-bold" scope="col">Habitación</th>
                <th class="font-weight-bold" scope="col">Cliente</th>
                <th class="font-weight-bold" scope="col">Tipo Documento</th>
                <th class="font-weight-bold" scope="col">Documento</th>
                <th class="font-weight-bold" scope="col">Cant. Noches</th>
                <th class="font-weight-bold" scope="col">Cant. Personas</th>
                <th class="font-weight-bold" scope="col">Fecha Entrada</th>
                <th class="font-weight-bold" scope="col">Fecha Salida</th>
                <th class="font-weight-bold" scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @if(count($reporteData) > 0)

            @php($i=1)
            @php($totalreporte=0)
            <!-- Ciclo para mostrar los datos del reporte -->
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
                <td class="font-weight-bold">$ {{ $rd->total }}</td>
            </tr>
            <!-- Cálculo del total del reporte -->
            @php($totalreporte+=$rd->total)
            @php($i++)
            @endforeach
            <!-- Fila para mostrar el total -->
            <tr>
                <td colspan="9" style="text-align:right; background: gray;color: white;font-weight: bold;">
                    <b>Total:</b></td>
                    <td style="text-align:left;">$ {{ number_format($totalreporte, 2, '.', '') }}</td>
            </tr>
            @else
            <!-- Mensaje de no se encontraron datos -->
            <tr>
                <td style="text-align:center;" colspan="10">No se encontraron datos!!</td>
            </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
