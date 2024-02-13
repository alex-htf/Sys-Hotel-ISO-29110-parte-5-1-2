<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Tipo Documento</th>
                <th>Nro Documento</th>
                <th>Nombre</th>
                {{-- <th>Razón Social</th> --}}
                <th>Dirección</th></th>
                <th>Telefóno</th>
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
                        {{-- <td>{{ $cli->razon_social }}</td> --}}
                        <td>{{ $cli->direccion}}</td>
                        <td>{{ $cli->telefono}}</td>
                        <td>{{ $cli->email}}</td>
                        <td>
                            <div class="btn-group" role="group">
                               
                                <img src="{{ url('assets/images/edit.png') }}" onclick="mostrarCliente(<?php echo "'".$param."'"; ?>)" title="Editar Cliente" style="cursor: pointer; height:24px; width:24px;">
              
                            </div>
                        </td>
                    </tr>

                    @php($i++)
                @endforeach

            @else 
            
                <tr>
                    <td align="center" colspan="8">No se encontraron registros</td>
                </tr>

            @endif
    
        </tbody>
    </table>

    {{ $clientes->onEachSide(1)->links('partials.my-paginate') }}

</div>