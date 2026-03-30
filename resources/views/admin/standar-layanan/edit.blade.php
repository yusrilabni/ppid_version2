@extends('admin.layouts.app')

@section('title', 'Edit File Standar Layanan')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 text-white">
                <h1 class="text-2xl font-bold">Edit File Standar Layanan</h1>
                <p class="text-blue-100 mt-1">Perbarui detail file untuk Standar Layanan.</p>
            </div>

            <div class="p-6">
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                        <strong class="font-bold">Whoops!</strong> Ada beberapa masalah dengan input Anda:
                        <ul class="mt-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.standar-layanan.update', $standarLayanan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        @if($isSuperAdmin)
                        <div class="md:col-span-2">
                            <label for="unit_id" class="block text-gray-700 text-sm font-semibold mb-2">Unit Kerja (Dinas) <span class="text-red-500">*</span></label>
                            <select name="unit_id" id="unit_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                                <option value="">Pilih Unit Kerja</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit['unit_id'] }}" {{ old('unit_id', $informasi->unit_id ?? '') == $unit['unit_id'] ? 'selected' : '' }}>
                                        {{ $unit['unit_nama'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Unit Kerja (Dinas)</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed" value="{{ $userUnitName }}" readonly>
                            <input type="hidden" name="unit_id" value="{{ $userUnitId }}">
                        </div>
                        @endif

                        <div class="md:col-span-2">
                            <label for="standar_layanan_id" class="block text-gray-700 text-sm font-semibold mb-2">Kategori Standar Layanan</label>
                            <select name="standar_layanan_id" id="standar_layanan_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                                <option value="">Pilih Kategori...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('standar_layanan_id', $standarLayanan->standar_layanan_id) == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul File</label>
                            <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" value="{{ old('title', $standarLayanan->title) }}" required>
                        </div>
                        <div class="md:col-span-2">
                            <label for="tahun_dokumen" class="block text-sm font-medium text-gray-700 mb-2">Tahun Dokumen</label>
                            <input type="date" name="tahun_dokumen" id="tahun_dokumen" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" value="{{ old('tahun_dokumen', \Carbon\Carbon::parse($standarLayanan->tahun_dokumen)->format('Y-m-d')) }}" required>
                        </div>
                        <div class="md:col-span-1">
                            <label for="category" class="block text-gray-700 text-sm font-semibold mb-2">Kategori Informasi <span class="text-red-500">*</span></label>
                            <select name="category" id="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($informasi_categories as $category)
                                    <option value="{{ $category }}" {{ old('category', $standarLayanan->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-1">
                            <label for="jenis_dokumen" class="block text-gray-700 text-sm font-semibold mb-2">Jenis Dokumen</label>
                            <select name="jenis_dokumen" id="jenis_dokumen" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                onchange="updateJenisDokumenDescription(this)"
                                onfocus="handleJenisDokumenFocus(this)"
                                onblur="handleJenisDokumenBlur(this)"
                                onmousedown="handleJenisDokumenFocus(this)">
                                <option value="">Pilih Jenis Dokumen</option>
                                @foreach($jenis_dokumen as $value => $label)
                                    @php
                                        $desc = '';
                                        if (strpos($label, '(') !== false) {
                                            $desc = substr($label, strpos($label, '(') + 1, -1);
                                        }
                                    @endphp
                                    <option value="{{ $value }}" data-desc="{{ $desc }}" {{ old('jenis_dokumen', $standarLayanan->jenis_dokumen) == $value ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div id="jenis_dokumen_desc" class="mt-2 text-xs text-blue-600 font-medium italic min-h-[1rem]"></div>
                        </div>
                        <div class="md:col-span-2">
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Status <span class="text-red-500">*</span></label>
                                <div class="flex space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="BERLAKU" class="form-radio h-4 w-4 text-blue-600" {{ old('status', $informasi->status) == 'BERLAKU' ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Berlaku</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="ARSIP" class="form-radio h-4 w-4 text-blue-600" {{ old('status', $informasi->status) == 'ARSIP' ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Arsip</span>
                                    </label>
                                </div>
                                <p class="text-red-500 text-xs mt-2">Pilih "BERLAKU" untuk dokumen yang masih sah digunakan saat ini (baik lama maupun baru), dan gunakan "ARSIP" hanya jika dokumen tersebut sudah kedaluwarsa atau telah diperbarui.</p>
                            </div>
                    </div>

                        <div class="mb-8">
                            <label class="block text-gray-700 text-sm font-semibold mb-2">File <span class="text-red-500">*</span></label>
                            
                            <div class="mb-4 flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="file_type" value="upload" class="form-radio h-4 w-4 text-blue-600" onchange="toggleFileInput()" {{ old('file_type', $standarLayanan->file_type ?? 'upload') == 'upload' ? 'checked' : '' }}>
                                    <span class="ml-2">Upload File</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="file_type" value="url" class="form-radio h-4 w-4 text-blue-600" onchange="toggleFileInput()" {{ old('file_type', $standarLayanan->file_type ?? 'upload') == 'url' ? 'checked' : '' }}>
                                    <span class="ml-2">Link File</span>
                                </label>
                            </div>

                            <div id="uploadField" class="mb-6">
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors duration-200" id="fileDropZone">
                                    <div class="flex flex-col items-center justify-center">
                                        @if ($standarLayanan->file)
                                        <div class="mb-4 p-4 bg-gray-100 rounded-lg w-full">
                                            <p class="text-sm text-gray-700 font-semibold">File saat ini:</p>
                                            <a href="{{ asset('storage/' . $standarLayanan->file) }}" target="_blank" class="text-blue-600 hover:underline">{{ $standarLayanan->file }}</a>
                                            
                                            @php
                                                $fileExtension = pathinfo($standarLayanan->file, PATHINFO_EXTENSION);
                                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                            @endphp

                                            @if (in_array(strtolower($fileExtension), $imageExtensions))
                                                <div class="mt-4">
                                                    <img src="{{ asset('storage/' . $standarLayanan->file) }}" alt="Preview" class="max-w-xs rounded-lg shadow-md mx-auto">
                                                </div>
                                            @endif
                                            <p class="text-xs text-gray-500 mt-2">Mengunggah file baru akan menggantikan file yang sudah ada.</p>
                                        </div>
                                        @endif
                                                                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3" id="fileIcon"></i>
                                        <p class="text-gray-600 mb-2">Pilih file untuk diupload</p>
                                        <p class="text-gray-500 text-sm mb-3">Format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX (Max 2MB) / JPG, PNG, JPEG (Max 10MB)</p>
                                        <input type="file" name="file" id="file" class="hidden" onchange="validateFile(this)">
                                        <label for="file" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg cursor-pointer transition duration-200">Pilih File</label>
                                        <div id="fileNameDisplay" class="mt-3 text-sm text-gray-600 hidden"></div>
                                        <div id="fileSizeDisplay" class="text-xs text-gray-500 hidden"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="urlField" class="mb-6" style="display: none;">
                                <label for="url" class="block text-gray-700 text-sm font-semibold mb-2">Link File (untuk file > 2MB)</label>
                                <input type="url" name="url" id="url" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" placeholder="https://contoh.com/file.pdf" value="{{ old('url', $standarLayanan->url) }}">
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">Update File</button>
                            <a href="{{ route('admin.standar-layanan.index') }}" class="px-6 py-2 border border-gray-300 text-gray-800 font-medium rounded-lg hover:bg-gray-50 transition duration-200">Batal</a>
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
    function toggleFileInput() {
        const uploadField = document.getElementById('uploadField');
        const urlField = document.getElementById('urlField');
        const fileRadio = document.querySelector('input[name="file_type"]:checked');
        const fileInput = document.getElementById('file');
        const urlInput = document.getElementById('url');
        const hasExistingFile = {{ $standarLayanan->file ? 'true' : 'false' }};
        const defaultUploadDisplay = document.querySelector('#fileDropZone .flex-col');
        const existingFileDisplay = document.querySelector('#fileDropZone .existing-file-display');
        const fileIcon = document.getElementById('fileIcon');
        const chooseFileText = document.querySelector('#fileDropZone p.text-gray-600');
        const fileFormatsText = document.querySelector('#fileDropZone p.text-gray-500');
        const chooseFileButton = document.querySelector('#fileDropZone label[for="file"]');
        
        if (fileRadio && fileRadio.value === 'url') {
            uploadField.style.display = 'none';
            fileInput.removeAttribute('required');
            urlField.style.display = 'block';
            urlInput.setAttribute('required', 'required');
        } else { // file_type is upload
            uploadField.style.display = 'block';
            urlField.style.display = 'none';
            urlInput.removeAttribute('required');

            if (hasExistingFile) {
                fileInput.removeAttribute('required'); // Not required if already has a file
            } else {
                fileInput.setAttribute('required', 'required'); // Required if no file
            }
        }
    }

    function validateFile(input) {
        const fileDropZone = document.getElementById('fileDropZone');
        const fileIcon = document.getElementById('fileIcon');
        const fileNameDisplay = document.getElementById('fileNameDisplay');
        const fileSizeDisplay = document.getElementById('fileSizeDisplay');

        fileNameDisplay.classList.add('hidden');
        fileSizeDisplay.classList.add('hidden');
        fileIcon.className = 'fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3';
        fileDropZone.className = 'border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors duration-200';

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const fileSize = file.size / 1024 / 1024;
            const fileExtension = file.name.split('.').pop().toLowerCase();
            
            const imageExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            const docExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];
            const allowedExtensions = [...imageExtensions, ...docExtensions];

            let maxSize = 2; // Default max size for documents
            if (imageExtensions.includes(fileExtension)) {
                maxSize = 10; // Max size for images
            }

            if (!allowedExtensions.includes(fileExtension)) {
                alert('Format file tidak didukung. Silakan gunakan format yang diizinkan.');
                input.value = '';
                fileIcon.className = 'fas fa-times-circle text-4xl text-red-500 mb-3';
                fileDropZone.classList.add('border-red-500', 'bg-red-50');
                return;
            }

            if (fileSize > maxSize) {
                alert(`Ukuran file terlalu besar (${fileSize.toFixed(2)} MB). Maksimal ${maxSize}MB. Silakan gunakan opsi Link File.`);
                input.value = '';
                fileIcon.className = 'fas fa-times-circle text-4xl text-red-500 mb-3';
                fileDropZone.classList.add('border-red-500', 'bg-red-50');
                return;
            }

            fileIcon.className = 'fas fa-check-circle text-4xl text-green-500 mb-3';
            fileDropZone.className = 'border-2 border-dashed border-green-500 bg-green-50 rounded-lg p-6 text-center transition-colors duration-200';
        }
    }

    function updateJenisDokumenDescription(select) {
        const selectedOption = select.options[select.selectedIndex];
        const descContainer = document.getElementById('jenis_dokumen_desc');
        if (selectedOption && selectedOption.dataset.desc) {
            descContainer.textContent = "Contoh: " + selectedOption.dataset.desc;
        } else {
            descContainer.textContent = "";
        }
    }

    function handleJenisDokumenFocus(select) {
        Array.from(select.options).forEach(opt => {
            if (opt.value && opt.dataset.desc) {
                opt.text = opt.value + " (" + opt.dataset.desc + ")";
            }
        });
    }

    function handleJenisDokumenBlur(select) {
        Array.from(select.options).forEach(opt => {
            if (opt.selected) {
                opt.text = opt.value;
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleFileInput();
        
        const jenisDokumenSelect = document.getElementById('jenis_dokumen');
        if (jenisDokumenSelect) {
            handleJenisDokumenBlur(jenisDokumenSelect);
            updateJenisDokumenDescription(jenisDokumenSelect);
        }
    });
</script>
@endpush
