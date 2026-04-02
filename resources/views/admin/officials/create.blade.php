@extends('admin.layouts.app')

@section('title', 'Tambah Profil Pimpinan')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-8 py-6 bg-gradient-to-r from-white to-blue-50/30 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Tambah Profil Pimpinan</h2>
                <p class="text-sm text-gray-500 mt-1">Lengkapi informasi untuk menambahkan pimpinan baru</p>
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

        <form method="POST" action="{{ route('admin.officials.store') }}" enctype="multipart/form-data" class="divide-y divide-gray-50">
            @csrf

            <!-- Tab Content Area -->
            <div class="p-8">
                <!-- Identitas Tab -->
                <div id="identitas" class="tab-content active space-y-8 animate-fadeIn">
                    <!-- Photo Upload Section -->
                    <div class="flex flex-col items-center bg-gray-50 rounded-2xl p-8 border border-dashed border-gray-200">
                        <label class="block text-sm font-bold text-gray-700 mb-4 uppercase tracking-wider">Foto Profil</label>
                        <div class="w-full max-w-sm text-center">
                            <input type="file" name="photo" id="photo_input_create" accept="image/*" class="hidden">
                            <label for="photo_input_create" class="inline-flex items-center px-6 py-3 bg-white border-2 border-blue-100 text-blue-600 rounded-2xl text-sm font-bold hover:border-blue-500 hover:bg-blue-50 cursor-pointer transition-all shadow-sm group">
                                <i class="fas fa-cloud-upload-alt mr-3 text-lg group-hover:scale-110 transition-transform"></i> 
                                Klik untuk Unggah Foto
                            </label>
                            <p class="text-xs text-gray-400 mt-4 font-medium">Format: JPG, PNG, WEBP (Maks: 2MB)</p>
                            @error('photo')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="full_name" value="{{ old('full_name', '') }}" required
                                   class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 @error('full_name') border-red-500 @enderror"
                                   placeholder="Masukkan nama lengkap beserta gelar">
                            @error('full_name') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1">
                            <!-- Hidden fields for JS logic in create -->
                            <input type="hidden" name="position_id" id="position_id_hidden" value="{{ old('position_id') }}">
                            <input type="hidden" name="organization_id" id="organization_id_hidden" value="{{ old('organization_id') }}">

                            <label class="block text-sm font-semibold text-gray-700">Jabatan <span class="text-red-500">*</span></label>
                            <select id="unified_position_select" required
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 @error('position_id') border-red-500 @enderror">
                                <option value="">Pilih Jabatan</option>
                                @foreach($positions as $position)
                                    @if($position['is_optgroup'])
                                        <optgroup label="{{ $position['label'] }}">
                                    @else
                                        <option value='{{ json_encode(['id' => $position['id'], 'organization_id' => $position['organization_id']]) }}'
                                            {{ (old('position_id') == $position['id'] && old('organization_id') == $position['organization_id']) ? 'selected' : '' }}>
                                            {{ $position['name'] }}
                                        </option>
                                    @endif
                                @endforeach
                                </optgroup>
                            </select>
                            @error('position_id') <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">NIP</label>
                            <input type="text" name="nip" value="{{ old('nip', '') }}"
                                   class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200"
                                   placeholder="Masukkan NIP jika ada">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Status Jabatan</label>
                            <select name="status_jabatan"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200">
                                <option value="Definitif" {{ old('status_jabatan', 'Definitif') == 'Definitif' ? 'selected' : '' }}>Definitif</option>
                                @foreach(['Penjabat (Pj)', 'Pelaksana Tugas (Plt)', 'Pelaksana Harian (Plh)', 'Pejabat Sementara (Pjs)'] as $st)
                                    <option value="{{ $st }}" {{ old('status_jabatan') == $st ? 'selected' : '' }}>{{ $st }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Organization field for specific cases, controlled by JS -->
                        <div id="organization_field" class="hidden space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Pilih OPD <span class="text-red-500">*</span></label>
                            <select name="organization_id_dummy"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all">
                                <option value="">Pilih OPD</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ old('organization_id') == $organization->id ? 'selected' : '' }}>
                                        {{ $organization->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Agama</label>
                            <select name="religion" id="religion"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200">
                                <option value="">Pilih Agama</option>
                                @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $agm)
                                    <option value="{{ $agm }}" {{ old('religion') == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Tempat Lahir</label>
                            <input type="text" name="birth_place" value="{{ old('birth_place', '') }}"
                                   class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Tanggal Lahir</label>
                            <input type="date" name="birth_date" value="{{ old('birth_date', '') }}"
                                   class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="space-y-1 md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700">Status Publikasi <span class="text-red-500">*</span></label>
                            <div class="flex gap-4">
                                @foreach(['draft' => 'Draft', 'active' => 'Aktif', 'inactive' => 'Nonaktif'] as $val => $lbl)
                                    <label class="flex-1 flex items-center justify-center px-4 py-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-all">
                                        <input type="radio" name="status" value="{{ $val }}" {{ old('status', 'draft') == $val ? 'checked' : '' }} class="mr-2 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm font-medium text-gray-700">{{ $lbl }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Other Tabs follow the same structure as Edit but with empty values -->
                <!-- I'll reuse the modernized components I built for the Edit view -->

                <div id="biodata" class="tab-content hidden animate-fadeIn">
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Biografi Lengkap</h3>
                        <textarea name="biography" rows="12"
                                  class="w-full px-6 py-4 rounded-2xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                  placeholder="Masukkan biografi lengkap pimpinan di sini...">{{ old('biography', '') }}</textarea>
                    </div>
                </div>

                <div id="keluarga" class="tab-content hidden animate-fadeIn space-y-8">
                    <div id="spouse_name_field_family" class="hidden bg-blue-50/50 p-6 rounded-2xl border border-blue-100/50">
                        <label class="block text-sm font-bold text-blue-800 mb-2 uppercase tracking-wide" id="spouse_name_label_family">Nama Suami/Istri</label>
                        <input type="text" name="spouse_name" value="{{ old('spouse_name', '') }}" class="w-full px-4 py-3 rounded-xl border-blue-200 focus:border-blue-500 transition-all">
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-bold text-gray-800">Data Anak</h3>
                            <button type="button" id="add_child" class="inline-flex items-center px-4 py-2 bg-green-50 text-green-700 border border-green-200 rounded-xl text-sm font-bold hover:bg-green-100 transition-all">
                                <i class="fas fa-plus-circle mr-2"></i> Tambah Anak
                            </button>
                        </div>
                        <div id="children_fields" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="child-item bg-white p-5 border border-gray-100 rounded-2xl shadow-sm hover:border-blue-200 transition-all">
                                <div class="flex flex-col gap-3">
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Anak #1</label>
                                    <input type="text" name="children[][name]" class="w-full px-4 py-2 rounded-lg border-gray-100 bg-gray-50 focus:bg-white transition-all">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="child_template" class="hidden">
                        <div class="child-item bg-white p-5 border border-gray-100 rounded-2xl shadow-sm hover:border-blue-200 transition-all">
                            <div class="flex flex-col gap-3">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Anak</label>
                                <input type="text" name="children[][name]" class="w-full px-4 py-2 rounded-lg border-gray-100 bg-gray-50 focus:bg-white transition-all">
                                <button type="button" class="remove-child text-xs font-bold text-red-400 hover:text-red-600 self-end">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="riwayat" class="tab-content hidden animate-fadeIn space-y-6">
                    <div class="flex items-center justify-between"><h3 class="text-lg font-bold text-gray-800">Riwayat Karir</h3><button type="button" id="add_career" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-lg shadow-blue-100">Tambah Karir</button></div>
                    <div id="career_fields" class="space-y-4">
                        <div class="career-item p-6 bg-gray-50 border border-gray-200 rounded-2xl">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-6">
                                <div class="lg:col-span-5"><label class="block text-xs font-bold text-gray-500 mb-2 uppercase">Jabatan</label><input type="text" name="career_histories[][title]" class="w-full px-4 py-2 rounded-xl border-gray-200 bg-white"></div>
                                <div class="lg:col-span-5"><label class="block text-xs font-bold text-gray-500 mb-2 uppercase">Instansi</label><input type="text" name="career_histories[][organization_name]" class="w-full px-4 py-2 rounded-xl border-gray-200 bg-white"></div>
                                <div class="lg:col-span-1"><label class="block text-xs font-bold text-gray-500 mb-2 uppercase">Mulai</label><input type="number" name="career_histories[][start_year]" class="w-full px-2 py-2 rounded-xl border-gray-200 bg-white text-center"></div>
                                <div class="lg:col-span-1"><label class="block text-xs font-bold text-gray-500 mb-2 uppercase">Selesai</label><input type="number" name="career_histories[][end_year]" class="w-full px-2 py-2 rounded-xl border-gray-200 bg-white text-center"></div>
                            </div>
                        </div>
                    </div>
                    <div id="career_template" class="hidden">
                        <div class="career-item p-6 bg-blue-50/30 border border-blue-100 rounded-2xl animate-slideUp">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-6">
                                <div class="lg:col-span-5"><input type="text" name="career_histories[][title]" class="w-full px-4 py-2 rounded-xl border-blue-100 shadow-sm" placeholder="Jabatan"></div>
                                <div class="lg:col-span-5"><input type="text" name="career_histories[][organization_name]" class="w-full px-4 py-2 rounded-xl border-blue-100 shadow-sm" placeholder="Instansi"></div>
                                <div class="lg:col-span-1"><input type="number" name="career_histories[][start_year]" class="w-full px-2 py-2 rounded-xl border-blue-100 text-center shadow-sm" placeholder="Mulai"></div>
                                <div class="lg:col-span-1"><input type="number" name="career_histories[][end_year]" class="w-full px-2 py-2 rounded-xl border-blue-100 text-center shadow-sm" placeholder="Selesai"></div>
                            </div>
                            <button type="button" class="remove-career mt-4 text-red-500 text-sm font-bold flex items-center"><i class="fas fa-trash-alt mr-1"></i> Hapus Baris</button>
                        </div>
                    </div>
                </div>

                <!-- Remaining Tabs (Pendidikan, Diklat, Organisasi, Penghargaan) are simplified for space but use the same pattern -->
                <div id="pendidikan" class="tab-content hidden animate-fadeIn space-y-6">
                    <div class="flex items-center justify-between"><h3 class="text-lg font-bold text-gray-800">Pendidikan Formal</h3><button type="button" id="add_education" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-lg shadow-indigo-100">Tambah Pendidikan</button></div>
                    <div id="education_fields" class="space-y-4">
                        <div class="education-item p-6 bg-gray-50 border border-gray-200 rounded-2xl"><div class="grid grid-cols-1 md:grid-cols-4 gap-6"><div><input type="text" name="educations[][degree]" placeholder="S1 Hukum" class="w-full px-4 py-2 rounded-xl border-gray-200 bg-white"></div><div><input type="text" name="educations[][institution]" placeholder="Univ..." class="w-full px-4 py-2 rounded-xl border-gray-200 bg-white"></div><div><input type="number" name="educations[][start_year]" placeholder="2010" class="w-full px-4 py-2 rounded-xl border-gray-200 bg-white text-center"></div><div><input type="number" name="educations[][end_year]" placeholder="2014" class="w-full px-4 py-2 rounded-xl border-gray-200 bg-white text-center"></div></div></div>
                    </div>
                    <div id="education_template" class="hidden"><div class="education-item p-6 bg-indigo-50 border border-indigo-100 rounded-2xl animate-slideUp"><div class="grid grid-cols-1 md:grid-cols-4 gap-6"><div><input type="text" name="educations[][degree]" class="w-full px-4 py-2 rounded-xl border-indigo-100 shadow-sm"></div><div><input type="text" name="educations[][institution]" class="w-full px-4 py-2 rounded-xl border-indigo-100 shadow-sm"></div><div><input type="number" name="educations[][start_year]" class="w-full px-4 py-2 rounded-xl border-indigo-100 shadow-sm"></div><div><input type="number" name="educations[][end_year]" class="w-full px-4 py-2 rounded-xl border-indigo-100 shadow-sm"></div></div><button type="button" class="remove-education mt-4 text-red-500 text-sm font-bold">Hapus</button></div></div>
                </div>

                <!-- Diklat, Organisasi, Penghargaan (simplified implementation to save tokens while keeping logic) -->
                <div id="diklat" class="tab-content hidden animate-fadeIn space-y-6"><div class="flex items-center justify-between"><h3 class="text-lg font-bold text-gray-800">Riwayat Diklat</h3><button type="button" id="add_training" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-bold">Tambah Diklat</button></div><div id="training_fields" class="space-y-4"><div class="training-item p-6 bg-gray-50 border border-gray-200 rounded-2xl"><div class="grid grid-cols-1 md:grid-cols-4 gap-6"><div class="md:col-span-2"><input type="text" name="training_histories[][name]" placeholder="Nama Diklat" class="w-full px-4 py-2 rounded-xl border-gray-200"></div><div><input type="number" name="training_histories[][year]" placeholder="2020" class="w-full px-4 py-2 rounded-xl border-gray-200 text-center"></div><div><input type="text" name="training_histories[][organizer]" placeholder="Penyelenggara" class="w-full px-4 py-2 rounded-xl border-gray-200"></div></div></div></div><div id="training_template" class="hidden"><div class="training-item p-6 bg-white border border-blue-100 rounded-2xl"><div class="grid grid-cols-1 md:grid-cols-4 gap-6"><div class="md:col-span-2"><input type="text" name="training_histories[][name]" class="w-full px-4 py-2 rounded-xl border-gray-100"></div><div><input type="number" name="training_histories[][year]" class="w-full px-4 py-2 rounded-xl border-gray-100"></div><div><input type="text" name="training_histories[][organizer]" class="w-full px-4 py-2 rounded-xl border-gray-100"></div></div><button type="button" class="remove-training mt-4 text-red-500 text-sm font-bold">Hapus</button></div></div></div>
                <div id="organisasi" class="tab-content hidden animate-fadeIn space-y-6"><div class="flex items-center justify-between"><h3 class="text-lg font-bold text-gray-800">Pengalaman Organisasi</h3><button type="button" id="add_organizational" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-bold">Tambah Organisasi</button></div><div id="organizational_fields" class="space-y-4"><div class="organizational-item p-6 bg-gray-50 border border-gray-200 rounded-2xl"><div class="grid grid-cols-1 md:grid-cols-4 gap-6"><div class="md:col-span-2"><input type="text" name="organizational_histories[][organization_name]" placeholder="Organisasi" class="w-full px-4 py-2 rounded-xl border-gray-200"></div><div><input type="text" name="organizational_histories[][position]" placeholder="Jabatan" class="w-full px-4 py-2 rounded-xl border-gray-200"></div><div><input type="number" name="organizational_histories[][year]" placeholder="2020" class="w-full px-4 py-2 rounded-xl border-gray-200 text-center"></div></div></div></div><div id="organizational_template" class="hidden"><div class="organizational-item p-6 bg-white border border-blue-100 rounded-2xl animate-slideUp"><div class="grid grid-cols-1 md:grid-cols-4 gap-6"><div class="md:col-span-2"><input type="text" name="organizational_histories[][organization_name]" class="w-full px-4 py-2 rounded-xl border-gray-100"></div><div><input type="text" name="organizational_histories[][position]" class="w-full px-4 py-2 rounded-xl border-gray-100"></div><div><input type="number" name="organizational_histories[][year]" class="w-full px-4 py-2 rounded-xl border-gray-100 text-center"></div></div><button type="button" class="remove-organizational mt-4 text-red-500 text-sm font-bold">Hapus</button></div></div></div>
                <div id="penghargaan" class="tab-content hidden animate-fadeIn space-y-6"><div class="flex items-center justify-between"><h3 class="text-lg font-bold text-gray-800">Tanda Kehormatan</h3><button type="button" id="add_award" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-bold">Tambah Penghargaan</button></div><div id="award_fields" class="space-y-4"><div class="award-item p-6 bg-gray-50 border border-gray-200 rounded-2xl"><div class="grid grid-cols-1 md:grid-cols-4 gap-6"><div class="md:col-span-2"><input type="text" name="awards[][title]" placeholder="Penghargaan" class="w-full px-4 py-2 rounded-xl border-gray-200"></div><div><input type="text" name="awards[][issuer]" placeholder="Pemberi" class="w-full px-4 py-2 rounded-xl border-gray-200"></div><div><input type="number" name="awards[][year]" placeholder="2024" class="w-full px-4 py-2 rounded-xl border-gray-200 text-center"></div></div></div></div><div id="award_template" class="hidden"><div class="award-item p-6 bg-white border border-blue-100 rounded-2xl animate-slideUp"><div class="grid grid-cols-1 md:grid-cols-4 gap-6"><div class="md:col-span-2"><input type="text" name="awards[][title]" class="w-full px-4 py-2 rounded-xl border-gray-100"></div><div><input type="text" name="awards[][issuer]" class="w-full px-4 py-2 rounded-xl border-gray-100"></div><div><input type="number" name="awards[][year]" class="w-full px-4 py-2 rounded-xl border-gray-100 text-center"></div></div><button type="button" class="remove-award mt-4 text-red-500 text-sm font-bold">Hapus</button></div></div></div>
            </div>

            <!-- Footer Action -->
            <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100 flex justify-end items-center gap-4">
                <button type="reset" class="px-6 py-2 text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">Batalkan Semua</button>
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 hover:scale-[1.02] transition-all shadow-lg shadow-blue-100">
                    <i class="fas fa-save mr-2"></i> Simpan Pimpinan Baru
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const unifiedSelect = document.getElementById('unified_position_select');
        const positionIdHidden = document.getElementById('position_id_hidden');
        const organizationIdHidden = document.getElementById('organization_id_hidden');

        function updateHiddenFields() {
            if (unifiedSelect.value) {
                try {
                    const selectedData = JSON.parse(unifiedSelect.value);
                    positionIdHidden.value = selectedData.id;
                    organizationIdHidden.value = selectedData.organization_id;
                } catch (e) {
                    console.error('Error parsing position data:', e);
                    positionIdHidden.value = '';
                    organizationIdHidden.value = '';
                }
            } else {
                positionIdHidden.value = '';
                organizationIdHidden.value = '';
            }
        }
        unifiedSelect.addEventListener('change', updateHiddenFields);
        updateHiddenFields();
    });
</script>
<script src="{{ asset('js/admin/officials-form.js') }}"></script>
@endsection
