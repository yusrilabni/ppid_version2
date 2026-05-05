@extends('frontend.layouts.app')

@section('title', 'Edit Profil Pimpinan')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => 'Pejabat Daerah', 'url' => route('official.pejabat-daerah'), 'icon' => 'fas fa-users'],
            ['title' => 'Kelola Profil Pimpinan', 'url' => '#', 'icon' => 'fas fa-user-edit'],
        ]" />

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mt-6">
            <!-- Header -->
            <div class="px-8 py-8 bg-gradient-to-r from-blue-600 to-indigo-700 text-white flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-black uppercase tracking-tight">Kelola Profil Pimpinan</h2>
                    <p class="text-blue-100 mt-1 font-medium italic opacity-80 text-sm">Perbarui informasi lengkap profil pimpinan badan publik secara mandiri</p>
                </div>
                <a href="{{ route('official.pejabat-daerah') }}" class="hidden md:inline-flex items-center px-6 py-3 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl text-xs font-black uppercase tracking-widest text-white hover:bg-white hover:text-blue-600 transition-all duration-300 shadow-lg">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            <!-- Tabs Navigation -->
            <div class="bg-white border-b border-gray-100 sticky top-0 z-10 overflow-x-auto no-scrollbar shadow-sm">
                <nav class="flex px-4 min-w-max">
                    @php
                        $tabs = [
                            ['id' => 'identitas', 'label' => 'Identitas', 'icon' => 'user-circle'],
                            ['id' => 'biodata', 'label' => 'Biodata', 'icon' => 'address-card'],
                            ['id' => 'keluarga', 'label' => 'Keluarga', 'icon' => 'users'],
                            ['id' => 'riwayat', 'label' => 'Karir', 'icon' => 'briefcase'],
                            ['id' => 'pendidikan', 'label' => 'Pendidikan', 'icon' => 'graduation-cap'],
                            ['id' => 'diklat', 'label' => 'Diklat', 'icon' => 'chalkboard-teacher'],
                            ['id' => 'organisasi', 'label' => 'Organisasi', 'icon' => 'sitemap'],
                            ['id' => 'penghargaan', 'label' => 'Penghargaan', 'icon' => 'trophy'],
                        ];
                    @endphp
                    @foreach($tabs as $tab)
                        <button type="button" 
                            class="tab-button flex items-center px-8 py-5 text-[10px] font-black uppercase tracking-widest transition-all duration-300 border-b-4 {{ $tab['id'] === 'identitas' ? 'active text-blue-600 border-blue-600 bg-blue-50/20' : 'text-gray-400 border-transparent hover:text-blue-500 hover:bg-gray-50' }}" 
                            data-tab="{{ $tab['id'] }}">
                            <i class="fas fa-{{ $tab['icon'] }} mr-3 text-lg"></i>
                            {{ $tab['label'] }}
                        </button>
                    @endforeach
                </nav>
            </div>

            <form method="POST" action="{{ route('pimpinan.update-public', $official->id) }}" enctype="multipart/form-data" class="divide-y divide-gray-50">
                @csrf
                @method('PUT')

                <!-- Tab Content Area -->
                <div class="p-8 md:p-12">
                    <!-- Identitas Tab -->
                    <div id="identitas" class="tab-content active space-y-10 animate-fadeIn">
                        <!-- Profile Photo Section -->
                        <div class="flex flex-col items-center bg-gray-50/50 rounded-[2.5rem] p-10 border-2 border-dashed border-gray-100 group hover:border-blue-200 transition-all">
                            <label class="block text-[11px] font-black text-gray-400 mb-6 uppercase tracking-[0.2em]">Pas Foto Pejabat</label>
                            <div class="relative">
                                <div class="w-48 h-48 rounded-[2rem] overflow-hidden border-8 border-white shadow-2xl group-hover:shadow-blue-200 transition-all duration-500">
                                    @if($official->photo)
                                        <img src="{{ asset('storage/' . $official->photo) }}" alt="Foto Profil" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-gray-50 to-blue-50 flex items-center justify-center">
                                            <i class="fas fa-user text-6xl text-blue-200"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="absolute -bottom-2 -right-2 bg-blue-600 w-12 h-12 rounded-2xl flex items-center justify-center text-white shadow-lg border-4 border-white">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                            
                            <div class="mt-8 w-full max-w-sm text-center">
                                <input type="file" name="photo" id="photo_input" accept="image/*" class="hidden">
                                <label for="photo_input" class="inline-flex items-center px-8 py-3.5 bg-blue-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-blue-700 cursor-pointer transition-all shadow-xl shadow-blue-100 hover:scale-[1.02]">
                                    <i class="fas fa-cloud-upload-alt mr-2"></i> Pilih Foto Terbaru
                                </label>
                                <p class="text-[10px] text-gray-400 mt-4 font-bold uppercase tracking-tight opacity-60 italic">Format: JPG, PNG, WEBP (Maks: 2MB)</p>
                                @error('photo')
                                    <p class="mt-2 text-sm text-red-500 font-bold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest ml-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="full_name" value="{{ old('full_name', $official->full_name) }}" required
                                       class="w-full px-6 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50/30 shadow-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-gray-800"
                                       placeholder="Nama Lengkap & Gelar">
                                @error('full_name') <p class="mt-1 text-xs text-red-500 font-bold ml-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest ml-1">Jabatan <span class="text-red-500">*</span></label>
                                @php
                                    $posOptions = $positions->map(fn($p) => ['value' => $p->id, 'label' => $p->name])->toArray();
                                @endphp
                                <x-custom-select name="position_id" id="position_id" :options="$posOptions" :value="old('position_id', $official->position_id)" placeholder="Pilih Jabatan" :required="true" />
                                @error('position_id') <p class="mt-1 text-xs text-red-500 font-bold ml-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest ml-1">NIP</label>
                                <input type="text" name="nip" value="{{ old('nip', $official->nip) }}"
                                       class="w-full px-6 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50/30 shadow-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-gray-800"
                                       placeholder="Kosongkan jika tidak ada">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest ml-1">Status Jabatan</label>
                                @php
                                    $statusJabatanOptions = [
                                        ['value' => 'Definitif', 'label' => 'Definitif'],
                                        ['value' => 'Penjabat (Pj)', 'label' => 'Penjabat (Pj)'],
                                        ['value' => 'Pelaksana Tugas (Plt)', 'label' => 'Pelaksana Tugas (Plt)'],
                                        ['value' => 'Pelaksana Harian (Plh)', 'label' => 'Pelaksana Harian (Plh)'],
                                        ['value' => 'Pejabat Sementara (Pjs)', 'label' => 'Pejabat Sementara (Pjs)'],
                                    ];
                                @endphp
                                <x-custom-select name="status_jabatan" id="status_jabatan" :options="$statusJabatanOptions" :value="old('status_jabatan', $official->status_jabatan)" placeholder="Pilih Status Jabatan" />
                            </div>

                            <div id="organization_field" class="{{ (old('position_id', $official->position_id) && ($positions->firstWhere('id', old('position_id', $official->position_id))->name ?? '') === 'Kepala OPD') ? '' : 'hidden' }} space-y-2">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest ml-1">Unit Kerja / OPD <span class="text-red-500">*</span></label>
                                @php
                                    $orgOptions = $organizations->map(fn($o) => ['value' => $o->id, 'label' => $o->name])->toArray();
                                @endphp
                                <x-custom-select name="organization_id" id="organization_id" :options="$orgOptions" :value="old('organization_id', $official->organization_id)" placeholder="Pilih OPD" />
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest ml-1">Agama</label>
                                @php
                                    $agamaOptions = collect(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'])->map(fn($a) => ['value' => $a, 'label' => $a])->toArray();
                                @endphp
                                <x-custom-select name="religion" id="religion" :options="$agamaOptions" :value="old('religion', $official->religion)" placeholder="Pilih Agama" />
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest ml-1">Tempat Lahir</label>
                                <input type="text" name="birth_place" value="{{ old('birth_place', $official->birth_place) }}"
                                       class="w-full px-6 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50/30 shadow-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-gray-800">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest ml-1">Tanggal Lahir</label>
                                <input type="date" name="birth_date" value="{{ old('birth_date', $official->birth_date ? $official->birth_date->format('Y-m-d') : '') }}"
                                       class="w-full px-6 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50/30 shadow-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-gray-800">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest ml-1">Status Pernikahan</label>
                                @php
                                    $maritalOptions = collect(['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati'])->map(fn($m) => ['value' => $m, 'label' => $m])->toArray();
                                @endphp
                                <x-custom-select name="marital_status" id="marital_status" :options="$maritalOptions" :value="old('marital_status', $official->marital_status)" placeholder="Pilih Status" />
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest ml-1">Jenis Kelamin</label>
                                @php
                                    $genderOptions = [['value' => 'Laki-laki', 'label' => 'Laki-laki'], ['value' => 'Perempuan', 'label' => 'Perempuan']];
                                @endphp
                                <x-custom-select name="jenis_kelamin" id="jenis_kelamin" :options="$genderOptions" :value="old('jenis_kelamin', $official->jenis_kelamin)" placeholder="Pilih Jenis Kelamin" />
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest ml-1">Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', $official->email) }}"
                                       class="w-full px-6 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50/30 shadow-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-gray-800">
                            </div>

                            <div class="space-y-2 md:col-span-2">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest ml-1">Alamat Rumah</label>
                                <textarea name="home_address" rows="2"
                                          class="w-full px-6 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50/30 shadow-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-gray-800 min-h-[100px]">{{ old('home_address', $official->home_address) }}</textarea>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest ml-1">Mulai Masa Jabatan</label>
                                <input type="date" name="start_term" value="{{ old('start_term', $official->start_term ? $official->start_term->format('Y-m-d') : '') }}"
                                       class="w-full px-6 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50/30 shadow-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-gray-800">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest ml-1">Akhir Masa Jabatan</label>
                                <input type="date" name="end_term" value="{{ old('end_term', $official->end_term ? $official->end_term->format('Y-m-d') : '') }}"
                                       class="w-full px-6 py-4 rounded-2xl border-2 border-gray-50 bg-gray-50/30 shadow-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-gray-800">
                            </div>

                            <div class="space-y-2 md:col-span-2">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest ml-1">Status Publikasi <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-3 gap-4">
                                    @foreach(['active' => 'Aktif', 'inactive' => 'Nonaktif', 'draft' => 'Draft'] as $val => $lbl)
                                        <label class="flex items-center justify-center px-6 py-4 border-2 border-gray-50 rounded-2xl cursor-pointer hover:bg-gray-50 transition-all group relative overflow-hidden shadow-sm">
                                            <input type="radio" name="status" value="{{ $val }}" {{ old('status', $official->status) == $val ? 'checked' : '' }} class="sr-only peer">
                                            <div class="absolute inset-0 bg-blue-600 scale-0 peer-checked:scale-100 transition-transform duration-300 origin-center"></div>
                                            <span class="relative z-10 text-[10px] font-black uppercase tracking-widest text-gray-400 peer-checked:text-white transition-colors">{{ $lbl }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Biodata & Biografi Tab -->
                    <div id="biodata" class="tab-content hidden animate-fadeIn space-y-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xl font-black text-gray-800 uppercase tracking-tight">Biografi & Riwayat Hidup</h3>
                            <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-4 py-2 rounded-xl uppercase tracking-widest border border-blue-100/50">Lengkapi Profil Anda</span>
                        </div>
                        <textarea name="biography" rows="15"
                                  class="w-full px-8 py-6 rounded-[2rem] border-2 border-gray-50 bg-gray-50/30 shadow-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all text-gray-700 leading-relaxed font-medium"
                                  placeholder="Tuliskan biografi lengkap pimpinan di sini...">{{ old('biography', $official->biography) }}</textarea>
                        @error('biography') <p class="mt-1 text-sm text-red-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Keluarga Tab -->
                    <div id="keluarga" class="tab-content hidden animate-fadeIn space-y-10">
                        <div id="spouse_name_field_family" class="hidden bg-gradient-to-br from-blue-50/50 to-indigo-50/50 p-8 rounded-[2rem] border border-blue-100/50 shadow-sm">
                            <label id="spouse_name_label_family" class="block text-[11px] font-black text-blue-900/60 mb-4 uppercase tracking-[0.2em] ml-2">
                                Nama Suami/Istri
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-6 flex items-center text-blue-400">
                                    <i class="fas fa-heart"></i>
                                </span>
                                <input type="text" name="spouse_name" value="{{ old('spouse_name', $official->spouse_name) }}"
                                       class="w-full pl-14 pr-6 py-4 rounded-2xl border-none shadow-xl shadow-blue-900/5 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-gray-800"
                                       placeholder="Masukkan nama lengkap pasangan">
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-black text-gray-800 uppercase tracking-tight">Data Anak</h3>
                                <button type="button" id="add_child" class="inline-flex items-center px-6 py-3 bg-green-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-green-600 transition-all shadow-lg shadow-green-100 hover:scale-[1.02]">
                                    <i class="fas fa-plus-circle mr-2 text-sm"></i> Tambah Anak
                                </button>
                            </div>
                            
                            <div id="children_fields" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @forelse($official->children ?? collect() as $index => $child)
                                    <div class="child-item group bg-white p-6 border border-gray-100 rounded-[1.5rem] shadow-sm hover:border-blue-300 hover:shadow-xl hover:shadow-blue-900/5 transition-all relative overflow-hidden">
                                        <div class="flex flex-col gap-4">
                                            <div class="flex items-center justify-between">
                                                <span class="text-[9px] font-black text-gray-300 uppercase tracking-widest">Anak #{{ $index + 1 }}</span>
                                                <button type="button" class="remove-child text-gray-300 hover:text-red-500 transition-colors">
                                                    <i class="fas fa-times-circle text-lg"></i>
                                                </button>
                                            </div>
                                            <input type="text" name="children[{{ $index }}][name]" value="{{ $child->name }}" 
                                                   class="w-full px-4 py-3 rounded-xl border-gray-50 bg-gray-50/50 focus:bg-white focus:border-blue-500 transition-all font-bold text-gray-700">
                                        </div>
                                    </div>
                                @empty
                                    <!-- Empty state handled by template/initial row if needed -->
                                @endforelse
                            </div>
                        </div>

                        <div id="child_template" class="hidden">
                            <div class="child-item group bg-white p-6 border-2 border-dashed border-gray-100 rounded-[1.5rem] shadow-sm hover:border-blue-300 transition-all animate-slideUp">
                                <div class="flex flex-col gap-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[9px] font-black text-blue-400 uppercase tracking-widest">Anak Baru</span>
                                        <button type="button" class="remove-child text-red-400 hover:text-red-600">
                                            <i class="fas fa-times-circle text-lg"></i>
                                        </button>
                                    </div>
                                    <input type="text" name="children[][name]" placeholder="Nama lengkap anak..."
                                           class="w-full px-4 py-3 rounded-xl border-gray-50 bg-gray-50/50 focus:bg-white focus:border-blue-500 transition-all font-bold">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Karir Tab -->
                    <div id="riwayat" class="tab-content hidden animate-fadeIn space-y-8">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-black text-gray-800 uppercase tracking-tight">Pengalaman Karir</h3>
                            <button type="button" id="add_career" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-100 hover:scale-[1.02]">
                                <i class="fas fa-plus-circle mr-2 text-sm"></i> Tambah Karir
                            </button>
                        </div>

                        <div id="career_fields" class="space-y-4">
                            @forelse($official->careerHistories as $index => $career)
                                <div class="career-item p-8 bg-white border border-gray-100 rounded-[2rem] shadow-sm hover:shadow-xl hover:shadow-blue-900/5 transition-all group">
                                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                                        <div class="lg:col-span-5 space-y-2">
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Jabatan / Posisi</label>
                                            <input type="text" name="career_histories[{{ $index }}][title]" value="{{ $career->title }}" class="w-full px-5 py-3.5 rounded-xl border-gray-50 bg-gray-50/50 focus:bg-white focus:border-blue-500 transition-all font-bold text-gray-800">
                                        </div>
                                        <div class="lg:col-span-4 space-y-2">
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Instansi / Unit Kerja</label>
                                            <input type="text" name="career_histories[{{ $index }}][organization_name]" value="{{ $career->organization_name }}" class="w-full px-5 py-3.5 rounded-xl border-gray-50 bg-gray-50/50 focus:bg-white focus:border-blue-500 transition-all font-bold text-gray-800">
                                        </div>
                                        <div class="lg:col-span-3 grid grid-cols-2 gap-4">
                                            <div class="space-y-2">
                                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Tahun Mulai</label>
                                                <input type="number" name="career_histories[{{ $index }}][start_year]" value="{{ $career->start_year }}" class="w-full px-2 py-3.5 rounded-xl border-gray-50 bg-gray-50/50 focus:bg-white focus:border-blue-500 transition-all font-bold text-gray-800 text-center">
                                            </div>
                                            <div class="space-y-2">
                                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Tahun Selesai</label>
                                                <input type="number" name="career_histories[{{ $index }}][end_year]" value="{{ $career->end_year }}" class="w-full px-2 py-3.5 rounded-xl border-gray-50 bg-gray-50/50 focus:bg-white focus:border-blue-500 transition-all font-bold text-gray-800 text-center">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-6 pt-6 border-t border-gray-50 flex justify-between items-center">
                                        <input type="text" name="career_histories[{{ $index }}][description]" value="{{ $career->description }}" placeholder="Keterangan tambahan (opsional)..." class="flex-1 px-4 py-2 text-sm italic text-gray-500 border-none bg-transparent focus:ring-0">
                                        <button type="button" class="remove-career px-4 py-2 text-red-400 hover:text-red-600 text-[10px] font-black uppercase tracking-widest transition-colors"><i class="fas fa-trash-alt mr-2"></i> Hapus</button>
                                    </div>
                                </div>
                            @empty @endforelse
                        </div>

                        <div id="career_template" class="hidden">
                            <div class="career-item p-8 bg-blue-50/20 border-2 border-dashed border-blue-100 rounded-[2.5rem] animate-slideUp">
                                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                                    <div class="lg:col-span-5"><input type="text" name="career_histories[][title]" placeholder="Jabatan Baru..." class="w-full px-5 py-3.5 rounded-xl border-blue-50 shadow-sm font-bold"></div>
                                    <div class="lg:col-span-4"><input type="text" name="career_histories[][organization_name]" placeholder="Nama Instansi..." class="w-full px-5 py-3.5 rounded-xl border-blue-50 shadow-sm font-bold"></div>
                                    <div class="lg:col-span-3 grid grid-cols-2 gap-4">
                                        <input type="number" name="career_histories[][start_year]" placeholder="Mulai" class="w-full py-3.5 rounded-xl border-blue-50 shadow-sm font-bold text-center">
                                        <input type="number" name="career_histories[][end_year]" placeholder="Selesai" class="w-full py-3.5 rounded-xl border-blue-50 shadow-sm font-bold text-center">
                                    </div>
                                </div>
                                <button type="button" class="remove-career mt-6 text-red-500 text-[10px] font-black uppercase tracking-widest"><i class="fas fa-trash-alt mr-2"></i> Batalkan</button>
                            </div>
                        </div>
                    </div>

                    <!-- Pendidikan Tab -->
                    <div id="pendidikan" class="tab-content hidden animate-fadeIn space-y-8">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-black text-gray-800 uppercase tracking-tight">Riwayat Pendidikan</h3>
                            <button type="button" id="add_education" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg">Tambah Pendidikan</button>
                        </div>
                        <div id="education_fields" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @forelse($official->educations as $index => $education)
                                <div class="education-item p-6 bg-white border border-gray-100 rounded-[1.5rem] shadow-sm hover:shadow-xl transition-all">
                                    <div class="space-y-4">
                                        <div class="flex justify-between items-start">
                                            <span class="text-[9px] font-black text-blue-500 uppercase tracking-widest bg-blue-50 px-3 py-1 rounded-lg">Pendidikan #{{ $index + 1 }}</span>
                                            <button type="button" class="remove-education text-gray-300 hover:text-red-500"><i class="fas fa-times-circle text-lg"></i></button>
                                        </div>
                                        <div class="space-y-3">
                                            <input type="text" name="educations[{{ $index }}][degree]" value="{{ $education->degree }}" placeholder="Jenjang (S1 / S2)" class="w-full px-4 py-3 rounded-xl border-gray-50 bg-gray-50/50 font-bold text-gray-800">
                                            <input type="text" name="educations[{{ $index }}][institution]" value="{{ $education->institution }}" placeholder="Nama Sekolah / Kampus" class="w-full px-4 py-3 rounded-xl border-gray-50 bg-gray-50/50 font-bold text-gray-800">
                                            <div class="grid grid-cols-2 gap-4">
                                                <input type="number" name="educations[{{ $index }}][start_year]" value="{{ $education->start_year }}" placeholder="Masuk" class="w-full py-3 rounded-xl border-gray-50 bg-gray-50/50 font-bold text-center">
                                                <input type="number" name="educations[{{ $index }}][end_year]" value="{{ $education->end_year }}" placeholder="Lulus" class="w-full py-3 rounded-xl border-gray-50 bg-gray-50/50 font-bold text-center">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty @endforelse
                        </div>
                        <div id="education_template" class="hidden">
                            <div class="education-item p-6 bg-indigo-50/30 border-2 border-dashed border-indigo-100 rounded-[1.5rem] animate-slideUp">
                                <div class="space-y-4">
                                    <button type="button" class="remove-education float-right text-red-400"><i class="fas fa-times-circle text-lg"></i></button>
                                    <div class="space-y-3 pt-4">
                                        <input type="text" name="educations[][degree]" placeholder="Jenjang Pendidikan Baru..." class="w-full px-4 py-3 rounded-xl border-none shadow-sm font-bold">
                                        <input type="text" name="educations[][institution]" placeholder="Nama Institusi..." class="w-full px-4 py-3 rounded-xl border-none shadow-sm font-bold">
                                        <div class="grid grid-cols-2 gap-4">
                                            <input type="number" name="educations[][start_year]" placeholder="Tahun Masuk" class="w-full py-3 rounded-xl border-none shadow-sm font-bold text-center">
                                            <input type="number" name="educations[][end_year]" placeholder="Tahun Lulus" class="w-full py-3 rounded-xl border-none shadow-sm font-bold text-center">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Diklat, Organisasi, Penghargaan (Compact Styles) -->
                    <div id="diklat" class="tab-content hidden animate-fadeIn space-y-6">
                        <div class="flex items-center justify-between"><h3 class="text-xl font-black text-gray-800 uppercase tracking-tight">Data Diklat</h3><button type="button" id="add_training" class="bg-blue-600 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg">Tambah Diklat</button></div>
                        <div id="training_fields" class="space-y-4">
                            @forelse($official->trainingHistories as $index => $training)
                                <div class="training-item p-6 bg-white border border-gray-100 rounded-3xl shadow-sm hover:shadow-xl transition-all">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                        <div class="md:col-span-2 space-y-2"><label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">Nama Diklat</label><input type="text" name="training_histories[{{ $index }}][name]" value="{{ $training->name }}" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-none font-bold"></div>
                                        <div class="space-y-2"><label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1 text-center block">Tahun</label><input type="number" name="training_histories[{{ $index }}][year]" value="{{ $training->year }}" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-none font-bold text-center"></div>
                                        <div class="space-y-2"><label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">Penyelenggara</label><input type="text" name="training_histories[{{ $index }}][organizer]" value="{{ $training->organizer }}" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-none font-bold"></div>
                                    </div>
                                    <button type="button" class="remove-training mt-4 text-red-400 hover:text-red-600 text-[10px] font-black uppercase tracking-widest"><i class="fas fa-trash-alt mr-1"></i> Hapus</button>
                                </div>
                            @empty @endforelse
                        </div>
                        <div id="training_template" class="hidden"><div class="training-item p-6 bg-blue-50/20 border-2 border-dashed border-blue-100 rounded-3xl"><div class="grid grid-cols-1 md:grid-cols-4 gap-6"><div class="md:col-span-2"><input type="text" name="training_histories[][name]" placeholder="Nama Diklat Baru..." class="w-full px-4 py-3 rounded-xl border-none shadow-sm font-bold"></div><div><input type="number" name="training_histories[][year]" placeholder="Tahun" class="w-full px-4 py-3 rounded-xl border-none shadow-sm font-bold text-center"></div><div><input type="text" name="training_histories[][organizer]" placeholder="Penyelenggara..." class="w-full px-4 py-3 rounded-xl border-none shadow-sm font-bold"></div></div><button type="button" class="remove-training mt-4 text-red-500 text-[10px] font-black uppercase tracking-widest">Batalkan</button></div></div>
                    </div>

                    <div id="organisasi" class="tab-content hidden animate-fadeIn space-y-6">
                        <div class="flex items-center justify-between"><h3 class="text-xl font-black text-gray-800 uppercase tracking-tight">Data Organisasi</h3><button type="button" id="add_organizational" class="bg-blue-600 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg">Tambah Organisasi</button></div>
                        <div id="organizational_fields" class="space-y-4">
                            @forelse($official->organizationalHistories as $index => $org)
                                <div class="organizational-item p-6 bg-white border border-gray-100 rounded-3xl shadow-sm hover:shadow-xl transition-all">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                        <div class="md:col-span-2 space-y-2"><label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">Nama Organisasi</label><input type="text" name="organizational_histories[{{ $index }}][organization_name]" value="{{ $org->organization_name }}" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-none font-bold"></div>
                                        <div class="space-y-2"><label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">Jabatan</label><input type="text" name="organizational_histories[{{ $index }}][position]" value="{{ $org->position }}" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-none font-bold"></div>
                                        <div class="space-y-2"><label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1 text-center block">Tahun</label><input type="number" name="organizational_histories[{{ $index }}][year]" value="{{ $org->year }}" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-none font-bold text-center"></div>
                                    </div>
                                    <button type="button" class="remove-organizational mt-4 text-red-400 hover:text-red-600 text-[10px] font-black uppercase tracking-widest"><i class="fas fa-trash-alt mr-1"></i> Hapus</button>
                                </div>
                            @empty @endforelse
                        </div>
                        <div id="organizational_template" class="hidden"><div class="organizational-item p-6 bg-blue-50/20 border-2 border-dashed border-blue-100 rounded-3xl"><div class="grid grid-cols-1 md:grid-cols-4 gap-6"><div class="md:col-span-2"><input type="text" name="organizational_histories[][organization_name]" placeholder="Nama Organisasi..." class="w-full px-4 py-3 rounded-xl border-none shadow-sm font-bold"></div><div><input type="text" name="organizational_histories[][position]" placeholder="Jabatan..." class="w-full px-4 py-3 rounded-xl border-none shadow-sm font-bold"></div><div><input type="number" name="organizational_histories[][year]" placeholder="Tahun" class="w-full px-4 py-3 rounded-xl border-none shadow-sm font-bold text-center"></div></div><button type="button" class="remove-organizational mt-4 text-red-500 text-[10px] font-black uppercase tracking-widest">Batalkan</button></div></div>
                    </div>

                    <div id="penghargaan" class="tab-content hidden animate-fadeIn space-y-6">
                        <div class="flex items-center justify-between"><h3 class="text-xl font-black text-gray-800 uppercase tracking-tight">Tanda Kehormatan</h3><button type="button" id="add_award" class="bg-blue-600 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg">Tambah Penghargaan</button></div>
                        <div id="award_fields" class="space-y-4">
                            @forelse($official->awards as $index => $award)
                                <div class="award-item p-8 bg-white border border-gray-100 rounded-[2rem] shadow-sm group hover:shadow-xl transition-all">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                                        <div class="md:col-span-2 space-y-2"><label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">Nama Penghargaan</label><input type="text" name="awards[{{ $index }}][title]" value="{{ $award->title }}" class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-none font-bold text-gray-800"></div>
                                        <div class="space-y-2"><label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">Pemberi</label><input type="text" name="awards[{{ $index }}][issuer]" value="{{ $award->issuer }}" class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-none font-bold text-gray-800"></div>
                                        <div class="space-y-2"><label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1 text-center block">Tahun</label><input type="number" name="awards[{{ $index }}][year]" value="{{ $award->year }}" class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-none font-bold text-gray-800 text-center"></div>
                                    </div>
                                    <div class="mt-6 pt-6 border-t border-gray-50 flex justify-between items-center">
                                        <input type="text" name="awards[{{ $index }}][description]" value="{{ $award->description }}" placeholder="Keterangan penghargaan..." class="flex-1 px-4 py-2 italic text-gray-400 border-none bg-transparent focus:ring-0">
                                        <button type="button" class="remove-award px-4 py-2 text-red-400 hover:text-red-600 text-[10px] font-black uppercase tracking-widest"><i class="fas fa-trash-alt mr-2"></i> Hapus Data</button>
                                    </div>
                                </div>
                            @empty @endforelse
                        </div>
                        <div id="award_template" class="hidden"><div class="award-item p-8 bg-blue-50/20 border-2 border-dashed border-blue-100 rounded-[2rem]"><div class="grid grid-cols-1 md:grid-cols-4 gap-8"><div class="md:col-span-2"><input type="text" name="awards[][title]" placeholder="Penghargaan Baru..." class="w-full px-5 py-4 rounded-2xl border-none shadow-sm font-bold"></div><div><input type="text" name="awards[][issuer]" placeholder="Instansi..." class="w-full px-5 py-4 rounded-2xl border-none shadow-sm font-bold"></div><div><input type="number" name="awards[][year]" placeholder="Tahun" class="w-full px-5 py-4 rounded-2xl border-none shadow-sm font-bold text-center"></div></div><button type="button" class="remove-award mt-4 text-red-500 text-[10px] font-black uppercase tracking-widest">Batalkan</button></div></div>
                    </div>
                </div>

                <!-- Footer Action -->
                <div class="px-8 py-10 bg-gray-50 border-t border-gray-100 flex justify-end items-center gap-6">
                    <button type="reset" class="px-8 py-3 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-red-500 transition-colors">Reset Semua Input</button>
                    <button type="submit" class="px-12 py-4 bg-blue-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-[0.2em] hover:bg-blue-700 hover:scale-[1.02] active:scale-95 transition-all shadow-2xl shadow-blue-600/20">
                        <i class="fas fa-save mr-3"></i> Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    .tab-content { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
    .animate-fadeIn { animation: fadeIn 0.5s ease-out; }
    .animate-slideUp { animation: slideUp 0.4s ease-out; }
    
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    
    .tab-button.active { @apply text-blue-600 border-blue-600 bg-blue-50/20 shadow-inner; }
    
    /* Input & Select Focus States */
    input:focus, select:focus, textarea:focus {
        outline: none;
    }
</style>

<script src="{{ asset('js/admin/officials-form.js') }}?v={{ time() }}"></script>
@endsection
