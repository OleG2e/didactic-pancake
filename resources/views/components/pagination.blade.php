@if ($paginator->hasPages())
    <nav class="pagination is-rounded is-right" role="navigation" aria-label="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="pagination-previous" disabled>Предыдущая</a>
        @else
            <a class="pagination-previous" href="{{ $paginator->previousPageUrl() }}">Предыдущая</a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="pagination-next" href="{{ $paginator->nextPageUrl() }}">Следующая</a>
        @else
            <a class="pagination-next" disabled>Следующая</a>
        @endif


        {{-- Pagination Elements --}}
        <ul class="pagination-list">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li><span class="pagination-ellipsis">&hellip;</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><a class="pagination-link is-current" aria-label="Перейти к странице {{ $page }}">{{ $page }}</a>
                            </li>
                        @else
                            <li><a href="{{ $url }}" class="pagination-link"
                                   aria-label="Перейти к странице {{ $page }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>

    </nav>
@endif