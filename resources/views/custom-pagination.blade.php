@if ($paginator->hasPages())
    <nav class="p-pagination" aria-label="Pagination">
        <ol class="p-pagination__items">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="p-pagination__item" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="p-pagination__link--previous" aria-hidden="true">@lang('pagination.previous')</span>
                </li>
            @else
                <li class="p-pagination__item">
                    <a class="p-pagination__link--previous" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">@lang('pagination.previous')</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="p-pagination__item" aria-disabled="true"><span class="p-pagination__link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="p-pagination__item" aria-current="page"><span class="p-pagination__link">{{ $page }}</span></li>
                        @else
                            <li class="p-pagination__item"><a class="p-pagination__link" href="{{ $url }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="p-pagination__item">
                    <a class="p-pagination__link--next" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">@lang('pagination.next')</a>
                </li>
            @else
                <li class="p-pagination__item" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="p-pagination__link--next" aria-hidden="true">@lang('pagination.next')</span>
                </li>
            @endif
        </ol>
    </nav>
@endif
