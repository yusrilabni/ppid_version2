{{-- Admin Topbar --}}
<div class="flex justify-between items-center p-4">
    <div class="flex items-center space-x-3">

        {{-- Desktop Toggle Button --}}
        <button x-show="!isMobile"
                @click="sidebarCollapsed = !sidebarCollapsed"
                class="text-gray-700 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100">
            <i class="bi" :class="sidebarCollapsed ? 'bi-chevron-right' : 'bi-chevron-left'"></i>
        </button>

        {{-- Mobile Toggle Button --}}
        <button x-show="isMobile"
                @click="sidebarOpenMobile = !sidebarOpenMobile"
                class="text-gray-700 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100">
            <i class="bi" :class="sidebarOpenMobile ? 'bi-x-lg' : 'bi-list'"></i>
        </button>

        <h1 class="text-xl font-bold text-gray-900">@yield('title', 'Admin Dashboard')</h1>
    </div>
    <div class="flex items-center space-x-4">

        {{-- Desktop Icons --}}
        <div x-show="!isMobile" class="flex items-center space-x-4">
            <!-- Notification -->
            <div class="relative">
                <button type="button" class="text-gray-700 hover:text-gray-900">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">3</span>
                </button>
            </div>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-700 hover:text-red-500">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>

    </div>
</div>
