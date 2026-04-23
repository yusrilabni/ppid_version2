@extends('frontend.layouts.app')

@section('title', 'Kelola Profil Pimpinan')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <x-breadcrumbs :breadcrumbs="[
            ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['title' => 'Pejabat Daerah', 'url' => route('official.pejabat-daerah'), 'icon' => 'fas fa-users'],
            ['title' => 'Kelola Profil Pimpinan', 'url' => request()->fullUrl(), 'icon' => 'fas fa-user-edit'],
        ]" />
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 text-white flex items-center">
                <div>
                    <h1 class="text-2xl font-bold">Kelola Profil Pimpinan</h1>
                    <p class="text-blue-100 mt-1">Perbarui informasi profil pimpinan Anda</p>
                </div>
            </div>

            <!-- Tabs -->
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px flex-wrap">
                    <button type="button" class="tab-button active px-4 py-4 text-sm font-medium text-blue-600 border-b-2 border-blue-600" data-tab="identitas">Identitas</button>
                    <button type="button" class="tab-button px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent" data-tab="biodata">Biodata & Biografi</button>
                    <button type="button" class="tab-button px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent" data-tab="keluarga">Keluarga</button>
                    <button type="button" class="tab-button px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent" data-tab="riwayat">Riwayat Karir</button>
                    <button type="button" class="tab-button px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent" data-tab="pendidikan">Pendidikan</button>
                    <button type="button" class="tab-button px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent" data-tab="diklat">Diklat</button>
                    <button type="button" class="tab-button px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent" data-tab="organisasi">Organisasi</button>
                    <button type="button" class="tab-button px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent" data-tab="penghargaan">Penghargaan</button>
                </nav>
            </div>

            <form method="POST" action="{{ route('pimpinan.update-public', $official->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="p-6">
                    <!-- Identitas Tab -->
                    <div id="identitas" class="tab-content active">
                        <div class="flex flex-col items-center mb-6">
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Foto Profil</label>
                            
                            @if($official->photo)
                                <div class="mb-4 text-center">
                                    <img src="{{ Storage::url($official->photo) }}" alt="Foto Profil Saat Ini" class="w-32 h-32 object-cover rounded-xl shadow-md border-2 border-blue-100 mx-auto">
                                    <p class="text-gray-500 text-[10px] mt-2 font-bold uppercase tracking-wider">Foto Saat Ini</p>
                                </div>
                            @endif

                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors duration-200 w-full max-w-xs" id="photoDropZone">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3" id="photoIcon"></i>
                                    <p class="text-gray-600 mb-2">Pilih foto baru</p>
                                    <p class="text-gray-500 text-[10px] mb-3 uppercase font-bold tracking-tight">JPG, PNG, GIF (Max 2MB)</p>
                                    <input type="file" name="photo" id="photo" class="hidden" accept="image/*" onchange="validatePhoto(this)">
                                    <label for="photo" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2.5 px-6 rounded-lg cursor-pointer transition duration-200 uppercase">Pilih File</label>
                                    <p id="photoErrorMessage" class="mt-2 text-red-500 text-sm hidden"></p>
                                    <div id="photoNameDisplay" class="mt-3 text-sm hidden"></div>
                                    <div id="photoSizeDisplay" class="text-xs hidden"></div>
                                </div>
                            </div>
                            @error('photo') <p class="mt-1 text-sm text-red-600 text-center">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Nama Lengkap *</label>
                                <input type="text" name="full_name" value="{{ old('full_name', $official->full_name) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('full_name') border-red-500 @enderror">
                                @error('full_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Jabatan</label>
                                <input type="text" value="{{ $official->position->name ?? '' }}" disabled class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">OPD</label>
                                <input type="text" value="{{ $official->organization->name ?? '' }}" disabled class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">NIP</label>
                                <input type="text" name="nip" value="{{ old('nip', $official->nip) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('nip') border-red-500 @enderror">
                                @error('nip') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Status Jabatan</label>
                                @php
                                    $statusJabatanOptions = [
                                        ['value' => 'Definitif', 'label' => 'Definitif'],
                                        ['value' => 'Penjabat (Pj)', 'label' => 'Penjabat (Pj)'],
                                        ['value' => 'Pelaksana Tugas (Plt)', 'label' => 'Pelaksana Tugas (Plt)'],
                                        ['value' => 'Pelaksana Harian (Plh)', 'label' => 'Pelaksana Harian (Plh)'],
                                        ['value' => 'Pejabat Sementara (Pjs)', 'label' => 'Pejabat Sementara (Pjs)'],
                                    ];
                                @endphp
                                <x-custom-select 
                                    name="status_jabatan" 
                                    :options="$statusJabatanOptions" 
                                    :value="old('status_jabatan', $official->status_jabatan)"
                                    placeholder="Pilih Status Jabatan"
                                    :searchable="false"
                                />
                                @error('status_jabatan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Agama</label>
                                @php
                                    $religionOptions = [
                                        ['value' => 'Islam', 'label' => 'Islam'],
                                        ['value' => 'Kristen', 'label' => 'Kristen'],
                                        ['value' => 'Katolik', 'label' => 'Katolik'],
                                        ['value' => 'Hindu', 'label' => 'Hindu'],
                                        ['value' => 'Buddha', 'label' => 'Buddha'],
                                        ['value' => 'Khonghucu', 'label' => 'Khonghucu'],
                                    ];
                                @endphp
                                <x-custom-select 
                                    name="religion" 
                                    :options="$religionOptions" 
                                    :value="old('religion', $official->religion)"
                                    placeholder="Pilih Agama"
                                    :searchable="false"
                                />
                                @error('religion') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Tempat Lahir</label>
                                <input type="text" name="birth_place" value="{{ old('birth_place', $official->birth_place) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('birth_place') border-red-500 @enderror">
                                @error('birth_place') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Tanggal Lahir</label>
                                <input type="date" name="birth_date" value="{{ old('birth_date', $official->birth_date ? $official->birth_date->format('Y-m-d') : '') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('birth_date') border-red-500 @enderror">
                                @error('birth_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Status Pernikahan</label>
                                @php
                                    $maritalOptions = [
                                        ['value' => 'Belum Menikah', 'label' => 'Belum Menikah'],
                                        ['value' => 'Menikah', 'label' => 'Menikah'],
                                        ['value' => 'Cerai Hidup', 'label' => 'Cerai Hidup'],
                                        ['value' => 'Cerai Mati', 'label' => 'Cerai Mati'],
                                    ];
                                @endphp
                                <x-custom-select 
                                    name="marital_status" 
                                    :options="$maritalOptions" 
                                    :value="old('marital_status', $official->marital_status)"
                                    placeholder="Pilih Status"
                                    :searchable="false"
                                />
                                @error('marital_status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Jenis Kelamin</label>
                                @php
                                    $genderOptions = [
                                        ['value' => 'Laki-laki', 'label' => 'Laki-laki'],
                                        ['value' => 'Perempuan', 'label' => 'Perempuan'],
                                    ];
                                @endphp
                                <x-custom-select 
                                    name="jenis_kelamin" 
                                    :options="$genderOptions" 
                                    :value="old('jenis_kelamin', $official->jenis_kelamin)"
                                    placeholder="Pilih Jenis Kelamin"
                                    :searchable="false"
                                />
                                @error('jenis_kelamin') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', $official->email) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('email') border-red-500 @enderror">
                                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Alamat Rumah</label>
                                <textarea name="home_address" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('home_address') border-red-500 @enderror">{{ old('home_address', $official->home_address) }}</textarea>
                                @error('home_address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Mulai Jabatan</label>
                                <input type="date" name="start_term" value="{{ old('start_term', $official->start_term ? $official->start_term->format('Y-m-d') : '') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('start_term') border-red-500 @enderror">
                                @error('start_term') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Akhir Jabatan</label>
                                <input type="date" name="end_term" value="{{ old('end_term', $official->end_term ? $official->end_term->format('Y-m-d') : '') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('end_term') border-red-500 @enderror">
                                @error('end_term') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Status *</label>
                                @php
                                    $statusOptions = [
                                        ['value' => 'active', 'label' => 'Aktif'],
                                        ['value' => 'inactive', 'label' => 'Nonaktif'],
                                        ['value' => 'draft', 'label' => 'Draft'],
                                    ];
                                @endphp
                                <x-custom-select 
                                    name="status" 
                                    :options="$statusOptions" 
                                    :value="old('status', $official->status)"
                                    placeholder="Pilih Status"
                                    :searchable="false"
                                    required="true"
                                />
                                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div id="biodata" class="tab-content hidden">
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Biografi</label>
                            <textarea name="biography" rows="8" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('biography') border-red-500 @enderror">{{ old('biography', $official->biography) }}</textarea>
                            @error('biography') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div id="keluarga" class="tab-content hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div id="spouse_name_field_family" class="hidden">
                                <label id="spouse_name_label_family" class="block text-gray-700 text-sm font-semibold mb-2">Nama Suami/Istri</label>
                                <input type="text" name="spouse_name" value="{{ old('spouse_name', $official->spouse_name) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('spouse_name') border-red-500 @enderror">
                                @error('spouse_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Anak</h3>
                        <div id="children_fields">
                            @forelse($official->children ?? collect() as $index => $child)
                                <div class="child-item mb-4 p-4 border rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-gray-700 text-sm font-semibold mb-2">Nama Anak</label>
                                            <input type="text" name="children[{{ $index }}][name]" value="{{ $child->name }}" placeholder="Nama anak" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                        </div>
                                    </div>
                                    <button type="button" class="remove-child mt-2 text-red-600 hover:text-red-800">Hapus</button>
                                </div>
                            @empty
                                <div class="child-item mb-4 p-4 border rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-gray-700 text-sm font-semibold mb-2">Nama Anak</label>
                                            <input type="text" name="children[0][name]" value="" placeholder="Nama anak" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                        </div>
                                    </div>
                                    <button type="button" class="remove-child mt-2 text-red-600 hover:text-red-800">Hapus</button>
                                </div>
                            @endforelse
                        </div>
                        <button type="button" id="add_child" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                            <i class="fas fa-plus mr-2"></i> Tambah Anak
                        </button>
                    </div>

                    <div id="riwayat" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Riwayat Karir</h3>
                        <div id="career_fields">
                            @forelse($official->careerHistories as $index => $career)
                                <div class="career-item mb-4 p-4 border rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                        <div class="md:col-span-2"><label class="block text-gray-700 text-sm font-semibold mb-2">Jabatan</label><input type="text" name="career_histories[{{ $index }}][title]" value="{{ old('career_histories.'.$index.'.title', $career->title) }}" placeholder="Nama jabatan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div class="md:col-span-2"><label class="block text-gray-700 text-sm font-semibold mb-2">Instansi/OPD</label><input type="text" name="career_histories[{{ $index }}][organization_name]" value="{{ old('career_histories.'.$index.'.organization_name', $career->organization_name) }}" placeholder="Nama instansi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun Mulai</label><input type="number" name="career_histories[{{ $index }}][start_year]" value="{{ old('career_histories.'.$index.'.start_year', $career->start_year) }}" placeholder="2020" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-2">
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun Selesai</label><input type="number" name="career_histories[{{ $index }}][end_year]" value="{{ old('career_histories.'.$index.'.end_year', $career->end_year) }}" placeholder="2024" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div class="md:col-span-4"><label class="block text-gray-700 text-sm font-semibold mb-2">Keterangan</label><input type="text" name="career_histories[{{ $index }}][description]" value="{{ old('career_histories.'.$index.'.description', $career->description) }}" placeholder="Tambahkan keterangan (opsional)" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                    </div>
                                    <button type="button" class="remove-career mt-2 text-red-600 hover:text-red-800">Hapus</button>
                                </div>
                            @empty
                                <div class="career-item mb-4 p-4 border rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                        <div class="md:col-span-2"><label class="block text-gray-700 text-sm font-semibold mb-2">Jabatan</label><input type="text" name="career_histories[0][title]" value="" placeholder="Nama jabatan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div class="md:col-span-2"><label class="block text-gray-700 text-sm font-semibold mb-2">Instansi/OPD</label><input type="text" name="career_histories[0][organization_name]" value="" placeholder="Nama instansi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun Mulai</label><input type="number" name="career_histories[0][start_year]" value="" placeholder="2020" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-2">
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun Selesai</label><input type="number" name="career_histories[0][end_year]" value="" placeholder="2024" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div class="md:col-span-4"><label class="block text-gray-700 text-sm font-semibold mb-2">Keterangan</label><input type="text" name="career_histories[0][description]" value="" placeholder="Tambahkan keterangan (opsional)" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                    </div>
                                    <button type="button" class="remove-career mt-2 text-red-600 hover:text-red-800">Hapus</button>
                                </div>
                            @endforelse
                        </div>
                        <button type="button" id="add_career" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                            <i class="fas fa-plus mr-2"></i> Tambah Riwayat Karir
                        </button>
                    </div>

                    <div id="pendidikan" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Pendidikan</h3>
                        <div id="education_fields">
                            @forelse($official->educations as $index => $education)
                                <div class="education-item mb-4 p-4 border rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Jenjang</label><input type="text" name="educations[{{ $index }}][degree]" value="{{ old('educations.'.$index.'.degree', $education->degree) }}" placeholder="SMA, S1, dll" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Institusi</label><input type="text" name="educations[{{ $index }}][institution]" value="{{ old('educations.'.$index.'.institution', $education->institution) }}" placeholder="Nama institusi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun Mulai</label><input type="number" name="educations[{{ $index }}][start_year]" value="{{ old('educations.'.$index.'.start_year', $education->start_year) }}" placeholder="2020" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun Selesai</label><input type="number" name="educations[{{ $index }}][end_year]" value="{{ old('educations.'.$index.'.end_year', $education->end_year) }}" placeholder="2024" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                    </div>
                                    <button type="button" class="remove-education mt-2 text-red-600 hover:text-red-800">Hapus</button>
                                </div>
                            @empty
                                <div class="education-item mb-4 p-4 border rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Jenjang</label><input type="text" name="educations[0][degree]" placeholder="SMA, S1, dll" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Institusi</label><input type="text" name="educations[0][institution]" placeholder="Nama institusi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun Mulai</label><input type="number" name="educations[0][start_year]" placeholder="2020" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun Selesai</label><input type="number" name="educations[0][end_year]" placeholder="2024" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                    </div>
                                    <button type="button" class="remove-education mt-2 text-red-600 hover:text-red-800">Hapus</button>
                                </div>
                            @endforelse
                        </div>
                        <button type="button" id="add_education" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                            <i class="fas fa-plus mr-2"></i> Tambah Pendidikan
                        </button>
                    </div>

                    <div id="diklat" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Diklat</h3>
                        <div id="training_fields">
                            @forelse($official->trainingHistories as $index => $training)
                                <div class="training-item mb-4 p-4 border rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div class="md:col-span-2"><label class="block text-gray-700 text-sm font-semibold mb-2">Nama Diklat</label><input type="text" name="training_histories[{{ $index }}][name]" value="{{ old('training_histories.'.$index.'.name', $training->name) }}" placeholder="Nama diklat" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun</label><input type="number" name="training_histories[{{ $index }}][year]" value="{{ old('training_histories.'.$index.'.year', $training->year) }}" placeholder="2024" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Penyelenggara</label><input type="text" name="training_histories[{{ $index }}][organizer]" value="{{ old('training_histories.'.$index.'.organizer', $training->organizer) }}" placeholder="Nama penyelenggara" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                    </div>
                                    <button type="button" class="remove-training mt-2 text-red-600 hover:text-red-800">Hapus</button>
                                </div>
                            @empty
                                <div class="training-item mb-4 p-4 border rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div class="md:col-span-2"><label class="block text-gray-700 text-sm font-semibold mb-2">Nama Diklat</label><input type="text" name="training_histories[0][name]" placeholder="Nama diklat" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun</label><input type="number" name="training_histories[0][year]" placeholder="2024" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Penyelenggara</label><input type="text" name="training_histories[0][organizer]" placeholder="Nama penyelenggara" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                    </div>
                                    <button type="button" class="remove-training mt-2 text-red-600 hover:text-red-800">Hapus</button>
                                </div>
                            @endforelse
                        </div>
                        <button type="button" id="add_training" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                            <i class="fas fa-plus mr-2"></i> Tambah Diklat
                        </button>
                    </div>

                    <div id="organisasi" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Organisasi</h3>
                        <div id="organizational_fields">
                            @forelse($official->organizationalHistories as $index => $organizational)
                                <div class="organizational-item mb-4 p-4 border rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div class="md:col-span-2"><label class="block text-gray-700 text-sm font-semibold mb-2">Nama Organisasi</label><input type="text" name="organizational_histories[{{ $index }}][organization_name]" value="{{ old('organizational_histories.'.$index.'.organization_name', $organizational->organization_name) }}" placeholder="Nama organisasi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Jabatan</label><input type="text" name="organizational_histories[{{ $index }}][position]" value="{{ old('organizational_histories.'.$index.'.position', $organizational->position) }}" placeholder="Jabatan dalam organisasi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun</label><input type="number" name="organizational_histories[{{ $index }}][year]" value="{{ old('organizational_histories.'.$index.'.year', $organizational->year) }}" placeholder="2020-2024" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                    </div>
                                    <button type="button" class="remove-organizational mt-2 text-red-600 hover:text-red-800">Hapus</button>
                                </div>
                            @empty
                                <div class="organizational-item mb-4 p-4 border rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div class="md:col-span-2"><label class="block text-gray-700 text-sm font-semibold mb-2">Nama Organisasi</label><input type="text" name="organizational_histories[0][organization_name]" placeholder="Nama organisasi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Jabatan</label><input type="text" name="organizational_histories[0][position]" placeholder="Jabatan dalam organisasi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun</label><input type="number" name="organizational_histories[0][year]" placeholder="2020-2024" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                    </div>
                                    <button type="button" class="remove-organizational mt-2 text-red-600 hover:text-red-800">Hapus</button>
                                </div>
                            @endforelse
                        </div>
                        <button type="button" id="add_organizational" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                            <i class="fas fa-plus mr-2"></i> Tambah Organisasi
                        </button>
                    </div>

                    <div id="penghargaan" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Penghargaan</h3>
                        <div id="award_fields">
                            @forelse($official->awards as $index => $award)
                                <div class="award-item mb-4 p-4 border rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div class="md:col-span-2"><label class="block text-gray-700 text-sm font-semibold mb-2">Nama Penghargaan</label><input type="text" name="awards[{{ $index }}][title]" value="{{ old('awards.'.$index.'.title', $award->title) }}" placeholder="Nama penghargaan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Pemberi</label><input type="text" name="awards[{{ $index }}][issuer]" value="{{ old('awards.'.$index.'.issuer', $award->issuer) }}" placeholder="Instansi pemberi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun</label><input type="number" name="awards[{{ $index }}][year]" value="{{ old('awards.'.$index.'.year', $award->year) }}" placeholder="2024" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                    </div>
                                    <div class="mt-4"><label class="block text-gray-700 text-sm font-semibold mb-2">Deskripsi</label><input type="text" name="awards[{{ $index }}][description]" value="{{ old('awards.'.$index.'.description', $award->description) }}" placeholder="Deskripsi (opsional)" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                    <button type="button" class="remove-award mt-2 text-red-600 hover:text-red-800">Hapus</button>
                                </div>
                            @empty
                                <div class="award-item mb-4 p-4 border rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div class="md:col-span-2"><label class="block text-gray-700 text-sm font-semibold mb-2">Nama Penghargaan</label><input type="text" name="awards[0][title]" placeholder="Nama penghargaan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Pemberi</label><input type="text" name="awards[0][issuer]" placeholder="Instansi pemberi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                        <div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun</label><input type="number" name="awards[0][year]" placeholder="2024" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                    </div>
                                    <div class="mt-4"><label class="block text-gray-700 text-sm font-semibold mb-2">Deskripsi</label><input type="text" name="awards[0][description]" placeholder="Deskripsi (opsional)" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div>
                                    <button type="button" class="remove-award mt-2 text-red-600 hover:text-red-800">Hapus</button>
                                </div>
                            @endforelse
                        </div>
                        <button type="button" id="add_award" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                            <i class="fas fa-plus mr-2"></i> Tambah Penghargaan
                        </button>
                    </div>
                </div>

                <div class="hidden">
                    <div id="child_template"><div class="child-item mb-4 p-4 border rounded-lg"><div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="block text-gray-700 text-sm font-semibold mb-2">Nama Anak</label><input type="text" name="children[][name]" placeholder="Nama anak" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div></div><button type="button" class="remove-child mt-2 text-red-600 hover:text-red-800">Hapus</button></div></div>
                    <div id="career_template"><div class="career-item mb-4 p-4 border rounded-lg"><div class="grid grid-cols-1 md:grid-cols-5 gap-4"><div class="md:col-span-2"><label class="block text-gray-700 text-sm font-semibold mb-2">Jabatan</label><input type="text" name="career_histories[][title]" placeholder="Nama jabatan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div><div class="md:col-span-2"><label class="block text-gray-700 text-sm font-semibold mb-2">Instansi/OPD</label><input type="text" name="career_histories[][organization_name]" placeholder="Nama instansi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div><div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun Mulai</label><input type="number" name="career_histories[][start_year]" placeholder="2020" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div></div><div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-2"><div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun Selesai</label><input type="number" name="career_histories[][end_year]" placeholder="2024" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div><div class="md:col-span-4"><label class="block text-gray-700 text-sm font-semibold mb-2">Keterangan</label><input type="text" name="career_histories[][description]" placeholder="Tambahkan keterangan (opsional)" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div></div><button type="button" class="remove-career mt-2 text-red-600 hover:text-red-800">Hapus</button></div></div>
                    <div id="education_template"><div class="education-item mb-4 p-4 border rounded-lg"><div class="grid grid-cols-1 md:grid-cols-4 gap-4"><div><label class="block text-gray-700 text-sm font-semibold mb-2">Jenjang</label><input type="text" name="educations[][degree]" placeholder="SMA, S1, dll" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div><div><label class="block text-gray-700 text-sm font-semibold mb-2">Institusi</label><input type="text" name="educations[][institution]" placeholder="Nama institusi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div><div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun Mulai</label><input type="number" name="educations[][start_year]" placeholder="2020" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div><div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun Selesai</label><input type="number" name="educations[][end_year]" placeholder="2024" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div></div><button type="button" class="remove-education mt-2 text-red-600 hover:text-red-800">Hapus</button></div></div>
                    <div id="training_template"><div class="training-item mb-4 p-4 border rounded-lg"><div class="grid grid-cols-1 md:grid-cols-4 gap-4"><div class="md:col-span-2"><label class="block text-gray-700 text-sm font-semibold mb-2">Nama Diklat</label><input type="text" name="training_histories[][name]" placeholder="Nama diklat" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div><div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun</label><input type="number" name="training_histories[][year]" placeholder="2024" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div><div><label class="block text-gray-700 text-sm font-semibold mb-2">Penyelenggara</label><input type="text" name="training_histories[][organizer]" placeholder="Nama penyelenggara" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div></div><button type="button" class="remove-training mt-2 text-red-600 hover:text-red-800">Hapus</button></div></div>
                    <div id="organizational_template"><div class="organizational-item mb-4 p-4 border rounded-lg"><div class="grid grid-cols-1 md:grid-cols-4 gap-4"><div class="md:col-span-2"><label class="block text-gray-700 text-sm font-semibold mb-2">Nama Organisasi</label><input type="text" name="organizational_histories[][organization_name]" placeholder="Nama organisasi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div><div><label class="block text-gray-700 text-sm font-semibold mb-2">Jabatan</label><input type="text" name="organizational_histories[][position]" placeholder="Jabatan dalam organisasi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div><div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun</label><input type="number" name="organizational_histories[][year]" placeholder="2020-2024" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div></div><button type="button" class="remove-organizational mt-2 text-red-600 hover:text-red-800">Hapus</button></div></div>
                    <div id="award_template"><div class="award-item mb-4 p-4 border rounded-lg"><div class="grid grid-cols-1 md:grid-cols-4 gap-4"><div class="md:col-span-2"><label class="block text-gray-700 text-sm font-semibold mb-2">Nama Penghargaan</label><input type="text" name="awards[][title]" placeholder="Nama penghargaan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div><div><label class="block text-gray-700 text-sm font-semibold mb-2">Pemberi</label><input type="text" name="awards[][issuer]" placeholder="Instansi pemberi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div><div><label class="block text-gray-700 text-sm font-semibold mb-2">Tahun</label><input type="number" name="awards[][year]" placeholder="2024" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div></div><div class="mt-4"><label class="block text-gray-700 text-sm font-semibold mb-2">Deskripsi</label><input type="text" name="awards[][description]" placeholder="Deskripsi (opsional)" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></div><button type="button" class="remove-award mt-2 text-red-600 hover:text-red-800">Hapus</button></div></div>
                </div>

                <div class="p-6 flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('official.pejabat-daerah') }}" class="px-6 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition duration-200">
                        Kembali
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/frontend/pimpinan-form.js') }}?v={{ time() }}"></script>
@endpush
