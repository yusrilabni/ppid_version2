@extends('frontend.layouts.app')

@section('title', $subStandarLayanan->title)

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-7xl mx-auto">
        
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => $subStandarLayanan->standarLayanan->title ?? 'Kategori', 'url' => route('frontend.standar-layanan.showBySlug', Str::slug($subStandarLayanan->standarLayanan->title ?? '')), 'icon' => $categoryIcon],
            ['title' => $subStandarLayanan->title, 'url' => '#', 'icon' => 'fas fa-file-alt']
        ]" />

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 md:p-8">
                <!-- Header -->
                <div class="mb-8">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                        <div class="flex-1">
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 leading-tight">
                                {{ $subStandarLayanan->title }}
                            </h1>
                            
                            {{-- Original Desktop Badges --}}
                            <div class="hidden md:flex flex-wrap items-center space-x-4 mt-4 text-sm text-gray-500">
                                <span class="inline-flex items-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-medium">
                                    <i class="fas fa-folder-open mr-2 text-blue-600"></i>
                                    {{ $subStandarLayanan->standarLayanan->title ?? 'Tidak Diketahui' }}
                                </span>
                                <span class="inline-flex items-center bg-gray-100 text-gray-800 px-3 py-1 rounded-full font-medium">
                                    <i class="fas fa-calendar-alt mr-2 text-gray-600"></i>
                                    Tahun {{ $subStandarLayanan->tahun_dokumen }}
                                </span>
                                <span class="inline-flex items-center bg-purple-100 text-purple-800 px-3 py-1 rounded-full font-medium">
                                    <i class="fas fa-eye mr-2 text-purple-600"></i>
                                    Dilihat: {{ number_format($subStandarLayanan->views_count, 0, ',', '.') }}
                                </span>
                                <span class="inline-flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full font-medium">
                                    <i class="fas fa-download mr-2 text-green-600"></i>
                                    Diunduh: {{ number_format($subStandarLayanan->download_count, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Mobile Grid Cards --}}
                    <div class="grid grid-cols-3 md:hidden gap-2 mt-6">
                        <div class="flex flex-col items-center bg-gray-50 border border-gray-100 p-2 rounded-lg text-center">
                            <i class="fas fa-calendar-alt text-blue-500 mb-1 text-xs"></i>
                            <div class="flex flex-col">
                                <span class="text-[8px] uppercase text-gray-400 font-bold leading-none">Tahun</span>
                                <span class="text-[10px] font-bold text-gray-700 leading-tight">
                                    {{ \Carbon\Carbon::parse($subStandarLayanan->tahun_dokumen)->format('Y') == $subStandarLayanan->tahun_dokumen ? $subStandarLayanan->tahun_dokumen : \Carbon\Carbon::parse($subStandarLayanan->tahun_dokumen)->format('d/m/y') }}
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col items-center bg-gray-50 border border-gray-100 p-2 rounded-lg text-center">
                            <i class="fas fa-eye text-purple-500 mb-1 text-xs"></i>
                            <div class="flex flex-col">
                                <span class="text-[8px] uppercase text-gray-400 font-bold leading-none">Lihat</span>
                                <span class="text-[10px] font-bold text-gray-700 leading-tight">{{ number_format($subStandarLayanan->views_count, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-center bg-gray-50 border border-gray-100 p-2 rounded-lg text-center">
                            <i class="fas fa-download text-green-500 mb-1 text-xs"></i>
                            <div class="flex flex-col">
                                <span class="text-[8px] uppercase text-gray-400 font-bold leading-none">Unduh</span>
                                <span class="text-[10px] font-bold text-gray-700 leading-tight">{{ number_format($subStandarLayanan->download_count, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $fileUrl = $subStandarLayanan->file_type === 'url' ? $subStandarLayanan->url : ($subStandarLayanan->file ? asset('storage/' . $subStandarLayanan->file) : null);
                    $fileExtension = $subStandarLayanan->file ? pathinfo($subStandarLayanan->file, PATHINFO_EXTENSION) : null;
                    $isPdf = $fileUrl && $fileExtension === 'pdf';
                    $isImage = $fileUrl && in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                @endphp

                <!-- File Preview / Download Block -->
                <div class="mt-6">
                    @if($fileUrl)
                        {{-- PDF Preview --}}
                        @if($isPdf)
                            <div class="border rounded-lg overflow-hidden">
                                <iframe src="{{ $fileUrl }}" width="100%" height="600px" frameborder="0">
                                    <p>Browser Anda tidak mendukung pratinjau PDF. Anda bisa <a href="{{ $fileUrl }}">mengunduhnya di sini</a>.</p>
                                </iframe>
                            </div>
                            <div class="mt-4 text-center">
                                <a href="{{ route('frontend.standar-layanan.download', $subStandarLayanan) }}" target="_blank" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition">
                                    <i class="fas fa-download mr-2"></i> Unduh PDF
                                </a>
                            </div>
                        {{-- Image Preview --}}
                        @elseif($isImage)
                            <div class="border rounded-lg p-4 flex justify-center bg-gray-50">
                                <img src="{{ $fileUrl }}" alt="{{ $subStandarLayanan->title }}" class="max-w-full h-auto rounded-md shadow-md">
                            </div>
                            <div class="mt-4 text-center">
                                <a href="{{ route('frontend.standar-layanan.download', $subStandarLayanan) }}" target="_blank" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition">
                                    <i class="fas fa-download mr-2"></i> Unduh Gambar
                                </a>
                            </div>
                        {{-- URL or Other File Types --}}
                        @else
                            <div class="p-6 bg-gray-50 border rounded-lg flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                                <div class="flex items-center">
                                    <i class="fas {{ $subStandarLayanan->file_type === 'url' ? 'fa-link' : 'fa-file-alt' }} text-gray-500 text-3xl mr-4"></i>
                                    <div>
                                        <p class="font-semibold text-gray-800">File tersedia untuk diakses.</p>
                                        <p class="text-sm text-gray-600">{{ $subStandarLayanan->file_type === 'url' ? 'Tautan eksternal' : 'File untuk diunduh' }}</p>
                                    </div>
                                </div>
                                <a href="{{ $subStandarLayanan->file_type === 'url' ? route('frontend.standar-layanan.visit-url', $subStandarLayanan) : route('frontend.standar-layanan.download', $subStandarLayanan) }}"
                                   target="_blank"
                                   class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition whitespace-nowrap">
                                    <i class="fas {{ $subStandarLayanan->file_type === 'url' ? 'fa-external-link-alt' : 'fa-download' }} mr-2"></i>
                                    {{ $subStandarLayanan->file_type === 'url' ? 'Kunjungi Tautan' : 'Unduh File' }}
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="p-6 bg-red-50 border border-red-200 rounded-lg text-center">
                            <i class="fas fa-exclamation-triangle text-red-500 text-3xl mb-2"></i>
                            <p class="font-semibold text-red-800">File atau tautan tidak tersedia.</p>
                        </div>
                    @endif
                </div>
                
                <!-- Back Button -->
                <div class="mt-8 text-right border-t pt-4">
                    <a href="{{ url()->previous() }}" class="text-gray-600 hover:text-gray-800 hover:underline">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
