@extends('frontend.layouts.app')

@section('title', 'Tentang OPD & Pejabat Daerah')

@section('content')
<div class="py-8 md:py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => 'Tentang OPD', 'url' => '', 'icon' => 'fas fa-building']
        ]" />

        <div class="mb-16 text-center mt-8">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-6 tracking-tight">Profil Pimpinan & Organisasi Daerah</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">Daftar Dinas, Badan, Kecamatan, Desa, dan Kelurahan yang bertugas di wilayah Kabupaten Sinjai.</p>
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
                                    
                                    if ($groupName === 'Kecamatan') {
                                        $iconClass = 'fa-landmark';
                                        $colorClass = 'bg-indigo-600';
                                        $shadowClass = 'shadow-indigo-200';
                                    } elseif ($groupName === 'Badan') {
                                        $iconClass = 'fa-shield-alt';
                                        $colorClass = 'bg-emerald-600';
                                        $shadowClass = 'shadow-emerald-200';
                                    } elseif ($groupName === 'Desa') {
                                        $iconClass = 'fa-home';
                                        $colorClass = 'bg-orange-600';
                                        $shadowClass = 'shadow-orange-200';
                                    } elseif ($groupName === 'Kelurahan') {
                                        $iconClass = 'fa-city';
                                        $colorClass = 'bg-amber-600';
                                        $shadowClass = 'shadow-amber-200';
                                    }
                                @endphp
                                <div class="w-12 h-12 {{ $colorClass }} rounded-2xl flex items-center justify-center text-white mr-5 shadow-lg {{ $shadowClass }}">
                                    <i class="fas {{ $iconClass }} text-xl"></i>
                                </div>
                                <div>
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] block mb-1">Klasifikasi</span>
                                    <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">{{ $groupName }}</h2>
                                </div>
                                <div class="ml-8 pl-8 border-l border-gray-100 hidden md:block">
                                    <span class="{{ str_replace('bg-', 'text-', $colorClass) }} bg-gray-50 px-4 py-1 rounded-full text-xs font-black uppercase">
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
                                    
                                    <div class="p-8 pb-8 flex flex-col items-center text-center flex-grow relative z-10">
                                        {{-- Profile Image Section (Desain ala Unit Lokal) --}}
                                        <div class="relative mb-6">
                                            <div class="absolute inset-0 bg-blue-600 rounded-full blur-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
                                            
                                            @php
                                                // Cari Pejabat Terkait (Kepala Dinas/Badan/Camat)
                                                // Kita asumsikan pimpinan pertama adalah pimpinan utama
                                                $leader = \App\Models\Official::where('organization_id', $organization->id)
                                                    ->where('status', 'active')
                                                    ->first();
                                            @endphp

                                            @if($leader && $leader->photo)
                                                <img src="{{ asset('storage/' . $leader->photo) }}"
                                                     alt="{{ $leader->full_name }}"
                                                     class="w-32 h-32 md:w-36 md:h-36 rounded-full object-cover border-4 border-white shadow-2xl relative z-10 transition-transform duration-500 group-hover:scale-105">
                                            @else
                                                <div class="w-32 h-32 md:w-36 md:h-36 rounded-full bg-gradient-to-br from-gray-50 to-gray-100 border-4 border-white shadow-2xl flex items-center justify-center text-gray-300 text-4xl md:text-5xl relative z-10">
                                                    <i class="fas fa-building"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <h3 class="text-xl font-black text-gray-900 mb-2 leading-tight group-hover:text-blue-600 transition-colors">
                                            {{ $organization->name }}
                                        </h3>

                                        @if($leader)
                                            <p class="text-sm font-bold text-gray-500 mb-4">{{ $leader->full_name }}</p>
                                        @endif
                                        
                                        <div class="flex items-start text-gray-500 font-bold text-[11px] mb-8 bg-gray-50 px-5 py-3 rounded-2xl border border-gray-100 w-full min-h-[60px]">
                                            <i class="fas fa-map-marker-alt mr-3 mt-0.5 text-blue-400"></i>
                                            <span class="leading-relaxed text-left line-clamp-2">{!! $organization->api_address ?? 'Alamat belum ditambahkan.' !!}</span>
                                        </div>

                                        <div class="mt-auto space-y-3 w-full">
                                            <a href="{{ route('opd.detail', $organization) }}" class="inline-flex items-center justify-center w-full bg-blue-600 text-white font-black text-xs py-4 rounded-2xl transition-all duration-500 uppercase tracking-widest gap-2 shadow-lg shadow-blue-100 group-hover:shadow-blue-200">
                                                <i class="fas fa-sitemap mr-1"></i> Struktur & Website
                                            </a>

                                            @auth
                                                @php
                                                    $canManage = false;
                                                    // Gunakan Helper isAdmin() yang sudah kita perkuat sebelumnya
                                                    if (Auth::user()->isSuperAdmin()) {
                                                        $canManage = true;
                                                    } elseif (Auth::user()->unit_id && (string)Auth::user()->unit_id === (string)$organization->remote_id) {
                                                        $canManage = true;
                                                    } elseif (isset($api_unit_id) && (string)$api_unit_id === (string)$organization->remote_id) {
                                                        $canManage = true;
                                                    }
                                                @endphp

                                                @if ($canManage)
                                                    <div class="pt-2">
                                                        <a href="{{ route('opd.manage-public', ['organization' => $organization->id]) }}" class="inline-flex items-center justify-center w-full bg-white text-blue-600 border-2 border-blue-100 hover:border-blue-500 hover:bg-blue-50 font-black text-xs py-4 rounded-2xl transition-all duration-500 uppercase tracking-widest gap-2">
                                                            <i class="fas fa-edit"></i> Kelola Profil Unit
                                                        </a>
                                                    </div>
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
