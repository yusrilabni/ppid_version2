@extends('frontend.layouts.app')

@section('title', 'Tambah Informasi Pemkab')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <x-breadcrumbs :breadcrumbs="[['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],['title' => 'Informasi Pemkab', 'url' => route('frontend.informasi-pemkab.index'), 'icon' => 'fas fa-file-alt'],['title' => 'Tambah Dokumen', 'url' => '#', 'icon' => 'fas fa-plus-circle'],]" />

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 text-white flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold">Tambah Dokumen Informasi Pemkab</h1>
                    <p class="text-blue-100 mt-1">Tambahkan dokumen baru ke dalam sistem transparansi</p>
                </div>
            </div>

            <div class="p-6" x-data="pemkabForm()">
                <form action="{{ route('admin.informasi-pemkab.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Judul -->
                        <div class="md:col-span-2">
                            <label for="judul" class="block text-gray-700 text-sm font-semibold mb-2">Judul Dokumen <span class="text-red-500">*</span></label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required placeholder="Masukkan judul dokumen"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            @error('judul')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="md:col-span-2">
                            <label for="deskripsi" class="block text-gray-700 text-sm font-semibold mb-2">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Deskripsi singkat dokumen"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        @php
                            $kategoriOptions = collect($kategori_jenis)->keys()->map(function($kat) {
                                return ['value' => $kat, 'label' => $kat];
                            })->toArray();
                        @endphp
                        <div class="relative z-50">
                            <label for="kategori" class="block text-gray-700 text-sm font-semibold mb-2">Kategori <span class="text-red-500">*</span></label>
                            <x-custom-select 
                                name="kategori" 
                                :options="$kategoriOptions" 
                                :value="old('kategori')"
                                placeholder="Pilih Kategori"
                                :searchable="false"
                                required="true"
                                @change="kategoriChanged($event.detail.value)"
                            />
                            @error('kategori')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Dokumen -->
                        <div class="relative z-40">
                            <label for="jenis_dokumen" class="block text-gray-700 text-sm font-semibold mb-2">Jenis Dokumen <span class="text-red-500">*</span></label>
                            <x-custom-select 
                                name="jenis_dokumen" 
                                :options="[]" 
                                :value="old('jenis_dokumen')"
                                placeholder="Pilih Jenis Dokumen"
                                :searchable="false"
                                required="true"
                            />
                            @error('jenis_dokumen')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tahun -->
                        <div>
                            <label for="tahun" class="block text-gray-700 text-sm font-semibold mb-2">Tahun Dokumen <span class="text-red-500">*</span></label>
                            <input type="number" name="tahun" id="tahun" value="{{ old('tahun', date('Y')) }}" required min="2000" max="2099"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            @error('tahun')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipe Upload & Input File/URL -->
                        <div class="md:col-span-2 border border-gray-200 rounded-xl p-4 bg-gray-50/50">
                            <label class="block text-gray-700 text-sm font-semibold mb-3">Pilih Metode Upload <span class="text-red-500">*</span></label>
                            
                            <div class="flex space-x-6 mb-4">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="upload_method" value="file" x-model="uploadMethod" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Upload File Lokal</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="upload_method" value="link" x-model="uploadMethod" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Link Eksternal (Google Drive / Lainnya)</span>
                                </label>
                            </div>
                            @error('upload_method')
                                <p class="text-red-500 text-xs mt-1 mb-4">{{ $message }}</p>
                            @enderror

                            <!-- Input File Lokal -->
                            <div x-show="uploadMethod === 'file'" x-cloak>
                                <label for="file" class="block text-gray-700 text-sm font-semibold mb-2">Pilih File <span class="text-red-500">*</span></label>
                                <input type="file" name="file" id="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar"
                                    x-bind:required="uploadMethod === 'file'"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition duration-200">
                                <p class="text-xs text-gray-500 mt-1">Format: PDF, Word, Excel, ZIP, RAR. Maks: 10MB</p>
                                @error('file')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Input Link Eksternal -->
                            <div x-show="uploadMethod === 'link'" x-cloak>
                                <label for="link" class="block text-gray-700 text-sm font-semibold mb-2">URL Dokumen <span class="text-red-500">*</span></label>
                                <input type="url" name="link" id="link" value="{{ old('link') }}" placeholder="https://drive.google.com/..."
                                    x-bind:required="uploadMethod === 'link'"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                <p class="text-xs text-gray-500 mt-1">Pastikan link dapat diakses secara publik.</p>
                                @error('link')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-4">
                        <a href="{{ route('admin.informasi-pemkab.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition duration-200 flex items-center">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 shadow-md hover:shadow-lg transition duration-200 flex items-center">
                            <i class="fas fa-save mr-2"></i> Simpan Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('pemkabForm', () => ({
            mapping: @json($kategori_jenis),
            uploadMethod: '{{ old('upload_method', 'file') }}',
            
            init() {
                // Initialize jenis options if old value exists
                let initialKat = '{{ old('kategori') }}';
                if (initialKat) {
                    this.kategoriChanged(initialKat);
                }
            },
            
            kategoriChanged(val) {
                let opts = [];
                if (val && this.mapping[val]) {
                    opts = this.mapping[val].map(item => ({value: item, label: item}));
                }
                
                // Dispatch event to update the jenis_dokumen custom-select component
                window.dispatchEvent(new CustomEvent('update-options', {
                    detail: { target: 'jenis_dokumen', data: opts }
                }));
            }
        }));
    });
</script>
@endsection
