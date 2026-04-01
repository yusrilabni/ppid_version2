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

    <script>
        // Force manual restoration
        if ('scrollRestoration' in history) { history.scrollRestoration = 'manual'; }
    </script>

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('storage/logo/favicon_io/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" type="image/webp" href="{{ asset('storage/logo/favicon_io/ppid.webp') }}">

    <!-- Scripts -->
    <script src="https://unpkg.com/@hotwired/turbo@7.3.0/dist/turbo.es2017-umd.js" data-turbo-track="reload"></script>
    <style>
        [x-cloak] { display: none !important; }
        
        /* Sembunyikan Turbo Progress Bar agar loading hanya di tab browser */
        .turbo-progress-bar {
            display: none !important;
            height: 0 !important;
            opacity: 0 !important;
        }

        /* Navbar Sticky */
        #main-navbar-container {
            position: sticky;
            top: 0;
            z-index: 100;
            background: white;
        }

        /* Swiper Pagination */
        .swiper-pagination-bullet { opacity: 0.3 !important; background: gray !important; }
        .swiper-pagination-bullet-active { opacity: 1 !important; background: #2563eb !important; }
        .swiper-pagination { bottom: 0 !important; height: 30px; display: flex; justify-content: center; align-items: center; gap: 8px; }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'blue': {
                            50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa',
                            500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a',
                        },
                        'green': {
                            50: '#f0fdf4', 100: '#dcfce7', 200: '#bbf7d0', 300: '#86efac', 400: '#4ade80',
                            500: '#22c55e', 600: '#16a34a', 700: '#15803d', 800: '#166534', 900: '#14532d',
                        },
                        'yellow': {
                            50: '#fefce8', 100: '#fef9c3', 200: '#fef08a', 300: '#fde047', 400: '#facc15',
                            500: '#eab308', 600: '#ca8a04', 700: '#a16207', 800: '#854d0e', 900: '#713f12',
                        },
                        'red': {
                            50: '#fef2f2', 100: '#fee2e2', 200: '#fecaca', 300: '#fca5a5', 400: '#f87171',
                            500: '#ef4444', 600: '#dc2626', 700: '#b91c1c', 800: '#991b1b', 900: '#7f1d1d',
                        },
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        var saveScroll = function() {
            var scrollKey = 'scrollPos_' + btoa(window.location.href);
            localStorage.setItem(scrollKey, window.scrollY);
        };
        
        window.addEventListener('scroll', function() {
            clearTimeout(window.scrollTimeout);
            window.scrollTimeout = setTimeout(saveScroll, 100);
        });

        window.addEventListener('turbo:before-visit', saveScroll);
        
        document.addEventListener('turbo:load', function() {
            if (window.tailwind) { window.tailwind.run(); }
            if (window.lucide) { window.lucide.createIcons(); }
        });

        document.addEventListener('alpine:init', () => {
            Alpine.store('accConfig', {
                isOpen: false,
                fontLevel: localStorage.getItem('acc_font_level') || 'normal',
                contrast: localStorage.getItem('acc_contrast') || 'default', 
                links: localStorage.getItem('acc_links') === 'true',
                headings: localStorage.getItem('acc_headings') === 'true',
                focus: localStorage.getItem('acc_focus') || 'default', 
                keyboard: localStorage.getItem('acc_keyboard') === 'true',
                textSpacing: localStorage.getItem('acc_text_spacing') === 'true',
                hideImages: localStorage.getItem('acc_hide_images') === 'true',
                dyslexic: localStorage.getItem('acc_dyslexic') || 'default', 
                lineHeight: localStorage.getItem('acc_line_height') === 'true',
                alignment: localStorage.getItem('acc_alignment') || 'default', 
                saturation: localStorage.getItem('acc_saturation') || 'default', 
                fontMap: { 'kecil': 12, 'normal': 16, 'sedang': 20, 'besar': 24 },
                init() { this.applyPersisted(); },
                applyPersisted() { document.documentElement.style.fontSize = this.getFontSize() + 'px'; },
                getFontSize() { return this.fontMap[this.fontLevel] || 16; },
                setFontLevel(level) {
                    this.fontLevel = level;
                    localStorage.setItem('acc_font_level', level);
                    document.documentElement.style.fontSize = this.getFontSize() + 'px';
                },
                update(key, val) { 
                    this[key] = val; 
                    localStorage.setItem('acc_' + key, val); 
                },
                toggleMenu() { this.isOpen = !this.isOpen; },
                cycleContrast() {
                    const modes = ['default', 'light', 'invert', 'dark'];
                    this.contrast = modes[(modes.indexOf(this.contrast) + 1) % modes.length];
                    localStorage.setItem('acc_contrast', this.contrast);
                },
                cycleFocus() {
                    const modes = ['default', 'cursor', 'mask', 'guide'];
                    this.focus = modes[(modes.indexOf(this.focus) + 1) % modes.length];
                    localStorage.setItem('acc_focus', this.focus);
                },
                cycleDyslexic() {
                    const modes = ['default', 'open', 'lexend'];
                    this.dyslexic = modes[(modes.indexOf(this.dyslexic) + 1) % modes.length];
                    localStorage.setItem('acc_dyslexic', this.dyslexic);
                },
                cycleAlignment() {
                    const modes = ['default', 'left', 'center', 'right'];
                    this.alignment = modes[(modes.indexOf(this.alignment) + 1) % modes.length];
                    localStorage.setItem('acc_alignment', this.alignment);
                },
                cycleSaturation() {
                    const modes = ['default', 'low', 'high', 'mono'];
                    this.saturation = modes[(modes.indexOf(this.saturation) + 1) % modes.length];
                    localStorage.setItem('acc_saturation', this.saturation);
                }
            });

            Alpine.store('surveyModal', {
                open: false,
                init() {
                    const isHome = window.location.pathname === '/' || window.location.pathname === '/home';
                    if (!isHome) return;
                    setTimeout(() => { this.open = true; }, 4000);
                },
                close() { this.open = false; }
            });
        })
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" data-turbo-track="reload">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" data-turbo-track="reload" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" data-turbo-track="reload">
    <style>
        .news-carousel, .info-carousel { width: 100%; overflow: hidden; }
        .info-carousel .swiper-slide { height: auto; }
        
        /* Accessibility Styles */
        #acc-main-wrapper.acc-contrast-light, #acc-main-wrapper.acc-contrast-light *:not(.acc-ignore) { background-color: #fff !important; color: #000 !important; }
        #acc-main-wrapper.acc-contrast-dark, #acc-main-wrapper.acc-contrast-dark *:not(.acc-ignore) { background-color: #000 !important; color: #ff0 !important; }
        .acc-reading-mask { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 999998; background: rgba(0,0,0,0.85); display: none; }
        body.acc-focus-mask .acc-reading-mask { display: block !important; }
    </style>
    @stack('styles')
</head>

<body class="antialiased bg-gray-100 text-gray-800" data-turbo="true" x-data="{}"
    :class="$store.accConfig ? { 
        'acc-highlight-links': $store.accConfig.links, 
        'acc-highlight-headings': $store.accConfig.headings, 
        'acc-text-spacing': $store.accConfig.textSpacing, 
        'acc-dyslexic-open': $store.accConfig.dyslexic === 'open', 
        'acc-dyslexic-lexend': $store.accConfig.dyslexic === 'lexend', 
        'acc-line-height': $store.accConfig.lineHeight, 
        'acc-align-left': $store.accConfig.alignment === 'left', 
        'acc-align-center': $store.accConfig.alignment === 'center', 
        'acc-align-right': $store.accConfig.alignment === 'right',
        'acc-focus-mask': $store.accConfig.focus === 'mask', 
        'acc-focus-guide': $store.accConfig.focus === 'guide', 
        'acc-big-cursor': $store.accConfig.focus === 'cursor', 
        'acc-keyboard-nav': $store.accConfig.keyboard
    } : {}"
    :style="{ fontSize: $store.accConfig ? $store.accConfig.getFontSize() + 'px' : '16px' }">

    <div id="acc-main-wrapper" 
        :class="$store.accConfig ? { 
            'acc-contrast-light': $store.accConfig.contrast === 'light', 
            'acc-contrast-invert': $store.accConfig.contrast === 'invert', 
            'acc-contrast-dark': $store.accConfig.contrast === 'dark', 
            'acc-sat-low': $store.accConfig.saturation === 'low', 
            'acc-sat-high': $store.accConfig.saturation === 'high', 
            'acc-sat-mono': $store.accConfig.saturation === 'mono', 
            'acc-hide-images': $store.accConfig.hideImages
        } : {}"
        style="min-height: 100vh;">
        
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

    <div class="acc-reading-mask" id="reading-mask"></div>

    <!-- Accessibility Widget -->
    <div x-data="accessibilityWidget()" class="fixed z-[99999]" style="bottom: 24px; left: 24px;">
        <button @click="$store.accConfig.toggleMenu()" class="bg-blue-600 text-white w-16 h-16 rounded-full shadow-lg flex items-center justify-center">
            <i class="fas fa-universal-access text-3xl"></i>
        </button>
    </div>

    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script>
        function accessibilityWidget() {
            return {
                init() {
                    document.addEventListener('mousemove', (e) => {
                        const mask = document.getElementById('reading-mask');
                        if (mask && Alpine.store('accConfig').focus === 'mask') {
                            const y = e.clientY;
                            mask.style.clipPath = `polygon(0% 0%, 0% 100%, 100% 100%, 100% 0%, 0% 0%, 0% ${y - 50}px, 100% ${y - 50}px, 100% ${y + 50}px, 0% ${y + 50}px, 0% ${y - 50}px)`;
                        }
                    });
                }
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
