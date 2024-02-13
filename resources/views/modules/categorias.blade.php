@extends('master')

@section('content')

<!-- App hero header starts -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <span>Mantenimiento de Categorías</span>
    </h3>
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item" aria-current="page"><i class="fa-solid fa-database"></i> Mantenimiento Habitaciones</li>
            <li class="breadcrumb-item active" aria-current="page">Categoría</li>
        </ol>
    </nav>

</div>
<!-- App Hero header ends -->

<div class="app-body" style="margin-top:-8.5rem !important;height: calc(103vh - 202px);">

    <div class="row mb-3">
        <div class="col-xl-12">
            <div class="form-group">
                <h5 class="mb-3">Buscar por:</h5>
            </div>
        </div>

        <div class="col-xl-7 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="txtBuscarCategoria" style="font-size:14px;">Categoría: </label>
                <input type="text" class="form-control" id="txtBuscarCategoria" placeholder="Código o nombre de la Categoría...">
            </div>
        </div>

        <div class="col-xl-5 col-md-6 col-sm-12">
            <div class="form-group">
                <label for="estadoCategoriaBuscar" style="font-size:14px;">Estado:</label>
                <select name="estadoCategoriaBuscar" id="estadoCategoriaBuscar" class="form-control">
                    <option value="_all_">--Seleccione--</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
        </div>
        
    </div>

    <div class="row">
        <div class="col-xl-12 d-flex justify-content-end">
            <div class="form-group">
            <button type="button" class="btn btn-success btn-fw" data-bs-toggle="modal" data-bs-target="#ModalCategoria"><img src="{{ url('assets/images/add.png') }}" alt="agregar" width="25px"> Agregar Categoría</button>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xxl-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <section class="categorias">
                        @if(isset($categorias) && count($categorias) > 0)
                                
                            @include('data.load_categorias_data')
                        
                        @else 
                            <div class="table-responsive">
                                <table class="table align-middle table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Descripción</th>
                                            <th scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center" colspan="4">No se encontraron registros</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </section>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal Agregar -->
<div class="modal fade" id="ModalCategoria" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header" style="background-color:#00368e !important; color:#fff !important;">
            <h5 class="modal-title" id="tituloModalCategoria">Agregar Categoría</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limpiarModalCategoria()"></button>
        </div>
        <form action="#" method="POST" id="formCategoria">
            @csrf
            <input type="hidden" name="categoria_id" id="categoria_id">
            <div class="modal-body p-4 bg-light">
                <div class="my-2">
                    <label for="curso">Categoría:</label>
                    <input type="text" name="categoria" id="categoria" class="form-control" placeholder="Categoría" required>
                </div>
                <div class="my-2">
                    <label for="descripcion">Descripcion</label>
                    <textarea class="form-control ml-2" name="descripcion" id="descripcion" cols="20" rows="3" placeholder="Ingrese la Descripción.."></textarea>
                </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limpiarModalCategoria()">Cerrar</button>
            <button type="submit" id="btncategoria" class="btn btn-success">Agregar Categoría</button>
            </div>
        </form>
        </div>
    </div>
</div>


@endsection


@section('scripts')

