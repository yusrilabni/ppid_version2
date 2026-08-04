<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-H7VECPDPPH"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-H7VECPDPPH');
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PPID Admin - @yield('title')</title>

    <link rel="icon" type="image/webp" href="{{ asset('storage/logo/favicon_io/ppid.webp') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/logo/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/logo/favicon_io/favicon-16x16.png') }}">

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" crossorigin="anonymous"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom styles -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-CSxGih6d.css') }}">

    <!-- Additional dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom CSS for MINIMIZE sidebar functionality -->
    <style>
        .sidebar {
            width: 16rem; /* 256px */
            transition: width 0.3s ease-in-out;
        }
        .main-content {
            margin-left: 16rem; /* 256px */
            transition: margin-left 0.3s ease-in-out;
        }

        /* Collapsed state for the sidebar */
        .sidebar.collapsed {
            width: 5rem; /* 80px */
        }
        .main-content.collapsed {
            margin-left: 5rem; /* 80px */
        }

        /* Hide menu text and large logo when collapsed */
        .sidebar.collapsed .menu-text,
        .sidebar.collapsed .sidebar-logo-large {
            display: none;
        }

        /* Show the small logo only when collapsed */
        .sidebar:not(.collapsed) .sidebar-logo-small {
            display: none;
        }
        .sidebar.collapsed .sidebar-logo-small {
            display: flex;
        }

        /* Center icons and remove margins when collapsed for alignment */
        .sidebar.collapsed .menu-item {
            justify-content: center;
        }
        .sidebar.collapsed .menu-item .mx-3 {
            margin: 0;
        }
        .sidebar.collapsed .menu-item > i {
            margin-right: 0 !important;
        }

        /* Tooltip for collapsed menu items */
        .sidebar.collapsed .menu-item {
            position: relative;
        }
        .sidebar.collapsed .menu-item::after {
            content: attr(title);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background-color: #1e3a8a; /* bg-blue-900 */
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem; /* rounded-md */
            white-space: nowrap;
            font-size: 0.875rem;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s, visibility 0.2s;
            z-index: 100;
            margin-left: 0.75rem;
        }
        .sidebar.collapsed .menu-item:hover::after {
            opacity: 1;
            visibility: visible;
        }

        /* Separator icon visibility */
        .sidebar:not(.collapsed) .separator-icon {
            display: none;
        }
        .sidebar.collapsed .separator-icon {
            display: flex;
        }


        /* Mobile specific styles */
        @media (max-width: 1023px) {
            .sidebar {
                position: fixed !important;
                top: 0 !important;
                bottom: 0 !important;
                left: 0 !important;
                height: 100vh !important;
                z-index: 50 !important;
                width: 280px !important;
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
                box-shadow: 10px 0 15px -3px rgba(0, 0, 0, 0.1);
            }
            .sidebar.show {
                transform: translateX(0) !important;
            }
            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div x-data="{
            sidebarCollapsed: false,
            sidebarOpenMobile: false,
            isMobile: window.innerWidth < 1024
         }"
         x-init="
            window.addEventListener('resize', () => {
                isMobile = window.innerWidth < 1024;
                if (isMobile) {
                    sidebarCollapsed = false;
                }
            })
         "
         class="relative min-h-screen lg:flex">

        <!-- Sidebar -->
        <aside id="sidebar"
               class="sidebar fixed inset-y-0 left-0 z-40 bg-white"
               :class="{ 
                   'collapsed': !isMobile && sidebarCollapsed,
                   'show': isMobile && sidebarOpenMobile 
               }"
               x-show="!isMobile || sidebarOpenMobile"
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="opacity-0 -translate-x-full"
               x-transition:enter-end="opacity-100 translate-x-0"
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="opacity-100 translate-x-0"
               x-transition:leave-end="opacity-0 -translate-x-full"
        >
            @include('admin.layouts.sidebar')
        </aside>

        <!-- Main Content Wrapper -->
        <div class="main-content flex-1 flex flex-col min-w-0 overflow-x-hidden"
             :class="{ 'collapsed': sidebarCollapsed && !isMobile }">

            <!-- Topbar -->
            <header class="bg-white shadow-sm border-b z-20 sticky top-0">
                @include('admin.layouts.topbar')
            </header>

            <!-- Main content area -->
            <main id="main-content-area" class="flex-1 p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>

        <!-- Mobile overlay, shown when the sidebar is open on mobile -->
        <div x-show="sidebarOpenMobile && isMobile"
             @click="sidebarOpenMobile = false"
             class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden"
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:leave="transition-opacity ease-in duration-200">
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Optional: Initialize collapse functionality for sidebar sub-menus if needed
        document.addEventListener('DOMContentLoaded', function() {
            const collapsibles = document.querySelectorAll('[data-collapse-toggle]');
            collapsibles.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('aria-controls');
                    const target = document.getElementById(targetId);
                    if (target) {
                        target.classList.toggle('hidden');
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const sidebar = document.getElementById('admin-sidebar-scroll-container');
            if (sidebar) {
                const scrollPos = localStorage.getItem('sidebarScroll');
                if (scrollPos) {
                    sidebar.scrollTop = parseInt(scrollPos, 10);
                }

                window.addEventListener('beforeunload', () => {
                    localStorage.setItem('sidebarScroll', sidebar.scrollTop);
                });
            }
        });
    </script>
    @stack('scripts')
    <script>
        // Skrip untuk memberikan peringatan saat merubah data di lingkungan lokal
        document.addEventListener('submit', function(e) {
            // Cek jika berjalan di localhost atau 127.0.0.1
            if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
                // Tampilkan konfirmasi alert
                if (!confirm('Peringatan: Anda sedang merubah data atau konfigurasi di lingkungan LOKAL. Apakah Anda yakin ingin melanjutkan perubahan ini?')) {
                    e.preventDefault();
                }
            }
        });
    </script>
</body>
</html>