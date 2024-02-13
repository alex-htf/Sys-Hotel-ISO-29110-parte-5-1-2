<div class="d-flex justify-content-center">

@if ($paginator->hasPages())

    <nav class="mt-4 text-center">
        <ul class="pagination rounded-flat pagination-dark">

        @if ($paginator->onFirstPage())
            <li class="page-item" style="pointer-events: none;"><a class="page-link" href="#"><i class="fa fa-chevron-left" style="color:#858796;"></i></a></li>
        @else 
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Anterior"><i class="fa fa-chevron-left"></i></a></li>
        @endif

        @foreach ($elements as $element)

            @if (is_string($element))
                <li class="page-item" style="pointer-events: none;"><a class="page-link" href="#">{{ $element }}</a></li>
            @endif

            @if (is_array($element))

                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" style="pointer-events: none;"><a class="page-link" href="#">{{$page}}</a></li>
                    @else 
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif 
                @endforeach
            
            @endif

        @endforeach

        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}"><i class="fa fa-chevron-right"></i></a></li>
        @else 
        <li class="page-item" style="pointer-events: none;"><a class="page-link" href="#"><i class="fa fa-chevron-right" style="color:#858796;"></i></a></li>        
        @endif

        </ul>
    </nav>

@endif


</div>