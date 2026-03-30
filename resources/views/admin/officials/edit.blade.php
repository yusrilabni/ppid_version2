@extends('admin.layouts.app')

@section('title', 'Edit Profil Pimpinan')

@section('content')
    <div class="bg-white rounded-xl shadow">
        <div class="flex justify-between items-center p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800">Edit Profil Pimpinan</h2>
            <a href="{{ route('admin.officials.index') }}" class="text-blue-600 hover:text-blue-800">
                &larr; Kembali
            </a>
        </div>

        <!-- Tabs -->
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <button type="button" class="tab-button active px-4 py-4 text-sm font-medium text-blue-600 border-b-2 border-blue-600" data-tab="identitas">
                    Identitas
                </button>
                <button type="button" class="tab-button px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent" data-tab="biodata">
                    Biodata & Biografi
                </button>
                <button type="button" class="tab-button px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent" data-tab="keluarga">
                    Keluarga
                </button>
                <button type="button" class="tab-button px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent" data-tab="riwayat">
                    Riwayat Karir
                </button>
                <button type="button" class="tab-button px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent" data-tab="pendidikan">
                    Pendidikan
                </button>
                <button type="button" class="tab-button px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent" data-tab="diklat">
                    Diklat
                </button>
                <button type="button" class="tab-button px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent" data-tab="organisasi">
                    Organisasi
                </button>
                <button type="button" class="tab-button px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent" data-tab="penghargaan">
                    Penghargaan
                </button>
            </nav>
        </div>

        <form method="POST" action="{{ route('admin.officials.update', $official->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Tab Content -->
            <div class="p-6">
                <!-- Identitas Tab -->
                <div id="identitas" class="tab-content active">
                    <!-- Foto Section at the Top -->
                    <div class="flex flex-col items-center mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto</label>
                        @if($official->photo)
                            <div class="mb-3">
                                <img src="{{ Storage::url($official->photo) }}" alt="Foto Profil" class="w-32 h-32 rounded-full object-cover border-2 border-gray-300">
                            </div>
                        @endif
                        <div class="w-full max-w-xs">
                            <input type="file" name="photo" accept="image/*"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('photo') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-1 text-center">Biarkan kosong jika tidak ingin mengubah foto ini di identitas saya</p>
                            @error('photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                            <input type="text" name="full_name" value="{{ old('full_name', $official->full_name) }}" required
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('full_name') border-red-500 @enderror">
                            @error('full_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan *</label>
                            <select name="position_id" id="position_id" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('position_id') border-red-500 @enderror">
                                <option value="">Pilih Jabatan</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}" {{ old('position_id', $official->position_id) == $position->id ? 'selected' : '' }}>
                                        {{ $position->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('position_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                            <input type="text" name="nip" value="{{ old('nip', $official->nip) }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nip') border-red-500 @enderror">
                            @error('nip')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Jabatan</label>
                            <select name="status_jabatan"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('status_jabatan') border-red-500 @enderror">
                                <option value="Definitif" {{ old('status_jabatan', $official->status_jabatan) == 'Definitif' ? 'selected' : '' }}>Definitif</option>
                                <option value="Penjabat (Pj)" {{ old('status_jabatan', $official->status_jabatan) == 'Penjabat (Pj)' ? 'selected' : '' }}>Penjabat (Pj)</option>
                                <option value="Pelaksana Tugas (Plt)" {{ old('status_jabatan', $official->status_jabatan) == 'Pelaksana Tugas (Plt)' ? 'selected' : '' }}>Pelaksana Tugas (Plt)</option>
                                <option value="Pelaksana Harian (Plh)" {{ old('status_jabatan', $official->status_jabatan) == 'Pelaksana Harian (Plh)' ? 'selected' : '' }}>Pelaksana Harian (Plh)</option>
                                <option value="Pejabat Sementara (Pjs)" {{ old('status_jabatan', $official->status_jabatan) == 'Pejabat Sementara (Pjs)' ? 'selected' : '' }}>Pejabat Sementara (Pjs)</option>
                            </select>
                            @error('status_jabatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="organization_field" class="{{ (old('position_id', $official->position_id) && ($positions->firstWhere('id', old('position_id', $official->position_id))->name ?? '') === 'Kepala OPD') ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-gray-700 mb-1">OPD *</label>
                            <select name="organization_id"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('organization_id') border-red-500 @enderror">
                                <option value="">Pilih OPD</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ old('organization_id', $official->organization_id) == $organization->id ? 'selected' : '' }}>
                                        {{ $organization->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('organization_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                            <select name="religion" id="religion"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('religion') border-red-500 @enderror">
                                <option value="">Pilih Agama</option>
                                <option value="Islam" {{ old('religion', $official->religion) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('religion', $official->religion) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('religion', $official->religion) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('religion', $official->religion) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('religion', $official->religion) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Khonghucu" {{ old('religion', $official->religion) == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                            </select>
                            @error('religion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                            <input type="text" name="birth_place" value="{{ old('birth_place', $official->birth_place) }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('birth_place') border-red-500 @enderror">
                            @error('birth_place')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                            <input type="date" name="birth_date" value="{{ old('birth_date', $official->birth_date ? $official->birth_date->format('Y-m-d') : '') }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('birth_date') border-red-500 @enderror">
                            @error('birth_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Pernikahan</label>
                            <select name="marital_status" id="marital_status"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('marital_status') border-red-500 @enderror">
                                <option value="">Pilih Status</option>
                                <option value="Belum Menikah" {{ old('marital_status', $official->marital_status) == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                <option value="Menikah" {{ old('marital_status', $official->marital_status) == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                <option value="Cerai Hidup" {{ old('marital_status', $official->marital_status) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                <option value="Cerai Mati" {{ old('marital_status', $official->marital_status) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                            </select>
                            @error('marital_status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('jenis_kelamin') border-red-500 @enderror">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $official->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $official->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $official->email) }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Rumah</label>
                            <textarea name="home_address" rows="3"
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('home_address') border-red-500 @enderror">{{ old('home_address', $official->home_address) }}</textarea>
                            @error('home_address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mulai Jabatan</label>
                            <input type="date" name="start_term" value="{{ old('start_term', $official->start_term ? $official->start_term->format('Y-m-d') : '') }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('start_term') border-red-500 @enderror">
                            @error('start_term')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Akhir Jabatan</label>
                            <input type="date" name="end_term" value="{{ old('end_term', $official->end_term ? $official->end_term->format('Y-m-d') : '') }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('end_term') border-red-500 @enderror">
                            @error('end_term')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                            <select name="status" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                                <option value="active" {{ old('status', $official->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status', $official->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                <option value="draft" {{ old('status', $official->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Biodata & Biografi Tab -->
                <div id="biodata" class="tab-content hidden">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Biografi</label>
                        <textarea name="biography" rows="8"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('biography') border-red-500 @enderror">{{ old('biography', $official->biography) }}</textarea>
                        @error('biography')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Keluarga Tab -->
                <div id="keluarga" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div id="spouse_name_field_family" class="hidden">
                            <label id="spouse_name_label_family" class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Suami/Istri
                            </label>
                            <input type="text" name="spouse_name" value="{{ old('spouse_name', $official->spouse_name) }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('spouse_name') border-red-500 @enderror">
                            @error('spouse_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div id="children_fields">
                        @forelse($official->children ?? collect() as $index => $child)
                            <div class="child-item mb-4 p-4 border rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Anak</label>
                                        <input type="text" name="children[{{ $index }}][name]" value="{{ $child->name }}" placeholder="Nama anak"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                <button type="button" class="remove-child mt-2 text-red-600 hover:text-red-800">Hapus</button>
                            </div>
                        @empty
                            <div class="child-item mb-4 p-4 border rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Anak</label>
                                        <input type="text" name="children[0][name]" value="" placeholder="Nama anak"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <button type="button" id="add_child" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                        <i class="fas fa-plus mr-2"></i> Tambah Anak
                    </button>

                    <!-- Template for new child entries -->
                    <div id="child_template" class="hidden">
                        <div class="child-item mb-4 p-4 border rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Anak</label>
                                    <input type="text" name="children[][name]" placeholder="Nama anak"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <button type="button" class="remove-child mt-2 text-red-600 hover:text-red-800">Hapus</button>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Karir Tab -->
                <div id="riwayat" class="tab-content hidden">
                    <div id="career_fields">
                        @forelse($official->careerHistories as $index => $career)
                            <div class="career-item mb-4 p-4 border rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                        <input type="text" name="career_histories[{{ $index }}][title]" value="{{ old('career_histories.'.$index.'.title', $career->title) }}" placeholder="Nama jabatan"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Instansi/OPD</label>
                                        <input type="text" name="career_histories[{{ $index }}][organization_name]" value="{{ old('career_histories.'.$index.'.organization_name', $career->organization_name) }}" placeholder="Nama instansi"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Mulai</label>
                                        <input type="number" name="career_histories[{{ $index }}][start_year]" value="{{ old('career_histories.'.$index.'.start_year', $career->start_year) }}" placeholder="2020"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Selesai</label>
                                        <input type="number" name="career_histories[{{ $index }}][end_year]" value="{{ old('career_histories.'.$index.'.end_year', $career->end_year) }}" placeholder="2024"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                        <input type="text" name="career_histories[{{ $index }}][description]" value="{{ old('career_histories.'.$index.'.description', $career->description) }}" placeholder="Tambahkan keterangan (opsional)"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                <button type="button" class="remove-career mt-2 text-red-600 hover:text-red-800">Hapus</button>
                            </div>
                        @empty
                            <div class="career-item mb-4 p-4 border rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                        <input type="text" name="career_histories[0][title]" value="" placeholder="Nama jabatan"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Instansi/OPD</label>
                                        <input type="text" name="career_histories[0][organization_name]" value="" placeholder="Nama instansi"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Mulai</label>
                                        <input type="number" name="career_histories[0][start_year]" value="" placeholder="2020"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Selesai</label>
                                        <input type="number" name="career_histories[0][end_year]" value="" placeholder="2024"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                        <input type="text" name="career_histories[0][description]" value="" placeholder="Tambahkan keterangan (opsional)"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <button type="button" id="add_career" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                        <i class="fas fa-plus mr-2"></i> Tambah Riwayat Karir
                    </button>

                    <!-- Template for new career entries -->
                    <div id="career_template" class="hidden">
                        <div class="career-item mb-4 p-4 border rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                    <input type="text" name="career_histories[][title]" placeholder="Nama jabatan"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Instansi/OPD</label>
                                    <input type="text" name="career_histories[][organization_name]" placeholder="Nama instansi"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Mulai</label>
                                    <input type="number" name="career_histories[][start_year]" placeholder="2020"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Selesai</label>
                                    <input type="number" name="career_histories[][end_year]" placeholder="2024"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div class="md:col-span-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                    <input type="text" name="career_histories[][description]" placeholder="Tambahkan keterangan (opsional)"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <button type="button" class="remove-career mt-2 text-red-600 hover:text-red-800">Hapus</button>
                        </div>
                    </div>
                </div>

                <!-- Pendidikan Tab -->
                <div id="pendidikan" class="tab-content hidden">
                    <div id="education_fields">
                        @forelse($official->educations as $index => $education)
                            <div class="education-item mb-4 p-4 border rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenjang Pendidikan</label>
                                        <input type="text" name="educations[{{ $index }}][degree]" value="{{ old('educations.'.$index.'.degree', $education->degree) }}" placeholder="SMA, S1, S2, dll"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Institusi</label>
                                        <input type="text" name="educations[{{ $index }}][institution]" value="{{ old('educations.'.$index.'.institution', $education->institution) }}" placeholder="Nama institusi"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Mulai</label>
                                        <input type="number" name="educations[{{ $index }}][start_year]" value="{{ old('educations.'.$index.'.start_year', $education->start_year) }}" placeholder="2020"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Selesai</label>
                                        <input type="number" name="educations[{{ $index }}][end_year]" value="{{ old('educations.'.$index.'.end_year', $education->end_year) }}" placeholder="2024"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                <button type="button" class="remove-education mt-2 text-red-600 hover:text-red-800">Hapus</button>
                            </div>
                        @empty
                            <div class="education-item mb-4 p-4 border rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenjang Pendidikan</label>
                                        <input type="text" name="educations[0][degree]" value="" placeholder="SMA, S1, S2, dll"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Institusi</label>
                                        <input type="text" name="educations[0][institution]" value="" placeholder="Nama institusi"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Mulai</label>
                                        <input type="number" name="educations[0][start_year]" value="" placeholder="2020"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Selesai</label>
                                        <input type="number" name="educations[0][end_year]" value="" placeholder="2024"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <button type="button" id="add_education" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                        <i class="fas fa-plus mr-2"></i> Tambah Pendidikan
                    </button>

                    <!-- Template for new education entries -->
                    <div id="education_template" class="hidden">
                        <div class="education-item mb-4 p-4 border rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenjang Pendidikan</label>
                                    <input type="text" name="educations[][degree]" placeholder="SMA, S1, S2, dll"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Institusi</label>
                                    <input type="text" name="educations[][institution]" placeholder="Nama institusi"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Mulai</label>
                                    <input type="number" name="educations[][start_year]" placeholder="2020"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Selesai</label>
                                    <input type="number" name="educations[][end_year]" placeholder="2024"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <button type="button" class="remove-education mt-2 text-red-600 hover:text-red-800">Hapus</button>
                        </div>
                    </div>
                </div>

                <!-- Diklat Tab -->
                <div id="diklat" class="tab-content hidden">
                    <div id="training_fields">
                        @forelse($official->trainingHistories as $index => $training)
                            <div class="training-item mb-4 p-4 border rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Diklat</label>
                                        <input type="text" name="training_histories[{{ $index }}][name]" value="{{ old('training_histories.'.$index.'.name', $training->name) }}" placeholder="Nama diklat"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                                        <input type="number" name="training_histories[{{ $index }}][year]" value="{{ old('training_histories.'.$index.'.year', $training->year) }}" placeholder="2024"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Penyelenggara</label>
                                        <input type="text" name="training_histories[{{ $index }}][organizer]" value="{{ old('training_histories.'.$index.'.organizer', $training->organizer) }}" placeholder="Nama penyelenggara"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                <button type="button" class="remove-training mt-2 text-red-600 hover:text-red-800">Hapus</button>
                            </div>
                        @empty
                            <div class="training-item mb-4 p-4 border rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Diklat</label>
                                        <input type="text" name="training_histories[0][name]" value="" placeholder="Nama diklat"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                                        <input type="number" name="training_histories[0][year]" value="" placeholder="2024"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Penyelenggara</label>
                                        <input type="text" name="training_histories[0][organizer]" value="" placeholder="Nama penyelenggara"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <button type="button" id="add_training" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                        <i class="fas fa-plus mr-2"></i> Tambah Diklat
                    </button>

                    <!-- Template for new training entries -->
                    <div id="training_template" class="hidden">
                        <div class="training-item mb-4 p-4 border rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Diklat</label>
                                    <input type="text" name="training_histories[][name]" placeholder="Nama diklat"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                                    <input type="number" name="training_histories[][year]" placeholder="2024"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Penyelenggara</label>
                                    <input type="text" name="training_histories[][organizer]" placeholder="Nama penyelenggara"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <button type="button" class="remove-training mt-2 text-red-600 hover:text-red-800">Hapus</button>
                        </div>
                    </div>
                </div>

                <!-- Organisasi Tab -->
                <div id="organisasi" class="tab-content hidden">
                    <div id="organizational_fields">
                        @forelse($official->organizationalHistories as $index => $organizational)
                            <div class="organizational-item mb-4 p-4 border rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Organisasi</label>
                                        <input type="text" name="organizational_histories[{{ $index }}][organization_name]" value="{{ old('organizational_histories.'.$index.'.organization_name', $organizational->organization_name) }}" placeholder="Nama organisasi"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                        <input type="text" name="organizational_histories[{{ $index }}][position]" value="{{ old('organizational_histories.'.$index.'.position', $organizational->position) }}" placeholder="Jabatan dalam organisasi"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                                        <input type="number" name="organizational_histories[{{ $index }}][year]" value="{{ old('organizational_histories.'.$index.'.year', $organizational->year) }}" placeholder="2020-2024"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                <button type="button" class="remove-organizational mt-2 text-red-600 hover:text-red-800">Hapus</button>
                            </div>
                        @empty
                            <div class="organizational-item mb-4 p-4 border rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Organisasi</label>
                                        <input type="text" name="organizational_histories[0][organization_name]" value="" placeholder="Nama organisasi"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                        <input type="text" name="organizational_histories[0][position]" value="" placeholder="Jabatan dalam organisasi"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                                        <input type="number" name="organizational_histories[0][year]" value="" placeholder="2020-2024"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <button type="button" id="add_organizational" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                        <i class="fas fa-plus mr-2"></i> Tambah Organisasi
                    </button>

                    <!-- Template for new organizational entries -->
                    <div id="organizational_template" class="hidden">
                        <div class="organizational-item mb-4 p-4 border rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Organisasi</label>
                                    <input type="text" name="organizational_histories[][organization_name]" placeholder="Nama organisasi"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                    <input type="text" name="organizational_histories[][position]" placeholder="Jabatan dalam organisasi"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                                    <input type="number" name="organizational_histories[][year]" placeholder="2020-2024"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <button type="button" class="remove-organizational mt-2 text-red-600 hover:text-red-800">Hapus</button>
                        </div>
                    </div>
                </div>

                <!-- Penghargaan Tab -->
                <div id="penghargaan" class="tab-content hidden">
                    <div id="award_fields">
                        @forelse($official->awards as $index => $award)
                            <div class="award-item mb-4 p-4 border rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penghargaan</label>
                                        <input type="text" name="awards[{{ $index }}][title]" value="{{ old('awards.'.$index.'.title', $award->title) }}" placeholder="Nama penghargaan"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Pemberi</label>
                                        <input type="text" name="awards[{{ $index }}][issuer]" value="{{ old('awards.'.$index.'.issuer', $award->issuer) }}" placeholder="Instansi pemberi"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                                        <input type="number" name="awards[{{ $index }}][year]" value="{{ old('awards.'.$index.'.year', $award->year) }}" placeholder="2024"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                    <input type="text" name="awards[{{ $index }}][description]" value="{{ old('awards.'.$index.'.description', $award->description) }}" placeholder="Deskripsi (opsional)"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <button type="button" class="remove-award mt-2 text-red-600 hover:text-red-800">Hapus</button>
                            </div>
                        @empty
                            <div class="award-item mb-4 p-4 border rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penghargaan</label>
                                        <input type="text" name="awards[0][title]" value="" placeholder="Nama penghargaan"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Pemberi</label>
                                        <input type="text" name="awards[0][issuer]" value="" placeholder="Instansi pemberi"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                                        <input type="number" name="awards[0][year]" value="" placeholder="2024"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                    <input type="text" name="awards[0][description]" value="" placeholder="Deskripsi (opsional)"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <button type="button" id="add_award" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                        <i class="fas fa-plus mr-2"></i> Tambah Penghargaan
                    </button>

                    <!-- Template for new award entries -->
                    <div id="award_template" class="hidden">
                        <div class="award-item mb-4 p-4 border rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penghargaan</label>
                                    <input type="text" name="awards[][title]" placeholder="Nama penghargaan"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pemberi</label>
                                    <input type="text" name="awards[][issuer]" placeholder="Instansi pemberi"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                                    <input type="number" name="awards[][year]" placeholder="2024"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <input type="text" name="awards[][description]" placeholder="Deskripsi (opsional)"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <button type="button" class="remove-award mt-2 text-red-600 hover:text-red-800">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/admin/officials-form.js') }}"></script>
@endsection