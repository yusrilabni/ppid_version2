<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PPID @hasSection('title')
            - @yield('title')
        @endif
    </title>
    <meta name="description" content="Pejabat Pengelola Informasi dan Dokumentasi">

    <!-- Turbo & Asset Trackers -->
    <script src="https://unpkg.com/@hotwired/turbo@7.3.0/dist/turbo.es2017-umd.js" data-turbo-track="reload"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" data-turbo-track="reload">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" data-turbo-track="reload" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" data-turbo-track="reload">

    <style>
        [x-cloak] { display: none !important; }
        /* Instant Navigation Feel */
        .turbo-progress-bar {
            height: 2px !important;
            background-color: #2563eb !important;
        }
        
        /* Navbar Sticky & Static Feel - NO FLICKER */
        #main-navbar-container {
            position: sticky;
            top: 0;
            z-index: 100;
            background: white;
            transition: none !important;
        }
        
        /* Smooth Fade In for Main Content */
        main {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        // High-Performance Turbo Configuration
        document.addEventListener('turbo:load', function() {
            if (window.tailwind) { window.tailwind.run(); }
            if (window.lucide) { window.lucide.createIcons(); }
        });
        
        // Instant Hover Prefetch for Turbo
        document.addEventListener('mouseover', (event) => {
            if (event.target.tagName === 'A' && event.target.href && !event.target.hasAttribute('data-turbo-prefetch')) {
                event.target.setAttribute('data-turbo-prefetch', 'true');
            }
        });
    </script>
    @stack('styles')
</head>

<body class="antialiased bg-gray-100 text-gray-800" data-turbo="true">
    <div id="acc-main-wrapper" style="min-height: 100vh;">
        <!-- NAVBAR - TURBO PERMANENT (TIDAK AKAN DI-RENDER ULANG) -->
        <header id="main-navbar-container" data-turbo-permanent>
            @include('frontend.layouts.navbar')
        </header>

        <main id="main-content">
            @yield('content')
        </main>

        <footer id="main-footer-container" data-turbo-permanent>
            @include('frontend.layouts.footer')
        </footer>
    </div>
    @stack('scripts')
</body>
</html>
