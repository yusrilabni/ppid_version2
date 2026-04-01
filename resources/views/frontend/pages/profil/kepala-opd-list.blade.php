@extends('frontend.layouts.app')

@section('content')
    <div class="py-4 md:py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs Aligned with Content -->
            <div class="mb-4">
                <x-breadcrumbs :breadcrumbs="[
                    ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                    ['title' => 'Pejabat Daerah', 'url' => '#', 'icon' => 'fas fa-users']
                ]" />
            </div>

            <div class="bg-white rounded-2xl md:rounded-xl shadow-lg overflow-hidden p-4 md:p-6">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 md:mb-8 text-center">Daftar Pejabat Daerah</h1>

                @if($kepalaOpds->isEmpty())
                    <p class="text-gray-600 text-center py-12">Tidak ada Pimpinan OPD yang ditemukan.</p>
                @else
                    <div class="space-y-10 md:space-y-16">
                        @php
                            $groups = [
                                ['id' => 'eselon2', 'title' => 'Eselon II', 'subtitle' => 'Kepala Badan/Dinas/Inspektorat', 'items' => $kepalaOpds->get('eselon2', collect()), 'color' => 'blue', 'icon' => 'fas fa-building'],
                                ['id' => 'eselon3', 'title' => 'Eselon III', 'subtitle' => 'Camat', 'items' => $kepalaOpds->get('eselon3', collect()), 'color' => 'green', 'icon' => 'fas fa-map-marked-alt'],
                            ];
                        @endphp

                        @foreach($groups as $group)
                            @if($group['items']->isNotEmpty())
                                <section>
                                    <div class="flex flex-col md:flex-row md:items-center mb-6 md:mb-8">
                                        <div class="flex items-center mb-4 md:mb-0">
                                            <div class="w-10 h-10 md:w-12 md:h-12 bg-{{ $group['color'] }}-600 rounded-xl md:rounded-2xl shadow-lg flex items-center justify-center text-white mr-3 md:mr-4">
                                                <i class="{{ $group['icon'] }} text-lg md:text-xl"></i>
                                            </div>
                                            <div>
                                                <h2 class="text-xl md:text-2xl font-black text-gray-900 leading-tight">{{ $group['title'] }}</h2>
                                                <p class="text-gray-500 text-[10px] md:text-sm uppercase tracking-wider font-bold">{{ $group['subtitle'] }}</p>
                                            </div>
                                        </div>
                                        <div class="h-px flex-1 bg-gray-200 md:mx-8 hidden lg:block"></div>
                                        <div class="flex items-center">
                                            <span class="px-4 py-1 bg-{{ $group['color'] }}-50 text-{{ $group['color'] }}-700 text-[10px] md:text-sm font-bold rounded-full border border-{{ $group['color'] }}-100 whitespace-nowrap">
                                                {{ $group['items']->count() }} Pejabat
                                            </span>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8">
                                        @foreach($group['items'] as $official)
                                            <div class="bg-white rounded-[2rem] md:rounded-3xl shadow-md hover:shadow-2xl border border-gray-100 overflow-hidden flex flex-col transition-all duration-500 hover:-translate-y-1 md:hover:-translate-y-2 group">
                                                <div class="p-6 md:p-8 pb-6 flex flex-col items-center text-center flex-grow">
                                                    <div class="relative mb-4 md:mb-6">
                                                        <div class="absolute inset-0 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-full blur-lg opacity-10 md:opacity-20 group-hover:opacity-40 transition-opacity"></div>
                                                        @if($official->photo)
                                                            <img src="{{ asset('storage/' . $official->photo) }}"
                                                                 alt="{{ $official->full_name }}"
                                                                 class="w-24 h-24 md:w-28 md:h-28 rounded-full object-cover border-4 border-white shadow-xl relative z-10">
                                                        @else
                                                            <div class="w-24 h-24 md:w-28 md:h-28 rounded-full bg-gradient-to-br from-gray-50 to-gray-100 border-4 border-white shadow-xl flex items-center justify-center text-gray-300 text-3xl md:text-4xl relative z-10">
                                                                <i class="fas fa-user"></i>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <a href="{{ route('official.profile.show', ['slug' => $official->slug ?? '']) }}" class="text-lg md:text-xl font-black text-gray-900 mb-1 md:mb-2 hover:text-blue-600 transition-colors line-clamp-2 min-h-[3.5rem] md:min-h-0">
                                                        {{ $official->full_name }}
                                                    </a>
                                                    
                                                    <p class="text-[11px] md:text-sm font-bold text-gray-500 mb-3 md:mb-4 italic leading-relaxed">
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
                                                        {{ $jabatan_tampilan }}
                                                    </p>

                                                    <div class="inline-flex items-center px-3 py-1 bg-gray-50 rounded-full text-[9px] md:text-[10px] font-bold text-gray-400 uppercase tracking-tighter border border-gray-100 max-w-full">
                                                        <i class="fas fa-landmark mr-1.5 text-{{ $group['color'] }}-400 flex-shrink-0"></i>
                                                        <span class="truncate">{{ $official->organization->name ?? 'N/A' }}</span>
                                                    </div>
                                                </div>

                                                @auth
                                                    @php
                                                        $canManage = false;
                                                        // Strictly match unit even for Superadmins
                                                        if (isset($api_unit_id) && isset($official->organization) && (string)$api_unit_id === (string)$official->organization->remote_id) {
                                                            $canManage = true;
                                                        } elseif (isset($official->organization) && (string)$user->unit_id === (string)$official->organization->remote_id) {
                                                            $canManage = true;
                                                        }
                                                    @endphp

                                                    @if ($canManage)
                                                        <div class="px-6 pb-6 md:pb-8 pt-2 md:pt-4 border-t border-gray-50">
                                                            <a href="{{ route('pimpinan.edit-public', $official) }}" class="w-full flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-4 md:px-6 py-2.5 md:py-3 rounded-xl md:rounded-2xl transition-all duration-300 shadow-lg shadow-blue-200 group-hover:shadow-blue-300 text-sm md:text-base font-bold">
                                                                <i class="fas fa-pencil-alt mr-2 text-xs md:text-sm"></i>
                                                                <span>Kelola Pimpinan</span>
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endauth
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
    </div>
@endsection
