<div x-show="$store.pedomanAdminModal.open" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 z-[110] bg-slate-900/90 backdrop-blur-sm flex items-center justify-center p-2 md:p-6" 
     style="display: none;">
    
    <div class="bg-white w-full max-w-7xl max-h-[95vh] rounded-3xl shadow-2xl flex flex-col overflow-hidden border border-slate-200 font-sans text-slate-700">
        
        <!-- Header -->
        <div class="bg-indigo-900 px-6 py-4 flex-shrink-0 border-b border-indigo-950 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-indigo-50 p-2 rounded-xl shadow-lg">
                        <i class="fas fa-chalkboard-teacher text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold uppercase tracking-tight">Pedoman Operasional Admin</h3>
                        <p class="text-indigo-200 text-xs font-medium uppercase tracking-widest">Portal PPID v2.0</p>
                    </div>
                </div>
                <button @click="$store.pedomanAdminModal.close()" 
                        class="bg-white/10 hover:bg-white/20 text-white transition-all p-2 rounded-lg">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Tab Navigation (STICKY) -->
        <div class="bg-slate-50 border-b border-slate-200 flex overflow-x-auto no-scrollbar sticky top-0 z-50 shadow-sm">
            <template x-for="(tab, index) in $store.pedomanAdminModal.tabs" :key="index">
                <button @click="$store.pedomanAdminModal.activeTab = index"
                        :class="$store.pedomanAdminModal.activeTab === index ? 'border-indigo-600 text-indigo-700 bg-white shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700'"
                        class="px-5 py-4 border-b-4 font-bold text-xs whitespace-nowrap transition-all flex items-center gap-2 min-h-[56px] uppercase tracking-tighter">
                    <i :class="tab.icon"></i>
                    <span x-text="tab.title"></span>
                </button>
            </template>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-6 md:p-10 bg-white space-y-12">
            
            <!-- Tab 0: MENU PROFIL -->
            <div x-show="$store.pedomanAdminModal.activeTab === 0" x-transition class="space-y-12">
                <h4 class="text-xl font-bold border-l-4 border-indigo-600 pl-4 uppercase tracking-tighter">Pengelolaan Profil OPD & Pimpinan</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- 1. Struktur & Website -->
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-200 shadow-sm">
                        <h5 class="font-bold text-indigo-700 mb-4 flex items-center gap-2 uppercase text-sm">
                            <span class="bg-indigo-100 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">1</span>
                            Struktur & Website OPD
                        </h5>
                        <ul class="space-y-4 text-xs mb-8 leading-relaxed font-medium">
                            <li class="flex gap-3">
                                <i class="fas fa-mouse-pointer text-indigo-500 mt-0.5"></i>
                                <span>Menu <strong>Profil</strong> > <strong>Tentang OPD</strong></span>
                            </li>
                            <li class="flex gap-3">
                                <i class="fas fa-search text-indigo-500 mt-0.5"></i>
                                <span>Cari unit, klik tombol <span class="bg-white text-blue-600 border border-blue-200 px-2 py-0.5 rounded text-[9px] font-bold uppercase shadow-sm">KELOLA PROFIL UNIT</span></span>
                            </li>
                        </ul>
                        <div class="space-y-4 border-t pt-5">
                            <div class="flex gap-4 bg-white p-4 rounded-xl border border-slate-100 shadow-inner items-center">
                                <div class="flex-1 text-[10px] text-slate-500 font-bold uppercase italic">A. Upload Gambar Struktur (JPG/PNG).</div>
                                <div class="w-24 bg-slate-50 border border-dashed border-slate-300 rounded-lg flex items-center justify-center relative py-3">
                                    <i class="fas fa-sitemap text-slate-300"></i>
                                    <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[5px] border-y-transparent border-r-[8px] border-r-indigo-500 shadow-lg"></div>
                                </div>
                            </div>
                            <div class="flex gap-4 bg-white p-4 rounded-xl border border-slate-100 shadow-inner items-center">
                                <div class="flex-1 text-[10px] text-slate-500 font-bold uppercase italic">B. Input URL Website Resmi.</div>
                                <div class="w-24 bg-white border border-slate-200 rounded p-1.5 flex items-center relative shadow-sm">
                                    <span class="text-[7px] text-indigo-400 font-black italic">https://...</span>
                                    <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[5px] border-y-transparent border-r-[8px] border-r-indigo-500 shadow-lg"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Data Pimpinan -->
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-200 shadow-sm">
                        <h5 class="font-bold text-indigo-700 mb-4 flex items-center gap-2 uppercase text-sm">
                            <span class="bg-indigo-100 w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span>
                            Data Pimpinan & Pejabat
                        </h5>
                        <ul class="space-y-4 text-xs mb-8 leading-relaxed font-medium">
                            <li class="flex gap-3">
                                <i class="fas fa-edit text-indigo-500 mt-0.5"></i>
                                <span>Cari pimpinan, klik tombol <span class="bg-amber-500 text-white px-2 py-0.5 rounded shadow-sm text-[10px] font-bold uppercase shadow-md">KELOLA PIMPINAN</span>.</span>
                            </li>
                            <li class="bg-amber-100/50 p-3 rounded-xl border-2 border-amber-200 text-[10px] font-bold text-amber-800 italic">
                                <i class="fas fa-info-circle mr-1"></i> WAJIB: Isi Tab Identitas (Nama + Gelar & Status Aktif). Lainnya OPSIONAL.
                            </li>
                        </ul>
                        <div class="space-y-4 border-t pt-5">
                            <div class="bg-white p-5 rounded-2xl border border-slate-200 space-y-4 shadow-inner relative">
                                <div class="flex items-center gap-4">
                                    <div class="bg-indigo-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold shadow-lg shadow-indigo-200">A</div>
                                    <p class="text-[10px] font-bold text-slate-700">NAMA LENGKAP + GELAR (Dr. Nama, M.Si)</p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="bg-indigo-600 text-white w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold shadow-lg shadow-indigo-200">B</div>
                                    <p class="text-[10px] font-bold text-slate-700 uppercase">STATUS DISETEL KE: <span class="text-green-600 underline font-black">AKTIF</span></p>
                                </div>
                                <div class="flex justify-center pt-3">
                                    <div class="bg-blue-600 text-white px-8 py-2.5 rounded-xl text-[10px] font-bold animate-bounce shadow-xl border-2 border-white uppercase">SIMPAN PROFIL</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 1: JENIS INFORMASI (FULL RESTORED) -->
            <div x-show="$store.pedomanAdminModal.activeTab === 1" x-transition class="space-y-12">
                <h4 class="text-xl font-bold border-l-4 border-blue-600 pl-4 uppercase tracking-tighter">Klasifikasi & Panduan Operasional Informasi</h4>

                <!-- BAGIAN: LOGIKA MENDALAM (WHY) -->
                <div class="space-y-8">
                    <h5 class="text-lg font-bold flex items-center gap-3 border-b-2 border-blue-100 pb-2 uppercase text-slate-800">
                        <i class="fas fa-balance-scale text-blue-600"></i> Mengapa Harus Diklasifikasikan?
                    </h5>
                    
                    <div class="grid grid-cols-1 gap-8 text-sm leading-relaxed font-bold">
                        <!-- BERKALA -->
                        <div class="bg-blue-50 p-10 rounded-[3rem] border-2 border-blue-200 relative overflow-hidden shadow-sm">
                            <div class="absolute top-0 right-0 p-10 opacity-5"><i class="fas fa-history text-[8rem] text-blue-900"></i></div>
                            <h6 class="font-black text-blue-900 mb-4 uppercase tracking-widest flex items-center gap-3 text-base italic underline underline-offset-4 decoration-2">
                                <i class="fas fa-calendar-alt"></i> 1. Informasi Berkala (Kewajiban Rutin)
                            </h6>
                            <p class="mb-6 text-xs text-justify">Dokumen diklasifikasikan sebagai <strong>Informasi Berkala</strong> karena merupakan <strong>Kewajiban Akuntabilitas Rutin</strong>. Wajib ada dan diperbarui terjadwal (tahunan/semesteran) sesuai siklus anggaran. Sifatnya <strong>Ganti Data (Update)</strong>. Dokumen terbaru (2024) WAJIB mematikan validitas dokumen lama (2023) menjadi <strong>ARSIP</strong>.</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="bg-white/80 p-5 rounded-[2rem] border-2 border-blue-100 shadow-xl italic text-blue-800 text-[11px]">
                                    <p class="uppercase underline decoration-2 mb-2 italic">Studi Logika Rutin:</p>
                                    <span>"Setiap dokumen dengan <strong>Siklus Waktu Tetap</strong> (seperti Renstra, Anggaran, atau Laporan Kinerja) WAJIB masuk kategori <strong>BERKALA</strong>. Data lama wajib masuk <strong>ARSIP</strong>."</span>
                                </div>
                                <div class="bg-white/80 p-5 rounded-[2rem] border-2 border-blue-100 shadow-xl italic text-red-700 text-[11px]">
                                    <p class="uppercase underline decoration-2 mb-2 italic">Penting:</p>
                                    <span>"Wajib mengubah status data lama menjadi ARSIP ketika ada dokumen baru yang BERLAKU, agar publik selalu mendapatkan referensi yang akurat."</span>
                                </div>
                            </div>
                        </div>

                        <!-- SETIAP SAAT -->
                        <div class="bg-emerald-50 p-10 rounded-[4rem] border-2 border-emerald-200 relative overflow-hidden shadow-sm text-emerald-900">
                            <div class="absolute top-0 right-0 p-10 opacity-5"><i class="fas fa-folder-open text-[8rem] text-emerald-900"></i></div>
                            <h6 class="font-black mb-4 uppercase tracking-widest flex items-center gap-3 text-base italic underline underline-offset-4 decoration-2">
                                <i class="fas fa-archive"></i> 2. Informasi Setiap Saat (Catatan Sejarah)
                            </h6>
                            <p class="mb-6 text-xs text-justify">Dokumen masuk kategori ini karena merupakan <strong>Catatan Histori & Produk Kebijakan</strong>. Wajib sedia kapanpun diminta. Sifatnya <strong>Akumulatif (Menumpuk)</strong>. Semua data tahun lama hingga sekarang tetap BERLAKU sebagai database sejarah kebijakan unit Bapak.</p>
                            <div class="bg-white/80 p-5 rounded-[2rem] border-2 border-emerald-100 shadow-xl italic text-emerald-800 text-[11px]">
                                <p class="uppercase underline decoration-2 mb-2 italic">Studi Logika Kebijakan:</p>
                                <span>"Dokumen berupa <strong>Ketetapan Hukum</strong> (seperti SK Kadis, MoU Kerjasama) WAJIB masuk kategori <strong>SETIAP SAAT</strong> karena berlaku permanen selama belum dicabut pimpinan."</span>
                            </div>
                        </div>

                        <!-- SERTA MERTA & DIKECUALIKAN -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="bg-red-50 p-6 rounded-3xl border-2 border-red-200 text-xs shadow-sm">
                                <h6 class="font-bold text-red-900 mb-2 uppercase underline italic">3. Serta Merta (Darurat)</h6>
                                <p>Mendesak & Mengancam Nyawa. Wajib upload detik itu juga! <br><span class="text-red-600">(Contoh: Info Banjir, Wabah).</span></p>
                            </div>
                            <div class="bg-slate-900 p-6 rounded-3xl border-2 border-slate-700 text-xs shadow-sm text-white">
                                <h6 class="font-bold text-slate-300 mb-2 uppercase underline italic">4. Dikecualikan (Rahasia)</h6>
                                <p>Data Rahasia (Pasal 17 UU KIP). Tidak tampil di publik. <span class="text-indigo-400">(Contoh: Rekam Medis, Rahasia Bisnis).</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TUTORIAL FORM A - H -->
                <div class="space-y-8">
                    <h5 class="text-lg font-bold flex items-center gap-3 border-b-2 border-slate-100 pb-2 uppercase text-slate-800">
                        <i class="fas fa-edit text-indigo-600"></i> Tutorial Pengisian Formulir (A - H)
                    </h5>

                    <div class="bg-slate-50 rounded-[4rem] border-4 border-slate-200 p-10 space-y-16 shadow-inner font-black">
                        <!-- A: JUDUL -->
                        <div class="flex flex-col md:flex-row gap-10 items-start">
                            <div class="flex-1 space-y-2 uppercase tracking-tighter">
                                <div class="flex gap-4 items-center">
                                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg">A</span>
                                    <h6 class="text-base font-bold">Judul Informasi</h6>
                                </div>
                                <p class="ml-14 text-xs text-slate-500 italic underline underline-offset-2">Wajib Baku: Nama Dokumen + Unit + Tahun.</p>
                            </div>
                            <div class="md:w-72 bg-white p-3 rounded-xl border-2 border-indigo-100 shadow-xl relative">
                                <div class="h-10 w-full border-2 border-indigo-200 rounded-lg bg-indigo-50/50 flex items-center px-4 text-[9px] text-indigo-400 italic shadow-inner">Renja Dinas... 2024...</div>
                                <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[10px] border-y-transparent border-r-[15px] border-r-indigo-600 shadow-2xl"></div>
                            </div>
                        </div>

                        <!-- B: DESKRIPSI & PELENGKAP -->
                        <div class="flex flex-col md:flex-row gap-10 items-start border-t pt-10">
                            <div class="flex-1 space-y-6 uppercase tracking-tighter">
                                <div class="flex gap-4 items-center">
                                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg">B</span>
                                    <h6 class="text-base font-bold">Deskripsi & Lampiran</h6>
                                </div>
                                <div class="ml-14 space-y-6 text-xs font-black">
                                    <p class="text-slate-500 italic">Ringkasan isi dokumen bagi masyarakat.</p>
                                    <div class="bg-amber-100 p-8 rounded-[3rem] border-4 border-amber-300 shadow-xl shadow-amber-200/50 relative overflow-hidden italic text-amber-900">
                                        <div class="absolute top-0 right-0 p-6 opacity-10"><i class="fas fa-file-pdf text-6xl"></i></div>
                                        <h6 class="font-bold uppercase mb-4 underline decoration-4 italic">Dokumen Pelengkap (WAJIB):</h6>
                                        <p class="leading-loose uppercase tracking-tighter underline">"Jika laporan Bapak memiliki lampiran banyak (DPA + Lampiran A-Z), wajib GABUNGKAN DALAM 1 PDF atau gunakan opsi Link File Google Drive unit Bapak!"</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- H: FINALISASI -->
                        <div class="flex flex-col md:flex-row gap-10 items-start border-t-4 border-dashed border-slate-200 pt-16">
                            <div class="flex-1 space-y-4 uppercase tracking-tighter">
                                <div class="flex gap-4 items-center">
                                    <span class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg animate-bounce text-sm">H</span>
                                    <h6 class="text-base font-bold underline decoration-blue-500 decoration-4 italic">Check & Simpan</h6>
                                </div>
                                <p class="ml-14 text-xs text-blue-700 italic font-black">"Khusus BERKALA, WAJIB klik CHECK INFORMASI untuk mematikan data tahun lama secara otomatis!"</p>
                            </div>
                            <div class="md:w-72 flex justify-center relative">
                                <div class="bg-yellow-500 text-white px-8 py-3 rounded-2xl text-[10px] font-black shadow-xl animate-bounce border-4 border-white uppercase italic shadow-yellow-200">CHECK INFORMASI</div>
                                <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[12px] border-y-transparent border-r-[20px] border-r-yellow-500 shadow-lg"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BANTUAN AI -->
                <div class="bg-indigo-900 text-white p-12 rounded-[5rem] shadow-2xl relative overflow-hidden italic font-black">
                    <div class="absolute -right-10 -bottom-10 opacity-10"><i class="fas fa-microchip text-[15rem]"></i></div>
                    <div class="relative z-10">
                        <h5 class="text-3xl font-black mb-10 flex items-center gap-8 italic tracking-tighter uppercase underline decoration-8 decoration-indigo-700 underline-offset-8">
                            <i class="fas fa-magic text-indigo-300 text-5xl"></i> Bingung Klasifikasi? Tanya AI!
                        </h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center text-base">
                            <div class="space-y-10">
                                <div class="flex gap-8 items-start bg-white/5 p-8 rounded-[3rem] border-4 border-white/10 shadow-2xl transition-all hover:bg-white/10">
                                    <span class="bg-indigo-500 text-white w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center font-black text-xl shadow-xl shadow-indigo-900/50">1</span>
                                    <p class="pt-2 uppercase underline decoration-indigo-400">Klik tombol "Tanya Pedoman" di pojok kanan atas form.</p>
                                </div>
                                <div class="flex gap-8 items-start bg-white/5 p-8 rounded-[3rem] border-4 border-white/10 shadow-2xl transition-all hover:bg-white/10">
                                    <span class="bg-indigo-500 text-white w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center font-black text-xl shadow-xl shadow-indigo-900/50">2</span>
                                    <p class="pt-2 italic uppercase italic underline decoration-green-500 decoration-4 underline-offset-8">Ketik Nama Dokumen & Klik Tombol Hijau <span class="bg-green-600 px-5 py-2 rounded-2xl animate-pulse shadow-green-900/50">TANYA AI</span>!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- REKAPITULASI DOKUMEN WAJIB -->
                <div class="bg-white border-[12px] border-slate-50 rounded-[5rem] p-16 shadow-2xl relative overflow-hidden font-black italic uppercase tracking-tighter">
                    <div class="absolute top-0 left-0 w-full h-3 bg-gradient-to-r from-blue-600 via-indigo-600 to-emerald-600"></div>
                    <h5 class="text-2xl font-black text-slate-800 mb-16 text-center uppercase tracking-[0.5em] italic underline decoration-8 decoration-slate-100 underline-offset-8">Dokumen Wajib Per Unit Kerja</h5>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-16 text-slate-500">
                        <div class="space-y-6">
                            <p class="text-sm font-black text-blue-600 uppercase border-b-4 border-blue-100 pb-3 flex items-center gap-3 underline underline-offset-4 decoration-4"><i class="fas fa-building text-xl"></i> Dinas / Badan / RSUD</p>
                            <ul class="text-xs text-slate-500 space-y-4 list-disc list-inside leading-loose italic uppercase tracking-tighter">
                                <li>Renstra & Renja (5 thn & thn)</li>
                                <li>DPA & RKA Anggaran Unit</li>
                                <li>LRA & Neraca Keuangan</li>
                                <li>Tarif Layanan & SPM (RSUD)</li>
                                <li>LHKPN Pejabat Utama</li>
                            </ul>
                        </div>
                        <div class="space-y-6">
                            <p class="text-sm font-black text-indigo-600 uppercase border-b-4 border-indigo-100 pb-3 flex items-center gap-3 underline underline-offset-4 decoration-4"><i class="fas fa-search-dollar text-xl"></i> Inspektorat</p>
                            <ul class="text-xs text-slate-500 space-y-4 list-disc list-inside leading-loose italic uppercase tracking-tighter text-justify">
                                <li>PKPT (Program Kerja Audit)</li>
                                <li>Ringkasan LHP Publik</li>
                                <li>SOP Audit Pengawasan</li>
                                <li>Laporan Akuntabilitas</li>
                            </ul>
                        </div>
                        <div class="space-y-6">
                            <p class="text-sm font-black text-green-600 uppercase border-b-4 border-green-100 pb-3 flex items-center gap-3 underline underline-offset-4 decoration-4"><i class="fas fa-map-marked-alt text-xl"></i> Kecamatan / Desa / Kel</p>
                            <ul class="text-xs text-slate-500 space-y-4 list-disc list-inside leading-loose italic uppercase tracking-tighter text-justify">
                                <li>APBDes / RKPDes (Anggaran)</li>
                                <li>LPPD Penyelenggaraan Desa</li>
                                <li>Monografi & Profil Wilayah</li>
                                <li>Data Inventaris Aset Desa</li>
                                <li>Laporan PATEN (Kecamatan)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: TRANSPARANSI (RESTORED) -->
            <div x-show="$store.pedomanAdminModal.activeTab === 2" x-transition class="space-y-8 uppercase font-bold italic tracking-tighter text-slate-800">
                <h4 class="text-xl font-bold border-l-4 border-green-600 pl-4 underline underline-offset-4 tracking-tighter">Layanan Permohonan Informasi</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="bg-slate-900 rounded-3xl p-8 text-white relative overflow-hidden shadow-2xl transition-all hover:scale-[1.02]">
                        <div class="absolute top-0 right-0 p-8 opacity-10"><i class="fas fa-file-import text-8xl"></i></div>
                        <h5 class="text-lg font-bold mb-6 flex items-center gap-3 italic uppercase underline decoration-indigo-500 decoration-4 underline-offset-8 font-black">Mengarahkan Pemohon</h5>
                        <div class="space-y-8 font-black">
                            <div class="flex gap-6 items-start bg-white/10 p-6 rounded-[2.5rem] border-2 border-white/20 shadow-xl shadow-green-900/50">
                                <span class="bg-green-500 text-white w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-lg shadow-lg">1</span>
                                <p class="text-sm tracking-widest pt-3 uppercase italic font-black">Warga login ke portal PPID.</p>
                            </div>
                            <div class="flex gap-6 items-start bg-white/10 p-6 rounded-[2.5rem] border-2 border-white/20 shadow-xl shadow-green-900/50">
                                <span class="bg-green-500 text-white w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-lg shadow-lg">2</span>
                                <p class="text-sm tracking-widest pt-3 uppercase italic font-black underline decoration-green-400 underline-offset-4">Menu Transparansi > Permohonan.</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border-8 border-slate-100 rounded-[4rem] p-12 shadow-2xl font-black italic uppercase">
                        <h5 class="text-xl font-bold text-slate-800 mb-8 flex items-center gap-3 uppercase italic underline decoration-blue-500 decoration-8 underline-offset-8 decoration-offset-4">Admin Merespon</h5>
                        <div class="p-8 bg-blue-50 rounded-[3rem] border-4 border-blue-100 shadow-inner">
                            <ol class="text-xs text-slate-600 space-y-6 list-decimal list-inside font-bold italic tracking-tighter uppercase leading-relaxed font-black">
                                <li class="bg-white p-4 rounded-2xl shadow-md border-2 border-blue-100">Buka Dashboard Permohonan.</li>
                                <li class="bg-white p-4 rounded-2xl shadow-md border-2 border-blue-100">Cari status <span class="text-orange-600 underline uppercase italic">PENDING</span>.</li>
                                <li class="bg-white p-4 rounded-2xl shadow-xl border-4 border-blue-300">Tombol Biru <span class="text-blue-600 underline italic uppercase tracking-widest">"PROSES / BALAS"</span>.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: PBJ (RESTORED) -->
            <div x-show="$store.pedomanAdminModal.activeTab === 3" x-transition class="space-y-12 font-bold italic uppercase tracking-tighter text-slate-800">
                <h4 class="text-xl font-bold border-l-4 border-orange-600 pl-4 italic underline underline-offset-8">Panduan Khusus PBJ</h4>
                <div class="bg-orange-50 p-12 rounded-[5rem] border-8 border-orange-100 mb-12 flex gap-10 items-start shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5 rotate-12"><i class="fas fa-shopping-cart text-[10rem] text-orange-900"></i></div>
                    <div class="bg-orange-500 text-white p-10 rounded-[4rem] shadow-2xl animate-bounce border-8 border-white flex-shrink-0 italic shadow-orange-300">
                        <i class="fas fa-exclamation-triangle text-5xl text-white shadow-orange-950"></i>
                    </div>
                    <div class="relative z-10 pt-4 space-y-6 font-black uppercase tracking-tighter">
                        <h6 class="text-3xl font-bold text-orange-900 italic underline decoration-orange-300 decoration-8 underline-offset-8 uppercase">WAJIB BAGI BAGIAN PBJ!</h6>
                        <p class="text-lg text-orange-800 leading-relaxed font-bold underline decoration-4 decoration-orange-100 underline-offset-8 italic">"UPDATE DATA PAKET TENDER RUTIN SESUAI PROGRES FISIK!"</p>
                    </div>
                </div>
                <div class="space-y-6 font-black italic uppercase">
                    <ul class="text-base space-y-8">
                        <li class="p-12 bg-white border-8 border-slate-100 rounded-[5rem] shadow-2xl flex gap-10 items-center transition-all hover:scale-105 hover:border-orange-200 group">
                            <span class="text-orange-500 font-bold text-6xl italic tracking-tighter group-hover:scale-125 transition-transform shadow-orange-100 text-shadow-xl shadow-inner">01.</span>
                            <span class="text-xl uppercase tracking-tighter font-black italic underline decoration-orange-100 decoration-8">Klik menu <strong>PBJ</strong> > <strong>Input Paket</strong>. Isi Pagu & Pemenang Tender.</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="bg-slate-50 p-10 border-t-8 border-slate-100 flex flex-col md:flex-row gap-10 items-center justify-between flex-shrink-0 shadow-[0_-15px_60px_rgba(0,0,0,0.05)] relative z-50">
            <div class="flex items-center gap-8 text-slate-400 font-bold uppercase tracking-[0.5em] leading-tight text-[11px] italic font-black">
                <div class="flex -space-x-8">
                    <img src="https://ui-avatars.com/api/?name=Admin+PPID&background=4f46e5&color=fff" class="w-20 h-20 rounded-full border-8 border-white shadow-2xl shadow-indigo-200">
                    <img src="https://ui-avatars.com/api/?name=Super+Admin&background=1e1b4b&color=fff" class="w-20 h-20 rounded-full border-8 border-white shadow-2xl shadow-indigo-900">
                </div>
                <div>Portal PPID v2.0 <br><span class="text-[10px] font-black text-indigo-500 italic underline decoration-4 decoration-indigo-100">Dinas Kominfo & Persandian Sinjai</span></div>
            </div>
            
            <div class="flex gap-8 w-full md:w-auto font-black uppercase italic tracking-tighter">
                <button @click="$store.pedomanAdminModal.prevTab()" x-show="$store.pedomanAdminModal.activeTab > 0" class="px-12 py-5 bg-white text-slate-600 rounded-[2rem] border-8 border-slate-200 text-base hover:bg-slate-50 transition-all flex items-center gap-6 shadow-3xl active:scale-95 italic shadow-inner">
                    <i class="fas fa-arrow-left"></i> SEBELUMNYA
                </button>

                <button @click="$store.pedomanAdminModal.nextTab()" class="flex-1 md:flex-none px-24 py-5 bg-indigo-700 text-white rounded-[2rem] shadow-[0_30px_80px_rgba(67,56,202,0.4)] text-base transition-all hover:bg-indigo-800 hover:scale-[1.15] active:scale-95 flex items-center justify-center gap-8 border-b-[16px] border-indigo-950 uppercase italic tracking-widest decoration-white/20 underline">
                    <span x-text="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'SAYA MENGERTI, TUTUP' : 'LANJUT KE BERIKUTNYA'"></span>
                    <i :class="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'fas fa-check-double' : 'fas fa-arrow-right'"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin'))
    <div class="fixed z-[105] bottom-6 right-6" x-data x-cloak>
        <button @click="$store.pedomanAdminModal.show()" 
                class="w-18 h-18 bg-indigo-700 hover:bg-indigo-800 text-white rounded-full shadow-[0_30px_80px_rgba(67,56,202,0.6)] flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 group relative border-4 border-white p-4 overflow-hidden transition-all duration-700 shadow-indigo-600/30">
            <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/10 to-white/20 opacity-0 group-hover:opacity-100 transition-opacity shadow-inner"></div>
            <i class="fas fa-chalkboard-teacher text-3xl group-hover:rotate-12 transition-transform shadow-indigo-950"></i>
            <div class="absolute bottom-full right-0 mb-6 px-6 py-3 bg-indigo-950 text-white text-[12px] font-black rounded-[2.5rem] opacity-0 group-hover:opacity-100 transition-all transform translate-y-8 group-hover:translate-y-0 whitespace-nowrap pointer-events-none shadow-[0_30px_70px_rgba(0,0,0,0.8)] border-4 border-indigo-800 uppercase tracking-widest flex items-center gap-4 italic font-black shadow-2xl italic">
                <i class="fas fa-graduation-cap text-indigo-400 text-2xl animate-bounce"></i> Panduan Operasional Admin
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
