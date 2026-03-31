@extends('frontend.layouts.app')

@section('content')
        {{-- Hero Slider --}}
        @if ($sliders->count() > 0)
            <div x-data="{ currentSlide: 0, sliders: @js($sliders), transitionDuration: {{ $transitionDuration }} }" x-init="setInterval(() => { currentSlide = (currentSlide + 1) % sliders.length }, transitionDuration)"
                class="relative w-full overflow-hidden slider-container">
                <div class="grid grid-cols-1 grid-rows-1">
                    @foreach ($sliders as $index => $slider)
                        <div class="col-start-1 row-start-1 {{ $index !== 0 ? 'hidden' : '' }}" x-show="currentSlide === {{ $index }}"
                            :class="{ 'hidden': currentSlide !== {{ $index }} }"
                            x-transition:opacity.duration.1000ms>
                            <a href="{{ $slider->link ?: ($slider->informasi ? route('frontend.informasi.detail', $slider->informasi->slug) : '#') }}"
                                class="block relative w-full h-full">
                                <img src="{{ asset('storage/' . $slider->image) ?: '/placeholder.jpg' }}"
                                    alt="{{ $slider->title }}" class="w-full h-auto md:h-[500px] md:object-cover" 
                                    fetchpriority="{{ $index === 0 ? 'high' : 'auto' }}" 
                                    loading="{{ $index === 0 ? 'eager' : 'lazy' }}" />
                                <div
                                    class="absolute inset-0 @if ($slider->show_title || $slider->show_description) bg-black bg-opacity-40 @endif flex items-center justify-center overlay-content">
                                    <div class="text-center text-white max-w-4xl mx-auto px-4">
                                        @if ($slider->show_title)
                                            <h2 class="text-xl md:text-5xl font-bold mb-2 md:mb-4">{{ $slider->title }}</h2>
                                        @endif
                                        @if ($slider->description && $slider->show_description)
                                            <p class="text-xs md:text-xl mb-4 md:mb-6 line-clamp-2 md:line-clamp-none">{{ $slider->description }}</p>
                                        @endif
                                        @if ($slider->link)
                                            <span
                                                class="inline-flex items-center justify-center px-4 py-2 md:px-8 md:py-3 border border-transparent text-xs md:text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                                Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
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
                    <button @click="currentSlide = (currentSlide - 1 + sliders.length) % sliders.length"
                        class="absolute left-2 md:left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-60 hover:bg-opacity-80 text-white p-1.5 md:p-3 rounded-full z-20 border border-white border-opacity-50 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3 md:w-5 md:h-5">
                            <path d="m12 19-7-7 7-7" /><path d="M19 12H5" />
                        </svg>
                    </button>
                    <button @click="currentSlide = (currentSlide + 1) % sliders.length"
                        class="absolute right-2 md:right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-60 hover:bg-opacity-80 text-white p-1.5 md:p-3 rounded-full z-20 border border-white border-opacity-50 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3 md:w-5 md:h-5">
                            <path d="M5 12h14" /><path d="m12 5 7 7-7 7" />
                        </svg>
                    </button>
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-1.5 z-20">
                        @foreach ($sliders as $index => $slider)
                            <button @click="currentSlide = {{ $index }}"
                                :class="{ 'bg-white border-2 border-white': currentSlide === {{ $index }}, 'bg-white bg-opacity-50 border border-white': currentSlide !== {{ $index }} }"
                                class="w-2 h-2 md:w-3 md:h-3 rounded-full transition-all duration-300"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        {{-- Informasi Terbaru Section --}}
        <section class="py-6 md:py-10 bg-white">
            <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-4 md:mb-10">
                    <h2 class="text-xl md:text-3xl font-bold text-gray-900 mb-1 md:mb-2">Informasi Terbaru</h2>
                    <p class="text-gray-600 text-xs md:text-base max-w-2xl mx-auto">Dokumen dan pengumuman publik terkini dari PPID Kabupaten Sinjai.</p>
                </div>

                <div class="relative group px-0 md:px-2">
                    <div class="swiper-pagination latest-info-pagination !relative !top-0 !bottom-auto mb-2 md:mb-4 mt-1 md:mt-2"></div>
                    <div class="swiper-container latest-info-carousel overflow-hidden">
                        <div class="swiper-wrapper">
                            @foreach ($latestInformasis as $info)
                                @php
                                    $unitName = $info->organization->name ?? ($info->user->opd_name ?? 'PPID Kabupaten Sinjai');
                                    $uploaderName = $info->user->name ?? 'Admin PPID';
                                    $catColor = match($info->category) {
                                        'Informasi Berkala' => 'blue',
                                        'Informasi Setiap Saat' => 'green',
                                        'Informasi Serta Merta' => 'yellow',
                                        'Informasi Dikecualikan' => 'red',
                                        default => 'gray'
                                    };
                                @endphp
                                <div class="swiper-slide h-auto p-1">
                                    <div class="bg-white rounded-2xl md:rounded-3xl border-l-4 border-{{ $catColor }}-500 shadow-sm hover:shadow-2xl transition-all duration-500 h-full flex flex-col group/card p-4 md:p-6 hover:-translate-y-2 relative overflow-hidden m-0.5">
                                        <div class="absolute -right-6 -top-6 text-{{ $catColor }}-50 group-hover/card:scale-110 transition-transform duration-700 opacity-50 pointer-events-none">
                                            <i class="fas fa-file-alt text-6xl md:text-8xl"></i>
                                        </div>
                                        <div class="mb-3 md:mb-5 relative z-10">
                                            <div class="flex items-center gap-2 md:gap-3 mb-1 md:mb-2">
                                                <div class="w-7 h-7 md:w-9 md:h-9 rounded-lg md:rounded-xl bg-{{ $catColor }}-50 flex items-center justify-center text-{{ $catColor }}-600 border border-{{ $catColor }}-100/50">
                                                    <i class="fas fa-building text-[10px] md:text-sm"></i>
                                                </div>
                                                <div class="flex flex-col min-w-0">
                                                    <span class="text-[9px] md:text-[11px] font-extrabold text-gray-800 uppercase tracking-tight line-clamp-1">{{ $unitName }}</span>
                                                    <span class="text-[8px] md:text-[9px] text-gray-400 font-bold uppercase tracking-wider">Oleh: {{ $uploaderName }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="text-gray-900 font-bold text-sm md:text-lg mb-4 md:mb-6 line-clamp-2 leading-tight group-hover/card:text-{{ $catColor }}-600 transition-colors relative z-10">
                                            {{ $info->title }}
                                        </h3>
                                        <div class="mt-auto pt-3 md:pt-5 border-t border-gray-50 flex items-end justify-between relative z-10">
                                            <div class="flex flex-col gap-1.5 md:gap-2">
                                                <div class="flex flex-col gap-0.5 md:gap-1">
                                                    <span class="text-[8px] md:text-[10px] text-gray-400 font-bold uppercase tracking-widest flex items-center">
                                                        <i class="fas fa-calendar-alt mr-1 md:mr-1.5 text-blue-500"></i>
                                                        {{ \Carbon\Carbon::parse($info->tanggal_upload)->locale('id')->isoFormat('D MMMM Y') }}
                                                    </span>
                                                    <span class="text-[8px] md:text-[10px] text-gray-500 font-bold flex items-center">
                                                        <i class="fas fa-file-pdf mr-1 md:mr-1.5 text-blue-500"></i>
                                                        {{ $info->jenis_dokumen ?: 'Dokumen Publik' }}
                                                    </span>
                                                </div>
                                                <span class="inline-flex items-center w-fit text-[7px] md:text-[9px] font-black px-1.5 md:px-2.5 py-0.5 md:py-1 rounded-md md:rounded-lg bg-{{ $catColor }}-50 text-{{ $catColor }}-600 border border-{{ $catColor }}-100 uppercase tracking-wider">
                                                    {{ $info->category }}
                                                </span>
                                            </div>
                                            <a href="{{ route('frontend.informasi.detail', $info->slug) }}" 
                                               class="w-8 h-8 md:w-11 md:h-11 rounded-xl md:rounded-2xl bg-gray-900 text-white flex items-center justify-center hover:bg-{{ $catColor }}-600 transition-all shadow-lg active:scale-90 group/btn">
                                                <i class="fas fa-arrow-right text-xs md:text-base group-hover/btn:translate-x-0.5 group-hover/btn:-translate-y-0.5 transition-transform"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button class="latest-info-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-2 bg-white shadow-xl rounded-full p-2 md:p-3 z-10 text-gray-700 hover:bg-blue-600 hover:text-white transition-all border border-gray-100 hidden md:block">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="latest-info-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 bg-white shadow-xl rounded-full p-2 md:p-3 z-10 text-gray-700 hover:bg-blue-600 hover:text-white transition-all border border-gray-100 hidden md:block">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </section>

        <section class="py-6 md:py-10 bg-gray-50">
            <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-0">
                    <h2 class="text-xl md:text-3xl font-bold text-gray-900 mb-1 md:mb-2">Berita Terbaru</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto text-xs md:text-base">Dapatkan informasi terkini seputar kegiatan dan pengumuman dari Humas Sinjai.</p>
                </div>
                @if (!empty($rss_items))
                    <div class="relative px-0 md:px-10">
                        <div class="swiper-pagination news-pagination !relative !top-0 !bottom-auto mb-1 mt-1 md:mt-2"></div>
                        <div class="swiper-container news-carousel relative overflow-hidden pt-0">
                            <div class="swiper-wrapper">
                                @foreach ($rss_items as $item)
                                    <div class="swiper-slide h-auto p-1">
                                        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 h-full flex flex-col border border-gray-100 m-0.5">
                                            <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                                                <img src="{{ $item['image'] ?: 'https://via.placeholder.com/400x225.png?text=No+Image' }}"
                                                    alt="{{ $item['title'] }}" class="w-full h-36 md:h-48 object-cover transform hover:scale-105 transition-transform duration-500" loading="lazy" />
                                            </div>
                                            <div class="p-4 md:p-5 flex flex-col flex-grow">
                                                <div class="flex items-center text-[10px] md:text-xs text-gray-500 mb-2 md:mb-3">
                                                    <i class="fas fa-calendar-alt mr-1 md:mr-1.5 text-blue-500"></i>
                                                    {{ \Carbon\Carbon::parse($item['pubDate'])->locale('id')->isoFormat('D MMMM Y') }}
                                                </div>
                                                <h3 class="text-sm md:text-base font-bold text-gray-900 mb-1 md:mb-2 line-clamp-2 leading-snug">
                                                    {{ html_entity_decode(strip_tags($item['title'])) }}
                                                </h3>
                                                <p class="text-[10px] md:text-xs text-gray-600 line-clamp-3 mb-3 md:mb-4 flex-grow">{{ html_entity_decode(strip_tags($item['description'])) }}</p>
                                                <div class="mt-auto">
                                                    <a href="{{ $item['link'] }}" target="_blank" class="inline-flex items-center justify-center px-3 py-2 md:px-4 md:py-2.5 border border-blue-100 text-[10px] md:text-sm font-semibold rounded-lg text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white transition-all duration-300 w-full group">
                                                        Baca Selengkapnya <i class="fas fa-external-link-alt ml-1.5"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button class="news-button-prev absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow-xl rounded-full p-2 md:p-3 z-10 text-gray-700 hover:bg-blue-600 hover:text-white transition-all border border-gray-100 hidden md:block">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="news-button-next absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow-xl rounded-full p-2 md:p-3 z-10 text-gray-700 hover:bg-blue-600 hover:text-white transition-all border border-gray-100 hidden md:block">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                @endif
            </div>
        </section>

        {{-- Informasi Publik --}}
        <section id="informasi" class="py-6 md:py-10 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-2 md:mb-4">
                    <h2 class="text-lg md:text-3xl font-bold text-gray-900 mb-1 md:mb-4 px-2">Akses informasi publik sesuai dengan kategori yang ditetapkan</h2>
                    <p class="text-xs md:text-lg text-gray-600 max-w-2xl mx-auto">Kami menyediakan berbagai informasi publik yang dapat diakses oleh masyarakat secara transparan dan mudah</p>
                </div>

                @php
                    $informasiMenu = collect(config('menu'))->firstWhere('title', 'Jenis Informasi');
                    $informasiItems = $informasiMenu['children'] ?? [];
                    $cardData = [
                        'Informasi Berkala' => ['color' => 'blue', 'icon' => 'info-circle', 'points' => ['Profil badan publik dan unit kerja','Profil pejabat dan tentang OPD','Program dan kegiatan yang diumumkan rutin','Ringkasan laporan kinerja dan keuangan','Informasi layanan publik dan jam pelayanan']],
                        'Informasi Tersedia Setiap Saat' => ['color' => 'green', 'icon' => 'clock', 'points' => ['Dokumen administratif dan arsip resmi','SOP, SK, dan kebijakan internal','Dokumen pendukung pelaksanaan kegiatan','Data dan dokumen yang diberikan jika diminta','Arsip dokumen tahun berjalan dan sebelumnya']],
                        'Informasi Serta Merta' => ['color' => 'yellow', 'icon' => 'exclamation-circle', 'points' => ['Informasi bencana alam','Informasi keadaan darurat','Gangguan layanan publik berdampak luas','Ancaman terhadap keselamatan masyarakat','Kebijakan darurat yang harus segera diketahui']],
                        'Informasi Dikecualikan' => ['color' => 'red', 'icon' => 'lock', 'points' => ['Informasi yang mengandung data pribadi','Informasi rahasia negara atau jabatan','Dokumen hukum yang masih berjalan','Informasi yang berpotensi merugikan pihak tertentu','Informasi yang ditetapkan melalui uji konsekuensi']],
                    ];
                @endphp

                <div class="relative px-0 md:px-10">
                    <div class="swiper-pagination info-pagination !relative !top-0 !bottom-auto mb-1 mt-1 md:mt-2"></div>
                    <div class="swiper-container info-carousel relative !py-2 md:!py-4 overflow-hidden">
                        <div class="swiper-wrapper mt-2 md:mt-4">
                            @foreach ($informasiItems as $item)
                                @php $data = $cardData[$item['title']] ?? ['color' => 'gray', 'icon' => 'info-circle', 'points' => []]; @endphp
                                <div class="swiper-slide h-auto p-2">
                                    <div class="h-full w-full">
                                        <div class="bg-white rounded-2xl shadow-lg md:shadow-xl hover:shadow-2xl transition-all duration-300 h-full flex flex-col group border border-gray-200 overflow-hidden min-h-[320px] md:min-h-[400px]">
                                            <div class="h-1.5 md:h-2 bg-gradient-to-r from-{{ $data['color'] }}-500 to-{{ $data['color'] }}-600"></div>
                                            <div class="p-4 md:p-8 flex-grow flex flex-col">
                                                <div class="flex items-center mb-3 md:mb-6">
                                                    <div class="w-8 h-8 md:w-12 md:h-12 rounded-lg bg-{{ $data['color'] }}-500 flex items-center justify-center mr-3 md:mr-4 flex-shrink-0">
                                                        <i class="fas fa-{{ $data['icon'] }} text-white text-base md:text-xl"></i>
                                                    </div>
                                                    <h3 class="text-base md:text-xl font-bold text-gray-800 line-clamp-1">{{ $item['title'] }}</h3>
                                                </div>
                                                <ul class="space-y-1.5 md:space-y-3 text-[11px] md:text-base text-gray-600 flex-grow">
                                                    @foreach ($data['points'] as $point)
                                                        <li class="flex items-start"><i class="fas fa-check-circle text-{{ $data['color'] }}-500 mt-1 mr-2 text-[9px] md:text-sm"></i><span>{{ $point }}</span></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="mt-auto p-4 md:p-6 bg-gray-50">
                                                <a href="{{ url($item['url']) }}" class="w-full py-2 md:py-3 px-4 rounded-lg bg-{{ $data['color'] }}-500 text-white font-semibold text-center block hover:opacity-90 transition-opacity text-xs md:text-base">Akses Informasi <i class="fas fa-arrow-right ml-1.5 text-[10px] md:text-sm"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button class="info-button-prev absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow-xl rounded-full p-2 md:p-3 z-10 text-gray-700 hover:bg-blue-600 hover:text-white transition-all border border-gray-100 hidden md:block">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="info-button-next absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow-xl rounded-full p-2 md:p-3 z-10 text-gray-700 hover:bg-blue-600 hover:text-white transition-all border border-gray-100 hidden md:block">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <div class="mt-6 md:mt-10 text-center">
                    <a href="{{ route('laporan.permohonan.create') }}" class="inline-flex items-center justify-center px-6 py-3 md:px-8 md:py-4 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transition-all text-xs md:text-base">Ajukan Permohonan Informasi</a>
                </div>
            </div>
        </section>

        {{-- Galeri --}}
        <section id="galeri" class="py-6 md:py-10 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-6 md:mb-10">
                    <h2 class="text-xl md:text-3xl font-bold text-gray-900 mb-1 md:mb-2">Galeri</h2>
                    <p class="text-xs md:text-base text-gray-600 max-w-2xl mx-auto">Dokumentasi kegiatan dan momen penting PPID</p>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6">
                    @foreach ($galeri as $item)
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all group">
                            <div class="aspect-w-16 aspect-h-12 overflow-hidden">
                                <img src="{{ asset('storage/' . $item->image) ?: '/placeholder.jpg' }}" alt="{{ $item->title }}" class="w-full h-32 md:h-48 object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy" />
                            </div>
                            <div class="p-3 md:p-5"><h3 class="font-bold text-gray-900 line-clamp-1 text-[10px] md:text-sm">{{ $item->title }}</h3></div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-6 md:mt-10"><a href="{{ route('frontend.galeri.all') }}" class="px-6 py-2.5 md:px-8 md:py-3 border border-gray-300 rounded-xl text-[10px] md:text-sm font-bold bg-white hover:bg-gray-50 text-gray-700 transition-all">Lihat Semua Galeri</a></div>
            </div>
        </section>

        {{-- Statistik --}}
        <section class="py-6 md:py-10 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-xl md:text-3xl font-bold text-gray-900 mb-6 md:mb-10">Statistik PPID</h2>
                <div class="grid grid-cols-3 md:grid-cols-3 gap-2 md:gap-8 mb-6 md:mb-12">
                    <div class="p-3 md:p-8 bg-blue-50 rounded-xl md:rounded-3xl">
                        <i class="fas fa-info-circle text-blue-600 text-lg md:text-4xl mb-1 md:mb-4"></i>
                        <h3 class="text-sm md:text-3xl font-bold text-gray-900 mb-0.5 md:mb-2">{{ number_format($frontendStats['informasi']['total'], 0, ',', '.') }}</h3>
                        <p class="text-[7px] md:text-xs text-gray-600 font-bold uppercase tracking-widest">Info Publik</p>
                    </div>
                    <div class="p-3 md:p-8 bg-green-50 rounded-xl md:rounded-3xl">
                        <i class="fas fa-file-alt text-green-600 text-lg md:text-4xl mb-1 md:mb-4"></i>
                        <h3 class="text-sm md:text-3xl font-bold text-gray-900 mb-0.5 md:mb-2">{{ number_format($frontendStats['permohonan'], 0, ',', '.') }}</h3>
                        <p class="text-[7px] md:text-xs text-gray-600 font-bold uppercase tracking-widest">Permohonan</p>
                    </div>
                    <div class="p-3 md:p-8 bg-purple-50 rounded-xl md:rounded-3xl">
                        <i class="fas fa-poll text-purple-600 text-lg md:text-4xl mb-1 md:mb-4"></i>
                        <h3 class="text-sm md:text-3xl font-bold text-gray-900 mb-0.5 md:mb-2">{{ number_format($frontendStats['survey_responses'], 0, ',', '.') }}</h3>
                        <p class="text-[7px] md:text-xs text-gray-600 font-bold uppercase tracking-widest">Respon Survei</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl md:rounded-3xl p-5 md:p-12 border border-gray-100">
                    <h3 class="text-sm md:text-xl font-bold mb-6 md:mb-10 text-gray-800">Laporan Kinerja Pelayanan</h3>
                    <div class="grid grid-cols-3 md:grid-cols-3 gap-2 md:gap-8">
                        <div>
                            <div class="text-sm md:text-4xl font-black text-blue-600 mb-0.5 md:mb-2">{{ $tingkatKepuasan }}%</div>
                            <p class="text-[7px] md:text-xs font-bold text-gray-500 uppercase tracking-widest">Kepuasan</p>
                        </div>
                        <div>
                            <div class="text-sm md:text-4xl font-black text-green-600 mb-0.5 md:mb-2">{{ $rataRataWaktuRespon }}H</div>
                            <p class="text-[7px] md:text-xs font-bold text-gray-500 uppercase tracking-widest">Respon</p>
                        </div>
                        <div>
                            <div class="text-sm md:text-4xl font-black text-purple-600 mb-0.5 md:mb-2">{{ $tingkatPenyelesaian }}%</div>
                            <p class="text-[7px] md:text-xs font-bold text-gray-500 uppercase tracking-widest">Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Kontak Kami --}}
        <section id="kontak" class="py-6 md:py-10 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-6 md:mb-10">
                    <h2 class="text-xl md:text-3xl font-bold text-gray-900 mb-1 md:mb-2">Kontak Kami</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto text-[10px] md:text-base">Hubungi kami untuk informasi lebih lanjut</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-12">
                    <div>
                        <h3 class="text-base md:text-xl font-bold text-gray-800 mb-4 md:mb-8">Informasi Kontak</h3>
                        <div class="space-y-4 md:space-y-8">
                            <div class="flex items-start space-x-3 md:space-x-5">
                                <div class="w-10 h-10 md:w-14 md:h-14 bg-blue-100 rounded-xl md:rounded-2xl flex items-center justify-center flex-shrink-0 text-blue-600 shadow-sm"><i class="fas fa-map-marker-alt text-lg md:text-2xl"></i></div>
                                <div><h4 class="text-sm md:text-base font-bold text-gray-900">Alamat</h4><p class="text-[10px] md:text-sm text-gray-600 mt-0.5 leading-relaxed">{{ $contactInfo['address'] }}</p></div>
                            </div>
                            <div class="flex items-start space-x-3 md:space-x-5">
                                <div class="w-10 h-10 md:w-14 md:h-14 bg-green-100 rounded-xl md:rounded-2xl flex items-center justify-center flex-shrink-0 text-green-600 shadow-sm"><i class="fas fa-phone-alt text-lg md:text-2xl"></i></div>
                                <div><h4 class="text-sm md:text-base font-bold text-gray-900">Telepon</h4><p class="text-[10px] md:text-sm text-gray-600 mt-0.5">{{ $contactInfo['phone'] }}</p></div>
                            </div>
                            <div class="flex items-start space-x-3 md:space-x-5">
                                <div class="w-10 h-10 md:w-14 md:h-14 bg-purple-100 rounded-xl md:rounded-2xl flex items-center justify-center flex-shrink-0 text-purple-600 shadow-sm"><i class="fas fa-envelope text-lg md:text-2xl"></i></div>
                                <div><h4 class="text-sm md:text-base font-bold text-gray-900">Email</h4><p class="text-[10px] md:text-sm text-gray-600 mt-0.5">{{ $contactInfo['email'] }}</p></div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-xl p-6 md:p-10 border border-gray-50 relative overflow-hidden">
                        <h3 class="text-lg md:text-2xl font-bold text-gray-800 mb-4 md:mb-8 relative z-10">Kirim Pesan</h3>
                        <form id="contactForm" class="space-y-4 md:space-y-5 relative z-10">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
                                <div>
                                    <label class="block text-[10px] md:text-xs font-bold text-gray-700 uppercase tracking-widest mb-1.5 ml-1">Nama Lengkap</label>
                                    <input type="text" name="name" required class="w-full px-4 py-3 md:px-5 md:py-4 rounded-xl md:rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-xs md:text-sm" placeholder="Nama Anda" />
                                </div>
                                <div>
                                    <label class="block text-[10px] md:text-xs font-bold text-gray-700 uppercase tracking-widest mb-1.5 ml-1">Email</label>
                                    <input type="email" name="email" required class="w-full px-4 py-3 md:px-5 md:py-4 rounded-xl md:rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-xs md:text-sm" placeholder="email@contoh.com" />
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] md:text-xs font-bold text-gray-700 uppercase tracking-widest mb-1.5 ml-1">Subjek</label>
                                <input type="text" name="subject" required class="w-full px-4 py-3 md:px-5 md:py-4 rounded-xl md:rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-xs md:text-sm" placeholder="Apa yang ingin ditanyakan?" />
                            </div>
                            <div>
                                <label class="block text-[10px] md:text-xs font-bold text-gray-700 uppercase tracking-widest mb-1.5 ml-1">Pesan</label>
                                <textarea name="message" rows="4" required class="w-full px-4 py-3 md:px-5 md:py-4 rounded-xl md:rounded-2xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-xs md:text-sm resize-none" placeholder="Tulis pesan Anda di sini..."></textarea>
                            </div>
                            <button type="submit" id="submitBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 md:py-5 rounded-xl md:rounded-2xl shadow-xl shadow-blue-200 transition-all flex items-center justify-center gap-2 md:gap-3 group text-xs md:text-base">
                                <i class="fas fa-paper-plane group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i> <span id="submitText">Kirim Pesan Sekarang</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
