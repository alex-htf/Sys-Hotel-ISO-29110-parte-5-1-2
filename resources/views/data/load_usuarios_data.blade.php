<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th width="20%">Nombres Completo</th>
            <th width="5%">Email</th>
            <th width="10">Dirección</th>
            <th width="10">Teléfono</th>
            <th width="10">Usuario</th>
            <th>Foto</th>
            <th width="7%">Estado</th>
            <th width="10%">Acciones</th>
        </tr>
        </thead>
        <tbody>
            @if(count($usuarios) > 0)

                @php($i=1)                 
                @foreach($usuarios as $key => $usu)
                <?php $encrypUserId=$usu->user_id;?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td class="font-weight-bold">{{ $usu->apellidos }} {{ $usu->nombres }}</td>
                        <td class="text-muted">{{ $usu->email }}</td>
                        <td>{{ $usu->direccion }}</td>
                        <td>{{ $usu->telefono }}</td>
                        <td>{{ $usu->usuario}}</td>
                        @if($usu->foto!= '')
                        <td><img src="{{URL::asset('img/usuarios/'.$usu->foto)}}" alt="Foto Usuario" width="80" class="img-thumbnail"></td>
                        @else 
                        <td><img src="{{URL::asset('assets/images/profile.png')}}" alt="Foto Usuario" width="60" class="img-thumbnail"></td>
                        @endif

                        @if($usu->estado!=0)
                            <td><label class="badge bg-success">Activo</label></td>
                        @else 
                            <td><label class="badge bg-danger">Inactivo</label></td>
                        @endif

                        <td>
                            <div class="btn-group" role="group">
                               
                                <a href="{{ route('usuarios.edit',$encrypUserId) }}"><img src="{{ url('assets/images/edit.png') }}" title="Editar Usuario" style="cursor: pointer; height:24px; width:24px;"></a>
              
                                
      
                                <img src="{{ url('assets/images/delete.png') }}" onclick="eliminarUsuario(<?php echo "'".$encrypUserId."'"; ?>)" title="Eliminar Usuario" style="cursor: pointer; height:24px; width:24px;">
           
                                
                                @if($usu->estado!=0)
                                
                                        <img src="{{ url('assets/images/off.png') }}" onclick="desactivarUsuario(<?php echo "'".$encrypUserId."'"; ?>)" title="Desactivar Usuario" style="cursor: pointer; height:24px; width:24px;">&nbsp;
                               
                                @else 
                    
                                        <img src="{{ url('assets/images/check.png') }}" onclick="activarUsuario(<?php echo "'".$encrypUserId."'"; ?>)" title="Activar Usuario" style="cursor: pointer; height:24px; width:24px;">&nbsp;
                     
                                @endif
                            </div>
                        </td>
                    </tr>

                    @php($i++)
                @endforeach

            @else 
            
                <tr>
                    <td align="center" colspan="9">No se encontraron registros</td>
                </tr>

            @endif
    
        </tbody>
    </table>

    {{ $usuarios->onEachSide(1)->links('partials.my-paginate') }}

</div>