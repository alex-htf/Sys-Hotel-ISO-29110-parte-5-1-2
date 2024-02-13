@extends('master')

@section('content')

<!-- App hero header starts -->
<div class="app-hero-header d-flex justify-content-between">
    <h3 class="fw-light mb-5">
        <b><span>Reporte Recepción</span></b>
    </h3>
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-house"></i> Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-file-invoice"></i> Reportes</li>
        </ol>
    </nav>

</div>
<!-- App Hero header ends -->

<div class="app-body"style="margin-top:-8.5rem !important;height: calc(103vh - 202px);">

    <div class="row">
        <div class="col-xl-6 col-md-6 col-sm-12 px-5 mt-2">
            <div class="form-group">
                <label for="txtBuscarCategoria" style="font-size:14px;">Desde: </label>
                <input type="date" class="form-control" name="fechaDesde" id="fechaDesde">
            </div>
        </div>

        <div class="col-xl-6 col-md-6 col-sm-12 px-5 mt-2">
            <div class="form-group">
                <label for="txtBuscarCategoria" style="font-size:14px;">Hasta: </label>
                <input type="date" class="form-control" name="fechaHasta" id="fechaHasta">
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-xl-12 d-flex justify-content-center">
            <div class="form-group">
                <button type="button" id="btnPreviewReporte" class="btn btn-info btn-fw"><img src="{{ url('assets/images/eye.png') }}" alt="agregar" width="25px"> Vista Previa</button>
                <button type="button" id="btnExportarPDF" class="btn btn-dark btn-fw"><img src="{{ url('assets/images/pdf.png') }}" alt="agregar" width="25px"> Exportar PDF</button>
            </div>
        </div>
    </div>

    <div class="row mt-3">

        <div class="col-12">

            <div class="card shadow mb-4">
                <div class="card-body">
                    <section class="tblreporte">
                    </section>
                </div>
            </div>

        </div>


    </div>

</div>

@endsection


@section('scripts')
    <script>

        $(function (){
            
            $('#btnPreviewReporte').click(function(event){
                event.preventDefault();
                let fdesde = $('#fechaDesde').val();
                let fhasta = $('#fechaHasta').val();
                let url = $('meta[name=app-url]').attr("content") + "/reportes/vista_previa";
                $.ajax({
                        url: url,
                        method:'GET',
                        data: { 
                            fdesde: fdesde, 
                            fhasta: fhasta, 
                        },
                    }).done(function (response) {

                    //    $('.tblreporte').html(reponse);
                    
                        if(response.code == "422")
                        {
                            let errors = response.errors;
                            let reporteValidation = '';

                            $.each(errors, function(index, value) {

                            if (typeof value !== 'undefined' || typeof value !== "") 
                            {
                                reporteValidation += '<li>' + value + '</li>';
                            }

                            }); 


                            Swal.fire({
                                icon: 'error',
                                title: 'ERROR...',
                                html: '<ul>'+
                                reporteValidation  + 
                                        '</ul>'
                            });
                        }
                        else  if(response.code == "423")
                        {
                            Swal.fire({
                                    icon: 'error',
                                    title: 'ERROR...',
                                text: 'La Fecha Desde no debe ser Mayor que la Fecha Hasta!'
                            })
                        }
                        else 
                        {
                            $('.tblreporte').html(response);
                        }
                    }).fail(function () {
                        console.log("Error al cargar los datos");
                    });
            });

            $(document).on('click', '#btnExportarPDF', function(e) {
                event.preventDefault();
                let fechaD = $('#fechaDesde').val();
                let fechaH = $('#fechaHasta').val();

                if(fechaDesde == "")
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR!',
                        text: 'La Fecha Desde es requerida'
                    });
                }
                 else if(fechaHasta == "")
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR!',
                        text: 'La Fecha Hasta es requerida'
                    });
                }
                else 
                {
                    if(fechaDesde > fechaHasta)
                    {
                        Swal.fire({
                            icon: 'error',
                            title: 'ERROR!',
                            text: 'La Fecha Desde no debe ser mayor hasta la Fecha Hasta es requerida'
                        });
                    }
                    else 
                    {
                        var url = "{{ route('reportePDF', ['fdesde' => 'fechaD','fhasta' => 'fechaH']) }}";
                        url = url.replace('fechaD', fechaD);
                        url = url.replace('fechaH', fechaH);
                        url = url.replace('&amp;', '&');
                        window.open(url,'_blank');

                    }
                }
         
            });

        });

    </script>
@endsection