@endsection

@push('scripts')
    <script>
        function initHomePlugins() {
            if (window.lucide) { window.lucide.createIcons(); }
            new Swiper('.latest-info-carousel', { slidesPerView: 1, spaceBetween: 15, loop: true, autoplay: { delay: 4000, disableOnInteraction: false }, navigation: { nextEl: '.latest-info-next', prevEl: '.latest-info-prev' }, pagination: { el: '.latest-info-pagination', clickable: true }, breakpoints: { 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 }, 1280: { slidesPerView: 4 } } });
            new Swiper('.news-carousel', { slidesPerView: 1, spaceBetween: 15, loop: true, autoplay: { delay: 5000, disableOnInteraction: false }, pagination: { el: '.news-pagination', clickable: true }, navigation: { nextEl: '.news-button-next', prevEl: '.news-button-prev' }, breakpoints: { 640: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 1024: { slidesPerView: 4 } } });
            new Swiper('.info-carousel', { slidesPerView: 1, spaceBetween: 15, loop: false, autoHeight: true, pagination: { el: '.info-pagination', clickable: true }, navigation: { nextEl: '.info-button-next', prevEl: '.info-button-prev' }, breakpoints: { 640: { slidesPerView: 1 }, 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } } });
            const contactForm = document.getElementById('contactForm');
            if (contactForm && !contactForm.dataset.initialized) {
                contactForm.dataset.initialized = "true";
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=ppidkabsinjai@gmail.com&su=${encodeURIComponent(formData.get('subject'))}&body=${encodeURIComponent('Nama: '+formData.get('name')+'\nEmail: '+formData.get('email')+'\n\nPesan: '+formData.get('message'))}`;
                    window.open(gmailUrl, '_blank');
                    this.reset();
                });
            }
        }
        document.addEventListener('DOMContentLoaded', initHomePlugins);
        document.addEventListener('turbo:load', initHomePlugins);
    </script>
@endpush
