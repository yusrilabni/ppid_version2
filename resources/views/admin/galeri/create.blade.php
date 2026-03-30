@extends('admin.layouts.app')

@section('title', 'Tambah Galeri Baru')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">Tambah Galeri Baru</h2>
            <p class="text-gray-600">Tambahkan item galeri baru ke website</p>
        </div>

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

        <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" 
            x-data="{ 
                mediaType: '{{ old('type', 'foto') }}', 
                videoUrl: '{{ old('video') }}',
                getVideoId(url) {
                    if (!url) return null;
                    const regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^&?\/ ]{11})/;
                    const match = url.match(regex);
                    return match ? match[1] : null;
                }
            }">
            @csrf
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" value="{{ old('title') }}" required>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" id="description" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" rows="5">{{ old('description') }}</textarea>
            </div>

            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Jenis</label>
                <select name="type" id="type" x-model="mediaType" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" required>
                    <option value="foto">Foto</option>
                    <option value="video">Video</option>
                </select>
            </div>

            <div id="mediaSection" class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Media</label>
                <div id="fotoSection" x-show="mediaType === 'foto'" style="display: none;">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
                    <input type="file" name="image" id="image" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" accept="image/*" :required="mediaType === 'foto'" :disabled="mediaType !== 'foto'">
                    <p class="mt-2 text-sm text-gray-500">Unggah gambar untuk galeri (JPG, PNG, GIF). Gambar akan otomatis dikonversi ke format WebP dan dikompresi kurang dari 2MB.</p>
                </div>
                <div id="videoSection" x-show="mediaType === 'video'" style="display: none;">
                    <label for="video" class="block text-sm font-medium text-gray-700 mb-2">URL Video</label>
                    <input type="url" name="video" id="video" x-model="videoUrl" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" placeholder="https://youtube.com/..." :required="mediaType === 'video'" :disabled="mediaType !== 'video'">
                    <p class="mt-2 text-sm text-gray-500">Masukkan URL video yang valid (YouTube, Vimeo, dll)</p>
                    <div x-show="getVideoId(videoUrl)" class="mt-2" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pratinjau Video</label>
                        <img :src="`https://img.youtube.com/vi/${getVideoId(videoUrl)}/default.jpg`" alt="Pratinjau Video" class="h-32 w-auto object-cover rounded border border-gray-200">
                    </div>
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

            <div class="flex items-center space-x-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                    Tambah Galeri
                </button>
                <a href="{{ route('admin.galeri.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-6 rounded-lg transition">
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

        document.addEventListener('DOMContentLoaded', function() {
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

            // TinyMCE for description
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
        });
    </script>
@endsection