<div class="table-responsive">
    <table class="table align-middle table-hover m-0">
        <thead>
        <tr>
            <th>#</th>
            <th>Tarifa</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
            @if(count($tarifas) > 0)

                @php($i=1)                 
                @foreach($tarifas as $key => $tar)
                <?php $parameter=$tar->tarifa_id;?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td class="font-weight-bold">{{ $tar->tarifa }}</td>
                        @if($tar->estado!=0)
                            <td><label class="badge bg-success">Activo</label></td>
                        @else 
                           <td><label class="badge bg-danger">Inactivo</label></td>
                        @endif
                        <td>
                            <div class="btn-group" role="group">
                              
                                <img src="{{ url('assets/images/edit.png') }}" onclick="mostrarTarifa(<?php echo "'".$parameter."'"; ?>)" title="Editar Tarifa" style="cursor: pointer; height:24px; width:24px;">
                 
                                
               
                                <img src="{{ url('assets/images/delete.png') }}" onclick="eliminarTarifa(<?php echo "'".$parameter."'"; ?>)" title="Eliminar Tarifa" style="cursor: pointer; height:24px; width:24px;">
                          
                                
                                @if($tar->estado!=0)
                           
                                    <img src="{{ url('assets/images/off.png') }}" onclick="desactivarTarifa(<?php echo "'".$parameter."'"; ?>)" title="Desactivar Tarifa" style="cursor: pointer; height:24px; width:24px;">&nbsp;
                           
                                @else 
                          
                                    <img src="{{ url('assets/images/check.png') }}" onclick="activarTarifa(<?php echo "'".$parameter."'"; ?>)" title="Activar Tarifa" style="cursor: pointer; height:24px; width:24px;">&nbsp;
                          
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


    {{ $tarifas->onEachSide(1)->links('partials.my-paginate') }}

</div>
