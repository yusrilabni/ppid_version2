@extends('frontend.layouts.app')

@section('title', 'Edit Informasi Pemkab')

@section('content')
<div class="relative min-h-screen bg-gray-50 pt-4 md:pt-6 pb-16">
    <!-- Dekorasi Background -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-0 w-full h-80 bg-gradient-to-b from-amber-700 via-amber-600 to-transparent opacity-90"></div>
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-overlay"></div>
    </div>

    <div class="container max-w-5xl mx-auto px-4 relative z-10">
        <div class="mb-6">
            <x-breadcrumbs :breadcrumbs="[
                ['title' => 'Beranda', 'url' => route('home'), 'icon' => 'fas fa-home'],
                ['title' => 'Transparansi', 'url' => '#', 'icon' => 'fas fa-layer-group'],
                ['title' => 'Informasi Pemkab', 'url' => route('frontend.informasi-pemkab.index'), 'icon' => 'fas fa-file-pdf'],
                ['title' => 'Edit Dokumen', 'url' => '#', 'icon' => 'fas fa-edit'],
            ]" theme="dark" />
        </div>

        @if(session('error'))
        <div class="mb-6 bg-red-50/90 border border-red-200 text-red-700 px-6 py-4 rounded-2xl shadow-sm flex items-start backdrop-blur-sm relative z-20">
            <div class="flex-shrink-0 mt-0.5">
                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-bold text-red-800">Gagal Memproses Dokumen</h3>
                <p class="mt-1 text-sm">{{ session('error') }}</p>
                @if(str_contains(session('error'), 'SQLSTATE'))
                    <p class="mt-2 text-xs opacity-75 font-mono">Pastikan Anda sudah menjalankan perintah: php artisan migrate --force</p>
                @endif
            </div>
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-6 bg-red-50/90 border border-red-200 text-red-700 px-6 py-4 rounded-2xl shadow-sm flex items-start backdrop-blur-sm relative z-20">
            <div class="flex-shrink-0 mt-0.5">
                <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-bold text-red-800">Terdapat Kesalahan Pengisian Form:</h3>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-white/50 relative z-10">
            <div class="bg-gradient-to-r from-amber-500 via-orange-500 to-amber-600 p-8 md:p-10 text-white relative overflow-hidden">
                <!-- Dekorasi Header Card -->
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-black mb-2 tracking-tight">Edit Dokumen</h2>
                        <p class="text-amber-100 font-medium text-lg">Perbarui informasi dan file lampiran dokumen</p>
                    </div>
                    <div class="hidden md:flex w-16 h-16 bg-white/20 rounded-2xl items-center justify-center backdrop-blur-sm border border-white/30 transform rotate-3 hover:rotate-6 transition-transform">
                        <i class="fas fa-edit text-3xl text-white"></i>
                    </div>
                </div>
            </div>

            <div class="p-8 md:p-10">
                <form action="{{ route('admin.informasi-pemkab.update', $informasi_pemkab->id) }}" method="POST" enctype="multipart/form-data" 
                      x-data="pemkabForm" class="relative">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <!-- Judul -->
                        <div class="md:col-span-2">
                            <label for="judul" class="block text-gray-700 text-sm font-bold mb-3">Judul Dokumen <span class="text-red-500">*</span></label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul', $informasi_pemkab->judul) }}" placeholder="Masukkan judul yang deskriptif..."
                                class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all duration-300 font-medium text-gray-800 placeholder-gray-400 shadow-sm">
                            @error('judul')
                                <p class="text-red-500 text-xs mt-2 font-medium"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="md:col-span-2">
                            <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-3">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Tuliskan keterangan singkat mengenai dokumen ini..."
                                class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all duration-300 font-medium text-gray-800 placeholder-gray-400 shadow-sm">{{ old('deskripsi', $informasi_pemkab->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-xs mt-2 font-medium"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        @php
                            $kategoriOptions = collect($kategori_jenis)->keys()->map(function($kat) {
                                return ['value' => $kat, 'label' => $kat];
                            })->toArray();
                        @endphp
                        <div class="relative z-50">
                            <label for="kategori" class="block text-gray-700 text-sm font-bold mb-3">Kategori <span class="text-red-500">*</span></label>
                            <x-custom-select 
                                name="kategori" 
                                :options="$kategoriOptions" 
                                :value="old('kategori', $informasi_pemkab->kategori)"
                                placeholder="Pilih Kategori Dokumen"
                                :searchable="false"
                                @change="kategoriChanged($event.detail.value)"
                                class="shadow-sm"
                            />
                            @error('kategori')
                                <p class="text-red-500 text-xs mt-2 font-medium"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Dokumen -->
                        <div class="relative z-40">
                            <label for="jenis_dokumen" class="block text-gray-700 text-sm font-bold mb-3">Jenis Dokumen <span class="text-red-500">*</span></label>
                            <x-custom-select 
                                name="jenis_dokumen" 
                                :options="[]" 
                                :value="old('jenis_dokumen', $informasi_pemkab->jenis_dokumen)"
                                placeholder="Pilih Jenis Dokumen"
                                :searchable="false"
                                class="shadow-sm"
                            />
                            @error('jenis_dokumen')
                                <p class="text-red-500 text-xs mt-2 font-medium"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tahun -->
                        <div>
                            <label for="tahun" class="block text-gray-700 text-sm font-bold mb-3">Tahun Dokumen <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i class="far fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input type="number" name="tahun" id="tahun" value="{{ old('tahun', $informasi_pemkab->tahun) }}" min="2000" max="2099"
                                    class="w-full pl-12 pr-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all duration-300 font-bold text-gray-800 shadow-sm">
                            </div>
                            @error('tahun')
                                <p class="text-red-500 text-xs mt-2 font-medium"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status & Jadwal -->
                        <div class="md:col-span-2 border-2 border-dashed border-gray-200 rounded-2xl p-6 bg-gray-50/50 hover:bg-gray-50 transition-colors duration-300 relative z-30">
                            <label class="block text-gray-800 text-base font-bold mb-4">Pengaturan Penerbitan <span class="text-red-500">*</span></label>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-30">
                                @php
                                    $statusOptions = [
                                        ['value' => 'published', 'label' => 'Langsung Terbitkan (Published)'],
                                        ['value' => 'draft', 'label' => 'Simpan Sebagai Draft'],
                                        ['value' => 'scheduled', 'label' => 'Jadwalkan Penerbitan'],
                                    ];
                                @endphp
                                <div class="relative z-30">
                                    <label class="block text-gray-700 text-sm font-bold mb-3">Status Dokumen</label>
                                    <x-custom-select 
                                        name="status" 
                                        :options="$statusOptions" 
                                        :value="old('status', $informasi_pemkab->status ?? 'published')"
                                        placeholder="Pilih Status"
                                        :searchable="false"
                                        @change="statusDokumen = $event.detail.value"
                                        class="shadow-sm"
                                    />
                                    @error('status')
                                        <p class="text-red-500 text-xs mt-2 font-medium"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-3">Visibilitas</label>
                                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                                        <label class="flex-1 flex items-center p-3 border border-gray-200 rounded-xl bg-white cursor-pointer hover:border-amber-300 transition-all">
                                            <input type="radio" name="visibility" value="public" x-model="visibility" class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500">
                                            <span class="ml-3 text-sm font-bold text-gray-800">Publik <span class="block font-normal text-xs text-gray-500">Dapat dilihat semua orang</span></span>
                                        </label>
                                        <label class="flex-1 flex items-center p-3 border border-gray-200 rounded-xl bg-white cursor-pointer hover:border-amber-300 transition-all">
                                            <input type="radio" name="visibility" value="private" x-model="visibility" class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500">
                                            <span class="ml-3 text-sm font-bold text-gray-800">Privat <span class="block font-normal text-xs text-gray-500">Hanya untuk internal</span></span>
                                        </label>
                                    </div>
                                    @error('visibility')
                                        <p class="text-red-500 text-xs mt-2 font-medium"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Input Jadwal -->
                            <div x-show="statusDokumen === 'scheduled'" x-collapse x-cloak class="mt-6 pt-6 border-t border-gray-200">
                                <label for="published_at" class="block text-gray-700 text-sm font-bold mb-3">Pilih Tanggal & Waktu Rilis</label>
                                <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', $informasi_pemkab->published_at ? date('Y-m-d\TH:i', strtotime($informasi_pemkab->published_at)) : '') }}"
                                    class="w-full md:w-1/2 px-5 py-4 bg-white border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all duration-300 font-medium text-gray-800 shadow-sm">
                                @error('published_at')
                                    <p class="text-red-500 text-xs mt-2 font-medium"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tipe Upload & Input File/URL -->
                        @php
                            $isLink = str_starts_with($informasi_pemkab->file_path, 'http');
                        @endphp
                        <div class="md:col-span-2 border-2 border-dashed border-amber-200 rounded-2xl p-6 bg-amber-50/30 hover:bg-amber-50/60 transition-colors duration-300 group">
                            <label class="block text-amber-900 text-base font-bold mb-4">Metode Lampiran Dokumen <span class="text-red-500">*</span></label>
                            
                            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-6 mb-6">
                                <label class="flex items-center cursor-pointer p-4 border border-amber-100 rounded-xl bg-white shadow-sm hover:shadow-md hover:border-amber-300 transition-all">
                                    <input type="radio" name="upload_method" value="file" x-model="uploadMethod" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500">
                                    <div class="ml-3">
                                        <span class="block text-sm font-bold text-gray-800">Upload File Lokal</span>
                                        <span class="block text-xs text-gray-500 mt-0.5">PDF, Word, Excel, ZIP (Max 2MB)</span>
                                    </div>
                                </label>
                                <label class="flex items-center cursor-pointer p-4 border border-amber-100 rounded-xl bg-white shadow-sm hover:shadow-md hover:border-amber-300 transition-all">
                                    <input type="radio" name="upload_method" value="link" x-model="uploadMethod" class="w-5 h-5 text-amber-600 border-gray-300 focus:ring-amber-500">
                                    <div class="ml-3">
                                        <span class="block text-sm font-bold text-gray-800">Link Eksternal</span>
                                        <span class="block text-xs text-gray-500 mt-0.5">Google Drive, Dropbox, dll.</span>
                                    </div>
                                </label>
                            </div>
                            @error('upload_method')
                                <p class="text-red-500 text-xs mt-1 mb-4 font-medium"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror

                            <!-- Input File Lokal -->
                            <div x-show="uploadMethod === 'file'" x-collapse x-cloak>
                                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                                    <label for="file" class="block text-gray-700 text-sm font-bold mb-3">Upload File Baru (Biarkan kosong jika tidak diubah)</label>
                                    <input type="file" name="file" id="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar"
                                        class="w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-amber-100 file:text-amber-700 hover:file:bg-amber-200 transition-all cursor-pointer bg-gray-50 rounded-xl border border-gray-100">
                                    
                                    @if(!$isLink && $informasi_pemkab->file_path)
                                        <div class="mt-4 p-3 bg-amber-50 border border-amber-100 rounded-lg inline-flex items-center text-sm text-amber-700 font-bold shadow-sm">
                                            <i class="fas fa-file-alt mr-2 text-amber-500 text-lg"></i>
                                            <a href="{{ asset('storage/' . $informasi_pemkab->file_path) }}" target="_blank" class="hover:underline hover:text-amber-900 transition-colors">
                                                Lihat File Saat Ini
                                            </a>
                                        </div>
                                    @endif
                                    
                                    @error('file')
                                        <p class="text-red-500 text-xs mt-2 font-medium"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Input Link Eksternal -->
                            <div x-show="uploadMethod === 'link'" x-collapse x-cloak>
                                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                                    <label for="link" class="block text-gray-700 text-sm font-bold mb-3">Masukkan URL Dokumen</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-link text-gray-400"></i>
                                        </div>
                                        <input type="url" name="link" id="link" value="{{ old('link', $isLink ? $informasi_pemkab->file_path : '') }}" placeholder="https://drive.google.com/..."
                                            class="w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all duration-300 font-medium text-gray-800 placeholder-gray-400">
                                    </div>
                                    <p class="text-xs text-amber-600 mt-2 font-medium"><i class="fas fa-info-circle mr-1"></i>Pastikan pengaturan privasi link adalah "Siapa saja yang memiliki link" (Public).</p>
                                    
                                    @if($isLink && $informasi_pemkab->file_path)
                                        <div class="mt-4 p-3 bg-amber-50 border border-amber-100 rounded-lg inline-flex items-center text-sm text-amber-700 font-bold shadow-sm">
                                            <i class="fas fa-external-link-square-alt mr-2 text-amber-500 text-lg"></i>
                                            <a href="{{ $informasi_pemkab->file_path }}" target="_blank" class="hover:underline hover:text-amber-900 transition-colors">
                                                Kunjungi Link Saat Ini
                                            </a>
                                        </div>
                                    @endif
                                    
                                    @error('link')
                                        <p class="text-red-500 text-xs mt-2 font-medium"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 pt-6 border-t border-gray-100 flex flex-col-reverse sm:flex-row justify-end sm:space-x-4 relative z-10">
                        <a href="{{ route('frontend.informasi-pemkab.index') }}" class="mt-3 sm:mt-0 px-8 py-3.5 bg-white text-gray-700 font-bold rounded-xl border-2 border-gray-200 hover:bg-gray-50 hover:border-gray-300 transition-all duration-300 flex items-center justify-center">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-3.5 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-bold rounded-xl hover:from-amber-600 hover:to-amber-700 shadow-lg shadow-amber-500/30 hover:shadow-amber-600/40 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Private -->
    <div x-data="{}" x-show="showPrivateModal" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden" style="display: none;" x-cloak>
        <!-- Backdrop -->
        <div x-show="showPrivateModal" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-black/60 backdrop-blur-sm"
             @click="cancelPrivate()"></div>

        <!-- Modal Panel -->
        <div x-show="showPrivateModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md p-6 sm:p-8 m-4 z-[101]">
             
             <div class="flex items-center justify-center w-20 h-20 rounded-full bg-orange-100 mx-auto mb-6 shadow-inner">
                 <i class="fas fa-lock text-4xl text-orange-500"></i>
             </div>

             <h3 class="text-2xl font-black text-gray-900 text-center mb-4 tracking-tight">Ketentuan Privat</h3>
             
             <p class="text-sm text-gray-600 text-center mb-8 leading-relaxed">
                 Dokumen ini <strong class="text-red-600">tidak akan dibuka untuk umum</strong>.<br><br>
                 Hanya dapat dilihat oleh Admin yang login. Anda dapat membagikan <strong class="text-gray-800">link detailnya</strong> nanti kepada orang yang bersangkutan, sehingga hanya yang memiliki link tersebut yang dapat melihatnya.
             </p>

             <div class="flex flex-col space-y-3">
                 <button type="button" @click="acceptPrivate()" class="w-full px-6 py-3.5 bg-orange-500 text-white font-bold rounded-xl hover:bg-orange-600 transition-colors shadow-lg shadow-orange-500/30">
                     Ya, Saya Setuju
                 </button>
                 <button type="button" @click="cancelPrivate()" class="w-full px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-colors">
                     Batal (Kembali ke Publik)
                 </button>
             </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('pemkabForm', () => ({
            mapping: @json($kategori_jenis),
            uploadMethod: '{{ old('upload_method', $isLink ? 'link' : 'file') }}',
            statusDokumen: '{{ old('status', $informasi_pemkab->status ?? 'published') }}',
            visibility: '{{ old('visibility', $informasi_pemkab->visibility ?? 'public') }}',
            showPrivateModal: false,
            
            init() {
                // Initialize jenis options if old value exists
                let initialKat = '{{ old('kategori', $informasi_pemkab->kategori) }}';
                if (initialKat) {
                    this.kategoriChanged(initialKat);
                }

                // Watch visibility changes
                this.$watch('visibility', (value) => {
                    if (value === 'private') {
                        this.showPrivateModal = true;
                    }
                });
            },

            cancelPrivate() {
                this.showPrivateModal = false;
                this.visibility = 'public'; // Revert back to public
            },
            
            acceptPrivate() {
                this.showPrivateModal = false;
                // keep visibility as private
            },
            
            kategoriChanged(val) {
                let opts = [];
                if (val && this.mapping[val]) {
                    opts = this.mapping[val].map(item => ({value: item, label: item}));
                }
                
                // Dispatch event to update the jenis_dokumen custom-select component
                window.dispatchEvent(new CustomEvent('update-options', {
                    detail: { target: 'jenis_dokumen', data: opts }
                }));
            }
        }));
    });
</script>
@endsection
