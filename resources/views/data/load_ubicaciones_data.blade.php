<div class="table-responsive">
    <table class="table align-middle table-hover m-0">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Ubicación</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @if(count($ubicaciones) > 0)

                @php($i=1)                 
                @foreach($ubicaciones as $key => $ubi)
                <?php $parameter=$ubi->ubicacion_id;?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td class="font-weight-bold">{{ $ubi->ubicacion }}</td>
                        @if($ubi->estado!=0)
                            <td><label class="badge bg-success">Activo</label></td>
                        @else 
                           <td><label class="badge bg-danger">Inactivo</label></td>
                        @endif
                        <td>
                            <div class="btn-group" role="group">
                              
                                <img src="{{ url('assets/images/edit.png') }}" onclick="mostrarUbicacion(<?php echo "'".$parameter."'"; ?>)" title="Editar Ubicacion" style="cursor: pointer; height:24px; width:24px;">
                 
                                
               
                                <img src="{{ url('assets/images/delete.png') }}" onclick="eliminarUbicacion(<?php echo "'".$parameter."'"; ?>)" title="Eliminar Ubicacion" style="cursor: pointer; height:24px; width:24px;">
                          
                                
                                @if($ubi->estado!=0)
                           
                                    <img src="{{ url('assets/images/off.png') }}" onclick="desactivarUbicacion(<?php echo "'".$parameter."'"; ?>)" title="Desactivar Ubicacion" style="cursor: pointer; height:24px; width:24px;">&nbsp;
                           
                                @else 
                          
                                    <img src="{{ url('assets/images/check.png') }}" onclick="activarUbicacion(<?php echo "'".$parameter."'"; ?>)" title="Activar Ubicacion" style="cursor: pointer; height:24px; width:24px;">&nbsp;
                          
                                @endif
                            </div>
                        </td>
                    </tr>

                    @php($i++)
                @endforeach

            @else 
            
                <tr>
                    <td align="center" colspan="4">No se encontraron registros</td>
                </tr>

            @endif
    
        </tbody>
    </table>


    {{ $ubicaciones->onEachSide(1)->links('partials.my-paginate') }}

</div>
