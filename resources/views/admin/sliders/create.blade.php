@extends('admin.layouts.app')

@section('title', 'Tambah Slider Baru')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">Tambah Slider Baru</h2>
            <p class="text-gray-600">Tambahkan gambar slider baru ke halaman utama</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-start">
                <div>
                    <i class="fas fa-exclamation-triangle mr-2 text-red-500"></i>
                </div>
                <div>
                    <strong class="font-bold">Ups!</strong>
                    <span class="block">Terjadi beberapa masalah dengan input Anda.</span>
                    <ul class="mt-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data" id="createSliderForm">
            @csrf
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" value="{{ old('title') }}" required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tampilkan Judul</label>
                <div class="flex items-center">
                    <input type="checkbox" name="show_title" id="show_title" value="1" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" checked>
                    <label for="show_title" class="ml-2 block text-sm text-gray-700">Tampilkan judul pada halaman beranda</label>
                </div>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" id="description" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" rows="5">{{ old('description') }}</textarea>
                <p class="mt-2 text-sm text-gray-500">Tambahkan deskripsi untuk slider (opsional)</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tampilkan Deskripsi</label>
                <div class="flex items-center">
                    <input type="checkbox" name="show_description" id="show_description" value="1" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" checked>
                    <label for="show_description" class="ml-2 block text-sm text-gray-700">Tampilkan deskripsi pada halaman beranda</label>
                </div>
            </div>

            <div class="mb-6">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori Informasi</label>
                <select name="category" id="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">Tidak Berkategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6" id="jenisDokumenWrapper">
                <label for="jenis_dokumen" class="block text-sm font-medium text-gray-700 mb-2">Jenis Dokumen</label>
                <select name="jenis_dokumen" id="jenis_dokumen" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition"
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


            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
                <input type="file" name="image" id="image" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" required>
                <p class="mt-2 text-sm text-gray-500">Unggah gambar untuk slider (ukuran yang disarankan: 1200x400 pixel)</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <div class="flex items-center">
                    <input type="checkbox" name="active" id="active" value="1" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" {{ old('active') ? 'checked' : '' }}>
                    <label for="active" class="ml-2 block text-sm text-gray-700">Aktif</label>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit" id="submitButton" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                    Tambah Slider
                </button>
                <a href="{{ route('admin.sliders.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-6 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
    <script>
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

        document.addEventListener('DOMContentLoaded', function () {
            const categorySelect = document.getElementById('category');
            const jenisDokumenWrapper = document.getElementById('jenisDokumenWrapper');
            const jenisDokumenSelect = document.getElementById('jenis_dokumen');

            function toggleJenisDokumenVisibility() {
                if (categorySelect.value === '') { // 'Tidak Berkategori' selected
                    jenisDokumenWrapper.style.display = 'none';
                    jenisDokumenSelect.value = ''; // Clear selection
                } else {
                    jenisDokumenWrapper.style.display = 'block';
                }
            }

            // Initial check on page load
            toggleJenisDokumenVisibility();
            if (jenisDokumenSelect) {
                handleJenisDokumenBlur(jenisDokumenSelect);
                updateJenisDokumenDescription(jenisDokumenSelect);
            }

            // Add event listener for changes
            categorySelect.addEventListener('change', toggleJenisDokumenVisibility);
        });

        document.getElementById('createSliderForm').addEventListener('submit', function() {
            var submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.innerHTML = 'Menyimpan...';
        });

        tinymce.init({
            selector: '#description',
            height: 200,
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image | removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    </script>
@endsection
