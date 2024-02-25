<div class="d-flex justify-content-center">
    <!-- Comprueba si hay páginas disponibles para mostrar -->
    @if ($paginator->hasPages())
    <nav class="mt-4 text-center">
        <!-- Lista de páginas de la paginación -->
        <ul class="pagination rounded-flat pagination-dark">
            <!-- Botón para ir a la página anterior -->
            @if ($paginator->onFirstPage())
            <li class="page-item" style="pointer-events: none;"><a class="page-link" href="#"><i
                        class="fa fa-chevron-left" style="color:#858796;"></i></a></li>
            @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                    aria-label="Anterior"><i class="fa fa-chevron-left"></i></a></li>
            @endif

            <!-- Itera sobre los elementos de la paginación -->
            @foreach ($elements as $element)
            
            <!-- Si el elemento es una cadena, muestra un botón desactivado -->
            @if (is_string($element))
            <li class="page-item" style="pointer-events: none;"><a class="page-link" href="#">{{ $element }}</a></li>
            @endif

            <!-- Si el elemento es un array, muestra los números de página -->
            @if (is_array($element))
            @foreach ($element as $page => $url)
            <!-- Resalta la página actual -->
            @if ($page == $paginator->currentPage())
            <li class="page-item active" style="pointer-events: none;"><a class="page-link" href="#">{{$page}}</a></li>
            @else
            <!-- Enlace a otras páginas -->
            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @endif
            @endforeach
            @endif
            @endforeach

            <!-- Botón para ir a la página siguiente -->
            @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}"><i
                        class="fa fa-chevron-right"></i></a></li>
            @else
            <!-- Botón de página siguiente desactivado -->
            <li class="page-item" style="pointer-events: none;"><a class="page-link" href="#"><i
                        class="fa fa-chevron-right" style="color:#858796;"></i></a></li>
            @endif
        </ul>
    </nav>
    @endif
</div>
