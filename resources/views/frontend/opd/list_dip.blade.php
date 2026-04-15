@extends('frontend.layouts.app')

@section('title', 'DIP Unit - Daftar Informasi Publik')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-house'],
            ['title' => 'DIP Unit', 'url' => '', 'icon' => 'fas fa-book']
        ]" />

        <div class="mb-10 text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 md:text-4xl mb-4">Daftar Informasi Publik (DIP) Unit</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Pilih unit kerja di bawah ini untuk melihat Daftar Informasi Publik yang dikelola oleh masing-masing unit.</p>
        </div>

        <!-- Section OPD -->
        <div class="mb-16">
            <div class="flex items-center mb-8">
                <div class="bg-blue-600 w-2 h-8 rounded-full mr-4"></div>
                <h2 class="text-2xl font-bold text-gray-800">Organisasi Perangkat Daerah (OPD)</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($opds as $opd)
                    @include('frontend.opd._unit_card', ['unit' => $opd, 'icon' => 'fa-building'])
                @endforeach
            </div>
        </div>

        <!-- Section Kecamatan -->
        <div>
            <div class="flex items-center mb-8">
                <div class="bg-green-600 w-2 h-8 rounded-full mr-4"></div>
                <h2 class="text-2xl font-bold text-gray-800">Kecamatan, Desa & Kelurahan</h2>
            </div>

            <div class="space-y-12">
                @foreach ($kecamatans as $kec)
                    <div class="bg-gray-50 rounded-3xl p-6 md:p-8 border border-gray-200">
                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4 text-green-600">
                                    <i class="fas fa-map-marked-alt text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $kec['name'] }}</h3>
                                    <p class="text-sm text-gray-500">Mencakup seluruh dokumen Desa & Kelurahan di wilayah ini</p>
                                </div>
                            </div>
                            @if($kec['slug'])
                                <a href="{{ route('opd.dip.show', $kec['slug']) }}" class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-xl transition-all duration-300 shadow-md">
                                    <i class="fas fa-file-alt mr-2"></i> DIP {{ $kec['name'] }}
                                </a>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach ($kec['villages'] as $village)
                                <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                                    <h4 class="text-sm font-bold text-gray-800 mb-3">{{ $village['name'] }}</h4>
                                    @if($village['slug'])
                                        <a href="{{ route('opd.dip.show', $village['slug']) }}" class="text-xs text-blue-600 font-semibold hover:text-blue-800 flex items-center">
                                            Lihat DIP <i class="fas fa-chevron-right ml-1"></i>
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Belum terdaftar</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
