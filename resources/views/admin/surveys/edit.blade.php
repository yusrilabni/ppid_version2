@extends('admin.layouts.app')

@section('title', 'Edit Survei')

@section('content')
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Edit Survei</h1>
                    <p class="text-gray-600 mt-1">Perbarui detail survei: {{ $survey->title }}</p>
                </div>
                <a href="{{ route('admin.surveys.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div class="flex items-center">
                        <div class="p-2 rounded-lg bg-blue-100 text-blue-600 mr-3">
                            <i class="fas fa-edit text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Informasi Survei</h2>
                            <p class="text-sm text-gray-600">Perbarui informasi dasar survei</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('admin.surveys.update', $survey) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Title -->
                        <div class="form-group">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-heading text-blue-500 mr-2 text-sm"></i>
                                Judul Survei *
                            </label>
                            <div class="relative">
                                <input type="text" name="title" id="title"
                                    class="block w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                    placeholder="Masukkan judul survei" value="{{ old('title', $survey->title) }}" required>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-edit text-gray-400"></i>
                                </div>
                            </div>
                            @error('title')
                                <div class="mt-2 flex items-center text-red-600 text-sm">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-align-left text-blue-500 mr-2 text-sm"></i>
                                Deskripsi Survei
                            </label>
                            <div class="relative">
                                <textarea name="description" id="description" rows="4"
                                    class="block w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                    placeholder="Deskripsikan tujuan survei ini">{{ old('description', $survey->description) }}</textarea>
                                <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                    <i class="fas fa-file-alt text-gray-400"></i>
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Deskripsi singkat tentang tujuan survei ini</p>
                            @error('description')
                                <div class="mt-2 flex items-center text-red-600 text-sm">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Status and Type in Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Status -->
                            <div class="form-group">
                                <label for="status"
                                    class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-toggle-on text-blue-500 mr-2 text-sm"></i>
                                    Status
                                </label>
                                <div class="relative">
                                    <select name="status" id="status"
                                        class="block w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition duration-150 ease-in-out">
                                        <option value="Draft" {{ old('status', $survey->status) == 'Draft' ? 'selected' : '' }}
                                            class="py-2">Draft</option>
                                        <option value="Aktif" {{ old('status', $survey->status) == 'Aktif' ? 'selected' : '' }}
                                            class="py-2">Aktif</option>
                                        <option value="Nonaktif" {{ old('status', $survey->status) == 'Nonaktif' ? 'selected' : '' }}
                                            class="py-2">Nonaktif</option>
                                    </select>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-flag text-gray-400"></i>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('status')
                                    <div class="mt-2 flex items-center text-red-600 text-sm">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div class="form-group">
                                <label for="type"
                                    class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-users text-blue-500 mr-2 text-sm"></i>
                                    Jenis Akses Survei
                                </label>
                                <div class="relative">
                                    <select name="type" id="type"
                                        class="block w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition duration-150 ease-in-out">
                                        <option value="default" {{ old('type', $survey->type) == 'default' ? 'selected' : '' }}
                                            class="py-2">Default</option>
                                        <option value="publik" {{ old('type', $survey->type) == 'publik' ? 'selected' : '' }}
                                            class="py-2">Publik</option>
                                        <option value="private" {{ old('type', $survey->type) == 'private' ? 'selected' : '' }}
                                            class="py-2">Private</option>
                                        <option value="skm" {{ old('type', $survey->type) == 'skm' ? 'selected' : '' }}
                                            class="py-2">SKM</option>
                                        <option value="ppid" {{ old('type', $survey->type) == 'ppid' ? 'selected' : '' }}
                                            class="py-2">Survei PPID</option>
                                    </select>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-globe text-gray-400"></i>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Tentukan akses survei</p>
                                @error('type')
                                    <div class="mt-2 flex items-center text-red-600 text-sm">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Date Range in Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Start Date -->
                            <div class="form-group">
                                <label for="start_date"
                                    class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-calendar-alt text-blue-500 mr-2 text-sm"></i>
                                    Tanggal Mulai
                                </label>
                                <div class="relative">
                                    <input type="datetime-local" name="start_date" id="start_date"
                                        class="block w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                        value="{{ old('start_date', $survey->start_date ? date('Y-m-d\TH:i', strtotime($survey->start_date)) : '') }}">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-play text-gray-400"></i>
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Opsional</p>
                                @error('start_date')
                                    <div class="mt-2 flex items-center text-red-600 text-sm">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- End Date -->
                            <div class="form-group">
                                <label for="end_date"
                                    class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-calendar-times text-blue-500 mr-2 text-sm"></i>
                                    Tanggal Selesai
                                </label>
                                <div class="relative">
                                    <input type="datetime-local" name="end_date" id="end_date"
                                        class="block w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                        value="{{ old('end_date', $survey->end_date ? date('Y-m-d\TH:i', strtotime($survey->end_date)) : '') }}">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-stop text-gray-400"></i>
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Opsional</p>
                                @error('end_date')
                                    <div class="mt-2 flex items-center text-red-600 text-sm">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div
                        class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Pastikan semua perubahan sudah benar sebelum disimpan
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.surveys.index') }}"
                                class="px-6 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 border border-transparent rounded-lg text-sm font-medium text-white hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition duration-150 ease-in-out flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Help Card -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-5">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-lightbulb text-blue-500 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Tips Memperbarui Survei</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Perubahan judul atau deskripsi akan langsung terlihat oleh responden</li>
                                <li>Jika Anda mengubah status menjadi "Nonaktif", responden tidak lagi bisa mengisi survei ini</li>
                                <li>Anda dapat mengatur ulang periode waktu survei melalui input tanggal</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            /* Custom styling for datetime-local inputs */
            input[type="datetime-local"]::-webkit-calendar-picker-indicator {
                background: transparent;
                bottom: 0;
                color: transparent;
                cursor: pointer;
                height: auto;
                left: 0;
                position: absolute;
                right: 0;
                top: 0;
                width: auto;
            }

            /* Smooth transitions */
            .form-group input:focus,
            .form-group select:focus,
            .form-group textarea:focus {
                transform: translateY(-1px);
            }

            /* Custom select dropdown styling */
            select {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
                background-position: right 0.5rem center;
                background-repeat: no-repeat;
                background-size: 1.5em 1.5em;
                padding-right: 2.5rem;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        </style>
    @endpush
@endsection