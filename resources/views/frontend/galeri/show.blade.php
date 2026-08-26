@extends('frontend.layouts.app')

@section('title', $galeri->title)

@section('meta')
    <meta property="og:title" content="{{ $galeri->title }} - Galeri PPID Kabupaten Sinjai">
    <meta property="og:description" content="{{ $galeri->description ?: 'Lihat foto galeri PPID Kabupaten Sinjai.' }}">
    <meta property="og:image" content="{{ asset('storage/' . $galeri->image) }}">
    <meta name="twitter:title" content="{{ $galeri->title }} - Galeri PPID Kabupaten Sinjai">
    <meta name="twitter:description" content="{{ $galeri->description ?: 'Lihat foto galeri PPID Kabupaten Sinjai.' }}">
    <meta name="twitter:image" content="{{ asset('storage/' . $galeri->image) }}">
@endsection

@section('content')
<div class="py-8 md:py-12 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <div class="mb-8">
            <x-breadcrumbs :breadcrumbs="$breadcrumbs" />
        </div>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Image Section -->
            <div class="p-4 md:p-8 bg-gray-100 flex justify-center items-center min-h-[300px]">
                @if($galeri->type === 'foto')
                    <img src="{{ asset('storage/' . $galeri->image) }}" alt="{{ $galeri->title }}" class="max-w-full h-auto rounded-xl shadow-lg">
                @else
                    {{-- Handle Video Case if needed, but the user specifically asked for foto --}}
                    @php
                        $videoId = null;
                        $url = parse_url($galeri->video ?? '');
                        if (isset($url['host']) && (strpos($url['host'], 'youtube.com') !== false || strpos($url['host'], 'youtu.be') !== false)) {
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
                    @if($videoId)
                        <div class="w-full aspect-video">
                            <iframe class="w-full h-full rounded-xl" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    @else
                         <a href="{{ $galeri->video }}" target="_blank" class="flex flex-col items-center gap-4 text-blue-600 font-bold">
                            <i class="fas fa-video text-6xl"></i>
                            Tonton Video
                         </a>
                    @endif
                @endif
            </div>

            <!-- Content Section -->
            <div class="p-8 md:p-12">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div>
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-bold rounded-full uppercase tracking-wider mb-2">
                            {{ $galeri->category ?: 'Galeri' }}
                        </span>
                        <h1 class="text-2xl md:text-4xl font-black text-gray-900 leading-tight">{{ $galeri->title }}</h1>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-400 font-bold uppercase tracking-widest">
                            <i class="far fa-calendar-alt mr-1"></i> {{ $galeri->created_at->translatedFormat('d F Y') }}
                        </p>
                    </div>
                </div>

                @if($galeri->description)
                    <div class="prose prose-blue max-w-none text-gray-600 leading-relaxed text-lg">
                        {!! nl2br(e($galeri->description)) !!}
                    </div>
                @endif

                <!-- Sharing Section -->
                <div class="mt-12 pt-8 border-t border-gray-100">
                    <h3 class="text-sm font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Bagikan Foto Ini</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="https://api.whatsapp.com/send?text={{ rawurlencode($galeri->title . ' - ' . url()->current()) }}" target="_blank" class="flex items-center gap-2 bg-green-500 text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-green-600 transition-colors shadow-lg shadow-green-100">
                            <i class="fab fa-whatsapp text-lg"></i> WhatsApp
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-blue-700 transition-colors shadow-lg shadow-blue-100">
                            <i class="fab fa-facebook text-lg"></i> Facebook
                        </a>
                        <button onclick="navigator.clipboard.writeText('{{ url()->current() }}').then(() => alert('Link berhasil disalin!'))" class="flex items-center gap-2 bg-gray-800 text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-gray-900 transition-colors shadow-lg shadow-gray-100">
                            <i class="fas fa-link text-lg"></i> Salin Link
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('frontend.galeri.all') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-blue-600 font-black text-xs uppercase tracking-widest transition-colors">
                <i class="fas fa-arrow-left"></i> Kembali ke Semua Galeri
            </a>
        </div>
    </div>
</div>
@endsection
