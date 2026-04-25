<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @if(($mode ?? 'static') === 'slider')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    @endif

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: transparent; overflow-x: hidden; }
        .info-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); height: 100%; }
        .info-card:hover { transform: translateY(-4px); }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .swiper-pagination-bullet-active { background: #2563eb !important; }
        .swiper { padding: 10px 10px 40px 10px !important; }
    </style>
</head>
<body class="p-2">
    @if(($display ?? 'list') === 'card')
        @if(($mode ?? 'static') === 'slider')
            {{-- MODE SLIDER (CARD) --}}
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @forelse($informasis as $info)
                        <div class="swiper-slide">
                            @include('frontend.extra.widgets.partials.card-item', ['info' => $info, 'index' => $loop->index])
                        </div>
                    @empty
                        <div class="swiper-slide text-center py-12">Belum ada data</div>
                    @endforelse
                </div>
                <div class="swiper-pagination"></div>
            </div>
        @else
            {{-- MODE GRID STATIC (CARD) --}}
            @php
                $gridCols = [
                    1 => 'grid-cols-1',
                    2 => 'grid-cols-1 sm:grid-cols-2',
                    3 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
                    4 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
                    5 => 'grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5',
                ][$columns ?? 3];
            @endphp
            <div class="grid {{ $gridCols }} gap-4">
                @forelse($informasis as $info)
                    @include('frontend.extra.widgets.partials.card-item', ['info' => $info, 'index' => $loop->index])
                @empty
                    <div class="col-span-full text-center py-12 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                        <i class="fas fa-info-circle text-gray-300 text-3xl mb-3"></i>
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Belum ada informasi tersedia</p>
                    </div>
                @endforelse
            </div>
        @endif
    @else
        {{-- MODE LIST (Default) --}}
        <div class="space-y-3">
            @forelse($informasis as $info)
                @php
                    $colors = ['blue', 'green', 'purple', 'orange', 'red'];
                    $color = $colors[$loop->index % count($colors)];
                @endphp
                <div class="info-card bg-white p-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md flex items-center space-x-4">
                    <div class="w-12 h-12 bg-{{ $color }}-50 text-{{ $color }}-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-inner">
                        <i class="fas fa-file-alt text-lg"></i>
                    </div>
                    <div class="flex-grow min-w-0">
                        <div class="flex items-center space-x-2 mb-1">
                            <span class="text-[9px] font-black uppercase tracking-widest text-{{ $color }}-600 bg-{{ $color }}-50 px-2 py-0.5 rounded-md">
                                {{ $info->category }}
                            </span>
                        </div>
                        <a href="{{ route('frontend.informasi.detail', $info->slug) }}" target="_blank" class="text-sm font-bold text-gray-800 hover:text-blue-600 block truncate leading-tight">
                            {{ $info->title }}
                        </a>
                        <div class="flex items-center text-[10px] text-gray-400 mt-1.5 space-x-3">
                            <span class="flex items-center"><i class="far fa-calendar-alt mr-1.5"></i> {{ \Carbon\Carbon::parse($info->tanggal_upload)->isoFormat('D MMM Y') }}</span>
                            <span class="flex items-center"><i class="far fa-eye mr-1.5"></i> {{ number_format($info->views_count ?? 0) }}</span>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('frontend.informasi.detail', $info->slug) }}" target="_blank" class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                    <i class="fas fa-info-circle text-gray-300 text-3xl mb-3"></i>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Belum ada informasi tersedia</p>
                </div>
            @endforelse
        </div>
    @endif
    
    <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
        <div class="flex items-center">
            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse mr-2"></div>
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Live Updates</span>
        </div>
        <a href="{{ url('/') }}" target="_blank" class="text-[9px] font-black text-blue-600/40 uppercase tracking-widest hover:text-blue-600 transition-colors">
            PPID KABUPATEN SINJAI
        </a>
    </div>

    @if(($mode ?? 'static') === 'slider')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var swiper = new Swiper(".mySwiper", {
                slidesPerView: 1,
                spaceBetween: 20,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                breakpoints: {
                    640: { slidesPerView: 2 },
                    1024: { slidesPerView: {{ $columns ?? 3 }} },
                },
                @if($autoplay)
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                @endif
            });
        });
    </script>
    @endif
</body>
</html>
