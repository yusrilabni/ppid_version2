@extends('frontend.layouts.app')

@section('title', 'DIP ' . $unitName . ' - Tahun ' . $year)

@section('content')
<div class="py-8 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <x-breadcrumbs :breadcrumbs="[
                ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                ['title' => 'DIP Unit', 'url' => route('dipunit.index'), 'icon' => 'fas fa-university'],                ['title' => $unitName, 'url' => '#', 'icon' => 'fas fa-file-alt'],
            ]" />
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mb-8">
            <div class="bg-gradient-to-r from-blue-700 to-indigo-800 p-8 md:p-10 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 p-10 opacity-10 transform translate-x-1/4 -translate-y-1/4">
                    <i class="fas fa-building text-[120px]"></i>
                </div>
                <div class="relative z-10">
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                        <div>
                            <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold uppercase tracking-wider mb-4 border border-white/20">Daftar Informasi Publik Unit</span>
                            <h1 class="text-3xl md:text-4xl font-extrabold leading-tight mb-2">{{ $unitName }}</h1>
                            <p class="text-blue-100 text-lg md:text-xl font-medium opacity-90">Tahun Anggaran {{ $year }}</p>
                        </div>
                        
                        <!-- Export & Year Filter -->
                        <div class="flex flex-col md:flex-row gap-4 items-center">
                            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                            <a href="{{ route('opd.dip.export', [$organization->slug, 'year' => $year]) }}" class="inline-flex items-center bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-6 rounded-2xl transition-all duration-300 shadow-xl hover:shadow-green-300 transform hover:-translate-y-1 order-2 md:order-1">
                                <i class="fas fa-file-excel mr-2 text-xl"></i> Export Excel
                            </a>
                            @endif

                            <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/20 order-1 md:order-2">
                                <form action="{{ url()->current() }}" method="GET" id="filterForm" class="flex flex-col gap-2">
                                    <label for="year" class="text-xs font-bold uppercase tracking-widest text-blue-100">Pilih Tahun DIP</label>
                                    <div class="relative">
                                        <select name="year" id="year" onchange="this.form.submit()" 
                                            class="appearance-none w-full md:w-40 bg-white text-gray-900 px-4 py-2.5 rounded-xl font-bold focus:outline-none focus:ring-2 focus:ring-blue-400 border-none shadow-sm cursor-pointer pr-10">
                                            @foreach($availableYears as $availYear)
                                                <option value="{{ $availYear }}" {{ $availYear == $year ? 'selected' : '' }}>{{ $availYear }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-blue-600">
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-10">
                @if($informasiTahunIni->isEmpty())
                    <div class="text-center py-16">
                        <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-exclamation-triangle text-orange-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Data Tidak Ditemukan</h3>
                        <p class="text-gray-500">Belum ada Daftar Informasi Publik (DIP) untuk tahun {{ $year }} pada OPD ini.</p>
                        <a href="{{ route('dipunit.index') }}" class="inline-flex items-center mt-6 text-blue-600 font-bold hover:underline">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Unit
                        </a>
                    </div>
                @else
                    <div class="space-y-12">
                        @php
                            $categories = [
                                'Informasi Berkala' => '1. Informasi Berkala',
                                'Informasi Setiap Saat' => '2. Informasi Tersedia Setiap Saat',
                                'Informasi Serta Merta' => '3. Informasi Serta Merta'
                            ];
                        @endphp

                        @foreach($categories as $key => $label)
                            @if($informasiTahunIni->has($key))
                                <div class="relative">
                                    <div class="flex items-center gap-4 mb-8">
                                        <div class="h-10 w-1.5 bg-blue-600 rounded-full"></div>
                                        <h3 class="text-2xl font-black text-gray-800 uppercase tracking-tight">{{ $label }}</h3>
                                    </div>
                                    
                                    @php $char = 'a'; @endphp
                                    <div class="space-y-10 pl-2">
                                        @foreach($informasiTahunIni->get($key) as $jenisDokumen => $groupedByUnit)
                                            <div class="bg-gray-50/50 rounded-3xl p-6 md:p-8 border border-gray-100">
                                                <h4 class="text-lg font-bold text-indigo-700 mb-6 flex items-start">
                                                    <span class="bg-indigo-600 text-white w-7 h-7 rounded-xl flex items-center justify-center text-xs font-black mr-4 flex-shrink-0 shadow-md shadow-indigo-100">{{ $char++ }}</span>
                                                    <span class="pt-0.5">{{ $jenisDokumen ?: 'Dokumen Lainnya' }}</span>
                                                </h4>

                                                <div class="space-y-8">
                                                    @foreach($groupedByUnit as $originUnitName => $informasiList)
                                                        <div class="relative">
                                                            <!-- Unit Origin Label -->
                                                            <div class="flex items-center mb-4 gap-3">
                                                                <div class="h-px flex-grow bg-gray-200"></div>
                                                                <span class="px-4 py-1.5 bg-white border border-gray-200 rounded-full text-[10px] font-black text-gray-500 uppercase tracking-widest shadow-sm">
                                                                    <i class="fas fa-university mr-2 text-indigo-400"></i> Unit: {{ $originUnitName }}
                                                                </span>
                                                                <div class="h-px flex-grow bg-gray-200"></div>
                                                            </div>

                                                            <div class="overflow-x-auto rounded-2xl border border-gray-200 shadow-sm bg-white">
                                                                @include('frontend.pages.dip._informasi_table', ['informasiList' => $informasiList])
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Info Footer -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-gray-500 text-sm px-4">
            <p><i class="fas fa-info-circle mr-2"></i> Data diperbarui secara otomatis oleh sistem PPID.</p>
            <p>© {{ date('Y') }} PPID Kabupaten Sinjai</p>
        </div>
    </div>
</div>
@endsection
