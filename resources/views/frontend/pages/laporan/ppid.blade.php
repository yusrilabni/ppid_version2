@extends('frontend.layouts.app')

@section('title', 'Laporan Tahunan PPID')

@section('content')
<div class="py-8 md:py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => 'Laporan PPID', 'url' => '#', 'icon' => 'fas fa-file-invoice']
        ]" />

        <div class="mb-16 text-center mt-8">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-6 tracking-tight">
                <i class="fas fa-file-invoice text-blue-600 mr-2"></i>
                Laporan Tahunan PPID
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Daftar laporan tahunan pelayanan informasi publik Dinas Komunikasi Informatika dan Persandian Kabupaten Sinjai.
            </p>
        </div>

        @if($laporans->isNotEmpty())
            <!-- All Reports Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($laporans as $laporan)
                    <div class="group flex flex-col rounded-[2.5rem] shadow-md hover:shadow-2xl overflow-hidden bg-white border border-gray-100 transition-all duration-500 hover:-translate-y-2 relative">
                        <!-- Decorative background -->
                        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-br from-blue-50 to-white opacity-50"></div>

                        <div class="relative h-80 overflow-hidden m-4 rounded-[2rem] shadow-inner bg-gray-50 flex-shrink-0">
                            @if($laporan->cover)
                                <img class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-110" src="{{ asset('storage/' . $laporan->cover) }}" alt="{{ $laporan->title }}">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center p-8 text-center bg-gradient-to-br from-gray-50 to-gray-100">
                                    <i class="fas fa-file-pdf text-blue-200 text-7xl mb-4"></i>
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">No Preview Cover</span>
                                </div>
                            @endif
                            
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-blue-600 px-4 py-1.5 rounded-full text-[10px] font-black shadow-lg border border-blue-50">
                                TAHUN {{ $laporan->tahun }}
                            </div>
                        </div>

                        <div class="flex-1 p-8 pt-2 flex flex-col justify-between">
                            <div class="flex-1 mb-6">
                                @php
                                    $len = Str::length($laporan->title);
                                    $titleClass = 'text-base';
                                    if ($len > 50) $titleClass = 'text-xs';
                                    elseif ($len > 25) $titleClass = 'text-sm';
                                @endphp
                                <h3 class="{{ $titleClass }} font-black text-gray-900 text-center leading-snug group-hover:text-blue-600 transition-colors">
                                    {{ $laporan->title }}
                                </h3>
                            </div>
                            <div class="grid grid-cols-1 gap-3">
                                <a href="{{ route('laporan.ppid.preview', $laporan->encoded_id) }}" 
                                   class="flex items-center justify-center w-full bg-blue-600 text-white font-black text-[10px] py-3.5 rounded-2xl transition-all duration-500 uppercase tracking-widest gap-2 shadow-lg shadow-blue-100 hover:shadow-blue-200">
                                    <i class="fas fa-eye text-xs"></i>
                                    Preview Laporan
                                </a>
                                <a href="{{ asset('storage/' . $laporan->file) }}" 
                                   download
                                   class="flex items-center justify-center w-full bg-white text-gray-600 border-2 border-gray-100 hover:border-blue-500 hover:text-blue-600 font-black text-[10px] py-3 rounded-2xl transition-all duration-500 uppercase tracking-widest gap-2">
                                    <i class="fas fa-download text-xs"></i>
                                    Download PDF
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-[3rem] p-20 text-center shadow-sm border border-dashed border-gray-200">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8">
                    <i class="fas fa-folder-open text-gray-200 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-3">Belum Ada Laporan</h3>
                <p class="text-gray-500 max-w-sm mx-auto">Daftar laporan tahunan akan segera tersedia di halaman ini. Silakan kembali lagi nanti.</p>
            </div>
        @endif
    </div>
</div>
@endsection
