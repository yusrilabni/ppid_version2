@extends('frontend.layouts.app')

@section('title', 'DIP Unit - Daftar Informasi Publik')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-house'],
            ['title' => 'DIP Unit', 'url' => '', 'icon' => 'fas fa-university']
        ]" />

        <div class="mb-12 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Daftar Informasi Publik (DIP) Unit</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Pilih unit kerja di bawah ini untuk melihat Daftar Informasi Publik yang dikelola oleh masing-masing OPD, Kecamatan, Desa, dan Kelurahan.</p>
        </div>

        <!-- Section OPD (Dinas & Badan) -->
        <div class="mb-20">
            <div class="flex items-center justify-between mb-8 border-b border-gray-100 pb-4">
                <div class="flex items-center">
                    <div class="bg-blue-600 w-3 h-10 rounded-full mr-4 shadow-lg shadow-blue-200"></div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Organisasi Perangkat Daerah (OPD)</h2>
                        <p class="text-sm text-gray-500">Dinas, Badan, dan Kantor Lingkup Pemerintah Kabupaten Sinjai</p>
                    </div>
                </div>
                <div class="hidden md:block bg-blue-50 text-blue-700 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                    {{ count($opds) }} Unit
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($opds as $opd)
                    @include('frontend.opd._unit_card', ['unit' => $opd, 'icon' => 'fa-building', 'color' => 'blue'])
                @endforeach
            </div>
        </div>

        <!-- Section Kecamatan -->
        <div>
            <div class="flex items-center justify-between mb-8 border-b border-gray-100 pb-4">
                <div class="flex items-center">
                    <div class="bg-indigo-600 w-3 h-10 rounded-full mr-4 shadow-lg shadow-indigo-200"></div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Wilayah Kecamatan</h2>
                        <p class="text-sm text-gray-500">Pusat pemerintahan wilayah kecamatan dan induk data Desa/Kelurahan</p>
                    </div>
                </div>
                <div class="hidden md:block bg-indigo-50 text-indigo-700 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                    {{ count($kecamatans) }} Kecamatan
                </div>
            </div>

            <div class="space-y-16">
                @foreach ($kecamatans as $kec)
                    <div class="bg-white rounded-[2.5rem] p-8 md:p-10 border border-gray-100 shadow-xl shadow-gray-100/50">
                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
                            <div class="flex items-center">
                                <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mr-5 text-indigo-600 shadow-inner">
                                    <i class="fas fa-landmark text-3xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-black text-gray-900 tracking-tight">{{ $kec['name'] }}</h3>
                                    <div class="flex items-center mt-1 text-indigo-600 font-semibold text-sm">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        <span>Menampilkan data gabungan Kecamatan & {{ count($kec['villages']) }} Desa/Kelurahan</span>
                                    </div>
                                </div>
                            </div>
                            
                            @if($kec['slug'])
                                <a href="{{ route('opd.dip.show', $kec['slug']) }}" class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 px-8 rounded-2xl transition-all duration-300 shadow-lg shadow-indigo-200 transform hover:scale-105 active:scale-95">
                                    <i class="fas fa-file-contract mr-3 text-lg"></i> LIHAT DIP KECAMATAN
                                </a>
                            @else
                                <span class="bg-gray-100 text-gray-400 font-bold py-3 px-8 rounded-2xl italic">Belum Terdaftar</span>
                            @endif
                        </div>

                        <div class="relative mb-6">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-gray-100"></div>
                            </div>
                            <div class="relative flex justify-start">
                                <span class="pr-4 bg-white text-xs font-black uppercase tracking-widest text-gray-400">Daftar Desa & Kelurahan</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                            @foreach ($kec['villages'] as $village)
                                <div class="group bg-gray-50 hover:bg-white p-5 rounded-2xl border border-transparent hover:border-indigo-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between min-h-[140px] transform hover:-translate-y-1">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="w-10 h-10 bg-white group-hover:bg-indigo-50 rounded-lg flex items-center justify-center text-gray-400 group-hover:text-indigo-600 transition-colors duration-300">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <span class="text-[10px] font-black uppercase tracking-tighter bg-gray-200 group-hover:bg-indigo-100 text-gray-500 group-hover:text-indigo-600 px-2 py-0.5 rounded transition-colors duration-300">
                                            {{ $village['type'] == 'WILAYAH' ? 'Desa/Kel' : $village['type'] }}
                                        </span>
                                    </div>
                                    
                                    <div>
                                        <h4 class="text-base font-bold text-gray-800 group-hover:text-indigo-900 transition-colors duration-300 mb-3">{{ $village['name'] }}</h4>
                                        
                                        @if($village['slug'])
                                            <a href="{{ route('opd.dip.show', $village['slug']) }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 tracking-wide">
                                                BUKA DIP <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                                            </a>
                                        @else
                                            <div class="flex items-center text-[10px] text-gray-400 italic font-medium">
                                                <i class="fas fa-hourglass-start mr-1.5"></i> Belum ada data
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
