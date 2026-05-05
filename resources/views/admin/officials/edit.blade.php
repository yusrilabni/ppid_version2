@extends('admin.layouts.app')

@section('title', 'Edit Profil Pimpinan')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-8 py-6 bg-gradient-to-r from-white to-blue-50/30 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Edit Profil Pimpinan</h2>
                <p class="text-sm text-gray-500 mt-1">Perbarui informasi lengkap pimpinan badan publik</p>
            </div>
            <a href="{{ route('admin.officials.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition-all duration-200 shadow-sm">
                <i class="fas fa-arrow-left mr-2 text-xs"></i> Kembali
            </a>
        </div>

        <!-- Tabs Navigation -->
        <div class="bg-white border-b border-gray-100 sticky top-0 z-10 overflow-x-auto no-scrollbar">
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
                        class="tab-button flex items-center px-6 py-5 text-sm font-medium transition-all duration-200 border-b-2 {{ $tab['id'] === 'identitas' ? 'active text-blue-600 border-blue-600 bg-blue-50/30' : 'text-gray-500 border-transparent hover:text-blue-500 hover:bg-gray-50' }}" 
                        data-tab="{{ $tab['id'] }}">
                        <i class="fas fa-{{ $tab['icon'] }} mr-2 text-base"></i>
                        {{ $tab['label'] }}
                    </button>
                @endforeach
            </nav>
        </div>

        <form method="POST" action="{{ route('admin.officials.update', $official->id) }}" enctype="multipart/form-data" class="divide-y divide-gray-50">
            @csrf
            @method('PUT')

            <!-- Tab Content Area -->
            <div class="p-8">
                <!-- Identitas Tab -->
                <div id="identitas" class="tab-content active space-y-8 animate-fadeIn">
                    <!-- Profile Photo Section -->
                    <div class="flex flex-col items-center bg-gray-50 rounded-2xl p-8 border border-dashed border-gray-200">
                        <label class="block text-sm font-bold text-gray-700 mb-4 uppercase tracking-wider">Foto Profil</label>
                        <div class="relative group">
                            <div class="w-40 h-40 rounded-2xl overflow-hidden border-4 border-white shadow-lg group-hover:shadow-xl transition-all duration-300">
                                @if($official->photo)
                                    <img src="{{ asset('storage/' . $official->photo) }}" alt="Foto Profil" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-user text-5xl text-blue-300"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-2xl cursor-pointer">
                                <i class="fas fa-camera text-white text-2xl"></i>
                            </div>
                        </div>
                        
                        <div class="mt-6 w-full max-w-sm text-center">
                            <input type="file" name="photo" id="photo_input" accept="image/*" class="hidden">
                            <label for="photo_input" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 cursor-pointer transition-colors shadow-sm">
                                <i class="fas fa-upload mr-2"></i> Pilih Foto Baru
                            </label>
                            <p class="text-xs text-gray-400 mt-3 font-medium italic">Format: JPG, PNG, WEBP. Maks: 2MB</p>
                            @error('photo')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="full_name" value="{{ old('full_name', $official->full_name) }}" required
                                   class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 @error('full_name') border-red-500 @enderror"
                                   placeholder="Contoh: Dr. H. Ahmad Fauzi, M.Si">
                            @error('full_name') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Jabatan Utama <span class="text-red-500">*</span></label>
                            @php
                                $posOptions = $positions->map(fn($p) => ['value' => $p->id, 'label' => $p->name])->toArray();
                            @endphp
                            <x-custom-select name="position_id" id="position_id" :options="$posOptions" :value="old('position_id', $official->position_id)" placeholder="Pilih Jabatan" :required="true" />
                            @error('position_id') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">NIP</label>
                            <input type="text" name="nip" value="{{ old('nip', $official->nip) }}"
                                   class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200"
                                   placeholder="19XXXXXXXXXXXXXX">
                            @error('nip') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Status Jabatan</label>
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

                        <div id="organization_field" class="{{ (old('position_id', $official->position_id) && ($positions->firstWhere('id', old('position_id', $official->position_id))->name ?? '') === 'Kepala OPD') ? '' : 'hidden' }} space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">OPD / Organisasi <span class="text-red-500">*</span></label>
                            @php
                                $orgOptions = $organizations->map(fn($o) => ['value' => $o->id, 'label' => $o->name])->toArray();
                            @endphp
                            <x-custom-select name="organization_id" id="organization_id" :options="$orgOptions" :value="old('organization_id', $official->organization_id)" placeholder="Pilih OPD" />
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Agama</label>
                            @php
                                $agamaOptions = collect(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'])->map(fn($a) => ['value' => $a, 'label' => $a])->toArray();
                            @endphp
                            <x-custom-select name="religion" id="religion" :options="$agamaOptions" :value="old('religion', $official->religion)" placeholder="Pilih Agama" />
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Tempat Lahir</label>
                            <input type="text" name="birth_place" value="{{ old('birth_place', $official->birth_place) }}"
                                   class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Tanggal Lahir</label>
                            <input type="date" name="birth_date" value="{{ old('birth_date', $official->birth_date ? $official->birth_date->format('Y-m-d') : '') }}"
                                   class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Status Pernikahan</label>
                            @php
                                $maritalOptions = collect(['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati'])->map(fn($m) => ['value' => $m, 'label' => $m])->toArray();
                            @endphp
                            <x-custom-select name="marital_status" id="marital_status" :options="$maritalOptions" :value="old('marital_status', $official->marital_status)" placeholder="Pilih Status" />
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Jenis Kelamin</label>
                            @php
                                $genderOptions = [['value' => 'Laki-laki', 'label' => 'Laki-laki'], ['value' => 'Perempuan', 'label' => 'Perempuan']];
                            @endphp
                            <x-custom-select name="jenis_kelamin" id="jenis_kelamin" :options="$genderOptions" :value="old('jenis_kelamin', $official->jenis_kelamin)" placeholder="Pilih Jenis Kelamin" />
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $official->email) }}"
                                   class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200"
                                   placeholder="nama@email.com">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Alamat Rumah</label>
                            <textarea name="home_address" rows="1"
                                      class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 min-h-[50px]">{{ old('home_address', $official->home_address) }}</textarea>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Mulai Masa Jabatan</label>
                            <input type="date" name="start_term" value="{{ old('start_term', $official->start_term ? $official->start_term->format('Y-m-d') : '') }}"
                                   class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Akhir Masa Jabatan</label>
                            <input type="date" name="end_term" value="{{ old('end_term', $official->end_term ? $official->end_term->format('Y-m-d') : '') }}"
                                   class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200">
                        </div>

                        <div class="space-y-1 md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700">Status Aktif Pimpinan <span class="text-red-500">*</span></label>
                            <div class="flex gap-4">
                                @foreach(['active' => 'Aktif', 'inactive' => 'Nonaktif', 'draft' => 'Draft'] as $val => $lbl)
                                    <label class="flex-1 flex items-center justify-center px-4 py-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-all peer-checked:bg-blue-50 peer-checked:border-blue-200">
                                        <input type="radio" name="status" value="{{ $val }}" {{ old('status', $official->status) == $val ? 'checked' : '' }} class="mr-2 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm font-medium text-gray-700">{{ $lbl }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Biodata & Biografi Tab -->
                <div id="biodata" class="tab-content hidden animate-fadeIn">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Biografi & Riwayat Hidup</h3>
                            <span class="text-xs font-medium text-blue-600 bg-blue-50 px-3 py-1 rounded-full uppercase tracking-wider">Rich Text Editor</span>
                        </div>
                        <textarea name="biography" rows="12"
                                  class="w-full px-6 py-4 rounded-2xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 text-gray-700 leading-relaxed"
                                  placeholder="Tuliskan biografi lengkap pimpinan di sini...">{{ old('biography', $official->biography) }}</textarea>
                        @error('biography') <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Keluarga Tab -->
                <div id="keluarga" class="tab-content hidden animate-fadeIn space-y-8">
                    <div id="spouse_name_field_family" class="hidden bg-blue-50/50 p-6 rounded-2xl border border-blue-100/50">
                        <label id="spouse_name_label_family" class="block text-sm font-bold text-blue-800 mb-2 uppercase tracking-wide">
                            Nama Suami/Istri
                        </label>
                        <input type="text" name="spouse_name" value="{{ old('spouse_name', $official->spouse_name) }}"
                               class="w-full px-4 py-3 rounded-xl border-blue-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                               placeholder="Masukkan nama pasangan">
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-bold text-gray-800">Data Anak</h3>
                            <button type="button" id="add_child" class="inline-flex items-center px-4 py-2 bg-green-50 text-green-700 border border-green-200 rounded-xl text-sm font-bold hover:bg-green-100 transition-all">
                                <i class="fas fa-plus-circle mr-2"></i> Tambah Anak
                            </button>
                        </div>
                        
                        <div id="children_fields" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($official->children ?? collect() as $index => $child)
                                <div class="child-item group bg-white p-5 border border-gray-100 rounded-2xl shadow-sm hover:border-blue-200 transition-all relative overflow-hidden">
                                    <div class="flex flex-col gap-3">
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Anak #{{ $index + 1 }}</label>
                                        <input type="text" name="children[{{ $index }}][name]" value="{{ $child->name }}" 
                                               class="w-full px-4 py-2 rounded-lg border-gray-100 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring focus:ring-blue-100 transition-all">
                                        <button type="button" class="remove-child text-xs font-bold text-red-400 hover:text-red-600 self-end transition-colors flex items-center">
                                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="child-item group bg-white p-5 border border-gray-100 rounded-2xl shadow-sm hover:border-blue-200 transition-all relative overflow-hidden">
                                    <div class="flex flex-col gap-3">
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Anak #1</label>
                                        <input type="text" name="children[0][name]" value="" placeholder="Masukkan nama anak"
                                               class="w-full px-4 py-2 rounded-lg border-gray-100 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring focus:ring-blue-100 transition-all">
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Child Template -->
                    <div id="child_template" class="hidden">
                        <div class="child-item group bg-white p-5 border border-gray-100 rounded-2xl shadow-sm hover:border-blue-200 transition-all">
                            <div class="flex flex-col gap-3">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Anak Baru</label>
                                <input type="text" name="children[][name]" placeholder="Nama anak baru"
                                       class="w-full px-4 py-2 rounded-lg border-gray-100 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring focus:ring-blue-100 transition-all">
                                <button type="button" class="remove-child text-xs font-bold text-red-400 hover:text-red-600 self-end transition-colors flex items-center">
                                    <i class="fas fa-trash-alt mr-1"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Karir Tab -->
                <div id="riwayat" class="tab-content hidden animate-fadeIn space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-800">Pengalaman Jabatan & Karir</h3>
                        <button type="button" id="add_career" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 transition-all shadow-md shadow-blue-100">
                            <i class="fas fa-plus-circle mr-2"></i> Tambah Karir
                        </button>
                    </div>

                    <div id="career_fields" class="space-y-4">
                        @forelse($official->careerHistories as $index => $career)
                            <div class="career-item p-6 bg-gray-50 border border-gray-200 rounded-2xl transition-all hover:bg-white hover:shadow-md group">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-6">
                                    <div class="lg:col-span-5">
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jabatan</label>
                                        <input type="text" name="career_histories[{{ $index }}][title]" value="{{ $career->title }}"
                                               class="w-full px-4 py-2 rounded-xl border-gray-200 bg-white">
                                    </div>
                                    <div class="lg:col-span-5">
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Instansi/OPD</label>
                                        <input type="text" name="career_histories[{{ $index }}][organization_name]" value="{{ $career->organization_name }}"
                                               class="w-full px-4 py-2 rounded-xl border-gray-200 bg-white">
                                    </div>
                                    <div class="lg:col-span-1">
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Mulai</label>
                                        <input type="number" name="career_histories[{{ $index }}][start_year]" value="{{ $career->start_year }}"
                                               class="w-full px-2 py-2 rounded-xl border-gray-200 bg-white text-center">
                                    </div>
                                    <div class="lg:col-span-1">
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Selesai</label>
                                        <input type="number" name="career_histories[{{ $index }}][end_year]" value="{{ $career->end_year }}"
                                               class="w-full px-2 py-2 rounded-xl border-gray-200 bg-white text-center">
                                    </div>
                                </div>
                                <div class="mt-4 flex justify-between items-center">
                                    <input type="text" name="career_histories[{{ $index }}][description]" value="{{ $career->description }}" placeholder="Keterangan tambahan..."
                                           class="w-full max-w-2xl px-4 py-2 rounded-xl border-gray-100 bg-white/50 italic text-sm">
                                    <button type="button" class="remove-career text-red-500 hover:text-red-700 font-bold text-sm ml-4 whitespace-nowrap">
                                        <i class="fas fa-trash-alt mr-1"></i> Hapus Baris
                                    </button>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>

                    <div id="career_template" class="hidden">
                        <div class="career-item p-6 bg-blue-50/30 border border-blue-100 rounded-2xl transition-all animate-slideUp group">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-6">
                                <div class="lg:col-span-5">
                                    <label class="block text-xs font-bold text-blue-600/60 uppercase mb-2">Jabatan Baru</label>
                                    <input type="text" name="career_histories[][title]" class="w-full px-4 py-2 rounded-xl border-blue-100">
                                </div>
                                <div class="lg:col-span-5">
                                    <label class="block text-xs font-bold text-blue-600/60 uppercase mb-2">Instansi/OPD</label>
                                    <input type="text" name="career_histories[][organization_name]" class="w-full px-4 py-2 rounded-xl border-blue-100">
                                </div>
                                <div class="lg:col-span-1">
                                    <label class="block text-xs font-bold text-blue-600/60 uppercase mb-2">Mulai</label>
                                    <input type="number" name="career_histories[][start_year]" class="w-full px-2 py-2 rounded-xl border-blue-100 text-center">
                                </div>
                                <div class="lg:col-span-1">
                                    <label class="block text-xs font-bold text-blue-600/60 uppercase mb-2">Selesai</label>
                                    <input type="number" name="career_histories[][end_year]" class="w-full px-2 py-2 rounded-xl border-blue-100 text-center">
                                </div>
                            </div>
                            <button type="button" class="remove-career mt-4 text-red-500 hover:text-red-700 font-bold text-sm flex items-center">
                                <i class="fas fa-trash-alt mr-1"></i> Batalkan & Hapus
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Pendidikan Tab -->
                <div id="pendidikan" class="tab-content hidden animate-fadeIn space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-800">Riwayat Pendidikan Formal</h3>
                        <button type="button" id="add_education" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all shadow-md shadow-indigo-100">
                            <i class="fas fa-plus-circle mr-2"></i> Tambah Pendidikan
                        </button>
                    </div>

                    <div id="education_fields" class="space-y-4">
                        @forelse($official->educations as $index => $education)
                            <div class="education-item p-6 bg-gray-50 border border-gray-200 rounded-2xl transition-all hover:bg-white hover:shadow-md">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jenjang</label>
                                        <input type="text" name="educations[{{ $index }}][degree]" value="{{ $education->degree }}" placeholder="S1 Hukum"
                                               class="w-full px-4 py-2 rounded-xl border-gray-200">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Institusi</label>
                                        <input type="text" name="educations[{{ $index }}][institution]" value="{{ $education->institution }}"
                                               class="w-full px-4 py-2 rounded-xl border-gray-200">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Tahun Mulai</label>
                                        <input type="number" name="educations[{{ $index }}][start_year]" value="{{ $education->start_year }}"
                                               class="w-full px-4 py-2 rounded-xl border-gray-200">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Tahun Lulus</label>
                                        <input type="number" name="educations[{{ $index }}][end_year]" value="{{ $education->end_year }}"
                                               class="w-full px-4 py-2 rounded-xl border-gray-200">
                                    </div>
                                </div>
                                <button type="button" class="remove-education mt-4 text-red-500 hover:text-red-700 font-bold text-sm">Hapus</button>
                            </div>
                        @empty
                        @endforelse
                    </div>

                    <div id="education_template" class="hidden">
                        <div class="education-item p-6 bg-indigo-50/30 border border-indigo-100 rounded-2xl animate-slideUp">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div><input type="text" name="educations[][degree]" placeholder="S1 / S2 / S3" class="w-full px-4 py-2 rounded-xl border-indigo-100"></div>
                                <div><input type="text" name="educations[][institution]" placeholder="Nama Universitas" class="w-full px-4 py-2 rounded-xl border-indigo-100"></div>
                                <div><input type="number" name="educations[][start_year]" placeholder="Mulai" class="w-full px-4 py-2 rounded-xl border-indigo-100"></div>
                                <div><input type="number" name="educations[][end_year]" placeholder="Lulus" class="w-full px-4 py-2 rounded-xl border-indigo-100"></div>
                            </div>
                            <button type="button" class="remove-education mt-4 text-red-500 hover:text-red-700 font-bold text-sm">Hapus</button>
                        </div>
                    </div>
                </div>

                <div id="diklat" class="tab-content hidden animate-fadeIn space-y-6">
                    <div class="flex items-center justify-between"><h3 class="text-lg font-bold text-gray-800">Riwayat Diklat & Kursus</h3><button type="button" id="add_training" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-lg shadow-blue-100">Tambah Diklat</button></div>
                    <div id="training_fields" class="space-y-4">
                        @forelse($official->trainingHistories as $index => $training)
                            <div class="training-item p-6 bg-gray-50 border border-gray-200 rounded-2xl">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                    <div class="md:col-span-2"><label class="block text-xs font-bold text-gray-400 mb-2">Nama Diklat</label><input type="text" name="training_histories[{{ $index }}][name]" value="{{ $training->name }}" class="w-full px-4 py-2 rounded-xl border-gray-100"></div>
                                    <div><label class="block text-xs font-bold text-gray-400 mb-2">Tahun</label><input type="number" name="training_histories[{{ $index }}][year]" value="{{ $training->year }}" class="w-full px-4 py-2 rounded-xl border-gray-100 text-center"></div>
                                    <div><label class="block text-xs font-bold text-gray-400 mb-2">Penyelenggara</label><input type="text" name="training_histories[{{ $index }}][organizer]" value="{{ $training->organizer }}" class="w-full px-4 py-2 rounded-xl border-gray-100"></div>
                                </div>
                                <button type="button" class="remove-training mt-4 text-red-500 text-sm font-bold">Hapus</button>
                            </div>
                        @empty @endforelse
                    </div>
                    <div id="training_template" class="hidden"><div class="training-item p-6 bg-gray-50 border border-gray-200 rounded-2xl"><div class="grid grid-cols-1 md:grid-cols-4 gap-6"><div class="md:col-span-2"><input type="text" name="training_histories[][name]" class="w-full px-4 py-2 rounded-xl border-gray-100"></div><div><input type="number" name="training_histories[][year]" class="w-full px-4 py-2 rounded-xl border-gray-100 text-center"></div><div><input type="text" name="training_histories[][organizer]" class="w-full px-4 py-2 rounded-xl border-gray-100"></div></div><button type="button" class="remove-training mt-4 text-red-500 text-sm font-bold">Hapus</button></div></div>
                </div>

                <div id="organisasi" class="tab-content hidden animate-fadeIn space-y-6">
                    <div class="flex items-center justify-between"><h3 class="text-lg font-bold text-gray-800">Riwayat Organisasi</h3><button type="button" id="add_organizational" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-lg shadow-blue-100">Tambah Organisasi</button></div>
                    <div id="organizational_fields" class="space-y-4">
                        @forelse($official->organizationalHistories as $index => $org)
                            <div class="organizational-item p-6 bg-gray-50 border border-gray-200 rounded-2xl">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                    <div class="md:col-span-2"><label class="block text-xs font-bold text-gray-400 mb-2">Nama Organisasi</label><input type="text" name="organizational_histories[{{ $index }}][organization_name]" value="{{ $org->organization_name }}" class="w-full px-4 py-2 rounded-xl border-gray-100"></div>
                                    <div><label class="block text-xs font-bold text-gray-400 mb-2">Jabatan</label><input type="text" name="organizational_histories[{{ $index }}][position]" value="{{ $org->position }}" class="w-full px-4 py-2 rounded-xl border-gray-100"></div>
                                    <div><label class="block text-xs font-bold text-gray-400 mb-2">Tahun</label><input type="number" name="organizational_histories[{{ $index }}][year]" value="{{ $org->year }}" class="w-full px-4 py-2 rounded-xl border-gray-100 text-center"></div>
                                </div>
                                <button type="button" class="remove-organizational mt-4 text-red-500 text-sm font-bold">Hapus</button>
                            </div>
                        @empty @endforelse
                    </div>
                    <div id="organizational_template" class="hidden"><div class="organizational-item p-6 bg-gray-50 border border-gray-200 rounded-2xl"><div class="grid grid-cols-1 md:grid-cols-4 gap-6"><div class="md:col-span-2"><input type="text" name="organizational_histories[][organization_name]" class="w-full px-4 py-2 rounded-xl border-gray-100"></div><div><input type="text" name="organizational_histories[][position]" class="w-full px-4 py-2 rounded-xl border-gray-100"></div><div><input type="number" name="organizational_histories[][year]" class="w-full px-4 py-2 rounded-xl border-gray-100 text-center"></div></div><button type="button" class="remove-organizational mt-4 text-red-500 text-sm font-bold">Hapus</button></div></div>
                </div>

                <div id="penghargaan" class="tab-content hidden animate-fadeIn space-y-6">
                    <div class="flex items-center justify-between"><h3 class="text-lg font-bold text-gray-800">Tanda Kehormatan & Penghargaan</h3><button type="button" id="add_award" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-lg shadow-blue-100">Tambah Penghargaan</button></div>
                    <div id="award_fields" class="space-y-4">
                        @forelse($official->awards as $index => $award)
                            <div class="award-item p-6 bg-gray-50 border border-gray-200 rounded-2xl transition-all">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                    <div class="md:col-span-2"><label class="block text-xs font-bold text-gray-400 mb-2">Nama Penghargaan</label><input type="text" name="awards[{{ $index }}][title]" value="{{ $award->title }}" class="w-full px-4 py-2 rounded-xl border-gray-100 shadow-sm"></div>
                                    <div><label class="block text-xs font-bold text-gray-400 mb-2">Instansi Pemberi</label><input type="text" name="awards[{{ $index }}][issuer]" value="{{ $award->issuer }}" class="w-full px-4 py-2 rounded-xl border-gray-100 shadow-sm"></div>
                                    <div><label class="block text-xs font-bold text-gray-400 mb-2">Tahun</label><input type="number" name="awards[{{ $index }}][year]" value="{{ $award->year }}" class="w-full px-4 py-2 rounded-xl border-gray-100 shadow-sm text-center"></div>
                                </div>
                                <div class="mt-4"><label class="block text-xs font-bold text-gray-400 mb-2">Keterangan Singkat</label><input type="text" name="awards[{{ $index }}][description]" value="{{ $award->description }}" class="w-full px-4 py-2 rounded-xl border-gray-50 bg-white/50 italic"></div>
                                <button type="button" class="remove-award mt-4 text-red-500 text-sm font-bold hover:underline">Hapus Data Ini</button>
                            </div>
                        @empty @endforelse
                    </div>
                    <div id="award_template" class="hidden"><div class="award-item p-6 bg-white border border-blue-100 rounded-2xl"><div class="grid grid-cols-1 md:grid-cols-4 gap-6"><div class="md:col-span-2"><input type="text" name="awards[][title]" class="w-full px-4 py-2 rounded-xl border-gray-100 shadow-sm"></div><div><input type="text" name="awards[][issuer]" class="w-full px-4 py-2 rounded-xl border-gray-100 shadow-sm"></div><div><input type="number" name="awards[][year]" class="w-full px-4 py-2 rounded-xl border-gray-100 shadow-sm text-center"></div></div><div class="mt-4"><input type="text" name="awards[][description]" class="w-full px-4 py-2 rounded-xl border-gray-50 bg-white/50 italic"></div><button type="button" class="remove-award mt-4 text-red-500 text-sm font-bold">Hapus</button></div></div>
                </div>
            </div>

            <!-- Footer Action -->
            <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100 flex justify-end items-center gap-4">
                <button type="reset" class="px-6 py-2 text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">Reset Form</button>
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 hover:scale-[1.02] transition-all shadow-lg shadow-blue-100">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    .tab-content { transition: opacity 0.3s ease-in-out; }
    .animate-fadeIn { animation: fadeIn 0.4s ease-out; }
    .animate-slideUp { animation: slideUp 0.3s ease-out; }
    
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .tab-button.active { @apply text-blue-600 border-blue-600 bg-blue-50/50; }
</style>

<script src="{{ asset('js/admin/officials-form.js') }}"></script>
@endsection
