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
            min-height: 64px !important;
        }
        /* Lock menu states during load */
        .opacity-100 { opacity: 1 !important; }
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
                        setTimeout(() => { if (this.open) { this.close(); } }, 5000);
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.cdnfonts.com/css/open-dyslexic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .news-carousel, .info-carousel { width: 100%; overflow: hidden; }
        .info-carousel .swiper-slide { height: auto; }
        html { transition: font-size 0.2s ease; font-size: 16px; scroll-behavior: smooth; }
        body { font-size: 1rem; min-height: 100vh; display: flex; flex-direction: column; }
        #acc-main-wrapper { flex: 1 0 auto; display: flex; flex-direction: column; width: 100%; }
        main { flex: 1 0 auto; }

        /* Accessibility Styles */
        #acc-main-wrapper.acc-contrast-light { background-color: #fff !important; color: #000 !important; filter: contrast(1.2) !important; }
        #acc-main-wrapper.acc-contrast-invert { filter: invert(1) hue-rotate(180deg) !important; background-color: #000 !important; }
        #acc-main-wrapper.acc-contrast-dark { background-color: #000 !important; color: #fff !important; }
        #acc-main-wrapper.acc-contrast-dark *:not(.acc-ignore):not(.acc-ignore *) { background-color: #000 !important; color: #ffff00 !important; border-color: #fff !important; }
        
        #acc-main-wrapper.acc-highlight-links a:not(.acc-ignore), 
        #acc-main-wrapper.acc-highlight-links button:not(.acc-ignore) { outline: 4px solid #ff00ff !important; outline-offset: 2px !important; background-color: #ffff00 !important; color: #000 !important; font-weight: bold !important; }
        
        /* Widget Styles */
        .acc-widget-container { font-family: 'Inter', sans-serif !important; }
        .acc-grid-btn { background: white !important; color: #374151 !important; border: 1px solid #E5E7EB !important; border-radius: 16px !important; padding: 16px 10px !important; cursor: pointer !important; display: flex !important; flex-direction: column !important; align-items: center !important; text-align: center !important; min-height: 140px !important; width: 100% !important; position: relative !important; transition: all 0.2s !important; }
        .acc-grid-btn:hover { background: #F3F4F6 !important; }
        .acc-grid-btn.active { border: 2px solid #0052FF !important; }
        .acc-icon-wrapper { height: 50px !important; display: flex !important; align-items: center !important; justify-content: center !important; margin-bottom: 12px !important; width: 100% !important; }
        .acc-icon-wrapper i { font-size: 32px !important; color: #374151 !important; }
        .acc-text-wrapper span { font-size: 13px !important; font-weight: 700 !important; color: #374151 !important; }

        @media (max-width: 1023px) {
            .acc-menu-panel { position: fixed !important; top: 0 !important; left: 0 !important; bottom: 0 !important; width: 300px !important; max-width: 85vw !important; height: 100vh !important; border-radius: 0 !important; box-shadow: 10px 0 25px rgba(0,0,0,0.2) !important; z-index: 100002 !important; }
        }
        .acc-reading-mask { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 999998; background: rgba(0,0,0,0.85); display: none; }
        body.acc-focus-mask .acc-reading-mask { display: block !important; }
    </style>
    @stack('styles')
</head>

<body class="antialiased bg-gray-100 text-gray-800"
    :class="{ 'acc-focus-mask': $store.accConfig.focus === 'mask', 'overflow-hidden': $store.accConfig.isOpen && window.innerWidth < 1024 }">

    <div id="acc-main-wrapper" 
        :class="$store.accConfig ? { 'acc-contrast-light': $store.accConfig.contrast === 'light', 'acc-contrast-invert': $store.accConfig.contrast === 'invert', 'acc-contrast-dark': $store.accConfig.contrast === 'dark', 'acc-sat-low': $store.accConfig.saturation === 'low', 'acc-sat-high': $store.accConfig.saturation === 'high', 'acc-sat-mono': $store.accConfig.saturation === 'mono', 'acc-highlight-links': $store.accConfig.links, 'acc-highlight-headings': $store.accConfig.headings, 'acc-text-spacing': $store.accConfig.textSpacing, 'acc-hide-images': $store.accConfig.hideImages, 'acc-dyslexic-open': $store.accConfig.dyslexic === 'open', 'acc-dyslexic-lexend': $store.accConfig.dyslexic === 'lexend', 'acc-line-height': $store.accConfig.lineHeight, 'acc-align-left': $store.accConfig.alignment === 'left', 'acc-align-center': $store.accConfig.alignment === 'center', 'acc-align-right': $store.accConfig.alignment === 'right' } : {}">
        
        <header id="main-navbar-container">
            @include('frontend.layouts.navbar')
        </header>

        <main id="main-content">@yield('content')</main>
        @include('frontend.layouts.footer')
    </div>

    <div class="acc-reading-mask" id="reading-mask"></div>

    <!-- Accessibility Widget -->
    <div x-data="accessibilityWidget()" class="fixed z-[99999] acc-widget-container flex flex-col items-center" style="bottom: 24px; left: 24px;">
        
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

        <div x-show="$store.accConfig.isOpen" @click.away="$store.accConfig.isOpen = false" x-transition x-cloak
             class="absolute bg-white overflow-hidden acc-menu-panel" style="display: none; bottom: 110px; left: 0; width: 340px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); border: 1px solid #E5E7EB;">
            <div class="bg-[#0052FF] text-white p-6">
                <h3 class="font-bold text-lg">Menu Aksesibilitas</h3>
                <p class="text-xs opacity-90">Optimalkan tampilan sesuai kebutuhan Anda</p>
            </div>
            <div class="p-4 overflow-y-auto" style="max-height: 450px; background: #F9FAFB;">
                <div style="margin-bottom: 15px; background: #fff; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                    <p style="font-size: 11px; font-weight: 700; color: #6B7280; margin-bottom: 8px; text-transform: uppercase;">Kontrol Suara (TTS)</p>
                    <div class="grid grid-cols-2 gap-2">
                        <button @click="toggleReader()" :class="isReaderActive ? 'border-[#0052FF] border-2' : 'border-[#E5E7EB] border'" class="bg-white p-2 rounded-lg text-xs font-bold">Klik Baca</button>
                        <button @click="toggleHoverReader()" :class="isHoverActive ? 'border-[#0052FF] border-2' : 'border-[#E5E7EB] border'" class="bg-white p-2 rounded-lg text-xs font-bold">Sorot Baca</button>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <button @click="$store.accConfig.cycleContrast()" class="acc-grid-btn" :class="{'active': $store.accConfig.contrast !== 'default'}"><div class="acc-icon-wrapper"><i class="fas fa-adjust"></i></div><div class="acc-text-wrapper"><span>Kontras</span></div></button>
                    <button @click="cycleFont()" class="acc-grid-btn" :class="{'active': $store.accConfig.fontLevel !== 'normal'}"><div class="acc-icon-wrapper"><i class="fas fa-font"></i></div><div class="acc-text-wrapper"><span>Ukuran Teks</span></div></button>
                    <button @click="$store.accConfig.update('links', !$store.accConfig.links)" class="acc-grid-btn" :class="{'active': $store.accConfig.links}"><div class="acc-icon-wrapper"><i class="fas fa-link"></i></div><div class="acc-text-wrapper"><span>Sorot Tautan</span></div></button>
                    <button @click="$store.accConfig.update('textSpacing', !$store.accConfig.textSpacing)" class="acc-grid-btn" :class="{'active': $store.accConfig.textSpacing}"><div class="acc-icon-wrapper"><i class="fas fa-arrows-alt-h"></i></div><div class="acc-text-wrapper"><span>Spasi Teks</span></div></button>
                    <button @click="$store.accConfig.update('hideImages', !$store.accConfig.hideImages)" class="acc-grid-btn" :class="{'active': $store.accConfig.hideImages}"><div class="acc-icon-wrapper"><i class="fas fa-image"></i></div><div class="acc-text-wrapper"><span>Sembunyi Gbr</span></div></button>
                    <button @click="$store.accConfig.cycleDyslexic()" class="acc-grid-btn" :class="{'active': $store.accConfig.dyslexic !== 'default'}"><div class="acc-icon-wrapper"><i class="fas fa-spell-check"></i></div><div class="acc-text-wrapper"><span>Ramah Disleksia</span></div></button>
                    <button @click="$store.accConfig.cycleFocus()" class="acc-grid-btn" :class="{'active': $store.accConfig.focus !== 'default'}"><div class="acc-icon-wrapper"><i class="fas fa-low-vision"></i></div><div class="acc-text-wrapper"><span>Fokus Baca</span></div></button>
                    <button @click="$store.accConfig.update('keyboard', !$store.accConfig.keyboard)" class="acc-grid-btn" :class="{'active': $store.accConfig.keyboard}"><div class="acc-icon-wrapper"><i class="fas fa-keyboard"></i></div><div class="acc-text-wrapper"><span>Navigasi Key</span></div></button>
                    <button @click="$store.accConfig.cycleAlignment()" class="acc-grid-btn" :class="{'active': $store.accConfig.alignment !== 'default'}"><div class="acc-icon-wrapper"><i class="fas fa-align-left"></i></div><div class="acc-text-wrapper"><span>Perataan</span></div></button>
                    <button @click="$store.accConfig.cycleSaturation()" class="acc-grid-btn" :class="{'active': $store.accConfig.saturation !== 'default'}"><div class="acc-icon-wrapper"><i class="fas fa-palette"></i></div><div class="acc-text-wrapper"><span>Warna</span></div></button>
                    <button @click="$store.accConfig.update('headings', !$store.accConfig.headings)" class="acc-grid-btn" :class="{'active': $store.accConfig.headings}"><div class="acc-icon-wrapper"><i class="fas fa-heading"></i></div><div class="acc-text-wrapper"><span>Sorot Judul</span></div></button>
                    <button @click="$store.accConfig.update('lineHeight', !$store.accConfig.lineHeight)" class="acc-grid-btn" :class="{'active': $store.accConfig.lineHeight}"><div class="acc-icon-wrapper"><i class="fas fa-arrows-alt-v"></i></div><div class="acc-text-wrapper"><span>Tinggi Baris</span></div></button>
                </div>
                <div class="mt-4 text-center border-t pt-4">
                    <button @click="resetAcc()" class="text-xs text-gray-500 font-bold uppercase tracking-wider">Reset Semua</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script>
        lucide.createIcons();
        function accessibilityWidget() {
            return {
                isSoundEnabled: true, isReaderActive: false, isHoverActive: false,
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
                    document.addEventListener('click', (e) => { if (this.isSoundEnabled && this.isReaderActive && !e.target.closest('.acc-widget-container')) this.speak(e.target.innerText || ''); });
                },
                toggleMasterSound() { this.isSoundEnabled = !this.isSoundEnabled; localStorage.setItem('acc_sound_enabled', this.isSoundEnabled); if (!this.isSoundEnabled) window.speechSynthesis.cancel(); },
                toggleReader() { if (!this.isSoundEnabled) this.toggleMasterSound(); this.isReaderActive = !this.isReaderActive; this.isHoverActive = false; },
                toggleHoverReader() { if (!this.isSoundEnabled) this.toggleMasterSound(); this.isHoverActive = !this.isHoverActive; this.isReaderActive = false; },
                cycleFont() { const levels = ['kecil', 'normal', 'sedang', 'besar']; Alpine.store('accConfig').setFontLevel(levels[(levels.indexOf(Alpine.store('accConfig').fontLevel) + 1) % 4]); },
                resetAcc() { localStorage.clear(); location.reload(); },
                formatTextForTTS(text) {
                    if (!text) return '';
                    const abbreviations = ['SOP', 'DIP', 'PPID', 'IPM', 'TPAK', 'RKPD', 'RPJMD', 'LKPJ', 'SPBU', 'ASN', 'OPD', 'TTS'];
                    let processedText = text;
                    abbreviations.forEach(abbr => { const regex = new RegExp('\\b' + abbr + '\\b', 'gi'); processedText = processedText.replace(regex, abbr.split('').join(' ')); });
                    processedText = processedText.replace(/\bNo\.\b/gi, 'Nomor').replace(/\bKab\.\b/gi, 'Kabupaten').replace(/\bKec\.\b/gi, 'Kecamatan');
                    return processedText;
                },
                speak(text) { window.speechSynthesis.cancel(); const utterance = new SpeechSynthesisUtterance(this.formatTextForTTS(text)); utterance.lang = 'id-ID'; window.speechSynthesis.speak(utterance); }
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
