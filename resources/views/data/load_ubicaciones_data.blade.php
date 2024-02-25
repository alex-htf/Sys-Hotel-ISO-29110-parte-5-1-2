<div class="table-responsive">
    <table class="table align-middle table-hover m-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Ubicación</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Verificar si hay ubicaciones disponibles -->
            @if(count($ubicaciones) > 0)
            <!-- Inicializar contador para el número de ubicación -->
            @php($i=1)
            <!-- Recorrer todas las ubicaciones -->
            @foreach($ubicaciones as $key => $ubi)
            <!-- Obtener el ID de la ubicación -->
            <?php $parameter=$ubi->ubicacion_id;?>
            <tr>
                <!-- Mostrar el número de la ubicación -->
                <td>{{ $i }}</td>
                <!-- Mostrar el nombre de la ubicación -->
                <td class="font-weight-bold">{{ $ubi->ubicacion }}</td>
                <!-- Verificar si la ubicación está activa -->
                @if($ubi->estado != 0)
                <!-- Mostrar etiqueta de estado activo -->
                <td><label class="badge bg-success">Activo</label></td>
                @else
                <!-- Mostrar etiqueta de estado inactivo -->
                <td><label class="badge bg-danger">Inactivo</label></td>
                @endif
                <td>
                    <div class="btn-group" role="group">
                        <!-- Botón para editar la ubicación -->
                        <i class="fas fa-edit text-muted" onclick="mostrarUbicacion(<?php echo "'".$parameter."'"; ?>)" title="Editar Ubicación" style="cursor: pointer; font-size: 24px;"></i>
                        &nbsp;
                        &nbsp;
                        <!-- Botón para eliminar la ubicación -->
                        <i class="fas fa-trash-alt text-muted" onclick="eliminarUbicacion(<?php echo "'".$parameter."'"; ?>)" title="Eliminar Ubicación" style="cursor: pointer; font-size: 24px;"></i>
                        &nbsp;
                        &nbsp;
                        <!-- Botón para desactivar la ubicación si está activa -->
                        @if($ubi->estado != 0)
                            <i class="fas fa-toggle-on text-muted" onclick="desactivarUbicacion(<?php echo "'".$parameter."'"; ?>)" title="Desactivar Ubicación" style="cursor: pointer; font-size: 24px;"></i>
                            &nbsp;
                            &nbsp;
                        <!-- Botón para activar la ubicación si está inactiva -->
                        @else
                            <i class="fas fa-toggle-off text-muted" onclick="activarUbicacion(<?php echo "'".$parameter."'"; ?>)" title="Activar Ubicación" style="cursor: pointer; font-size: 24px;"></i>
                        @endif
                    </div>
                </td>
            </tr>
            <!-- Incrementar el contador de número de ubicación -->
            @php($i++)
            @endforeach
            @else
            <!-- Mostrar mensaje si no hay ubicaciones disponibles -->
            <tr>
                <td align="center" colspan="4">No se encontraron registros</td>
            </tr>
            @endif
        </tbody>
    </table>
    <!-- Paginación -->
    {{ $ubicaciones->onEachSide(1)->links('partials.my-paginate') }}
</div>
