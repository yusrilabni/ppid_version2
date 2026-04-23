@extends('frontend.layouts.app')

@section('title', 'Ubah Informasi')

@section('content')
<div x-data>

    <x-pedoman-modal />
    <x-ai-analis-modal />

    {{-- The rest of the page content --}}
    <div class="container mx-auto py-8 px-4">
        <div class="max-w-4xl mx-auto">
            <x-breadcrumbs :breadcrumbs="[
                ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                ['title' => $categoryName, 'url' => route('frontend.informasi.category', $categorySlug), 'icon' => $categoryIcon],
                ['title' => 'Ubah Informasi', 'url' => request()->fullUrl(), 'icon' => 'fas fa-edit'],
            ]" />
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 text-white flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">Ubah Informasi</h1>
                        <p class="text-blue-100 mt-1">Perbarui informasi publik: <span class="font-semibold">{{ Str::limit($informasi->title, 40) }}</span></p>
                    </div>
                    <button
                        type="button"
                        @click="$store.pedomanModal.show()"
                        class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition-colors flex items-center"
                    >
                        <i class="fas fa-question-circle mr-2"></i>
                        Tanya Pedoman
                    </button>
                </div>

                <div class="p-6">
                    @if (session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                            <strong class="font-medium">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
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

                    <form action="{{ url('admin/update-data-ada/' . $informasi->id) }}" method="POST" enctype="multipart/form-data" x-data="informasiForm()" x-init="init()">
                        @csrf
                        {{-- Hapus @method PUT karena kita bypass via POST murni --}}
                        <input type="hidden" name="replacement_id" id="replacement_id">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="md:col-span-2"><label for="title" class="block text-gray-700 text-sm font-semibold mb-2">Judul Informasi <span class="text-red-500">*</span></label><input type="text" name="title" id="title" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" value="{{ old('title', $informasi->title) }}" required minlength="5" placeholder="Masukkan judul informasi"></div>
                            <div class="md:col-span-2"><label for="doc_desc" class="block text-gray-700 text-sm font-semibold mb-2">Deskripsi Singkat</label><textarea name="doc_desc" id="doc_desc" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" placeholder="Deskripsi singkat tentang informasi ini">{{ old('doc_desc', $informasi->deskripsi) }}</textarea></div>
                            <div class="md:col-span-2"><label for="doc_content" class="block text-gray-700 text-sm font-semibold mb-2">Konten Informasi Lengkap</label><textarea name="doc_content" id="doc_content" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" placeholder="Konten lengkap informasi publik">{{ old('doc_content', $informasi->content) }}</textarea></div>
                            @php
                                $categories = [
                                    ['value' => 'Informasi Berkala', 'label' => 'Informasi Berkala'],
                                    ['value' => 'Informasi Setiap Saat', 'label' => 'Informasi Setiap Saat'],
                                    ['value' => 'Informasi Serta Merta', 'label' => 'Informasi Serta Merta'],
                                    ['value' => 'Informasi Dikecualikan', 'label' => 'Informasi Dikecualikan'],
                                ];
                            @endphp
                            <div>
                                <label for="category" class="block text-gray-700 text-sm font-semibold mb-2">Kategori Informasi <span class="text-red-500">*</span></label>
                                <x-custom-select 
                                    name="category" 
                                    :options="$categories" 
                                    :value="old('category', $informasi->category)"
                                    placeholder="Pilih Kategori"
                                    :searchable="false"
                                    required="true"
                                />
                            </div>
                            @if ($isSuperAdmin)
                                <div>
                                    <label for="target_unit" class="block text-gray-700 text-sm font-semibold mb-2">Unit Kerja <span class="text-red-500">*</span></label>
                                    <x-custom-select
                                        name="target_unit"
                                        :options="$units"
                                        :value="old('target_unit', $currentUnitId ?? $informasi->unit_id)"
                                        placeholder="Pilih Unit Kerja"
                                        :searchable="true"
                                        required="true"
                                    />                                </div>
                            @else
                                <div>
                                    <label class="block text-gray-700 text-sm font-semibold mb-2">Unit Kerja</label>
                                    <input type="text" class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed" value="{{ $userUnitName }}" readonly>
                                    <input type="hidden" name="target_unit" value="{{ $userUnitId }}">
                                </div>
                            @endif
                            <div>
                                <label for="jenis_dokumen" class="block text-gray-700 text-sm font-semibold mb-2">Jenis Dokumen</label>
                                @php
                                    $jenisDokumenOptions = [
                                        ['value' => 'Profil Badan Publik', 'label' => 'Profil Badan Publik', 'desc' => 'Sejarah, Visi Misi, Tupoksi, Struktur Organisasi, Profil Pimpinan, Domisili'],
                                        ['value' => 'Informasi Organisasi & Kepegawaian', 'label' => 'Informasi Organisasi & Kepegawaian', 'desc' => 'Data Statistik Pegawai, Daftar Pejabat Struktural, LHKPN/LHKASN'],
                                        ['value' => 'Dokumen Strategis', 'label' => 'Dokumen Strategis', 'desc' => 'RPJMD, Renstra, Renja, Indikator Kinerja Utama/IKU'],
                                        ['value' => 'Program & Kegiatan', 'label' => 'Program & Kegiatan', 'desc' => 'DPA, Kalender Kegiatan Tahunan, Ringkasan Program Kerja'],
                                        ['value' => 'Laporan Kinerja Instansi', 'label' => 'Laporan Kinerja Instansi', 'desc' => 'LKjIP, LKPJ, Laporan Tahunan Instansi'],
                                        ['value' => 'Informasi Keuangan', 'label' => 'Informasi Keuangan', 'desc' => 'RKA, LRA, Neraca, Laporan Arus Kas, CALK, Opini BPK'],
                                        ['value' => 'Pengadaan Barang/Jasa', 'label' => 'Pengadaan Barang/Jasa', 'desc' => 'RUP, Kerangka Acuan Kerja/KAK, Ringkasan Kontrak, Daftar Pemenang Tender'],
                                        ['value' => 'Daftar Aset dan Inventaris', 'label' => 'Daftar Aset dan Inventaris', 'desc' => 'Buku Inventaris Barang, Rekapitulasi Aset Daerah'],
                                        ['value' => 'Standar Layanan & SOP PPID', 'label' => 'Standar Layanan & SOP PPID', 'desc' => 'Maklumat Pelayanan, SOP Permohonan Informasi, SOP Sengketa, Standar Pelayanan Minimal/SPM'],
                                        ['value' => 'Daftar Informasi Publik & Laporan PPID', 'label' => 'Daftar Informasi Publik & Laporan PPID', 'desc' => 'Buku DIP Tahunan, Register Permohonan, Daftar Informasi Dikecualikan, Laporan Layanan Informasi'],
                                        ['value' => 'Regulasi & Peraturan', 'label' => 'Regulasi & Peraturan', 'desc' => 'Undang-Undang, Peraturan Pemerintah, Perda, Perbup, SK Kepala Daerah/Dinas'],
                                        ['value' => 'Perjanjian Kerja Sama / MoU', 'label' => 'Perjanjian Kerja Sama / MoU', 'desc' => 'Nota Kesepahaman Antar Lembaga, Kontrak Kerja Sama Pihak Ketiga'],
                                        ['value' => 'Pengumuman & Siaran Pers', 'label' => 'Pengumuman & Siaran Pers', 'desc' => 'Pengumuman Resmi, Siaran Pers, Surat Edaran, Hasil Survei Kepuasan Masyarakat/SKM'],
                                        ['value' => 'Informasi Serta Merta', 'label' => 'Informasi Serta Merta', 'desc' => 'Peringatan Dini Bencana, Informasi Gangguan Layanan Massal, Protokol Darurat'],
                                        ['value' => 'Lainnya', 'label' => 'Lainnya', 'desc' => ''],
                                    ];
                                    $currentJenis = old('jenis_dokumen', $informasi->jenis_dokumen);
                                    $currentDesc = collect($jenisDokumenOptions)->firstWhere('value', $currentJenis)['desc'] ?? '';
                                @endphp
                                <div @change="const item = $event.detail.item; if(item) { document.getElementById('jenis_dokumen_desc').innerText = item.desc || ''; }">
                                    <x-custom-select 
                                        name="jenis_dokumen" 
                                        :options="$jenisDokumenOptions" 
                                        :value="$currentJenis"
                                        placeholder="Pilih Jenis Dokumen"
                                        :searchable="true"
                                    />
                                </div>
                                <div id="jenis_dokumen_desc" class="mt-2 text-xs text-blue-600 font-medium italic min-h-[1rem]">{{ $currentDesc }}</div>
                            </div>
                            <div><label for="tahun" class="block text-gray-700 text-sm font-semibold mb-2">Tahun Dokumen <span class="text-red-500">*</span></label><input type="date" name="tahun" id="tahun" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" value="{{ old('tahun', $informasi->tanggal_upload) }}" required x-model="tahun"></div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Status <span class="text-red-500">*</span></label>
                                <div class="flex space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="BERLAKU" class="form-radio h-4 w-4 text-blue-600" x-model="status" {{ strtoupper(trim(old('status', $informasi->status))) == 'BERLAKU' ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Berlaku</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="ARSIP" class="form-radio h-4 w-4 text-blue-600" x-model="status" {{ strtoupper(trim(old('status', $informasi->status))) == 'ARSIP' ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Arsip</span>
                                    </label>
                                </div>
                                <p class="text-red-500 text-xs mt-2">Pilih "BERLAKU" untuk dokumen yang masih sah digunakan saat ini (baik lama maupun baru), dan gunakan "ARSIP" hanya jika dokumen tersebut sudah kedaluwarsa atau telah diperbarui.</p>
                            </div>
                            
                        </div>
                        <div class="mb-8">
                            <label class="block text-gray-700 text-sm font-semibold mb-2">File</label>
                            <div class="mb-4 flex space-x-4"><label class="inline-flex items-center"><input type="radio" name="file_type" value="upload" class="form-radio h-4 w-4 text-blue-600" {{ $informasi->url ? '' : 'checked' }} x-on:change="toggleFileInput()"><span class="ml-2 text-gray-700">Upload File</span></label><label class="inline-flex items-center"><input type="radio" name="file_type" value="url" class="form-radio h-4 w-4 text-blue-600" {{ $informasi->url ? 'checked' : '' }} x-on:change="toggleFileInput()"><span class="ml-2 text-gray-700">Link File</span></label></div>
                            <div id="uploadField" class="mb-6" style="{{ $informasi->url ? 'display: none;' : '' }}">
                                <label for="file" class="block text-gray-700 text-sm font-semibold mb-2">Upload File Baru</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors duration-200" id="fileDropZone">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3" id="fileIcon"></i>
                                        <p class="text-gray-600 mb-2">Pilih file baru untuk diupload</p>
                                        <p class="text-gray-500 text-sm mb-3">Format: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG (Max 2MB)</p>
                                        <input type="file" name="file" id="file" class="hidden" onchange="validateFile(this)">
                                        <label for="file" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg cursor-pointer transition duration-200">Pilih File Baru</label>
                                        <p id="fileErrorMessage" class="mt-2 text-red-500 text-sm hidden"></p>
                                        <div id="fileNameDisplay" class="mt-3 text-sm text-gray-600 hidden"></div>
                                        <div id="fileSizeDisplay" class="text-xs text-gray-500 hidden"></div>
                                    </div>
                                </div>                                @if ($informasi->file)
                                    <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-100">
                                        <div class="flex items-center justify-between">
                                            <div><p class="text-sm font-medium text-gray-700">File saat ini:</p><a href="{{ asset('storage/' . $informasi->file) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">{{ $informasi->file }}</a></div>
                                            <div class="text-xs text-gray-500">Ukuran: {{ \File::exists(storage_path('app/public/' . $informasi->file)) ? round(\File::size(storage_path('app/public/' . $informasi->file)) / 1024, 2) . ' KB' : 'N/A' }}</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div id="urlField" class="mb-6" style="{{ $informasi->url ? '' : 'display: none;' }}"><label for="url" class="block text-gray-700 text-sm font-semibold mb-2">Link File (untuk file > 2MB)</label><input type="url" name="url" id="url" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" value="{{ old('url', $informasi->url) }}" placeholder="https://contoh.com/file.pdf"><p class="text-gray-500 text-xs mt-2">Gunakan ini jika file Anda lebih dari 2MB dan tidak bisa diupload</p></div>
                        </div>
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('frontend.informasi.category', $categorySlug) }}" class="px-6 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition duration-200">Batal</a>
                            <button type="button" id="check-similarity-btn" class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition duration-200">Check Informasi</button>
                            <button type="submit" id="submit-btn" style="display: none;" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">Simpan Perubahan</button>
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
                        Simpan Perubahan
                    </button>
                    <button id="cancel-replacement" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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
        const currentInformasiId = {{ $informasi->id }};

        checkButton.addEventListener('click', function () {
            this.disabled = true;
            this.textContent = 'Mengecek...';

            const title = titleInput.value;
            const url = `{{ route('admin.informasi.check_similarity') }}`;
            const isSuperAdmin = @json($isSuperAdmin);

            const formData = new FormData();
            formData.append('title', title);
            formData.append('_token', '{{ csrf_token() }}');

            if (isSuperAdmin) {
                const unitIdInput = document.getElementById('unit_id');
                if (unitIdInput) {
                    formData.append('unit_id', unitIdInput.value);
                }
            }

            if (titleInput.value.length < 5) {
                alert('Judul informasi harus memiliki minimal 5 karakter.');
                this.disabled = false;
                this.textContent = 'Check Informasi';
                return;
            }

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
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

                const filteredData = data.filter(doc => doc.id !== currentInformasiId);
                if (filteredData.length > 0) {
                    similarDocumentsSelect.innerHTML = '';
                    filteredData.forEach(doc => {
                        const option = document.createElement('option');
                        option.value = doc.id;
                        option.textContent = doc.title;
                        similarDocumentsSelect.appendChild(option);
                    });
                    modal.classList.remove('hidden');
                } else {
                    alert('Tidak ada dokumen serupa yang ditemukan. Anda dapat menyimpan perubahan ini.');
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

        confirmButton.addEventListener('click', function () {
            replacementIdInput.value = similarDocumentsSelect.value;
            modal.classList.add('hidden');

            // Hide check button, show submit button as per user request
            checkButton.style.display = 'none';
            submitButton.style.display = 'inline-block';

            // Do NOT submit the form immediately.
        });

        submitFromModalButton.addEventListener('click', function() {
            replacementIdInput.value = '';
            modal.classList.add('hidden');
            form.submit();
        });

        cancelButton.addEventListener('click', function () {
            replacementIdInput.value = '';
            modal.classList.add('hidden');
            checkButton.style.display = 'none';
            submitButton.style.display = 'inline-block';
        });
    });

    function informasiForm() {
        return {
            category: '{{ old('category', $informasi->category) }}',
            tahun: '{{ old('tahun', $informasi->tanggal_upload) }}',
            fileInput: '{{ $informasi->url ? 'url' : 'upload' }}',
            status: '{{ old('status', $informasi->status) }}',
            
            init() {
                this.toggleFileInput();
                this.updateButtonVisibility();

                this.$watch('status', () => {
                    this.updateButtonVisibility();
                });
            },

            updateButtonVisibility() {
                const checkButton = document.getElementById('check-similarity-btn');
                const submitButton = document.getElementById('submit-btn');
                if (this.status === 'ARSIP') {
                    checkButton.style.display = 'none';
                    submitButton.style.display = 'inline-block';
                } else {
                    checkButton.style.display = 'inline-block';
                    submitButton.style.display = 'none';
                }
            },

            toggleFileInput() {
                this.fileInput = document.querySelector('input[name="file_type"]:checked').value;

                const uploadField = document.getElementById('uploadField');
                const urlField = document.getElementById('urlField');

                if (this.fileInput === 'url') {
                    uploadField.style.display = 'none';
                    urlField.style.display = 'block';
                } else {
                    uploadField.style.display = 'block';
                    urlField.style.display = 'none';
                }
            }
        }
    }

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

                const maxFileSize = 2 * 1024 * 1024; // 2MB

    

                if (fileSize > maxFileSize) {

                    fileErrorMessage.textContent = 'Ukuran file melebihi batas maksimal 2MB. Silakan pilih file yang lebih kecil atau gunakan opsi Link File.';

                    fileErrorMessage.classList.remove('hidden');

                    input.value = ''; // Clear the file input

                    fileNameDisplay.textContent = '';

                    fileNameDisplay.classList.add('hidden');

                    fileSizeDisplay.textContent = '';

                    fileSizeDisplay.classList.add('hidden');

                    // Change icon to show error

                    fileIcon.classList.remove('fa-cloud-upload-alt', 'text-gray-400'); // Remove default classes

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

                fileIcon.classList.remove('fa-cloud-upload-alt', 'text-gray-400'); // Remove default classes

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

    // Initialize description on page load
    document.addEventListener('DOMContentLoaded', function() {
        const jenisDokumenSelect = document.getElementById('jenis_dokumen');
        if (jenisDokumenSelect) {
            handleJenisDokumenBlur(jenisDokumenSelect);
            updateJenisDokumenDescription(jenisDokumenSelect);
        }
    });
</script>
@endpush