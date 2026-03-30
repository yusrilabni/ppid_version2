@extends('admin.layouts.app')

@section('title', 'Tambah Profil Pimpinan')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Profil Pimpinan</h1>
            <a href="{{ route('admin.officials.index') }}" class="text-blue-600 hover:text-blue-800">
                &larr; Kembali
            </a>
        </div>

        <div class="bg-white rounded-lg shadow">
            <!-- Tabs -->
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button type="button" class="tab-button active px-4 py-4 text-sm font-medium text-blue-600 border-b-2 border-blue-600" data-tab="identitas">
                        Identitas
                    </button>
                    <button type="button" class="tab-button px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent" data-tab="biodata">
                        Biodata & Biografi
                    </button>
                    <button type="button" class="tab-button px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent" data-tab="riwayat">
                        Riwayat Karir
                    </button>
                    <button type="button" class="tab-button px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent" data-tab="pendidikan">
                        Pendidikan
                    </button>
                    <button type="button" class="tab-button px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent" data-tab="penghargaan">
                        Penghargaan
                    </button>
                </nav>
            </div>

            <form action="{{ route('admin.officials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Tab Content -->
                <div class="p-6">
                    <!-- Identitas Tab -->
                    <div id="identitas" class="tab-content active">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                                <input type="text" name="full_name" value="{{ old('full_name') }}" required
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
                                        <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                            {{ $position->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('position_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="organization_field" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-1">OPD</label>
                                <select name="organization_id"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('organization_id') border-red-500 @enderror">
                                    <option value="">Pilih OPD (Opsional)</option>
                                    @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}" {{ old('organization_id') == $organization->id ? 'selected' : '' }}>
                                            {{ $organization->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('organization_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                                <select name="status" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                                <input type="text" name="birth_place" value="{{ old('birth_place') }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('birth_place') border-red-500 @enderror">
                                @error('birth_place')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                                <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('birth_date') border-red-500 @enderror">
                                @error('birth_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                                <input type="text" name="nip" value="{{ old('nip') }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nip') border-red-500 @enderror">
                                @error('nip')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mulai Jabatan</label>
                                <input type="date" name="start_term" value="{{ old('start_term') }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('start_term') border-red-500 @enderror">
                                @error('start_term')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Akhir Jabatan</label>
                                <input type="date" name="end_term" value="{{ old('end_term') }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('end_term') border-red-500 @enderror">
                                @error('end_term')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                                <input type="file" name="photo" accept="image/*"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('photo') border-red-500 @enderror">
                                <p class="text-xs text-gray-500 mt-1">Format: JPEG, PNG. Max: 2MB</p>
                                @error('photo')
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
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('biography') border-red-500 @enderror">{{ old('biography') }}</textarea>
                            @error('biography')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Riwayat Karir Tab -->
                    <div id="riwayat" class="tab-content hidden">
                        <div id="career_fields">
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
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tgl Mulai</label>
                                        <input type="date" name="career_histories[][start_date]"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tgl Selesai</label>
                                        <input type="date" name="career_histories[][end_date]"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                        <input type="text" name="career_histories[][description]" placeholder="Tambahkan keterangan (opsional)"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add_career" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                            <i class="fas fa-plus mr-2"></i> Tambah Riwayat Karir
                        </button>
                    </div>

                    <!-- Pendidikan Tab -->
                    <div id="pendidikan" class="tab-content hidden">
                        <div id="education_fields">
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
                            </div>
                        </div>
                        <button type="button" id="add_education" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                            <i class="fas fa-plus mr-2"></i> Tambah Pendidikan
                        </button>
                    </div>

                    <!-- Penghargaan Tab -->
                    <div id="penghargaan" class="tab-content hidden">
                        <div id="award_fields">
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
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                        <input type="date" name="awards[][date]"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                    <input type="text" name="awards[][description]" placeholder="Deskripsi (opsional)"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add_award" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                            <i class="fas fa-plus mr-2"></i> Tambah Penghargaan
                        </button>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tab functionality
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons and content
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('active', 'text-blue-600', 'border-blue-600');
                    btn.classList.add('text-gray-500', 'border-transparent');
                });
                
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
                
                // Add active class to clicked button
                button.classList.remove('text-gray-500', 'border-transparent');
                button.classList.add('active', 'text-blue-600', 'border-blue-600');
                
                // Show corresponding content
                const tabId = button.getAttribute('data-tab');
                document.getElementById(tabId).classList.remove('hidden');
            });
        });

        // Show/hide organization field based on position selection
        document.getElementById('position_id').addEventListener('change', function() {
            const organizationField = document.getElementById('organization_field');
            const selectedOption = this.options[this.selectedIndex];
            const positionName = selectedOption.text;

            if (positionName.toLowerCase().includes('kepala')) {
                organizationField.classList.remove('hidden');
            } else {
                organizationField.classList.add('hidden');
            }
        });

        // Initialize organization field visibility based on current selection
        document.addEventListener('DOMContentLoaded', function() {
            const positionSelect = document.getElementById('position_id');
            if (positionSelect.value) {
                const selectedOption = positionSelect.options[positionSelect.selectedIndex];
                const positionName = selectedOption.text;
                
                if (positionName.toLowerCase().includes('kepala')) {
                    document.getElementById('organization_field').classList.remove('hidden');
                }
            }
        });

        // Dynamic fields for career history
        document.getElementById('add_career').addEventListener('click', function() {
            const container = document.getElementById('career_fields');
            const newField = document.createElement('div');
            newField.className = 'career-item mb-4 p-4 border rounded-lg';
            newField.innerHTML = `
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tgl Mulai</label>
                        <input type="date" name="career_histories[][start_date]"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tgl Selesai</label>
                        <input type="date" name="career_histories[][end_date]"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="md:col-span-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <input type="text" name="career_histories[][description]" placeholder="Tambahkan keterangan (opsional)"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <button type="button" class="remove-career mt-2 text-red-600 hover:text-red-800">Hapus</button>
            `;
            container.appendChild(newField);
            
            // Add event listener to the remove button
            newField.querySelector('.remove-career').addEventListener('click', function() {
                newField.remove();
            });
        });

        // Dynamic fields for education
        document.getElementById('add_education').addEventListener('click', function() {
            const container = document.getElementById('education_fields');
            const newField = document.createElement('div');
            newField.className = 'education-item mb-4 p-4 border rounded-lg';
            newField.innerHTML = `
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
            `;
            container.appendChild(newField);
            
            // Add event listener to the remove button
            newField.querySelector('.remove-education').addEventListener('click', function() {
                newField.remove();
            });
        });

        // Dynamic fields for awards
        document.getElementById('add_award').addEventListener('click', function() {
            const container = document.getElementById('award_fields');
            const newField = document.createElement('div');
            newField.className = 'award-item mb-4 p-4 border rounded-lg';
            newField.innerHTML = `
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" name="awards[][date]"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <div class="mt-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <input type="text" name="awards[][description]" placeholder="Deskripsi (opsional)"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <button type="button" class="remove-award mt-2 text-red-600 hover:text-red-800">Hapus</button>
            `;
            container.appendChild(newField);
            
            // Add event listener to the remove button
            newField.querySelector('.remove-award').addEventListener('click', function() {
                newField.remove();
            });
        });

        // Initialize remove event listeners for existing items (if any)
        document.querySelectorAll('.remove-career').forEach(button => {
            button.addEventListener('click', function() {
                this.parentElement.remove();
            });
        });
        
        document.querySelectorAll('.remove-education').forEach(button => {
            button.addEventListener('click', function() {
                this.parentElement.remove();
            });
        });
        
        document.querySelectorAll('.remove-award').forEach(button => {
            button.addEventListener('click', function() {
                this.parentElement.remove();
            });
        });
    </script>
@endsection