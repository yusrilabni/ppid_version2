@extends('frontend.layouts.app')

@section('title', 'Semua Galeri')

@section('content')
    <div class="container mx-auto py-12 px-4">
        <div class="max-w-7xl mx-auto">
        <x-breadcrumbs :breadcrumbs="$breadcrumbs" />



        @if ($galeri->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($galeri as $item)
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out overflow-hidden flex flex-col h-full">
                        <div class="aspect-w-16 aspect-h-12 relative">
                            @if($item->is_pinned)
                                <div class="absolute top-2 left-2 bg-orange-500 text-white rounded-full p-2 z-10 shadow-md" title="Foto di-pin">
                                    <i class="fas fa-thumbtack text-xs"></i>
                                </div>
                            @endif
                            @if ($item->type === 'foto')
                                <a href="{{ route('frontend.galeri.show', $item->id) }}" class="block">
                                    <img src="{{ asset('storage/' . $item->image) ?: '/placeholder.jpg' }}"
                                        alt="{{ $item->title }}"
                                        class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300" />
                                    <div class="absolute top-2 right-2 bg-white bg-opacity-90 rounded-full p-2">
                                        <i data-lucide="camera" class="h-4 w-4 text-gray-700"></i>
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
                                    <a href="{{ route('frontend.galeri.show', $item->id) }}" class="block">
                                        <img src="https://img.youtube.com/vi/{{ $videoId }}/default.jpg"
                                            alt="{{ $item->title }}"
                                            class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300" />
                                        <div
                                            class="absolute top-2 right-2 bg-white bg-opacity-90 rounded-full p-2">
                                            <i data-lucide="play-circle" class="h-4 w-4 text-gray-700"></i>
                                        </div>
                                    </a>
                                @else
                                    <a href="{{ route('frontend.galeri.show', $item->id) }}" class="block">
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                            <i data-lucide="video" class="h-12 w-12 text-gray-400"></i>
                                            <div
                                                class="absolute top-2 right-2 bg-white bg-opacity-90 rounded-full p-2">
                                                <i data-lucide="video" class="h-4 w-4 text-gray-700"></i>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-1 line-clamp-1">
                                {{ $item->title }}
                            </h3>
                            @if ($item->category)
                                <span
                                    class="inline-block px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full mb-2">
                                    {{ $item->category }}
                                </span>
                            @endif
                            @if ($item->description)
                                <p class="text-sm text-gray-600 line-clamp-2">
                                    {{ $item->description }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12 flex justify-center">
                {{ $galeri->links('vendor.pagination.tailwind') }}
            </div>
        @else
            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12">
                <div class="flex flex-col items-center">
                    <i class="fas fa-image text-gray-400 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data galeri</h3>
                    <p class="text-gray-500">Belum ada galeri yang ditambahkan.</p>
                </div>
            </div>
        @endif
    </div>
        </div>
    </div>
@endsection
