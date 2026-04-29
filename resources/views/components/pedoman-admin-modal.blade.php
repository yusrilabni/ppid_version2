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
        <div class="bg-indigo-900 px-6 py-4 flex-shrink-0 border-b border-indigo-950 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-indigo-500 p-2 rounded-xl shadow-lg">
                        <i class="fas fa-chalkboard-teacher text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold uppercase tracking-tight">Pedoman Operasional Admin</h3>
                        <p class="text-indigo-200 text-xs font-medium">Panduan Pengelolaan Portal PPID v2</p>
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
                        class="px-4 py-3 border-b-4 font-bold text-sm whitespace-nowrap transition-all flex items-center gap-2 min-h-[56px]">
                    <i :class="tab.icon"></i>
                    <span x-text="tab.title"></span>
                </button>
            </template>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-6 md:p-10 bg-white text-slate-700">
            
            <!-- Tab 0: Menu Profil -->
            <div x-show="$store.pedomanAdminModal.activeTab === 0" x-transition class="space-y-10">
                <h4 class="text-xl font-bold border-l-4 border-indigo-600 pl-4 uppercase tracking-tighter">Pengelolaan Profil OPD & Pimpinan</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 shadow-sm text-sm">
                            <h5 class="font-bold text-indigo-700 mb-4 flex items-center gap-2 uppercase">
                                <span class="bg-indigo-100 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">1</span>
                                Struktur & Website OPD
                            </h5>
                            <ul class="space-y-3 text-xs text-slate-600 mb-6 leading-relaxed">
                                <li class="flex gap-3">
                                    <i class="fas fa-mouse-pointer text-indigo-500 mt-0.5"></i>
                                    <span>Klik menu <strong>Profil</strong> > <strong>Tentang OPD</strong></span>
                                </li>
                                <li class="flex gap-3">
                                    <i class="fas fa-search text-indigo-500 mt-0.5"></i>
                                    <span>Cari unit Bapak, klik tombol <span class="bg-white text-blue-600 border border-blue-200 px-1.5 py-0.5 rounded text-[9px] font-bold uppercase">KELOLA PROFIL UNIT</span></span>
                                </li>
                                <li class="flex gap-3">
                                    <i class="fas fa-upload text-indigo-500 mt-0.5"></i>
                                    <span>Lengkapi form, klik tombol <span class="bg-blue-600 text-white px-2 py-0.5 rounded shadow-sm text-[10px] font-bold uppercase">SIMPAN PERUBAHAN</span>.</span>
                                </li>
                            </ul>

                            <div class="space-y-3 border-t pt-4">
                                <div class="flex gap-4 bg-white p-3 rounded-lg border border-slate-100 shadow-sm items-center">
                                    <div class="flex-1 text-[10px] text-slate-500 font-bold uppercase">A. Upload Gambar Struktur (JPG/PNG).</div>
                                    <div class="w-24 bg-slate-50 border border-dashed border-slate-300 rounded flex items-center justify-center relative py-2">
                                        <i class="fas fa-sitemap text-slate-300"></i>
                                        <div class="absolute -left-2 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[4px] border-y-transparent border-r-[6px] border-r-indigo-500"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 shadow-sm text-sm">
                            <h5 class="font-bold text-indigo-700 mb-4 flex items-center gap-2 uppercase">
                                <span class="bg-indigo-100 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">2</span>
                                Data Pimpinan & Pejabat
                            </h5>
                            <ul class="space-y-3 text-xs text-slate-600 mb-6 leading-relaxed">
                                <li class="flex gap-3">
                                    <i class="fas fa-edit text-indigo-500 mt-0.5"></i>
                                    <span>Cari nama, klik tombol <span class="bg-amber-500 text-white px-1.5 py-0.5 rounded text-[9px] font-bold uppercase shadow-sm">KELOLA PIMPINAN</span>.</span>
                                </li>
                                <li class="flex gap-3 text-amber-700 font-bold bg-amber-100/50 p-3 rounded-xl border-2 border-amber-200 text-[10px]">
                                    <i class="fas fa-info-circle mt-0.5 text-base"></i>
                                    <span>WAJIB: Isi Tab Identitas (Nama & Status Aktif). Lainnya Opsional.</span>
                                </li>
                            </ul>
                            <div class="flex justify-center pt-2">
                                <div class="bg-blue-600 text-white px-5 py-2 rounded-xl text-[10px] font-bold animate-bounce shadow-lg">SIMPAN PROFIL</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 1: Jenis Informasi -->
            <div x-show="$store.pedomanAdminModal.activeTab === 1" x-transition class="space-y-12">
                <div class="flex items-center gap-4 border-l-4 border-blue-600 pl-4 mb-6">
                    <h4 class="text-xl font-bold italic tracking-tight uppercase">Logika Klasifikasi & Standar Dokumen PPID</h4>
                </div>

                <!-- BAGIAN: LOGIKA MENDALAM (WHY) -->
                <div class="space-y-8">
                    <h5 class="text-lg font-bold flex items-center gap-3 border-b-2 border-blue-100 pb-2 uppercase text-slate-800">
                        <i class="fas fa-balance-scale text-blue-600"></i> Mengapa Dokumen Harus Diklasifikasikan?
                    </h5>
                    
                    <div class="grid grid-cols-1 gap-6 text-sm leading-relaxed">
                        <!-- BERKALA -->
                        <div class="bg-blue-50 p-8 rounded-[2.5rem] border border-blue-200 relative overflow-hidden shadow-sm">
                            <div class="absolute top-0 right-0 p-8 opacity-5"><i class="fas fa-history text-[6rem] text-blue-900"></i></div>
                            <h6 class="font-bold text-blue-900 mb-3 uppercase tracking-widest flex items-center gap-2 text-base italic underline">
                                <i class="fas fa-calendar-alt"></i> 1. Informasi Berkala (Kewajiban Rutin)
                            </h6>
                            <p class="mb-4 text-xs font-medium">Dokumen diklasifikasikan sebagai <strong>Informasi Berkala</strong> karena merupakan <strong>Representasi Kewajiban Rutin</strong>. Wajib ada dan diperbarui secara terjadwal (tahunan/semesteran) sesuai siklus anggaran. Sifatnya menggantikan (Update Data). Dokumen terbaru (2024) WAJIB mematikan validitas dokumen lama (2023).</p>
                            <div class="bg-white/80 p-4 rounded-2xl border border-blue-100 text-[11px] italic font-bold text-blue-800 shadow-sm">
                                <p class="uppercase underline mb-1">Studi Logika Rutin:</p>
                                <span>"Setiap dokumen dengan <strong>Siklus Waktu Tetap</strong> (seperti Renstra, Anggaran, atau Laporan Kinerja) WAJIB masuk kategori <strong>BERKALA</strong>. Gunakan fitur <strong>Check Informasi</strong> untuk mengarsipkan data lama."</span>
                            </div>
                        </div>

                        <!-- SETIAP SAAT -->
                        <div class="bg-emerald-50 p-8 rounded-[2.5rem] border border-emerald-200 relative overflow-hidden shadow-sm">
                            <div class="absolute top-0 right-0 p-8 opacity-5"><i class="fas fa-archive text-[6rem] text-emerald-900"></i></div>
                            <h6 class="font-bold text-emerald-900 mb-3 uppercase tracking-widest flex items-center gap-2 text-base italic underline">
                                <i class="fas fa-folder-open"></i> 2. Informasi Setiap Saat (Catatan Sejarah)
                            </h6>
                            <p class="mb-4 text-xs font-medium">Dokumen masuk kategori <strong>Informasi Setiap Saat</strong> karena merupakan <strong>Catatan Histori & Produk Kebijakan</strong>. Wajib sedia kapanpun diminta. Sifatnya <strong>Akumulatif (Menumpuk)</strong>. Semua data tahun lama hingga sekarang tetap BERLAKU sebagai database sejarah kebijakan unit Bapak.</p>
                            <div class="bg-white/80 p-4 rounded-2xl border border-emerald-100 text-[11px] italic font-bold text-emerald-800 shadow-sm">
                                <p class="uppercase underline mb-1">Studi Logika Kebijakan:</p>
                                <span>"Dokumen berupa <strong>Ketetapan Hukum</strong> (SK Kadis, MoU Kerjasama) WAJIB masuk kategori <strong>SETIAP SAAT</strong>. Dokumen ini berlaku permanen selama belum dicabut."</span>
                            </div>
                        </div>

                        <!-- SERTA MERTA & DIKECUALIKAN -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-red-50 p-6 rounded-2xl border border-red-200 text-xs shadow-sm">
                                <h6 class="font-bold text-red-900 mb-2 uppercase underline italic">3. Serta Merta (Darurat)</h6>
                                <p class="font-bold text-slate-700 leading-relaxed">Mendesak & Mengancam Nyawa. Wajib upload segera! <span class="text-red-600">(Contoh: Info Banjir, Wabah, Bencana Alam).</span></p>
                            </div>
                            <div class="bg-slate-900 p-6 rounded-2xl border border-slate-700 text-xs shadow-sm text-white">
                                <h6 class="font-bold text-slate-300 mb-2 uppercase underline italic">4. Dikecualikan (Rahasia)</h6>
                                <p class="font-bold text-slate-400 leading-relaxed">Data Rahasia (Pasal 17 UU KIP). Tidak tampil di publik. <span class="text-indigo-400">(Contoh: Rekam Medis, Rahasia Bisnis).</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN: DAFTAR DOKUMEN WAJIB PER UNIT -->
                <div class="space-y-8">
                    <h5 class="text-lg font-bold flex items-center gap-3 border-b-2 border-slate-100 pb-2 uppercase text-slate-800">
                        <i class="fas fa-list-check text-indigo-600"></i> Dokumen Wajib Per Unit Kerja
                    </h5>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div class="bg-white border-2 border-slate-200 rounded-3xl p-8 shadow-md relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-2 h-full bg-blue-600"></div>
                            <h6 class="font-bold text-blue-700 text-sm mb-6 uppercase tracking-widest italic border-b pb-2">Dinas / Badan / RSUD / Inspektorat</h6>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-xs font-bold uppercase tracking-tighter">
                                <ul class="space-y-3">
                                    <li class="flex items-center gap-3 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                        <div class="bg-blue-600 text-white px-2 py-0.5 rounded text-[8px] uppercase">Berkala</div>
                                        <span class="flex-1">Renstra, Renja, DPA, RKA, LRA, Neraca, LKjIP, PKPT (Audit).</span>
                                    </li>
                                    <li class="flex items-center gap-3 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                        <div class="bg-emerald-600 text-white px-2 py-0.5 rounded text-[8px] uppercase">Setiap Saat</div>
                                        <span class="flex-1">MoU, SK Kadis, Perjanjian Pihak Ke-3, LHP (Ringkasan).</span>
                                    </li>
                                </ul>
                                <div class="bg-blue-50/50 p-6 rounded-2xl border-2 border-dashed border-blue-100 italic text-[10px] text-blue-900 leading-relaxed font-bold">
                                    "RSUD wajib upload Tarif Layanan Medis & Standar Pelayanan Minimal (SPM) di kategori BERKALA."
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border-2 border-slate-200 rounded-3xl p-8 shadow-md relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-2 h-full bg-green-600"></div>
                            <h6 class="font-bold text-green-700 text-sm mb-6 uppercase tracking-widest italic border-b pb-2">Kecamatan / Desa / Kelurahan</h6>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-xs font-bold uppercase tracking-tighter">
                                <ul class="space-y-3">
                                    <li class="flex items-center gap-3 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                        <div class="bg-blue-600 text-white px-2 py-0.5 rounded text-[8px] uppercase">Berkala</div>
                                        <span class="flex-1">APBDes, RKPDes, RPJMDes, LPPD Desa, Laporan PATEN.</span>
                                    </li>
                                    <li class="flex items-center gap-3 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                        <div class="bg-emerald-600 text-white px-2 py-0.5 rounded text-[8px] uppercase">Setiap Saat</div>
                                        <span class="flex-1">Monografi Wilayah, Profil Desa, Data Inventaris.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN: TUTORIAL FORM LENGKAP A - H -->
                <div class="space-y-8">
                    <h5 class="text-lg font-bold flex items-center gap-3 border-b-2 border-slate-100 pb-2 uppercase text-slate-800">
                        <i class="fas fa-edit text-indigo-600"></i> Tutorial Pengisian Formulir (A - H)
                    </h5>

                    <div class="bg-slate-50 rounded-[3rem] border-2 border-slate-200 p-8 space-y-10 shadow-inner">
                        <!-- A: JUDUL -->
                        <div class="flex flex-col md:flex-row gap-8 items-start font-bold">
                            <div class="flex-1 space-y-2">
                                <div class="flex gap-4 items-center">
                                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg">A</span>
                                    <h6 class="text-sm font-bold uppercase tracking-tighter">Judul Informasi</h6>
                                </div>
                                <p class="ml-14 text-xs text-slate-500 uppercase tracking-tighter italic">Format Wajib: <strong>Nama Dokumen + Unit + Tahun</strong>.</p>
                            </div>
                            <div class="md:w-64 bg-white p-3 rounded-xl border-2 border-indigo-100 shadow-md relative">
                                <div class="h-10 w-full border-2 border-indigo-200 rounded-lg bg-indigo-50/50 flex items-center px-4 text-[9px] text-indigo-400 italic">Renja Dinas... 2024...</div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[12px] border-r-indigo-600"></div>
                            </div>
                        </div>

                        <!-- B: DESKRIPSI -->
                        <div class="flex flex-col md:flex-row gap-8 items-start font-bold">
                            <div class="flex-1 space-y-4">
                                <div class="flex gap-4 items-center">
                                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg">B</span>
                                    <h6 class="text-sm font-bold uppercase tracking-tighter">Deskripsi & Lampiran</h6>
                                </div>
                                <div class="ml-14 space-y-4">
                                    <p class="text-xs text-slate-500 uppercase tracking-tighter">Ringkasan isi dokumen bagi masyarakat.</p>
                                    <div class="bg-amber-100 p-5 rounded-2xl border-2 border-amber-200 text-[10px] text-amber-800 italic">
                                        <h6 class="font-bold uppercase mb-2 underline italic"><i class="fas fa-exclamation-triangle"></i> Dokumen Pelengkap (WAJIB):</h6>
                                        <p class="font-bold uppercase leading-relaxed tracking-tighter">"Jika laporan Bapak memiliki lampiran banyak (LRA + Lampiran A-Z), wajib GABUNGKAN DALAM 1 PDF atau gunakan opsi Link File Google Drive unit Bapak!"</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- H: FINALISASI (CHECK SIMILARITY) -->
                        <div class="flex flex-col md:flex-row gap-8 items-start border-t-2 border-dashed border-slate-200 pt-10 font-bold">
                            <div class="flex-1 space-y-2">
                                <div class="flex gap-4 items-center">
                                    <span class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg">H</span>
                                    <h6 class="text-sm font-bold uppercase tracking-tighter underline">Langkah Final: Check & Simpan</h6>
                                </div>
                                <p class="ml-14 text-xs text-blue-700 italic uppercase tracking-tighter font-bold">"Khusus BERKALA, WAJIB klik CHECK INFORMASI untuk mematikan data tahun lama!"</p>
                            </div>
                            <div class="md:w-64 bg-slate-100 p-4 rounded-2xl border-2 border-slate-300 shadow-lg relative flex justify-center">
                                <div class="bg-yellow-500 text-white px-6 py-2 rounded-xl text-[9px] font-bold shadow-md animate-bounce border-2 border-white uppercase italic">CHECK INFORMASI</div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[12px] border-r-yellow-500"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN: BANTUAN AI ANALIS (POSISI BAWAH) -->
                <div class="bg-indigo-900 text-white p-10 rounded-[4rem] shadow-xl relative overflow-hidden italic font-bold">
                    <div class="absolute -right-10 -bottom-10 opacity-10"><i class="fas fa-microchip text-[12rem]"></i></div>
                    <div class="relative z-10">
                        <h5 class="text-2xl font-bold mb-8 flex items-center gap-6 italic tracking-tighter uppercase underline decoration-4 decoration-indigo-700 underline-offset-8">
                            <i class="fas fa-magic text-indigo-300"></i> Bingung Klasifikasi? Tanya AI!
                        </h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                            <div class="space-y-6">
                                <div class="flex gap-5 items-start bg-white/5 p-5 rounded-2xl border-2 border-white/10 shadow-lg transition-all hover:bg-white/10">
                                    <span class="bg-indigo-500 text-white w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-lg shadow-xl">1</span>
                                    <p class="text-xs pt-1 uppercase tracking-widest italic">Klik tombol <span class="bg-indigo-600 border border-indigo-400 px-3 py-1 rounded-lg text-[9px]">TANYA PEDOMAN</span> di pojok kanan atas form.</p>
                                </div>
                                <div class="flex gap-5 items-start bg-white/5 p-5 rounded-2xl border-2 border-white/10 shadow-lg transition-all hover:bg-white/10">
                                    <span class="bg-indigo-500 text-white w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-lg shadow-xl">2</span>
                                    <p class="text-xs pt-1 italic uppercase tracking-tighter italic decoration-green-500 decoration-4">Ketik Nama Dokumen & Klik Tombol Hijau <span class="text-green-400 underline animate-pulse">TANYA AI</span>!</p>
                                </div>
                            </div>
                            <!-- Visual AI -->
                            <div class="bg-white/10 backdrop-blur-xl rounded-[3rem] p-8 border-2 border-white/10 shadow-2xl group">
                                <div class="bg-white rounded-3xl p-6 space-y-6 shadow-2xl relative transition-transform duration-700 group-hover:scale-105">
                                    <div class="h-3 w-32 bg-slate-100 rounded-full shadow-inner"></div>
                                    <div class="h-14 w-full border-2 border-slate-200 rounded-xl bg-slate-50 flex items-center px-5 text-sm text-slate-400 italic font-bold uppercase tracking-tighter shadow-inner">Laporan LRA Dinas...</div>
                                    <div class="flex justify-end relative mt-4">
                                        <div class="bg-green-600 text-white px-8 py-3 rounded-xl text-[10px] font-bold shadow-lg animate-bounce border-2 border-white">TANYA AI</div>
                                        <div class="absolute -left-6 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[12px] border-y-transparent border-r-[20px] border-r-indigo-500 drop-shadow-xl shadow-indigo-600"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Transparansi & Permohonan -->
            <div x-show="$store.pedomanAdminModal.activeTab === 2" x-transition class="space-y-8 uppercase font-bold italic tracking-tighter text-slate-800">
                <h4 class="text-xl font-bold border-l-4 border-green-600 pl-4 italic underline underline-offset-4">Alur Layanan Permohonan Informasi</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="bg-slate-900 rounded-3xl p-8 text-white relative overflow-hidden shadow-xl transition-all hover:scale-[1.02]">
                        <div class="absolute top-0 right-0 p-8 opacity-10"><i class="fas fa-file-import text-8xl"></i></div>
                        <h5 class="text-lg font-bold mb-6 flex items-center gap-3 italic uppercase underline decoration-indigo-500 decoration-4 underline-offset-8">Mengarahkan Pemohon</h5>
                        <div class="space-y-6 font-black">
                            <div class="flex gap-6 items-start bg-white/10 p-6 rounded-[2.5rem] border-2 border-white/20">
                                <span class="bg-green-500 text-white w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-lg shadow-lg">1</span>
                                <p class="text-sm tracking-widest pt-3 uppercase">Warga login ke portal PPID.</p>
                            </div>
                            <div class="flex gap-6 items-start bg-white/10 p-6 rounded-[2.5rem] border-2 border-white/20">
                                <span class="bg-green-500 text-white w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-lg shadow-lg">2</span>
                                <p class="text-sm tracking-widest pt-3 uppercase italic underline decoration-green-400 underline-offset-4">Menu Transparansi > Permohonan.</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border-4 border-slate-100 rounded-[3rem] p-10 shadow-xl relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-3 h-full bg-blue-600"></div>
                        <h5 class="text-lg font-bold text-slate-800 mb-8 flex items-center gap-3 uppercase italic underline decoration-blue-500 underline-offset-8 decoration-8">Admin Merespon</h5>
                        <div class="p-8 bg-blue-50 rounded-[3rem] border-4 border-blue-100 shadow-inner">
                            <ol class="text-xs text-slate-600 space-y-6 list-decimal list-inside font-bold italic tracking-tighter uppercase leading-relaxed">
                                <li class="bg-white p-3 rounded-xl border border-blue-200">Dashboard Permohonan.</li>
                                <li class="bg-white p-3 rounded-xl border border-blue-200">Cari status <span class="text-orange-600 underline uppercase italic">PENDING</span>.</li>
                                <li class="bg-white p-3 rounded-xl border border-blue-200 shadow-md border-2 border-blue-300">Tombol Biru <span class="text-blue-600">"PROSES / BALAS"</span>.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: PBJ -->
            <div x-show="$store.pedomanAdminModal.activeTab === 3" x-transition class="space-y-12 font-bold italic uppercase tracking-tighter text-slate-800">
                <h4 class="text-xl font-bold border-l-4 border-orange-600 pl-4 italic underline underline-offset-8">Panduan Khusus PBJ</h4>
                <div class="bg-orange-50 p-10 rounded-[4rem] border-4 border-orange-200 mb-10 flex gap-8 items-start shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5 rotate-12"><i class="fas fa-shopping-cart text-[10rem] text-orange-900"></i></div>
                    <div class="bg-orange-500 text-white p-10 rounded-[2rem] shadow-xl animate-bounce border-4 border-white flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-3xl"></i>
                    </div>
                    <div class="relative z-10 pt-2 space-y-4">
                        <h6 class="text-2xl font-bold text-orange-900 uppercase tracking-tighter italic underline decoration-orange-300 decoration-8 underline-offset-8 uppercase">WAJIB BAGI BAGIAN PBJ!</h6>
                        <p class="text-sm text-orange-800 leading-relaxed font-bold underline italic uppercase decoration-4 decoration-orange-100 underline-offset-8">"UPDATE DATA PAKET TENDER RUTIN SESUAI PROGRES FISIK!"</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="bg-slate-50 p-8 border-t-2 border-slate-100 flex flex-col md:flex-row gap-8 items-center justify-between flex-shrink-0 shadow-[0_-15px_60px_rgba(0,0,0,0.05)] relative z-50">
            <div class="flex items-center gap-6 text-slate-400 font-bold uppercase tracking-[0.4em] leading-tight text-[11px] italic">
                <div class="flex -space-x-5">
                    <img src="https://ui-avatars.com/api/?name=Admin+PPID&background=4f46e5&color=fff" class="w-16 h-16 rounded-full border-4 border-white shadow-xl">
                    <img src="https://ui-avatars.com/api/?name=Super+Admin&background=1e1b4b&color=fff" class="w-16 h-16 rounded-full border-4 border-white shadow-xl">
                </div>
                <div>Portal PPID v2.0 <br><span class="text-[9px] text-indigo-500 underline decoration-2 underline-offset-4 decoration-indigo-100">Dinas Kominfo Sinjai</span></div>
            </div>
            
            <div class="flex gap-6 w-full md:w-auto font-bold uppercase italic tracking-tighter">
                <button @click="$store.pedomanAdminModal.prevTab()" x-show="$store.pedomanAdminModal.activeTab > 0" class="px-10 py-4 bg-white text-slate-600 rounded-[1.5rem] border-2 border-slate-200 text-sm hover:bg-slate-100 transition-all flex items-center gap-4 shadow-xl active:scale-95 italic">
                    <i class="fas fa-arrow-left"></i> SEBELUMNYA
                </button>

                <button @click="$store.pedomanAdminModal.nextTab()" class="flex-1 md:flex-none px-20 py-4 bg-indigo-700 text-white rounded-[1.5rem] shadow-[0_30px_80px_rgba(67,56,202,0.4)] text-sm transition-all hover:bg-indigo-800 hover:scale-[1.1] active:scale-95 flex items-center justify-center gap-6 border-b-8 border-indigo-950 uppercase italic tracking-widest">
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
                class="w-14 h-14 bg-indigo-700 hover:bg-indigo-800 text-white rounded-full shadow-[0_20px_50px_rgba(67,56,202,0.4)] flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 group relative border-2 border-white p-4 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/5 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <i class="fas fa-chalkboard-teacher text-2xl group-hover:rotate-12 transition-transform"></i>
            <div class="absolute bottom-full right-0 mb-6 px-4 py-2 bg-indigo-950 text-white text-[10px] font-bold rounded-[1.5rem] opacity-0 group-hover:opacity-100 transition-all transform translate-y-6 group-hover:translate-y-0 whitespace-nowrap pointer-events-none shadow-2xl border-2 border-indigo-800 uppercase tracking-widest flex items-center gap-3 italic">
                <i class="fas fa-graduation-cap text-indigo-400 text-base animate-bounce"></i> Panduan Admin
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
