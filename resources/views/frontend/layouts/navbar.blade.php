<nav x-data="{ open: false, searchOpen: false, activeSubMenu: null }" class="bg-white shadow-lg sticky top-0 z-50 border-b border-blue-100"
    style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
    <div class="w-full">
        <!-- Tinggi navbar tetap sama -->
        <div class="flex justify-between h-16 items-center">
            <!-- Logo Section - Diperbesar dengan transform scale -->
            <div class="flex items-center flex-shrink-0 pl-4 xl:pl-6">
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center group relative">
                    <!-- Logo diperbesar dengan transform scale -->
                    <div
                        class="transform origin-left scale-[1.4] xl:scale-150 group-hover:scale-[1.5] xl:group-hover:scale-[1.6] transition-transform duration-300">
                        <img class="w-auto h-16 xl:h-20" src="{{ asset('storage/logo/ppid.webp') }}"
                            alt="PPID" onerror="this.onerror=null; this.src='{{ asset('storage/logo/ppid.png') }}'">
                    </div>
                </a>
            </div>

            <!-- Menu & Search Container (Desktop) -->
            <div class="hidden xl:flex flex-1 justify-center mx-4 min-w-0">
                <div class="relative bg-blue-50/50 rounded-2xl border border-blue-100 transition-all duration-500 ease-in-out h-12 flex items-center px-2"
                     :class="searchOpen ? 'w-full max-w-2xl shadow-inner bg-white border-blue-200' : 'w-auto max-w-full'">
                    
                    <!-- Menu List Container -->
                    <div class="flex items-center space-x-1 whitespace-nowrap w-full justify-center opacity-100 scale-100 translate-y-0"
                         :class="searchOpen ? 'opacity-0 pointer-events-none scale-95 translate-y-[-10px]' : 'opacity-100 scale-100 translate-y-0'">
                        @foreach ($menus as $menu)
                            @php
                                $isActive = !empty($menu['url']) && $menu['url'] !== '#' && (request()->is(trim($menu['url'], '/') . '*') || request()->fullUrlIs(url($menu['url'])));
                                $hasActiveChild = false;
                                if (!empty($menu['children'])) {
                                    foreach ($menu['children'] as $child) {
                                        if (request()->is(trim($child['url'], '/') . '*') || request()->fullUrlIs(url($child['url']))) {
                                            $hasActiveChild = true;
                                            break;
                                        }
                                    }
                                }
                            @endphp
                            @if ($menu['title'] === 'DIP' && empty($menu['children']))
                                @continue
                            @endif
                            @if ($menu['title'] === 'Login')
                                @continue
                            @endif
                            @if (empty($menu['children']))
                                <a href="{{ Str::startsWith($menu['url'], '#') ? '#' : url($menu['url']) }}"
                                    @if (Str::startsWith($menu['url'], '#')) onclick="event.preventDefault(); document.getElementById('{{ substr($menu['url'], 1) }}').scrollIntoView({ behavior: 'smooth' }); @endif
                                    class="flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 border {{ $isActive ? 'bg-white text-blue-600 shadow-sm border-blue-200' : 'text-gray-700 hover:bg-white hover:text-blue-600 border-transparent hover:border-blue-200 hover:shadow-sm' }}">
                                    <i class="fas fa-{{ $menu['icon'] ?? 'circle' }} mr-2 {{ $isActive ? 'text-blue-600' : 'text-blue-500' }}"></i>
                                    {{ $menu['title'] }}
                                </a>
                            @else
                                <div x-data="{ open: false }" class="relative flex-shrink-0">
                                    <button @click="open = !open" @click.outside="open = false"
                                        class="flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 border {{ $hasActiveChild ? 'bg-white text-blue-600 shadow-sm border-blue-200' : 'text-gray-700 hover:bg-white hover:text-blue-600 border-transparent hover:border-blue-200 hover:shadow-sm' }}"
                                        :class="{ 'bg-white text-blue-600 shadow-sm border-blue-200': open }">
                                        <i class="fas fa-{{ $menu['icon'] ?? 'folder' }} mr-2 {{ $hasActiveChild ? 'text-blue-600' : 'text-blue-500' }}"></i>
                                        {{ \App\Helpers\GeneralHelper::wordLimit($menu['title']) }}
                                        <i class="fas fa-chevron-down h-3 w-3 ml-2 transition-transform duration-300 flex-shrink-0"
                                            :class="{ 'rotate-180': open }"></i>
                                    </button>
                                    <div x-show="open" x-transition
                                        class="absolute z-50 mt-2 w-72 rounded-lg shadow-xl bg-white border border-blue-100 min-w-max"
                                        style="display: none;">
                                        <div class="py-1">
                                            @foreach ($menu['children'] as $child)
                                                @php
                                                    $isChildActive = request()->is(trim($child['url'], '/') . '*') || request()->fullUrlIs(url($child['url']));
                                                @endphp
                                                <a href="{{ url($child['url']) }}"
                                                    class="flex items-center px-4 py-3 text-sm transition-all duration-200 whitespace-nowrap {{ $isChildActive ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">
                                                    <i
                                                        class="fas fa-{{ $child['icon'] ?? 'angle-right' }} mr-3 text-xs {{ $isChildActive ? 'text-blue-600' : 'text-blue-400' }}"></i>
                                                    {{ $child['title'] }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        <!-- Desktop Search Trigger (Icon Only) -->
                        <button @click="searchOpen = true; $nextTick(() => $refs.searchInput.focus())" 
                            class="flex items-center justify-center bg-blue-600 text-white hover:bg-blue-700 w-9 h-9 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-110 ml-2 flex-shrink-0">
                            <i class="fas fa-search text-base"></i>
                        </button>
                    </div>

                    <!-- Search Form Container -->
                    <div x-cloak class="absolute inset-0 flex items-center px-2 transition-all duration-500 ease-in-out"
                         :class="searchOpen ? 'opacity-100 scale-100 translate-y-0' : 'opacity-0 scale-95 translate-y-[10px] pointer-events-none'">
                        <form action="{{ route('frontend.informasi.search') }}" method="GET" class="w-full flex items-center">
                            <div class="relative w-full">
                                <input type="text" name="q" placeholder="Cari informasi, dokumen, atau OPD..." 
                                    class="w-full bg-transparent border-none py-2 pl-10 pr-10 text-sm focus:outline-none focus:ring-0 transition-all"
                                    x-ref="searchInput"
                                    @keydown.escape="searchOpen = false">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-blue-500 text-lg"></i>
                                </div>
                                <button type="button" @click="searchOpen = false" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                    <i class="fas fa-times-circle text-lg"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Login/User Dropdown & Mobile Menu Button -->
            <div class="flex items-center flex-shrink-0 pr-4 xl:pr-6 space-x-2">
                @guest
                    @php
                        $loginMenu = collect($menus)->firstWhere('title', 'Login');
                    @endphp
                    @if ($loginMenu)
                        <div class="hidden xl:block">
                            <a href="{{ route('login') }}"
                                class="flex items-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-2 rounded-lg text-sm font-medium transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                {{ $loginMenu['title'] }}
                            </a>
                        </div>
                    @endif
                @endguest

                @auth
                    <!-- Authenticated User Dropdown -->
                    <div class="hidden xl:relative xl:flex items-center" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center space-x-2 bg-blue-50 rounded-full p-1 pr-3 hover:bg-blue-100 transition-colors focus:outline-none">
                            @php
                                $fullName = Auth::user()->name;
                                $words = explode(' ', $fullName);
                                $truncatedWords = array_slice($words, 0, 3);
                                $displayableName = implode(' ', $truncatedWords);
                                // Remove any trailing non-alphanumeric characters from the displayable name
                                $displayableName = preg_replace('/[^\p{L}\p{N}\s]+$/u', '', $displayableName);
                            @endphp
                            @if (Auth::user()->profile_photo_path)
                                <img class="h-8 w-8 rounded-full object-cover"
                                    src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
                                    alt="{{ $displayableName }}">
                            @else
                                <x-initials-avatar :name="$displayableName" class="h-8 w-8" />
                            @endif
                            <div class="flex flex-col items-start">
                                <span class="text-gray-700 text-sm font-medium">{{ $displayableName }}</span>
                                @if (in_array(Auth::user()->role, ['admin', 'superadmin']))
                                    <span class="text-gray-500 text-xs">{{ Auth::user()->nip }}</span>
                                @else
                                    <span class="text-gray-500 text-xs">{{ Auth::user()->email }}</span>
                                @endif
                            </div>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>

                        <div x-show="open" @click.outside="open = false" x-transition x-cloak
                            class="absolute top-full right-0 mt-2 w-60 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-1">
                                <div class="px-4 py-2 border-b">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    @if (in_array(Auth::user()->role, ['admin', 'superadmin']))
                                        <p class="text-xs text-gray-500">{{ Auth::user()->nip }}</p>
                                    @else
                                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                    @endif
                                </div>
                                @if (Auth::user()->role === 'superadmin')
                                    <a href="{{ url('/admin/dashboard') }}"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-tachometer-alt w-5 mr-3 text-gray-400"></i>
                                        {{ __('Admin Dashboard') }}
                                    </a>
                                @endif
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-circle w-5 mr-3 text-gray-400"></i> {{ __('Profile') }}
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt w-5 mr-3 text-red-400"></i> {{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth

                <div class="xl:hidden">
                    <button @click="open = !open; activeSubMenu = null" class="text-gray-700 hover:text-blue-600 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="xl:hidden" x-cloak>
        <!-- Mobile Search -->
        <div class="px-4 pt-2 pb-3">
            <form action="{{ route('frontend.informasi.search') }}" method="GET" class="relative">
                <input type="text" name="q" placeholder="Cari informasi..." 
                    class="w-full bg-blue-50 border border-blue-100 rounded-xl py-2.5 pl-10 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fas fa-search text-blue-400 text-sm"></i>
                </div>
                <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center text-blue-600 hover:text-blue-700">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        </div>
        <div class="pt-2 pb-3 space-y-1 sm:px-3">
            @foreach ($menus as $menu)
                @php
                    $isActive = !empty($menu['url']) && $menu['url'] !== '#' && (request()->is(trim($menu['url'], '/') . '*') || request()->fullUrlIs(url($menu['url'])));
                    $hasActiveChild = false;
                    if (!empty($menu['children'])) {
                        foreach ($menu['children'] as $child) {
                            if (request()->is(trim($child['url'], '/') . '*') || request()->fullUrlIs(url($child['url']))) {
                                $hasActiveChild = true;
                                break;
                            }
                        }
                    }
                @endphp
                @if ($menu['title'] === 'Login' && Auth::check())
                    @continue
                @endif
                @if (empty($menu['children']))
                    <a href="{{ Str::startsWith($menu['url'], '#') ? '#' : url($menu['url']) }}"
                        @if (Str::startsWith($menu['url'], '#')) onclick="event.preventDefault(); document.getElementById('{{ substr($menu['url'], 1) }}').scrollIntoView({ behavior: 'smooth' }); open = false;" @endif
                        class="flex items-center py-2 px-3 text-base font-medium rounded-md {{ $isActive ? 'text-blue-600 bg-blue-50 font-bold' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-50' }}">
                        <i class="fas fa-{{ $menu['icon'] ?? 'circle' }} w-6 mr-2 {{ $isActive ? 'text-blue-600' : 'text-blue-500' }}"></i>
                        <span>{{ \App\Helpers\GeneralHelper::wordLimit($menu['title']) }}</span>
                    </a>
                @else
                    <div x-init="if({{ $hasActiveChild ? 'true' : 'false' }}) activeSubMenu = {{ $loop->index }}">
                        <button @click="activeSubMenu === {{ $loop->index }} ? activeSubMenu = null : activeSubMenu = {{ $loop->index }}"
                            class="w-full flex justify-between items-center py-2 px-3 text-base font-medium rounded-md {{ $hasActiveChild ? 'text-blue-600 bg-blue-50 font-bold' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-50' }}">
                            <span class="flex items-center">
                                <i class="fas fa-{{ $menu['icon'] ?? 'folder' }} w-6 mr-2 {{ $hasActiveChild ? 'text-blue-600' : 'text-blue-500' }}"></i>
                                {{ $menu['title'] }}
                            </span>
                            <i class="fas fa-chevron-down h-3 w-3 ml-2 transition-transform duration-300"
                                :class="{ 'rotate-180': activeSubMenu === {{ $loop->index }} }"></i>
                        </button>
                        <div x-show="activeSubMenu === {{ $loop->index }}" class="pl-4">
                            @foreach ($menu['children'] as $child)
                                @php
                                    $isChildActive = request()->is(trim($child['url'], '/') . '*') || request()->fullUrlIs(url($child['url']));
                                @endphp
                                <a href="{{ url($child['url']) }}"
                                    class="flex items-center py-2 px-3 text-base font-medium rounded-md {{ $isChildActive ? 'text-blue-700 bg-blue-50/50 font-bold' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50' }}">
                                    <i
                                        class="fas fa-{{ $child['icon'] ?? 'angle-right' }} w-6 mr-2 {{ $isChildActive ? 'text-blue-600' : 'text-blue-400' }}"></i>
                                    <span>{{ $child['title'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        @auth
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        @if (Auth::user()->profile_photo_path)
                            <img class="h-10 w-10 rounded-full object-cover"
                                src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
                                alt="{{ Auth::user()->name }}">
                        @else
                            <x-initials-avatar :name="Auth::user()->name" class="h-10 w-10" />
                        @endif
                    </div>

                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ $displayableName ?? Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        {{ __('Profile') }}
                    </a>
                    @if (Auth::user()->role === 'superadmin')
                        <a href="{{ url('/admin/dashboard') }}"
                            class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            {{ __('Admin Dashboard') }}
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            {{ __('Logout') }}
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
