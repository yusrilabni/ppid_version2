{{--
  This is the single, unified sidebar.
  It's wrapped in a container that handles the scrolling and structure.
--}}
<div id="admin-sidebar-scroll-container" class="flex flex-col h-full bg-gradient-to-b from-blue-800 to-blue-900 text-white overflow-y-auto">

    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-16 px-4 border-b border-blue-700 flex-shrink-0">

        <!-- Logo container -->
        <div class="flex items-center">
            {{-- Large logo, shown by default --}}
                            <a href="{{ route('home') }}" class="sidebar-logo-large text-xl font-bold flex items-center">
                                <i class="fas fa-shield-alt mr-2"></i>
                                <span class="menu-text">PPID Admin</span>
                            </a>
                            {{-- Small logo, shown only when collapsed --}}
                            <a href="{{ route('home') }}" class="sidebar-logo-small text-xl font-bold items-center justify-center">
                                <i class="fas fa-shield-alt"></i>
                            </a>        </div>

        {{-- This button is for closing the sidebar on mobile when it's an overlay --}}
        <button @click="sidebarOpenMobile = false" class="lg:hidden text-white">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>


    <!-- Main Navigation -->
    <div class="flex-1">
        <nav class="pt-4 pb-4">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white transition-colors duration-200 menu-item @if(request()->routeIs('admin.dashboard')) bg-blue-700 bg-opacity-75 @endif" title="Dashboard">
                <i class="fas fa-tachometer-alt w-5"></i>
                <span class="mx-3 menu-text">Dashboard</span>
            </a>

            <div class="mt-6 px-4">
                <div class="h-8 flex items-center justify-center">
                    <h3 class="menu-text w-full text-xs uppercase text-blue-300 font-semibold tracking-wider">Manajemen Informasi</h3>
                    <div class="separator-icon justify-center w-full">
                        <i class="bi bi-three-dots text-blue-400"></i>
                    </div>
                </div>
                @can('viewAny', App\Models\Informasi::class)
                <a href="{{ route('admin.informasi-crud.index') }}" class="flex items-center px-4 py-2 text-blue-200 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white rounded-lg transition-colors duration-200 my-1 menu-item @if(request()->routeIs('admin.informasi-crud.*')) bg-blue-700 bg-opacity-75 @endif" title="Informasi">
                    <i class="fas fa-info-circle w-4 mr-3"></i>
                    <span class="menu-text">Informasi</span>
                </a>
                <a href="{{ route('admin.informasi-pemkab.index') }}" class="flex items-center px-4 py-2 text-blue-200 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white rounded-lg transition-colors duration-200 my-1 menu-item @if(request()->routeIs('admin.informasi-pemkab.*')) bg-blue-700 bg-opacity-75 @endif" title="Informasi Pemkab">
                    <i class="fas fa-file-invoice w-4 mr-3"></i>
                    <span class="menu-text">Informasi Pemkab</span>
                </a>
                @endcan
                <a href="{{ route('admin.standar-layanan.index') }}" class="flex items-center px-4 py-2 text-blue-200 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white rounded-lg transition-colors duration-200 my-1 menu-item @if(request()->routeIs('admin.standar-layanan.*')) bg-blue-700 bg-opacity-75 @endif" title="Standar Layanan">
                    <i class="fas fa-clipboard-list w-4 mr-3"></i>
                    <span class="menu-text">Standar Layanan</span>
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="flex items-center px-4 py-2 text-blue-200 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white rounded-lg transition-colors duration-200 my-1 menu-item @if(request()->routeIs('admin.laporan.*')) bg-blue-700 bg-opacity-75 @endif" title="Laporan">
                    <i class="fas fa-file-alt w-4 mr-3"></i>
                    <span class="menu-text">Laporan</span>
                </a>
                <a href="{{ route('admin.permohonan-informasi.index') }}" class="flex items-center px-4 py-2 text-blue-200 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white rounded-lg transition-colors duration-200 my-1 menu-item @if(request()->routeIs('admin.permohonan-informasi.*')) bg-blue-700 bg-opacity-75 @endif" title="Permohonan Informasi">
                    <i class="fas fa-file-signature w-4 mr-3"></i>
                    <span class="menu-text">Permohonan Informasi</span>
                </a>
                @if(Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.surveys.index') }}" class="flex items-center px-4 py-2 text-blue-200 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white rounded-lg transition-colors duration-200 my-1 menu-item @if(request()->routeIs('admin.surveys.*')) bg-blue-700 bg-opacity-75 @endif" title="Daftar Survei">
                    <i class="fas fa-poll w-4 mr-3"></i>
                    <span class="menu-text">Survei Kepuasan</span>
                </a>
                <a href="{{ route('admin.pbj-questions.index') }}" class="flex items-center px-4 py-2 text-blue-200 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white rounded-lg transition-colors duration-200 my-1 menu-item @if(request()->routeIs('admin.pbj-questions.*')) bg-blue-700 bg-opacity-75 @endif" title="PBJ">
                    <i class="fas fa-shopping-cart w-4 mr-3"></i>
                    <span class="menu-text">PBJ</span>
                </a>
                @endif
            </div>

            <div class="mt-6 px-4">
                <div class="h-8 flex items-center justify-center">
                    <h3 class="menu-text w-full text-xs uppercase text-blue-300 font-semibold tracking-wider">Manajemen Struktur</h3>   
                    <div class="separator-icon justify-center w-full">
                        <i class="bi bi-three-dots text-blue-400"></i>
                    </div>
                </div>
                <a href="{{ route('admin.organizations.index') }}" class="flex items-center px-4 py-2 text-blue-200 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white rounded-lg transition-colors duration-200 my-1 menu-item @if(request()->routeIs('admin.organizations.*') && !request()->routeIs('admin.organizations.structures')) bg-blue-700 bg-opacity-75 @endif" title="Organisasi">
                    <i class="fas fa-building w-4 mr-3"></i>
                    <span class="menu-text">Organisasi</span>
                </a>
                <a href="{{ route('admin.officials.index') }}" class="flex items-center px-4 py-2 text-blue-200 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white rounded-lg transition-colors duration-200 my-1 menu-item @if(request()->routeIs('admin.officials.*')) bg-blue-700 bg-opacity-75 @endif" title="Profil Pimpinan">
                    <i class="fas fa-users w-4 mr-3"></i>
                    <span class="menu-text">Profil Pimpinan</span>
                </a>
                <a href="{{ route('admin.lhkpn.index') }}" class="flex items-center px-4 py-2 text-blue-200 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white rounded-lg transition-colors duration-200 my-1 menu-item @if(request()->routeIs('admin.lhkpn.*') || request()->routeIs('admin.officials.lhkpn.*')) bg-blue-700 bg-opacity-75 @endif" title="LHKPN">
                    <i class="fas fa-file-invoice-dollar w-4 mr-3"></i>
                    <span class="menu-text">LHKPN</span>
                </a>
                @if(Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.profil-ppid.index') }}" class="flex items-center px-4 py-2 text-blue-200 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white rounded-lg transition-colors duration-200 my-1 menu-item @if(request()->routeIs('admin.profil-ppid.*')) bg-blue-700 bg-opacity-75 @endif" title="Profil PPID">
                    <i class="fas fa-info-circle w-4 mr-3"></i>
                    <span class="menu-text">Profil PPID</span>
                </a>
                @endif
            </div>

            <div class="mt-6 px-4">
                <div class="h-8 flex items-center justify-center">
                    <h3 class="menu-text w-full text-xs uppercase text-blue-300 font-semibold tracking-wider">Manajemen Website</h3>    
                    <div class="separator-icon justify-center w-full">
                        <i class="bi bi-three-dots text-blue-400"></i>
                    </div>
                </div>
                @if(Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.sliders.index') }}" class="flex items-center px-4 py-2 text-blue-200 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white rounded-lg transition-colors duration-200 my-1 menu-item @if(request()->routeIs('admin.sliders.*')) bg-blue-700 bg-opacity-75 @endif" title="Sliders">
                    <i class="fas fa-images w-4 mr-3"></i>
                    <span class="menu-text">Sliders</span>
                </a>
                @endif
                <a href="{{ route('admin.galeri.index') }}" class="flex items-center px-4 py-2 text-blue-200 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white rounded-lg transition-colors duration-200 my-1 menu-item @if(request()->routeIs('admin.galeri.*')) bg-blue-700 bg-opacity-75 @endif" title="Galeri">
                    <i class="fas fa-photo-video w-4 mr-3"></i>
                    <span class="menu-text">Galeri</span>
                </a>
                @if(Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 text-blue-200 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white rounded-lg transition-colors duration-200 my-1 menu-item @if(request()->routeIs('admin.users.*')) bg-blue-700 bg-opacity-75 @endif" title="Users">
                    <i class="fas fa-users w-4 mr-3"></i>
                    <span class="menu-text">Users</span>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 py-2 text-blue-200 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white rounded-lg transition-colors duration-200 my-1 menu-item @if(request()->routeIs('admin.reports.*')) bg-blue-700 bg-opacity-75 @endif" title="Laporan">
                    <i class="fas fa-chart-line w-4 mr-3"></i>
                    <span class="menu-text">Laporan PPID</span>
                </a>
                <a href="{{ route('admin.ai-settings.index') }}" class="flex items-center px-4 py-2 text-blue-200 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white rounded-lg transition-colors duration-200 my-1 menu-item @if(request()->routeIs('admin.ai-settings.*')) bg-blue-700 bg-opacity-75 @endif" title="Pengaturan AI">
                    <i class="fas fa-robot w-4 mr-3"></i>
                    <span class="menu-text">Pengaturan AI</span>
                </a>
                <a href="{{ route('admin.api-logs.index') }}" class="flex items-center px-4 py-2 text-blue-200 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white rounded-lg transition-colors duration-200 my-1 menu-item @if(request()->routeIs('admin.api-logs.*')) bg-blue-700 bg-opacity-75 @endif" title="API Tracker">
                    <i class="fas fa-shield-alt w-4 mr-3"></i>
                    <span class="menu-text">API Tracker</span>
                </a>
                @endif            </div>
        </nav>
    </div>

    <!-- User Profile Footer -->
    <div class="p-3 border-t border-blue-700 bg-blue-800 flex-shrink-0">
        <div class="flex items-center justify-between" :class="{ 'justify-center': !isMobile && sidebarCollapsed }">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    @if(Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Profile" class="w-8 h-8 rounded-full object-cover">
                    @else
                        <div class="bg-gray-200 border-2 border-dashed rounded-full w-8 h-8 flex items-center justify-center">
                            <i class="fas fa-user text-gray-600 text-xs"></i>
                        </div>
                    @endif
                </div>
                <div class="ml-2 flex-1 menu-text" x-show="isMobile || !sidebarCollapsed">
                    <p class="text-xs font-medium text-white">{{ implode(' ', array_slice(explode(' ', Auth::user()->name), 0, 3)) }}</p>
                    @if(Auth::user()->nip)
                        <p class="text-xs text-blue-200">{{ Auth::user()->nip }}</p>
                    @endif
                </div>
            </div>
            
            {{-- Logout button in sidebar for mobile --}}
            <div x-show="isMobile" class="flex items-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-blue-200 hover:text-white p-2">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>