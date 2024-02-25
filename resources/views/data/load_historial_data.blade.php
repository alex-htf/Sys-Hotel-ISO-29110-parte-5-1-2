<div class="table-responsive">
    <!-- Tabla principal -->
    <table class="table align-middle table-hover m-0">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Habitación</th>
                <th scope="col">Categoría</th>
                <th scope="col">Ubicación</th>
                <th scope="col">Cliente</th>
                <th scope="col">Tipo de Documento</th>
                <th scope="col">Número de Documento</th>
                <th scope="col">Total</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @if(count($dataHistorial) > 0)
            <!-- Inicialización de contador -->
            @php($i = ($dataHistorial->currentPage() - 1) * $dataHistorial->perPage() + 1)
            <!-- @php($i=1)  -->
            @foreach($dataHistorial as $key => $dh)
            <?php $parameter=$dh->proceso_id; ?>
            <tr>
                <td>{{ $i }}</td>
                <td class="font-weight-bold">{{ $dh->habitacion }}</td>
                <td class="text-muted">{{ $dh->categoria }}</td>
                <td class="text-muted">{{ $dh->ubicacion }}</td>
                <td class="text-muted">{{ $dh->cliente }}</td>
                <td class="text-muted">{{ $dh->tipo }}</td>
                <td class="text-muted">{{ $dh->documento }}</td>
                <td class="text-muted">{{ $dh->total }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <!-- Botón para mostrar detalles -->
                        <a data-bs-toggle="collapse" href="#demo{{$i}}" role="button" aria-expanded="false"
                            aria-controls="collapseExample" class="toggle-details">
                            <i class="fas fa-arrow-circle-down" title="Ver más Detalles"
                                style="cursor: pointer; font-size: 24px;"></i>
                        </a>
                    </div>
                </td>
            </tr>

            <!-- Fila de detalles colapsable -->
            <tr class="collapse" id="demo{{$i}}">
                <td colspan="12">
                    <!-- Tabla de detalles -->
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
                                <td>{{ $dh->cant_noches }}</td>
                                <td class="text-muted">{{ $dh->cant_personas }}</td>
                                <td class="text-muted">{{ $dh->observaciones }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <!-- Incremento de contador -->
            @php($i++) 
            @endforeach
            @else

            <tr>
                <td align="center" colspan="9">No se encontraron registros</td>
            </tr>
            @endif

        </tbody>
    </table>
    <!-- Paginación -->
    {{ $dataHistorial->onEachSide(1)->links('partials.my-paginate') }}

</div>

<!-- Script de jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        // Función para cambiar el ícono de "Ver más Detalles"
        $('.toggle-details').click(function () {
            var icon = $(this).find('i');
            if (icon.hasClass('fa-arrow-circle-down')) {
                icon.removeClass('fa-arrow-circle-down').addClass('fa-arrow-circle-up');
            } else {
                icon.removeClass('fa-arrow-circle-up').addClass('fa-arrow-circle-down');
            }
        });
    });
</script>
