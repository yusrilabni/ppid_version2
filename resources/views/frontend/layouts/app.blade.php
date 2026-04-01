<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
    x-data
    :style="{ fontSize: $store.accConfig ? $store.accConfig.getFontSize() + 'px' : '16px' }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PPID @hasSection('title')
            - @yield('title')
        @endif
    </title>
    <meta name="description" content="Pejabat Pengelola Informasi dan Dokumentasi">

    <!-- Anti-Flicker & Critical Layout -->
    <style>
        [x-cloak] { display: none !important; }
        #main-navbar-container {
            position: sticky !important;
            top: 0 !important;
            z-index: 100 !important;
            background: #ffffff !important;
            height: 64px !important;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        /* Lock menu items to prevent Alpine flicker */
        .flex.opacity-100 { opacity: 1 !important; transform: none !important; }
        /* Disable initial animations */
        * { transition: none !important; animation: none !important; }
    </style>

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('storage/logo/favicon_io/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" type="image/webp" href="{{ asset('storage/logo/favicon_io/ppid.webp') }}">

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('pedomanModal', {
                open: false, allowClose: false,
                init() { },
                show() { this.open = true; this.allowClose = false; },
                close() { this.open = false; },
                enableClose() { this.allowClose = true; }
            });

            Alpine.store('aiAnalisModal', {
                open: false,
                show() { this.open = true; },
                close() { this.open = false; }
            });

            Alpine.store('surveyModal', {
                open: false,
                init() {
                    const isHome = window.location.pathname === '/' || window.location.pathname === '/home';
                    if (!isHome) return;
                    const authStatus = @json(auth()->check());
                    const userRole = @json(auth()->user()?->role ?? 'guest');
                    const userId = @json(auth()->id() ?? 'guest');
                    
                    let shouldShow = false;
                    if (!authStatus) {
                        shouldShow = true;
                    } else if (userRole === 'user' || userRole === 'admin') {
                        if (!sessionStorage.getItem('survey_seen_' + userId)) {
                            shouldShow = true;
                        }
                    }

                    if (shouldShow) {
                        this.open = true;
                        // Auto close after 5 seconds if not manually closed
                        setTimeout(() => {
                            if (this.open) {
                                this.close();
                            }
                        }, 5000);
                    }
                },
                close() {
                    const userId = @json(auth()->id() ?? 'guest');
                    this.open = false;
                    sessionStorage.setItem('survey_seen_' + userId, 'true');
                    window.dispatchEvent(new CustomEvent('trigger-greeting'));
                }
            });

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
                getFontSize() { return this.fontMap[this.fontLevel] || 16; },
                setFontLevel(level) {
                    this.fontLevel = level;
                    localStorage.setItem('acc_font_level', level);
                    document.documentElement.style.fontSize = this.getFontSize() + 'px';
                },
                update(key, val) { this[key] = val; localStorage.setItem('acc_' + key, val); },
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
        })
    </script>

    <!-- Fonts & Icons: Load CSS version for Zero Flicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.cdnfonts.com/css/open-dyslexic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        [x-cloak] { display: none !important; }
        html { transition: font-size 0.2s ease; font-size: 16px; scroll-behavior: smooth; }
        body { font-size: 1rem; min-height: 100vh; display: flex; flex-direction: column; }
        
        /* Layout Locking: Prevent Footer Jumps */
        #acc-main-wrapper { 
            display: flex; 
            flex-direction: column; 
            min-height: 100vh; 
            background-color: #f3f4f6; 
        }
        main { flex: 1 0 auto; min-height: 80vh; }
        header { flex-shrink: 0; }
        footer { flex-shrink: 0; }

        /* Accessibility Styles */
        #acc-main-wrapper.acc-contrast-light { background-color: #fff !important; color: #000 !important; filter: contrast(1.5) !important; }
        #acc-main-wrapper.acc-contrast-invert { filter: invert(1) hue-rotate(180deg) !important; background-color: #000 !important; }
        #acc-main-wrapper.acc-contrast-invert img { filter: invert(1) hue-rotate(180deg) !important; }
        #acc-main-wrapper.acc-contrast-dark { background-color: #000 !important; color: #fff !important; }
        #acc-main-wrapper.acc-contrast-dark *:not(.acc-ignore):not(.acc-ignore *) { background-color: #000 !important; color: #ffff00 !important; border-color: #fff !important; }
        #acc-main-wrapper.acc-sat-low { filter: saturate(0.5) !important; }
        #acc-main-wrapper.acc-sat-high { filter: saturate(2) !important; }
        #acc-main-wrapper.acc-sat-mono { filter: grayscale(1) !important; }
        #acc-main-wrapper.acc-highlight-links a:not(.acc-ignore), 
        #acc-main-wrapper.acc-highlight-links button:not(.acc-ignore) { outline: 4px solid #ff00ff !important; outline-offset: 2px !important; background-color: #ffff00 !important; color: #000 !important; font-weight: bold !important; }
        
        #acc-main-wrapper.acc-highlight-headings h1, #acc-main-wrapper.acc-highlight-headings h2, #acc-main-wrapper.acc-highlight-headings h3 { background-color: #0000ff !important; color: #fff !important; padding: 8px !important; border-left: 12px solid #ffff00 !important; display: block !important; }

        /* High Contrast Overrides for Sections */
        #acc-main-wrapper.acc-contrast-dark section,
        #acc-main-wrapper.acc-contrast-dark div[class*="bg-"],
        #acc-main-wrapper.acc-contrast-dark .bg-white,
        #acc-main-wrapper.acc-contrast-dark .bg-gray-50 { background-color: #000 !important; color: #ffff00 !important; }
        
        #acc-main-wrapper.acc-contrast-light section,
        #acc-main-wrapper.acc-contrast-light div[class*="bg-"] { background-color: #fff !important; color: #000 !important; }
        #acc-main-wrapper.acc-text-spacing *:not(.acc-ignore) { letter-spacing: 2px !important; }
        #acc-main-wrapper.acc-hide-images img { visibility: hidden !important; opacity: 0 !important; }
        #acc-main-wrapper.acc-dyslexic-open *:not(.acc-ignore) { font-family: 'Open-Dyslexic', sans-serif !important; }
        #acc-main-wrapper.acc-dyslexic-lexend *:not(.acc-ignore) { font-family: 'Lexend', sans-serif !important; }
        #acc-main-wrapper.acc-line-height *:not(.acc-ignore) { line-height: 2 !important; }
        #acc-main-wrapper.acc-align-left *:not(.acc-ignore) { text-align: left !important; }
        #acc-main-wrapper.acc-align-center *:not(.acc-ignore) { text-align: center !important; }
        #acc-main-wrapper.acc-align-right *:not(.acc-ignore) { text-align: right !important; }

        /* Widget UI Styles */
        .acc-widget-container { font-family: 'Inter', sans-serif !important; font-size: 16px !important; box-sizing: border-box !important; }
        .acc-menu-panel { display: flex; flex-direction: column; }
        .acc-grid-btn { background: white !important; color: #374151 !important; border: 1px solid #E5E7EB !important; border-radius: 16px !important; padding: 16px 10px !important; cursor: pointer !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: flex-start !important; text-align: center !important; min-height: 145px !important; width: 100% !important; position: relative !important; transition: all 0.2s !important; }
        .acc-grid-btn:hover { background: #F3F4F6 !important; }
        .acc-grid-btn.active { border: 2px solid #0052FF !important; }
        .acc-check-icon { position: absolute !important; top: 10px !important; right: 10px !important; color: #0052FF !important; font-size: 14px !important; margin: 0 !important; }
        .acc-icon-wrapper { height: 50px !important; display: flex !important; align-items: center !important; justify-content: center !important; margin-bottom: 12px !important; width: 100% !important; margin-top: 5px !important; }
        .acc-icon-wrapper i, .acc-icon-wrapper svg { font-size: 32px !important; width: 32px !important; height: 32px !important; line-height: 1 !important; color: #374151 !important; fill: #374151 !important; }
        .acc-text-wrapper { display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; flex-grow: 1 !important; width: 100% !important; }
        .acc-text-wrapper span { font-size: 13px !important; font-weight: 700 !important; line-height: 1.2 !important; color: #374151 !important; margin-bottom: 4px !important; }
        .acc-text-wrapper small { font-size: 11px !important; font-weight: 500 !important; opacity: 0.7 !important; color: #6B7280 !important; margin: 0 !important; line-height: 1.2 !important; }
        .acc-dot-container { display: flex !important; gap: 4px !important; height: 4px !important; justify-content: center !important; align-items: center !important; width: 100% !important; margin-top: 10px !important; }
        .acc-dot { height: 4px !important; border-radius: 2px !important; display: block !important; }

        @media (max-width: 1023px) {
            .acc-menu-panel {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                bottom: 0 !important;
                width: 300px !important;
                max-width: 85vw !important;
                height: 100vh !important;
                border-radius: 0 !important;
                margin: 0 !important;
                box-shadow: 10px 0 25px rgba(0,0,0,0.2) !important;
                z-index: 100002 !important;
            }
            .acc-menu-content {
                max-height: none !important;
                flex: 1 !important;
            }
        }
    </style>
    @stack('styles')
</head>

<body class="antialiased bg-gray-100 text-gray-800" data-turbo="true" x-data="{}"
    :class="{ 'acc-focus-mask': $store.accConfig.focus === 'mask', 'acc-focus-guide': $store.accConfig.focus === 'guide', 'acc-big-cursor': $store.accConfig.focus === 'cursor', 'acc-keyboard-nav': $store.accConfig.keyboard, 'overflow-hidden': $store.accConfig.isOpen && window.innerWidth < 1024 }">

    <div id="acc-main-wrapper" 
        :class="$store.accConfig ? { 'acc-contrast-light': $store.accConfig.contrast === 'light', 'acc-contrast-invert': $store.accConfig.contrast === 'invert', 'acc-contrast-dark': $store.accConfig.contrast === 'dark', 'acc-sat-low': $store.accConfig.saturation === 'low', 'acc-sat-high': $store.accConfig.saturation === 'high', 'acc-sat-mono': $store.accConfig.saturation === 'mono', 'acc-highlight-links': $store.accConfig.links, 'acc-highlight-headings': $store.accConfig.headings, 'acc-text-spacing': $store.accConfig.textSpacing, 'acc-hide-images': $store.accConfig.hideImages, 'acc-dyslexic-open': $store.accConfig.dyslexic === 'open', 'acc-dyslexic-lexend': $store.accConfig.dyslexic === 'lexend', 'acc-line-height': $store.accConfig.lineHeight, 'acc-align-left': $store.accConfig.alignment === 'left', 'acc-align-center': $store.accConfig.alignment === 'center', 'acc-align-right': $store.accConfig.alignment === 'right' } : {}">
        @include('frontend.layouts.navbar')
        <main>@yield('content')</main>
        @include('frontend.layouts.footer')
    </div>

    <div class="acc-reading-mask" id="reading-mask"></div>
    <div class="acc-reading-guide" id="reading-guide"></div>

    <!-- SURVEY MODAL -->
    <div x-show="$store.surveyModal.open" class="fixed inset-0 z-[10000] flex items-center justify-center p-4 bg-black/70 backdrop-blur-md" x-cloak x-transition>
        <div class="bg-white rounded-[2rem] shadow-2xl max-w-lg w-full overflow-hidden transform transition-all border border-white/20">
            <div class="relative bg-gradient-to-br from-blue-600 to-indigo-800 p-10 text-center text-white">
                <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
                    <svg width="100%" height="100%"><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/></pattern><rect width="100%" height="100%" fill="url(#grid)" /></svg>
                </div>
                <div class="bg-white/20 w-24 h-24 rounded-3xl flex items-center justify-center mx-auto mb-6 backdrop-blur-sm border border-white/30 rotate-12 shadow-xl">
                    <i class="fas fa-poll-h text-5xl"></i>
                </div>
                <h3 class="text-3xl font-extrabold tracking-tight">Survei Kepuasan</h3>
                <p class="text-blue-100 mt-3 text-lg opacity-90">Bantu kami meningkatkan kualitas layanan publik</p>
            </div>
            <div class="p-10 text-center bg-gray-50/50">
                <p class="text-gray-600 mb-10 leading-relaxed text-lg font-medium">Suara Anda sangat berarti bagi kami. Luangkan waktu sejenak untuk mengisi survei singkat pelayanan PPID Kabupaten Sinjai.</p>
                <div class="flex flex-col gap-4">
                    <a href="{{ url('/laporan/survei') }}" @click="$store.surveyModal.close()" class="group bg-blue-600 hover:bg-blue-700 text-white font-bold py-5 px-8 rounded-2xl transition-all shadow-xl shadow-blue-200 flex items-center justify-center gap-3">
                        <i class="fas fa-edit text-xl"></i><span>Isi Survei Sekarang</span>
                    </a>
                    <button @click="$store.surveyModal.close()" class="text-gray-400 hover:text-red-500 font-bold py-2 uppercase text-xs tracking-wider">Nanti Saja</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Accessibility Widget -->
    <div x-data="accessibilityWidget()" class="fixed z-[99999] acc-widget-container flex flex-col items-center" style="bottom: 24px; left: 24px;" x-cloak>
        
        <!-- Mobile Overlay -->
        <div x-show="$store.accConfig.isOpen && window.innerWidth < 1024" 
             @click="$store.accConfig.isOpen = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/50 z-[100001] lg:hidden">
        </div>

        <!-- MASTER SOUND TOGGLE (Bulat, Mungil, Hijau/Merah, Pasti Muncul Ikon) -->
        <button @click.stop="toggleMasterSound()" 
                class="flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-lg text-white pointer-events-auto mb-2" 
                :class="isSoundEnabled ? 'bg-green-500' : 'bg-red-500'"
                style="width: 32px; height: 32px; border-radius: 50%; border: none; cursor: pointer !important; z-index: 100001; position: relative;">
            <i x-show="isSoundEnabled" class="fas fa-volume-up" style="font-size: 14px !important; color: white !important; display: block !important;"></i>
            <i x-show="!isSoundEnabled" class="fas fa-volume-mute" style="font-size: 14px !important; color: white !important; display: block !important;"></i>
        </button>

        <button @click="$store.accConfig.toggleMenu()" class="bg-[#0052FF] hover:bg-[#0041CC] text-white flex items-center justify-center transition-all duration-300 hover:scale-105 shadow-lg pointer-events-auto" style="width: 64px; height: 64px; border-radius: 50%; border: none; cursor: pointer;" :class="{'ring-4 ring-blue-200': $store.accConfig.isOpen}">
            <i class="fas fa-universal-access" style="font-size: 30px !important;" x-show="!$store.accConfig.isOpen"></i>
            <i class="fas fa-times" style="font-size: 28px !important;" x-show="$store.accConfig.isOpen"></i>
        </button>

        <div x-show="$store.accConfig.isOpen" 
             @click.away="if(window.innerWidth >= 1024) $store.accConfig.isOpen = false" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 -translate-x-full"
             class="absolute bg-white overflow-hidden acc-menu-panel" 
             style="bottom: 110px; left: 0; width: 360px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); border: 1px solid #E5E7EB;">
            <div class="bg-[#0052FF] text-white shrink-0 relative" style="padding: 24px 20px;">
                <h3 style="font-size: 18px !important; margin: 0 !important; font-weight: 700 !important; color: white !important;">Menu Aksesibilitas</h3>
                <p style="font-size: 12px !important; margin: 4px 0 0 0 !important; opacity: 0.9 !important; color: white !important;">Optimalkan tampilan sesuai kebutuhan Anda</p>
                
                {{-- Close Button for Sidebar (Mobile only) --}}
                <button @click.stop="$store.accConfig.isOpen = false" 
                        class="lg:hidden absolute top-4 right-4 text-white/80 hover:text-white p-2"
                        style="background: rgba(255,255,255,0.1); border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer;">
                    <i class="fas fa-times" style="font-size: 18px !important;"></i>
                </button>
            </div>

            <div class="overflow-y-auto acc-menu-content" style="padding: 20px; max-height: 540px; background: #F9FAFB;">
                <div style="margin-bottom: 20px; background: #fff; padding: 16px; border-radius: 16px; border: 1px solid #E5E7EB;">
                    <p style="font-size: 12px !important; font-weight: 700 !important; color: #6B7280 !important; margin: 0 0 12px 0 !important; text-transform: uppercase !important;">Kontrol Suara (TTS)</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px;">
                        <button @click="toggleReader()" :class="isReaderActive ? 'border-[#0052FF] border-2' : 'border-[#E5E7EB] border'" class="bg-white text-[#374151] flex items-center justify-center" style="padding: 12px; border-radius: 12px; cursor: pointer; font-size: 12px !important; font-weight: 700; border-style: solid;">
                            <i class="fas fa-volume-up" style="margin-right: 8px !important; font-size: 16px !important;"></i> Klik Baca
                        </button>
                        <button @click="toggleHoverReader()" :class="isHoverActive ? 'border-[#0052FF] border-2' : 'border-[#E5E7EB] border'" class="bg-white text-[#374151] flex items-center justify-center" style="padding: 12px; border-radius: 12px; cursor: pointer; font-size: 12px !important; font-weight: 700; border-style: solid;">
                            <i class="fas fa-mouse-pointer" style="margin-right: 8px !important; font-size: 16px !important;"></i> Sorot Baca
                        </button>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
                    <!-- 1. Contrast -->
                    <button @click="$store.accConfig.cycleContrast()" class="acc-grid-btn acc-ignore" :class="{'active': $store.accConfig.contrast !== 'default'}">
                        <i x-show="$store.accConfig.contrast !== 'default'" class="fas fa-check-circle acc-check-icon"></i>
                        <div class="acc-icon-wrapper"><i :class="{'fas fa-adjust': $store.accConfig.contrast === 'default', 'fas fa-sun': $store.accConfig.contrast === 'light', 'fas fa-eye-slash': $store.accConfig.contrast === 'invert', 'fas fa-moon': $store.accConfig.contrast === 'dark'}"></i></div>
                        <div class="acc-text-wrapper"><span>Kontras Tinggi</span><small x-text="$store.accConfig.contrast" class="capitalize"></small></div>
                        <div class="acc-dot-container"><template x-for="m in ['default', 'light', 'invert', 'dark']"><div :style="{ width: $store.accConfig.contrast === m ? '12px' : '6px', backgroundColor: $store.accConfig.contrast === m ? '#0052FF' : '#D1D5DB' }" class="acc-dot"></div></template></div>
                    </button>
                    <!-- 2. Text Size -->
                    <button @click="cycleFont()" class="acc-grid-btn acc-ignore" :class="{'active': $store.accConfig.fontLevel !== 'normal'}">
                        <i x-show="$store.accConfig.fontLevel !== 'normal'" class="fas fa-check-circle acc-check-icon"></i>
                        <div class="acc-icon-wrapper" style="height: 50px !important;"><div style="display: flex; align-items: baseline; justify-content: center; gap: 4px;"><span :style="'font-size: ' + ($store.accConfig.fontLevel === 'kecil' ? '12' : ($store.accConfig.fontLevel === 'normal' ? '16' : ($store.accConfig.fontLevel === 'sedang' ? '20' : '24'))) + 'px !important'" style="font-weight: bold; color: #374151 !important; line-height: 1 !important; margin: 0 !important;">T</span><span :style="'font-size: ' + ($store.accConfig.fontLevel === 'kecil' ? '24' : ($store.accConfig.fontLevel === 'normal' ? '32' : ($store.accConfig.fontLevel === 'sedang' ? '40' : '48'))) + 'px !important'" style="font-weight: bold; color: #374151 !important; line-height: 1 !important; margin: 0 !important;">T</span></div></div>
                        <div class="acc-text-wrapper"><span>Ukuran Teks</span><small x-text="$store.accConfig.fontLevel" class="capitalize"></small></div>
                        <div class="acc-dot-container"><template x-for="l in ['kecil', 'normal', 'sedang', 'besar']"><div :style="{ width: $store.accConfig.fontLevel === l ? '12px' : '6px', backgroundColor: $store.accConfig.fontLevel === l ? '#0052FF' : '#D1D5DB' }" class="acc-dot"></div></template></div>
                    </button>
                    <!-- 3. Highlight Links -->
                    <button @click="$store.accConfig.update('links', !$store.accConfig.links)" class="acc-grid-btn acc-ignore" :class="{'active': $store.accConfig.links}">
                        <i x-show="$store.accConfig.links" class="fas fa-check-circle acc-check-icon"></i>
                        <div class="acc-icon-wrapper"><i class="fas fa-link"></i></div>
                        <div class="acc-text-wrapper"><span>Sorot Tautan</span><small x-text="$store.accConfig.links ? 'Aktif' : 'Default'"></small></div>
                        <div class="acc-dot-container"><div :style="{ width: $store.accConfig.links ? '24px' : '12px', backgroundColor: $store.accConfig.links ? '#0052FF' : '#D1D5DB' }" class="acc-dot"></div></div>
                    </button>
                    <!-- 4. Text Spacing -->
                    <button @click="$store.accConfig.update('textSpacing', !$store.accConfig.textSpacing)" class="acc-grid-btn acc-ignore" :class="{'active': $store.accConfig.textSpacing}">
                        <i x-show="$store.accConfig.textSpacing" class="fas fa-check-circle acc-check-icon"></i>
                        <div class="acc-icon-wrapper"><i class="fas fa-arrows-alt-h"></i></div>
                        <div class="acc-text-wrapper"><span>Spasi Teks</span><small x-text="$store.accConfig.textSpacing ? 'Aktif' : 'Default'"></small></div>
                        <div class="acc-dot-container"><div :style="{ width: $store.accConfig.textSpacing ? '24px' : '12px', backgroundColor: $store.accConfig.textSpacing ? '#0052FF' : '#D1D5DB' }" class="acc-dot"></div></div>
                    </button>
                    <!-- 5. Hide Images -->
                    <button @click="$store.accConfig.update('hideImages', !$store.accConfig.hideImages)" class="acc-grid-btn acc-ignore" :class="{'active': $store.accConfig.hideImages}">
                        <i x-show="$store.accConfig.hideImages" class="fas fa-check-circle acc-check-icon"></i>
                        <div class="acc-icon-wrapper"><i class="fas fa-image"></i></div>
                        <div class="acc-text-wrapper"><span>Sembunyi Gbr</span><small x-text="$store.accConfig.hideImages ? 'Aktif' : 'Default'"></small></div>
                        <div class="acc-dot-container"><div :style="{ width: $store.accConfig.hideImages ? '24px' : '12px', backgroundColor: $store.accConfig.hideImages ? '#0052FF' : '#D1D5DB' }" class="acc-dot"></div></div>
                    </button>
                    <!-- 6. Dyslexia -->
                    <button @click="$store.accConfig.cycleDyslexic()" class="acc-grid-btn acc-ignore" :class="{'active': $store.accConfig.dyslexic !== 'default'}">
                        <i x-show="$store.accConfig.dyslexic !== 'default'" class="fas fa-check-circle acc-check-icon"></i>
                        <div class="acc-icon-wrapper"><i :class="{'fas fa-font': $store.accConfig.dyslexic === 'default', 'fas fa-universal-access': $store.accConfig.dyslexic === 'open', 'fas fa-spell-check': $store.accConfig.dyslexic === 'lexend'}"></i></div>
                        <div class="acc-text-wrapper"><span>Ramah Disleksia</span><small x-text="$store.accConfig.dyslexic" class="capitalize"></small></div>
                        <div class="acc-dot-container"><template x-for="m in ['default', 'open', 'lexend']"><div :style="{ width: $store.accConfig.dyslexic === m ? '12px' : '6px', backgroundColor: $store.accConfig.dyslexic === m ? '#0052FF' : '#D1D5DB' }" class="acc-dot"></div></template></div>
                    </button>
                    <!-- 7. Focus -->
                    <button @click="$store.accConfig.cycleFocus()" class="acc-grid-btn acc-ignore" :class="{'active': $store.accConfig.focus !== 'default'}">
                        <i x-show="$store.accConfig.focus !== 'default'" class="fas fa-check-circle acc-check-icon"></i>
                        <div class="acc-icon-wrapper"><i :class="{'fas fa-eye': $store.accConfig.focus === 'default', 'fas fa-mouse-pointer': $store.accConfig.focus === 'cursor', 'fas fa-low-vision': $store.accConfig.focus === 'mask', 'fas fa-grip-lines-vertical': $store.accConfig.focus === 'guide'}"></i></div>
                        <div class="acc-text-wrapper"><span>Fokus Membaca</span><small x-text="$store.accConfig.focus" class="capitalize"></small></div>
                        <div class="acc-dot-container"><template x-for="m in ['default', 'cursor', 'mask', 'guide']"><div :style="{ width: $store.accConfig.focus === m ? '12px' : '6px', backgroundColor: $store.accConfig.focus === m ? '#0052FF' : '#D1D5DB' }" class="acc-dot"></div></template></div>
                    </button>
                    <!-- 8. Keyboard Nav -->
                    <button @click="$store.accConfig.update('keyboard', !$store.accConfig.keyboard)" class="acc-grid-btn acc-ignore" :class="{'active': $store.accConfig.keyboard}">
                        <i x-show="$store.accConfig.keyboard" class="fas fa-check-circle acc-check-icon"></i>
                        <div class="acc-icon-wrapper"><i class="fas fa-keyboard"></i></div>
                        <div class="acc-text-wrapper"><span>Navigasi Key</span><small x-text="$store.accConfig.keyboard ? 'Aktif' : 'Default'"></small></div>
                        <div class="acc-dot-container"><div :style="{ width: $store.accConfig.keyboard ? '24px' : '12px', backgroundColor: $store.accConfig.keyboard ? '#0052FF' : '#D1D5DB' }" class="acc-dot"></div></div>
                    </button>
                    <!-- 9. Alignment -->
                    <button @click="$store.accConfig.cycleAlignment()" class="acc-grid-btn acc-ignore" :class="{'active': $store.accConfig.alignment !== 'default'}">
                        <i x-show="$store.accConfig.alignment !== 'default'" class="fas fa-check-circle acc-check-icon"></i>
                        <div class="acc-icon-wrapper"><i :class="{'fas fa-bars': $store.accConfig.alignment === 'default', 'fas fa-align-left': $store.accConfig.alignment === 'left', 'fas fa-align-center': $store.accConfig.alignment === 'center', 'fas fa-align-right': $store.accConfig.alignment === 'right'}"></i></div>
                        <div class="acc-text-wrapper"><span>Perataan</span><small x-text="$store.accConfig.alignment" class="capitalize"></small></div>
                        <div class="acc-dot-container"><template x-for="m in ['default', 'left', 'center', 'right']"><div :style="{ width: $store.accConfig.alignment === m ? '12px' : '6px', backgroundColor: $store.accConfig.alignment === m ? '#0052FF' : '#D1D5DB' }" class="acc-dot"></div></template></div>
                    </button>
                    <!-- 10. Saturation -->
                    <button @click="$store.accConfig.cycleSaturation()" class="acc-grid-btn acc-ignore" :class="{'active': $store.accConfig.saturation !== 'default'}">
                        <i x-show="$store.accConfig.saturation !== 'default'" class="fas fa-check-circle acc-check-icon"></i>
                        <div class="acc-icon-wrapper"><i :class="{'fas fa-palette': $store.accConfig.saturation === 'default', 'fas fa-brush': $store.accConfig.saturation === 'low', 'fas fa-fill-drip': $store.accConfig.saturation === 'high', 'fas fa-tint-slash': $store.accConfig.saturation === 'mono'}"></i></div>
                        <div class="acc-text-wrapper"><span>Warna</span><small x-text="$store.accConfig.saturation" class="capitalize"></small></div>
                        <div class="acc-dot-container"><template x-for="s in ['default', 'low', 'high', 'mono']"><div :style="{ width: $store.accConfig.saturation === s ? '12px' : '6px', backgroundColor: $store.accConfig.saturation === s ? '#0052FF' : '#D1D5DB' }" class="acc-dot"></div></template></div>
                    </button>
                    <!-- 11. Headings -->
                    <button @click="$store.accConfig.update('headings', !$store.accConfig.headings)" class="acc-grid-btn acc-ignore" :class="{'active': $store.accConfig.headings}">
                        <i x-show="$store.accConfig.headings" class="fas fa-check-circle acc-check-icon"></i>
                        <div class="acc-icon-wrapper"><i class="fas fa-heading"></i></div>
                        <div class="acc-text-wrapper"><span>Sorot Judul</span><small x-text="$store.accConfig.headings ? 'Aktif' : 'Default'"></small></div>
                        <div class="acc-dot-container"><div :style="{ width: $store.accConfig.headings ? '24px' : '12px', backgroundColor: $store.accConfig.headings ? '#0052FF' : '#D1D5DB' }" class="acc-dot"></div></div>
                    </button>
                    <!-- 12. Line Height -->
                    <button @click="$store.accConfig.update('lineHeight', !$store.accConfig.lineHeight)" class="acc-grid-btn acc-ignore" :class="{'active': $store.accConfig.lineHeight}">
                        <i x-show="$store.accConfig.lineHeight" class="fas fa-check-circle acc-check-icon"></i>
                        <div class="acc-icon-wrapper"><i class="fas fa-arrows-alt-v"></i></div>
                        <div class="acc-text-wrapper"><span>Tinggi Baris</span><small x-text="$store.accConfig.lineHeight ? 'Aktif' : 'Default'"></small></div>
                        <div class="acc-dot-container"><div :style="{ width: $store.accConfig.lineHeight ? '24px' : '12px', backgroundColor: $store.accConfig.lineHeight ? '#0052FF' : '#D1D5DB' }" class="acc-dot"></div></div>
                    </button>
                </div>

                <div style="margin-top: 24px; text-align: center; border-top: 1px solid #E5E7EB; padding-top: 20px;">
                    <button @click="resetAcc()" class="bg-gray-800 text-white hover:bg-black w-full flex items-center justify-center acc-ignore" style="padding: 14px; border-radius: 12px; border: none; cursor: pointer; font-size: 13px !important; font-weight: 700; margin-bottom: 12px;"><i class="fas fa-undo" style="margin-right: 8px !important; font-size: 14px !important;"></i> Reset Semua</button>
                    <p style="font-size: 11px !important; color: #9CA3AF !important; margin: 0 !important; font-weight: 600 !important;">&copy; 2026 PPID KABUPATEN SINJAI</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script>
        // Re-enable transitions after load to prevent initial ghosting
        window.addEventListener('load', () => { document.body.classList.add('loaded'); });
        
        lucide.createIcons();
        function accessibilityWidget() {
            return {
                isSoundEnabled: true,
                isReaderActive: false,
                isHoverActive: false,
                isCurrentlySpeaking: false,
                hoverTimeout: null,
                init() {
                    const userRole = @json(auth()->user()?->role ?? 'guest');

                    // CEK MEMORI BROWSER (Persistensi Mute)
                    const savedSoundState = localStorage.getItem('acc_sound_enabled');
                    if (savedSoundState !== null) {
                        this.isSoundEnabled = (savedSoundState === 'true');
                    } else {
                        this.isSoundEnabled = (userRole !== 'superadmin');
                    }

                    window.addEventListener('trigger-greeting', () => {
                        if (!this.isSoundEnabled) { 
                            this.activateDefaultTTS(userRole); 
                            return; 
                        }
                        const authStatus = @json(auth()->check());
                        const userId = @json(auth()->id() ?? 'guest');
                        const userName = @json(auth()->user()?->name ?? '');
                        const isHome = window.location.pathname === '/' || window.location.pathname === '/home';
                        if (!isHome) { this.activateDefaultTTS(userRole); return; }
                        window.speechSynthesis.cancel();
                        let text = "Selamat Datang di P P I D Kabupaten Sinjai";
                        let fullText = authStatus ? ("Halo " + userName + ", " + text) : text;
                        const utterance = new SpeechSynthesisUtterance(fullText);
                        utterance.lang = 'id-ID';
                        utterance.onend = () => { if (this.isSoundEnabled) this.activateDefaultTTS(userRole); };
                        window.speechSynthesis.speak(utterance);
                    });
                    setInterval(() => { this.isCurrentlySpeaking = window.speechSynthesis.speaking; }, 200);
                    document.addEventListener('click', (e) => {
                        if (!this.isSoundEnabled || !this.isReaderActive || e.target.closest('.acc-widget-container')) return;
                        this.handleElementSource(e.target);
                    });
                    document.addEventListener('mouseover', (e) => {
                        if (!this.isSoundEnabled || !this.isHoverActive || e.target.closest('.acc-widget-container')) return;
                        clearTimeout(this.hoverTimeout);
                        this.hoverTimeout = setTimeout(() => { this.handleElementSource(e.target, true); }, 600);
                    });
                },
                toggleMasterSound() {
                    this.isSoundEnabled = !this.isSoundEnabled;
                    localStorage.setItem('acc_sound_enabled', this.isSoundEnabled); // SIMPAN KE MEMORI
                    if (!this.isSoundEnabled) {
                        window.speechSynthesis.cancel();
                        this.isReaderActive = false;
                        this.isHoverActive = false;
                    } else {
                        const userRole = @json(auth()->user()?->role ?? 'guest');
                        this.activateDefaultTTS(userRole);
                    }
                },
                activateDefaultTTS(role) {
                    this.isHoverActive = (role === 'guest' || role === 'user');
                    this.isReaderActive = (role === 'admin');
                },
                handleElementSource(target, isHover = false) {
                    let text = '';
                    const el = target.closest('a, button, h1, h2, h3, h4, h5, h6, p, li, span, img, td, th, label, input');
                    if (!el) return;
                    if (el.tagName.toLowerCase() === 'img') text = el.getAttribute('alt') || 'Gambar';
                    else if (el.tagName.toLowerCase() === 'input') text = el.getAttribute('placeholder') || 'Kotak isian';
                    else {
                        text = el.innerText || el.getAttribute('aria-label') || '';
                        if (el.tagName.toLowerCase() === 'a' && el.href && el.href.toLowerCase().endsWith('.pdf')) text = "Dokumen P D F, " + text;
                    }
                    text = text.trim();
                    if (text && text.length > 1) { this.speak(text); }
                },
                toggleReader() { if (!this.isSoundEnabled) this.isSoundEnabled = true; this.isReaderActive = !this.isReaderActive; this.isHoverActive = false; },
                toggleHoverReader() { if (!this.isSoundEnabled) this.isSoundEnabled = true; this.isHoverActive = !this.isHoverActive; this.isReaderActive = false; },
                cycleFont() { Alpine.store('accConfig').setFontLevel(['kecil', 'normal', 'sedang', 'besar'][(['kecil', 'normal', 'sedang', 'besar'].indexOf(Alpine.store('accConfig').fontLevel) + 1) % 4]); },
                resetAcc() { localStorage.clear(); sessionStorage.clear(); location.reload(); },
                speak(text) { if (!this.isSoundEnabled) return; window.speechSynthesis.cancel(); const utterance = new SpeechSynthesisUtterance(text); utterance.lang = 'id-ID'; window.speechSynthesis.speak(utterance); }
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
