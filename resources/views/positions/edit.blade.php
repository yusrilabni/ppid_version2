@extends('admin.layouts.app')

@section('title', 'Edit Jabatan')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">Edit Jabatan</h2>
            <p class="text-gray-600">Perbarui informasi jabatan dalam struktur organisasi</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-start">
                <div>
                    <i class="fas fa-exclamation-triangle mr-2 text-red-500"></i>
                </div>
                <div>
                    <strong class="font-bold">Ups!</strong>
                    <span class="block">Terjadi beberapa masalah dengan input Anda.</span>
                    <ul class="mt-1 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.positions.update', $position) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Nama Jabatan</label>
                <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" value="{{ old('title', $position->title) }}" required>
            </div>

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Pegawai (Opsional)</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" value="{{ old('name', $position->name) }}">
                <p class="mt-2 text-sm text-gray-500">Nama pegawai yang menjabat di posisi ini (opsional)</p>
            </div>

            <div class="mb-6">
                <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">Jabatan Atasan (Opsional)</label>
                <select name="parent_id" id="parent_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">-- Tidak Ada (Jabatan Tertinggi) --</option>
                    @foreach($allPositions as $pos)
                        @if($pos->id !== $position->id)
                            <option value="{{ $pos->id }}" {{ old('parent_id', $position->parent_id) == $pos->id ? 'selected' : '' }}>
                                {{ $pos->title }} - {{ $pos->name ?: 'Kosong' }}
                            </option>
                        @endif
                    @endforeach
                </select>
                <p class="mt-2 text-sm text-gray-500">Pilih jabatan atasan jika ini adalah bawahan dari jabatan lain</p>
            </div>

            <div class="mb-6">
                <label for="order_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Urut</label>
                <input type="number" name="order_number" id="order_number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" value="{{ old('order_number', $position->order_number) }}" min="0">
                <p class="mt-2 text-sm text-gray-500">Nomor urut untuk mengatur urutan penampilan (semakin kecil nilai, semakin tinggi posisinya)</p>
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                    Perbarui Jabatan
                </button>
                <a href="{{ route('admin.positions.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-6 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection