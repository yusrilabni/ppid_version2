@extends('frontend.layouts.app')

@section('content')
    <style>
        /* Carousel Skeleton Fix: Force side-by-side layout before JS loads */
        .latest-info-carousel:not(.swiper-initialized) .swiper-wrapper,
        .news-carousel:not(.swiper-initialized) .swiper-wrapper {
            display: flex !important;
            gap: 20px !important;
            overflow: hidden !important;
        }
        .latest-info-carousel:not(.swiper-initialized) .swiper-slide,
        .news-carousel:not(.swiper-initialized) .swiper-slide {
            flex: 0 0 100% !important;
        }
        @media (min-width: 640px) {
            .latest-info-carousel:not(.swiper-initialized) .swiper-slide,
            .news-carousel:not(.swiper-initialized) .swiper-slide { flex: 0 0 calc(50% - 10px) !important; }
        }
        @media (min-width: 1024px) {
            .latest-info-carousel:not(.swiper-initialized) .swiper-slide,
            .news-carousel:not(.swiper-initialized) .swiper-slide { flex: 0 0 calc(25% - 15px) !important; }
        }

        [x-cloak] { display: none !important; }
    </style>
        {{-- Hero Slider --}}
        @if ($sliders->count() > 0)
            <div class="swiper hero-slider relative w-full overflow-hidden {{ ($sliderAspectRatio === 'aspect-first' || $sliderAspectRatio === 'aspect-auto') ? '' : $sliderAspectRatio }}">
                <div class="swiper-wrapper">
                    @foreach ($sliders as $slider)
                        <div class="swiper-slide relative">
                            <a href="{{ $slider->link ?: ($slider->informasi ? route('frontend.informasi.detail', $slider->informasi->slug) : '#') }}"
                                class="block w-full h-full">
                                <img src="{{ asset('storage/' . $slider->image) ?: '/placeholder.jpg' }}"
                                    alt="{{ $slider->title }}" 
                                    class="w-full {{ $sliderAspectRatio === 'aspect-auto' ? 'h-auto' : 'h-full' }} object-cover" />
                                <div
                                    class="absolute inset-0 @if ($slider->show_title || $slider->show_description) bg-black bg-opacity-40 @endif flex items-center justify-center overlay-content">
                                    <div class="text-center text-white max-w-4xl mx-auto px-4">
                                        @if ($slider->show_title)
                                            <h2 class="text-2xl md:text-5xl font-bold mb-2 md:mb-4">{{ $slider->title }}</h2>
                                        @endif
                                        @if ($slider->description && $slider->show_description)
                                            <p class="text-base md:text-xl mb-4 md:mb-6 line-clamp-2 md:line-clamp-none">{{ $slider->description }}</p>
                                        @endif
                                        @if ($slider->link)
                                            <span
                                                class="inline-flex items-center justify-center px-6 py-2 md:px-8 md:py-3 border border-transparent text-sm md:text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                                Selengkapnya <i data-lucide="arrow-right" class="ml-2 h-4 w-4"></i>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                {{-- Slider Controls --}}
                @if ($sliders->count() > 1)
                    <button class="swiper-button-prev-custom absolute left-2 md:left-4 top-1/2 transform -translate-y-1/2 bg-black/60 hover:bg-black/80 text-white p-2 md:p-3 rounded-full z-20 border-2 border-white/50 shadow-xl transition-all duration-300 group">
                        <i data-lucide="chevron-left" class="w-5 h-5 md:w-6 md:h-6 group-hover:-translate-x-0.5 transition-transform"></i>
                    </button>
                    <button class="swiper-button-next-custom absolute right-2 md:right-4 top-1/2 transform -translate-y-1/2 bg-black/60 hover:bg-black/80 text-white p-2 md:p-3 rounded-full z-20 border-2 border-white/50 shadow-xl transition-all duration-300 group">
                        <i data-lucide="chevron-right" class="w-5 h-5 md:w-6 md:h-6 group-hover:translate-x-0.5 transition-transform"></i>
                    </button>
                    
                    <!-- Pagination Overlay: Menempel di atas gambar -->
                    <div class="swiper-pagination !absolute !bottom-4 !left-0 !right-0 !z-30"></div>
                @endif
            </div>
            <style>
                /* CSS untuk memastikan tidak ada celah di bawah slider */
                .hero-slider {
                    padding-bottom: 0 !important;
                    margin-bottom: 0 !important;
                }
                .hero-slider .swiper-pagination {
                    line-height: 0 !important;
                    pointer-events: none;
                }
                .hero-slider .swiper-pagination-bullet {
                    pointer-events: auto;
                    background: white !important;
                    opacity: 0.5;
                    width: 8px;
                    height: 8px;
                    margin: 0 4px !important;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.3);
                }
                .hero-slider .swiper-pagination-bullet-active {
                    background: #2563eb !important;
                    opacity: 1;
                    width: 20px;
                    border-radius: 4px;
                }
            </style>
        @endif

        <section class="py-10 bg-white">
            <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-4">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Informasi Terbaru</h2>
                    <p class="text-gray-600 text-sm md:text-base max-w-2xl mx-auto">Dokumen dan pengumuman publik terkini dari PPID Kabupaten Sinjai.</p>
                </div>

                <div class="relative group">
                    <!-- Add Pagination -->
                    <div class="swiper-pagination latest-info-pagination !relative !top-0 !bottom-auto mb-1 mt-1"></div>
                    
                    <div class="swiper-container latest-info-carousel loading overflow-hidden px-1">
                        <div class="swiper-wrapper">
                            @foreach ($latestInformasis as $info)
                                @php
                                    // Pre-calculate data for cleaner view
                                    $unitName = $info->organization->name ?? ($info->user->opd_name ?? 'PPID Kabupaten Sinjai');
                                    $uploaderName = 'Administrator';
                                    if ($info->user) {
                                        $user = $info->user;
                                        if ($user->role === 'superadmin') {
                                            if ($info->unit_id && (string)$info->unit_id !== (string)$user->unit_id) {
                                                $uploaderName = 'Admin PPID ' . $unitName;
                                            } else {
                                                $uploaderName = $user->name;
                                            }
                                        } else {
                                            $uploaderName = $user->name;
                                        }
                                    } else {
                                        $uploaderName = 'Admin PPID ' . $unitName;
                                    }

                                    $catColor = match($info->category) {
                                        'Informasi Berkala' => 'blue',
                                        'Informasi Setiap Saat' => 'green',
                                        'Informasi Serta Merta' => 'yellow',
                                        'Informasi Dikecualikan' => 'red',
                                        default => 'gray'
                                    };
                                @endphp
                                <div class="swiper-slide h-auto">
                                    <div class="bg-white rounded-3xl border-l-4 border-{{ $catColor }}-500 shadow-sm hover:shadow-2xl transition-all duration-500 h-full flex flex-col group/card p-6 hover:-translate-y-2 relative overflow-hidden">
                                        {{-- Decorative Background Icon --}}
                                        <div class="absolute -right-6 -top-6 text-{{ $catColor }}-50 group-hover/card:scale-110 transition-transform duration-700 opacity-50 pointer-events-none">
                                            <i data-lucide="file-text" class="w-32 h-32"></i>
                                        </div>

                                        {{-- Header: Unit & Admin --}}
                                        <div class="mb-5 relative z-10">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="w-9 h-9 rounded-xl bg-{{ $catColor }}-50 flex items-center justify-center text-{{ $catColor }}-600 border border-{{ $catColor }}-100/50">
                                                    <i data-lucide="building-2" class="w-4 h-4"></i>
                                                </div>
                                                <div class="flex flex-col min-w-0">
                                                    <span class="text-[11px] font-extrabold text-gray-800 uppercase tracking-tight line-clamp-1">{{ $unitName }}</span>
                                                    <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Oleh: {{ $uploaderName }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Title --}}
                                        <h3 class="text-gray-900 font-bold text-lg mb-6 line-clamp-2 leading-tight group-hover/card:text-{{ $catColor }}-600 transition-colors relative z-10">
                                            {{ $info->title }}
                                        </h3>

                                        {{-- Footer Info --}}
                                        <div class="mt-auto pt-5 border-t border-gray-50 flex items-end justify-between relative z-10">
                                            <div class="flex flex-col gap-2">
                                                <div class="flex flex-col gap-1">
                                                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest flex items-center">
                                                        <i data-lucide="calendar" class="w-3 h-3 mr-1.5 text-blue-500"></i>
                                                        {{ \Carbon\Carbon::parse($info->tanggal_upload)->locale('id')->isoFormat('D MMMM Y') }}
                                                    </span>
                                                    <span class="text-[10px] text-gray-500 font-bold flex items-center">
                                                        <i data-lucide="file-text" class="w-3 h-3 mr-1.5 text-blue-500"></i>
                                                        {{ $info->jenis_dokumen ?: 'Dokumen Publik' }}
                                                    </span>
                                                </div>
                                                <span class="inline-flex items-center w-fit text-[9px] font-black px-2.5 py-1 rounded-lg bg-{{ $catColor }}-50 text-{{ $catColor }}-600 border border-{{ $catColor }}-100 uppercase tracking-wider">
                                                    {{ $info->category }}
                                                </span>
                                            </div>
                                            
                                            <a href="{{ route('frontend.informasi.detail', $info->slug) }}" 
                                               class="w-11 h-11 rounded-2xl bg-gray-900 text-white flex items-center justify-center hover:bg-{{ $catColor }}-600 transition-all shadow-lg active:scale-90 group/btn">
                                                <i data-lucide="arrow-up-right" class="w-5 h-5 group-hover/btn:translate-x-0.5 group-hover/btn:-translate-y-0.5 transition-transform"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Navigation Buttons --}}
                    <button class="latest-info-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 bg-white shadow-xl rounded-full p-3 z-10 text-gray-700 hover:bg-blue-600 hover:text-white transition-all border border-gray-100 opacity-0 group-hover:opacity-100 group-hover:translate-x-0">
                        <i data-lucide="chevron-left" class="h-6 w-6"></i>
                    </button>
                    <button class="latest-info-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 bg-white shadow-xl rounded-full p-3 z-10 text-gray-700 hover:bg-blue-600 hover:text-white transition-all border border-gray-100 opacity-0 group-hover:opacity-100 group-hover:translate-x-0">
                        <i data-lucide="chevron-right" class="h-6 w-6"></i>
                    </button>
                </div>
            </div>
        </section>

        <section class="py-3 md:py-6 bg-gray-50">
            <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-4">
                    <h2 class="text-xl md:text-3xl font-bold text-gray-900 mb-2 md:mb-4">Berita Terbaru</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto text-xs md:text-base mb-0">
                        Dapatkan informasi terkini seputar kegiatan dan pengumuman dari Humas Sinjai.
                    </p>
                </div>

                @if (!empty($rss_items))
                    <!-- Swiper -->
                    <div class="relative px-1">
                        <div class="swiper-container news-carousel relative loading overflow-hidden pt-0">
                            <!-- Add Pagination -->
                            <div class="swiper-pagination !relative !top-0 !bottom-auto mt-[1px] mb-6"></div>

                            <div class="swiper-wrapper">
                                @foreach ($rss_items as $item)
                                    <div class="swiper-slide h-auto">
                                        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 h-full flex flex-col border border-gray-100 m-1">
                                            <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                                                <img src="{{ $item['image'] ?: 'https://via.placeholder.com/400x225.png?text=No+Image' }}"
                                                    alt="{{ $item['title'] }}" class="w-full h-48 object-cover transform hover:scale-105 transition-transform duration-500" />
                                            </div>
                                            <div class="p-5 flex flex-col flex-grow">
                                                <div class="flex items-center text-xs text-gray-500 mb-3">
                                                    <i data-lucide="calendar" class="h-3.5 w-3.5 mr-1.5 text-blue-500"></i>
                                                    {{ \Carbon\Carbon::parse($item['pubDate'])->locale('id')->isoFormat('D MMMM Y') }}
                                                </div>
                                                <h3 class="text-base font-bold text-gray-900 mb-2 line-clamp-2 leading-snug hover:text-blue-600 transition-colors">
                                                    {{ html_entity_decode(strip_tags($item['title'])) }}
                                                </h3>
                                                <p class="text-xs text-gray-600 line-clamp-3 mb-4 flex-grow">
                                                    {{ html_entity_decode(strip_tags($item['description'])) }}
                                                </p>
                                                <div class="mt-auto">
                                                    <a href="{{ $item['link'] }}" target="_blank"
                                                        class="inline-flex items-center justify-center px-4 py-2.5 border border-blue-100 text-sm font-semibold rounded-lg text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white transition-all duration-300 w-full group">
                                                        Baca Selengkapnya
                                                        <i data-lucide="external-link" class="ml-2 h-3.5 w-3.5 transform group-hover:translate-x-1 transition-transform"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Add Navigation -->
                            <div class="swiper-button-next news-button-next !hidden md:!flex">
                                <i data-lucide="chevron-right"></i>
                            </div>
                            <div class="swiper-button-prev news-button-prev !hidden md:!flex">
                                <i data-lucide="chevron-left"></i>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500">Belum ada berita tersedia</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- Informasi Publik Section --}}
        <section id="informasi" class="py-3 md:py-6 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-1">
                    <h2 class="text-xl md:text-3xl font-bold text-gray-900 mb-2 md:mb-4">Akses informasi publik sesuai dengan kategori yang
                        ditetapkan</h2>
                    <p class="text-sm md:text-lg text-gray-600 max-w-2xl mx-auto">
                        Kami menyediakan berbagai informasi publik yang dapat diakses oleh masyarakat secara transparan dan
                        mudah
                    </p>
                </div>

                @php
                    $informasiMenu = collect(config('menu'))->firstWhere('title', 'Jenis Informasi');
                    $informasiItems = $informasiMenu['children'] ?? [];
                    $cardData = [
                        'Informasi Berkala' => [
                            'color' => 'blue',
                            'points' => [
                                'Profil badan publik dan unit kerja',
                                'Profil pejabat dan tentang OPD',
                                'Program dan kegiatan yang diumumkan rutin',
                                'Ringkasan laporan kinerja dan keuangan',
                                'Informasi layanan publik dan jam pelayanan',
                            ],
                        ],

                        'Informasi Tersedia Setiap Saat' => [
                            'color' => 'green',
                            'points' => [
                                'Dokumen administratif dan arsip resmi',
                                'SOP, SK, dan kebijakan internal',
                                'Dokumen pendukung pelaksanaan kegiatan',
                                'Data dan dokumen yang diberikan jika diminta',
                                'Arsip dokumen tahun berjalan dan sebelumnya',
                            ],
                        ],

                        'Informasi Serta Merta' => [
                            'color' => 'yellow',
                            'points' => [
                                'Informasi bencana alam',
                                'Informasi keadaan darurat',
                                'Gangguan layanan publik berdampak luas',
                                'Ancaman terhadap keselamatan masyarakat',
                                'Kebijakan darurat yang harus segera diketahui',
                            ],
                        ],

                        'Informasi Dikecualikan' => [
                            'color' => 'red',
                            'points' => [
                                'Informasi yang mengandung data pribadi',
                                'Informasi rahasia negara atau jabatan',
                                'Dokumen hukum yang masih berjalan',
                                'Informasi yang berpotensi merugikan pihak tertentu',
                                'Informasi yang ditetapkan melalui uji konsekuensi',
                            ],
                        ],
                    ];
                @endphp
                @if (!empty($informasiItems))
                    <div class="swiper-container info-carousel relative loading !px-2 !py-4 -mx-2 overflow-hidden">
                        <!-- Add Pagination -->
                        <div class="swiper-pagination"></div>
                        <div class="swiper-wrapper mt-8">
                            @foreach ($informasiItems as $index => $item)
                                @php
                                    $data = $cardData[$item['title']] ?? ['color' => 'gray', 'points' => []];
                                    $colorClass = 'bg-' . $data['color'] . '-500';
                                    $textColorClass = 'text-' . $data['color'] . '-600';
                                @endphp
                                <div class="swiper-slide !flex !items-center !justify-center p-2">
                                    <div class="h-full w-full">
                                        <div
                                            class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 h-full flex flex-col group border border-gray-200 overflow-hidden min-h-[350px] md:min-h-[400px]">
                                            <div class="h-2 bg-gradient-to-r {{ $colorClass }}"></div>
                                            <div class="p-5 md:p-8 flex-grow flex flex-col">
                                                <div class="flex items-center mb-4 md:mb-6">
                                                    <div
                                                        class="w-10 h-10 md:w-12 md:h-12 rounded-lg {{ $colorClass }} flex items-center justify-center mr-3 md:mr-4 flex-shrink-0">
                                                        <i
                                                            class="fas {{ isset($item['icon']) ? 'fa-' . $item['icon'] : 'fa-info-circle' }} text-white text-lg md:text-xl"></i>
                                                    </div>
                                                    <h3 class="text-lg md:text-xl font-bold text-gray-800">{{ $item['title'] }}</h3>
                                                </div>
                                                <ul class="space-y-2 md:space-y-3 text-sm md:text-base text-gray-600 flex-grow">
                                                    @foreach ($data['points'] as $point)
                                                        <li class="flex items-start">
                                                            <i
                                                                class="fas fa-check-circle {{ $textColorClass }} mt-1 mr-2 text-xs md:text-sm"></i>
                                                            <span>{{ $point }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="mt-auto p-5 md:p-6 bg-gray-50">
                                                <a href="{{ url($item['url']) }}"
                                                    class="w-full py-2.5 md:py-3 px-4 rounded-lg bg-gradient-to-r {{ $colorClass }} text-white font-semibold text-center block hover:opacity-90 transition-opacity text-sm md:text-base">
                                                    Akses Informasi
                                                    <i class="fas fa-arrow-right ml-2 text-xs md:text-sm"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Add Navigation -->
                        <div class="swiper-button-next info-button-next hidden md:flex">
                            <i data-lucide="chevron-right"></i>
                        </div>
                        <div class="swiper-button-prev info-button-prev hidden md:flex">
                            <i data-lucide="chevron-left"></i>
                        </div>
                    </div>
                @endif

                <div class="mt-3 md:mt-6 text-center">
                    <a href="#"
                        class="inline-flex items-center justify-center px-6 py-2 md:px-8 md:py-3 border border-transparent text-sm md:text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Ajukan Permohonan Informasi
                    </a>
                </div>
            </div>
        </section>

        {{-- Galeri Section --}}
        <section id="galeri" class="py-3 md:py-6 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-1">
                    <h2 class="text-xl md:text-3xl font-bold text-gray-900 mb-2 md:mb-4">Galeri</h2>
                    <p class="text-xs md:text-base text-gray-600 max-w-2xl mx-auto">
                        Dokumentasi kegiatan dan momen penting PPID
                    </p>
                </div>

                @if (isset($galeri) && $galeri->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                        @foreach ($galeri as $item)
                            <div
                                class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow group">
                                <div class="aspect-w-16 aspect-h-12 relative">
                                    @if ($item->type === 'foto')
                                        <a href="{{ $item->video ? $item->video : (asset('storage/' . $item->image) ?: '/placeholder.jpg') }}"
                                            {{ $item->video ? 'target="_blank"' : '' }} class="block">
                                            <img src="{{ asset('storage/' . $item->image) ?: '/placeholder.jpg' }}"
                                                alt="{{ $item->title }}"
                                                class="w-full h-40 md:h-48 object-cover group-hover:scale-105 transition-transform duration-300" />
                                            <div class="absolute top-2 right-2 bg-white bg-opacity-90 rounded-full p-2">
                                                <i data-lucide="camera" class="h-3 w-3 md:h-4 md:w-4 text-gray-700"></i>
                                            </div>
                                        </a>
                                    @else
                                        @php
                                            $videoId = null;
                                            $url = parse_url($item->video ?? '');
                                            if (
                                                isset($url['host']) &&
                                                (strpos($url['host'], 'youtube.com') !== false ||
                                                    strpos($url['host'], 'youtu.be') !== false)
                                            ) {
                                                if (isset($url['query'])) {
                                                    parse_str($url['query'], $params);
                                                    $videoId = $params['v'] ?? null;
                                                }
                                                if (!$videoId && isset($url['path'])) {
                                                    $pathParts = explode('/', $url['path']);
                                                    $videoId = end($pathParts);
                                                }
                                            }
                                        @endphp
                                        @if ($videoId)
                                            <a href="{{ $item->video }}" target="_blank" class="block">
                                                <img src="https://img.youtube.com/vi/{{ $videoId }}/default.jpg"
                                                    alt="{{ $item->title }}"
                                                    class="w-full h-40 md:h-48 object-cover group-hover:scale-105 transition-transform duration-300" />
                                                <div
                                                    class="absolute top-2 right-2 bg-white bg-opacity-90 rounded-full p-2">
                                                    <i data-lucide="play-circle" class="h-3 w-3 md:h-4 md:w-4 text-gray-700"></i>
                                                </div>
                                            </a>
                                        @else
                                            <a href="{{ $item->video }}" target="_blank" class="block">
                                                <div class="w-full h-40 md:h-48 bg-gray-200 flex items-center justify-center">
                                                    <i data-lucide="video" class="h-10 w-10 md:h-12 md:w-12 text-gray-400"></i>
                                                    <div
                                                        class="absolute top-2 right-2 bg-white bg-opacity-90 rounded-full p-2">
                                                        <i data-lucide="video" class="h-3 w-3 md:h-4 md:w-4 text-gray-700"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 mb-1 line-clamp-1 text-sm md:text-base">
                                        {{ $item->title }}
                                    </h3>
                                    @if ($item->category)
                                        <span
                                            class="inline-block px-2 py-0.5 text-[10px] md:text-xs bg-blue-100 text-blue-800 rounded-full mb-2">
                                            {{ $item->category }}
                                        </span>
                                    @endif
                                    @if ($item->description)
                                        <p class="text-xs md:text-sm text-gray-600 line-clamp-2">
                                            {{ $item->description }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i data-lucide="image" class="h-12 w-12 md:h-16 md:w-16 text-gray-300 mx-auto mb-4"></i>
                        <p class="text-gray-500">Belum ada galeri tersedia</p>
                    </div>
                @endif

                <div class="text-center mt-6 md:mt-8">
                    <a href="{{ route('frontend.galeri.all') }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-xs md:text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Lihat Semua Galeri
                    </a>
                </div>
            </div>
        </section>

        {{-- Statistik Section --}}
        <section class="py-3 md:py-6 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-1">
                    <h2 class="text-xl md:text-3xl font-bold text-gray-900 mb-2 md:mb-4">Statistik PPID</h2>
                    <p class="text-xs md:text-base text-gray-600 max-w-2xl mx-auto">
                        Data statistik kinerja pelayanan informasi publik
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8 md:mb-12">
                    <!-- Total Informasi Publik -->
                    <div class="bg-blue-50 p-5 md:p-6 rounded-lg shadow-md text-center">
                        <i class="fas fa-info-circle text-blue-600 text-3xl md:text-4xl mb-2 md:mb-3"></i>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1 md:mb-2">
                            {{ number_format($frontendStats['informasi']['total'], 0, ',', '.') }}</h3>
                        <p class="text-sm md:text-base text-gray-600">Informasi Publik</p>
                    </div>

                    <!-- Total Permohonan Informasi -->
                    <div class="bg-green-50 p-5 md:p-6 rounded-lg shadow-md text-center">
                        <i class="fas fa-file-alt text-green-600 text-3xl md:text-4xl mb-2 md:mb-3"></i>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1 md:mb-2">
                            {{ number_format($frontendStats['permohonan'], 0, ',', '.') }}</h3>
                        <p class="text-sm md:text-base text-gray-600">Jumlah Permohonan</p>
                    </div>

                    <!-- Total Respon Survei -->
                    <div class="bg-purple-50 p-5 md:p-6 rounded-lg shadow-md text-center">
                        <i class="fas fa-poll text-purple-600 text-3xl md:text-4xl mb-2 md:mb-3"></i>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1 md:mb-2">
                            {{ number_format($frontendStats['survey_responses'], 0, ',', '.') }}</h3>
                        <p class="text-sm md:text-base text-gray-600">Jumlah Respon Survei</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-5 md:p-8">
                    <h3 class="text-lg md:text-xl font-semibold mb-4 md:mb-6 text-center">Laporan Kinerja</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center items-center">
                        <div class="p-4 md:p-0 bg-white md:bg-transparent rounded-lg shadow-sm md:shadow-none">
                            <div class="text-xl md:text-2xl font-bold text-blue-600 mb-1 md:mb-2">{{ $tingkatKepuasan }}%</div>
                            <p class="text-xs md:text-sm text-gray-600 mb-3">Tingkat Kepuasan Layanan</p>
                            
                            <!-- Overlapping Avatars for Ratings -->
                            <div class="flex items-center justify-center py-2">
                                <div class="flex items-center -space-x-4 overflow-hidden">
                                    @php
                                        // Selalu tampilkan 3 bulatan profil
                                        $displayCount = 3;
                                        $realRatings = isset($ratedPermohonans) ? $ratedPermohonans : collect();
                                    @endphp

                                    @for ($i = 0; $i < $displayCount; $i++)
                                        @if (isset($realRatings[$i]))
                                            @php $permohonan = $realRatings[$i]; @endphp
                                            <div class="inline-block h-10 w-10 rounded-full ring-2 ring-white overflow-hidden bg-gray-100 z-{{ 30 - ($i * 10) }}" title="{{ $permohonan->user->name ?? $permohonan->nama_pemohon }}">
                                                @if($permohonan->user && $permohonan->user->profile_photo_path)
                                                    <img src="{{ asset('storage/' . $permohonan->user->profile_photo_path) }}" alt="Avatar" class="h-full w-full object-cover">
                                                @else
                                                    <div class="h-full w-full flex items-center justify-center bg-blue-100 text-blue-600 text-xs font-bold">
                                                        {{ strtoupper(substr($permohonan->user->name ?? $permohonan->nama_pemohon, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            {{-- Placeholder Bulat jika rating asli belum mencapai 3 --}}
                                            <div class="inline-block h-10 w-10 rounded-full ring-2 ring-white overflow-hidden bg-gray-200 z-{{ 30 - ($i * 10) }} flex items-center justify-center text-gray-400">
                                                <i class="fas fa-user text-xs"></i>
                                            </div>
                                        @endif
                                    @endfor
                                </div>
                                <div class="ml-4 text-xs md:text-sm font-bold text-gray-700 bg-gray-100 px-4 py-1.5 rounded-full border border-gray-200 shadow-sm">
                                    {{ number_format(\App\Models\PermohonanInformasi::whereNotNull('rating')->count(), 0, ',', '.') }} Penilaian
                                </div>
                            </div>
                        </div>
                        <div class="p-4 md:p-0 bg-white md:bg-transparent rounded-lg shadow-sm md:shadow-none">
                            <div class="text-xl md:text-2xl font-bold text-green-600 mb-1 md:mb-2">{{ $rataRataWaktuRespon }} Hari</div>
                            <p class="text-xs md:text-sm text-gray-600">Rata-rata Waktu Respon</p>
                        </div>
                        <div class="p-4 md:p-0 bg-white md:bg-transparent rounded-lg shadow-sm md:shadow-none">
                            <div class="text-xl md:text-2xl font-bold text-purple-600 mb-1 md:mb-2">{{ $tingkatPenyelesaian }}%</div>
                            <p class="text-xs md:text-sm text-gray-600">Tingkat Penyelesaian Permohonan</p>
                        </div>
                    </div>

                    {{-- Running Ticker: Latest Responses --}}
                    @if(isset($latestResponses) && $latestResponses->count() > 0)
                        <div class="mt-8 bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden flex items-center">
                            <div class="bg-blue-600 text-white px-4 py-3 font-bold text-xs md:text-sm whitespace-nowrap flex items-center gap-2 z-10 shadow-lg shrink-0">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-100 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                                </span>
                                TANGGAPAN TERBARU
                            </div>
                            <div class="flex-1 overflow-hidden relative bg-gray-50/50 py-3">
                                <div class="animate-marquee whitespace-nowrap flex items-center gap-12">
                                    @foreach($latestResponses as $resp)
                                        <div class="inline-flex items-center gap-3">
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-[10px] font-bold text-blue-600 border border-blue-200">
                                                    {{ strtoupper(substr($resp->user->name ?? 'A', 0, 1)) }}
                                                </div>
                                                <span class="font-bold text-gray-800 text-xs">{{ $resp->user->name ?? 'Admin' }}</span>
                                            </div>
                                            <span class="text-gray-400">|</span>
                                            <span class="text-xs text-gray-600 italic">"{{ Str::limit($resp->message, 80) }}"</span>
                                            <span class="text-[10px] text-gray-400 font-medium bg-white px-2 py-0.5 rounded-full border border-gray-100">
                                                {{ $resp->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <style>
                            @keyframes marquee {
                                0% { transform: translateX(0); }
                                100% { transform: translateX(-50%); }
                            }
                            .animate-marquee {
                                display: inline-flex;
                                animation: marquee 40s linear infinite;
                                width: max-content;
                            }
                            .animate-marquee:hover {
                                animation-play-state: paused;
                            }
                        </style>
                        {{-- Duplicate items for seamless loop if content is short --}}
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const marquee = document.querySelector('.animate-marquee');
                                if (marquee) {
                                    marquee.innerHTML += marquee.innerHTML;
                                }
                            });
                        </script>
                    @endif
                </div>
            </div>
        </section>

        {{-- Kontak Section --}}
        <section id="kontak" class="py-3 md:py-6 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-1">
                    <h2 class="text-xl md:text-3xl font-bold text-gray-900 mb-2 md:mb-4">Kontak Kami</h2>
                    <p class="text-xs md:text-base text-gray-600 max-w-2xl mx-auto">
                        Hubungi kami untuk informasi lebih lanjut atau ajukan permohonan informasi publik
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                    {{-- Contact Info --}}
                    <div>
                        <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-4 md:mb-6">Informasi Kontak</h3>

                        <div class="space-y-4 md:space-y-6">
                            <div class="flex items-start space-x-3 md:space-x-4">
                                <div
                                    class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="h-5 w-5 md:h-6 md:w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm md:text-base font-medium text-gray-900">Alamat</h4>
                                    <p class="text-xs md:text-sm text-gray-600 mt-0.5 md:mt-1">
                                        {{ $contactInfo['address'] ?? 'Jl. Contoh No. 123, Kota, Provinsi' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3 md:space-x-4">
                                <div
                                    class="w-10 h-10 md:w-12 md:h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="h-5 w-5 md:h-6 md:w-6 text-green-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm md:text-base font-medium text-gray-900">Telepon</h4>
                                    <p class="text-xs md:text-sm text-gray-600 mt-0.5 md:mt-1">{{ $contactInfo['phone'] ?? '(021) 1234-5678' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3 md:space-x-4">
                                <div
                                    class="w-10 h-10 md:w-12 md:h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="h-5 w-5 md:h-6 md:w-6 text-purple-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm md:text-base font-medium text-gray-900">Email</h4>
                                    <p class="text-xs md:text-sm text-gray-600 mt-0.5 md:mt-1">{{ $contactInfo['email'] ?? 'info @contoh.com' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 md:mt-8 p-5 md:p-6 bg-blue-50 rounded-lg border border-blue-100">
                            <h4 class="text-sm md:text-base font-semibold text-gray-900 mb-3">Jam Pelayanan</h4>
                            <div class="space-y-2 text-xs md:text-sm text-gray-700">
                                <p class="flex justify-between">
                                    <span class="font-medium">Senin - Kamis:</span>
                                    <span>{{ $contactInfo['service_hours_weekday'] ?? '08:00 - 16:00' }}</span>
                                </p>
                                <p class="flex justify-between">
                                    <span class="font-medium">Jumat:</span>
                                    <span>{{ $contactInfo['service_hours_friday'] ?? '08:00 - 15:30' }}</span>
                                </p>
                                <p class="flex justify-between">
                                    <span class="font-medium">Sabtu - Minggu:</span>
                                    <span>{{ $contactInfo['service_hours_weekend'] ?? 'Libur' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Contact Form --}}
                    <div x-data="{ contactMethod: 'email' }">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                            {{-- Tab Header --}}
                            <div class="flex border-b border-gray-100 bg-gray-50/50">
                                <button @click="contactMethod = 'email'" 
                                    :class="contactMethod === 'email' ? 'bg-white border-b-2 border-blue-600 text-blue-600' : 'text-gray-500 hover:bg-gray-100'"
                                    class="flex-1 py-4 px-6 text-sm font-bold transition-all flex items-center justify-center gap-2">
                                    <i class="fas fa-envelope"></i> Kirim via Email
                                </button>
                                <button @click="contactMethod = 'whatsapp'" 
                                    :class="contactMethod === 'whatsapp' ? 'bg-white border-b-2 border-green-600 text-green-600' : 'text-gray-500 hover:bg-gray-100'"
                                    class="flex-1 py-4 px-6 text-sm font-bold transition-all flex items-center justify-center gap-2">
                                    <i class="fab fa-whatsapp text-lg"></i> Kirim via WhatsApp
                                </button>
                            </div>

                            <div class="p-5 md:p-8">
                                <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-4 md:mb-6" x-text="contactMethod === 'email' ? 'Kirim Pesan Email' : 'Kirim Pesan WhatsApp'">Kirim Pesan</h3>
                                <form id="contactForm" class="space-y-4 md:space-y-6">
                                    @csrf
                                    <input type="hidden" name="method" :value="contactMethod">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                        <div>
                                            <label for="name" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                                                Nama Lengkap <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" id="name" name="name" required
                                                class="w-full px-4 py-2.5 md:py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition duration-200 text-sm"
                                                placeholder="Masukkan nama lengkap" />
                                            <p class="mt-1 text-xs text-red-500 hidden" id="nameError"></p>
                                        </div>

                                        <div>
                                            <label for="email" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                                                Email <span class="text-red-500">*</span>
                                            </label>
                                            <input type="email" id="email" name="email" required
                                                class="w-full px-4 py-2.5 md:py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition duration-200 text-sm"
                                                placeholder="email @contoh.com" />
                                            <p class="mt-1 text-xs text-red-500 hidden" id="emailError"></p>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="subject" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                                            Subjek <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="subject" name="subject" required
                                            class="w-full px-4 py-2.5 md:py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition duration-200 text-sm"
                                            placeholder="Subjek pesan" />
                                        <p class="mt-1 text-xs text-red-500 hidden" id="subjectError"></p>
                                    </div>

                                    <div>
                                        <label for="message" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                                            Pesan <span class="text-red-500">*</span>
                                        </label>
                                        <textarea id="message" name="message" rows="4 md:rows-5" required
                                            class="w-full px-4 py-2.5 md:py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition duration-200 resize-none text-sm"
                                            placeholder="Tulis pesan Anda di sini..."></textarea>
                                        <p class="mt-1 text-xs text-red-500 hidden" id="messageError"></p>
                                    </div>

                                    <button type="submit" id="submitBtn"
                                        :class="contactMethod === 'email' ? 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500' : 'bg-green-600 hover:bg-green-700 focus:ring-green-500'"
                                        class="w-full inline-flex items-center justify-center px-6 py-3 md:py-3.5 border border-transparent text-sm md:text-base font-bold rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition duration-200 shadow-md">
                                        <i :class="contactMethod === 'email' ? 'fas fa-paper-plane' : 'fab fa-whatsapp text-lg'" class="mr-2"></i>
                                        <span id="submitText" x-text="contactMethod === 'email' ? 'Kirim Pesan Email' : 'Kirim Pesan WhatsApp'">Kirim Pesan</span>
                                        <span id="loadingSpinner" class="hidden ml-2">
                                            <svg class="animate-spin h-4 w-4 md:h-5 md:w-5 text-white"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </span>
                                    </button>

                                    <div id="formMessage" class="text-center text-xs mt-4 hidden"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection

@push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const heroSwiper = new Swiper('.hero-slider', {
                    loop: true,
                    effect: '{{ $sliderAnimationType }}',
                    autoHeight: {{ $sliderAspectRatio === 'aspect-auto' ? 'true' : 'false' }},
                    speed: 1000,
                    observer: true,
                    observeParents: true,
                    on: {
                        init: function() {
                            const self = this;
                            if ('{{ $sliderAspectRatio }}' === 'aspect-first') {
                                const lockToFirst = () => {
                                    const firstSlide = self.slides.find(s => s.getAttribute('data-swiper-slide-index') === '0');
                                    const firstImg = firstSlide ? firstSlide.querySelector('img') : null;
                                    if (firstImg && firstImg.complete && firstImg.naturalWidth) {
                                        const ratio = firstImg.naturalHeight / firstImg.naturalWidth;
                                        const targetHeight = self.el.offsetWidth * ratio;
                                        self.el.style.height = targetHeight + 'px';
                                        self.slides.forEach(s => {
                                            s.style.height = targetHeight + 'px';
                                        });
                                        self.update();
                                    } else if (firstImg) {
                                        firstImg.onload = lockToFirst;
                                    }
                                };
                                setTimeout(lockToFirst, 300);
                                window.addEventListener('resize', lockToFirst);
                            } else {
                                setTimeout(() => { self.update(); }, 300);
                            }
                        },
                        slideChangeTransitionStart: function() {
                            if (this.params.autoHeight) {
                                this.updateAutoHeight(500);
                            }
                        }
                    },
                    autoplay: {
                        delay: {{ $transitionDuration }},
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next-custom',
                        prevEl: '.swiper-button-prev-custom',
                    },
                    @if($sliderAnimationType === 'fade')
                    fadeEffect: { crossFade: true },
                    @elseif($sliderAnimationType === 'cube')
                    cubeEffect: { shadow: true, slideShadows: true, shadowOffset: 20, shadowScale: 0.94 },
                    @elseif($sliderAnimationType === 'flip')
                    flipEffect: { rotate: 30, slideShadows: true },
                    @elseif($sliderAnimationType === 'coverflow')
                    coverflowEffect: { rotate: 50, stretch: 0, depth: 100, modifier: 1, slideShadows: true },
                    @endif
                });
            });
        </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {            var latestInfoSwiper = new Swiper('.latest-info-carousel', {
                slidesPerView: 1,
                slidesPerGroup: 1,
                spaceBetween: 20,
                loop: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.latest-info-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.latest-info-next',
                    prevEl: '.latest-info-prev',
                },
                breakpoints: {
                    640: { 
                        slidesPerView: 2,
                        slidesPerGroup: 2,
                    },
                    1024: { 
                        slidesPerView: 3,
                        slidesPerGroup: 3,
                    },
                    1280: { 
                        slidesPerView: 4,
                        slidesPerGroup: 4,
                    },
                },
                on: {
                    init: function() {
                        this.el.classList.remove('loading');
                    },
                }
            });

            var newsSwiper = new Swiper('.news-carousel', {
                slidesPerView: 1,
                slidesPerGroup: 1,
                spaceBetween: 20,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.news-button-next',
                    prevEl: '.news-button-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        slidesPerGroup: 2,
                    },
                    768: {
                        slidesPerView: 3,
                        slidesPerGroup: 3,
                    },
                    1024: {
                        slidesPerView: 4,
                        slidesPerGroup: 4,
                    },
                },
                on: {
                    init: function() {
                        this.el.classList.remove('loading');
                    },
                }
            });

            var infoSwiper = new Swiper('.info-carousel', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: false,
                autoHeight: true,
                on: {
                    init: function() {
                        this.el.classList.remove('loading');
                    },
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.info-button-next',
                    prevEl: '.info-button-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 1,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 30,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                }
            });

            const contactForm = document.getElementById('contactForm');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const formMessage = document.getElementById('formMessage');

            function showError(fieldId, message) {
                const errorElement = document.getElementById(fieldId + 'Error');
                const inputElement = document.getElementById(fieldId);

                errorElement.textContent = message;
                errorElement.classList.remove('hidden');
                inputElement.classList.add('border-red-500');
                inputElement.classList.remove('border-gray-300');
            }

            function clearError(fieldId) {
                const errorElement = document.getElementById(fieldId + 'Error');
                const inputElement = document.getElementById(fieldId);

                errorElement.classList.add('hidden');
                inputElement.classList.remove('border-red-500');
                inputElement.classList.add('border-gray-300');
            }

            function showMessage(message, isSuccess) {
                formMessage.textContent = message;
                formMessage.className = 'text-center text-sm mt-4 ' + (isSuccess ? 'text-green-600' :
                    'text-red-600');
                formMessage.classList.remove('hidden');

                if (isSuccess) {
                    setTimeout(() => {
                        formMessage.classList.add('hidden');
                    }, 5000);
                }
            }

            contactForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Clear previous errors and messages
                ['name', 'email', 'subject', 'message'].forEach(clearError);
                formMessage.classList.add('hidden');

                // Get form data
                const formData = new FormData(this);
                const method = formData.get('method') || 'email';

                // Basic validation
                let isValid = true;
                if (!formData.get('name').trim()) {
                    showError('name', 'Nama lengkap harus diisi');
                    isValid = false;
                }

                if (!formData.get('email').trim()) {
                    showError('email', 'Email harus diisi');
                    isValid = false;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.get('email'))) {
                    showError('email', 'Format email tidak valid');
                    isValid = false;
                }

                if (!formData.get('subject').trim()) {
                    showError('subject', 'Subjek harus diisi');
                    isValid = false;
                }

                if (!formData.get('message').trim()) {
                    showError('message', 'Pesan harus diisi');
                    isValid = false;
                }

                if (!isValid) return;

                // Disable submit button and show loading
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                loadingSpinner.classList.remove('hidden');

                try {
                    const name = formData.get('name');
                    const email = formData.get('email');
                    const subject = formData.get('subject');
                    const message = formData.get('message');
                    
                    if (method === 'email') {
                        const recipient = "ppidkabsinjai@gmail.com";
                        const mailBody = `Saya ${name}, dengan email ${email}, ingin menyampaikan: ${message}`;
                        const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=${recipient}&su=${encodeURIComponent(subject)}&body=${encodeURIComponent(mailBody)}`;
                        window.open(gmailUrl, '_blank');
                        showMessage('Membuka Gmail... Pesan Anda telah disiapkan.', true);
                    } else {
                        const waNumber = "6285156878911";
                        const waMessage = `*Pesan Baru dari Website PPID*\n\n*Nama:* ${name}\n*Email:* ${email}\n*Subjek:* ${subject}\n\n*Pesan:*\n${message}`;
                        const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(waMessage)}`;
                        window.open(waUrl, '_blank');
                        showMessage('Membuka WhatsApp... Pesan Anda telah disiapkan.', true);
                    }

                    contactForm.reset();
                } catch (error) {
                    console.error('Error:', error);
                    showMessage('Terjadi kesalahan saat menyiapkan pesan.', false);
                } finally {
                    // Re-enable submit button
                    submitBtn.disabled = false;
                    submitText.classList.remove('hidden');
                    loadingSpinner.classList.add('hidden');
                }
            });

            // Real-time validation
            ['name', 'email', 'subject', 'message'].forEach(fieldId => {
                const input = document.getElementById(fieldId);
                input.addEventListener('input', () => clearError(fieldId));
            });
        });
    </script>
@endpush
