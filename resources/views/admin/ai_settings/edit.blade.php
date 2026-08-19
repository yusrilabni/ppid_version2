@extends('admin.layouts.app')

@section('title', 'Edit Pengaturan AI')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">Edit API Key AI</h2>
            <p class="text-gray-600">Perbarui detail API key.</p>
        </div>

        <form action="{{ route('admin.ai-settings.update', $aiSetting) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="provider" class="block text-sm font-medium text-gray-700 mb-1">Provider AI</label>
                    <input type="text" name="provider" id="provider" value="{{ old('provider', $aiSetting->provider) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('provider')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="model" class="block text-sm font-medium text-gray-700 mb-1">Model (Kosongkan atau ketik "auto" untuk deteksi otomatis dari sistem)</label>
                    <input type="text" name="model" id="model" value="{{ old('model', $aiSetting->model) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Biarkan berisi "auto", sistem akan mendeteksi dan memilih model terbaik (misal gemini-2.5-flash) yang tersedia di API Key Anda.</p>
                    @error('model')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="api_key" class="block text-sm font-medium text-gray-700 mb-1">API Key</label>
                    <input type="text" name="api_key" id="api_key" value="{{ old('api_key', $aiSetting->api_key) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('api_key')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $aiSetting->is_active) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Aktifkan API Key ini (Sistem otomatis mencoba semua key yang aktif jika salah satu limit)
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.ai-settings.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg transition">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
