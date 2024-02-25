<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Tipo Documento</th>
                <th>Nro Documento</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @if(count($clientes) > 0)
            @php($i=1)
            @foreach($clientes as $key => $cli)
            <?php $param=$cli->persona_id;?>
            <tr>
                <td>{{ $i }}</td>
                <td class="font-weight-bold">{{ $cli->tipo_documento }}</td>
                <td class="text-muted">{{ $cli->documento }}</td>
                <td>{{ $cli->nombre }}</td>
                <td>{{ $cli->direccion }}</td>
                <td>{{ $cli->telefono }}</td>
                <td>{{ $cli->email }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <!-- Botón de editar cliente con ícono Font Awesome -->
                        <button type="button" class="btn btn-link text-muted"
                            onclick="mostrarCliente(<?php echo "'".$param."'"; ?>)" title="Editar Cliente">
                            <i class="fas fa-edit" style="cursor: pointer; font-size: 24px;"></i>
                        </button>
                    </div>

                </td>
            </tr>
            @php($i++)
            @endforeach
            @else
            <!-- Mostrar si no se encuentran registros -->
            <tr>
                <td align="center" colspan="8">No se encontraron registros</td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- Paginación -->
    {{ $clientes->onEachSide(1)->links('partials.my-paginate') }}
</div>