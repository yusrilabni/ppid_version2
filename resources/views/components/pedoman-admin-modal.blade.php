<div x-show="$store.pedomanAdminModal.open" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 z-[110] bg-slate-900/90 backdrop-blur-sm flex items-center justify-center p-2 md:p-6" 
     style="display: none;">
    
    <div class="bg-white w-full max-w-7xl max-h-[95vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden border border-slate-200 font-sans">
        
        <!-- Header -->
        <div class="bg-indigo-900 px-6 py-4 flex-shrink-0 border-b border-indigo-950 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-500 p-2 rounded-lg shadow-lg">
                        <i class="fas fa-chalkboard-teacher text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold uppercase tracking-tight">Pedoman Operasional Admin</h3>
                        <p class="text-indigo-200 text-[10px] font-medium uppercase tracking-widest">Portal PPID v2.0</p>
                    </div>
                </div>
                <button @click="$store.pedomanAdminModal.close()" 
                        class="bg-white/10 hover:bg-white/20 text-white transition-all p-2 rounded-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Tab Navigation (STICKY) -->
        <div class="bg-slate-50 border-b border-slate-200 flex overflow-x-auto no-scrollbar sticky top-0 z-50 shadow-sm">
            <template x-for="(tab, index) in $store.pedomanAdminModal.tabs" :key="index">
                <button @click="$store.pedomanAdminModal.activeTab = index"
                        :class="$store.pedomanAdminModal.activeTab === index ? 'border-indigo-600 text-indigo-700 bg-white shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700'"
                        class="px-6 py-4 border-b-4 font-bold text-xs whitespace-nowrap transition-all flex items-center gap-2 min-h-[56px] uppercase tracking-tighter">
                    <i :class="tab.icon"></i>
                    <span x-text="tab.title"></span>
                </button>
            </template>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-4 md:p-8 bg-white text-slate-700">
            
            <!-- Tab 0: MENU PROFIL -->
            <div x-show="$store.pedomanAdminModal.activeTab === 0" x-transition class="space-y-10">
                <h4 class="text-lg font-bold border-l-4 border-indigo-600 pl-3 uppercase">Pengelolaan Profil OPD & Pimpinan</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Seksi OPD -->
                    <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <h5 class="font-bold text-indigo-700 mb-4 flex items-center gap-2 uppercase text-xs">
                            <span class="bg-indigo-100 w-6 h-6 rounded-full flex items-center justify-center font-bold">1</span>
                            Struktur & Website OPD
                        </h5>
                        <ul class="space-y-3 text-xs mb-6 leading-relaxed font-medium">
                            <li class="flex gap-2">
                                <i class="fas fa-mouse-pointer text-indigo-500 mt-0.5"></i>
                                <span>Menu <strong>Profil</strong> > <strong>Tentang OPD</strong></span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-search text-indigo-500 mt-0.5"></i>
                                <span>Cari unit, klik tombol <span class="bg-white text-blue-600 border border-blue-200 px-1.5 py-0.5 rounded text-[9px] font-bold uppercase shadow-sm">KELOLA PROFIL UNIT</span></span>
                            </li>
                            <li class="flex gap-2 border-t pt-2">
                                <i class="fas fa-upload text-indigo-500 mt-0.5"></i>
                                <span>Upload Gambar Struktur (JPG/PNG/WEBP) & Masukkan URL Website Resmi.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Seksi Pimpinan -->
                    <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <h5 class="font-bold text-indigo-700 mb-4 flex items-center gap-2 uppercase text-xs">
                            <span class="bg-indigo-100 w-6 h-6 rounded-full flex items-center justify-center font-bold">2</span>
                            Data Pimpinan & Pejabat
                        </h5>
                        <ul class="space-y-3 text-xs mb-6 leading-relaxed font-medium">
                            <li class="flex gap-2 text-amber-700 font-bold bg-amber-100/50 p-2 rounded-lg">
                                <i class="fas fa-exclamation-circle mt-0.5"></i>
                                <span>PENTING: Wajib isi Tab Identitas (Nama + Gelar & Status Aktif).</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-edit text-indigo-500 mt-0.5"></i>
                                <span>Klik tombol <span class="bg-amber-500 text-white px-1.5 py-0.5 rounded text-[9px] font-bold uppercase shadow-sm">KELOLA PIMPINAN</span> pada kartu profil.</span>
                            </li>
                            <li class="flex gap-2 border-t pt-2">
                                <i class="fas fa-save text-indigo-500 mt-0.5"></i>
                                <span>Setelah mengisi, pastikan klik tombol biru <span class="text-blue-600 font-bold uppercase">Simpan Profil</span>.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tab 1: JENIS INFORMASI (FULL RESTORED) -->
            <div x-show="$store.pedomanAdminModal.activeTab === 1" x-transition class="space-y-12">
                <h4 class="text-lg font-bold border-l-4 border-blue-600 pl-3 uppercase">Master Class: Klasifikasi Informasi</h4>

                <!-- LOGIKA MENDALAM -->
                <div class="space-y-6">
                    <h5 class="text-base font-bold flex items-center gap-2 border-b pb-2 text-slate-800">
                        <i class="fas fa-balance-scale text-blue-600"></i> Mengapa Harus Diklasifikasikan?
                    </h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs leading-relaxed">
                        <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100 relative">
                            <h6 class="font-bold text-blue-900 mb-2 uppercase underline underline-offset-4 decoration-2">1. Informasi Berkala</h6>
                            <p class="mb-3">Digunakan untuk dokumen <strong>Kewajiban Rutin</strong> (Renstra, LRA, DPA). Sifatnya <strong>Ganti Data (Update)</strong>. Data lama wajib masuk <strong>ARSIP</strong> jika ada data tahun baru.</p>
                            <div class="bg-white/60 p-3 rounded-xl border border-blue-200 italic font-bold">
                                Contoh: DPA 2024 menggantikan DPA 2023. Gunakan tombol "Check Informasi".
                            </div>
                        </div>
                        <div class="bg-emerald-50 p-6 rounded-2xl border border-emerald-100 relative">
                            <h6 class="font-bold text-emerald-900 mb-2 uppercase underline underline-offset-4 decoration-2">2. Informasi Setiap Saat</h6>
                            <p class="mb-3">Digunakan untuk <strong>Catatan Histori & Kebijakan</strong> (SK, MoU). Sifatnya <strong>Menumpuk (Akumulatif)</strong>. Semua tahun tetap penting ditampilkan sebagai katalog sejarah.</p>
                            <div class="bg-white/80 p-3 rounded-xl border border-emerald-200 italic font-bold">
                                Contoh: SK Panitia 2023 tetap tampil meskipun sudah ada SK 2024.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TUTORIAL FORM A - H -->
                <div class="space-y-8">
                    <h5 class="text-base font-bold flex items-center gap-2 border-b pb-2 uppercase text-slate-800">
                        <i class="fas fa-edit text-indigo-600"></i> Detail Pengisian Form (A - H)
                    </h5>
                    <div class="bg-slate-50 rounded-3xl border-2 border-slate-200 p-6 space-y-8">
                        <!-- A: JUDUL -->
                        <div class="flex flex-col md:flex-row gap-6 items-start">
                            <div class="flex-1 text-xs">
                                <div class="flex gap-3 mb-2">
                                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold shadow-md">A</span>
                                    <h6 class="font-bold uppercase mt-1">Judul Informasi</h6>
                                </div>
                                <p class="ml-11">Wajib format Baku: <strong>Nama Dokumen + Unit + Tahun</strong>.</p>
                            </div>
                            <div class="md:w-60 bg-white p-3 rounded-xl border border-indigo-100 shadow-sm relative">
                                <div class="h-8 w-full border-2 border-indigo-200 rounded-lg bg-indigo-50/50 flex items-center px-3 text-[9px] text-indigo-400 italic">Renja Dinas... 2024...</div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500 shadow-lg"></div>
                            </div>
                        </div>

                        <!-- B: DESKRIPSI -->
                        <div class="flex flex-col md:flex-row gap-6 items-start border-t pt-6">
                            <div class="flex-1 text-xs font-medium space-y-4">
                                <div class="flex gap-3 mb-2">
                                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold shadow-md">B</span>
                                    <h6 class="font-bold uppercase mt-1">Deskripsi & Pelengkap</h6>
                                </div>
                                <div class="ml-11 bg-amber-50 p-4 rounded-xl border border-amber-200 text-amber-800 italic text-[11px] font-bold">
                                    "Jika lampiran banyak (DPA + Lampiran A-Z), wajib GABUNGKAN DALAM 1 PDF. Jika > 2MB, pilih opsi Link File Google Drive!"
                                </div>
                            </div>
                        </div>

                        <!-- H: FINALISASI -->
                        <div class="flex flex-col md:flex-row gap-6 items-start border-t pt-6">
                            <div class="flex-1 text-xs">
                                <div class="flex gap-3 mb-2">
                                    <span class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold shadow-md animate-bounce text-sm">H</span>
                                    <h6 class="font-bold uppercase mt-1 text-blue-900 underline">Langkah Final: Check & Simpan</h6>
                                </div>
                                <p class="ml-11 font-bold text-blue-700 italic">"Khusus BERKALA, wajib klik CHECK INFORMASI untuk mematikan data tahun lama!"</p>
                            </div>
                            <div class="md:w-60 flex justify-center relative">
                                <div class="bg-yellow-500 text-white px-5 py-2.5 rounded-xl text-[10px] font-bold shadow-lg animate-bounce border-2 border-white uppercase italic">CHECK INFORMASI</div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-yellow-500 shadow-lg"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BANTUAN AI -->
                <div class="bg-indigo-900 text-white p-8 rounded-[2rem] shadow-xl relative overflow-hidden italic font-bold">
                    <div class="absolute -right-6 -bottom-6 opacity-10"><i class="fas fa-microchip text-9xl"></i></div>
                    <h5 class="text-lg font-bold mb-6 flex items-center gap-3 uppercase underline underline-offset-4 decoration-indigo-700">
                        <i class="fas fa-magic text-indigo-300"></i> Bingung Klasifikasi? Tanya AI!
                    </h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center text-xs">
                        <div class="space-y-4">
                            <p>1. Klik <strong>TANYA PEDOMAN</strong> di pojok kanan form.</p>
                            <p>2. Ketik Nama Dokumen Bapak & Klik Tombol Hijau <strong>TANYA AI</strong>.</p>
                        </div>
                        <div class="bg-white/10 p-5 rounded-2xl border border-white/20 text-center">
                            <div class="bg-green-600 text-white px-6 py-3 rounded-xl text-[10px] font-bold shadow-lg animate-pulse uppercase tracking-widest border-2 border-white">TANYA AI</div>
                        </div>
                    </div>
                </div>

                <!-- REKAPITULASI DOKUMEN WAJIB -->
                <div class="bg-white border-4 border-slate-100 rounded-[3rem] p-10 shadow-lg">
                    <h5 class="text-sm font-bold text-slate-800 mb-8 text-center uppercase tracking-widest border-b pb-4">Standar Dokumen Wajib Per Unit</h5>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-[11px] font-bold uppercase tracking-tighter text-slate-500">
                        <div class="space-y-3">
                            <p class="text-blue-600 underline underline-offset-4 italic border-b pb-1 flex items-center gap-2"><i class="fas fa-building"></i> Dinas / Badan / RSUD</p>
                            <ul class="space-y-1 list-disc list-inside leading-relaxed">
                                <li>Renstra, Renja, DPA, LRA.</li>
                                <li>Tarif Layanan (RSUD).</li>
                                <li>LHKPN Pejabat Utama.</li>
                            </ul>
                        </div>
                        <div class="space-y-3">
                            <p class="text-indigo-600 underline underline-offset-4 italic border-b pb-1 flex items-center gap-2"><i class="fas fa-search-dollar"></i> Inspektorat</p>
                            <ul class="space-y-1 list-disc list-inside leading-relaxed text-justify">
                                <li>PKPT (Audit Tahunan).</li>
                                <li>Ringkasan LHP Publik.</li>
                                <li>Laporan Akuntabilitas.</li>
                            </ul>
                        </div>
                        <div class="space-y-3">
                            <p class="text-green-600 underline underline-offset-4 italic border-b pb-1 flex items-center gap-2"><i class="fas fa-map-marked-alt"></i> Kecamatan / Desa / Kel</p>
                            <ul class="space-y-1 list-disc list-inside leading-relaxed">
                                <li>APBDes / RKPDes Desa.</li>
                                <li>LPPD & Monografi.</li>
                                <li>Laporan PATEN (Kec).</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: TRANSPARANSI -->
            <div x-show="$store.pedomanAdminModal.activeTab === 2" x-transition class="space-y-8 uppercase font-bold italic text-slate-800 tracking-tighter">
                <h4 class="text-xl font-bold border-l-4 border-green-600 pl-4 underline underline-offset-4">Layanan Permohonan Informasi</h4>
                <div class="bg-white border-2 border-slate-100 rounded-3xl p-8 shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-2 h-full bg-blue-600"></div>
                    <h5 class="text-base font-bold mb-4 flex items-center gap-3 italic underline decoration-blue-500 decoration-4">Tugas Admin Merespon:</h5>
                    <ol class="text-xs text-slate-600 space-y-4 list-decimal list-inside leading-loose">
                        <li>Cari status <span class="text-orange-600 underline">PENDING</span>.</li>
                        <li>Klik tombol biru <span class="text-blue-600 font-bold uppercase tracking-widest">"PROSES / BALAS"</span>.</li>
                        <li>Tulis jawaban & lampirkan dokumen (File/URL).</li>
                    </ol>
                </div>
            </div>

            <!-- Tab 3: PBJ -->
            <div x-show="$store.pedomanAdminModal.activeTab === 3" x-transition class="space-y-10 font-bold uppercase italic tracking-tighter text-slate-800">
                <h4 class="text-xl font-bold border-l-4 border-orange-600 pl-4 underline underline-offset-8">Panduan Khusus PBJ</h4>
                <div class="bg-orange-50 p-8 rounded-[2rem] border-4 border-orange-100 mb-8 flex gap-6 items-start shadow-lg">
                    <div class="bg-orange-500 text-white p-6 rounded-2xl shadow-xl animate-bounce border-2 border-white"><i class="fas fa-exclamation-triangle text-2xl"></i></div>
                    <p class="text-sm text-orange-900 leading-relaxed font-bold underline decoration-4 decoration-orange-100 italic pt-2 uppercase">"DATA PAKET TENDER WAJIB DIUPDATE RUTIN SESUAI PROGRES FISIK!"</p>
                </div>
                <div class="p-8 bg-white border-4 border-slate-100 rounded-3xl shadow-xl">
                    <ul class="text-sm space-y-6">
                        <li class="flex gap-4 items-center bg-slate-50 p-4 rounded-xl">
                            <span class="text-orange-500 font-bold text-3xl">01.</span>
                            <span>Menu <strong>PBJ</strong> > <strong>Input Paket</strong>. Isi Pagu & Pemenang.</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="bg-slate-50 p-6 border-t border-slate-200 flex flex-col md:flex-row gap-6 items-center justify-between flex-shrink-0 shadow-inner z-50">
            <div class="flex items-center gap-4 text-slate-400 font-bold uppercase tracking-widest text-[10px] italic">
                <div class="flex -space-x-4">
                    <img src="https://ui-avatars.com/api/?name=Admin+PPID&background=4f46e5&color=fff" class="w-12 h-12 rounded-full border-2 border-white shadow-lg">
                    <img src="https://ui-avatars.com/api/?name=Super+Admin&background=1e1b4b&color=fff" class="w-12 h-12 rounded-full border-2 border-white shadow-lg">
                </div>
                <div>Portal PPID v2.0 <br><span class="text-[8px] text-indigo-500 underline decoration-indigo-100 italic">Dinas Kominfo Sinjai</span></div>
            </div>
            
            <div class="flex gap-4 w-full md:w-auto font-bold uppercase italic tracking-tighter">
                <button @click="$store.pedomanAdminModal.prevTab()" x-show="$store.pedomanAdminModal.activeTab > 0" class="px-8 py-3 bg-white text-slate-600 rounded-xl border border-slate-200 text-xs hover:bg-slate-50 transition-all flex items-center gap-3 shadow-md active:scale-95">
                    <i class="fas fa-arrow-left text-[10px]"></i> SEBELUMNYA
                </button>

                <button @click="$store.pedomanAdminModal.nextTab()" class="flex-1 md:flex-none px-16 py-3 bg-indigo-700 text-white rounded-xl shadow-xl text-xs transition-all hover:bg-indigo-800 hover:scale-[1.05] active:scale-95 flex items-center justify-center gap-4 border-b-4 border-indigo-900">
                    <span x-text="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'SAYA MENGERTI, TUTUP' : 'LANJUT KE BERIKUTNYA'"></span>
                    <i :class="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'fas fa-check-double text-[10px]' : 'fas fa-arrow-right text-[10px]'"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin'))
    <div class="fixed z-[105] bottom-6 right-6" x-data x-cloak>
        <button @click="$store.pedomanAdminModal.show()" 
                class="w-14 h-14 bg-indigo-700 hover:bg-indigo-800 text-white rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-90 group relative border-2 border-white p-4 overflow-hidden shadow-indigo-600/30">
            <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/5 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <i class="fas fa-chalkboard-teacher text-2xl group-hover:rotate-6 transition-transform"></i>
            <div class="absolute bottom-full right-0 mb-5 px-4 py-2 bg-indigo-950 text-white text-[10px] font-bold rounded-xl opacity-0 group-hover:opacity-100 transition-all transform translate-y-4 group-hover:translate-y-0 whitespace-nowrap pointer-events-none shadow-2xl border border-indigo-800 uppercase tracking-widest flex items-center gap-2 italic">
                <i class="fas fa-graduation-cap text-indigo-400"></i> Panduan Admin
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
