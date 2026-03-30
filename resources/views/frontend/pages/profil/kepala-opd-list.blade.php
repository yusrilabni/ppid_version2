@extends('frontend.layouts.app')

@section('content')
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs Aligned with Content -->
            <div class="mb-4">
                <x-breadcrumbs :breadcrumbs="[
                    ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                    ['title' => 'Pejabat Daerah', 'url' => '#', 'icon' => 'fas fa-users']
                ]" />
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden p-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Daftar Pejabat Daerah</h1>

                @if($kepalaOpds->isEmpty())
                    <p class="text-gray-600 text-center">Tidak ada Pimpinan OPD yang ditemukan.</p>
                @else
                    <div class="space-y-16">
                        @php
                            $groups = [
                                ['id' => 'eselon2', 'title' => 'Eselon II (Kepala Badan/Dinas/Inspektorat)', 'items' => $kepalaOpds->get('eselon2', collect()), 'color' => 'blue', 'icon' => 'fas fa-building'],
                                ['id' => 'eselon3', 'title' => 'Eselon III (Camat)', 'items' => $kepalaOpds->get('eselon3', collect()), 'color' => 'green', 'icon' => 'fas fa-map-marked-alt'],
                            ];
                        @endphp

                        @foreach($groups as $group)
                            @if($group['items']->isNotEmpty())
                                <section>
                                    <div class="flex items-center mb-8">
                                        <div class="w-12 h-12 bg-{{ $group['color'] }}-600 rounded-2xl shadow-lg flex items-center justify-center text-white mr-4">
                                            <i class="{{ $group['icon'] }} text-xl"></i>
                                        </div>
                                        <div>
                                            <h2 class="text-2xl font-black text-gray-900">{{ $group['title'] }}</h2>
                                            <p class="text-gray-500 text-sm">Pemerintah Kabupaten Sinjai</p>
                                        </div>
                                        <div class="h-px flex-1 bg-gray-200 mx-8 hidden lg:block"></div>
                                        <span class="px-4 py-1.5 bg-{{ $group['color'] }}-50 text-{{ $group['color'] }}-700 text-sm font-bold rounded-full border border-{{ $group['color'] }}-100">
                                            {{ $group['items']->count() }} Pejabat
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                        @foreach($group['items'] as $official)
                                            <div class="bg-white rounded-3xl shadow-md hover:shadow-2xl border border-gray-100 overflow-hidden flex flex-col transition-all duration-500 hover:-translate-y-2 group">
                                                <div class="p-8 pb-6 flex flex-col items-center text-center flex-grow">
                                                    <div class="relative mb-6">
                                                        <div class="absolute inset-0 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-full blur-lg opacity-20 group-hover:opacity-40 transition-opacity"></div>
                                                        @if($official->photo)
                                                            <img src="{{ asset('storage/' . $official->photo) }}"
                                                                 alt="{{ $official->full_name }}"
                                                                 class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-xl relative z-10">
                                                        @else
                                                            <div class="w-28 h-28 rounded-full bg-gradient-to-br from-gray-50 to-gray-100 border-4 border-white shadow-xl flex items-center justify-center text-gray-300 text-4xl relative z-10">
                                                                <i class="fas fa-user"></i>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <a href="{{ route('official.profile.show', ['slug' => $official->slug ?? '']) }}" class="text-xl font-black text-gray-900 mb-2 hover:text-blue-600 transition-colors">
                                                        {{ $official->full_name }}
                                                    </a>
                                                    
                                                    <p class="text-sm font-bold text-gray-500 mb-4 italic">
                                                        @php
                                                            $jabatan_asli = $official->position->name; 
                                                            $jabatan_tampilan = $jabatan_asli;
                                                            $status_jabatan = $official->status_jabatan;

                                                            if ($status_jabatan !== 'Definitif' && !empty($status_jabatan)) {
                                                                preg_match('/\((\w+)\)/', $status_jabatan, $matches);
                                                                $prefix = $matches[1] ?? '';
                                                                if (!empty($prefix)) {
                                                                    $jabatan_tampilan = trim($prefix) . '. ' . $jabatan_tampilan;
                                                                }
                                                            }

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
                                                        @endphp
                                                        {{ $jabatan_tampilan }}
                                                    </p>

                                                    <div class="inline-flex items-center px-3 py-1 bg-gray-50 rounded-full text-[10px] font-bold text-gray-400 uppercase tracking-tighter border border-gray-100">
                                                        <i class="fas fa-landmark mr-1.5 text-{{ $group['color'] }}-400"></i>
                                                        {{ $official->organization->name ?? 'N/A' }}
                                                    </div>
                                                </div>

                                                @auth
                                                    @if (isset($api_unit_id) && isset($official->organization) && $api_unit_id == $official->organization->remote_id)
                                                        <div class="px-6 pb-8 pt-4 border-t border-gray-50">
                                                            <a href="{{ route('pimpinan.edit-public', $official) }}" class="w-full flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl transition-all duration-300 shadow-lg shadow-blue-200 group-hover:shadow-blue-300">
                                                                <i class="fas fa-pencil-alt mr-2"></i>
                                                                <span class="font-bold">Kelola Pimpinan</span>
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
