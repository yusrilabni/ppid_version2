@extends('admin.layouts.app')

@section('title', 'Edit Galeri')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">Edit Galeri</h2>
            <p class="text-gray-600">Perbarui informasi item galeri</p>
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

        <form action="{{ route('admin.galeri.update', $galeri) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" value="{{ old('title', $galeri->title) }}" required>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" id="description" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" rows="5">{{ old('description', $galeri->description) }}</textarea>
            </div>

            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Jenis</label>
                <select name="type" id="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" required>
                    <option value="">Pilih Jenis</option>
                    <option value="foto" {{ old('type', $galeri->type) == 'foto' ? 'selected' : '' }}>Foto</option>
                    <option value="video" {{ old('type', $galeri->type) == 'video' ? 'selected' : '' }}>Video</option>
                </select>
            </div>

            <div id="mediaSection" class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Media</label>
                <div id="fotoSection" class="{{ $galeri->type !== 'foto' ? 'hidden' : '' }}">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Baru (Opsional)</label>
                    <input type="file" name="image" id="image" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" accept="image/*">
                    <p class="mt-2 text-sm text-gray-500">Unggah gambar baru (JPG, PNG, GIF). Gambar akan otomatis dikonversi ke format WebP dan dikompresi kurang dari 2MB. Biarkan kosong untuk tetap menggunakan gambar saat ini.</p>
                    @if($galeri->image)
                        <div class="mt-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                            <img src="{{ asset('storage/' . $galeri->image) }}" alt="{{ $galeri->title }}" class="h-32 w-auto object-cover rounded border border-gray-200">
                        </div>
                    @endif
                </div>
                <div id="videoSection" class="{{ $galeri->type !== 'video' ? 'hidden' : '' }}">
                    <label for="video" class="block text-sm font-medium text-gray-700 mb-2">URL Video</label>
                    <input type="url" name="video" id="video" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" value="{{ old('video', $galeri->video) }}" placeholder="https://youtube.com/...">
                    <p class="mt-2 text-sm text-gray-500">Masukkan URL video yang valid (YouTube, Vimeo, dll)</p>
                    @if($galeri->video && $galeri->type === 'video')
                        @php
                            // Extract YouTube video ID from URL
                            $videoId = null;
                            $url = parse_url($galeri->video);
                            if (isset($url['host'])) {
                                if (strpos($url['host'], 'youtube.com') !== false || strpos($url['host'], 'youtu.be') !== false) {
                                    if (isset($url['query'])) {
                                        parse_str($url['query'], $params);
                                        $videoId = $params['v'] ?? null;
                                    }
                                    if (!$videoId && isset($url['path'])) {
                                        $pathParts = explode('/', $url['path']);
                                        $videoId = end($pathParts);
                                    }
                                }
                            }
                        @endphp
                        @if($videoId)
                            <div class="mt-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Pratinjau Video Saat Ini</label>
                                <img src="https://img.youtube.com/vi/{{ $videoId }}/default.jpg" alt="Gambar Pratinjau Video Saat Ini" class="h-32 w-auto object-cover rounded border border-gray-200">
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <div class="mb-6">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori Informasi</label>
                <select name="category" id="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">Tidak Berkategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ old('category', $galeri->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-6">
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
                        <option value="{{ $value }}" data-desc="{{ $desc }}" {{ old('jenis_dokumen', $galeri->jenis_dokumen) == $value ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                <div id="jenis_dokumen_desc" class="mt-2 text-xs text-blue-600 font-medium italic min-h-[1rem]"></div>
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                    Perbarui Galeri
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
            const typeSelect = document.getElementById('type');
            const fotoSection = document.getElementById('fotoSection');
            const videoSection = document.getElementById('videoSection');
            const jenisDokumenSelect = document.getElementById('jenis_dokumen');

            if (jenisDokumenSelect) {
                handleJenisDokumenBlur(jenisDokumenSelect);
                updateJenisDokumenDescription(jenisDokumenSelect);
            }
            
            typeSelect.addEventListener('change', function() {
                if(this.value === 'foto') {
                    fotoSection.classList.remove('hidden');
                    videoSection.classList.add('hidden');
                } else if(this.value === 'video') {
                    videoSection.classList.remove('hidden');
                    fotoSection.classList.add('hidden');
                } else {
                    fotoSection.classList.add('hidden');
                    videoSection.classList.add('hidden');
                }
            });
        });

        // Initialize TinyMCE for description
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

        const typeSelect = document.getElementById('type');
        const fotoSection = document.getElementById('fotoSection');
        const videoSection = document.getElementById('videoSection');
        const videoInput = document.getElementById('video');

        typeSelect.addEventListener('change', function() {
            if(this.value === 'foto') {
                fotoSection.classList.remove('hidden');
                videoSection.classList.add('hidden');
            } else if(this.value === 'video') {
                videoSection.classList.remove('hidden');
                fotoSection.classList.add('hidden');
            } else {
                fotoSection.classList.add('hidden');
                videoSection.classList.add('hidden');
            }
        });

        // Preview YouTube thumbnail as user types URL
        videoInput.addEventListener('input', function() {
            const url = this.value;
            if (url) {
                // Extract YouTube video ID from URL
                let videoId = null;
                try {
                    const parsedUrl = new URL(url);
                    if (parsedUrl.hostname.includes('youtube.com') || parsedUrl.hostname.includes('youtu.be')) {
                        if (parsedUrl.searchParams.get('v')) {
                            videoId = parsedUrl.searchParams.get('v');
                        } else if (parsedUrl.pathname.split('/').pop()) {
                            videoId = parsedUrl.pathname.split('/').pop();
                        }
                    }
                } catch (e) {
                    // Invalid URL
                }

                if (videoId) {
                    // In edit view, we'll just show a preview div after the input field
                    let previewDiv = document.getElementById('videoPreview');
                    if (!previewDiv) {
                        previewDiv = document.createElement('div');
                        previewDiv.id = 'videoPreview';
                        previewDiv.className = 'mt-2';
                        previewDiv.innerHTML = `
                            <label class="block text-sm font-medium text-gray-700 mb-2">Video Preview</label>
                            <img id="videoThumbnail" src="https://img.youtube.com/vi/${videoId}/default.jpg" alt="Video Thumbnail" class="h-32 w-auto object-cover rounded border border-gray-200">
                        `;
                        videoInput.parentNode.appendChild(previewDiv);
                    } else {
                        document.getElementById('videoThumbnail').src = `https://img.youtube.com/vi/${videoId}/default.jpg`;
                    }
                } else {
                    const previewDiv = document.getElementById('videoPreview');
                    if (previewDiv) {
                        previewDiv.remove();
                    }
                }
            } else {
                const previewDiv = document.getElementById('videoPreview');
                if (previewDiv) {
                    previewDiv.remove();
                }
            }
        });
    </script>
@endsection