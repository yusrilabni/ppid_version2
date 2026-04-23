@extends('frontend.layouts.app')

@section('title', 'Tentang OPD & Wilayah Daerah')

@section('content')
<div class="py-8 md:py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => 'Tentang OPD', 'url' => '', 'icon' => 'fas fa-building']
        ]" />

        <div class="mb-16 text-center mt-8">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-6 tracking-tight">Daftar Organisasi & Wilayah Daerah</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">Daftar OPD, Kecamatan, Desa, dan Kelurahan yang bertugas di wilayah Kabupaten Sinjai.</p>
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
                @foreach($groupedOrganizations as $groupName => $data)
                    <section class="relative">
                        <!-- Group Header -->
                        <div class="sticky top-20 z-20 mb-10">
                            <div class="bg-white/80 backdrop-blur-md border border-gray-100 inline-flex items-center px-8 py-4 rounded-3xl shadow-xl">
                                @php
                                    $iconClass = 'fa-building';
                                    $colorClass = 'bg-blue-600';
                                    $shadowClass = 'shadow-blue-200';
                                    $totalUnits = 0;
                                    
                                    if ($groupName === 'Kecamatan') {
                                        $iconClass = 'fa-landmark';
                                        $colorClass = 'bg-indigo-600';
                                        $shadowClass = 'shadow-indigo-200';
                                        $totalUnits = count($data);
                                    } elseif ($groupName === 'OPD') {
                                        $iconClass = 'fa-shield-alt';
                                        $colorClass = 'bg-emerald-600';
                                        $shadowClass = 'shadow-emerald-200';
                                        $totalUnits = count($data);
                                    } elseif ($groupName === 'Wilayah (Desa & Kelurahan)') {
                                        $iconClass = 'fa-map-marked-alt';
                                        $colorClass = 'bg-orange-600';
                                        $shadowClass = 'shadow-orange-200';
                                        foreach($data as $kecItems) $totalUnits += count($kecItems);
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
                                        {{ $totalUnits }} Unit Kerja
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if($groupName === 'Wilayah (Desa & Kelurahan)')
                            <div class="space-y-16">
                                @foreach($data as $kecName => $organizations)
                                    <div class="relative">
                                        <div class="flex items-center mb-8">
                                            <div class="h-px bg-gray-200 flex-grow"></div>
                                            <h3 class="mx-6 text-sm font-black text-gray-400 uppercase tracking-[0.2em]">Kecamatan {{ $kecName }}</h3>
                                            <div class="h-px bg-gray-200 flex-grow"></div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                                            @foreach($organizations as $organization)
                                                @include('frontend.opd._org_card', ['organization' => $organization, 'api_unit_id' => $api_unit_id])
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                                @foreach($data as $organization)
                                    @include('frontend.opd._org_card', ['organization' => $organization, 'api_unit_id' => $api_unit_id])
                                @endforeach
                            </div>
                        @endif
                    </section>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
