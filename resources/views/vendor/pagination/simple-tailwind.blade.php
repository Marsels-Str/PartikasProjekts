@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                class="relative inline-flex items-center px-4 py-2 border border-[var(--border)] rounded-md
                       hover:bg-[var(--text)] hover:text-[var(--bg)]
                       transition ease-in-out duration-100 active:scale-95">
                {!! __('←') !!}
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="relative inline-flex items-center px-4 py-2 border border-[var(--border)] rounded-md
                       hover:bg-[var(--text)] hover:text-[var(--bg)]
                       transition ease-in-out duration-100 active:scale-95">
                {!! __('→') !!}
            </a>
        @endif
    </nav>
@endif
