@props(['breadcrumbs' => [], 'theme' => 'light'])

@if (!empty($breadcrumbs) && is_array($breadcrumbs) && count($breadcrumbs) > 0)
<nav aria-label="Breadcrumb" class="mb-4 overflow-hidden">
    <ol class="flex flex-wrap items-center text-xs md:text-sm font-semibold {{ $theme === 'dark' ? 'text-gray-200' : 'text-gray-500' }} gap-y-2">
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!$loop->last)
                <li class="flex items-center">
                    @if (isset($breadcrumb['url']) && !empty($breadcrumb['url']))
                        <a href="{{ $breadcrumb['url'] }}" class="hover:text-blue-400 transition-all duration-200 flex items-center group whitespace-nowrap">
                            @if (isset($breadcrumb['icon']))
                                <i class="{{ $breadcrumb['icon'] }} mr-1.5 {{ $theme === 'dark' ? 'text-gray-300 group-hover:text-blue-300' : 'text-gray-400 group-hover:text-blue-500' }} transition-colors"></i>
                            @endif
                            <span class="max-w-[100px] md:max-w-[200px] truncate">{{ $breadcrumb['title'] }}</span>
                        </a>
                    @else
                        <span class="flex items-center whitespace-nowrap">
                            @if (isset($breadcrumb['icon']))
                                <i class="{{ $breadcrumb['icon'] }} mr-1.5 {{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-400' }}"></i>
                            @endif
                            <span class="max-w-[100px] md:max-w-[200px] truncate">{{ $breadcrumb['title'] }}</span>
                        </span>
                    @endif
                    
                    <span class="mx-2 {{ $theme === 'dark' ? 'text-gray-400' : 'text-gray-300' }}">
                        <i class="fas fa-chevron-right text-[10px]"></i>
                    </span>
                </li>
            @else
                <li class="flex items-center {{ $theme === 'dark' ? 'text-white' : 'text-blue-600' }} min-w-0">
                    @if (isset($breadcrumb['icon']))
                        <i class="{{ $breadcrumb['icon'] }} mr-1.5 flex-shrink-0"></i>
                    @endif
                    <span class="truncate font-bold">
                        <span class="hidden md:inline">{{ $breadcrumb['title'] }}</span>
                        <span class="md:hidden">{{ \Illuminate\Support\Str::limit($breadcrumb['title'], 20) }}</span>
                    </span>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
@endif