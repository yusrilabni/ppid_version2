@extends('frontend.layouts.app')

@section('title', 'Edit Informasi Pemkab')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <x-breadcrumbs :breadcrumbs="[['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],['title' => 'Informasi Pemkab', 'url' => route('frontend.informasi-pemkab.index'), 'icon' => 'fas fa-file-alt'],['title' => 'Edit Dokumen', 'url' => '#', 'icon' => 'fas fa-edit'],]" />

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-700 p-6 text-white flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold">Edit Dokumen Informasi Pemkab</h1>
                    <p class="text-yellow-100 mt-1">Ubah formulir di bawah ini untuk memperbarui dokumen</p>
                </div>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.informasi-pemkab.update', $informasi_pemkab->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Judul -->
                        <div class="md:col-span-2">
                            <label for="judul" class="block text-gray-700 text-sm font-semibold mb-2">Judul Dokumen <span class="text-red-500">*</span></label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul', $informasi_pemkab->judul) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                            @error('judul')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="md:col-span-2">
                            <label for="deskripsi" class="block text-gray-700 text-sm font-semibold mb-2">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">{{ old('deskripsi', $informasi_pemkab->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="relative" style="z-index: 50;">
                            <label for="kategori" class="block text-gray-700 text-sm font-semibold mb-2">Kategori <span class="text-red-500">*</span></label>
                            <select name="kategori" id="kategori" required class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200 transition custom-select2">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategori_jenis as $kat => $jenis)
                                    <option value="{{ $kat }}" {{ old('kategori', $informasi_pemkab->kategori) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Dokumen -->
                        <div class="relative" style="z-index: 49;">
                            <label for="jenis_dokumen" class="block text-gray-700 text-sm font-semibold mb-2">Jenis Dokumen <span class="text-red-500">*</span></label>
                            <select name="jenis_dokumen" id="jenis_dokumen" required disabled class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-200 transition bg-gray-100 cursor-not-allowed custom-select2">
                                <option value="">-- Pilih Kategori Terlebih Dahulu --</option>
                            </select>
                            @error('jenis_dokumen')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tahun -->
                        <div>
                            <label for="tahun" class="block text-gray-700 text-sm font-semibold mb-2">Tahun Dokumen <span class="text-red-500">*</span></label>
                            <input type="number" name="tahun" id="tahun" value="{{ old('tahun', $informasi_pemkab->tahun) }}" required min="2000" max="2099"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                            @error('tahun')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div>
                            <label for="file" class="block text-gray-700 text-sm font-semibold mb-2">Upload File Dokumen (Biarkan kosong jika tidak ingin mengubah)</label>
                            <input type="file" name="file" id="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100 transition duration-200">
                            <p class="text-xs text-gray-500 mt-1">Format: PDF, Word, Excel, ZIP, RAR. Maks: 10MB</p>
                            
                            @if($informasi_pemkab->file_path)
                                <div class="mt-2 text-sm text-yellow-600 font-semibold">
                                    <a href="{{ asset('storage/' . $informasi_pemkab->file_path) }}" target="_blank" class="hover:underline">
                                        <i class="fas fa-file-download mr-1"></i> File Saat Ini
                                    </a>
                                </div>
                            @endif
                            @error('file')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-4">
                        <a href="{{ route('admin.informasi-pemkab.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition duration-200 flex items-center">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 shadow-md hover:shadow-lg transition duration-200 flex items-center">
                            <i class="fas fa-save mr-2"></i> Perbarui Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Select2 & Logic -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 42px !important;
        border: 1px solid #d1d5db !important;
        border-radius: 0.5rem !important;
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #374151 !important;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    const mapping = @json($kategori_jenis);
    const oldJenis = "{{ old('jenis_dokumen', $informasi_pemkab->jenis_dokumen) }}";
    
    $(document).ready(function() {
        $('.custom-select2').select2({
            width: '100%',
            dropdownAutoWidth: true
        });

        $('#kategori').on('change', function() {
            let kategori = $(this).val();
            let $jenis = $('#jenis_dokumen');
            
            $jenis.empty();
            
            if (kategori && mapping[kategori]) {
                $jenis.prop('disabled', false);
                $jenis.removeClass('bg-gray-100 cursor-not-allowed');
                $jenis.append('<option value="">-- Pilih Jenis Dokumen --</option>');
                
                mapping[kategori].forEach(function(item) {
                    let selected = (oldJenis === item) ? 'selected' : '';
                    $jenis.append(`<option value="${item}" ${selected}>${item}</option>`);
                });
            } else {
                $jenis.prop('disabled', true);
                $jenis.addClass('bg-gray-100 cursor-not-allowed');
                $jenis.append('<option value="">-- Pilih Kategori Terlebih Dahulu --</option>');
            }
        });

        // Trigger on load to set Jenis Dokumen
        if ($('#kategori').val()) {
            $('#kategori').trigger('change');
        }
    });
</script>
@endsection
