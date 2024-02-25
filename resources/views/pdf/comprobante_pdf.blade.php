<!DOCTYPE html>
<html>

<head>
    <title>
        Comprobante Recepción
    </title>
    <!-- Se incluye el estilo de Bootstrap para el diseño -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>
<!-- Estilos CSS personalizados para las tablas -->
<style>
    table {
        border-collapse: collapse;
    }

    table td,
    table th {
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
    <!-- Contenedor principal con diseño fluido -->
    <div class="container-fluid">
        <!-- Sección para la fecha del comprobante -->
        <div class="d-flex">
            <!-- Fecha del comprobante generada dinámicamente con PHP -->
            <p style="font-size:12px;">Fecha del comprobante: {{ date('d/m/Y H:i:s', strtotime(now())) }}</p>
        </div>
        <hr>
        <!-- Sección para el logo del hotel -->
        <div style="width: 100%; margin: 0 auto;text-align:center;">
            <img src='{{ public_path("assets/images/logo.jpeg") }}' width="180px" height="180px"
                style="margin-right:auto; margin-left:auto;" alt="">
        </div>
        <!-- Sección para los detalles del comprobante -->
        <div style="width: 100%; margin: 0 auto;">
            <h6><b>DETALLES:</b></h6>
            <p style="font-size:22px;">Comprobante de Pago</p>
            <p>Fecha de Ingreso: {{$diaIngreso}} de {{$mesIngresoEspañol}} del {{$añoIngreso}}</p>
            <p>Fecha de Salida: {{$diaSalida}} de {{$mesSalidaEspañol}} del {{$añoSalida}}</p>
        </div>

        <!-- Sección para los datos de la empresa y el cliente -->
        <div style="width: 100%; margin-top:25px;">
            <!-- Datos de la empresa -->
            <div style="width: 50%; float:left; margin-right: 20px; border-right:1px solid #000">
                <h6>DATOS DE LA EMPRESA</h6>
                <p>HOTEL: {{$nombreHotel->valor}}</p>
                <p>RUC: {{$rucHotel->valor}}</p>
                <p>DIRECCION: {{$direccionHotel->valor}}</p>
                <p>TELEFONO: {{$telHotel->valor}}</p>
                <p>EMAIL: {{$emailHotel->valor}}</p>
            </div>
            <!-- Datos del cliente -->
            <div style="width: 50%; float: left; margin-right: 5px;">
                <h6>CLIENTE</h6>
                <p>Nombre: {{$dataFactura->cliente}}</p>
                <p>Documento: {{$dataFactura->tipo}} - {{$dataFactura->documento}}</p>
                <p>Direccion: {{$dataFactura->direccion}}</p>
                <p>Teléfono: {{$dataFactura->telefono}}</p>
            </div>
        </div>

        <!-- Sección para la tabla de costos de alojamiento -->
<div style="width: 100%; margin-top: 215px">
    <!-- Tabla para mostrar los costos de alojamiento -->
    <table style="width: 100%;" border="1">
        <thead>
            <tr>
                <!-- Encabezados de la tabla -->
                <th scope="col" style="background-color:#9098A2; text-align: center;">#</th>
                <th scope="col" colspan="2" style="background-color:#9098A2; text-align: center;">Costo de
                    Alojamiento</th>
            </tr>
            <tr>
                <!-- Detalles de las columnas -->
                <th scope="col" style="font-size:13px;text-align:center; vertical-align:middle;">CANT.</th>
                <th scope="col" style="font-size:13px;text-align:center; vertical-align:middle;">DESCRIPCION</th>
                <th scope="col" style="font-size:13px;text-align:center; vertical-align:middle;">P. UNITARIO</th>
            </tr>
        </thead>
       <tbody> 
            <tr>
                <!-- Detalles de los costos de alojamiento -->
                <td align="center">1</td>
                <td align="center">Alojamiento de la habitación {{$dataFactura->habitacion}}</td>
                <td align="center">$ {{$dataFactura->total}}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <!-- Encabezado y total -->
                <th scope="col" colspan="2" style="background-color:#9098A2; text-align: center;"><p style="font-size:14px; margin-bottom:1px;"><b>TOTAL</b></p></th>
                <!-- Total calculado -->
                <th scope="col" style="background-color:#9098A2; text-align: center;">$ <?php echo number_format($dataFactura->total, 2, '.', ''); ?></th>
                
            </tr>
        </tfoot>
    </table>
</div>

    <!-- Se incluye el script de Bootstrap para funcionalidades adicionales -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>