<script>

    $(window).on('hashchange',function(){
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            } else{
                loadcategorias(page);
            }
        }
    });

    $(function (){

        $(document).on('click', '.categorias .pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            loadcategorias(page);
        });

        $('#txtBuscarCategoria').on('keyup', function(e){
            url=$('meta[name=app-url]').attr("content") + "/categorias";
            let estadocategoria = $('#estadoCategoriaBuscar').val(); 
            $.ajax({
                url: url,
                method:'GET',
                data: {categoria: this.value, estado: estadocategoria}
            }).done(function (data) {
                $('.categorias').html(data);
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        });


        $('#estadoCategoriaBuscar').on('change', function (e ){
            url=$('meta[name=app-url]').attr("content") + "/categorias";
            let categoriabuscar = $('#txtBuscarCategoria').val();
            $.ajax({
                url: url,
                method:'GET',
                data: {categoria: categoriabuscar, estado: this.value}
            }).done(function (data) {
                $('.categorias').html(data);
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        });

        window.limpiarModalCategoria = function()
        {   
            $('#tituloModalCategoria').html('Agregar Categoría');
            $("#formCategoria")[0].reset();
            $("#btncategoria").text('Registrar Categoría');
            $('#categoria_id').val("");
        }

        function loadcategorias(page)
        {
            let url='';
            let categoria = $('#txtBuscarCategoria').val();
            let estado = $('#estadoCategoriaBuscar').val(); 
            url=$('meta[name=app-url]').attr("content")  + "/categorias?page="+page;

            $.ajax({
                url: url,
                method:'GET',
                data: {categoria: categoria, estado: estado}
            }).done(function (data) {
                $('.categorias').html(data);
            }).fail(function () {
                console.log("Failed to load data!");
            });
        }

        $("#formCategoria").submit(function(e) {
            event.preventDefault();
            let hddcategoria_id = $('#categoria_id').val();
            //valida si el campo categoria_id esta vacío
            if(hddcategoria_id!="")
            {
                ActualizarCategoria(hddcategoria_id);
            }
            else 
            {
                GuardarCategoria();
            }
        });

        //Ajax para registrar Categoria
        window.GuardarCategoria = function()
        {
            $("#btncategoria").prop('disabled', true);
            $("#btncategoria").text('Registrando');
            $('#categoria_id').val("");
            let url = $('meta[name=app-url]').attr("content") + "/categorias";
            const fd = new FormData($("#formCategoria")[0]); 
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#btncategoria").prop('disabled', false);
                    $("#btncategoria").text('Registrar Categoría');
                    if(response.code == "200")
                    {
                           
                            $("#ModalCategoria").modal('hide');
                            limpiarModalCategoria();
                            loadcategorias();

                            Swal.fire({
                                icon: 'success',
                                title: 'ÉXITO!',
                                text: 'Se ha registrado la Categoría correctamente'
                            });
                    }
                    else  if(response.code == "422")
                    {
                            let errors = response.errors;
                            console.log(errors);
                            if (typeof errors.categoria !== 'undefined' || typeof errors.categoria !== "") 
                            {
                                categoriavalidation = '<li>' + errors.categoria + '</li>';
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'ERROR...',
                                html: '<ul>'+
                                        categoriavalidation  + 
                                        '</ul>'
                            });
                    }
                    else if(response.code=="426")
                    {
                        Swal.fire({
                                icon: 'error',
                                title: 'ERROR!',
                                text: 'La categoría ya Existe!'
                            });
                    }
                    else 
                    {
                        Swal.fire({
                                icon: 'error',
                                title: 'ERROR!',
                                text: 'Ha ocurrido un error al intentar registrar la categoría!'
                            });
                    }
                }
            })

        }

        window.mostrarCategoría = function(categoria_id) 
        {
            url=$('meta[name=app-url]').attr("content") + "/categorias/" +categoria_id;
            $("#ModalCategoria").modal('show');
            $.ajax({
                url: url,
                method:'GET'
            }).done(function (data) {
                $('#tituloModalCategoria').html('EDITAR CATEGORÍA: ' +data.categoria);
                $('#categoria_id').val(categoria_id);
                $('#categoria').val(data.categoria);
                $('#descripcion').val(data.descripcion);
                $('#btncategoria').text('Actualizar Categoría');
            }).fail(function () {
                console.log("Error al cargar los datos");
            });
        }

        window.ActualizarCategoria = function(categoria_id)
        {
            $("#btncategoria").prop('disabled', true);
            $("#btncategoria").text('Actualizando');
            let url = $('meta[name=app-url]').attr("content") + "/categorias/" + categoria_id;
            let data = $('#formCategoria').serialize();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "PUT",
                data: data,
                success: function(response) {
                    $("#btncategoria").prop('disabled', false);
                    $("#btncategoria").text('Actualizar Categoría');
                    if(response.code == "200")
                    {
                            limpiarModalCategoria();
                            $("#ModalCategoria").modal('hide');
                            loadcategorias();

                            Swal.fire({
                                icon: 'success',
                                title: 'ÉXITO!',
                                text: 'Se ha actualizado la Categoría correctamente'
                            });
                    }
                    else if(response.code == "422")
                    {
                        let errors = response.errors;
                        if (typeof errors.categoria !== 'undefined' || typeof errors.categoria !== "") 
                        {
                            categoriavalidation = '<li>' + errors.categoria + '</li>';
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR...',
                            html: '<ul>'+
                            categoriavalidation  + 
                                    '</ul>'
                        });
                    }
                },
                error: function(response) {
                    $("#btncategoria").prop('disabled', false);
    
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR...',
                        text: 'Se ha producido un error al intentar actualizar el registro!'
                    })
                }
            });
        }

        window.eliminarCategoría = function(categoria_id)
        {
            Swal.fire({
                icon: 'warning',
                title: 'Está seguro de eliminar la categoría?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: "#EB1010",
                confirmButtonText: `Eliminar`,
                cancelButtonText: `Cancelar`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = $('meta[name=app-url]').attr("content") +  "/categorias/"  + categoria_id;
                        let data = {
                            categoria_id: categoria_id
                        };
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: url,
                            type: "DELETE",
                            data: data,
                            success: function(response) {
                                if(response.code == "200")
                                {
                                    loadcategorias();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'ÉXITO!',
                                        text: 'Se ha eliminado la categoría correctamente'
                                    });
                                }
                                else if(response.code == "423")
                                    {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'ERROR...',
                                            text: 'No se puede eliminar la categoría porque existen habitaciones registradas en la categoría!'
                                        })
                                    }
                            },
                            error: function(response) {                
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ERROR...',
                                    text: 'Se ha producido un error al intentar eliminar el registro!'
                                })
                            }
                        });
                    }
                })
        }

        window.desactivarCategoría = function(categoria_id)
        {
            Swal.fire({
                icon: 'warning',
                title: 'Está seguro de desactivar la Categoría?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: "#EB1010",
                confirmButtonText: `Desactivar`,
                cancelButtonText: `Cancelar`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = $('meta[name=app-url]').attr("content") + "/categorias" +  "/desactivar/" + categoria_id;
                        let data = {
                            categoria_id: categoria_id
                        };
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: url,
                            type: "POST",
                            data: data,
                            success: function(response) {
                                // console.log(response);
                                if(response.code == "200")
                                {
                                    loadcategorias();
                                   
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'ÉXITO!',
                                        text: 'Se ha desactivado la Categoría correctamente'
                                    });
                                    // document.location.reload(true)
                                }
                            },
                            error: function(response) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ERROR...',
                                    text: 'Se ha producido un error al intentar desactivar el registro!'
                                })
                            }
                        });
                    }
                })
        }

        window.activarCategoria = function(categoria_id)
        {
            Swal.fire({
                icon: 'warning',
                title: 'Está seguro de activar la Categoría?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: "#EB1010",
                confirmButtonText: `Activar`,
                cancelButtonText: `Cancelar`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = $('meta[name=app-url]').attr("content") +  "/categorias" +  "/activar/" + categoria_id;
                        let data = {
                            categoria_id: categoria_id
                        };
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: url,
                            type: "POST",
                            data: data,
                            success: function(response) {
                                // console.log(response);
                                if(response.code == "200")
                                {
                                    loadcategorias();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'ÉXITO!',
                                        text: 'Se ha activado la categoría correctamente'
                                    });
                                    // document.location.reload(true)
                                }
                            },
                            error: function(response) {                    
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ERROR...',
                                    text: 'Se ha producido un error al intentar activar el registro!'
                                })
                            }
                        });
                    }
                })
        }


    });
</script>

@endsection