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
                        @if($cat->estado!=0)
                            <td><label class="badge bg-success">Activo</label></td>
                        @else 
                           <td><label class="badge bg-danger">Inactivo</label></td>
                        @endif
                        <td>
                            <div class="btn-group" role="group">
                              
                                <img src="{{ url('assets/images/edit.png') }}" onclick="mostrarCategoría(<?php echo "'".$parameter."'"; ?>)" title="Editar Categoría" style="cursor: pointer; height:24px; width:24px;">
                 
                                
               
                                <img src="{{ url('assets/images/delete.png') }}" onclick="eliminarCategoría(<?php echo "'".$parameter."'"; ?>)" title="Eliminar Categoría" style="cursor: pointer; height:24px; width:24px;">
                          
                                
                                @if($cat->estado!=0)
                           
                                    <img src="{{ url('assets/images/off.png') }}" onclick="desactivarCategoría(<?php echo "'".$parameter."'"; ?>)" title="Desactivar Categoría" style="cursor: pointer; height:24px; width:24px;">&nbsp;
                           
                                @else 
                          
                                    <img src="{{ url('assets/images/check.png') }}" onclick="activarCategoria(<?php echo "'".$parameter."'"; ?>)" title="Activar Categoría" style="cursor: pointer; height:24px; width:24px;">&nbsp;
                          
                                @endif
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


    {{ $categorias->onEachSide(1)->links('partials.my-paginate') }}

</div>
