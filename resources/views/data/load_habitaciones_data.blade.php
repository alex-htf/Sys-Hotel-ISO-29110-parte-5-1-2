<div class="table-responsive">
    <table class="table align-middle table-hover m-0">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Imagen</th>
                <th scope="col">Habitación</th>
                <th scope="col">Categoría</th>
                <th scope="col">Ubicación</th>
                <th scope="col">Detalle</th>
                <th scope="col">Precio</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @if(count($habitaciones) > 0)
            <!-- Verifica si hay habitaciones para mostrar -->
            @php($i=1)
            <!-- Variable contador para numerar las habitaciones -->
            @foreach($habitaciones as $key => $hab)
            <?php $parameter = $hab->habitacion_id; ?>
            <!-- Asigna el ID de la habitación a la variable $parameter -->
            <tr>
                <td>{{ $i }}</td>
                <!-- Muestra el número de habitación -->
                @if($hab->imagen != "")
                <!-- Verifica si hay una imagen asociada a la habitación -->
                <td><img src="{{ URL::asset('img/habitaciones/'.$hab->imagen) }}" alt="Imagen de Habitación"
                        width="80" class="img-thumbnail"></td>
                <!-- Muestra la imagen de la habitación -->
                @else
                <td><img src="{{ URL::asset('assets/images/bed.png') }}" alt="Imagen de Habitación" width="80"
                        class="img-thumbnail"></td>
                <!-- Si no hay imagen, muestra una imagen predeterminada -->
                @endif
                <td class="font-weight-bold">{{ $hab->habitacion }}</td>
                <!-- Muestra el nombre de la habitación -->
                <td class="font-weight-bold">{{ $hab->categoria }}</td>
                <!-- Muestra la categoría de la habitación -->
                <td class="font-weight-bold">{{ $hab->ubicacion }}</td>
                <!-- Muestra la ubicación de la habitación -->
                <td class="text-muted">{{ $hab->detalles }}</td>
                <!-- Muestra los detalles de la habitación -->
                <td class="text-muted">{{ $hab->precio }}</td>
                <!-- Muestra el precio de la habitación -->
                @if($hab->estado == 1)
                <!-- Verifica si la habitación está disponible -->
                <td><label class="badge bg-success">Disponible</label></td>
                <!-- Muestra una etiqueta indicando que la habitación está disponible -->
                @elseif($hab->estado == 2)
                <!-- Si la habitación no está disponible -->
                <td><label class="badge bg-danger">Ocupado</label></td>
                <!-- Muestra una etiqueta indicando que la habitación está ocupada -->
                @endif
                <td>
                    <div class="btn-group" role="group">
                        <!-- Grupo de botones de acciones -->
                        <i class="fas fa-edit text-muted" onclick="mostrarHabitacion('<?php echo $parameter; ?>')" title="Editar Habitación" style="cursor: pointer; font-size: 24px;"></i>
                        <!-- Botón para editar la habitación -->
                        &nbsp;
                        &nbsp;
                        <i class="fas fa-trash-alt text-muted" onclick="eliminarHabitacion('<?php echo $parameter; ?>')" title="Eliminar Habitación" style="cursor: pointer; font-size: 24px;"></i>
                        <!-- Botón para eliminar la habitación -->
                    </div>
                </td>
            </tr>
            @php($i++)
            <!-- Incrementa el contador de habitaciones -->
            @endforeach
            @else
            <!-- Si no hay habitaciones para mostrar -->
            <tr>
                <td align="center" colspan="9">No se encontraron registros</td>
                <!-- Muestra un mensaje indicando que no se encontraron habitaciones -->
            </tr>
            @endif
        </tbody>
    </table>
    {{ $habitaciones->onEachSide(1)->links('partials.my-paginate') }}
    <!-- Muestra la paginación de las habitaciones -->
</div>
