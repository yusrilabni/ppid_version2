@extends('admin.layouts.app')

@php
    $title_name = $official ? $official->full_name : ($unit ? 'Kepala ' . $unit->name : 'Jabatan');
@endphp

@section('title', 'Unggah LHKPN untuk ' . $title_name)

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Unggah LHKPN</h1>
                        <p class="mt-2 text-sm text-gray-600">Untuk Jabatan/Unit: <span class="font-semibold">{{ $title_name }}</span></p>
                    </div>
                    <a href="{{ route('admin.lhkpn.index') }}"
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
                                <i class="fas fa-file-invoice-dollar w-6 h-6 text-blue-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-lg font-semibold text-gray-900">Informasi Laporan LHKPN</h2>
                            <p class="text-sm text-gray-600">Lengkapi data berikut untuk mengunggah laporan</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('admin.lhkpn.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf
                    
                    <input type="hidden" name="unit_id" value="{{ $unit->id ?? '' }}">
                    <input type="hidden" name="position_id" value="{{ $position->id ?? '' }}">

                    @include('admin.lhkpn._form')

                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="text-sm text-gray-500">
                                <p>Pastikan semua informasi telah diisi dengan benar sebelum mengupload</p>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.lhkpn.index') }}"
                                    class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                    </svg>
                                    Unggah Laporan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Info Box -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Tips Upload</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Pastikan file PDF LHKPN sudah dalam format yang benar dan dapat dibaca</li>
                                <li>Ukuran file maksimal adalah 10MB</li>
                                <li>Format yang diizinkan hanya PDF</li>
                            </ul>
                        </div>
                    </div>
                </div>
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

                const event = new Event('change');
                input.dispatchEvent(event);
            }
        });
    </script>
@endsection
