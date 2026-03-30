@extends('admin.layouts.app')

@section('title', 'Kelola OPD')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Kelola OPD - {{ $organization->name }}</h2>
                <p class="text-gray-600">Unggah gambar OPD.</p>
            </div>
            <a href="{{ route('opd.list') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <strong class="font-bold">Ups!</strong>
                <ul class="mt-1 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.my-structure.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="max-w-lg mx-auto">

                {{-- Structure Image Upload --}}
                <div>
                    <label for="structure_image" class="block text-sm font-medium text-gray-700 mb-2">Gambar OPD (.webp, .jpg, .png)</label>
                    <input type="file" name="structure_image" id="structure_image" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" accept="image/*">
                    <p class="mt-1 text-sm text-gray-500">Maksimal 10MB. Akan dikonversi menjadi WebP.</p>
                    @if($struktur->image_path)
                        <div class="mt-4">
                            <p class="text-sm font-semibold text-gray-600 mb-2">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $struktur->image_path) }}" alt="Gambar OPD" class="w-full rounded-lg border border-gray-200 shadow-sm">
                        </div>
                    @endif
                </div>

            </div>

            <div class="mt-8 border-t pt-6 flex justify-end max-w-lg mx-auto">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
