@extends('frontend.layouts.app')

@section('title', 'Unit Lokal - Profil Kepala Desa & Kelurahan')

@section('content')
<div class="py-8 md:py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => 'Unit Lokal', 'url' => '', 'icon' => 'fas fa-map-marked-alt']
        ]" />

        <div class="mb-16 text-center mt-8">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-6 tracking-tight">Profil Pimpinan Unit Lokal</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">Daftar Kepala Desa dan Kelurahan yang bertugas di seluruh wilayah Kabupaten Sinjai.</p>
        </div>

        @if(empty($groupedData))
            <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-gray-100">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                    <i class="fas fa-users-slash text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Belum Ada Data</h3>
                <p class="text-gray-500">Data profil pimpinan desa dan kelurahan belum tersedia.</p>
            </div>
        @else
            @php
                $user = auth()->user();
                $apiData = $user && $user->nip ? \App\Models\User::getDataFromApi($user->nip) : null;
                $api_unit_id = $apiData['unit_id'] ?? null;
            @endphp
            
            <div class="space-y-24">
                @foreach($groupedData as $kecName => $group)
                    <section class="relative">
                        <!-- Kecamatan Header -->
                        <div class="sticky top-20 z-20 mb-10">
                            <div class="bg-white/80 backdrop-blur-md border border-gray-100 inline-flex items-center px-8 py-4 rounded-3xl shadow-xl">
                                <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white mr-5 shadow-lg shadow-indigo-200">
                                    <i class="fas fa-landmark text-xl"></i>
                                </div>
                                <div>
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] block mb-1">Wilayah</span>
                                    <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Kecamatan {{ $kecName }}</h2>
                                </div>
                                <div class="ml-8 pl-8 border-l border-gray-100 hidden md:block">
                                    <span class="bg-indigo-50 text-indigo-700 px-4 py-1 rounded-full text-xs font-black uppercase">
                                        {{ count($group['officials']) }} Pimpinan
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Officials Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                            @foreach($group['officials'] as $official)
                                <div class="group bg-white rounded-[2.5rem] shadow-md hover:shadow-2xl border border-gray-100 overflow-hidden flex flex-col transition-all duration-500 hover:-translate-y-2 relative">
                                    <!-- Decorative background -->
                                    <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-br from-indigo-50 to-white opacity-50"></div>
                                    
                                    <div class="p-8 pb-8 flex flex-col items-center text-center flex-grow relative z-10">
                                        <div class="relative mb-6">
                                            <div class="absolute inset-0 bg-indigo-600 rounded-full blur-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
                                            @if($official->photo)
                                                <img src="{{ asset('storage/' . $official->photo) }}"
                                                     alt="{{ $official->full_name }}"
                                                     class="w-32 h-32 md:w-36 md:h-36 rounded-full object-cover border-4 border-white shadow-2xl relative z-10 transition-transform duration-500 group-hover:scale-105">
                                            @else
                                                <div class="w-32 h-32 md:w-36 md:h-36 rounded-full bg-gradient-to-br from-gray-50 to-gray-100 border-4 border-white shadow-2xl flex items-center justify-center text-gray-300 text-4xl md:text-5xl relative z-10">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            @endif
                                            
                                            <!-- Gender/Status Badge -->
                                            <div class="absolute bottom-1 right-1 z-20">
                                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-white shadow-lg border border-gray-50 text-xs">
                                                    @if($official->jenis_kelamin == 'Laki-laki')
                                                        <i class="fas fa-mars text-blue-500"></i>
                                                    @else
                                                        <i class="fas fa-venus text-pink-500"></i>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>

                                        <a href="{{ route('official.profile.show', ['slug' => $official->slug ?? '']) }}" class="text-xl md:text-2xl font-black text-gray-900 mb-2 hover:text-indigo-600 transition-colors leading-tight">
                                            {{ $official->full_name }}
                                        </a>
                                        
                                        <div class="mb-4">
                                            @php
                                                $orgName = $official->organization->name ?? '';
                                                $isDesa = stripos($orgName, 'Desa') !== false;
                                                $jabatan = $isDesa ? 'Kepala Desa' : 'Lurah';
                                                
                                                if ($official->status_jabatan && $official->status_jabatan !== 'Definitif') {
                                                    $prefix = preg_match('/\((\w+)\)/', $official->status_jabatan, $matches) ? $matches[1] : $official->status_jabatan;
                                                    $jabatan = rtrim($prefix, '.') . '. ' . $jabatan;
                                                }
                                            @endphp
                                            <span class="px-4 py-1.5 bg-indigo-50 text-indigo-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-indigo-100">
                                                {{ $jabatan }}
                                            </span>
                                        </div>

                                        <div class="flex items-center text-gray-500 font-bold text-sm mb-6 bg-gray-50 px-5 py-2 rounded-2xl border border-gray-100">
                                            <i class="fas fa-map-marker-alt mr-2 text-indigo-400"></i>
                                            {{ $orgName }}
                                        </div>

                                        <div class="space-y-3 w-full">
                                            <a href="{{ route('official.profile.show', ['slug' => $official->slug ?? '']) }}" class="inline-flex items-center justify-center w-full bg-indigo-600 text-white font-black text-xs py-4 rounded-2xl transition-all duration-500 uppercase tracking-widest gap-2 shadow-lg shadow-indigo-100">
                                                Profil Lengkap <i class="fas fa-arrow-right text-sm"></i>
                                            </a>

                                            @auth
                                                @php
                                                    $canManage = false;
                                                    $remoteId = $official->organization->remote_id ?? null;
                                                    if ($user->isSuperAdmin()) {
                                                        $canManage = true;
                                                    } elseif ($user->unit_id && (string)$user->unit_id === (string)$remoteId) {
                                                        $canManage = true;
                                                    } elseif (isset($api_unit_id) && (string)$api_unit_id === (string)$remoteId) {
                                                        $canManage = true;
                                                    }
                                                @endphp

                                                @if ($canManage)
                                                    <div class="grid grid-cols-2 gap-2">
                                                        <a href="{{ route('opd.manage-public', ['organization' => $official->organization->id]) }}" class="inline-flex items-center justify-center bg-white text-indigo-600 border-2 border-indigo-100 hover:border-indigo-500 hover:bg-indigo-50 font-black text-[9px] py-3 rounded-xl transition-all duration-300 uppercase tracking-tighter gap-1">
                                                            <i class="fas fa-edit"></i> Profil Unit
                                                        </a>
                                                        
                                                        <a href="{{ route('pimpinan.edit-public', ['official' => $official->id]) }}" class="inline-flex items-center justify-center bg-amber-500 text-white border-2 border-amber-400 hover:bg-amber-600 font-black text-[9px] py-3 rounded-xl transition-all duration-300 uppercase tracking-tighter gap-1 shadow-md shadow-amber-100">
                                                            <i class="fas fa-user-edit"></i> Pimpinan
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
