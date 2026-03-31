<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: transparent; }
        .info-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .info-card:hover { transform: translateY(-2px); }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</head>
<body class="p-3">
    <div class="space-y-4">
        @forelse($informasis as $info)
            @php
                $colors = ['blue', 'green', 'purple', 'orange', 'red'];
                $color = $colors[array_rand($colors)];
            @endphp
            <div class="info-card bg-white p-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md flex items-center space-x-4">
                <div class="w-12 h-12 bg-{{ $color }}-50 text-{{ $color }}-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-file-invoice text-lg"></i>
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
                    <a href="{{ route('frontend.informasi.detail', $info->slug) }}" target="_blank" class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                <i class="fas fa-info-circle text-gray-300 text-3xl mb-3"></i>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Bel_um ada informasi tersedia</p>
            </div>
        @endforelse
    </div>
    
    <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
        <div class="flex items-center">
            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse mr-2"></div>
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Live Updates</span>
        </div>
        <a href="{{ url('/') }}" target="_blank" class="text-[9px] font-black text-blue-600/40 uppercase tracking-widest hover:text-blue-600 transition-colors">
            PPID KABUPATEN SINJAI
        </a>
    </div>
</body>
</html>
