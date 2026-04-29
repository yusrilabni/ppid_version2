<div x-show="$store.pedomanAdminModal.open" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 z-[110] bg-slate-900/95 backdrop-blur-sm flex items-center justify-center p-2 md:p-6" 
     style="display: none;">
    
    <div class="bg-white w-full max-w-7xl max-h-[95vh] rounded-3xl shadow-2xl flex flex-col overflow-hidden border border-slate-200 font-sans">
        
        <!-- Header -->
        <div class="bg-indigo-900 px-6 py-4 flex-shrink-0 border-b border-indigo-950">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-indigo-500 p-2 rounded-xl text-white shadow-lg">
                        <i class="fas fa-chalkboard-teacher text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white leading-tight uppercase tracking-tight">Pedoman Operasional Admin</h3>
                        <p class="text-indigo-200 text-xs mt-1 font-medium">Panduan Pengelolaan Portal PPID v2</p>
                    </div>
                </div>
                <button @click="$store.pedomanAdminModal.close()" 
                        class="bg-white/10 hover:bg-white/20 text-white transition-all p-2 rounded-lg">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Tab Navigation (STICKY) -->
        <div class="bg-slate-50 border-b border-slate-200 flex overflow-x-auto no-scrollbar scroll-smooth px-6 sticky top-0 z-50 shadow-sm">
            <template x-for="(tab, index) in $store.pedomanAdminModal.tabs" :key="index">
                <button @click="$store.pedomanAdminModal.activeTab = index"
                        :class="$store.pedomanAdminModal.activeTab === index ? 'border-indigo-600 text-indigo-700 bg-white shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700'"
                        class="px-4 py-3 border-b-4 font-bold text-xs whitespace-nowrap transition-all flex items-center gap-2 min-h-[48px]">
                    <i :class="tab.icon"></i>
                    <span x-text="tab.title"></span>
                </button>
            </template>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-4 md:p-8 bg-white text-slate-700">
            
            <!-- Tab 0: Menu Profil -->
            <div x-show="$store.pedomanAdminModal.activeTab === 0" x-transition class="space-y-8">
                <h4 class="text-lg font-bold border-l-4 border-indigo-600 pl-3">Pengelolaan Profil OPD & Pimpinan</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                        <h5 class="font-bold text-indigo-700 mb-3 text-sm flex items-center gap-2">
                            <span class="bg-indigo-100 w-5 h-5 rounded-full flex items-center justify-center text-[10px]">1</span>
                            Struktur & Website OPD
                        </h5>
                        <ul class="space-y-3 text-xs mb-4 leading-relaxed">
                            <li class="flex gap-2">
                                <i class="fas fa-mouse-pointer text-indigo-500 mt-0.5"></i>
                                <span>Klik menu <strong>Profil</strong> > <strong>Tentang OPD</strong></span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-search text-indigo-500 mt-0.5"></i>
                                <span>Cari OPD Anda, klik tombol <span class="bg-white text-blue-600 border border-blue-200 px-1.5 py-0.5 rounded text-[9px] font-bold">KELOLA PROFIL UNIT</span></span>
                            </li>
                        </ul>
                        <div class="space-y-3 border-t pt-3">
                            <div class="flex gap-3 bg-white p-3 rounded-lg border border-slate-100 shadow-sm text-[10px]">
                                <div class="flex-1 text-slate-500">A. Upload Gambar Struktur (JPG/PNG).</div>
                                <div class="w-20 bg-slate-50 border border-dashed border-slate-300 rounded flex items-center justify-center relative">
                                    <i class="fas fa-sitemap text-slate-300"></i>
                                    <div class="absolute -left-2 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[3px] border-y-transparent border-r-[5px] border-r-indigo-500"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                        <h5 class="font-bold text-indigo-700 mb-3 text-sm flex items-center gap-2">
                            <span class="bg-indigo-100 w-5 h-5 rounded-full flex items-center justify-center text-[10px]">2</span>
                            Data Pimpinan
                        </h5>
                        <ul class="space-y-3 text-xs mb-4 leading-relaxed">
                            <li class="flex gap-2">
                                <i class="fas fa-edit text-indigo-500 mt-0.5"></i>
                                <span>Klik tombol <span class="bg-amber-500 text-white px-1.5 py-0.5 rounded text-[9px] font-bold">KELOLA PIMPINAN</span>.</span>
                            </li>
                            <li class="bg-amber-100/50 p-2 rounded-lg border border-amber-200 text-[10px] font-bold text-amber-800">
                                <span>Cukup isi Tab Identitas (Nama & Status).</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tab 1: Jenis Informasi -->
            <div x-show="$store.pedomanAdminModal.activeTab === 1" x-transition class="space-y-10">
                <h4 class="text-lg font-bold border-l-4 border-blue-600 pl-3">Klasifikasi & Panduan Informasi</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-blue-50 p-5 rounded-2xl border border-blue-100">
                        <h6 class="font-bold text-blue-900 mb-2 text-sm flex items-center gap-2">
                            <i class="fas fa-history"></i> Informasi Berkala
                        </h6>
                        <p class="text-xs text-slate-600 leading-relaxed italic">Wajib rutin. Sifatnya <strong>Ganti Data</strong>. Data lama wajib masuk <strong>ARSIP</strong> jika ada data baru.</p>
                    </div>
                    <div class="bg-emerald-50 p-5 rounded-2xl border border-emerald-100">
                        <h6 class="font-bold text-emerald-900 mb-2 text-sm flex items-center gap-2">
                            <i class="fas fa-layer-group"></i> Informasi Setiap Saat
                        </h6>
                        <p class="text-xs text-slate-600 leading-relaxed italic">Katalog sejarah. Sifatnya <strong>Menumpuk</strong>. Semua tahun tetap Berlaku.</p>
                    </div>
                </div>

                <div class="space-y-8">
                    <h5 class="text-sm font-bold text-slate-800 uppercase tracking-widest border-b pb-2">Langkah Pengisian Form (A - H)</h5>
                    
                    <div class="space-y-8">
                        <div class="flex flex-col md:flex-row gap-6 items-start">
                            <div class="flex-1">
                                <div class="flex gap-3 mb-2">
                                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-sm">A</span>
                                    <h6 class="font-bold text-slate-800 mt-1 text-sm uppercase">Judul Informasi</h6>
                                </div>
                                <p class="text-xs text-slate-500 ml-11">Format: Nama Dokumen + Unit + Tahun.</p>
                            </div>
                            <div class="w-full md:w-60 bg-white p-3 rounded-xl border border-indigo-100 shadow-sm relative">
                                <div class="h-8 w-full border-2 border-indigo-200 rounded-lg bg-indigo-50/30 flex items-center px-3 text-[9px] text-indigo-400 italic">Renja Dinas...</div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row gap-6 items-start">
                            <div class="flex-1">
                                <div class="flex gap-3 mb-2">
                                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-sm">B</span>
                                    <h6 class="font-bold text-slate-800 mt-1 text-sm uppercase">Deskripsi & Pelengkap</h6>
                                </div>
                                <div class="ml-11 bg-amber-50 p-3 rounded-xl border border-amber-200 text-[10px] text-amber-800 font-medium italic">
                                    "Lampiran banyak? Gabungkan dalam 1 PDF atau gunakan Link Folder Google Drive!"
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row gap-6 items-start">
                            <div class="flex-1 text-blue-700">
                                <div class="flex gap-3 mb-2 text-slate-800">
                                    <span class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">H</span>
                                    <h6 class="font-bold mt-1 text-sm uppercase italic">Check & Simpan</h6>
                                </div>
                                <p class="text-xs ml-11 uppercase font-bold">"Wajib klik CHECK INFORMASI untuk mematikan data tahun lama!"</p>
                            </div>
                            <div class="w-full md:w-60 flex justify-center relative">
                                <div class="bg-yellow-500 text-white px-5 py-2.5 rounded-xl text-[10px] font-bold shadow-lg animate-bounce uppercase">CHECK INFORMASI</div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-yellow-500"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-indigo-900 text-white p-8 rounded-[2rem] shadow-xl relative overflow-hidden">
                    <h5 class="text-lg font-bold mb-6 flex items-center gap-3">
                        <i class="fas fa-magic text-indigo-300"></i> Bingung Klasifikasi? Tanya AI!
                    </h5>
                    <div class="space-y-4 text-xs font-medium">
                        <div class="flex gap-3 items-center bg-white/5 p-3 rounded-lg border border-white/10">
                            <span class="bg-indigo-500 w-6 h-6 rounded-full flex items-center justify-center text-[10px]">1</span>
                            <span>Klik <strong>TANYA PEDOMAN</strong> di pojok kanan form.</span>
                        </div>
                        <div class="flex gap-3 items-center bg-white/5 p-3 rounded-lg border border-white/10">
                            <span class="bg-indigo-500 w-6 h-6 rounded-full flex items-center justify-center text-[10px]">2</span>
                            <span>Ketik Nama Dokumen & Klik Tombol Hijau <strong>TANYA AI</strong>.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Transparansi -->
            <div x-show="$store.pedomanAdminModal.activeTab === 2" x-transition class="space-y-8">
                <h4 class="text-lg font-bold border-l-4 border-green-600 pl-3">Layanan Permohonan Informasi</h4>
                <div class="bg-white border-2 border-slate-100 rounded-2xl p-6 shadow-md">
                    <p class="text-xs font-bold text-blue-800 mb-3 uppercase underline decoration-2">Tugas Admin Merespon:</p>
                    <ol class="text-xs text-slate-600 space-y-3 list-decimal list-inside font-medium leading-relaxed">
                        <li>Cari status <span class="text-orange-600 font-bold">PENDING</span>.</li>
                        <li>Klik <span class="text-blue-600 font-bold">"Proses / Balas"</span>.</li>
                        <li>Tulis jawaban & lampirkan dokumen.</li>
                    </ol>
                </div>
            </div>

            <!-- Tab 3: PBJ -->
            <div x-show="$store.pedomanAdminModal.activeTab === 3" x-transition class="space-y-8">
                <h4 class="text-lg font-bold border-l-4 border-orange-600 pl-3">Panduan Khusus PBJ</h4>
                <div class="bg-orange-50 p-6 rounded-2xl border border-orange-200">
                    <p class="text-xs text-orange-900 leading-relaxed font-bold uppercase underline italic">"Data Paket Tender Wajib Diupdate Rutin Sesuai Progres Fisik!"</p>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="bg-slate-50 p-4 md:p-6 border-t border-slate-200 flex flex-col md:flex-row gap-4 items-center justify-between flex-shrink-0 z-50">
            <div class="flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name=Admin+PPID&background=4f46e5&color=fff" class="w-8 h-8 rounded-full border border-white shadow">
                <div class="text-[10px] text-slate-400 font-medium uppercase tracking-widest leading-tight">Dinas Kominfo Sinjai</div>
            </div>
            
            <div class="flex gap-3 w-full md:w-auto">
                <button @click="$store.pedomanAdminModal.prevTab()" x-show="$store.pedomanAdminModal.activeTab > 0" class="px-4 py-2 bg-white text-slate-600 font-bold rounded-lg border border-slate-200 text-[11px] shadow-sm">SEBELUMNYA</button>
                <button @click="$store.pedomanAdminModal.nextTab()" class="flex-1 md:flex-none px-6 py-2 bg-indigo-700 text-white font-bold rounded-lg shadow-md text-[11px]">
                    <span x-text="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'TUTUP' : 'LANJUT'"></span>
                </button>
            </div>
        </div>
    </div>
