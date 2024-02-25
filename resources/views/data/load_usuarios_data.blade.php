<div class="table-responsive">
    <!-- Tabla para mostrar los usuarios -->
    <table class="table">
        <thead>
            <!-- Encabezados de la tabla -->
            <tr>
                <th width="20%">Nombres Completos</th>
                <th width="20%">Email</th>
                <th width="15%">Dirección</th>
                <th width="10%">Teléfono</th>
                <th width="10%">Usuario</th>
                <th width="8%">Foto</th>
                <th width="5%">Editar</th>
            </tr>
        </thead>
        <tbody>
            <!-- Comprueba si hay usuarios -->
            @if(count($usuarios) > 0)
            <!-- Inicia el contador -->
            @php($i=1)
            <!-- Iteración sobre cada usuario -->
            @foreach($usuarios as $key => $usu)
            <!-- Obtiene el ID del usuario encriptado -->
            <?php $encrypUserId=$usu->user_id;?>
            <!-- Fila de la tabla para cada usuario -->
            <tr>  
                <td class="font-weight-bold">{{ $usu->apellidos }} {{ $usu->nombres }}</td>
                <td class="text-muted">{{ $usu->email }}</td>
                <td>{{ $usu->direccion }}</td>
                <td>{{ $usu->telefono }}</td>
                <td>{{ $usu->usuario}}</td>
                <!-- Foto del usuario, si está disponible -->
                @if($usu->foto!= '')
                <td><img src="{{URL::asset('img/usuarios/'.$usu->foto)}}" alt="Foto Usuario" width="80"
                        class="img-thumbnail"></td>
                @else
                <!-- Si no hay foto, se muestra una imagen predeterminada -->
                <td><img src="{{URL::asset('assets/images/profile.png')}}" alt="Foto Usuario" width="60"
                        class="img-thumbnail"></td>
                @endif
                <!--  disponibles para elAcciones usuario (editar) -->
                <td>
                <div class="btn-group" role="group">
                    <a href="{{ route('usuarios.edit',$encrypUserId) }}" title="Editar Usuario"><i class="fas fa-edit text-muted" style="cursor: pointer; font-size: 24px;"></i></a>
                    &nbsp;
                </div>
                </td>
            </tr>
            <!-- Incrementa el contador -->
            @php($i++)
            @endforeach
            <!-- Si no hay usuarios, muestra un mensaje -->
            @else
            <tr>
                <td align="center" colspan="9">No se encontraron registros</td>
            </tr>
            @endif
        </tbody>
    </table>
    <!-- Paginación de los usuarios -->
    {{ $usuarios->onEachSide(1)->links('partials.my-paginate') }}
</div>
