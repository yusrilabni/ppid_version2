@extends('admin.layouts.app')

@section('title', 'Tambah OPD Baru')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">Tambah OPD Baru</h2>
            <p class="text-gray-600">Tambahkan OPD baru dengan informasi yang diperlukan</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-start">
                <div>
                    <i class="fas fa-exclamation-triangle mr-2 text-red-500"></i>
                </div>
                <div>
                    <strong class="font-bold">Ups!</strong>
                    <span class="block">Terjadi beberapa masalah dengan input Anda.</span>
                    <ul class="mt-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.organizations.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="unit_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Unit *</label>
                <select name="unit_id" id="unit_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" required>
                    <option value="">Pilih OPD</option>
                    @if(!empty($units))
                        @foreach($units as $unit)
                            <option value="{{ $unit['unit_id'] }}" data-name="{{ $unit['unit_nama'] }}" {{ old('unit_id') == $unit['unit_id'] ? 'selected' : '' }}>
                                {{ $unit['unit_nama'] }}
                            </option>
                        @endforeach
                    @else
                        <option value="" disabled>Gagal memuat data OPD dari API.</option>
                    @endif
                </select>
                <input type="hidden" name="name" id="name">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Tipe *</label>
                    <select name="type" id="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" required>
                        <option value="opd" {{ old('type', 'opd') == 'opd' ? 'selected' : '' }}>OPD</option>
                        <option value="kecamatan" {{ old('type') == 'kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                        <option value="unit" {{ old('type') == 'unit' ? 'selected' : '' }}>Unit</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" required>
                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                    Simpan OPD
                </button>
                <a href="{{ route('admin.organizations.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-6 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const unitSelect = document.getElementById('unit_id');
                const nameInput = document.getElementById('name');

                unitSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    if (selectedOption && selectedOption.value) {
                        nameInput.value = selectedOption.getAttribute('data-name');
                    } else {
                        nameInput.value = '';
                    }
                });

                // Initialize on page load in case of old input
                if (unitSelect.value) {
                    const selectedOption = unitSelect.options[unitSelect.selectedIndex];
                    if (selectedOption && selectedOption.value) {
                        nameInput.value = selectedOption.getAttribute('data-name');
                    }
                }
            });
        </script>
    </div>
@endsection