@extends('admin.layouts.app')

@section('title', 'Tambah File Standar Layanan')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 text-white">
                <h1 class="text-2xl font-bold">Tambah File Standar Layanan</h1>
                <p class="text-blue-100 mt-1">Tambahkan file pendukung baru ke dalam sistem.</p>
            </div>

            <div class="p-6">
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                        <strong class="font-medium">Whoops!</strong> Ada beberapa masalah dengan input Anda:
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.standar-layanan.store') }}" method="POST" enctype="multipart/form-data" x-data="informasiForm()">
                    @csrf
                    <input type="hidden" name="replacement_id" id="replacement_id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        @if($isSuperAdmin)
                        <div class="md:col-span-2">
                            <label for="unit_id" class="block text-gray-700 text-sm font-semibold mb-2">Unit Kerja (Dinas) <span class="text-red-500">*</span></label>
                            <select name="unit_id" id="unit_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                                <option value="">Pilih Unit Kerja</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit['unit_id'] }}" {{ old('unit_id') == $unit['unit_id'] ? 'selected' : '' }}>
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
                            <label for="standar_layanan_id" class="block text-gray-700 text-sm font-semibold mb-2">Kategori Standar Layanan <span class="text-red-500">*</span></label>
                            <select name="standar_layanan_id" id="standar_layanan_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('standar_layanan_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label for="title" class="block text-gray-700 text-sm font-semibold mb-2">Judul File <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" value="{{ old('title') }}" required placeholder="Masukkan judul file">
                        </div>
                        <div class="md:col-span-2">
                            <label for="tahun_dokumen" class="block text-gray-700 text-sm font-semibold mb-2">Tahun Dokumen <span class="text-red-500">*</span></label>
                            <input type="date" name="tahun_dokumen" id="tahun_dokumen" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" value="{{ old('tahun_dokumen', date('Y-m-d')) }}" required>
                        </div>
                        <div class="md:col-span-1">
                            <label for="category" class="block text-gray-700 text-sm font-semibold mb-2">Kategori Informasi <span class="text-red-500">*</span></label>
                            <select name="category" id="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($informasi_categories as $category)
                                    <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
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
                                    <option value="{{ $value }}" data-desc="{{ $desc }}" {{ old('jenis_dokumen') == $value ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <div id="jenis_dokumen_desc" class="mt-2 text-xs text-blue-600 font-medium italic min-h-[1rem]"></div>
                        </div>
                        <div class="md:col-span-2">
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Status <span class="text-red-500">*</span></label>
                                <div class="flex space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="BERLAKU" class="form-radio h-4 w-4 text-blue-600" x-model="status">
                                        <span class="ml-2 text-gray-700">Berlaku</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="ARSIP" class="form-radio h-4 w-4 text-blue-600" x-model="status">
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
            <input type="radio" name="file_type" value="upload" class="form-radio h-4 w-4 text-blue-600" checked onchange="toggleFileInput()">
            <span class="ml-2 text-gray-700">Upload File</span>
        </label>
        <label class="inline-flex items-center">
            <input type="radio" name="file_type" value="url" class="form-radio h-4 w-4 text-blue-600" onchange="toggleFileInput()">
            <span class="ml-2 text-gray-700">Link File</span>
        </label>
    </div>
    <div id="uploadField" class="mb-6">
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors duration-200" id="fileDropZone">
            <div class="flex flex-col items-center justify-center">
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
        <input type="url" name="url" id="url" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" placeholder="https://contoh.com/file.pdf">
    </div>
</div>


                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.standar-layanan.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition duration-200">Batal</a>
                        <button type="button" id="check-similarity-btn" x-show="status === 'BERLAKU'" class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition duration-200">Check Informasi</button>
                        <button type="submit" id="submit-btn" x-show="status === 'ARSIP'" style="display: none;" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">Simpan Informasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Similarity Modal -->
<div id="similarity-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                <i class="fas fa-exclamation-triangle text-yellow-600 fa-2x"></i>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">Peringatan Kemiripan Judul</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Judul yang Anda masukkan memiliki kemiripan dengan dokumen yang sudah ada.
                </p>
                <div class="mt-4">
                    <label for="similar_documents" class="block text-sm font-medium text-gray-700">Pilih dokumen untuk diganti (diarsip):</label>
                    <select id="similar_documents" name="similar_documents" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <!-- Options will be populated by JavaScript -->
                    </select>
                </div>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirm-replacement" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Ganti
                </button>
                <button id="submit-from-modal" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Simpan Informasi
                </button>
                <button id="cancel-replacement" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const standarLayananSelect = document.getElementById('standar_layanan_id');
        const statusField = document.getElementById('status-field');
        
        function toggleStatusFields() {
            const selectedOption = standarLayananSelect.options[standarLayananSelect.selectedIndex];
            const categoryTitle = selectedOption.text.toLowerCase();

            if (categoryTitle.includes('dasar hukum') || categoryTitle.includes('sop')) {
                if(statusField) statusField.style.display = 'none';

            } else {
                if(statusField) statusField.style.display = 'block';
            }
        }

        standarLayananSelect.addEventListener('change', toggleStatusFields);
        toggleStatusFields();
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const checkButton = document.getElementById('check-similarity-btn');
        const submitButton = document.getElementById('submit-btn');
        const titleInput = document.getElementById('title');
        const modal = document.getElementById('similarity-modal');
        const similarDocumentsSelect = document.getElementById('similar_documents');
        const replacementIdInput = document.getElementById('replacement_id');
        const confirmButton = document.getElementById('confirm-replacement');
        const submitFromModalButton = document.getElementById('submit-from-modal');
        const cancelButton = document.getElementById('cancel-replacement');
        
        let isSubmitting = false;

        if(checkButton) {
            checkButton.addEventListener('click', function () {
                this.disabled = true;
                this.textContent = 'Mengecek...';

                const title = titleInput.value;

                if (title.length < 5) {
                    alert('Judul informasi harus memiliki minimal 5 karakter.');
                    this.disabled = false;
                    this.textContent = 'Check Informasi';
                    return;
                }

                fetch('{{ route('admin.informasi.check_similarity') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ title: title })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    checkButton.disabled = false;
                    checkButton.textContent = 'Check Informasi';

                    if (data.length > 0) {
                        similarDocumentsSelect.innerHTML = '';
                        data.forEach(doc => {
                            const option = document.createElement('option');
                            option.value = doc.id;
                            option.textContent = doc.title;
                            similarDocumentsSelect.appendChild(option);
                        });
                        modal.classList.remove('hidden');
                    } else {
                        alert('Tidak ada dokumen serupa yang ditemukan. Anda dapat menyimpan informasi ini.');
                        checkButton.style.display = 'none';
                        submitButton.style.display = 'inline-block';
                    }
                })
                .catch(error => {
                    console.error('Error checking similarity:', error);
                    alert('Terjadi kesalahan saat memeriksa kemiripan dokumen.');
                    checkButton.disabled = false;
                    checkButton.textContent = 'Check Informasi';
                });
            });
        }

        const performSubmit = (btn, text, replacementId = null) => {
            if (isSubmitting) return;
            isSubmitting = true;
            
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> ${text}`;
            }
            
            if (replacementId !== null) {
                replacementIdInput.value = replacementId;
            }
            
            modal.classList.add('hidden');
            form.submit();
        };

        if(confirmButton){
            confirmButton.addEventListener('click', function () {
                performSubmit(this, 'Mengganti...', similarDocumentsSelect.value);
            });
        }
        
        if(submitFromModalButton){
            submitFromModalButton.addEventListener('click', function() {
                performSubmit(this, 'Menyimpan...', '');
            });
        }

        if(cancelButton){
            cancelButton.addEventListener('click', function () {
                replacementIdInput.value = '';
                modal.classList.add('hidden');
                if(checkButton) checkButton.style.display = 'none';
                if(submitButton) submitButton.style.display = 'inline-block';
            });
        }

        form.addEventListener('submit', function(e) {
            if (isSubmitting) {
                e.preventDefault();
                return;
            }
            
            const btn = document.getElementById('submit-btn');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';
            }
            isSubmitting = true;
        });
    });

    function informasiForm() {
        return {
            status: '{{ old('status', 'BERLAKU') }}',
            init() {
                this.$watch('status', (value) => {
                    const checkButton = document.getElementById('check-similarity-btn');
                    const submitButton = document.getElementById('submit-btn');
                    if (value === 'BERLAKU') {
                        if(checkButton) checkButton.style.display = 'inline-block';
                        if(submitButton) submitButton.style.display = 'none';
                    } else {
                        if(checkButton) checkButton.style.display = 'none';
                        if(submitButton) submitButton.style.display = 'inline-block';
                    }
                });
            }
        }
    }
</script>
<script>
    function toggleFileInput() {
        const uploadField = document.getElementById('uploadField');
        const urlField = document.getElementById('urlField');
        const fileRadio = document.querySelector('input[name="file_type"]:checked');
        const fileInput = document.getElementById('file');
        const urlInput = document.getElementById('url');

        if (fileRadio && fileRadio.value === 'url') {
            uploadField.style.display = 'none';
            fileInput.removeAttribute('required');
            urlField.style.display = 'block';
            urlInput.setAttribute('required', 'required');
        } else {
            uploadField.style.display = 'block';
            fileInput.setAttribute('required', 'required');
            urlField.style.display = 'none';
            urlInput.removeAttribute('required');
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
            
            const imageExtensions = ['jpg', 'jpeg', 'png'];
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

            fileNameDisplay.textContent = file.name;
            fileSizeDisplay.textContent = 'Ukuran: ' + fileSize.toFixed(2) + ' MB';
            fileNameDisplay.classList.remove('hidden');
            fileSizeDisplay.classList.remove('hidden');
            fileIcon.className = 'fas fa-check-circle text-4xl text-green-500 mb-3';
            fileDropZone.classList.add('border-green-500', 'bg-green-50');
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
