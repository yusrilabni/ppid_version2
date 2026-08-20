@if ($paginator->hasPages())
    <div class="flex flex-col items-center space-y-4 mt-8">
        <!-- Navigation Buttons -->
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center space-x-1 md:space-x-2 bg-white p-1.5 rounded-2xl border border-gray-100 shadow-sm">
            
            {{-- First Page Link --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="First">
                    <span class="flex items-center justify-center w-8 h-10 md:w-10 md:h-10 text-gray-300 cursor-not-allowed transition-all duration-200" aria-hidden="true">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                        </svg>
                    </span>
                </span>
            @else
                <a href="{{ $paginator->url(1) }}" class="flex items-center justify-center w-8 h-10 md:w-10 md:h-10 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-300 transform hover:scale-110" aria-label="First">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </a>
            @endif

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <span class="flex items-center justify-center w-8 h-10 md:w-10 md:h-10 text-gray-300 cursor-not-allowed transition-all duration-200" aria-hidden="true">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex items-center justify-center w-8 h-10 md:w-10 md:h-10 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-300 transform hover:scale-110" aria-label="{{ __('pagination.previous') }}">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
            @endif

            {{-- Pagination Elements (Custom 5 Pages Limit) --}}
            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                
                // Hitung window 5 halaman
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $currentPage + 2);
                
                // Jika halaman awal kurang dari 5, geser end ke kanan
                if ($end - $start < 4) {
                    if ($start == 1) {
                        $end = min($lastPage, $start + 4);
                    } elseif ($end == $lastPage) {
                        $start = max(1, $end - 4);
                    }
                }
            @endphp
            
            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $currentPage)
                    <span aria-current="page" class="flex">
                        <span class="flex items-center justify-center w-8 h-10 md:w-10 md:h-10 text-sm font-bold text-white bg-blue-600 rounded-xl shadow-md shadow-blue-200">{{ $page }}</span>
                    </span>
                @else
                    <a href="{{ $paginator->url($page) }}" 
                       class="flex items-center justify-center w-8 h-10 md:w-10 md:h-10 text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-300 transform hover:scale-110" 
                       aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                        {{ $page }}
                    </a>
                @endif
            @endfor

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex items-center justify-center w-8 h-10 md:w-10 md:h-10 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-300 transform hover:scale-110" aria-label="{{ __('pagination.next') }}">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    <span class="flex items-center justify-center w-8 h-10 md:w-10 md:h-10 text-gray-300 cursor-not-allowed transition-all duration-200" aria-hidden="true">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                </span>
            @endif

            {{-- Last Page Link --}}
            @if ($paginator->currentPage() == $paginator->lastPage())
                <span aria-disabled="true" aria-label="Last">
                    <span class="flex items-center justify-center w-8 h-10 md:w-10 md:h-10 text-gray-300 cursor-not-allowed transition-all duration-200" aria-hidden="true">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                        </svg>
                    </span>
                </span>
            @else
                <a href="{{ $paginator->url($paginator->lastPage()) }}" class="flex items-center justify-center w-8 h-10 md:w-10 md:h-10 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-300 transform hover:scale-110" aria-label="Last">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                </a>
            @endif
        </nav>

        <!-- Page Info -->
        <p class="text-xs text-gray-400 font-medium tracking-wide">
            Menampilkan <span class="text-gray-700">{{ $paginator->firstItem() }}</span> - <span class="text-gray-700">{{ $paginator->lastItem() }}</span> dari <span class="text-gray-700">{{ $paginator->total() }}</span> data
        </p>
    </div>
@endif
