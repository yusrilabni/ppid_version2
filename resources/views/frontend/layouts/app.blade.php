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
        
        /* Accessibility Widget Styles */
        .acc-widget-container { font-family: 'Inter', sans-serif !important; }
        .acc-menu-panel { display: flex; flex-direction: column; }
        .acc-grid-btn { background: white !important; color: #374151 !important; border: 1px solid #E5E7EB !important; border-radius: 16px !important; padding: 16px 10px !important; cursor: pointer !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: flex-start !important; text-align: center !important; min-height: 145px !important; width: 100% !important; position: relative !important; transition: all 0.2s !important; }
        .acc-grid-btn:hover { background: #F3F4F6 !important; }
        .acc-grid-btn.active { border: 2px solid #0052FF !important; }
        .acc-check-icon { position: absolute !important; top: 10px !important; right: 10px !important; color: #0052FF !important; font-size: 14px !important; }
        .acc-icon-wrapper { height: 50px !important; display: flex !important; align-items: center !important; justify-content: center !important; margin-bottom: 12px !important; width: 100% !important; }
        .acc-text-wrapper span { font-size: 13px !important; font-weight: 700 !important; line-height: 1.2 !important; color: #374151 !important; }
        .acc-dot-container { display: flex !important; gap: 4px !important; height: 4px !important; justify-content: center !important; margin-top: 10px !important; }
        .acc-dot { height: 4px !important; border-radius: 2px !important; }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'blue': { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a' },
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
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
        });
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" data-turbo-track="reload">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" data-turbo-track="reload" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" data-turbo-track="reload">
    <style>
        .news-carousel, .info-carousel { width: 100%; overflow: hidden; }
        .info-carousel .swiper-slide { height: auto; }
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
    <div x-data="accessibilityWidget()" class="fixed z-[99999] acc-widget-container flex flex-col items-center" style="bottom: 24px; left: 24px;">
        
        <!-- Tombol Mute/Unmute Suara -->
        <button @click.stop="toggleMasterSound()" 
                class="flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-lg text-white mb-2" 
                :class="isSoundEnabled ? 'bg-green-500' : 'bg-red-500'"
                style="width: 32px; height: 32px; border-radius: 50%; border: none; cursor: pointer;">
            <i x-show="isSoundEnabled" class="fas fa-volume-up" style="font-size: 14px;"></i>
            <i x-show="!isSoundEnabled" class="fas fa-volume-mute" style="font-size: 14px;"></i>
        </button>

        <button @click="$store.accConfig.toggleMenu()" class="bg-[#0052FF] hover:bg-[#0041CC] text-white flex items-center justify-center transition-all duration-300 hover:scale-105 shadow-lg" style="width: 64px; height: 64px; border-radius: 50%; border: none; cursor: pointer;">
            <i class="fas fa-universal-access" style="font-size: 30px;" x-show="!$store.accConfig.isOpen"></i>
            <i class="fas fa-times" style="font-size: 28px;" x-show="$store.accConfig.isOpen"></i>
        </button>

        <!-- Menu Panel -->
        <div x-show="$store.accConfig.isOpen" 
             @click.away="$store.accConfig.isOpen = false"
             x-transition
             class="absolute bg-white overflow-hidden acc-menu-panel" 
             style="bottom: 110px; left: 0; width: 320px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); border: 1px solid #E5E7EB;">
            <div class="bg-[#0052FF] text-white p-6">
                <h3 class="font-bold text-lg">Menu Aksesibilitas</h3>
                <p class="text-xs opacity-90">Optimalkan tampilan sesuai kebutuhan Anda</p>
            </div>
            <div class="p-4 overflow-y-auto" style="max-height: 400px; background: #F9FAFB;">
                <div class="grid grid-cols-2 gap-3">
                    <!-- Contoh 1: Kontras -->
                    <button @click="$store.accConfig.cycleContrast()" class="acc-grid-btn" :class="{'active': $store.accConfig.contrast !== 'default'}">
                        <div class="acc-icon-wrapper"><i class="fas fa-adjust"></i></div>
                        <div class="acc-text-wrapper"><span>Kontras</span></div>
                    </button>
                    <!-- Contoh 2: Ukuran Teks -->
                    <button @click="cycleFont()" class="acc-grid-btn" :class="{'active': $store.accConfig.fontLevel !== 'normal'}">
                        <div class="acc-icon-wrapper"><i class="fas fa-font"></i></div>
                        <div class="acc-text-wrapper"><span>Ukuran Teks</span></div>
                    </button>
                </div>
                <div class="mt-4 text-center border-t pt-4">
                    <button @click="localStorage.clear(); location.reload();" class="text-xs text-gray-500 font-bold uppercase tracking-wider">Reset Semua</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script>
        function accessibilityWidget() {
            return {
                isSoundEnabled: true,
                init() {
                    const savedSound = localStorage.getItem('acc_sound_enabled');
                    if (savedSound !== null) this.isSoundEnabled = (savedSound === 'true');
                    
                    document.addEventListener('mousemove', (e) => {
                        const mask = document.getElementById('reading-mask');
                        if (mask && Alpine.store('accConfig').focus === 'mask') {
                            const y = e.clientY;
                            mask.style.clipPath = `polygon(0% 0%, 0% 100%, 100% 100%, 100% 0%, 0% 0%, 0% ${y - 50}px, 100% ${y - 50}px, 100% ${y + 50}px, 0% ${y + 50}px, 0% ${y - 50}px)`;
                        }
                    });
                },
                toggleMasterSound() {
                    this.isSoundEnabled = !this.isSoundEnabled;
                    localStorage.setItem('acc_sound_enabled', this.isSoundEnabled);
                    if (!this.isSoundEnabled) window.speechSynthesis.cancel();
                },
                cycleFont() { 
                    const levels = ['kecil', 'normal', 'sedang', 'besar'];
                    const current = Alpine.store('accConfig').fontLevel;
                    const next = levels[(levels.indexOf(current) + 1) % 4];
                    Alpine.store('accConfig').setFontLevel(next);
                }
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
