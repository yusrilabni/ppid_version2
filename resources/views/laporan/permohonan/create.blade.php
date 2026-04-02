@extends('frontend.layouts.app')

@section('content')
    <div class="container mx-auto py-6 md:py-8 px-4">
        <div class="max-w-6xl mx-auto">
            <x-breadcrumbs :breadcrumbs="[
                ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                ['title' => 'Permohonan Informasi', 'url' => route('laporan.permohonan.index'), 'icon' => 'fas fa-file-alt'],
                ['title' => 'Formulir Permohonan', 'url' => '#', 'icon' => 'fas fa-file-signature']
            ]" />
            
            <div class="text-center mb-8 md:mb-10 mt-4 md:mt-6">
                <div class="inline-flex items-center justify-center w-14 h-14 md:w-16 md:h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full mb-4 md:mb-6 shadow-lg">
                    <img src="{{ asset('storage/logo/ppid.webp') }}" alt="Logo PPID" class="w-10 h-10 md:w-12 md:h-12">
                </div>
                <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-2 md:mb-3">{{ __('Permohonan Informasi') }}</h1>
                <p class="text-sm md:text-base text-gray-600 max-w-2xl mx-auto px-2">
                    {{ __('Lengkapi formulir di bawah ini untuk membuat permohonan informasi publik.') }}
                </p>
            </div>

            @if (session('success'))
                <div class="mb-8 p-4 md:p-5 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 shadow-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center rounded-full bg-green-100">
                                <i class="fas fa-check-circle text-green-600 text-sm md:text-base"></i>
                            </div>
                        </div>
                        <div class="ml-3 md:ml-4">
                            <h3 class="text-base md:text-lg font-semibold text-green-800">{{ __('Permohonan Terkirim!') }}</h3>
                            <p class="text-sm md:text-base text-green-700 mt-1">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="px-5 py-4 md:px-6 md:py-5 bg-gradient-to-r from-blue-600 to-indigo-600">
                    <h2 class="text-lg md:text-xl font-bold text-white flex items-center">
                        <i class="fas fa-pen-alt mr-3 text-sm md:text-base"></i>
                        {{ __('Formulir Permohonan') }}
                    </h2>
                </div>

                <form method="POST" action="{{ route('laporan.permohonan.store') }}" class="space-y-6 md:space-y-8 p-5 md:p-10"
                    x-data="{ caraMemperoleh: [], caraMendapatkanSalinan: [], submitting: false }"
                    @submit="submitting = true">
                    @csrf

                    <!-- Section 1: Data Pemohon -->
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-7 h-7 md:w-8 md:h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 text-xs md:text-sm font-bold">1</div>
                            <h3 class="ml-3 text-lg md:text-xl font-bold text-gray-800">{{ __('Data Pemohon') }}</h3>
                            <div class="ml-4 flex-1 border-t border-gray-200"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                            <div class="space-y-1.5">
                                <label for="nama_pemohon" class="block text-xs md:text-sm font-semibold text-gray-700">
                                    {{ __('Nama Lengkap') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-user text-sm"></i>
                                    </span>
                                    <input type="text" name="nama_pemohon" id="nama_pemohon" required
                                        class="w-full pl-10 pr-4 py-2.5 md:py-3 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                                        placeholder="Nama lengkap sesuai identitas" value="{{ old('nama_pemohon') }}">
                                </div>
                                @error('nama_pemohon') <p class="text-[10px] md:text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label for="pekerjaan" class="block text-xs md:text-sm font-semibold text-gray-700">
                                    {{ __('Pekerjaan') }}
                                </label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-briefcase text-sm"></i>
                                    </span>
                                    <input type="text" name="pekerjaan" id="pekerjaan"
                                        class="w-full pl-10 pr-4 py-2.5 md:py-3 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                                        placeholder="Contoh: PNS, Swasta, Pelajar" value="{{ old('pekerjaan') }}">
                                </div>
                            </div>

                            <div class="space-y-1.5 md:col-span-2">
                                <label for="alamat_pemohon" class="block text-xs md:text-sm font-semibold text-gray-700">
                                    {{ __('Alamat Lengkap') }} <span class="text-red-500">*</span>
                                </label>
                                <textarea id="alamat_pemohon" name="alamat_pemohon" rows="3" required
                                    class="w-full px-4 py-2.5 md:py-3 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                                    placeholder="Masukkan alamat lengkap Anda">{{ old('alamat_pemohon') }}</textarea>
                            </div>

                            <div class="space-y-1.5">
                                <label for="nomor_telepon_pemohon" class="block text-xs md:text-sm font-semibold text-gray-700">
                                    {{ __('Nomor Telepon/WA') }}
                                </label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-phone text-sm"></i>
                                    </span>
                                    <input type="text" name="nomor_telepon_pemohon" id="nomor_telepon_pemohon"
                                        class="w-full pl-10 pr-4 py-2.5 md:py-3 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                                        placeholder="08xxxxxxxxxx" value="{{ old('nomor_telepon_pemohon') }}">
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label for="email_pemohon" class="block text-xs md:text-sm font-semibold text-gray-700">
                                    {{ __('Alamat Email') }}
                                </label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                        <i class="fas fa-envelope text-sm"></i>
                                    </span>
                                    <input type="email" name="email_pemohon" id="email_pemohon"
                                        class="w-full pl-10 pr-4 py-2.5 md:py-3 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                                        placeholder="nama@email.com" value="{{ old('email_pemohon') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Informasi -->
                    <div class="space-y-6 pt-6 border-t border-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-7 h-7 md:w-8 md:h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 text-xs md:text-sm font-bold">2</div>
                            <h3 class="ml-3 text-lg md:text-xl font-bold text-gray-800">{{ __('Rincian Permohonan') }}</h3>
                            <div class="ml-4 flex-1 border-t border-gray-200"></div>
                        </div>

                        <div class="space-y-5">
                            <div class="space-y-1.5">
                                <label for="detail_informasi" class="block text-xs md:text-sm font-semibold text-gray-700">
                                    {{ __('Informasi yang Dibutuhkan') }} <span class="text-red-500">*</span>
                                </label>
                                <textarea id="detail_informasi" name="detail_informasi" rows="4" required
                                    class="w-full px-4 py-2.5 md:py-3 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                                    placeholder="Sebutkan secara detail nama dokumen atau data yang Anda minta">{{ old('detail_informasi') }}</textarea>
                            </div>

                            <div class="space-y-1.5">
                                <label for="tujuan_penggunaan_informasi" class="block text-xs md:text-sm font-semibold text-gray-700">
                                    {{ __('Tujuan Penggunaan') }} <span class="text-red-500">*</span>
                                </label>
                                <textarea id="tujuan_penggunaan_informasi" name="tujuan_penggunaan_informasi" rows="3" required
                                    class="w-full px-4 py-2.5 md:py-3 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                                    placeholder="Contoh: Untuk keperluan penelitian tesis atau data pribadi">{{ old('tujuan_penggunaan_informasi') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Cara Memperoleh -->
                    <div class="space-y-6 pt-6 border-t border-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-7 h-7 md:w-8 md:h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 text-xs md:text-sm font-bold">3</div>
                            <h3 class="ml-3 text-lg md:text-xl font-bold text-gray-800">{{ __('Metode Perolehan') }}</h3>
                            <div class="ml-4 flex-1 border-t border-gray-200"></div>
                        </div>

                        <div class="space-y-4">
                            <div class="bg-blue-50/50 p-4 md:p-5 rounded-xl border border-blue-100">
                                <label class="block text-xs md:text-sm font-bold text-gray-700 mb-4">{{ __('Cara Memperoleh Informasi') }}</label>
                                <div class="grid grid-cols-1 gap-3">
                                    <label class="flex items-start p-3.5 bg-white rounded-xl border border-gray-200 hover:border-blue-400 transition-all cursor-pointer">
                                        <input type="checkbox" name="cara_memperoleh_informasi[]" value="Melihat/Membaca/Mendengarkan" x-model="caraMemperoleh" class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 rounded">
                                        <div class="ml-3">
                                            <span class="block text-sm font-bold text-gray-800">Melihat/Membaca/Mendengarkan</span>
                                            <span class="block text-[10px] md:text-xs text-gray-500 mt-0.5">Datang langsung ke lokasi PPID.</span>
                                        </div>
                                    </label>
                                    <label class="flex items-start p-3.5 bg-white rounded-xl border border-gray-200 hover:border-blue-400 transition-all cursor-pointer">
                                        <input type="checkbox" name="cara_memperoleh_informasi[]" value="Mendapat Salinan Informasi" x-model="caraMemperoleh" class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 rounded">
                                        <div class="ml-3">
                                            <span class="block text-sm font-bold text-gray-800">Mendapat Salinan (Copy)</span>
                                            <span class="block text-[10px] md:text-xs text-gray-500 mt-0.5">Mendapatkan file atau berkas fisik.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div x-show="caraMemperoleh.includes('Mendapat Salinan Informasi')" x-transition class="bg-indigo-50/50 p-4 md:p-5 rounded-xl border border-indigo-100">
                                <label class="block text-xs md:text-sm font-bold text-gray-700 mb-4">{{ __('Metode Pengiriman Salinan') }}</label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    @foreach(['Mengambil', 'Kurir', 'Pos', 'Faksmail', 'E-Mail'] as $metode)
                                        <label class="flex items-center p-3 bg-white rounded-xl border border-gray-200 hover:border-indigo-400 transition-all cursor-pointer @if($metode == 'E-Mail') col-span-2 md:col-span-1 @endif">
                                            <input type="checkbox" name="cara_mendapatkan_salinan[]" value="{{ $metode }}" x-model="caraMendapatkanSalinan" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 rounded">
                                            <span class="ml-2.5 text-xs md:text-sm font-medium text-gray-700">{{ $metode }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div x-show="caraMendapatkanSalinan.includes('Mengambil')" x-transition class="bg-blue-50 p-4 md:p-5 rounded-xl border border-blue-100">
                                <div x-data="customSelect({ data: {{ isset($units) ? json_encode($units) : '[]' }}, old: '{{ old('tempat_mendapatkan_salinan') }}' })" class="relative">
                                    <label class="block text-xs md:text-sm font-bold text-gray-700 mb-2">{{ __('Lokasi Pengambilan') }}</label>
                                    <input type="hidden" name="tempat_mendapatkan_salinan" x-model="selectedValue">
                                    <div class="relative">
                                        <button type="button" @click="open = !open" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-2.5 text-left text-sm flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                            <span class="truncate" x-text="selectedLabel || 'Pilih Dinas/Unit Kerja'"></span>
                                            <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                                        </button>
                                        <div x-show="open" @click.away="open = false" class="absolute bottom-full md:bottom-auto md:top-full mb-2 md:mb-0 md:mt-2 w-full bg-white border border-gray-200 rounded-xl shadow-2xl z-[100] overflow-hidden" x-transition x-cloak>
                                            <div class="p-2 border-b border-gray-100 bg-gray-50">
                                                <input type="text" x-model="search" @click.stop placeholder="Cari unit kerja..." class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500">
                                            </div>
                                            <ul class="max-h-60 overflow-y-auto py-1">
                                                <template x-for="item in filteredData" :key="item.unit_id">
                                                    <li @click="select(item)" class="px-4 py-2.5 text-xs hover:bg-blue-50 cursor-pointer flex justify-between items-center transition-colors">
                                                        <span x-text="item.unit_nama"></span>
                                                        <i x-show="selectedValue == item.unit_id" class="fas fa-check text-blue-600"></i>
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Privasi -->
                    <div class="space-y-6 pt-6 border-t border-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-7 h-7 md:w-8 md:h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 text-xs md:text-sm font-bold">4</div>
                            <h3 class="ml-3 text-lg md:text-xl font-bold text-gray-800">{{ __('Tingkat Privasi') }}</h3>
                            <div class="ml-4 flex-1 border-t border-gray-200"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            @foreach(['Publik' => 'Terlihat oleh umum', 'Anonim' => 'Nama Anda disamarkan', 'Rahasia' => 'Hanya untuk internal'] as $status => $desc)
                                <label class="relative flex items-start p-4 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-blue-400 transition-all has-[:checked]:bg-blue-50/50 has-[:checked]:border-blue-500">
                                    <input type="radio" name="privacy_status" value="{{ $status }}" class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500" @if($status == 'Publik') checked @endif>
                                    <div class="ml-3">
                                        <span class="block text-sm font-bold text-gray-800">{{ $status }}</span>
                                        <span class="block text-[10px] text-gray-500 mt-0.5">{{ $desc }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="pt-8 border-t border-gray-100">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                            <div class="text-[10px] md:text-xs text-gray-500 text-center md:text-left order-2 md:order-1">
                                <p class="flex items-center justify-center md:justify-start">
                                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                    {{ __('Pastikan data sudah benar sebelum dikirim.') }}
                                </p>
                                <p class="mt-1 font-medium"><span class="text-red-500">*</span> Field wajib diisi</p>
                            </div>
                                                        <button type="submit" 
                                                            :disabled="submitting"
                                                            class="w-full md:w-auto inline-flex items-center justify-center px-10 py-3.5 text-sm md:text-base font-bold rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg hover:shadow-xl active:scale-[0.98] transition-all order-1 md:order-2 disabled:opacity-70 disabled:cursor-not-allowed">
                                                            <i class="fas fa-paper-plane mr-3" x-show="!submitting"></i>
                                                            <i class="fas fa-spinner fa-spin mr-3" x-show="submitting" x-cloak></i>
                                                            <span x-text="submitting ? '{{ __('Mengirim...') }}' : '{{ __('Kirim Permohonan') }}'"></span>
                                                        </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Informasi Penting & Status Privasi -->
            <div class="mt-8 p-5 md:p-8 bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl border border-gray-200">
                <div class="flex flex-col md:flex-row items-start gap-4">
                    <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 mx-auto md:mx-0">
                        <i class="fas fa-lightbulb text-xl"></i>
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <h4 class="text-lg md:text-xl font-bold text-gray-800">{{ __('Informasi Penting & Status Privasi') }}</h4>
                        <p class="text-xs md:text-sm text-gray-500 mt-1">Harap baca informasi di bawah ini sebelum mengirimkan permohonan Anda.</p>
                        
                        <div class="mt-6 pt-6 border-t border-blue-200/60">
                            <h5 class="font-bold text-gray-700 mb-4 text-sm md:text-base flex items-center justify-center md:justify-start">
                                <i class="fas fa-user-shield mr-2 text-blue-500"></i> Penjelasan Status Privasi:
                            </h5>
                            <div class="grid grid-cols-1 gap-4 text-left">
                                <div class="p-4 bg-white/60 rounded-xl border border-blue-100">
                                    <div class="flex items-start">
                                        <i class="fas fa-globe-asia text-blue-500 mt-1 mr-3 flex-shrink-0"></i>
                                        <div class="text-xs md:text-sm text-gray-600">
                                            <strong class="text-gray-800 block mb-1">Publik:</strong>
                                            <span>Permohonan Anda dapat dilihat oleh semua orang. Memilih status ini membantu pengguna lain yang mungkin mencari informasi yang sama dan mengurangi permohonan berulang.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 bg-white/60 rounded-xl border border-yellow-100">
                                    <div class="flex items-start">
                                        <i class="fas fa-user-secret text-yellow-500 mt-1 mr-3 flex-shrink-0"></i>
                                        <div class="text-xs md:text-sm text-gray-600">
                                            <strong class="text-gray-800 block mb-1">Anonim:</strong>
                                            <span>Permohonan Anda akan tampil di daftar publik, namun nama Anda akan kami samarkan (contoh: J*****) untuk melindungi privasi Anda.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 bg-white/60 rounded-xl border border-red-100">
                                    <div class="flex items-start">
                                        <i class="fas fa-lock text-red-500 mt-1 mr-3 flex-shrink-0"></i>
                                        <div class="text-xs md:text-sm text-gray-600">
                                            <strong class="text-gray-800 block mb-1">Rahasia:</strong>
                                            <span>Permohonan Anda bersifat privat dan tidak akan ditampilkan di daftar publik. Hanya Anda dan admin yang dapat melihat detail permohonan ini.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-blue-200/60">
                             <h5 class="font-bold text-gray-700 mb-4 text-sm md:text-base flex items-center justify-center md:justify-start">
                                <i class="fas fa-clock mr-2 text-blue-500"></i> Proses & Notifikasi:
                             </h5>
                            <ul class="space-y-3 text-left">
                                <li class="flex items-start text-xs md:text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span>{{ __('Permohonan akan diproses dalam waktu maksimal 10 + 7 hari kerja sesuai regulasi yang berlaku.') }}</span>
                                </li>
                                <li class="flex items-start text-xs md:text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span>{{ __('Status permohonan dapat dipantau melalui akun atau notifikasi di website ini.') }}</span>
                                </li>
                                <li class="flex items-start text-xs md:text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span>{{ __('Pastikan data kontak yang Anda isi (email/telepon) valid dan dapat dihubungi.') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
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
                // Use robust comparison
                const selected = this.allData.find(item => item.unit_id.toString() === this.selectedValue.toString());
                return selected ? selected.unit_nama : null;
            },
            get filteredData() {
                if (!this.search || this.search.trim() === '') return this.allData;
                const term = this.search.toLowerCase().trim();
                return this.allData.filter(item => 
                    item.unit_nama && item.unit_nama.toLowerCase().includes(term)
                );
            },
            select(item) {
                this.selectedValue = item.unit_id;
                this.open = false;
                this.search = ''; // Reset search after selection
            }
        }));
    });
    </script>
@endsection
