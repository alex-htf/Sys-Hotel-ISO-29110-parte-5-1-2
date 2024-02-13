<!DOCTYPE html>
<html>
<head>
    <title> 
        Comprobante Recepción
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>
<style>
    /* table {
    border-collapse: collapse;
    }
    table td, table th {
    border: 1px solid black;
    }
    table tr:first-child th {
    border-top: 0;
    }
    table tr:last-child td {
    border-bottom: 0;
    }
    table tr td:first-child,
    table tr th:first-child {
    border-left: 0;
    }
    table tr td:last-child,
    table tr th:last-child {
    border-right: 0;
    } */
    table {
            width: 95%;
            border-collapse: collapse;
            margin: 50px auto;
        }

        /* Zebra striping */
        tr:nth-of-type(odd) {
            background: #eee;
        }

        th {
            background: gray;
            color: white;
            font-weight: bold;
        }

        td,
        th {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 18px;
        }

        .tblreporterecepcion th
        {
            color: #fff !important;
        }
</style>
<body>
     
    <div style="width: 100%; margin: 0 auto; display:flex; align-items:center;">
        <div style="width: 10%; float:left; margin-right: 10px;">
            <img src='{{ public_path("assets/images/logo.jpeg") }}'  width="50px" height="50px"  alt="">
        </div>
        <div style="width: 68%; float: left; margin-right: 5px;">
            <center><h2>Reporte Recepción</h2></center>
        </div>
        <div style="width: 22%; float: left;">
            <p style="font-size:12px;">Fecha del Reporte: @php echo date('m/d/Y'); @endphp</p>
        </div>
    </div>

    <table style="position: relative; top: 50px;  width: 100%; margin-bottom:20px;" class="tblreporterecepcion">
        <thead>
            <tr>
                <th scope="col" style="font-size:12px">#</th>
                <th scope="col" style="font-size:12px">Habitación</th>
                <th scope="col" style="font-size:12px">Cliente</th>
                <th scope="col" style="font-size:12px">Tipo Documento</th>
                <th scope="col" style="font-size:12px">Documento</th>
                <th scope="col" style="font-size:12px">Cant. Noches</th>
                <th scope="col" style="font-size:12px">Cant. Personas</th>
                <th scope="col" style="font-size:12px">Fecha Entrada</th>
                <th scope="col" style="font-size:12px">Fecha Salida</th>
                <th scope="col" style="font-size:12px">Estado Pago</th>
                <th scope="col" style="font-size:12px">Tipo Pago</th>
                <th scope="col" style="font-size:12px">Importe</th>
            </tr>
        </thead>
        <tbody>
            @if(count($reporteData) > 0)

                @php($i=1)       
                @php($totalreporte=0)            
                @foreach($reporteData as $key => $rd)
                    <tr>
                        <td style="font-size:12px">{{ $i }}</td>
                        <td class="font-weight-bold" style="font-size:12px">{{ $rd->habitacion }}</td>
                        <td class="font-weight-bold" style="font-size:12px">{{ $rd->cliente }}</td>
                        <td class="font-weight-bold" style="font-size:12px">{{ $rd->tipo }}</td>
                        <td class="font-weight-bold" style="font-size:12px">{{ $rd->documento }}</td>
                        <td class="font-weight-bold" style="font-size:12px">{{ $rd->cant_noches }}</td>
                        <td class="font-weight-bold" style="font-size:12px">{{ $rd->cant_personas }}</td>
                        <td class="font-weight-bold" style="font-size:12px">{{ $rd->fecha_entrada }}</td>
                        <td class="font-weight-bold" style="font-size:12px">{{ $rd->fecha_salida }}</td>
                        @if($rd->estado_pago == 1)
                            <td class="font-weight-bold" style="color: green;font-weight:bold;font-size:10px;">PAGADO</td>
                        @else 
                            <td class="font-weight-bold" style="color: red;font-weight:bold;font-size:10px;">FALTA PAGAR</td>
                        @endif
                        <td class="font-weight-bold" style="font-size:12px">{{ $rd->pago }}</td>
                        <td class="font-weight-bold" style="font-size:12px"> {{ $rd->total }}</td>
                    </tr>
                    @php($totalreporte+=$rd->total)
                    @php($i++)
                @endforeach
                <tr>
                    <td colspan="11" style="text-align:right; vertical-align:middle; background: gray;color: white;font-weight: bold;"><b>Total:</b></td>
                    <td style="text-align:left; vertical-align:middle;">{{$totalreporte}}</td>
                </tr>

            @else 
                <tr>
                    <td style="text-align:center; vertical-align:middle;" colspan="12">No se encontraron datos!!</td>
                </tr>

            @endif
        </tbody>
    </table>

</body>