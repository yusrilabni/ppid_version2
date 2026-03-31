@extends('frontend.layouts.app')

@section('content')
        {{-- Hero Slider --}}
        @if ($sliders->count() > 0)
            <div x-data="{ currentSlide: 0, sliders: @js($sliders), transitionDuration: {{ $transitionDuration }} }" x-init="setInterval(() => { currentSlide = (currentSlide + 1) % sliders.length }, transitionDuration)"
                class="relative w-full overflow-hidden slider-container acc-ignore-links">
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
                    <button @click="currentSlide = (currentSlide - 1 + sliders.length) % sliders.length"
                        class="absolute left-2 md:left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-60 hover:bg-opacity-80 text-white p-2 md:p-3 rounded-full z-20 border-2 border-white border-opacity-50 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-arrow-left w-4 h-4 md:w-5 md:h-5">
                            <path d="m12 19-7-7 7-7" />
                            <path d="M19 12H5" />
                        </svg>
                    </button>
                    <button @click="currentSlide = (currentSlide + 1) % sliders.length"
                        class="absolute right-2 md:right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-60 hover:bg-opacity-80 text-white p-2 md:p-3 rounded-full z-20 border-2 border-white border-opacity-50 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4 md:w-5 md:h-5">
                            <path d="M5 12h14" />
                            <path d="m12 5 7 7-7 7" />
                        </svg>
                    </button>
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 z-20">
                        @foreach ($sliders as $index => $slider)
                            <button @click="currentSlide = {{ $index }}"
                                :class="{
                                    'bg-white border-2 border-white': currentSlide ===
                                        {{ $index }},
                                    'bg-white bg-opacity-50 border border-white': currentSlide !==
                                        {{ $index }}
                                }"
                                class="w-3 h-3 rounded-full transition-all duration-300"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        {{-- Informasi Terbaru Section --}}
        <section class="py-10 bg-white">
            <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Informasi Terbaru</h2>
                    <p class="text-gray-600 text-sm md:text-base max-w-2xl mx-auto">Dokumen dan pengumuman publik terkini dari PPID Kabupaten Sinjai.</p>
                </div>

                <div class="relative group">
                    <div class="swiper-container latest-info-carousel overflow-hidden px-1">
                        <div class="swiper-wrapper">
                            @foreach ($latestInformasis as $info)
                                @php
                                    $unitName = $info->organization->name ?? ($info->user->opd_name ?? 'PPID Kabupaten Sinjai');
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
                                        <div class="absolute -right-6 -top-6 text-{{ $catColor }}-50 group-hover/card:scale-110 transition-transform duration-700 opacity-50 pointer-events-none">
                                            <i data-lucide="file-text" class="w-32 h-32"></i>
                                        </div>
                                        <div class="mb-5 relative z-10">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="w-9 h-9 rounded-xl bg-{{ $catColor }}-50 flex items-center justify-center text-{{ $catColor }}-600 border border-{{ $catColor }}-100/50">
                                                    <i data-lucide="building-2" class="w-4 h-4"></i>
                                                </div>
                                                <div class="flex flex-col min-w-0">
                                                    <span class="text-[11px] font-extrabold text-gray-800 uppercase tracking-tight line-clamp-1">{{ $unitName }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="text-gray-900 font-bold text-lg mb-6 line-clamp-2 leading-tight group-hover/card:text-{{ $catColor }}-600 transition-colors relative z-10">
                                            {{ $info->title }}
                                        </h3>
                                        <div class="mt-auto pt-5 border-t border-gray-50 flex items-end justify-between relative z-10">
                                            <div class="flex flex-col gap-2">
                                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest flex items-center">
                                                    <i data-lucide="calendar" class="w-3 h-3 mr-1.5 text-blue-500"></i>
                                                    {{ \Carbon\Carbon::parse($info->tanggal_upload)->locale('id')->isoFormat('D MMMM Y') }}
                                                </span>
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
                    <button class="latest-info-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 bg-white shadow-xl rounded-full p-3 z-10 text-gray-700 hover:bg-blue-600 hover:text-white transition-all border border-gray-100">
                        <i data-lucide="chevron-left" class="h-6 w-6"></i>
                    </button>
                    <button class="latest-info-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 bg-white shadow-xl rounded-full p-3 z-10 text-gray-700 hover:bg-blue-600 hover:text-white transition-all border border-gray-100">
                        <i data-lucide="chevron-right" class="h-6 w-6"></i>
                    </button>
                </div>
            </div>
        </section>

        <section class="py-10 bg-gray-50">
            <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Berita Terbaru</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto text-sm md:text-base">Dapatkan informasi terkini seputar kegiatan dan pengumuman dari Humas Sinjai.</p>
                </div>
                @if (!empty($rss_items))
                    <div class="relative px-1">
                        <div class="swiper-container news-carousel relative overflow-hidden">
                            <div class="swiper-pagination !relative !top-0 !bottom-auto mb-6"></div>
                            <div class="swiper-wrapper">
                                @foreach ($rss_items as $item)
                                    <div class="swiper-slide h-auto">
                                        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 h-full flex flex-col border border-gray-100">
                                            <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                                                <img src="{{ $item['image'] ?: 'https://via.placeholder.com/400x225.png?text=No+Image' }}"
                                                    alt="{{ $item['title'] }}" class="w-full h-48 object-cover transform hover:scale-105 transition-transform duration-500" loading="lazy" />
                                            </div>
                                            <div class="p-5 flex flex-col flex-grow">
                                                <div class="flex items-center text-xs text-gray-500 mb-3">
                                                    <i data-lucide="calendar" class="h-3.5 w-3.5 mr-1.5 text-blue-500"></i>
                                                    {{ \Carbon\Carbon::parse($item['pubDate'])->locale('id')->isoFormat('D MMMM Y') }}
                                                </div>
                                                <h3 class="text-base font-bold text-gray-900 mb-2 line-clamp-2 leading-snug">
                                                    {{ html_entity_decode(strip_tags($item['title'])) }}
                                                </h3>
                                                <p class="text-xs text-gray-600 line-clamp-3 mb-4 flex-grow">{{ html_entity_decode(strip_tags($item['description'])) }}</p>
                                                <div class="mt-auto">
                                                    <a href="{{ $item['link'] }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2.5 border border-blue-100 text-sm font-semibold rounded-lg text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white transition-all duration-300 w-full group">Baca Selengkapnya <i data-lucide="external-link" class="ml-2 h-3.5 w-3.5"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section class="py-10 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h2 class="text-xl md:text-3xl font-bold text-gray-900 mb-2 md:mb-4">Akses informasi publik sesuai dengan kategori yang ditetapkan</h2>
                    <p class="text-sm md:text-lg text-gray-600 max-w-2xl mx-auto">Kami menyediakan berbagai informasi publik yang dapat diakses oleh masyarakat secara transparan dan mudah</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                        $informasiMenu = collect(config('menu'))->firstWhere('title', 'Jenis Informasi');
                        $informasiItems = $informasiMenu['children'] ?? [];
                        $cardData = [
                            'Informasi Berkala' => ['color' => 'blue', 'icon' => 'info-circle', 'points' => ['Profil badan publik','Profil pejabat','Ringkasan laporan']],
                            'Informasi Tersedia Setiap Saat' => ['color' => 'green', 'icon' => 'clock', 'points' => ['Dokumen administratif','SOP, SK','Arsip dokumen']],
                            'Informasi Serta Merta' => ['color' => 'yellow', 'icon' => 'exclamation-circle', 'points' => ['Bencana alam','Darurat','Gangguan luas']],
                            'Informasi Dikecualikan' => ['color' => 'red', 'icon' => 'lock', 'points' => ['Data pribadi','Rahasia negara','Uji konsekuensi']],
                        ];
                    @endphp
                    @foreach ($informasiItems as $item)
                        @php $data = $cardData[$item['title']] ?? ['color' => 'gray', 'icon' => 'info-circle', 'points' => []]; @endphp
                        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all p-6 border border-gray-100 flex flex-col">
                            <div class="w-12 h-12 rounded-xl bg-{{ $data['color'] }}-500 flex items-center justify-center mb-4">
                                <i class="fas fa-{{ $data['icon'] }} text-white text-xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4">{{ $item['title'] }}</h3>
                            <ul class="space-y-2 text-sm text-gray-600 mb-6 flex-grow">
                                @foreach ($data['points'] as $point)
                                    <li class="flex items-start"><i class="fas fa-check-circle text-{{ $data['color'] }}-500 mt-1 mr-2"></i>{{ $point }}</li>
                                @endforeach
                            </ul>
                            <a href="{{ url($item['url']) }}" class="w-full py-2 bg-{{ $data['color'] }}-500 text-white rounded-lg text-center font-bold text-sm">Akses Informasi</a>
                        </div>
                    @endforeach
                </div>
                <div class="mt-10 text-center">
                    <a href="{{ route('laporan.permohonan.create') }}" class="inline-flex items-center justify-center px-8 py-3 bg-blue-600 text-white font-bold rounded-lg shadow-lg hover:bg-blue-700 transition-all">Ajukan Permohonan Informasi</a>
                </div>
            </div>
        </section>

        <section class="py-10 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10"><h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Galeri</h2><p class="text-gray-600 max-w-2xl mx-auto">Dokumentasi kegiatan dan momen penting PPID</p></div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($galeri as $item)
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all group">
                            <img src="{{ asset('storage/' . $item->image) ?: '/placeholder.jpg' }}" alt="{{ $item->title }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy" />
                            <div class="p-4"><h3 class="font-bold text-gray-900 line-clamp-1 text-sm">{{ $item->title }}</h3></div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-10"><a href="{{ route('frontend.galeri.all') }}" class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium bg-white hover:bg-gray-50 text-gray-700 transition-all">Lihat Semua Galeri</a></div>
            </div>
        </section>

        <section class="py-10 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-10">Statistik PPID</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-8 bg-blue-50 rounded-2xl">
                        <i class="fas fa-info-circle text-blue-600 text-4xl mb-4"></i>
                        <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($frontendStats['informasi']['total'], 0, ',', '.') }}</h3>
                        <p class="text-gray-600 font-bold uppercase tracking-widest text-xs">Informasi Publik</p>
                    </div>
                    <div class="p-8 bg-green-50 rounded-2xl">
                        <i class="fas fa-file-alt text-green-600 text-4xl mb-4"></i>
                        <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($frontendStats['permohonan'], 0, ',', '.') }}</h3>
                        <p class="text-gray-600 font-bold uppercase tracking-widest text-xs">Permohonan</p>
                    </div>
                    <div class="p-8 bg-purple-50 rounded-2xl">
                        <i class="fas fa-poll text-purple-600 text-4xl mb-4"></i>
                        <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($frontendStats['survey_responses'], 0, ',', '.') }}</h3>
                        <p class="text-gray-600 font-bold uppercase tracking-widest text-xs">Respon Survei</p>
                    </div>
                </div>
            </div>
        </section>
@endsection

@push('scripts')
    <script>
        function initHomePlugins() {
            if (window.lucide) { window.lucide.createIcons(); }
            new Swiper('.latest-info-carousel', { slidesPerView: 1, spaceBetween: 20, loop: true, autoplay: { delay: 4000 }, navigation: { nextEl: '.latest-info-next', prevEl: '.latest-info-prev' }, breakpoints: { 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 }, 1280: { slidesPerView: 4 } } });
            new Swiper('.news-carousel', { slidesPerView: 1, spaceBetween: 20, loop: true, autoplay: { delay: 5000 }, breakpoints: { 640: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 1024: { slidesPerView: 4 } } });
        }
        document.addEventListener('DOMContentLoaded', initHomePlugins);
    </script>
@endpush
