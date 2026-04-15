@extends('frontend.layouts.app')

@section('title', 'DIP Unit - Daftar Informasi Publik')

@section('content')
<div class="container mx-auto py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-house'],
            ['title' => 'DIP Unit', 'url' => '', 'icon' => 'fas fa-university']
        ]" />

        <div class="mb-16 text-center">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-6 tracking-tight">Daftar Informasi Publik Unit</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">Akses Daftar Informasi Publik (DIP) secara transparan dari seluruh tingkatan unit kerja di Kabupaten Sinjai.</p>
        </div>

        <!-- 1. BAGIAN DINAS & BADAN (OPD) -->
        <section class="mb-24">
            <div class="flex items-center gap-4 mb-10 border-b border-gray-100 pb-6">
                <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-blue-200">
                    <i class="fas fa-building text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tight">Dinas & Badan (OPD)</h2>
                    <p class="text-blue-600 font-bold text-sm">Organisasi Perangkat Daerah Pusat</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($opds as $opd)
                    @include('frontend.opd._unit_card', ['unit' => $opd, 'icon' => 'fa-building', 'color' => 'blue'])
                @endforeach
            </div>
        </section>

        <!-- 2. BAGIAN KANTOR KECAMATAN -->
        <section class="mb-24">
            <div class="flex items-center gap-4 mb-10 border-b border-gray-100 pb-6">
                <div class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-indigo-200">
                    <i class="fas fa-landmark text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tight">Kantor Kecamatan</h2>
                    <p class="text-indigo-600 font-bold text-sm">Pusat Pemerintahan Wilayah Kecamatan</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($kecamatans as $kec)
                    @include('frontend.opd._unit_card', ['unit' => $kec, 'icon' => 'fa-landmark', 'color' => 'indigo'])
                @endforeach
            </div>
        </section>

        <!-- 3. BAGIAN DESA & KELURAHAN -->
        <section>
            <div class="flex items-center gap-4 mb-12 border-b border-gray-100 pb-6">
                <div class="w-14 h-14 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-emerald-200">
                    <i class="fas fa-map-marked-alt text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tight">Desa & Kelurahan</h2>
                    <p class="text-emerald-600 font-bold text-sm">Unit Kerja Tingkat Wilayah Desa/Kelurahan</p>
                </div>
            </div>

            <div class="space-y-20">
                @foreach ($villagesByKecamatan as $kecName => $villages)
                    <div class="relative">
                        <!-- Sub-header Kecamatan -->
                        <div class="sticky top-20 z-20 mb-8">
                            <div class="bg-white/80 backdrop-blur-md border border-gray-100 inline-flex items-center px-6 py-3 rounded-2xl shadow-lg">
                                <span class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mr-3">Wilayah</span>
                                <h3 class="text-xl font-black text-emerald-700 uppercase tracking-tight">Kecamatan {{ $kecName }}</h3>
                                <span class="ml-4 bg-emerald-100 text-emerald-700 px-3 py-0.5 rounded-full text-[10px] font-black uppercase">{{ count($villages) }} Unit</span>
                            </div>
                        </div>

                        <!-- Grid Desa -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach ($villages as $village)
                                <div class="group bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:border-emerald-100 transition-all duration-500 flex flex-col justify-between min-h-[180px] relative overflow-hidden transform hover:-translate-y-2">
                                    <!-- Background Pattern -->
                                    <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity duration-500">
                                        <i class="fas fa-map-marker-alt text-8xl"></i>
                                    </div>

                                    <div class="relative z-10">
                                        <div class="flex justify-between items-start mb-4">
                                            <div class="w-12 h-12 bg-gray-50 group-hover:bg-emerald-50 rounded-2xl flex items-center justify-center text-gray-400 group-hover:text-emerald-600 transition-all duration-500 shadow-inner">
                                                <i class="fas fa-house-chimney text-xl"></i>
                                            </div>
                                            <span class="text-[10px] font-black uppercase tracking-widest bg-gray-100 group-hover:bg-emerald-100 text-gray-500 group-hover:text-emerald-700 px-3 py-1 rounded-full transition-colors duration-500">
                                                {{ $village['type'] }}
                                            </span>
                                        </div>
                                        
                                        <h4 class="text-lg font-black text-gray-800 group-hover:text-emerald-900 transition-colors duration-500 leading-tight mb-4">
                                            {{ str_ireplace(['Desa ', 'Kelurahan '], '', $village['name']) }}
                                        </h4>
                                    </div>
                                    
                                    <div class="relative z-10 mt-auto">
                                        @if($village['slug'])
                                            <a href="{{ route('opd.dip.show', $village['slug']) }}" class="inline-flex items-center justify-center w-full bg-emerald-50 group-hover:bg-emerald-600 text-emerald-700 group-hover:text-white font-black text-xs py-3 rounded-xl transition-all duration-500 uppercase tracking-widest gap-2 shadow-sm group-hover:shadow-emerald-200">
                                                BUKA DIP <i class="fas fa-circle-arrow-right text-sm"></i>
                                            </a>
                                        @else
                                            <div class="flex items-center justify-center w-full bg-gray-50 text-gray-400 font-bold text-[10px] py-3 rounded-xl uppercase tracking-widest border border-dashed border-gray-200">
                                                <i class="fas fa-hourglass-start mr-2"></i> Belum Ada Data
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
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
