@if ($paginator->hasPages())
    <hr>
    <nav class="pagination is-centered" role="navigation" aria-label="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="pagination-previous"  disabled><i class="fas fa-chevron-circle-left mr-2"></i> Anterior</a>
        @else
            <a class="pagination-previous" wire:click="previousPage" rel="prev"><i class="fas fa-chevron-circle-left mr-2"></i> Anterior</a>
        @endif

        <ul class="pagination-list" style="list-style: none;">
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li><span class="pagination-ellipsis">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span class="pagination-link has-background-primary has-text-white">{{ $page }}</span></li>
                        @else
                            <li><a wire:click="gotoPage({{$page}})" class="pagination-link">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="pagination-next "wire:click="nextPage" rel="next">Siguiente <i class="fas fa-chevron-circle-right ml-2"></i></a>
        @else
            <a class="pagination-next" disabled>Siguiente <i class="fas fa-chevron-circle-right ml-2"></i></a>
@endif
@endif
