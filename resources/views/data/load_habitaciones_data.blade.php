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

                @php($i=1)                 
                @foreach($habitaciones as $key => $hab)
                <?php $parameter=$hab->habitacion_id;?>
                    <tr>
                        <td>{{ $i }}</td>
                        @if($hab->imagen!="")
                            <td><img src="{{URL::asset('img/habitaciones/'.$hab->imagen)}}" alt="Imagen Producto" width="80" class="img-thumbnail"></td>
                        @else 
                        <td><img src="{{URL::asset('assets/images/bed.png')}}" alt="Imagen Producto" width="80" class="img-thumbnail"></td>
                        @endif
                        <td class="font-weight-bold">{{ $hab->habitacion }}</td>
                        <td class="font-weight-bold">{{ $hab->categoria }}</td>
                        <td class="font-weight-bold">{{ $hab->ubicacion }}</td>
                        <td class="text-muted">{{ $hab->detalles }}</td>
                        <td class="text-muted">{{ $hab->precio }}</td>
                        @if($hab->estado == 1)
                            <td><label class="badge bg-success">Disponible</label></td>
                        @elseif($hab->estado == 2)
                            <td><label class="badge bg-danger">Ocupado</label></td>
                        @endif
                        <td>
                            <div class="btn-group" role="group">
                              
                                <img src="{{ url('assets/images/edit.png') }}" onclick="mostrarHabitacion(<?php echo "'".$parameter."'"; ?>)" title="Editar Habitación" style="cursor: pointer; height:24px; width:24px;">
                 
                                
               
                                <img src="{{ url('assets/images/delete.png') }}" onclick="eliminarHabitacion(<?php echo "'".$parameter."'"; ?>)" title="Eliminar Habitación" style="cursor: pointer; height:24px; width:24px;">
                          
                                
                                @if($hab->estado == 1)

                                    <img src="{{ url('assets/images/off.png') }}" onclick="OcupadaHabitación(<?php echo "'".$parameter."'"; ?>)" title="Habitación ocupada" style="cursor: pointer; height:24px; width:24px;">&nbsp;                                
                                @elseif($hab->estado == 2)
                                    <img src="{{ url('assets/images/check.png') }}" onclick="DisponibleHabitación(<?php echo "'".$parameter."'"; ?>)" title="Habitación Disponible" style="cursor: pointer; height:24px; width:24px;">&nbsp;                          
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


    {{ $habitaciones->onEachSide(1)->links('partials.my-paginate') }}

</div>
