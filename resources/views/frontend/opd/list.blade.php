@extends('frontend.layouts.app')

@section('title', 'Tentang OPD')

@section('content')
<div class="py-8 md:py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => 'Tentang OPD', 'url' => '', 'icon' => 'fas fa-building']
        ]" />

        <div class="mb-16 text-center mt-8">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-6 tracking-tight">Tentang Organisasi Perangkat Daerah</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">Profil, Struktur Organisasi, dan Tautan Resmi Organisasi Perangkat Daerah (OPD) Kabupaten Sinjai.</p>
        </div>

        @if(empty($groupedOrganizations))
            <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-gray-100">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                    <i class="fas fa-building text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Belum Ada Data</h3>
                <p class="text-gray-500">Data organisasi perangkat daerah belum tersedia.</p>
            </div>
        @else
            <div class="space-y-24">
                @foreach($groupedOrganizations as $groupName => $organizations)
                    <section class="relative">
                        <!-- Group Header -->
                        <div class="sticky top-20 z-20 mb-10">
                            <div class="bg-white/80 backdrop-blur-md border border-gray-100 inline-flex items-center px-8 py-4 rounded-3xl shadow-xl">
                                @php
                                    $iconClass = 'fa-building';
                                    $colorClass = 'bg-blue-600';
                                    $shadowClass = 'shadow-blue-200';
                                    
                                    if ($groupName === 'Wilayah Kecamatan') {
                                        $iconClass = 'fa-landmark';
                                        $colorClass = 'bg-indigo-600';
                                        $shadowClass = 'shadow-indigo-200';
                                    } elseif ($groupName === 'Wilayah Desa & Kelurahan') {
                                        $iconClass = 'fa-map-marked-alt';
                                        $colorClass = 'bg-emerald-600';
                                        $shadowClass = 'shadow-emerald-200';
                                    } elseif ($groupName === 'Sekretariat & Bagian' || $groupName === 'Lembaga Lainnya') {
                                @endphp
                                <div class="w-12 h-12 {{ $colorClass }} rounded-2xl flex items-center justify-center text-white mr-5 shadow-lg {{ $shadowClass }}">
                                    <i class="fas {{ $iconClass }} text-xl"></i>
                                </div>
                                <div>
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] block mb-1">Klasifikasi</span>
                                    <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">{{ $groupName }}</h2>
                                </div>
                                <div class="ml-8 pl-8 border-l border-gray-100 hidden md:block">
                                    <span class="bg-gray-50 text-gray-700 px-4 py-1 rounded-full text-xs font-black uppercase">
                                        {{ count($organizations) }} Unit Kerja
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Organizations Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                            @foreach($organizations as $organization)
                                <div class="group bg-white rounded-[2.5rem] shadow-md hover:shadow-2xl border border-gray-100 overflow-hidden flex flex-col transition-all duration-500 hover:-translate-y-2 relative">
                                    <!-- Decorative background -->
                                    <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-br from-gray-50 to-white opacity-50"></div>
                                    
                                    <div class="p-8 pb-8 flex flex-col flex-grow relative z-10">
                                        <div class="flex justify-between items-start mb-6">
                                            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-xl border border-gray-50 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                                                <i class="fas fa-building text-2xl"></i>
                                            </div>
                                            
                                            @if($organization->website_url)
                                            <a href="{{ $organization->website_url }}" target="_blank" class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300" title="Kunjungi Website Resmi">
                                                <i class="fas fa-globe"></i>
                                            </a>
                                            @endif
                                        </div>

                                        <h3 class="text-xl font-black text-gray-900 mb-4 leading-tight group-hover:text-blue-600 transition-colors">
                                            {{ $organization->name }}
                                        </h3>
                                        
                                        <div class="flex items-start text-gray-500 font-bold text-xs mb-8 bg-gray-50 px-5 py-4 rounded-3xl border border-gray-100 flex-grow">
                                            <i class="fas fa-map-marker-alt mr-3 mt-0.5 text-blue-400"></i>
                                            <span class="leading-relaxed">{!! $organization->api_address ?? 'Alamat belum ditambahkan.' !!}</span>
                                        </div>

                                        <div class="space-y-3">
                                            <a href="{{ route('opd.detail', $organization) }}" class="inline-flex items-center justify-center w-full bg-blue-600 text-white font-black text-xs py-4 rounded-2xl transition-all duration-500 uppercase tracking-widest gap-2 shadow-lg shadow-blue-100 group-hover:shadow-blue-200">
                                                <i class="fas fa-sitemap mr-1"></i> Struktur & Website
                                            </a>

                                            @auth
                                                @php
                                                    $canManage = false;
                                                    if ($user->unit_id && (string)$user->unit_id === (string)$organization->remote_id) {
                                                        $canManage = true;
                                                    } elseif (isset($api_unit_id) && (string)$api_unit_id === (string)$organization->remote_id) {
                                                        $canManage = true;
                                                    }
                                                @endphp

                                                @if ($canManage)
                                                    <a href="{{ route('opd.manage-public', ['organization' => $organization->id]) }}" class="inline-flex items-center justify-center w-full bg-white text-amber-600 border-2 border-amber-100 hover:border-amber-500 hover:bg-amber-500 hover:text-white font-black text-[10px] py-3 rounded-2xl transition-all duration-500 uppercase tracking-widest gap-2">
                                                        <i class="fas fa-edit mr-1"></i> Kelola Profil OPD
                                                    </a>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
