@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link" aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="bi bi-chevron-right"></i></a>
            </li>
        @endif

        {{-- Page Indicators (Showing dots instead of numbers like the design) --}}
        <div class="d-flex align-items-center gap-2" style="margin: 0 16px;">
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <div class="page-indicator active"></div>
                        @else
                            <div class="page-indicator" style="width: 8px; background: #ccc;"></div>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="bi bi-chevron-left"></i></a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link" aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
            </li>
        @endif
    </ul>
@endif
