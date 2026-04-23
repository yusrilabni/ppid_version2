@extends('frontend.layouts.app')

@section('title', 'Daftar Pejabat Daerah - Profil Pimpinan Eselon II & III')

@section('content')
<div class="py-8 md:py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => 'Pejabat Daerah', 'url' => '#', 'icon' => 'fas fa-users']
        ]" />

        <!-- Header Section -->
        <div class="mb-16 text-center mt-8">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-6 tracking-tight">Daftar Pejabat Daerah</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">Profil pimpinan tinggi pratama (Eselon II) dan pimpinan administrator (Eselon III) di lingkungan Pemerintah Kabupaten Sinjai.</p>
        </div>

        @if($kepalaOpds->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-gray-100">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                    <i class="fas fa-users-slash text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Tidak Ditemukan</h3>
                <p class="text-gray-500">Data pimpinan daerah belum tersedia atau sedang dalam proses pembaruan.</p>
            </div>
        @else
            @php
                $user = auth()->user();
                // api_unit_id is passed from controller, but we re-verify for safety if needed
                // It is already passed via compact() in controller.
                
                $groups = [
                    ['id' => 'eselon2', 'title' => 'Eselon II', 'subtitle' => 'Kepala Badan / Dinas / Inspektorat', 'items' => $kepalaOpds->get('eselon2', collect()), 'color' => 'blue', 'icon' => 'fas fa-building'],
                    ['id' => 'eselon3', 'title' => 'Eselon III', 'subtitle' => 'Camat (Pimpinan Wilayah)', 'items' => $kepalaOpds->get('eselon3', collect()), 'color' => 'green', 'icon' => 'fas fa-map-marked-alt'],
                ];
            @endphp

            <div class="space-y-24">
                @foreach($groups as $group)
                    @if($group['items']->isNotEmpty())
                        <section class="relative">
                            <!-- Category Header (Sticky) -->
                            <div class="sticky top-20 z-20 mb-10">
                                <div class="bg-white/80 backdrop-blur-md border border-gray-100 inline-flex items-center px-8 py-4 rounded-3xl shadow-xl">
                                    <div class="w-12 h-12 bg-{{ $group['color'] }}-600 rounded-2xl flex items-center justify-center text-white mr-5 shadow-lg shadow-{{ $group['color'] }}-200">
                                        <i class="{{ $group['icon'] }} text-xl"></i>
                                    </div>
                                    <div>
                                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] block mb-1">{{ $group['title'] }}</span>
                                        <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">{{ $group['subtitle'] }}</h2>
                                    </div>
                                    <div class="ml-8 pl-8 border-l border-gray-100 hidden md:block">
                                        <span class="bg-{{ $group['color'] }}-50 text-{{ $group['color'] }}-700 px-4 py-1 rounded-full text-xs font-black uppercase">
                                            {{ $group['items']->count() }} Pejabat
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Officials Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                                @foreach($group['items'] as $official)
                                    <div class="group h-full bg-white rounded-[2.5rem] shadow-md hover:shadow-2xl border border-gray-100 overflow-hidden flex flex-col transition-all duration-500 hover:-translate-y-2 relative">
                                        <!-- Decorative background -->
                                        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-br from-{{ $group['color'] }}-50 to-white opacity-50"></div>
                                        
                                        <div class="p-8 pb-8 flex flex-col items-center text-center flex-grow relative z-10">
                                            <div class="relative mb-6">
                                                <div class="absolute inset-0 bg-{{ $group['color'] }}-600 rounded-full blur-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
                                                @if($official->photo)
                                                    <img src="{{ asset('storage/' . $official->photo) }}"
                                                         alt="{{ $official->full_name }}"
                                                         class="w-32 h-32 md:w-36 md:h-36 rounded-full object-cover border-4 border-white shadow-2xl relative z-10 transition-transform duration-500 group-hover:scale-105">
                                                @else
                                                    <div class="w-32 h-32 md:w-36 md:h-36 rounded-full bg-gradient-to-br from-gray-50 to-gray-100 border-4 border-white shadow-2xl flex items-center justify-center text-gray-300 text-4xl md:text-5xl relative z-10">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                @endif
                                                
                                                <!-- Gender Badge -->
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

                                            <div class="min-h-[4rem] flex items-center justify-center mb-2">
                                                <a href="{{ route('official.profile.show', ['slug' => $official->slug ?? '']) }}" class="text-xl md:text-2xl font-black text-gray-900 hover:text-{{ $group['color'] }}-600 transition-colors leading-tight line-clamp-2">
                                                    {{ $official->full_name }}
                                                </a>
                                            </div>
                                            
                                            <div class="mb-6 min-h-[3rem] flex items-start justify-center">
                                                @php
                                                    $jabatan_asli = $official->position->name; 
                                                    $jabatan_tampilan = $jabatan_asli;
                                                    $status_jabatan = $official->status_jabatan;

                                                    if (strtolower($jabatan_asli) === 'kepala opd' && $official->organization) {
                                                        $orgName = $official->organization->name;
                                                        $orgNameLower = strtolower($orgName);

                                                        if (str_contains($orgNameLower, 'dinas')) {
                                                            $cleanedOrgName = str_ireplace('dinas ', '', $orgName);
                                                            $jabatan_tampilan = 'Kepala Dinas ' . $cleanedOrgName;
                                                        } elseif (str_contains($orgNameLower, 'kecamatan')) {
                                                            $cleanedOrgName = str_ireplace('kantor kecamatan ', '', $orgName);
                                                            $jabatan_tampilan = 'Camat ' . $cleanedOrgName;
                                                        } elseif (str_contains($orgNameLower, 'badan')) {
                                                            $cleanedOrgName = str_ireplace('badan ', '', $orgName);
                                                            $jabatan_tampilan = 'Kepala Badan ' . $cleanedOrgName;
                                                        } elseif (str_contains($orgNameLower, 'inspektorat')) {
                                                            $jabatan_tampilan = 'Kepala ' . $orgName . ' Kabupaten Sinjai';
                                                        } elseif (str_contains($orgNameLower, 'satuan polisi pamong praja dan pemadam kebakaran')) {
                                                            $jabatan_tampilan = 'Kepala ' . $orgName;
                                                        } elseif (str_contains($orgNameLower, 'rumah sakit umum daerah') || str_contains($orgNameLower, 'rsud')) {
                                                            $cleanedOrgName = str_ireplace(['pejabat ', 'kabupaten sinjai'], '', $orgNameLower);
                                                            $cleanedOrgName = ucwords($cleanedOrgName);
                                                            $jabatan_tampilan = 'Direktur ' . $cleanedOrgName . ' Sinjai';
                                                        } elseif (str_contains($orgNameLower, 'sekretariat dprd')) {
                                                            $jabatan_tampilan = 'Sekretaris DPRD (Sekwan) Kabupaten Sinjai';
                                                        }
                                                    }

                                                    if ($status_jabatan !== 'Definitif' && !empty($status_jabatan)) {
                                                        if (preg_match('/\((\w+)\)/', $status_jabatan, $matches)) {
                                                            $prefix = $matches[1];
                                                        } else {
                                                            $prefix = $status_jabatan;
                                                        }
                                                        $prefix = rtrim($prefix, '.');
                                                        $jabatan_tampilan = $prefix . '. ' . $jabatan_tampilan;
                                                    }
                                                @endphp
                                                <span class="px-4 py-1.5 bg-{{ $group['color'] }}-50 text-{{ $group['color'] }}-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-{{ $group['color'] }}-100 text-center">
                                                    {{ $jabatan_tampilan }}
                                                </span>
                                            </div>

                                            <!-- Bottom Section pushed to bottom -->
                                            <div class="mt-auto w-full">
                                                <div class="flex items-center justify-center text-gray-500 font-bold text-sm mb-6 bg-gray-50 px-5 py-2 rounded-2xl border border-gray-100 w-full">
                                                    <i class="fas fa-landmark mr-2 text-{{ $group['color'] }}-400 flex-shrink-0"></i>
                                                    <span class="truncate">{{ $official->organization->name ?? 'N/A' }}</span>
                                                </div>

                                                <div class="space-y-3 w-full">
                                                    @auth
                                                        @php
                                                            $canManage = false;
                                                            if ($user->isSuperAdmin()) {
                                                                $canManage = true;
                                                            } elseif (isset($api_unit_id) && isset($official->organization) && (string)$api_unit_id === (string)$official->organization->remote_id) {
                                                                $canManage = true;
                                                            } elseif (isset($official->organization) && (string)$user->unit_id === (string)$official->organization->remote_id) {
                                                                $canManage = true;
                                                            }
                                                        @endphp

                                                        @if ($canManage)
                                                            <a href="{{ route('pimpinan.edit-public', $official) }}" class="inline-flex items-center justify-center w-full bg-amber-500 text-white font-black text-xs py-4 rounded-2xl transition-all duration-500 uppercase tracking-widest gap-2 shadow-lg shadow-amber-100 hover:bg-amber-600">
                                                                <i class="fas fa-pencil-alt text-xs"></i> Kelola Pimpinan
                                                            </a>
                                                        @else
                                                            <a href="{{ route('official.profile.show', ['slug' => $official->slug ?? '']) }}" class="inline-flex items-center justify-center w-full bg-{{ $group['color'] }}-600 text-white font-black text-xs py-4 rounded-2xl transition-all duration-500 uppercase tracking-widest gap-2 shadow-lg shadow-{{ $group['color'] }}-100">
                                                                Profil Lengkap <i class="fas fa-arrow-right text-sm"></i>
                                                            </a>
                                                        @endif
                                                    @else
                                                        <a href="{{ route('official.profile.show', ['slug' => $official->slug ?? '']) }}" class="inline-flex items-center justify-center w-full bg-{{ $group['color'] }}-600 text-white font-black text-xs py-4 rounded-2xl transition-all duration-500 uppercase tracking-widest gap-2 shadow-lg shadow-{{ $group['color'] }}-100">
                                                            Profil Lengkap <i class="fas fa-arrow-right text-sm"></i>
                                                        </a>
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
