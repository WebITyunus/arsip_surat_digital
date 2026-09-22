@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center gap-1">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span
                class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                       text-gray-300 bg-gray-50 cursor-not-allowed">
                <i class="fas fa-chevron-left text-xs"></i>
            </span>
        @else
            <button
                wire:click="previousPage('{{ $paginator->getPageName() }}')"
                wire:loading.attr="disabled"
                class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                       text-gray-500 bg-white border border-gray-200
                       hover:bg-gray-50 hover:text-gray-700 transition">
                <i class="fas fa-chevron-left text-xs"></i>
            </button>
        @endif


        {{-- Pagination --}}
        @foreach ($elements as $element)

            {{-- "Three Dots" --}}
            @if (is_string($element))
                <span class="inline-flex items-center justify-center w-9 h-9 text-gray-400">
                    {{ $element }}
                </span>
            @endif


            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)

                    @if ($page == $paginator->currentPage())

                        <span
                            class="inline-flex items-center justify-center w-9 h-9
                                   rounded-lg bg-blue-600 text-white text-sm font-medium
                                   shadow-sm">
                            {{ $page }}
                        </span>

                    @else

                        <button
                            wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                            wire:loading.attr="disabled"
                            class="inline-flex items-center justify-center w-9 h-9
                                   rounded-lg bg-white border border-gray-200
                                   text-gray-600 text-sm
                                   hover:bg-blue-50 hover:text-blue-600
                                   hover:border-blue-200 transition">
                            {{ $page }}
                        </button>

                    @endif

                @endforeach
            @endif

        @endforeach


        {{-- Next --}}
        @if ($paginator->hasMorePages())

            <button
                wire:click="nextPage('{{ $paginator->getPageName() }}')"
                wire:loading.attr="disabled"
                class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                       text-gray-500 bg-white border border-gray-200
                       hover:bg-gray-50 hover:text-gray-700 transition">
                <i class="fas fa-chevron-right text-xs"></i>
            </button>

        @else

            <span
                class="inline-flex items-center justify-center w-9 h-9 rounded-lg
                       text-gray-300 bg-gray-50 cursor-not-allowed">
                <i class="fas fa-chevron-right text-xs"></i>
            </span>

        @endif

    </nav>
@endif
