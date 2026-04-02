@extends('frontend.layouts.app')

@section('content')
    <div class="container mx-auto my-8 px-4 md:px-0">
        <div class="max-w-6xl mx-auto">
            <x-breadcrumbs :breadcrumbs="[
                ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                ['title' => 'Permohonan Saya', 'url' => route('laporan.permohonan.saya'), 'icon' => 'fas fa-file-alt'],
                ['title' => 'Edit Permohonan', 'url' => '#', 'icon' => 'fas fa-edit']
            ]" />

            @if (session('success'))
                <div
                    class="my-8 p-5 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 shadow-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-green-100">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-green-800">{{ __('Berhasil Disimpan!') }}</h3>
                            <p class="text-green-700 mt-1">{{ session('success') }}</p>
                            <p class="text-green-600 text-sm mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                {{ __('Status permohonan dapat dicek melalui menu "Lacak Permohonan".') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="text-center mb-10 mt-6">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full mb-6 shadow-lg">
                    <img src="{{ asset('storage/logo/ppid.webp') }}" alt="Logo PPID" class="w-12 h-12">
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">{{ __('Edit Permohonan Informasi') }}</h1>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    {{ __('Perbarui detail permohonan informasi Anda. Pastikan data yang diisi sudah benar.') }}
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-indigo-600">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-pen-alt mr-3"></i>
                        {{ __('Formulir Edit Permohonan') }}
                    </h2>
                </div>

                <form method="POST" action="{{ route('laporan.permohonan.update', $permohonan) }}" class="space-y-8 p-6 md:p-10"
                    x-data="{ 
                        caraMemperoleh: {{ old('cara_memperoleh_informasi') ? json_encode(old('cara_memperoleh_informasi')) : $permohonan->cara_memperoleh_informasi ?? '[]' }}, 
                        caraMendapatkanSalinan: {{ old('cara_mendapatkan_salinan') ? json_encode(old('cara_mendapatkan_salinan')) : $permohonan->cara_mendapatkan_salinan ?? '[]' }} 
                    }">
                    @csrf
                    @method('PUT')

                    <!-- Bagian Data Pemohon -->
                    <div class="space-y-8">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-semibold">1</div>
                            <h3 class="ml-3 text-xl font-bold text-gray-800">{{ __('Data Pemohon') }}</h3>
                            <div class="ml-4 flex-1 border-t border-gray-300"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="nama_pemohon" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                    <i class="fas fa-user text-blue-500 mr-2 text-sm"></i> {{ __('Nama Pemohon') }} <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="nama_pemohon" id="nama_pemohon" class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                        placeholder="Masukkan nama lengkap" value="{{ old('nama_pemohon', $permohonan->nama_pemohon) }}" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-user text-gray-400"></i></div>
                                </div>
                                @error('nama_pemohon')<p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>@enderror
                            </div>

                            <div class="space-y-2">
                                <label for="pekerjaan" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                    <i class="fas fa-briefcase text-blue-500 mr-2 text-sm"></i> {{ __('Pekerjaan') }}
                                </label>
                                <div class="relative">
                                    <input type="text" name="pekerjaan" id="pekerjaan" class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                        placeholder="Contoh: PNS, Swasta, Pelajar" value="{{ old('pekerjaan', $permohonan->pekerjaan) }}">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-briefcase text-gray-400"></i></div>
                                </div>
                                @error('pekerjaan')<p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>@enderror
                            </div>

                            <div class="space-y-2">
                                <label for="alamat_pemohon" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                    <i class="fas fa-map-marker-alt text-blue-500 mr-2 text-sm"></i> {{ __('Alamat Pemohon') }} <span class="text-red-500 ml-1">*</span>
                                </label>
                                <textarea id="alamat_pemohon" name="alamat_pemohon" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                    placeholder="Masukkan alamat lengkap" required>{{ old('alamat_pemohon', $permohonan->alamat_pemohon) }}</textarea>
                                @error('alamat_pemohon')<p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>@enderror
                            </div>

                            <div class="space-y-2">
                                <label for="nomor_telepon_pemohon" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                    <i class="fas fa-phone text-blue-500 mr-2 text-sm"></i> {{ __('Nomor Telepon/WhatsApp') }}
                                </label>
                                <div class="relative">
                                    <input type="text" name="nomor_telepon_pemohon" id="nomor_telepon_pemohon" class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                        placeholder="08xxxxxxxxxx" value="{{ old('nomor_telepon_pemohon', $permohonan->nomor_telepon_pemohon) }}">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-phone text-gray-400"></i></div>
                                </div>
                                @error('nomor_telepon_pemohon')<p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>@enderror
                            </div>

                            <div class="space-y-2 md:col-span-2">
                                <label for="email_pemohon" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                    <i class="fas fa-envelope text-blue-500 mr-2 text-sm"></i> {{ __('Alamat Email') }}
                                </label>
                                <div class="relative">
                                    <input type="email" name="email_pemohon" id="email_pemohon" class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                        placeholder="nama@contoh.com" value="{{ old('email_pemohon', $permohonan->email_pemohon) }}">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-envelope text-gray-400"></i></div>
                                </div>
                                @error('email_pemohon')<p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Informasi yang Dibutuhkan -->
                    <div class="space-y-8 pt-6 border-t border-gray-200">
                         <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-semibold">2</div>
                            <h3 class="ml-3 text-xl font-bold text-gray-800">{{ __('Informasi yang Dibutuhkan') }}</h3>
                            <div class="ml-4 flex-1 border-t border-gray-300"></div>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label for="detail_informasi" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                    <i class="fas fa-info-circle text-blue-500 mr-2 text-sm"></i> {{ __('Rincian Informasi yang Dibutuhkan') }} <span class="text-red-500 ml-1">*</span>
                                </label>
                                <textarea id="detail_informasi" name="detail_informasi" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                    placeholder="Jelaskan secara detail informasi yang Anda butuhkan." required>{{ old('detail_informasi', $permohonan->detail_informasi) }}</textarea>
                                @error('detail_informasi')<p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>@enderror
                            </div>

                            <div class="space-y-2">
                                <label for="tujuan_penggunaan_informasi" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                    <i class="fas fa-bullseye text-blue-500 mr-2 text-sm"></i> {{ __('Tujuan Penggunaan Informasi') }} <span class="text-red-500 ml-1">*</span>
                                </label>
                                <textarea id="tujuan_penggunaan_informasi" name="tujuan_penggunaan_informasi" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                    placeholder="Jelaskan tujuan penggunaan informasi ini." required>{{ old('tujuan_penggunaan_informasi', $permohonan->tujuan_penggunaan_informasi) }}</textarea>
                                @error('tujuan_penggunaan_informasi')<p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Cara Memperoleh Informasi -->
                    <div class="space-y-8 pt-6 border-t border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-semibold">3</div>
                            <h3 class="ml-3 text-xl font-bold text-gray-800">{{ __('Cara Memperoleh Informasi') }}</h3>
                            <div class="ml-4 flex-1 border-t border-gray-300"></div>
                        </div>

                        <div class="space-y-6">
                            <div class="bg-blue-50 p-5 rounded-xl border border-blue-100">
                                <label class="block text-sm font-medium text-gray-700 mb-3 flex items-center">
                                    <i class="fas fa-tasks text-blue-500 mr-2"></i> {{ __('Pilih Cara Memperoleh Informasi') }}
                                </label>
                                <div class="space-y-3">
                                    <label class="flex items-center p-3 bg-white rounded-lg border border-gray-300 hover:border-blue-400 hover:shadow-sm transition duration-200 cursor-pointer">
                                        <input type="checkbox" name="cara_memperoleh_informasi[]" value="Melihat/Membaca/Mendengarkan" x-model="caraMemperoleh" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <div class="ml-3"><span class="font-medium text-gray-800">{{ __('Melihat/Membaca/Mendengarkan') }}</span></div>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg border border-gray-300 hover:border-blue-400 hover:shadow-sm transition duration-200 cursor-pointer">
                                        <input type="checkbox" name="cara_memperoleh_informasi[]" value="Mendapat Salinan Informasi" x-model="caraMemperoleh" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <div class="ml-3"><span class="font-medium text-gray-800">{{ __('Mendapat Salinan Informasi') }}</span></div>
                                    </label>
                                </div>
                                @error('cara_memperoleh_informasi')<p class="mt-3 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>@enderror
                            </div>

                            <div x-show="caraMemperoleh.includes('Mendapat Salinan Informasi')" x-transition.opacity.duration.300ms class="bg-indigo-50 p-5 rounded-xl border border-indigo-100">
                                <label class="block text-sm font-medium text-gray-700 mb-3 flex items-center">
                                    <i class="fas fa-shipping-fast text-indigo-500 mr-2"></i> {{ __('Cara Mendapatkan Salinan Informasi') }}
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <label class="flex items-center p-3 bg-white rounded-lg border border-gray-300 hover:border-indigo-400 hover:shadow-sm transition duration-200 cursor-pointer">
                                        <input type="checkbox" name="cara_mendapatkan_salinan[]" value="Mengambil" x-model="caraMendapatkanSalinan" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <div class="ml-3"><span class="font-medium text-gray-800">{{ __('Mengambil Langsung') }}</span></div>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg border border-gray-300 hover:border-indigo-400 hover:shadow-sm transition duration-200 cursor-pointer">
                                        <input type="checkbox" name="cara_mendapatkan_salinan[]" value="Kurir" x-model="caraMendapatkanSalinan" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <div class="ml-3"><span class="font-medium text-gray-800">{{ __('Kurir') }}</span></div>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg border border-gray-300 hover:border-indigo-400 hover:shadow-sm transition duration-200 cursor-pointer">
                                        <input type="checkbox" name="cara_mendapatkan_salinan[]" value="Pos" x-model="caraMendapatkanSalinan" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <div class="ml-3"><span class="font-medium text-gray-800">{{ __('Pos') }}</span></div>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg border border-gray-300 hover:border-indigo-400 hover:shadow-sm transition duration-200 cursor-pointer">
                                        <input type="checkbox" name="cara_mendapatkan_salinan[]" value="Faksmail" x-model="caraMendapatkanSalinan" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <div class="ml-3"><span class="font-medium text-gray-800">{{ __('Faksmail') }}</span></div>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg border border-gray-300 hover:border-indigo-400 hover:shadow-sm transition duration-200 cursor-pointer md:col-span-2">
                                        <input type="checkbox" name="cara_mendapatkan_salinan[]" value="E-Mail" x-model="caraMendapatkanSalinan" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <div class="ml-3"><span class="font-medium text-gray-800">{{ __('E-Mail') }}</span></div>
                                    </label>
                                </div>
                                @error('cara_mendapatkan_salinan')<p class="mt-3 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>@enderror
                            </div>

                            <div x-show="caraMendapatkanSalinan.includes('Mengambil')" x-transition.scale.origin.top.duration.300ms class="bg-blue-50 p-5 rounded-xl border border-blue-100">
                                <div x-data="customSelect({ data: {{ isset($units) ? json_encode($units) : '[]' }}, old: '{{ old('tempat_mendapatkan_salinan', $permohonan->tempat_mendapatkan_salinan) }}' })" class="relative">
                                    <label for="tempat_mendapatkan_salinan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-university text-blue-500 mr-2"></i> {{ __('Tempat Mengambil Salinan') }}
                                    </label>
                                    <input type="hidden" name="tempat_mendapatkan_salinan" x-model="selectedValue">
                                    <div class="relative">
                                        <button type="button" @click="open = !open" class="relative w-full bg-white border border-gray-300 rounded-xl shadow-sm pl-3 pr-10 py-3 text-left cursor-default focus:outline-none focus:ring-2 focus:ring-blue-500/20 sm:text-sm transition-all">
                                            <span class="flex items-center"><span class="ml-3 block truncate" x-text="selectedLabel || '-- Pilih Dinas/Unit Kerja --'"></span></span>
                                            <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"><svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></span>
                                        </button>
                                        <div x-show="open" @click.away="open = false" class="absolute mt-1 w-full rounded-md bg-white shadow-lg z-[100] border border-gray-100 overflow-hidden" x-transition x-cloak>
                                            <div class="p-2 bg-gray-50 border-b">
                                                <input type="text" x-model="search" @click.stop placeholder="Cari dinas..." 
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-indigo-500 text-sm">
                                            </div>
                                            <ul class="max-h-60 py-1 text-base overflow-auto focus:outline-none sm:text-sm" tabindex="-1" role="listbox">
                                                <template x-for="item in filteredData" :key="item.unit_id">
                                                    <li @click="select(item)" class="text-gray-900 cursor-default select-none relative py-2.5 pl-3 pr-9 hover:bg-indigo-600 hover:text-white transition-colors">
                                                        <span class="font-normal block truncate" x-text="item.unit_nama"></span>
                                                        <template x-if="selectedValue == item.unit_id">
                                                            <span class="text-indigo-600 absolute inset-y-0 right-0 flex items-center pr-4"><svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg></span>
                                                        </template>
                                                    </li>
                                                </template>
                                                <template x-if="filteredData.length === 0">
                                                    <li class="px-4 py-3 text-xs text-gray-500 text-center italic">
                                                        {{ __('Data tidak ditemukan.') }}
                                                    </li>
                                                </template>
                                            </ul>
                                        </div>
                                    </div>
                                    @error('tempat_mendapatkan_salinan')<p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                    document.addEventListener('alpine:init', () => {
                        Alpine.data('customSelect', ({ data, old }) => ({
                            open: false,
                            search: '',
                            allData: data,
                            selectedValue: old || null,
                            get selectedLabel() {
                                if (!this.selectedValue) return null;
                                // Perbandingan string yang lebih kuat
                                const selected = this.allData.find(item => String(item.unit_id) === String(this.selectedValue));
                                return selected ? selected.unit_nama : null;
                            },
                            get filteredData() {
                                const term = this.search.toLowerCase().trim();
                                if (!term) return this.allData;
                                return this.allData.filter(item => 
                                    item.unit_nama && item.unit_nama.toLowerCase().includes(term)
                                );
                            },
                            select(item) {
                                this.selectedValue = String(item.unit_id);
                                this.open = false;
                                this.search = ''; 
                            }
                        }));
                    });
                    </script>
                    
                    <!-- Bagian Status Privasi -->
                    <div class="space-y-8 pt-6 border-t border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-semibold">4</div>
                            <h3 class="ml-3 text-xl font-bold text-gray-800">{{ __('Status Privasi Permohonan') }}</h3>
                            <div class="ml-4 flex-1 border-t border-gray-300"></div>
                        </div>

                        <div class="bg-blue-50 p-5 rounded-xl border border-blue-100">
                            <label class="block text-sm font-medium text-gray-700 mb-3 flex items-center">
                                <i class="fas fa-shield-alt text-blue-500 mr-2"></i> {{ __('Pilih Tingkat Privasi') }}
                            </label>
                            <div class="space-y-3">
                                <label class="flex items-center p-3 bg-white rounded-lg border border-gray-300 hover:border-blue-400 hover:shadow-sm transition duration-200 cursor-pointer">
                                    <input type="radio" name="privacy_status" value="Publik" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300" @checked(old('privacy_status', $permohonan->privacy_status) == 'Publik')>
                                    <div class="ml-3"><span class="font-medium text-gray-800">{{ __('Publik') }}</span></div>
                                </label>
                                <label class="flex items-center p-3 bg-white rounded-lg border border-gray-300 hover:border-blue-400 hover:shadow-sm transition duration-200 cursor-pointer">
                                    <input type="radio" name="privacy_status" value="Anonim" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300" @checked(old('privacy_status', $permohonan->privacy_status) == 'Anonim')>
                                    <div class="ml-3"><span class="font-medium text-gray-800">{{ __('Anonim') }}</span></div>
                                </label>
                                <label class="flex items-center p-3 bg-white rounded-lg border border-gray-300 hover:border-blue-400 hover:shadow-sm transition duration-200 cursor-pointer">
                                    <input type="radio" name="privacy_status" value="Rahasia" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300" @checked(old('privacy_status', $permohonan->privacy_status) == 'Rahasia')>
                                    <div class="ml-3"><span class="font-medium text-gray-800">{{ __('Rahasia') }}</span></div>
                                </label>
                            </div>
                            @error('privacy_status')<p class="mt-3 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Bagian Tombol Submit -->
                    <div class="pt-8 border-t border-gray-200">
                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center justify-center px-8 py-3.5 text-base font-bold rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-lg hover:from-green-600 hover:to-emerald-700 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:-translate-y-0.5 transition-all duration-200 min-w-[200px]">
                                <i class="fas fa-save mr-3 text-lg"></i>
                                {{ __('Simpan Perubahan') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Informasi Tambahan -->
            <div class="mt-8 p-6 bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl border border-gray-200">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-lightbulb text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-semibold text-gray-800">{{ __('Informasi Penting & Status Privasi') }}</h4>
                        <p class="text-sm text-gray-500 mt-1">Harap baca informasi di bawah ini sebelum mengirimkan permohonan Anda.</p>
                        
                        <div class="mt-4 pt-4 border-t border-blue-200">
                            <h5 class="font-semibold text-gray-700 mb-2">Penjelasan Status Privasi:</h5>
                            <ul class="space-y-3 text-gray-600">
                                <li class="flex items-start">
                                    <i class="fas fa-globe-asia text-blue-500 mt-1 mr-3"></i>
                                    <div>
                                        <strong class="font-semibold text-gray-800">Publik:</strong>
                                        <span>Permohonan Anda dapat dilihat oleh semua orang. Memilih status ini membantu pengguna lain yang mungkin mencari informasi yang sama dan mengurangi permohonan berulang.</span>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-user-secret text-yellow-500 mt-1 mr-3"></i>
                                    <div>
                                        <strong class="font-semibold text-gray-800">Anonim:</strong>
                                        <span>Permohonan Anda akan tampil di daftar publik, namun nama Anda akan kami samarkan (contoh: J*****) untuk melindungi privasi Anda.</span>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-lock text-red-500 mt-1 mr-3"></i>
                                    <div>
                                        <strong class="font-semibold text-gray-800">Rahasia:</strong>
                                        <span>Permohonan Anda bersifat privat dan tidak akan ditampilkan di daftar publik. Hanya Anda dan admin yang dapat melihat detail permohonan ini. Gunakan status ini jika informasi yang Anda minta bersifat sangat pribadi atau sensitif.</span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-4 pt-4 border-t border-blue-200">
                             <h5 class="font-semibold text-gray-700 mb-2">Proses & Notifikasi:</h5>
                            <ul class="space-y-2 text-gray-600">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                    <span>{{ __('Permohonan akan diproses dalam waktu maksimal 14 hari kerja sesuai UU KIP.') }}</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                    <span>{{ __('Status permohonan dapat dipantau melalui akun atau notifikasi di website ini.') }}</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                    <span>{{ __('Pastikan data kontak yang Anda isi (email/telepon) valid dan dapat dihubungi.') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Animasi untuk checkbox */
        input[type="checkbox"]:checked, input[type="radio"]:checked {
            animation: checkAnim 0.2s ease-in-out;
        }

        @keyframes checkAnim {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    </style>
@endsection