@extends('frontend.layouts.app')

@section('title', 'Laporan Tahunan PPID')

@section('content')
<div class="container mx-auto my-8 px-4 md:px-0">
    <div class="max-w-7xl mx-auto">
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => 'Laporan PPID', 'url' => '#', 'icon' => 'fas fa-file-invoice']
        ]" />

        <div class="bg-gray-50 py-12 rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-12">
                        <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl flex items-center justify-center gap-3">
                            <i class="fas fa-file-invoice text-blue-600"></i>
                            Laporan Tahunan PPID
                        </h1>
                        <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                            Daftar laporan tahunan pelayanan informasi publik Dinas Komunikasi Informatika dan Persandian Kabupaten Sinjai.
                        </p>
                    </div>

            @if($laporans->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($laporans as $laporan)
                        <div class="flex flex-col rounded-lg shadow-lg overflow-hidden bg-white hover:shadow-xl transition-shadow duration-300">
                            <div class="flex-shrink-0 relative h-80 bg-gray-200">
                                @if($laporan->cover)
                                    <img class="w-full h-full object-cover object-top" src="{{ asset('storage/' . $laporan->cover) }}" alt="{{ $laporan->title }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-file-pdf text-blue-300 text-7xl"></i>
                                    </div>
                                @endif
                                <div class="absolute top-0 right-0 mt-4 mr-4 bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-md">
                                    TAHUN {{ $laporan->tahun }}
                                </div>
                            </div>
                            <div class="flex-1 p-6 flex flex-col justify-between">
                                <div class="flex-1 mb-4 flex items-center justify-center">
                                    @php
                                        $len = Str::length($laporan->title);
                                        $titleClass = 'text-lg';
                                        if ($len > 50) {
                                            $titleClass = 'text-sm';
                                        } elseif ($len > 25) {
                                            $titleClass = 'text-base';
                                        }
                                    @endphp
                                    <h3 class="{{ $titleClass }} font-bold text-gray-900 text-center leading-snug">
                                        {{ $laporan->title }}
                                    </h3>
                                </div>
                                <div class="grid grid-cols-2 gap-2 mt-auto">
                                    <a href="{{ route('laporan.ppid.preview', $laporan->encoded_id) }}" 
                                       class="flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-eye mr-2"></i>
                                        Preview
                                    </a>
                                    <a href="{{ asset('storage/' . $laporan->file) }}" 
                                       download
                                       class="flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-download mr-2"></i>
                                        Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-lg shadow">
                    <i class="fas fa-folder-open text-gray-300 text-7xl mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-900">Belum Ada Laporan</h3>
                    <p class="text-gray-500 mt-2">Daftar laporan tahunan akan segera tersedia di halaman ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
</div>
</div>
@endsection