</div>

@if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin'))
    <div class="fixed z-[105] bottom-6 right-6" x-data x-cloak>
        <button @click="$store.pedomanAdminModal.show()" 
                class="w-14 h-14 bg-indigo-700 hover:bg-indigo-800 text-white rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 group relative border-2 border-white">
            <i class="fas fa-chalkboard-teacher text-xl"></i>
            <div class="absolute bottom-full right-0 mb-4 px-3 py-1.5 bg-indigo-950 text-white text-[9px] font-bold rounded-lg opacity-0 group-hover:opacity-100 transition-all transform translate-y-2 group-hover:translate-y-0 whitespace-nowrap pointer-events-none shadow-xl border border-indigo-800 uppercase tracking-widest">
                <i class="fas fa-graduation-cap text-indigo-400 mr-2"></i> Panduan Admin
            </div>
        </button>
    </div>
@endif

<script>
    document.addEventListener('alpine:init', () => {
        const store = Alpine.store('pedomanAdminModal');
        if (store) {
            store.tabs = [
                { title: 'MENU PROFIL', icon: 'fas fa-user-shield' },
                { title: 'JENIS INFORMASI', icon: 'fas fa-folder-open' },
                { title: 'TRANSPARANSI', icon: 'fas fa-chart-line' },
                { title: 'PBJ', icon: 'fas fa-shopping-cart' }
            ];
        }
    })
</script>
