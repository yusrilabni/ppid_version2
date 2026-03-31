<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: transparent; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</head>
<body class="p-2">
    <div class="space-y-3">
        @forelse($informasis as $info)
            <div class="bg-white p-3 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex items-start space-x-3">
                <div class="bg-blue-50 text-blue-600 p-2 rounded-md flex-shrink-0">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="flex-grow min-w-0">
                    <a href="{{ route('frontend.informasi.detail', $info->slug) }}" target="_blank" class="text-sm font-bold text-gray-800 hover:text-blue-600 block truncate">
                        {{ $info->title }}
                    </a>
                    <div class="flex items-center text-[10px] text-gray-500 mt-1 space-x-2">
                        <span><i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($info->tanggal_upload)->format('d/m/Y') }}</span>
                        <span><i class="far fa-eye mr-1"></i> {{ $info->views_count ?? 0 }}</span>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 text-xs py-4">Belum ada informasi tersedia.</p>
        @endforelse
    </div>
    
    <div class="mt-4 text-center">
        <a href="{{ url('/') }}" target="_blank" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:text-blue-600">
            Powered by PPID Kabupaten Sinjai
        </a>
    </div>
</body>
</html>
