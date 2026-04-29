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
        <div class="bg-indigo-900 px-6 py-6 flex-shrink-0 border-b border-indigo-950">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-5">
                    <div class="bg-indigo-50 p-3 rounded-2xl text-white shadow-lg shadow-indigo-500/30">
                        <i class="fas fa-chalkboard-teacher text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl md:text-3xl font-black text-white leading-tight uppercase tracking-tight">Pedoman Operasional Admin</h3>
                        <p class="text-indigo-200 text-sm mt-1 font-medium">Panduan Langkah-demi-Langkah Pengelolaan Portal PPID v2</p>
                    </div>
                </div>
                <button @click="$store.pedomanAdminModal.close()" 
                        class="bg-white/10 hover:bg-white/20 text-white transition-all p-3 rounded-xl">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Tab Navigation (STICKY) -->
        <div class="bg-slate-100 border-b border-slate-200 flex overflow-x-auto no-scrollbar scroll-smooth px-6 sticky top-0 z-30 shadow-sm">
            <template x-for="(tab, index) in $store.pedomanAdminModal.tabs" :key="index">
                <button @click="$store.pedomanAdminModal.activeTab = index"
                        :class="$store.pedomanAdminModal.activeTab === index ? 'border-indigo-600 text-indigo-700 bg-white shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700'"
                        class="px-6 py-4 border-b-4 font-bold text-sm whitespace-nowrap transition-all flex items-center gap-2 min-h-[60px]">
                    <i :class="tab.icon"></i>
                    <span x-text="tab.title"></span>
                </button>
            </template>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-6 md:p-10 bg-white">
            
            <!-- Tab 0: Menu Profil -->
            <div x-show="$store.pedomanAdminModal.activeTab === 0" x-transition class="space-y-12">
                <div class="flex items-center gap-4 border-l-4 border-indigo-600 pl-4 mb-6">
                    <h4 class="text-2xl font-bold text-slate-800">Pengelolaan Profil OPD & Pimpinan</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-6">
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200">
                            <h5 class="font-bold text-indigo-700 mb-4 flex items-center gap-2">
                                <span class="bg-indigo-100 w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span>
                                Mengelola Struktur & Website OPD
                            </h5>
                            <ul class="space-y-4 text-sm text-slate-600 mb-6">
                                <li class="flex gap-3">
                                    <i class="fas fa-mouse-pointer text-indigo-500 mt-1"></i>
                                    <span>Klik menu <strong>Profil</strong> > <strong>Tentang OPD</strong></span>
                                </li>
                                <li class="flex gap-3">
                                    <i class="fas fa-search text-indigo-500 mt-1"></i>
                                    <span>Cari OPD Anda, lalu klik tombol <span class="bg-white text-blue-600 border border-blue-200 px-2 py-0.5 rounded shadow-sm text-[10px] font-bold inline-flex items-center gap-1 uppercase tracking-tighter"><i class="fas fa-edit text-[8px]"></i> KELOLA PROFIL UNIT</span></span>
                                </li>
                                <li class="flex gap-3">
                                    <i class="fas fa-upload text-indigo-500 mt-1"></i>
                                    <span>Lengkapi form, lalu klik tombol <span class="bg-blue-600 text-white px-2 py-0.5 rounded shadow-sm text-[10px] font-bold inline-flex items-center gap-1 uppercase"><i class="fas fa-save text-[8px]"></i> SIMPAN PERUBAHAN</span>.</span>
                                </li>
                            </ul>

                            <div class="space-y-4">
                                <!-- OPD Visual A -->
                                <div class="flex flex-col md:flex-row gap-4 bg-white p-4 rounded-xl border border-slate-100">
                                    <div class="flex-1 text-[11px] text-slate-500">Upload Gambar Struktur (JPG/PNG).</div>
                                    <div class="md:w-32 bg-slate-100 p-2 rounded-lg border border-dashed border-slate-300 flex items-center justify-center relative">
                                        <i class="fas fa-sitemap text-slate-300 text-xs"></i>
                                        <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[4px] border-y-transparent border-r-[6px] border-r-indigo-500"></div>
                                    </div>
                                </div>
                                <!-- OPD Visual B -->
                                <div class="flex flex-col md:flex-row gap-4 bg-white p-4 rounded-xl border border-slate-100">
                                    <div class="flex-1 text-[11px] text-slate-500">Input URL Website Resmi.</div>
                                    <div class="md:w-32 bg-white border border-slate-200 rounded p-1 flex items-center relative">
                                        <span class="text-[6px] text-indigo-400 font-bold px-1">https://...</span>
                                        <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[4px] border-y-transparent border-r-[6px] border-r-indigo-500"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200">
                            <h5 class="font-bold text-indigo-700 mb-4 flex items-center gap-2">
                                <span class="bg-indigo-100 w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span>
                                Mengelola Data Pimpinan
                            </h5>
                            <ul class="space-y-4 text-sm text-slate-600">
                                <li class="flex gap-3">
                                    <i class="fas fa-mouse-pointer text-indigo-500 mt-1"></i>
                                    <span>Klik menu <strong>Profil</strong> > <strong>Pejabat Daerah</strong> (OPD) atau <strong>Unit Lokal</strong> (Desa/Kel)</span>
                                </li>
                                <li class="flex gap-3">
                                    <i class="fas fa-edit text-indigo-500 mt-1"></i>
                                    <span>Cari nama pimpinan, klik tombol <span class="bg-amber-500 text-white px-2 py-0.5 rounded shadow-sm text-[10px] font-bold inline-flex items-center gap-1 uppercase tracking-tighter"><i class="fas fa-pencil-alt text-[8px]"></i> KELOLA PIMPINAN</span>.</span>
                                </li>
                                <li class="flex gap-3 text-amber-700 font-bold">
                                    <i class="fas fa-info-circle mt-1"></i>
                                    <span>Cukup isi Tab Identitas (Wajib *). Tab lain opsional.</span>
                                </li>
                            </ul>

                            <div class="mt-6 space-y-4">
                                <!-- Pimpinan Visual -->
                                <div class="bg-white p-4 rounded-xl border border-slate-200 space-y-3">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-indigo-600 text-white w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold">A</div>
                                        <p class="text-[10px] font-bold">Nama Lengkap + Gelar</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="bg-indigo-600 text-white w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold">B</div>
                                        <p class="text-[10px] font-bold">Status: <span class="text-green-600 uppercase">Aktif</span></p>
                                    </div>
                                    <div class="flex justify-center mt-2">
                                        <div class="bg-blue-600 text-white px-4 py-1.5 rounded-lg text-[9px] font-black animate-bounce">SIMPAN PROFIL</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 1: Jenis Informasi -->
            <div x-show="$store.pedomanAdminModal.activeTab === 1" x-transition class="space-y-12 text-slate-800">
                <div class="flex items-center gap-4 border-l-4 border-blue-600 pl-4 mb-6">
                    <h4 class="text-2xl font-bold">Panduan Operasional & Manajemen Informasi</h4>
                </div>

                <!-- LANGKAH AWAL -->
                <div class="bg-blue-50 p-6 rounded-3xl border border-blue-100 flex flex-col md:flex-row gap-6 items-center">
                    <div class="flex-1">
                        <h5 class="font-black text-blue-900 uppercase tracking-tighter mb-2">Langkah Awal: Memulai</h5>
                        <p class="text-xs text-slate-600 leading-relaxed">Buka menu <strong>Informasi</strong> (Berkala/Setiap Saat), lalu klik tombol biru besar bertuliskan <span class="bg-blue-600 text-white px-2 py-0.5 rounded text-[10px] font-black tracking-widest">+ TAMBAH INFORMASI</span>.</p>
                    </div>
                </div>

                <!-- PANDUAN TEKNIS FORM (A - H) -->
                <div class="space-y-10">
                    <h5 class="font-black text-slate-800 border-b pb-4 flex items-center gap-3">
                        <i class="fas fa-edit text-indigo-600"></i> Tutorial Pengisian Formulir (Poin A - H)
                    </h5>

                    <div class="space-y-12">
                        <!-- A: JUDUL -->
                        <div class="flex flex-col md:flex-row gap-8 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-3">
                                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-sm">A</span>
                                    <h6 class="font-bold text-slate-800 mt-1">Judul Informasi</h6>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed ml-12">Tulis judul spesifik: **Nama Dokumen + Unit + Tahun**. <br>Contoh: <strong>"Renja Dinas Kesehatan Tahun 2024"</strong>.</p>
                            </div>
                            <div class="md:w-64 bg-slate-100 p-3 rounded-2xl border border-slate-200 relative">
                                <div class="h-8 w-full border border-indigo-300 rounded-lg bg-white flex items-center px-3 text-[8px] text-indigo-400 font-bold italic">Renja Dinas Kesehatan 2024...</div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                            </div>
                        </div>

                        <!-- B: DESKRIPSI & DOKUMEN PELENGKAP -->
                        <div class="flex flex-col md:flex-row gap-8 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-3">
                                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-sm">B</span>
                                    <h6 class="font-bold text-slate-800 mt-1">Deskripsi & Skenario Lampiran</h6>
                                </div>
                                <div class="ml-12 space-y-4">
                                    <p class="text-[11px] text-slate-600 leading-relaxed">Jelaskan ringkasan isi dokumen agar pemohon mudah memahami data.</p>
                                    <div class="bg-amber-50 p-4 rounded-2xl border border-amber-200">
                                        <p class="text-[10px] font-black text-amber-800 mb-2 uppercase tracking-widest underline italic">Skenario Dokumen Pelengkap:</p>
                                        <p class="text-[10px] text-slate-600 leading-relaxed">Jika laporan memiliki banyak lampiran (Misal: LRA + Lampiran A, B, C), sangat disarankan untuk **menggabungkannya dalam 1 file PDF** (Max 2MB). Jika ukuran sangat besar, gunakan fitur **Link File** yang memuat URL ke satu folder penuh dokumen tersebut.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="md:w-64 bg-slate-100 p-3 rounded-2xl border border-slate-200 relative">
                                <div class="h-16 w-full border border-slate-300 rounded-lg bg-white flex flex-col p-2 gap-1 overflow-hidden">
                                    <div class="h-1 w-full bg-slate-100 rounded"></div>
                                    <div class="h-1 w-full bg-slate-100 rounded"></div>
                                    <div class="h-1 w-4/5 bg-slate-100 rounded"></div>
                                </div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                            </div>
                        </div>

                        <!-- C: KATEGORI & AI -->
                        <div class="flex flex-col md:flex-row gap-8 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-3">
                                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-sm">C</span>
                                    <h6 class="font-bold text-slate-800 mt-1">Kategori & Bantuan AI</h6>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed ml-12">Pilih kategori. Jika bingung identifikasi, klik tombol <span class="text-indigo-600 font-bold">TANYA PEDOMAN</span> lalu klik tombol hijau <span class="text-green-600 font-bold uppercase tracking-tighter">TANYA AI</span>.</p>
                            </div>
                            <div class="md:w-64 bg-slate-100 p-3 rounded-2xl border border-slate-200 relative space-y-2">
                                <div class="h-6 w-full bg-white border border-slate-300 rounded flex items-center px-2 justify-between text-[7px] font-bold">Informasi Berkala <i class="fas fa-chevron-down"></i></div>
                                <div class="flex justify-end"><div class="bg-green-600 text-white px-2 py-1 rounded text-[7px] font-black animate-pulse">TANYA AI</div></div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                            </div>
                        </div>

                        <!-- D: JENIS DOKUMEN -->
                        <div class="flex flex-col md:flex-row gap-8 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-3">
                                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-sm">D</span>
                                    <h6 class="font-bold text-slate-800 mt-1">Klasifikasi Jenis Dokumen</h6>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed ml-12">Pilih klasifikasi yang tepat (Keuangan, Regulasi, dll) agar pengelompokan di halaman publik akurat.</p>
                            </div>
                            <div class="md:w-64 bg-slate-100 p-3 rounded-2xl border border-slate-200 relative">
                                <div class="h-8 w-full border border-blue-200 rounded bg-blue-50 flex items-center px-2 justify-between text-[7px] text-blue-700 font-black italic">Informasi Keuangan <i class="fas fa-check-circle text-blue-500"></i></div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                            </div>
                        </div>

                        <!-- E: TAHUN -->
                        <div class="flex flex-col md:flex-row gap-8 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-3">
                                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-sm">E</span>
                                    <h6 class="font-bold text-slate-800 mt-1">Tahun Dokumen</h6>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed ml-12">Masukkan tanggal/tahun terbit dokumen dengan format <strong>YYYY-MM-DD</strong>.</p>
                            </div>
                            <div class="md:w-64 bg-slate-100 p-3 rounded-2xl border border-slate-200 relative">
                                <div class="h-8 w-full border border-slate-300 rounded bg-white flex items-center px-2 gap-2 text-[7px] text-slate-700"><i class="fas fa-calendar"></i> 2024-04-29</div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                            </div>
                        </div>

                        <!-- F: STATUS -->
                        <div class="flex flex-col md:flex-row gap-8 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-3">
                                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-sm">F</span>
                                    <h6 class="font-bold text-slate-800 mt-1">Status (Berlaku / Arsip)</h6>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed ml-12">Set ke **BERLAKU** untuk data aktif saat ini. Set ke **ARSIP** untuk dokumen lama.</p>
                            </div>
                            <div class="md:w-64 bg-slate-100 p-3 rounded-2xl border border-slate-200 relative flex gap-3 items-center">
                                <div class="flex items-center gap-1"><div class="w-3 h-3 rounded-full border-2 border-indigo-600 flex items-center justify-center"><div class="w-1.5 h-1.5 bg-indigo-600 rounded-full"></div></div><span class="text-[7px] font-bold text-indigo-700 uppercase">Berlaku</span></div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                            </div>
                        </div>

                        <!-- G: FILE / LINK -->
                        <div class="flex flex-col md:flex-row gap-8 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-3">
                                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-sm">G</span>
                                    <h6 class="font-bold text-slate-800 mt-1">File Dokumen (Max 2MB)</h6>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed ml-12">Gunakan **Upload File** (< 2MB) atau **Link File** (URL Google Drive/Cloud) untuk file besar.</p>
                            </div>
                            <div class="md:w-64 bg-white border-2 border-dashed border-indigo-100 p-4 rounded-2xl relative flex flex-col items-center gap-1">
                                <i class="fas fa-file-pdf text-indigo-300 text-xl"></i>
                                <span class="text-[7px] text-slate-400 font-bold uppercase">MAX 2MB</span>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                            </div>
                        </div>

                        <!-- H: FINALISASI (CHECK) -->
                        <div class="flex flex-col md:flex-row gap-8 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-3">
                                    <span class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-black text-sm">H</span>
                                    <h6 class="font-bold text-blue-900 mt-1 italic uppercase">Check & Simpan</h6>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed ml-12">Khusus **Informasi Berkala**, wajib klik tombol <span class="bg-yellow-500 text-white px-1.5 py-0.5 rounded font-bold text-[8px] uppercase tracking-tighter">CHECK INFORMASI</span> untuk mematikan data lama otomatis.</p>
                            </div>
                            <div class="md:w-64 bg-slate-100 p-3 rounded-2xl border border-slate-200 relative flex justify-center">
                                <div class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-[9px] font-black shadow shadow-yellow-200 animate-bounce uppercase">CHECK INFORMASI</div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-yellow-500"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t-4 border-dashed border-slate-100 py-6"></div>

                <!-- REFERENSI KLASIFIKASI & STUDI KASUS -->
                <div class="space-y-10">
                    <h5 class="text-xl font-black text-center uppercase tracking-widest text-slate-400">Referensi Klasifikasi & Studi Kasus</h5>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-slate-900 text-white p-8 rounded-[3rem] shadow-xl relative overflow-hidden md:col-span-2">
                            <h6 class="text-lg font-bold mb-6 border-b border-white/20 pb-4">Studi Kasus: Berkala vs Setiap Saat</h6>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <div>
                                    <p class="text-indigo-400 font-black text-[10px] uppercase tracking-widest mb-2">Berkala (Update Terkini)</p>
                                    <p class="text-[11px] text-slate-400 leading-relaxed italic">"DPA 2024 menggantikan DPA 2023. Saat upload data baru, gunakan **Check Informasi** untuk mengarsipkan data lama otomatis."</p>
                                </div>
                                <div>
                                    <p class="text-emerald-400 font-black text-[10px] uppercase tracking-widest mb-2">Setiap Saat (Database Katalog)</p>
                                    <p class="text-[11px] text-slate-400 leading-relaxed italic">"SK/MoU/Perjanjian 2023 tetap penting sebagai sejarah meskipun ada data 2024. Langsung **SIMPAN** tanpa arsip otomatis."</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-red-50 p-6 rounded-[2.5rem] border border-red-100">
                            <h6 class="font-black text-red-900 text-xs mb-2 uppercase tracking-widest">⚠️ Serta Merta (Darurat)</h6>
                            <p class="text-[10px] text-slate-600 leading-relaxed">Contoh: Peringatan Bencana, Wabah. Wajib upload segera!</p>
                        </div>
                        <div class="bg-slate-200 p-6 rounded-[2.5rem] border border-slate-300">
                            <h6 class="font-black text-slate-900 text-xs mb-2 uppercase tracking-widest">🔒 Dikecualikan (Rahasia)</h6>
                            <p class="text-[10px] text-slate-600 leading-relaxed">Contoh: Rekam Medis, Rahasia Bisnis. **TIDAK TAMPIL** di publik.</p>
                        </div>
                    </div>

                    <!-- STANDAR DOKUMEN PER UNIT -->
                    <div class="bg-white border-4 border-slate-100 rounded-[3rem] p-10 shadow-sm">
                        <h5 class="text-xl font-bold text-slate-800 mb-8 text-center uppercase tracking-widest border-b pb-4">Standar Dokumen Minimal Per Unit</h5>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="space-y-2">
                                <p class="text-[10px] font-black text-blue-600 uppercase border-b pb-1">Dinas / Badan / RSUD</p>
                                <ul class="text-[9px] text-slate-500 space-y-1 list-disc list-inside">
                                    <li>Renstra, Renja, DPA, RKA, LRA</li>
                                    <li>Neraca, Tarif Layanan, LHKPN</li>
                                </ul>
                            </div>
                            <div class="space-y-2">
                                <p class="text-[10px] font-black text-indigo-600 uppercase border-b pb-1">Inspektorat</p>
                                <ul class="text-[9px] text-slate-500 space-y-1 list-disc list-inside">
                                    <li>PKPT, Ringkasan LHP, SOP Audit</li>
                                </ul>
                            </div>
                            <div class="space-y-2">
                                <p class="text-[10px] font-black text-green-600 uppercase border-b pb-1">Kecamatan / Desa / Kel</p>
                                <ul class="text-[9px] text-slate-500 space-y-1 list-disc list-inside">
                                    <li>APBDes, RPJMDes, LPPD, Monografi</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Transparansi & Permohonan -->
            <div x-show="$store.pedomanAdminModal.activeTab === 2" x-transition class="space-y-8">
                <div class="flex items-center gap-4 border-l-4 border-green-600 pl-4 mb-6">
                    <h4 class="text-2xl font-bold text-slate-800">Alur Layanan Permohonan Informasi</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="bg-slate-900 rounded-3xl p-8 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-8 opacity-10">
                            <i class="fas fa-file-import text-9xl"></i>
                        </div>
                        <h5 class="text-xl font-bold mb-6 flex items-center gap-3">
                            <i class="fas fa-user-edit text-green-400"></i>
                            Mengarahkan Pemohon
                        </h5>
                        <div class="space-y-6">
                            <div class="flex gap-4">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-sm">1</div>
                                <div>
                                    <p class="font-bold text-green-400 text-sm uppercase">Login Pemohon</p>
                                    <p class="text-xs text-slate-300 mt-1">Minta warga login ke portal PPID.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-sm">2</div>
                                <div>
                                    <p class="font-bold text-green-400 text-sm uppercase">Isi Formulir</p>
                                    <p class="text-xs text-slate-300 mt-1">Arahkan ke menu <strong>Transparansi</strong> > <strong>Permohonan Informasi</strong>.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border-2 border-slate-100 rounded-3xl p-8">
                        <h5 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                            <i class="fas fa-reply text-blue-600"></i>
                            Tugas Admin (Merespon)
                        </h5>
                        <div class="space-y-6">
                            <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100">
                                <ol class="text-xs text-slate-600 space-y-3 list-decimal list-inside">
                                    <li>Pilih permohonan status <span class="text-orange-600 font-bold uppercase">Pending</span>.</li>
                                    <li>Klik tombol <span class="bg-blue-600 text-white px-2 py-0.5 rounded text-[10px] font-bold">Proses/Balas</span>.</li>
                                    <li>Tulis balasan & kirim dokumen.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: PBJ (PU & Sekretariat) -->
            <div x-show="$store.pedomanAdminModal.activeTab === 3" x-transition class="space-y-8">
                <div class="flex items-center gap-4 border-l-4 border-orange-600 pl-4 mb-6">
                    <h4 class="text-2xl font-bold text-slate-800">Panduan Khusus PBJ</h4>
                </div>

                <div class="bg-orange-50 p-6 rounded-2xl border border-orange-100 mb-8 flex gap-4 items-start">
                    <div class="bg-orange-500 text-white p-3 rounded-xl"><i class="fas fa-exclamation-triangle"></i></div>
                    <div>
                        <h6 class="font-bold text-orange-800">Perhatian Khusus PBJ!</h6>
                        <p class="text-xs text-orange-700 leading-relaxed mt-1">Wajib upload RUP, KAK, Kontrak, dan BAST secara berkala.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <h5 class="font-bold text-slate-800">Langkah Input PBJ</h5>
                        <ul class="text-sm text-slate-600 space-y-4">
                            <li class="p-4 bg-white border border-slate-200 rounded-xl flex gap-3">
                                <span class="text-orange-500 font-bold">01.</span>
                                <span>Klik menu <strong>PBJ</strong> > <strong>Input Data Paket</strong>.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="bg-slate-50 p-6 border-t border-slate-100 flex flex-col md:flex-row gap-6 items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="flex -space-x-2">
                    <img src="https://ui-avatars.com/api/?name=Admin+PPID&background=4f46e5&color=fff" class="w-8 h-8 rounded-full border-2 border-white">
                </div>
                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none">Dinas Kominfo & Persandian Sinjai</div>
            </div>
            
            <div class="flex gap-3 w-full md:w-auto">
                <button @click="$store.pedomanAdminModal.prevTab()" x-show="$store.pedomanAdminModal.activeTab > 0" class="px-6 py-3 bg-white text-slate-600 font-bold rounded-2xl border border-slate-200 text-sm">SEBELUMNYA</button>
                <button @click="$store.pedomanAdminModal.nextTab()" class="flex-1 md:flex-none px-12 py-3 bg-indigo-700 text-white font-black rounded-2xl shadow-xl text-sm">
                    <span x-text="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'TUTUP PANDUAN' : 'LANJUT'"></span>
                </button>
            </div>
        </div>
    </div>
</div>

@if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin'))
    <div class="fixed z-[105] bottom-6 right-6" x-data x-cloak>
        <button @click="$store.pedomanAdminModal.show()" 
                class="w-16 h-16 bg-indigo-700 hover:bg-indigo-800 text-white rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 group relative border-4 border-white">
            <i class="fas fa-book-reader text-2xl"></i>
            <div class="absolute bottom-full right-0 mb-4 px-4 py-2 bg-indigo-900 text-white text-[10px] font-bold rounded-xl opacity-0 group-hover:opacity-100 transition-all transform translate-y-2 group-hover:translate-y-0 whitespace-nowrap pointer-events-none shadow-xl border border-indigo-800 uppercase tracking-widest">
                <i class="fas fa-chalkboard-teacher mr-2"></i> Panduan Operasional Admin
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
