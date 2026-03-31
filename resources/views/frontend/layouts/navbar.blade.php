<nav x-data="{ open: false, searchOpen: false, activeSubMenu: null }" class="bg-white shadow-lg sticky top-0 z-50 border-b border-blue-100"
    style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            {{-- Logo Section --}}
            <div class="flex-shrink-0 flex items-center group">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div class="relative overflow-hidden rounded-xl shadow-md p-1 bg-white border border-blue-50">
                        <img class="h-12 w-auto object-contain"
                            src="{{ asset('storage/logo/ppid.webp') }}"
                            alt="Logo PPID">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-black tracking-tighter text-blue-900 leading-none uppercase">PPID</span>
                        <span class="text-[10px] font-bold text-blue-600 tracking-widest uppercase mt-0.5">Kabupaten Sinjai</span>
                    </div>
                </a>
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden lg:flex lg:items-center lg:space-x-1 relative w-full max-w-2xl px-8">
                <div class="relative flex items-center justify-center w-full">
                    <!-- Menu List Container -->
                    <div class="flex items-center space-x-1 whitespace-nowrap w-full justify-center"
                         :class="searchOpen ? 'opacity-0 pointer-events-none' : 'opacity-100'">
                        @foreach ($menus as $menu)
                            @php
                                $isActive = !empty($menu['url']) && $menu['url'] !== '#' && (request()->is(trim($menu['url'], '/') . '*') || request()->fullUrlIs(url($menu['url'])));
                                $hasActiveChild = false;
                                if (!empty($menu['children'])) {
                                    foreach ($menu['children'] as $child) {
                                        if (!empty($child['url']) && $child['url'] !== '#' && (request()->is(trim($child['url'], '/') . '*') || request()->fullUrlIs(url($child['url'])))) {
                                            $hasActiveChild = true;
                                            break;
                                        }
                                    }
                                }
                            @endphp

                            <div class="relative group/menu" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                <a href="{{ !empty($menu['url']) ? url($menu['url']) : '#' }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-bold tracking-tight rounded-xl {{ $isActive || $hasActiveChild ? 'text-blue-700 bg-blue-50/80 shadow-sm border border-blue-100/50' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                                    <span>{{ $menu['title'] }}</span>
                                    @if (!empty($menu['children']))
                                        <i class="fas fa-chevron-down ml-2 text-[10px] opacity-50 group-hover/menu:rotate-180 transition-transform"></i>
                                    @endif
                                </a>

                                @if (!empty($menu['children']))
                                    <div x-show="open" 
                                        x-cloak
                                        class="absolute left-0 w-64 mt-1 bg-white rounded-2xl shadow-2xl border border-blue-50 py-3 z-[60]">
                                        @foreach ($menu['children'] as $child)
                                            <a href="{{ !empty($child['url']) ? url($child['url']) : '#' }}"
                                                class="block px-5 py-2.5 text-sm font-bold text-slate-600 hover:text-blue-700 hover:bg-blue-50/50 flex items-center group/item {{ request()->fullUrlIs(url($child['url'])) ? 'text-blue-700 bg-blue-50/30' : '' }}">
                                                <div class="w-1.5 h-1.5 rounded-full bg-blue-200 mr-3 group-hover/item:scale-125 group-hover/item:bg-blue-500 transition-all"></div>
                                                {{ $child['title'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Desktop Search Overlay --}}
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none" 
                         :class="searchOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0'">
                        <form action="{{ route('frontend.informasi.search') }}" method="GET" class="w-full max-w-xl">
                            <div class="relative group">
                                <input type="text" name="q" placeholder="Cari informasi publik..."
                                    class="w-full bg-slate-100 border-2 border-transparent focus:border-blue-500 focus:bg-white focus:ring-0 rounded-2xl py-3 px-12 text-sm font-bold text-slate-800 shadow-inner transition-all"
                                    x-ref="searchInput">
                                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <button type="button" @click="searchOpen = false"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-500 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Right Controls --}}
            <div class="flex items-center space-x-3">
                <button @click="searchOpen = !searchOpen; if(searchOpen) setTimeout(() => $refs.searchInput.focus(), 100)"
                    class="p-3 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-2xl transition-all relative group"
                    title="Cari">
                    <i class="fas fa-search text-xl" :class="searchOpen ? 'hidden' : 'block'"></i>
                    <i class="fas fa-times text-xl" :class="searchOpen ? 'block' : 'hidden'"></i>
                </button>

                @auth
                    <div class="relative flex items-center" x-data="{ userOpen: false }">
                        <button @click="userOpen = !userOpen" 
                            class="flex items-center space-x-3 p-1.5 pr-4 bg-slate-50 rounded-2xl border border-slate-100 hover:border-blue-200 transition-all group">
                            <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white font-black shadow-lg shadow-blue-200 group-hover:scale-105 transition-transform uppercase">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="hidden xl:flex flex-col items-start leading-tight">
                                <span class="text-xs font-black text-slate-800 uppercase tracking-tight">{{ Auth::user()->name }}</span>
                                <span class="text-[9px] font-bold text-blue-600 uppercase">{{ Auth::user()->role }}</span>
                            </div>
                        </button>

                        <div x-show="userOpen" @click.away="userOpen = false" x-cloak
                            class="absolute right-0 top-full mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-blue-50 py-3 z-[60]">
                            <a href="{{ route('admin.dashboard') }}" class="block px-5 py-2.5 text-sm font-bold text-slate-600 hover:text-blue-700 hover:bg-blue-50 flex items-center">
                                <i class="fas fa-th-large mr-3 opacity-50"></i> Panel Admin
                            </a>
                            <hr class="my-2 border-slate-50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-5 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 flex items-center">
                                    <i class="fas fa-sign-out-alt mr-3 opacity-50"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="hidden md:inline-flex items-center px-6 py-3 text-sm font-black tracking-tight text-white bg-blue-600 hover:bg-blue-700 rounded-2xl shadow-lg shadow-blue-200 hover:shadow-blue-300 transition-all active:scale-95 uppercase">
                        Masuk
                    </a>
                @endauth

                {{-- Mobile Menu Button --}}
                <div class="lg:hidden">
                    <button @click="open = !open"
                        class="p-3 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-2xl transition-all">
                        <i class="fas fa-bars text-2xl" :class="open ? 'hidden' : 'block'"></i>
                        <i class="fas fa-times text-2xl" :class="open ? 'block' : 'hidden'"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Navigation --}}
    <div x-show="open" x-cloak class="lg:hidden bg-white border-t border-blue-50 py-4 px-4 space-y-2 shadow-inner">
        <form action="{{ route('frontend.informasi.search') }}" method="GET" class="mb-6">
            <div class="relative">
                <input type="text" name="q" placeholder="Cari informasi..."
                    class="w-full bg-slate-50 border-2 border-slate-100 focus:border-blue-500 rounded-xl py-3 pl-10 text-sm font-bold uppercase tracking-tight">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            </div>
        </form>

        @foreach ($menus as $menu)
            <div x-data="{ mobileSub: false }">
                <div class="flex items-center justify-between">
                    <a href="{{ !empty($menu['url']) ? url($menu['url']) : '#' }}"
                        class="flex-grow py-3 px-4 text-sm font-black text-slate-700 hover:bg-blue-50 rounded-xl uppercase tracking-tighter">
                        {{ $menu['title'] }}
                    </a>
                    @if (!empty($menu['children']))
                        <button @click="mobileSub = !mobileSub" class="p-3 text-blue-600">
                            <i class="fas fa-chevron-down transition-transform" :class="mobileSub ? 'rotate-180' : ''"></i>
                        </button>
                    @endif
                </div>
                @if (!empty($menu['children']))
                    <div x-show="mobileSub" class="pl-6 pr-2 py-2 space-y-1 bg-slate-50 rounded-2xl mt-1 shadow-inner">
                        @foreach ($menu['children'] as $child)
                            <a href="{{ !empty($child['url']) ? url($child['url']) : '#' }}"
                                class="block py-2.5 px-4 text-[11px] font-extrabold text-slate-600 hover:text-blue-700 border-l-2 border-blue-100 uppercase tracking-widest">
                                {{ $child['title'] }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach

        @guest
            <div class="pt-6">
                <a href="{{ route('login') }}"
                    class="block w-full text-center py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl uppercase tracking-widest">
                    Masuk Portal
                </a>
            </div>
        @endguest
    </div>
</nav>
