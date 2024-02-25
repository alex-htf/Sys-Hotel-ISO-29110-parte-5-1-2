<div class="table-responsive">
    <table class="table align-middle table-hover m-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Categoría</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @if(count($categorias) > 0)
            @php($i=1)
            @foreach($categorias as $key => $cat)
            <?php $parameter=$cat->categoria_id;?>
            <tr>
                <td>{{ $i }}</td>
                <td class="font-weight-bold">{{ $cat->categoria }}</td>
                <td class="text-muted">{{ $cat->descripcion }}</td>
                @if($cat->estado != 0)
                <td><label class="badge bg-success">Activo</label></td>
                @else
                <td><label class="badge bg-danger">Inactivo</label></td>
                @endif
                <td>
                    <div class="btn-group" role="group">
                        <!-- Botón de editar categoría -->
                        <i class="fas fa-edit text-muted" onclick="mostrarCategoria(<?php echo "'".$parameter."'"; ?>)"title="Editar Categoría" style="cursor: pointer; font-size: 24px;"></i>
                        &nbsp;
                        &nbsp;
                        <!-- Botón de eliminar categoría -->
                        <i class="fas fa-trash-alt text-muted" onclick="eliminarCategoria(<?php echo "'".$parameter."'"; ?>)"title="Eliminar Categoría" style="cursor: pointer; font-size: 24px;"></i>
                        &nbsp;
                        &nbsp;
                            <!-- Botón de desactivar categoría -->
                        @if($cat->estado != 0)
                            <i class="fas fa-toggle-on text-muted" onclick="desactivarCategoria(<?php echo "'".$parameter."'"; ?>)" title="Desactivar Categoría" style="cursor: pointer; font-size: 24px;"></i>
                            &nbsp;
                            &nbsp;
                        @else
                            <!-- Botón de activar categoría -->
                            <i class="fas fa-toggle-off text-muted" onclick="activarCategoria(<?php echo "'".$parameter."'"; ?>)" title="Activar Categoría" style="cursor: pointer; font-size: 24px;"></i>
                        @endif
                    </div>
                </td>
            </tr>
            @php($i++)
            @endforeach
            @else
            <!-- Mostrar mensaje si no se encontraron registros -->
            <tr>
                <td align="center" colspan="5">No se encontraron registros</td>
            </tr>
            @endif
        </tbody>
    </table>
    <!-- Paginación -->
    {{ $categorias->onEachSide(1)->links('partials.my-paginate') }}
</div>