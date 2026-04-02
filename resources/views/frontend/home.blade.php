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
            .news-carousel:not(.swiper-initialized) .swiper-slide { flex: 0 0 calc(50% - 100px) !important; }
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
                    <div class="swiper-slide relative overflow-hidden">
                        <a href="{{ $slider->link ?: ($slider->informasi ? route('frontend.informasi.detail', $slider->informasi->slug) : '#') }}"
                            class="block w-full h-full">
                            <img src="{{ asset('storage/' . $slider->image) ?: '/placeholder.jpg' }}"
                                alt="{{ $slider->title }}" 
                                class="w-full {{ $sliderAspectRatio === 'aspect-auto' ? 'h-auto' : 'h-full' }} object-cover transform scale-100 transition-transform duration-[2000ms] hover:scale-105"
                                data-swiper-parallax="20%" />
                            <div
                                class="absolute inset-0 @if ($slider->show_title || $slider->show_description) bg-black bg-opacity-40 @endif flex items-center justify-center overlay-content">
                                <div class="text-center text-white max-w-4xl mx-auto px-4" data-swiper-parallax="-300">
                                    @if ($slider->show_title)
                                        <h2 class="text-2xl md:text-5xl font-bold mb-2 md:mb-4 drop-shadow-lg" data-swiper-parallax="-100">{{ $slider->title }}</h2>
                                    @endif
                                    @if ($slider->description && $slider->show_description)
                                        <p class="text-base md:text-xl mb-4 md:mb-6 line-clamp-2 md:line-clamp-none opacity-90" data-swiper-parallax="-200">{{ $slider->description }}</p>
                                    @endif
                                    @if ($slider->link)
                                        <span data-swiper-parallax="-300"
                                            class="inline-flex items-center justify-center px-6 py-2 md:px-8 md:py-3 border border-transparent text-sm md:text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 shadow-lg transform transition-transform hover:scale-105">
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
                
                <!-- Pagination Overlay -->
                <div class="swiper-pagination !absolute !bottom-4 !left-0 !right-0 !z-30"></div>
            @endif
        </div>
        <style>
            .hero-slider { padding-bottom: 0 !important; margin-bottom: 0 !important; }
            .hero-slider .swiper-pagination { line-height: 0 !important; pointer-events: none; }
            .hero-slider .swiper-pagination-bullet { pointer-events: auto; background: white !important; opacity: 0.5; width: 8px; height: 8px; margin: 0 4px !important; box-shadow: 0 1px 3px rgba(0,0,0,0.3); }
            .hero-slider .swiper-pagination-bullet-active { background: #2563eb !important; opacity: 1; width: 20px; border-radius: 4px; }
        </style>
    @endif

    <section class="py-10 bg-white">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-4">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Informasi Terbaru</h2>
                <p class="text-gray-600 text-sm md:text-base max-w-2xl mx-auto">Dokumen dan pengumuman publik terkini dari PPID Kabupaten Sinjai.</p>
            </div>

            <div class="relative group">
                <div class="swiper-pagination latest-info-pagination !relative !top-0 !bottom-auto mb-1 mt-1"></div>
                <div class="swiper-container latest-info-carousel loading overflow-hidden px-1">
                    <div class="swiper-wrapper">
                        @foreach ($latestInformasis as $info)
                            @php
                                $unitName = $info->organization->name ?? ($info->user->opd_name ?? 'PPID Kabupaten Sinjai');
                                $uploaderName = $info->user->name ?? 'Administrator';
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
                                                <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Oleh: {{ $uploaderName }}</span>
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
                                        </div>
                                        <a href="{{ route('frontend.informasi.detail', $info->slug) }}" class="flex items-center justify-center w-10 h-10 rounded-2xl bg-{{ $catColor }}-50 text-{{ $catColor }}-600 hover:bg-{{ $catColor }}-600 hover:text-white transition-all duration-300 shadow-sm">
                                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Berita Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
                <div class="max-w-2xl">
                    <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-4 tracking-tight">Warta Terkini</h2>
                    <p class="text-gray-500 text-lg leading-relaxed">Informasi terbaru seputar kegiatan dan perkembangan PPID Kabupaten Sinjai.</p>
                </div>
                <div class="flex gap-2 mb-2">
                    <div class="swiper-pagination news-pagination !static !w-auto"></div>
                </div>
            </div>

            <div class="swiper-container news-carousel overflow-hidden">
                <div class="swiper-wrapper">
                    @foreach ($berita as $item)
                        <div class="swiper-slide h-auto">
                            <article class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 h-full flex flex-col group border border-white">
                                <div class="relative aspect-[16/10] overflow-hidden">
                                    <img src="{{ $item['image'] ?: '/placeholder.jpg' }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    <div class="absolute top-6 left-6">
                                        <span class="px-5 py-2.5 bg-blue-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl shadow-xl backdrop-blur-md bg-opacity-90">Berita</span>
                                    </div>
                                </div>
                                <div class="p-8 flex flex-col flex-grow">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div>
                                        <time class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ \Carbon\Carbon::parse($item['pubDate'])->locale('id')->isoFormat('D MMMM Y') }}</time>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-6 line-clamp-2 leading-tight group-hover:text-blue-600 transition-colors">{{ $item['title'] }}</h3>
                                    <div class="mt-auto flex items-center justify-between pt-6 border-t border-gray-50">
                                        <a href="{{ $item['link'] }}" target="_blank" class="text-sm font-black text-blue-600 uppercase tracking-widest hover:text-blue-800 transition-colors flex items-center gap-2">Baca Selengkapnya <i data-lucide="chevron-right" class="w-4 h-4"></i></a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Stat & Contact sections would go here - restoring standard structure -->
    @include('frontend.sections.stats')
    @include('frontend.sections.contact')

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. HERO SLIDER
            const heroSwiper = new Swiper('.hero-slider', {
                loop: true,
                effect: '{{ $sliderAnimationType }}',
                autoHeight: {{ $sliderAspectRatio === 'aspect-auto' ? 'true' : 'false' }},
                speed: 1200,
                parallax: true,
                grabCursor: true,
                watchSlidesProgress: true,
                autoplay: {
                    delay: {{ $transitionDuration }},
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true
                },
                pagination: {
                    el: '.hero-slider .swiper-pagination',
                    clickable: true,
                    dynamicBullets: true
                },
                navigation: {
                    nextEl: '.swiper-button-next-custom',
                    prevEl: '.swiper-button-prev-custom'
                },
                @if($sliderAnimationType === 'fade')
                fadeEffect: { crossFade: true },
                @elseif($sliderAnimationType === 'cube')
                cubeEffect: { shadow: true, slideShadows: true, shadowOffset: 20, shadowScale: 0.94 },
                @elseif($sliderAnimationType === 'flip')
                flipEffect: { rotate: 30, slideShadows: true },
                @elseif($sliderAnimationType === 'coverflow')
                coverflowEffect: { rotate: 35, stretch: 0, depth: 100, modifier: 1, slideShadows: true },
                @endif
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
                                    self.slides.forEach(s => s.style.height = targetHeight + 'px');
                                    self.update();
                                } else if (firstImg) {
                                    firstImg.onload = lockToFirst;
                                }
                            };
                            setTimeout(lockToFirst, 300);
                            window.addEventListener('resize', lockToFirst);
                        }
                    },
                    slideChangeTransitionStart: function() {
                        if (this.params.autoHeight) this.updateAutoHeight(800);
                    }
                }
            });

            // 2. LATEST INFO CAROUSEL
            new Swiper('.latest-info-carousel', {
                slidesPerView: 1,
                spaceBetween: 24,
                loop: true,
                speed: 800,
                grabCursor: true,
                watchSlidesProgress: true,
                autoplay: { delay: 4000, disableOnInteraction: false, pauseOnMouseEnter: true },
                pagination: { el: '.latest-info-pagination', clickable: true, dynamicBullets: true },
                breakpoints: {
                    640: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 },
                    1280: { slidesPerView: 4 }
                }
            });

            // 3. NEWS CAROUSEL
            new Swiper('.news-carousel', {
                slidesPerView: 1,
                spaceBetween: 24,
                loop: true,
                speed: 800,
                grabCursor: true,
                watchSlidesProgress: true,
                autoplay: { delay: 5000, disableOnInteraction: false, pauseOnMouseEnter: true },
                pagination: { el: '.news-pagination', clickable: true, dynamicBullets: true },
                breakpoints: {
                    640: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 },
                    1280: { slidesPerView: 4 }
                }
            });
        });
    </script>
@endpush
