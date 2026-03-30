@extends('frontend.layouts.app')

@section('title', 'LHKPN Pimpinan & Pejabat Daerah')

@section('content')
    <div class="bg-gray-50 min-h-screen pb-12">
        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 text-white pt-12 pb-20 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <svg class="h-full w-full" preserveAspectRatio="none" viewBox="0 0 100 100" fill="currentColor">
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                    </pattern>
                    <rect width="100" height="100" fill="url(#grid)" />
                </svg>
            </div>
            
            <div class="container mx-auto px-6 relative z-10">
                <div class="mb-6 lhkpn-breadcrumbs">
                    <x-breadcrumbs :breadcrumbs="[
                        ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                        ['title' => 'LHKPN', 'url' => '#', 'icon' => 'fas fa-file-invoice-dollar'],
                    ]" />
                </div>

                <style>
                    .lhkpn-breadcrumbs a, 
                    .lhkpn-breadcrumbs span, 
                    .lhkpn-breadcrumbs i {
                        color: rgba(255, 255, 255, 0.9) !important;
                    }
                    .lhkpn-breadcrumbs .breadcrumb-separator {
                        color: rgba(255, 255, 255, 0.4) !important;
                    }
                </style>

                <div class="mt-8">
                    <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight mb-4 text-white">Laporan Harta Kekayaan (LHKPN)</h1>
                    <p class="text-blue-100 text-lg max-w-2xl leading-relaxed">
                        Transparansi Harta Kekayaan Penyelenggara Negara di Lingkungan Pemerintah Kabupaten Sinjai.
                    </p>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-6 py-12 relative z-20">
            @php
                $pimpinan = $items->where('group', 'pimpinan');
                $eselon2 = $items->where('group', 'eselon2');
                $eselon3 = $items->where('group', 'eselon3');
            @endphp

            <!-- Grouped Sections -->
            <div class="space-y-16">
                <!-- Pimpinan Section -->
                <section>
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-600 rounded-2xl shadow-lg flex items-center justify-center text-white mr-4">
                                <i class="fas fa-crown text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-black text-gray-900">LHKPN Pimpinan</h2>
                                <p class="text-gray-500 text-sm">Bupati, Wakil Bupati, dan Sekretaris Daerah</p>
                            </div>
                        </div>
                        <div class="h-px flex-1 bg-gray-200 mx-8 hidden lg:block"></div>
                        <span class="px-4 py-1.5 bg-blue-50 text-blue-700 text-sm font-bold rounded-full border border-blue-100">
                            {{ $pimpinan->count() }} Jabatan
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($pimpinan as $item)
                            @include('frontend.lhkpn._official_card', ['item' => $item])
                        @endforeach
                    </div>
                </section>

                <!-- Eselon II Section -->
                <section>
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-600 rounded-2xl shadow-lg flex items-center justify-center text-white mr-4">
                                <i class="fas fa-building text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-black text-gray-900">LHKPN Eselon II</h2>
                                <p class="text-gray-500 text-sm">Asisten, Staf Ahli, dan Pejabat Daerah (Badan/Dinas/Inspektorat)</p>
                            </div>
                        </div>
                        <div class="h-px flex-1 bg-gray-200 mx-8 hidden lg:block"></div>
                        <span class="px-4 py-1.5 bg-green-50 text-green-700 text-sm font-bold rounded-full border border-green-100">
                            {{ $eselon2->count() }} Jabatan
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($eselon2 as $item)
                            @include('frontend.lhkpn._official_card', ['item' => $item])
                        @endforeach
                    </div>
                </section>

                <!-- Eselon III Section -->
                <section class="pb-12">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-amber-500 rounded-2xl shadow-lg flex items-center justify-center text-white mr-4">
                                <i class="fas fa-map-marked-alt text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-black text-gray-900">LHKPN Eselon III</h2>
                                <p class="text-gray-500 text-sm">Para Camat Se-Kabupaten Sinjai</p>
                            </div>
                        </div>
                        <div class="h-px flex-1 bg-gray-200 mx-8 hidden lg:block"></div>
                        <span class="px-4 py-1.5 bg-amber-50 text-amber-700 text-sm font-bold rounded-full border border-amber-100">
                            {{ $eselon3->count() }} Jabatan
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($eselon3 as $item)
                            @include('frontend.lhkpn._official_card', ['item' => $item])
                        @endforeach
                    </div>
                </section>
            </div>

            <!-- Pagination -->
            @if(method_exists($items, 'links'))
                <div class="mt-12">
                    {{ $items->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
