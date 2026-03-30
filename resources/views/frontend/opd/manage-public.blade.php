@extends('frontend.layouts.app')

@section('title', 'Kelola Tentang OPD')

@section('content')
<div x-data>
    <div class="container mx-auto py-8 px-4">
        <div class="max-w-4xl mx-auto">
            <x-breadcrumbs :breadcrumbs="[['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],['title' => 'Tentang OPD', 'url' => route('opd.detail', $organization), 'icon' => 'fas fa-building'],['title' => 'Kelola Tentang OPD', 'url' => request()->fullUrl(), 'icon' => 'fas fa-pencil-alt'],]" />

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 text-white flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">Kelola Tentang OPD - {{ $organization->name }}</h1>
                        <p class="text-blue-100 mt-1">Kelola gambar struktur dan tautan website OPD</p>
                    </div>
                </div>

                <div class="p-6">
                    @if (session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                            <strong class="font-medium">Whoops!</strong>
                            <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('opd.update-public', $organization) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="max-w-lg mx-auto">

                            {{-- Structure Image Upload --}}
                            <div class="mb-6">
                                <label for="structure_image" class="block text-gray-700 text-sm font-semibold mb-2">Gambar Tentang OPD (.webp, .jpg, .png)</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors duration-200" id="fileDropZone">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3" id="fileIcon"></i>
                                        <p class="text-gray-600 mb-2">Pilih file untuk diupload</p>
                                        <p class="text-gray-500 text-sm mb-3">Maksimal 10MB. Akan dikonversi menjadi WebP.</p>
                                        <input type="file" name="structure_image" id="structure_image" class="hidden" onchange="validateFile(this)">
                                        <label for="structure_image" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg cursor-pointer transition duration-200">Pilih File</label>
                                        <p id="fileErrorMessage" class="mt-2 text-red-500 text-sm hidden"></p>
                                        <div id="fileNameDisplay" class="mt-3 text-sm hidden"></div>
                                        <div id="fileSizeDisplay" class="text-xs hidden"></div>
                                    </div>
                                </div>
                                @if($struktur->image_path)
                                    <div class="mt-4">
                                        <p class="text-sm font-semibold text-gray-600 mb-2">Gambar Saat Ini:</p>
                                        <img src="{{ asset('storage/' . $struktur->image_path) }}" alt="Tentang OPD" class="w-full rounded-lg border border-gray-200 shadow-sm">
                                    </div>
                                @endif
                            </div>

                            {{-- Website URL Input --}}
                            <div class="mt-6">
                                <label for="website_url" class="block text-gray-700 text-sm font-semibold mb-2">Link Website OPD (Opsional)</label>
                                <input type="url" name="website_url" id="website_url" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" value="{{ old('website_url', $organization->website_url) }}" placeholder="https://www.example.com">
                                <p class="mt-1 text-sm text-gray-500">Masukkan URL lengkap website resmi OPD (misal: https://sinjaikab.go.id)</p>
                            </div>

                        </div>

                        <div class="mt-8 border-t pt-6 flex justify-end max-w-lg mx-auto">
                            <a href="{{ route('opd.detail', $organization) }}" class="px-6 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition duration-200">Batal</a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200 ml-3">
                                <i class="fas fa-save mr-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function validateFile(input) {
        const file = input.files[0];
        const fileNameDisplay = document.getElementById('fileNameDisplay');
        const fileSizeDisplay = document.getElementById('fileSizeDisplay');
        const fileIcon = document.getElementById('fileIcon');
        const fileErrorMessage = document.getElementById('fileErrorMessage');

        // Clear previous error messages
        fileErrorMessage.textContent = '';
        fileErrorMessage.classList.add('hidden');
        
        // Reset icon to default state before processing
        fileIcon.classList.remove('fa-check-circle', 'fa-times-circle', 'text-green-500', 'text-red-500');
        fileIcon.classList.add('fa-cloud-upload-alt', 'text-gray-400');


        if (file) {
            const fileSize = file.size;
            const fileName = file.name;
            const maxFileSize = 10 * 1024 * 1024; // 10MB

            if (fileSize > maxFileSize) {
                fileErrorMessage.textContent = 'Ukuran file melebihi batas maksimal 10MB. Silakan pilih file yang lebih kecil.';
                fileErrorMessage.classList.remove('hidden');
                input.value = ''; // Clear the file input
                fileNameDisplay.textContent = '';
                fileNameDisplay.classList.add('hidden');
                fileSizeDisplay.textContent = '';
                fileSizeDisplay.classList.add('hidden');
                // Change icon to show error
                fileIcon.classList.remove('fa-cloud-upload-alt', 'text-gray-400');
                fileIcon.classList.add('fa-times-circle', 'text-red-500');
                return;
            }
            
            // Display file info with green color
            fileNameDisplay.textContent = `File: ${fileName}`;
            fileSizeDisplay.textContent = `Ukuran: ${(fileSize / 1024).toFixed(2)} KB`;
            
            fileNameDisplay.classList.remove('hidden');
            fileSizeDisplay.classList.remove('hidden');
            fileNameDisplay.classList.add('text-green-600');
            fileSizeDisplay.classList.add('text-green-600');


            // Change icon to show success
            fileIcon.classList.remove('fa-cloud-upload-alt', 'text-gray-400');
            fileIcon.classList.add('fa-check-circle', 'text-green-500');
        } else {
            // No file selected or selection cancelled, reset everything to default
            fileNameDisplay.textContent = '';
            fileNameDisplay.classList.add('hidden');
            fileSizeDisplay.textContent = '';
            fileSizeDisplay.classList.add('hidden');
            
            fileNameDisplay.classList.remove('text-green-600');
            fileSizeDisplay.classList.remove('text-green-600');

            // Icon is already reset at the top of the function
        }
    }
</script>
@endpush
