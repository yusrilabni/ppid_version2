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
        <div class="bg-slate-50 border-b border-slate-200 flex overflow-x-auto no-scrollbar scroll-smooth px-6 sticky top-0 z-50 shadow-md">
            <template x-for="(tab, index) in $store.pedomanAdminModal.tabs" :key="index">
                <button @click="$store.pedomanAdminModal.activeTab = index"
                        :class="$store.pedomanAdminModal.activeTab === index ? 'border-indigo-600 text-indigo-700 bg-white shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700'"
                        class="px-6 py-4 border-b-4 font-bold text-sm whitespace-nowrap transition-all flex items-center gap-2 min-h-[64px]">
                    <i :class="tab.icon"></i>
                    <span x-text="tab.title"></span>
                </button>
            </template>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-6 md:p-10 bg-white text-slate-800 font-medium">
            
            <!-- Tab 0: Menu Profil -->
            <div x-show="$store.pedomanAdminModal.activeTab === 0" x-transition class="space-y-12">
                <div class="flex items-center gap-4 border-l-4 border-indigo-600 pl-4 mb-6">
                    <h4 class="text-2xl font-bold text-slate-800 uppercase tracking-tighter">Pengelolaan Profil OPD & Pimpinan</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-6">
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 shadow-sm">
                            <h5 class="font-black text-indigo-700 mb-4 flex items-center gap-2 uppercase text-sm tracking-widest">
                                <span class="bg-indigo-100 w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span>
                                Struktur & Website OPD
                            </h5>
                            <ul class="space-y-4 text-xs text-slate-600 mb-6 font-bold leading-relaxed">
                                <li class="flex gap-3">
                                    <i class="fas fa-mouse-pointer text-indigo-500 mt-1"></i>
                                    <span>Klik menu <strong>Profil</strong> > <strong>Tentang OPD</strong></span>
                                </li>
                                <li class="flex gap-3">
                                    <i class="fas fa-search text-indigo-500 mt-1"></i>
                                    <span>Cari OPD Anda, lalu klik tombol <span class="bg-white text-blue-600 border border-blue-200 px-2 py-0.5 rounded shadow-sm text-[10px] font-black inline-flex items-center gap-1 uppercase tracking-tighter"><i class="fas fa-edit text-[8px]"></i> KELOLA PROFIL UNIT</span></span>
                                </li>
                                <li class="flex gap-3">
                                    <i class="fas fa-upload text-indigo-500 mt-1"></i>
                                    <span>Lengkapi form, lalu klik tombol <span class="bg-blue-600 text-white px-2 py-0.5 rounded shadow-sm text-[10px] font-bold inline-flex items-center gap-1 uppercase"><i class="fas fa-save text-[8px]"></i> SIMPAN PERUBAHAN</span>.</span>
                                </li>
                            </ul>

                            <div class="space-y-4 border-t pt-4">
                                <div class="flex flex-col md:flex-row gap-4 bg-white p-4 rounded-xl border border-slate-100 shadow-inner text-[10px] font-bold uppercase tracking-tighter">
                                    <div class="flex-1 text-slate-500">A. Upload Gambar Struktur (JPG/PNG).</div>
                                    <div class="md:w-32 bg-slate-50 p-2 rounded-lg border border-dashed border-slate-300 flex items-center justify-center relative">
                                        <i class="fas fa-sitemap text-slate-300 text-xs"></i>
                                        <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[4px] border-y-transparent border-r-[6px] border-r-indigo-500"></div>
                                    </div>
                                </div>
                                <div class="flex flex-col md:flex-row gap-4 bg-white p-4 rounded-xl border border-slate-100 shadow-inner text-[10px] font-bold uppercase tracking-tighter">
                                    <div class="flex-1 text-slate-500">B. Input URL Website Resmi.</div>
                                    <div class="md:w-32 bg-white border border-slate-200 rounded p-1 flex items-center relative text-[6px] text-indigo-400 font-black italic">
                                        https://...
                                        <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[4px] border-y-transparent border-r-[6px] border-r-indigo-500"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 shadow-sm">
                            <h5 class="font-black text-indigo-700 mb-4 flex items-center gap-2 uppercase text-sm tracking-widest">
                                <span class="bg-indigo-100 w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span>
                                Data Pimpinan & Pejabat
                            </h5>
                            <ul class="space-y-4 text-xs text-slate-600 mb-6 font-bold leading-relaxed">
                                <li class="flex gap-3">
                                    <i class="fas fa-mouse-pointer text-indigo-500 mt-1"></i>
                                    <span>Klik menu <strong>Profil</strong> > <strong>Pejabat Daerah</strong> atau <strong>Unit Lokal</strong></span>
                                </li>
                                <li class="flex gap-3">
                                    <i class="fas fa-edit text-indigo-500 mt-1"></i>
                                    <span>Cari nama pimpinan, klik tombol <span class="bg-amber-500 text-white px-2 py-0.5 rounded shadow-sm text-[10px] font-black inline-flex items-center gap-1 uppercase tracking-tighter"><i class="fas fa-pencil-alt text-[8px]"></i> KELOLA PIMPINAN</span>.</span>
                                </li>
                                <li class="flex gap-3 text-amber-700 font-black bg-amber-100/50 p-3 rounded-xl border-2 border-amber-200 text-[10px] uppercase tracking-tighter">
                                    <i class="fas fa-info-circle mt-0.5 text-base"></i>
                                    <span>Wajib Isi: Tab Identitas (Nama Lengkap + Gelar & Status Aktif). Tab Riwayat/Award OPSIONAL.</span>
                                </li>
                            </ul>

                            <div class="space-y-4 border-t pt-4">
                                <div class="bg-white p-4 rounded-xl border border-slate-200 space-y-3 shadow-inner relative overflow-hidden font-black uppercase tracking-tighter text-slate-700 text-[10px]">
                                    <div class="absolute top-0 right-0 p-2 opacity-5 rotate-12"><i class="fas fa-user-tie text-4xl text-indigo-900"></i></div>
                                    <div class="flex items-center gap-3">
                                        <div class="bg-indigo-600 text-white w-5 h-5 rounded-full flex items-center justify-center font-black shadow-lg shadow-indigo-200 text-[10px]">A</div>
                                        <p>Nama Lengkap + Gelar (Dr. Nama, M.Si)</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="bg-indigo-600 text-white w-5 h-5 rounded-full flex items-center justify-center font-black shadow-lg shadow-indigo-200 text-[10px]">B</div>
                                        <p>Status disetel ke: <span class="text-green-600 underline italic">AKTIF</span></p>
                                    </div>
                                    <div class="flex justify-center pt-3 text-[10px] font-black uppercase tracking-widest border-2 border-white">
                                        <div class="bg-blue-600 text-white px-6 py-2 rounded-xl shadow-xl shadow-blue-300 animate-bounce">SIMPAN PROFIL</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 1: Jenis Informasi -->
            <div x-show="$store.pedomanAdminModal.activeTab === 1" x-transition class="space-y-16 text-slate-800 font-bold uppercase tracking-tighter">
                <div class="flex items-center gap-4 border-l-4 border-blue-600 pl-4 mb-6">
                    <h4 class="text-2xl font-bold italic tracking-tight uppercase">Logika Klasifikasi & Standar Dokumen PPID</h4>
                </div>

                <!-- BAGIAN: LOGIKA MENDALAM (WHY) -->
                <div class="space-y-10 font-black">
                    <h5 class="text-xl font-black text-slate-800 flex items-center gap-3 border-b-4 border-blue-100 pb-3">
                        <i class="fas fa-balance-scale text-blue-600 text-2xl"></i> Mengapa Dokumen Harus Diklasifikasikan?
                    </h5>
                    
                    <div class="grid grid-cols-1 gap-12 text-sm text-slate-700 leading-relaxed uppercase">
                        <!-- BERKALA -->
                        <div class="bg-blue-50 p-12 rounded-[4rem] border-2 border-blue-200 relative overflow-hidden shadow-sm">
                            <div class="absolute top-0 right-0 p-12 opacity-5"><i class="fas fa-history text-[10rem] text-blue-900"></i></div>
                            <h6 class="font-black text-blue-900 mb-6 uppercase tracking-[0.2em] flex items-center gap-3 text-xl italic underline decoration-blue-200">
                                <i class="fas fa-calendar-alt"></i> 1. Informasi Berkala (Kewajiban Rutin)
                            </h6>
                            <p class="mb-8 text-base text-justify">Sebuah dokumen diklasifikasikan sebagai <strong>Informasi Berkala</strong> berdasarkan Pasal 9 UU KIP karena merupakan <strong>Representasi Kewajiban Akuntabilitas Rutin</strong>. Dokumen ini wajib ada dan diperbarui secara proaktif sesuai siklus anggaran. Karena sifatnya rutin, maka data terbaru (2024) otomatis menggantikan validitas data lama (2023). Data lama <strong>WAJIB DIARSIPKAN</strong> menggunakan fitur Check Informasi!</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-[11px] leading-relaxed">
                                <div class="bg-white/80 p-8 rounded-[2.5rem] border-2 border-blue-100 shadow-xl">
                                    <p class="font-black text-blue-800 mb-3 text-xs uppercase tracking-widest border-b pb-2">Logika Dokumen Rutin:</p>
                                    <p>Dokumen yang memiliki <strong>Siklus Waktu Tetap</strong> (seperti Renstra, Anggaran, atau Laporan Kinerja) diklasifikasikan sebagai <strong>BERKALA</strong>.</p>
                                </div>
                                <div class="bg-white/80 p-8 rounded-[2.5rem] border-2 border-blue-100 shadow-xl text-red-700">
                                    <p class="font-black mb-3 text-xs uppercase tracking-widest border-b border-red-100 pb-2">Logika Update Terkini:</p>
                                    <p>Data terbaru membatalkan validitas data lama. Data lama WAJIB DIARSIPKAN agar publik tidak salah ambil referensi!</p>
                                </div>
                            </div>
                        </div>

                        <!-- SETIAP SAAT -->
                        <div class="bg-emerald-50 p-12 rounded-[4rem] border-2 border-emerald-200 relative overflow-hidden shadow-sm text-emerald-900">
                            <div class="absolute top-0 right-0 p-12 opacity-5"><i class="fas fa-folder-open text-[10rem] text-emerald-900"></i></div>
                            <h6 class="font-black mb-6 uppercase tracking-[0.2em] flex items-center gap-3 text-xl italic underline decoration-emerald-200">
                                <i class="fas fa-archive"></i> 2. Informasi Setiap Saat (Catatan Sejarah)
                            </h6>
                            <p class="mb-8 text-base text-justify">Dokumen masuk kategori <strong>Informasi Setiap Saat</strong> berdasarkan Pasal 11 UU KIP karena merupakan <strong>Catatan Histori & Produk Kebijakan</strong>. Dokumen ini tidak terikat jadwal rutin, namun wajib sedia lengkap di database jika sewaktu-waktu ada pemohon yang meminta. Sifatnya <strong>Akumulatif (Menumpuk)</strong>. Semua data tahun lama tetap BERLAKU sebagai database sejarah kebijakan unit Bapak.</p>
                        </div>
                    </div>
                </div>

                <!-- TUTORIAL FORM A - H -->
                <div class="space-y-12">
                    <h5 class="text-2xl font-black text-slate-800 uppercase tracking-tighter italic border-b-4 border-slate-100 pb-4 flex items-center gap-4">
                        <i class="fas fa-keyboard text-indigo-600"></i> Tutorial Pengisian Formulir (A - H)
                    </h5>
                    <div class="bg-slate-50 rounded-[5rem] border-4 border-slate-200 p-12 space-y-20 shadow-inner relative overflow-hidden">
                        <!-- Poin tutorial form tetap ada dengan detail visual yang sama -->
                        <!-- A: JUDUL -->
                        <div class="flex flex-col md:flex-row gap-12 items-start font-black">
                            <div class="flex-1">
                                <div class="flex gap-6 mb-6">
                                    <span class="w-14 h-14 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-2xl shadow-xl">A</span>
                                    <h6 class="text-2xl font-black text-slate-800 mt-2 uppercase tracking-tighter">Judul Informasi</h6>
                                </div>
                                <p class="text-base text-slate-600 ml-20 italic underline text-indigo-700">Format Wajib: Nama Dokumen + Unit + Tahun. <br>Contoh: "Renja Dinas Perumahan 2024".</p>
                            </div>
                            <div class="md:w-80 bg-white p-5 rounded-3xl border-2 border-slate-200 shadow-xl relative">
                                <div class="h-12 w-full border-4 border-indigo-200 rounded-2xl bg-indigo-50/50 flex items-center px-5 text-[10px] text-indigo-400 font-black italic uppercase italic tracking-tighter">Renja Dinas Perumahan 2024...</div>
                                <div class="absolute -left-6 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[12px] border-y-transparent border-r-[18px] border-r-indigo-600 shadow-2xl"></div>
                            </div>
                        </div>
                        <!-- B: DESKRIPSI & PELENGKAP -->
                        <div class="flex flex-col md:flex-row gap-12 items-start font-black">
                            <div class="flex-1">
                                <div class="flex gap-6 mb-6">
                                    <span class="w-14 h-14 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-2xl shadow-xl">B</span>
                                    <h6 class="text-2xl font-black text-slate-800 mt-2 uppercase tracking-tighter">Deskripsi & Lampiran</h6>
                                </div>
                                <div class="ml-20 space-y-8">
                                    <p class="text-base text-slate-600">Berikan ringkasan isi dokumen bagi masyarakat.</p>
                                    <div class="bg-amber-100 p-8 rounded-[3rem] border-4 border-amber-300 shadow-xl relative overflow-hidden italic text-amber-900 text-xs">
                                        <div class="absolute top-0 right-0 p-6 opacity-10"><i class="fas fa-file-pdf text-6xl"></i></div>
                                        <h6 class="font-black uppercase mb-4 underline italic">Dokumen Pelengkap (WAJIB):</h6>
                                        <p class="leading-loose uppercase tracking-tighter font-black">"Jika laporan Bapak memiliki lampiran banyak (LRA + Lampiran A-Z), wajib GABUNGKAN DALAM 1 PDF atau gunakan opsi Link File Google Drive!"</p>
                                    </div>
                                </div>
                            </div>
                            <div class="md:w-80 bg-white p-5 rounded-3xl border-2 border-slate-200 shadow-xl relative overflow-hidden h-32">
                                <div class="h-full w-full bg-slate-50 rounded-2xl shadow-inner border-2 p-4 gap-3 flex flex-col">
                                    <div class="h-2 w-full bg-slate-200 rounded"></div>
                                    <div class="h-2 w-full bg-slate-200 rounded"></div>
                                    <div class="h-2 w-1/2 bg-slate-200 rounded"></div>
                                </div>
                                <div class="absolute -left-6 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[12px] border-y-transparent border-r-[18px] border-r-indigo-600 shadow-2xl"></div>
                            </div>
                        </div>
                        <!-- C: KATEGORI & UNIT -->
                        <div class="flex flex-col md:flex-row gap-12 items-start font-black uppercase text-slate-700">
                            <div class="flex-1">
                                <div class="flex gap-6 mb-6">
                                    <span class="w-14 h-14 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-2xl shadow-xl">C</span>
                                    <h6 class="text-2xl font-black text-slate-800 mt-2 uppercase tracking-tighter">Kategori & Unit Kerja</h6>
                                </div>
                                <p class="text-base leading-relaxed ml-20 italic">"Pilih Kategori yang tepat. Unit kerja otomatis terkunci sesuai login akun Bapak."</p>
                            </div>
                            <div class="md:w-80 space-y-4 relative">
                                <div class="bg-white p-4 rounded-2xl border-2 border-slate-200 shadow-md flex justify-between items-center text-[10px] font-black uppercase text-slate-700">INFORMASI BERKALA <i class="fas fa-chevron-down"></i></div>
                                <div class="bg-slate-200 p-4 rounded-2xl border-2 border-slate-300 opacity-60 text-[10px] italic font-black uppercase text-slate-500 tracking-widest shadow-inner">Unit Terkunci...</div>
                                <div class="absolute -left-6 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[12px] border-y-transparent border-r-[18px] border-r-indigo-600 shadow-2xl"></div>
                            </div>
                        </div>
                        <!-- D: JENIS DOKUMEN -->
                        <div class="flex flex-col md:flex-row gap-12 items-start font-black">
                            <div class="flex-1">
                                <div class="flex gap-6 mb-6 text-slate-800">
                                    <span class="w-14 h-14 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-2xl shadow-xl">D</span>
                                    <h6 class="text-2xl font-black mt-2 uppercase tracking-tighter">Jenis Dokumen</h6>
                                </div>
                                <p class="text-base leading-relaxed ml-20 italic text-blue-700 underline underline-offset-8">"Pilih klasifikasi yang tepat (misal: Dokumen Keuangan) agar data Bapak muncul otomatis di folder yang tepat!"</p>
                            </div>
                            <div class="md:w-80 bg-white p-6 rounded-[2.5rem] border-8 border-blue-200 shadow-xl relative">
                                <div class="h-14 w-full border-2 border-blue-400 rounded-2xl bg-blue-50 flex items-center px-6 justify-between text-xs text-blue-700 font-black italic uppercase tracking-widest shadow-inner">Info Keuangan <i class="fas fa-check-double text-blue-600 text-xl"></i></div>
                                <div class="absolute -left-10 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[20px] border-y-transparent border-r-[35px] border-r-indigo-600 shadow-2xl"></div>
                            </div>
                        </div>
                        <!-- E - H (Ringkas) -->
                        <div class="flex flex-col md:flex-row gap-12 items-start font-black">
                            <div class="flex-1">
                                <div class="flex gap-6 mb-6 text-slate-800">
                                    <span class="w-14 h-14 bg-blue-600 text-white rounded-full flex items-center justify-center font-black text-2xl shadow-xl animate-bounce">H</span>
                                    <h6 class="text-2xl font-black mt-2 uppercase tracking-tighter italic underline decoration-8 decoration-blue-100">Check & Simpan</h6>
                                </div>
                                <p class="text-base leading-relaxed ml-20 italic text-blue-700 uppercase tracking-tighter font-black">"Khusus BERKALA, WAJIB klik CHECK INFORMASI untuk mematikan data tahun lalu secara otomatis!"</p>
                            </div>
                            <div class="md:w-80 bg-slate-100 p-8 rounded-[3rem] border-8 border-slate-300 shadow-2xl relative flex justify-center group hover:bg-white transition-colors duration-500">
                                <div class="bg-yellow-500 text-white px-10 py-5 rounded-[2.5rem] text-sm font-black shadow-[0_25px_60px_rgba(234,179,8,0.5)] animate-bounce uppercase border-[6px] border-white italic">CHECK INFORMASI</div>
                                <div class="absolute -left-12 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[25px] border-y-transparent border-r-[45px] border-r-yellow-500 shadow-2xl"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN: BANTUAN AI ANALIS (SETELAH TUTORIAL) -->
                <div class="bg-indigo-900 text-white p-16 rounded-[6rem] shadow-2xl relative overflow-hidden italic font-black">
                    <div class="absolute -right-10 -bottom-10 opacity-10"><i class="fas fa-microchip text-[18rem]"></i></div>
                    <div class="relative z-10">
                        <h5 class="text-4xl font-black mb-12 flex items-center gap-10 italic tracking-tighter uppercase underline decoration-8 decoration-indigo-700 underline-offset-8">
                            <i class="fas fa-magic text-indigo-300 text-6xl"></i> Bingung Klasifikasi? Tanya AI!
                        </h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-20 items-center">
                            <div class="space-y-12">
                                <div class="flex gap-8 items-start bg-white/5 p-8 rounded-[3rem] border-4 border-white/10 shadow-2xl transition-all hover:bg-white/10 hover:-translate-y-2">
                                    <span class="bg-indigo-500 text-white w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center font-black text-xl shadow-xl shadow-indigo-900/50">1</span>
                                    <p class="text-lg text-indigo-100 leading-relaxed pt-2 uppercase tracking-tighter italic">Klik tombol <span class="bg-indigo-600 border-2 border-indigo-400 px-4 py-1.5 rounded-xl text-xs">TANYA PEDOMAN</span> di pojok kanan atas form.</p>
                                </div>
                                <div class="flex gap-8 items-start bg-white/5 p-8 rounded-[3rem] border-4 border-white/10 shadow-2xl transition-all hover:bg-white/10 hover:-translate-y-2">
                                    <span class="bg-indigo-500 text-white w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center font-black text-xl shadow-xl shadow-indigo-900/50">2</span>
                                    <p class="text-lg text-indigo-100 leading-relaxed pt-2 uppercase tracking-tighter italic">Ketik Nama Dokumen Bapak (Contoh: "Laporan Neraca Unit").</p>
                                </div>
                                <div class="flex gap-8 items-start bg-white/5 p-8 rounded-[3rem] border-4 border-white/10 shadow-2xl transition-all hover:bg-white/10 hover:-translate-y-2">
                                    <span class="bg-indigo-500 text-white w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center font-black text-xl shadow-xl shadow-indigo-900/50">3</span>
                                    <p class="text-lg text-indigo-100 leading-relaxed pt-2 uppercase tracking-tighter italic">Klik Tombol Hijau <span class="bg-green-600 px-5 py-2 rounded-2xl animate-pulse">TANYA AI</span>!</p>
                                </div>
                            </div>
                            <!-- Visual AI (ULTRA LARGE) -->
                            <div class="bg-white/10 backdrop-blur-3xl rounded-[5rem] p-16 border-4 border-white/20 shadow-2xl relative overflow-hidden group">
                                <div class="bg-white rounded-[4rem] p-16 space-y-12 shadow-3xl relative z-10 transition-transform duration-1000 group-hover:scale-110">
                                    <div class="h-6 w-64 bg-slate-100 rounded-full mb-10 shadow-inner"></div>
                                    <div class="h-24 w-full border-8 border-slate-200 rounded-[2.5rem] bg-slate-50 flex items-center px-12 text-2xl text-slate-400 italic font-black uppercase tracking-tighter shadow-inner">Laporan Neraca Keuangan...</div>
                                    <div class="flex justify-end relative mt-10 text-[10px] font-black uppercase italic tracking-[0.3em]">
                                        <div class="bg-green-600 text-white px-16 py-8 rounded-[2.5rem] text-xl font-black shadow-[0_30px_100px_rgba(22,163,74,0.6)] animate-bounce border-8 border-white">TANYA AI</div>
                                        <div class="absolute -left-16 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[30px] border-y-transparent border-r-[60px] border-r-indigo-500 drop-shadow-3xl shadow-indigo-600"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Transparansi & Permohonan -->
            <div x-show="$store.pedomanAdminModal.activeTab === 2" x-transition class="space-y-8 uppercase font-black">
                <div class="flex items-center gap-4 border-l-4 border-green-600 pl-4 mb-6">
                    <h4 class="text-2xl font-bold text-slate-800 italic underline tracking-tighter">Alur Layanan Permohonan Informasi</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="bg-slate-900 rounded-3xl p-8 text-white relative overflow-hidden shadow-2xl transition-transform hover:scale-[1.02]">
                        <div class="absolute top-0 right-0 p-8 opacity-10"><i class="fas fa-file-import text-9xl"></i></div>
                        <h5 class="text-xl font-bold mb-6 flex items-center gap-3 italic uppercase underline decoration-indigo-500 decoration-4">Mengarahkan Pemohon</h5>
                        <div class="space-y-8">
                            <div class="flex gap-6 items-start bg-white/10 p-5 rounded-[2rem] border-2 border-white/20">
                                <span class="bg-green-500 text-white w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center font-black text-xl shadow-lg">1</span>
                                <p class="text-sm tracking-widest leading-relaxed pt-2 italic">Minta warga login ke portal PPID (Gunakan Akun Google).</p>
                            </div>
                            <div class="flex gap-6 items-start bg-white/10 p-5 rounded-[2rem] border-2 border-white/20">
                                <span class="bg-green-500 text-white w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center font-black text-xl shadow-lg">2</span>
                                <p class="text-sm tracking-widest leading-relaxed pt-2 italic">Arahkan ke menu <strong>Transparansi</strong> > <strong>Permohonan</strong>.</p>
                            </div>
                            <div class="flex gap-6 items-start bg-white/10 p-5 rounded-[2rem] border-2 border-white/20">
                                <span class="bg-green-500 text-white w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center font-black text-xl shadow-lg">3</span>
                                <p class="text-sm tracking-widest leading-relaxed pt-2 italic">Isi Formulir Lengkap & Klik tombol <span class="text-green-400 underline uppercase tracking-widest">BUAT PERMOHONAN</span>.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border-4 border-slate-100 rounded-[3rem] p-10 shadow-xl relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-3 h-full bg-blue-600"></div>
                        <h5 class="text-xl font-bold text-slate-800 mb-8 flex items-center gap-3 uppercase italic underline decoration-blue-500 decoration-8">Tugas Admin (Merespon)</h5>
                        <div class="space-y-6">
                            <div class="p-8 bg-blue-50 rounded-[3rem] border-4 border-blue-100 shadow-inner">
                                <p class="text-base font-black text-blue-800 mb-6 underline italic uppercase tracking-widest decoration-4">Langkah Pengiriman Jawaban:</p>
                                <ol class="text-xs text-slate-600 space-y-6 list-decimal list-inside font-black italic tracking-tighter uppercase leading-loose">
                                    <li class="bg-white p-3 rounded-xl border border-blue-200">Masuk ke Dashboard Admin Permohonan.</li>
                                    <li class="bg-white p-3 rounded-xl border border-blue-200">Cari status <span class="text-orange-600 underline">PENDING</span>.</li>
                                    <li class="bg-white p-3 rounded-xl border border-blue-200">Klik tombol biru <span class="text-blue-600 font-black italic">"PROSES / BALAS"</span>.</li>
                                    <li class="bg-white p-3 rounded-xl border border-blue-200">Tulis Jawaban & Upload File / Paste URL Jawaban.</li>
                                    <li class="bg-white p-3 rounded-xl border border-blue-200 shadow-lg">Klik KIRIM JAWABAN. Status akan jadi <span class="text-green-600 underline italic">SELESAI</span>.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: PBJ -->
            <div x-show="$store.pedomanAdminModal.activeTab === 3" x-transition class="space-y-12 font-black italic uppercase">
                <div class="flex items-center gap-4 border-l-4 border-orange-600 pl-4 mb-6">
                    <h4 class="text-2xl font-black text-slate-800 tracking-tight italic underline decoration-8 decoration-orange-100">Panduan Khusus PBJ (PU & Sekretariat)</h4>
                </div>

                <div class="bg-orange-50 p-12 rounded-[5rem] border-8 border-orange-100 mb-12 flex gap-10 items-start shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5 rotate-12"><i class="fas fa-shopping-cart text-[12rem] text-orange-900"></i></div>
                    <div class="bg-orange-500 text-white p-10 rounded-[4rem] shadow-2xl animate-bounce relative z-10 border-8 border-white flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-5xl"></i>
                    </div>
                    <div class="relative z-10 space-y-4 pt-4">
                        <h6 class="text-3xl font-black text-orange-900 uppercase tracking-tighter italic underline decoration-orange-300">Penting Bagi Bagian PBJ!</h6>
                        <p class="text-lg text-orange-800 leading-relaxed font-black underline italic uppercase decoration-2 tracking-tighter">"Data Paket Tender Wajib Diupdate Rutin Setiap Kali Ada Perubahan Progres Kontrak Fisik!"</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-20">
                    <div class="space-y-10">
                        <h5 class="font-black flex items-center gap-6 text-2xl text-slate-800 uppercase tracking-widest border-b-8 border-orange-50 pb-6 italic">
                            <i class="fas fa-shopping-cart text-orange-500 text-4xl"></i> Alur Input Data
                        </h5>
                        <ul class="text-base space-y-12 font-black italic">
                            <li class="p-12 bg-white border-8 border-slate-100 rounded-[5rem] shadow-2xl flex gap-8 items-center transition-all hover:scale-105 hover:border-orange-200 group">
                                <span class="text-orange-500 font-black text-6xl italic tracking-tighter group-hover:scale-125 transition-transform">01.</span>
                                <span class="text-base uppercase tracking-tighter font-black">Klik menu <strong>PBJ</strong> > <strong>Input Paket</strong>. Masukkan Pagu & Nama Pemenang.</span>
                            </li>
                        </ul>
                    </div>
                    <div class="space-y-10">
                        <h5 class="font-black flex items-center gap-6 text-2xl text-slate-800 uppercase tracking-widest border-b-8 border-orange-50 pb-6 italic italic">
                            <i class="fas fa-file-pdf text-orange-500 text-4xl"></i> Dokumen Pendukung
                        </h5>
                        <div class="p-10 bg-slate-50 border-8 border-slate-200 rounded-[5rem] shadow-2xl italic">
                            <p class="text-xs text-slate-500 mb-10 italic font-black uppercase tracking-widest text-center border-b-4 pb-4 border-slate-200">Daftar Dokumen Wajib Paket Tender:</p>
                            <ul class="text-sm space-y-8 font-black text-slate-700 uppercase tracking-tighter">
                                <li class="flex items-center gap-6 transition-all hover:translate-x-4"><i class="fas fa-check-circle text-green-500 text-3xl"></i> <span>Rencana Umum Pengadaan (RUP)</span></li>
                                <li class="flex items-center gap-6 transition-all hover:translate-x-4"><i class="fas fa-check-circle text-green-500 text-3xl"></i> <span>Kerangka Acuan Kerja (KAK)</span></li>
                                <li class="flex items-center gap-6 transition-all hover:translate-x-4"><i class="fas fa-check-circle text-green-500 text-3xl"></i> <span>Ringkasan Kontrak Kerja</span></li>
                                <li class="flex items-center gap-6 transition-all hover:translate-x-4"><i class="fas fa-check-circle text-green-500 text-3xl"></i> <span>Berita Acara Serah Terima (BAST)</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="bg-slate-50 p-10 border-t-4 border-slate-100 flex flex-col md:flex-row gap-10 items-center justify-between flex-shrink-0 shadow-[0_-15px_60px_rgba(0,0,0,0.1)] relative z-50">
            <div class="flex items-center gap-8">
                <div class="flex -space-x-6">
                    <img src="https://ui-avatars.com/api/?name=Admin+PPID&background=4f46e5&color=fff" class="w-20 h-20 rounded-full border-8 border-white shadow-2xl">
                    <img src="https://ui-avatars.com/api/?name=Super+Admin&background=1e1b4b&color=fff" class="w-20 h-20 rounded-full border-8 border-white shadow-2xl">
                </div>
                <div class="text-[14px] text-slate-400 font-black uppercase tracking-[0.5em] leading-tight italic">
                    Portal PPID v2.0 <br><span class="text-[11px] font-black text-indigo-500 italic underline decoration-4 decoration-indigo-100">Dinas Kominfo & Persandian Sinjai</span>
                </div>
            </div>
            
            <div class="flex gap-8 w-full md:w-auto">
                <button @click="$store.pedomanAdminModal.prevTab()" 
                        x-show="$store.pedomanAdminModal.activeTab > 0"
                        class="px-14 py-6 bg-white text-slate-600 font-black rounded-[2.5rem] border-4 border-slate-200 text-base hover:bg-slate-100 transition-all flex items-center gap-6 shadow-3xl hover:-translate-x-4 active:scale-95 italic">
                    <i class="fas fa-arrow-left"></i> SEBELUMNYA
                </button>

                <button @click="$store.pedomanAdminModal.nextTab()" 
                        class="flex-1 md:flex-none px-28 py-6 bg-indigo-700 text-white font-black rounded-[2.5rem] shadow-[0_40px_100px_rgba(67,56,202,0.5)] text-base transition-all hover:bg-indigo-800 hover:scale-[1.1] active:scale-95 flex items-center justify-center gap-8 border-b-[12px] border-indigo-950 uppercase italic tracking-widest">
                    <span x-text="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'SAYA MENGERTI, TUTUP PANDUAN' : 'LANJUT KE LANGKAH BERIKUTNYA'"></span>
                    <i :class="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'fas fa-check-double' : 'fas fa-arrow-right'"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin'))
    <div class="fixed z-[105] bottom-6 right-6" x-data x-cloak>
        <button @click="$store.pedomanAdminModal.show()" 
                class="w-24 h-24 bg-indigo-700 hover:bg-indigo-800 text-white rounded-full shadow-[0_40px_100px_rgba(67,56,202,0.6)] flex items-center justify-center transition-all duration-500 hover:scale-110 active:scale-90 group relative border-4 border-white p-8 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/10 to-white/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <i class="fas fa-chalkboard-teacher text-5xl"></i>
            <div class="absolute bottom-full right-0 mb-12 px-10 py-6 bg-indigo-950 text-white text-[16px] font-black rounded-[3rem] opacity-0 group-hover:opacity-100 transition-all transform translate-y-12 group-hover:translate-y-0 whitespace-nowrap pointer-events-none shadow-[0_50px_120px_rgba(0,0,0,0.6)] border-4 border-indigo-800 uppercase tracking-[0.5em] flex items-center gap-8 italic underline decoration-8 decoration-indigo-700">
                <i class="fas fa-graduation-cap text-indigo-400 text-4xl animate-bounce"></i> Panduan Operasional Admin
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
