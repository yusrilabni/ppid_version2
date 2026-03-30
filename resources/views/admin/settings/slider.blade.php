@extends('admin.layouts.app')

@section('title', 'Pengaturan Slider')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">Pengaturan Durasi Transisi Slider</h2>
            <p class="text-gray-600">Atur berapa detik setiap slider akan berpindah secara otomatis di halaman depan.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

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

        <form action="{{ route('admin.slider-settings.update') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="duration_in_seconds" class="block text-sm font-medium text-gray-700 mb-2">Durasi Transisi (detik)</label>
                <input type="number" name="duration_in_seconds" id="duration_in_seconds" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" value="{{ old('duration_in_seconds', $durationInSeconds) }}" min="1" required>
                <p class="mt-2 text-sm text-gray-500">Masukkan durasi dalam detik (minimal 1 detik).</p>
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                    Simpan Pengaturan
                </button>
                <a href="{{ route('admin.sliders.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-6 rounded-lg transition">
                    Kembali ke Manajemen Slider
                </a>
            </div>
        </form>
    </div>
@endsection
