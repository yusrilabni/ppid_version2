@extends('frontend.layouts.app')

@section('title', 'Tentang OPD')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-house'],
            ['title' => 'Tentang OPD', 'url' => '', 'icon' => 'fas fa-building']
        ]" />

        <div class="mb-10 text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 md:text-4xl mb-4">Tentang Organisasi Perangkat Daerah (OPD)</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Informasi profil, struktur organisasi, dan tautan resmi dari setiap Organisasi Perangkat Daerah Kabupaten Sinjai.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($organizations as $organization)
                <div class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 ease-in-out overflow-hidden flex flex-col h-full border border-gray-100 hover:border-blue-100 transform hover:-translate-y-2">
                    <div class="p-8 flex-grow flex flex-col">
                        <div class="flex items-center justify-center mb-6">
                            <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center group-hover:bg-blue-600 transition-colors duration-300">
                                <i class="fas fa-building text-blue-600 text-3xl group-hover:text-white transition-colors duration-300"></i>
                            </div>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800 mb-3 text-center leading-tight">{{ $organization->name }}</h2>
                        <div class="flex items-start text-gray-500 mb-6 text-center justify-center text-sm">
                            <i class="fas fa-map-marker-alt text-blue-500 mr-2 mt-0.5"></i>
                            <p class="flex-grow line-clamp-2">{!! $organization->api_address ?? 'Alamat belum ditambahkan.' !!}</p>
                        </div>
                        
                        <div class="mt-auto space-y-3">
                            <a href="{{ route('opd.detail', $organization->id) }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 w-full shadow-lg shadow-blue-100 hover:shadow-blue-200">
                                <i class="fas fa-sitemap mr-2"></i> Lihat Struktur Organisasi
                            </a>
                            
                            @if($organization->website_url)
                                <a href="{{ $organization->website_url }}" target="_blank" class="inline-flex items-center justify-center bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold py-2.5 px-6 rounded-xl transition-all duration-300 w-full border border-gray-100">
                                    <i class="fas fa-globe mr-2 text-blue-500"></i> Website Resmi
                                </a>
                            @endif

                            @auth
                                @php
                                    $canManage = false;
                                    $user = Auth::user();
                                    
                                    // Superadmin can manage everything
                                    if ($user->role === 'superadmin') {
                                        $canManage = true;
                                    } else {
                                        // Admin only manages their matching unit
                                        // Check against api_unit_id (from remote API) OR direct unit_id mapping
                                        if (isset($api_unit_id) && (string)$api_unit_id === (string)$organization->remote_id) {
                                            $canManage = true;
                                        } elseif ((string)$user->unit_id === (string)$organization->remote_id) {
                                            $canManage = true;
                                        }
                                    }
                                @endphp

                                @if ($canManage)
                                    <div class="pt-2">
                                        <a href="{{ route('opd.manage-public', $organization->id) }}" class="inline-flex items-center justify-center bg-amber-500 hover:bg-amber-600 text-white font-bold py-2.5 px-6 rounded-xl transition-all duration-300 w-full shadow-lg shadow-amber-100 hover:shadow-amber-200">
                                            <i class="fas fa-edit mr-2"></i> Kelola Struktur & Web
                                        </a>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 bg-white rounded-3xl shadow-sm border border-dashed border-gray-300">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-search text-gray-300 text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada data OPD</h3>
                        <p class="text-gray-500">Saat ini belum ada data organisasi perangkat daerah yang tersedia.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
