@extends('admin.layouts.app')

@section('title', 'Tambah Profil PPID')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Tambah Profil PPID Baru</h2>

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('admin.profil-ppid.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 1. INFORMASI PROFIL -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">1. Informasi Profil</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Profil</label>
                        <select name="status" id="status" class="form-select w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('status', 0) == 0 ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- 2. VISI DAN MISI PPID -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">2. Visi dan Misi PPID</h3>
                <div class="mb-4">
                    <label for="vision" class="block text-sm font-medium text-gray-700 mb-1">Visi PPID</label>
                    <textarea name="vision" id="vision" rows="5" class="form-textarea w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('vision') }}</textarea>
                    <x-input-error :messages="$errors->get('vision')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Misi PPID</label>
                    <div id="mission_fields_container">
                        @if(old('mission') && is_array(old('mission')))
                            @foreach(old('mission') as $index => $missionText)
                                <div class="mission-item flex items-center mb-2">
                                    <textarea name="mission[]" rows="3" class="form-textarea w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 mr-2">{{ $missionText }}</textarea>
                                    <button type="button" class="remove-mission-btn text-red-500 hover:text-red-700 p-2"><i class="fas fa-trash"></i></button>
                                </div>
                            @endforeach
                        @else
                            <div class="mission-item flex items-center mb-2">
                                <textarea name="mission[]" rows="3" class="form-textarea w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 mr-2"></textarea>
                                <button type="button" class="remove-mission-btn text-red-500 hover:text-red-700 p-2"><i class="fas fa-trash"></i></button>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add_mission_btn" class="mt-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg transition flex items-center">
                        <i class="fas fa-plus mr-2"></i> Tambah Misi
                    </button>
                    <x-input-error :messages="$errors->get('mission')" class="mt-2" />
                    <x-input-error :messages="$errors->get('mission.*')" class="mt-2" />
                </div>
            </div>

            <!-- 3. STRUKTUR ORGANISASI PPID -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">3. Struktur Organisasi PPID</h3>
                <div class="mb-4">
                    <label for="structure_image" class="block text-sm font-medium text-gray-700 mb-1">Upload Foto Struktur Organisasi PPID (JPG/PNG)</label>
                    <input type="file" name="structure_image" id="structure_image" class="form-input w-full rounded-md shadow-sm border-gray-300" accept="image/jpeg,image/png">
                    <x-input-error :messages="$errors->get('structure_image')" class="mt-2" />
                    <div id="structure_image_preview" class="mt-2"></div>
                </div>
            </div>

            <!-- 4. KONTAK PPID -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">4. Kontak PPID</h3>
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Kantor</label>
                    <textarea name="address" id="address" rows="3" class="form-textarea w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('address') }}</textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="text" name="phone" id="phone" class="form-input w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('phone') }}">
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Resmi</label>
                        <input type="email" name="email" id="email" class="form-input w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('email') }}">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- 5. LOKASI & MAPS -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">5. Lokasi & Maps</h3>
                <div class="mb-4">
                    <label for="maps_url" class="block text-sm font-medium text-gray-700 mb-1">Google Maps URL</label>
                    <input type="url" name="maps_url" id="maps_url" class="form-input w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('maps_url') }}" placeholder="Paste Google Maps URL here">
                    <x-input-error :messages="$errors->get('maps_url')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Preview Peta</label>
                    <div id="map_preview_container" class="w-full h-64 bg-gray-200 rounded-md flex items-center justify-center text-gray-500 overflow-hidden">
                        @if(old('maps_url'))
                            <iframe src="{{ old('maps_url') }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @else
                            Peta akan ditampilkan di sini setelah URL Google Maps dimasukkan.
                        @endif
                    </div>
                </div>
            </div>

            <!-- 6. MEDIA SOSIAL -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">6. Media Sosial & Website</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="instagram" class="block text-sm font-medium text-gray-700 mb-1">Instagram (URL)</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                <i class="fab fa-instagram"></i>
                            </span>
                            <input type="text" name="instagram" id="instagram" class="form-input flex-1 rounded-none rounded-r-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('instagram') }}" placeholder="https://www.instagram.com/username">
                        </div>
                        <x-input-error :messages="$errors->get('instagram')" class="mt-2" />
                    </div>
                    <div>
                        <label for="facebook" class="block text-sm font-medium text-gray-700 mb-1">Facebook (URL)</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                <i class="fab fa-facebook"></i>
                            </span>
                            <input type="text" name="facebook" id="facebook" class="form-input flex-1 rounded-none rounded-r-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('facebook') }}" placeholder="https://www.facebook.com/username">
                        </div>
                        <x-input-error :messages="$errors->get('facebook')" class="mt-2" />
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="twitter" class="block text-sm font-medium text-gray-700 mb-1">Twitter (URL)</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                <i class="fab fa-twitter"></i>
                            </span>
                            <input type="text" name="twitter" id="twitter" class="form-input flex-1 rounded-none rounded-r-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('twitter') }}" placeholder="https://twitter.com/username">
                        </div>
                        <x-input-error :messages="$errors->get('twitter')" class="mt-2" />
                    </div>
                    <div>
                        <label for="tiktok" class="block text-sm font-medium text-gray-700 mb-1">TikTok (URL)</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                <i class="fab fa-tiktok"></i>
                            </span>
                            <input type="text" name="tiktok" id="tiktok" class="form-input flex-1 rounded-none rounded-r-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('tiktok') }}" placeholder="https://www.tiktok.com/@@username">
                        </div>
                        <x-input-error :messages="$errors->get('tiktok')" class="mt-2" />
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="youtube" class="block text-sm font-medium text-gray-700 mb-1">YouTube (URL)</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                <i class="fab fa-youtube"></i>
                            </span>
                            <input type="text" name="youtube" id="youtube" class="form-input flex-1 rounded-none rounded-r-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('youtube') }}" placeholder="https://www.youtube.com/@@channel">
                        </div>
                        <x-input-error :messages="$errors->get('youtube')" class="mt-2" />
                    </div>
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website Pemda (URL)</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                <i class="fas fa-globe"></i>
                            </span>
                            <input type="text" name="website" id="website" class="form-input flex-1 rounded-none rounded-r-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('website') }}" placeholder="https://www.sinjaikab.go.id">
                        </div>
                        <x-input-error :messages="$errors->get('website')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- 6. AKSI FORM -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.profil-ppid.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">Simpan</button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function setupImagePreview(inputId, previewId) {
                const input = document.getElementById(inputId);
                const previewContainer = document.getElementById(previewId);
                if (input) {
                    input.addEventListener('change', function() {
                        previewContainer.innerHTML = '';
                        if (this.files && this.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.classList.add('w-24', 'h-24', 'object-cover', 'rounded-md', 'mt-2');
                                previewContainer.appendChild(img);
                            };
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                }
            }
            setupImagePreview('structure_image', 'structure_image_preview');

            const mapsUrlInput = document.getElementById('maps_url');
            const mapPreviewContainer = document.getElementById('map_preview_container');
            function updateMapPreview() {
                const url = mapsUrlInput ? mapsUrlInput.value : '';
                if (url) {
                    let embedUrl = '';
                    if (url.includes('google.com/maps/embed')) {
                        embedUrl = url;
                    } else if (url.includes('google.com/maps/place/')) {
                        const placeIdMatch = url.match(/data=!3m\d!1s(.*?)(!|$)/);
                        if (placeIdMatch && placeIdMatch[1]) {
                            embedUrl = `https://www.google.com/maps/embed/v1/place?q=place_id:${placeIdMatch[1]}`;
                        } else {
                            embedUrl = url.replace('/maps/place/', '/maps/embed?q=');
                        }
                    } else if (url.includes('google.com/maps/')) {
                        embedUrl = `https://www.google.com/maps/embed?q=${encodeURIComponent(url)}`;
                    }
                    if (embedUrl) {
                        mapPreviewContainer.innerHTML = `<iframe src="${embedUrl}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>`;
                    } else {
                        mapPreviewContainer.innerHTML = `<div class="w-full h-full bg-gray-200 rounded-md flex items-center justify-center text-gray-500">URL tidak valid.</div>`;
                    }
                } else {
                    mapPreviewContainer.innerHTML = `<div class="w-full h-full bg-gray-200 rounded-md flex items-center justify-center text-gray-500">Peta akan ditampilkan di sini.</div>`;
                }
            }
            if (mapsUrlInput) {
                mapsUrlInput.addEventListener('input', updateMapPreview);
                updateMapPreview(); 
            }

            const addMissionBtn = document.getElementById('add_mission_btn');
            const missionFieldsContainer = document.getElementById('mission_fields_container');
            if (addMissionBtn) {
                addMissionBtn.addEventListener('click', function() {
                    const newMissionHtml = `
                        <div class="mission-item flex items-center mb-2">
                            <textarea name="mission[]" rows="3" class="form-textarea w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 mr-2"></textarea>
                            <button type="button" class="remove-mission-btn text-red-500 hover:text-red-700 p-2"><i class="fas fa-trash"></i></button>
                        </div>
                    `;
                    missionFieldsContainer.insertAdjacentHTML('beforeend', newMissionHtml);
                });
            }
            if (missionFieldsContainer) {
                missionFieldsContainer.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-mission-btn') || e.target.closest('.remove-mission-btn')) {
                        if (confirm('Apakah Anda yakin ingin menghapus misi ini?')) {
                            e.target.closest('.mission-item').remove();
                        }
                    }
                });
            }
        </script>
    @endpush
@endsection
