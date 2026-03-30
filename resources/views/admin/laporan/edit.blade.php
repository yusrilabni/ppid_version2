@extends('admin.layouts.app')

@section('title', 'Edit Laporan Tahunan')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Edit Laporan Tahunan</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            Perbarui informasi laporan: <span class="font-semibold text-blue-600">{{ $laporan->title }}</span>
                        </p>
                    </div>
                    <a href="{{ route('admin.laporan.index') }}"
                        class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-lg font-semibold text-gray-900">Informasi Laporan</h2>
                            <p class="text-sm text-gray-600">Perbarui data laporan tahunan yang telah diunggah</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('admin.laporan.update', $laporan) }}" method="POST" enctype="multipart/form-data"
                    class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Judul Laporan -->
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-medium text-gray-800">
                            Judul Laporan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="title" id="title" value="{{ old('title', $laporan->title) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 placeholder-gray-400 @error('title') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                            @error('title')
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('title')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Grid: Tahun dan Status -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tahun -->
                        <div class="space-y-2">
                            <label for="tahun" class="block text-sm font-medium text-gray-800">
                                Tahun Laporan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="tahun" id="tahun" value="{{ old('tahun', $laporan->tahun) }}"
                                    min="2000" max="{{ date('Y') + 1 }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('tahun') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                                @error('tahun')
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('tahun')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-800">Status Publikasi</label>
                            <div class="flex items-center p-3 bg-gray-50 border border-gray-200 rounded-lg">
                                <input type="checkbox" name="published" value="1" id="published"
                                    {{ old('published', $laporan->published) ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="published" class="ml-3 text-sm text-gray-700 cursor-pointer">
                                    Terbitkan laporan ke publik
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="space-y-2">
                        <label for="content" class="block text-sm font-medium text-gray-800">
                            Deskripsi Singkat <span class="text-gray-400">(Opsional)</span>
                        </label>
                        <textarea name="content" id="content" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 resize-none">{{ old('content', $laporan->content) }}</textarea>
                    </div>

                    <!-- Current Files and Upload Section -->
                    <div class="space-y-6 pt-4 border-t border-gray-100">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Berkas Laporan
                        </h3>

                        <!-- Current Files Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Info current PDF -->
                            <div class="bg-blue-50/50 rounded-xl p-4 border border-blue-100 h-full">
                                <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-2">File PDF Saat Ini</p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center min-w-0 mr-4">
                                        <div class="p-2 bg-white rounded-lg shadow-sm mr-3">
                                            <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate max-w-[150px] sm:max-w-[200px]" title="{{ basename($laporan->file) }}">
                                                {{ basename($laporan->file) }}
                                            </p>
                                            <p class="text-[10px] text-gray-500">File Tersedia</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2 shrink-0">
                                        <a href="{{ asset('storage/' . $laporan->file) }}" target="_blank" 
                                           class="px-3 py-1 bg-white border border-gray-200 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                                            Lihat
                                        </a>
                                        <a href="{{ asset('storage/' . $laporan->file) }}" download
                                           class="px-3 py-1 bg-blue-600 rounded-md text-xs font-medium text-white hover:bg-blue-700 transition-colors shadow-sm">
                                            Download
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Info current Cover -->
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 h-full">
                                <p class="text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Cover Saat Ini</p>
                                <div class="flex items-center">
                                    @if($laporan->cover)
                                        <img src="{{ asset('storage/' . $laporan->cover) }}" alt="Cover" class="h-14 w-10 object-cover rounded shadow-sm mr-4">
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate max-w-[150px]" title="{{ basename($laporan->cover) }}">
                                                {{ basename($laporan->cover) }}
                                            </p>
                                            <p class="text-[10px] text-gray-500">Thumbnail Aktif</p>
                                        </div>
                                    @else
                                        <div class="h-14 w-10 bg-gray-200 rounded flex items-center justify-center mr-4">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Tidak ada cover</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Upload New Files Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Upload new PDF -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-800">Ganti File PDF</label>
                                <div class="relative group">
                                    <input type="file" name="file" id="file" accept="application/pdf"
                                        class="hidden" onchange="previewFileName(this, 'pdf-preview')">
                                    <label for="file"
                                        class="flex flex-col items-center justify-center w-full h-32 px-4 transition-all duration-200 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50 group-hover:border-blue-400">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                            </svg>
                                            <p class="text-xs text-gray-500"><span class="font-semibold">Klik untuk ganti file</span></p>
                                            <p class="text-[10px] text-gray-400 mt-1">PDF (Max. 10MB)</p>
                                        </div>
                                    </label>
                                </div>
                                <div id="pdf-preview" class="hidden mt-2 p-2 bg-green-50 border border-green-200 rounded-lg">
                                    <p class="text-xs text-green-700 truncate" id="file-file-name"></p>
                                </div>
                                @error('file')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Upload new Cover -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-800">Ganti Cover Laporan</label>
                                <div class="relative group">
                                    <input type="file" name="cover" id="cover" accept="image/*" class="hidden"
                                        onchange="previewFileName(this, 'cover-preview')">
                                    <label for="cover"
                                        class="flex flex-col items-center justify-center w-full h-32 px-4 transition-all duration-200 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50 group-hover:border-blue-400">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-xs text-gray-500"><span class="font-semibold">Klik untuk ganti cover</span></p>
                                            <p class="text-[10px] text-gray-400 mt-1">JPG, PNG (Max. 2MB)</p>
                                        </div>
                                    </label>
                                </div>
                                <div id="cover-preview" class="hidden mt-2 p-2 bg-green-50 border border-green-200 rounded-lg">
                                    <p class="text-xs text-green-700 truncate" id="cover-file-name"></p>
                                </div>
                                @error('cover')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-4">
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.laporan.index') }}"
                                    class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-sm transition-all duration-200 hover:shadow-md flex items-center">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewFileName(input, previewId) {
            const file = input.files[0];
            if (file) {
                const previewElement = document.getElementById(previewId);
                const fileNameElement = document.getElementById(input.id + '-file-name');

                previewElement.classList.remove('hidden');
                fileNameElement.textContent = file.name;
            }
        }

        // Drag and drop functionality
        document.querySelectorAll('input[type="file"]').forEach(input => {
            const label = input.nextElementSibling;

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                label.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                label.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                label.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                label.classList.add('border-blue-500', 'bg-blue-50');
            }

            function unhighlight() {
                label.classList.remove('border-blue-500', 'bg-blue-50');
            }

            label.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                input.files = files;

                // Trigger change event
                const event = new Event('change');
                input.dispatchEvent(event);
            }
        });
    </script>
@endsection