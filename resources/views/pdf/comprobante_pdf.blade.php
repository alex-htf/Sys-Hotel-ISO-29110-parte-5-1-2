<!DOCTYPE html>
<html>
<head>
    <title> 
        Comprobante Recepción
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>
<style>
    table {
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
    }
</style>
<body>

  

    <div class="container-fluid">


        <div class="d-flex">

            <p style="font-size:12px;">Fecha del comprobante: @php echo date('m/d/Y h:s:i'); @endphp</p>

        </div>

        <hr>
      
        <div style="width: 100%; margin: 0 auto;text-align:center;">
            <img src='{{ public_path("assets/images/logo.jpeg") }}' width="180px" height="180px" style="margin-right:auto; margin-left:auto;" alt="">
        </div>

        <div style="width: 100%; margin: 0 auto;">
            <h6><b>DETALLES:</b></h6>
            <p style="font-size:22px;">Comprobante de Pago</p>
            <p>Fecha de Ingreso: {{$diaIngreso}} de {{$mesIngresoEspañol}} del {{$añoIngreso}}</p>
            <p>Fecha de Salida: {{$diaSalida}} de {{$mesSalidaEspañol}} del {{$añoSalida}}</p>
        </div>

        <div style="width: 100%; margin-top:25px;">
            <div style="width: 50%; float:left; margin-right: 20px; border-right:1px solid #000">
                <h6>DATOS DE LA EMPRESA</h6>
                <p>HOTEL: {{$nombreHotel->valor}}</p>
                <p>RUC: {{$rucHotel->valor}}</p>
                <p>DIRECCION: {{$direccionHotel->valor}}</p>
                <p>TELEFONO: {{$telHotel->valor}}</p>
                <p>EMAIL: {{$emailHotel->valor}}</p>
            </div>
            <div style="width: 50%; float: left; margin-right: 5px;">
                <h6>CLIENTE</h6>
                <p>Nombre: {{$dataFactura->cliente}}</p>
                {{-- <p>Razón Social: {{$dataFactura->razon_social}}</p> --}}
                
                <!-- @if($dataFactura->tipo_comprobante == 1)
                    <p>Nombre: {{$dataFactura->razon_social}}</p>
                @elseif($dataFactura->tipo_comprobante == 2)
                    <p>Nombre: {{$dataFactura->cliente}}</p>
                @elseif($dataFactura->tipo_comprobante == 3)
                    <p>Nombre: {{$dataFactura->cliente}}</p>
                @endif
                 -->
                <p>Documento: {{$dataFactura->tipo}} - {{$dataFactura->documento}}</p>
                <p>Direccion: {{$dataFactura->direccion}}</p>
                <p>Teléfono: {{$dataFactura->telefono}}</p>
            </div>
        </div>


        <div  style="width: 100%; margin-top: 215px">

            <table style="width: 100%;" border="1">
                <thead>
                    <tr>
                        <th scope="col" style="background-color:#9098A2;">#</th>
                        <th scope="col" colspan="3" style="background-color:#9098A2;">Costo de Alojamiento</th>
                    </tr>
                    <tr>
                        <th scope="col" style="font-size:13px;text-align:center; vertical-align:middle;">CANT.</th>
                        <th scope="col" style="font-size:13px;text-align:center; vertical-align:middle;">DESCRIPCION</th>
                        <th scope="col" style="font-size:13px;text-align:center; vertical-align:middle;">P.UNITARIO</th>
                        <th scope="col" style="font-size:13px;text-align:center; vertical-align:middle;">IMPORTE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td align="center">1</td>
                        <td align="center">Alojamiento de la habitación {{$dataFactura->habitacion}}</td>
                        <td align="center">$ {{$dataFactura->total}}</td>
                        <td align="center">$ {{$dataFactura->total}}</td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%;" border="1">
                <tbody>
                    <tr>
                        <td style="background-color:#9098A2;" align="center" colspan="1"><p style="font-size:14px; margin-bottom:1px;"><b>TOTAL</b></p> </td>
                        <td align="center">$ <?php echo round($dataFactura->total,2) ?></td>
                    </tr>
                </tbody>
            </table>


        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>