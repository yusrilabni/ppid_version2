@if ($paginator->hasPages())
    <div class="flex flex-col items-center space-y-4 mt-8">
        <!-- Navigation Buttons -->
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center space-x-1 md:space-x-2 bg-white p-1.5 rounded-2xl border border-gray-100 shadow-sm">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <span class="flex items-center justify-center w-10 h-10 text-gray-300 cursor-not-allowed transition-all duration-200" aria-hidden="true">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex items-center justify-center w-10 h-10 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-300 transform hover:scale-110" aria-label="{{ __('pagination.previous') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span aria-disabled="true" class="hidden md:inline">
                        <span class="flex items-center justify-center w-10 h-10 text-gray-400">{{ $element }}</span>
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @php
                            // Logika tampil di mobile: Halaman 1, Halaman 2, Halaman Aktif, atau Halaman Terakhir
                            $isMobileVisible = ($page == 1 || $page == 2 || $page == $paginator->currentPage() || $page == $paginator->lastPage());
                        @endphp
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page">
                                <span class="flex items-center justify-center w-10 h-10 text-sm font-bold text-white bg-blue-600 rounded-xl shadow-md shadow-blue-200">{{ $page }}</span>
                            </span>
                        @else
                            <a href="{{ $url }}" 
                               class="{{ $isMobileVisible ? 'flex' : 'hidden md:flex' }} items-center justify-center w-10 h-10 text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-300 transform hover:scale-110" 
                               aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex items-center justify-center w-10 h-10 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-300 transform hover:scale-110" aria-label="{{ __('pagination.next') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    <span class="flex items-center justify-center w-10 h-10 text-gray-300 cursor-not-allowed transition-all duration-200" aria-hidden="true">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                </span>
            @endif
        </nav>

        <!-- Page Info -->
        <p class="text-xs text-gray-400 font-medium tracking-wide">
            Menampilkan <span class="text-gray-700">{{ $paginator->firstItem() }}</span> - <span class="text-gray-700">{{ $paginator->lastItem() }}</span> dari <span class="text-gray-700">{{ $paginator->total() }}</span> data
        </p>
    </div>
@endif
