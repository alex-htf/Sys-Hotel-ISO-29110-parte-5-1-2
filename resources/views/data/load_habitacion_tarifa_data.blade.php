<div class="table-responsive">
    <table class="table align-middle table-hover m-0">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tarifa</th>
                <th scope="col">Precio</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @if(count($tarifas_habitacion) > 0)

                @php($i=1)                 
                @foreach($tarifas_habitacion as $key => $th)
                <?php $parameter=$th->habitacion_tarifa_id;?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td class="font-weight-bold">{{ $th->tarifa }}</td>
                        <td class="text-muted">{{ $th->precio }}</td>
                        <td>
                            <div class="btn-group" role="group">
                              
                                <img src="{{ url('assets/images/edit.png') }}" onclick="mostrarHabitacionTarifa(<?php echo "'".$parameter."'"; ?>)" title="Editar Categoría" style="cursor: pointer; height:24px; width:24px;">
                 
                                <img src="{{ url('assets/images/delete.png') }}" onclick="eliminarHabitacionTarifa(<?php echo "'".$parameter."'"; ?>)" title="Eliminar Categoría" style="cursor: pointer; height:24px; width:24px;">
                          
                            </div>
                        </td>
                    </tr>

                    @php($i++)
                @endforeach

            @else 
            
                <tr>
                    <td align="center" colspan="5">No se encontraron registros</td>
                </tr>

            @endif
    
        </tbody>
    </table>


    {{ $tarifas_habitacion->onEachSide(1)->links('partials.my-paginate') }}

</div>
