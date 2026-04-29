<!-- Pedoman Admin Modal - Updated: 2024-04-29 16:15 -->
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
        <div class="flex-1 overflow-y-auto p-6 md:p-10 bg-white">
            
            <!-- Tab 0: Menu Profil -->
            <div x-show="$store.pedomanAdminModal.activeTab === 0" x-transition class="space-y-12">
                <div class="flex items-center gap-4 border-l-4 border-indigo-600 pl-4 mb-6">
                    <h4 class="text-2xl font-bold text-slate-800">Pengelolaan Profil OPD & Pimpinan</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-6">
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 shadow-sm">
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
                                <div class="flex flex-col md:flex-row gap-4 bg-white p-4 rounded-xl border border-slate-100 shadow-inner">
                                    <div class="flex-1 text-[11px] text-slate-500 font-medium">A. Upload Gambar Struktur Organisasi (JPG/PNG).</div>
                                    <div class="md:w-32 bg-slate-50 p-2 rounded-lg border border-dashed border-slate-300 flex items-center justify-center relative">
                                        <i class="fas fa-sitemap text-slate-300 text-xs"></i>
                                        <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[4px] border-y-transparent border-r-[6px] border-r-indigo-500"></div>
                                    </div>
                                </div>
                                <div class="flex flex-col md:flex-row gap-4 bg-white p-4 rounded-xl border border-slate-100 shadow-inner">
                                    <div class="flex-1 text-[11px] text-slate-500 font-medium">B. Input URL Website Resmi Instansi.</div>
                                    <div class="md:w-32 bg-white border border-slate-200 rounded p-1 flex items-center relative">
                                        <span class="text-[6px] text-indigo-400 font-bold px-1 uppercase tracking-tighter italic">https://...</span>
                                        <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[4px] border-y-transparent border-r-[6px] border-r-indigo-500"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 shadow-sm">
                            <h5 class="font-bold text-indigo-700 mb-4 flex items-center gap-2">
                                <span class="bg-indigo-100 w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span>
                                Mengelola Data Pimpinan
                            </h5>
                            <ul class="space-y-4 text-sm text-slate-600 mb-6">
                                <li class="flex gap-3">
                                    <i class="fas fa-mouse-pointer text-indigo-500 mt-1"></i>
                                    <span>Klik menu <strong>Profil</strong> > <strong>Pejabat Daerah</strong> (OPD) atau <strong>Unit Lokal</strong> (Desa/Kel)</span>
                                </li>
                                <li class="flex gap-3">
                                    <i class="fas fa-edit text-indigo-500 mt-1"></i>
                                    <span>Cari nama pimpinan, klik tombol <span class="bg-amber-500 text-white px-2 py-0.5 rounded shadow-sm text-[10px] font-bold inline-flex items-center gap-1 uppercase tracking-tighter"><i class="fas fa-pencil-alt text-[8px]"></i> KELOLA PIMPINAN</span>.</span>
                                </li>
                                <li class="flex gap-3 text-amber-700 font-bold bg-amber-100/50 p-2 rounded-xl border border-amber-200">
                                    <i class="fas fa-info-circle mt-0.5 text-sm"></i>
                                    <span class="text-xs uppercase tracking-tighter">Cukup isi Tab Identitas (Wajib *). Tab Biografi, Riwayat & Penghargaan bersifat Opsional.</span>
                                </li>
                            </ul>

                            <div class="space-y-4">
                                <div class="bg-white p-4 rounded-xl border border-slate-200 space-y-3 shadow-inner">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-indigo-600 text-white w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold">A</div>
                                        <p class="text-[10px] font-bold text-slate-700">Nama Lengkap Beserta Gelar (Contoh: Dr. Nama, M.Si)</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="bg-indigo-600 text-white w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold">B</div>
                                        <p class="text-[10px] font-bold text-slate-700">Status Jabatan disetel ke: <span class="text-green-600 font-black uppercase">Aktif</span></p>
                                    </div>
                                    <div class="flex justify-center pt-2">
                                        <div class="bg-blue-600 text-white px-5 py-2 rounded-xl text-[9px] font-black shadow-lg shadow-blue-300 animate-bounce uppercase">SIMPAN PROFIL</div>
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
                    <h4 class="text-2xl font-bold">Logika Klasifikasi & Panduan Operasional Informasi</h4>
                </div>

                <!-- BAGIAN: PENJELASAN UMUM (LOGIKA KLASIFIKASI) -->
                <div class="space-y-8">
                    <h5 class="text-xl font-black text-slate-800 flex items-center gap-3 border-b-2 pb-2">
                        <i class="fas fa-info-circle text-blue-600"></i> Logika Dasar Klasifikasi Informasi
                    </h5>
                    
                    <div class="space-y-8 text-sm text-slate-700 leading-relaxed">
                        <!-- BERKALA -->
                        <div class="bg-blue-50 p-8 rounded-[2.5rem] border border-blue-200 relative overflow-hidden shadow-sm">
                            <div class="absolute top-0 right-0 p-8 opacity-5"><i class="fas fa-sync-alt text-9xl text-blue-900"></i></div>
                            <h6 class="font-black text-blue-900 mb-4 uppercase tracking-widest flex items-center gap-2 text-base">
                                <i class="fas fa-calendar-check"></i> 1. Mengapa "Informasi Berkala"?
                            </h6>
                            <p class="mb-4">Sebuah dokumen diklasifikasikan sebagai <strong>Informasi Berkala</strong> karena dokumen tersebut merupakan <strong>Kewajiban Rutin</strong> yang wajib diterbitkan secara terjadwal (tahunan/semesteran) tanpa harus ada yang memohon. Dokumen ini adalah "Wajah Anggaran & Kinerja" unit kerja Bapak.</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white/60 p-4 rounded-2xl border border-blue-100 text-xs">
                                    <p class="font-black text-blue-700 mb-1 italic">Logika Dokumen Rutin:</p>
                                    <p class="text-slate-600">Dokumen yang memiliki <strong>Siklus Waktu Tetap</strong> (seperti Rencana Strategis, Anggaran, atau Laporan Kinerja) diklasifikasikan sebagai <strong>BERKALA</strong> karena wajib ada di setiap periode tertentu.</p>
                                </div>
                                <div class="bg-white/60 p-4 rounded-2xl border border-blue-100 text-xs">
                                    <p class="font-black text-blue-700 mb-1 italic">Logika Update Data:</p>
                                    <p class="text-slate-600">Karena sifatnya rutin, maka data terbaru (misal: Laporan 2024) otomatis membatalkan validitas data lama (Laporan 2023) sebagai informasi publik utama.</p>
                                </div>
                            </div>
                        </div>

                        <!-- SETIAP SAAT -->
                        <div class="bg-emerald-50 p-8 rounded-[2.5rem] border border-emerald-200 relative overflow-hidden shadow-sm">
                            <div class="absolute top-0 right-0 p-8 opacity-5"><i class="fas fa-layer-group text-9xl text-emerald-900"></i></div>
                            <h6 class="font-black text-emerald-900 mb-4 uppercase tracking-widest flex items-center gap-2 text-base">
                                <i class="fas fa-archive"></i> 2. Mengapa "Informasi Setiap Saat"?
                            </h6>
                            <p class="mb-4">Dokumen masuk kategori <strong>Informasi Setiap Saat</strong> karena sifatnya adalah <strong>Catatan Operasional & Bukti Kebijakan</strong>. Dokumen ini mungkin tidak rutin diterbitkan, tetapi harus siap sedia kapanpun masyarakat datang meminta. Ini adalah database sejarah aktivitas instansi Bapak.</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white/60 p-4 rounded-2xl border border-emerald-100 text-xs">
                                    <p class="font-black text-emerald-700 mb-1 italic">Logika Dokumen Kebijakan:</p>
                                    <p class="text-slate-600">Dokumen berupa <strong>Ketetapan Hukum</strong> (seperti SK, Peraturan, atau MoU) diklasifikasikan sebagai <strong>SETIAP SAAT</strong> karena berlaku terus-menerus selama tidak dicabut.</p>
                                </div>
                                <div class="bg-white/60 p-4 rounded-2xl border border-emerald-100 text-xs">
                                    <p class="font-black text-emerald-700 mb-1 italic">Logika Katalog Arsip:</p>
                                    <p class="text-slate-600">Karena merupakan database sejarah, maka semua dokumen (dari tahun lama hingga sekarang) tetap penting untuk ditampilkan berdampingan tanpa perlu saling menggantikan.</p>
                                </div>
                            </div>
                        </div>

                        <!-- CATATAN MANAJEMEN STATUS -->
                        <div class="bg-amber-900 text-white p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden">
                            <div class="absolute -right-4 -bottom-4 opacity-10 rotate-12"><i class="fas fa-exclamation-triangle text-9xl"></i></div>
                            <h6 class="text-lg font-black mb-4 uppercase tracking-tighter flex items-center gap-3">
                                <i class="fas fa-tools text-amber-400"></i> Penting: Manajemen Siklus Hidup Dokumen (Ganti/Arsip)
                            </h6>
                            <p class="text-sm text-amber-100 leading-relaxed mb-6">Setelah Bapak berhasil menentukan klasifikasinya, langkah terakhir yang sangat krusial adalah **Menjaga Keakuratan Data Publik** melalui pengaturan status:</p>
                            <div class="space-y-4">
                                <div class="flex gap-4 items-start bg-white/10 p-4 rounded-2xl border border-white/10">
                                    <div class="bg-amber-500 text-white w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center font-black">!</div>
                                    <div>
                                        <p class="text-xs font-bold text-amber-300 uppercase mb-1">Kapan Dokumen Menjadi ARSIP?</p>
                                        <p class="text-[11px] leading-relaxed italic text-slate-200">"Setiap kali ada dokumen terbaru yang diterbitkan (Update), maka dokumen versi lama yang serupa <strong>WAJIB diubah statusnya menjadi ARSIP</strong>. Hal ini untuk memastikan warga tidak salah mengambil data tahun lama sebagai referensi terkini."</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-red-50 p-6 rounded-[2.5rem] border border-red-200 shadow-sm">
                                <p class="mb-3 font-black text-red-900 uppercase text-xs tracking-widest"><i class="fas fa-bolt"></i> 3. Serta Merta (Emergency)</p>
                                <p class="text-xs text-slate-700 leading-relaxed font-medium">Diklasifikasikan ke sini karena dokumen bersifat <strong>Mendesak & Mengancam Keselamatan</strong>. <br><span class="italic font-bold text-red-700">Contoh: Info Banjir, Wabah, Gangguan Layanan Vital.</span></p>
                            </div>
                            <div class="bg-slate-900 p-6 rounded-[2.5rem] border border-slate-700 shadow-sm text-white">
                                <p class="mb-3 font-black text-slate-300 uppercase text-xs tracking-widest"><i class="fas fa-lock"></i> 4. Dikecualikan (Confidential)</p>
                                <p class="text-xs text-slate-400 leading-relaxed font-medium">Diklasifikasikan ke sini karena dokumen berisi <strong>Data Rahasia/Pribadi</strong> yang dilindungi UU KIP Pasal 17. <br><span class="italic font-bold text-indigo-400">Contoh: Rekam Medis, Rahasia Bisnis, Penyelidikan Polisi.</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN: TUTORIAL FORM LENGKAP A - H (VISUAL) -->
                <div class="space-y-10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-2xl"><i class="fas fa-keyboard text-xl"></i></div>
                        <div>
                            <h5 class="text-xl font-black text-slate-800 leading-tight">Langkah-Langkah Pengisian Formulir</h5>
                            <p class="text-[11px] text-slate-500 uppercase font-black tracking-widest uppercase">Panduan Detail Per Kolom (A - H)</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-[3rem] border-2 border-slate-200 p-10 space-y-12 shadow-inner">
                        <!-- A: JUDUL -->
                        <div class="flex flex-col md:flex-row gap-10 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-4">
                                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-lg shadow-lg shadow-indigo-200">A</span>
                                    <h6 class="font-bold text-slate-800 mt-1 uppercase">Judul Informasi</h6>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed ml-14">Gunakan format Judul: <strong>Nama Dokumen + Unit + Tahun</strong>. <br>Contoh: <span class="bg-white px-2 py-1 rounded border border-slate-200 text-indigo-600 font-bold italic">Renja Dinas Pekerjaan Umum 2024</span>.</p>
                            </div>
                            <div class="md:w-72 bg-white p-4 rounded-2xl border border-slate-200 shadow-md relative group">
                                <div class="h-2 w-20 bg-slate-100 rounded mb-3"></div>
                                <div class="h-10 w-full border-2 border-indigo-200 rounded-xl bg-indigo-50/50 flex items-center px-4">
                                    <span class="text-[9px] text-indigo-400 font-black italic tracking-tighter uppercase">Ketik Judul...</span>
                                </div>
                                <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[10px] border-r-indigo-600"></div>
                            </div>
                        </div>

                        <!-- B: DESKRIPSI -->
                        <div class="flex flex-col md:flex-row gap-10 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-4">
                                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-lg shadow-lg shadow-indigo-200">B</span>
                                    <h6 class="font-bold text-slate-800 mt-1 uppercase">Deskripsi & Skenario Pelengkap</h6>
                                </div>
                                <div class="ml-14 space-y-4">
                                    <p class="text-xs text-slate-600 leading-relaxed">Berikan ringkasan isi dokumen agar pemohon mudah memahami data.</p>
                                    <div class="bg-amber-100 p-5 rounded-3xl border-2 border-amber-300 shadow-lg shadow-amber-100">
                                        <h6 class="text-[11px] font-black text-amber-900 uppercase tracking-widest mb-2 flex items-center gap-2"><i class="fas fa-exclamation-circle text-lg"></i> Dokumen Pelengkap:</h6>
                                        <p class="text-[11px] text-amber-800 leading-relaxed font-bold">"Jika laporan Bapak memiliki lampiran banyak (LRA + Lampiran A, B, C), disarankan GABUNGKAN DALAM 1 PDF. Jika file sangat berat, pilih opsi Link File (Google Drive) yang memuat SATU FOLDER penuh lampiran tersebut."</p>
                                    </div>
                                </div>
                            </div>
                            <div class="md:w-72 bg-white p-4 rounded-2xl border border-slate-200 shadow-md relative overflow-hidden">
                                <div class="h-20 w-full border border-slate-200 rounded-xl bg-slate-50 flex flex-col p-3 gap-2">
                                    <div class="h-1.5 w-full bg-slate-200 rounded"></div>
                                    <div class="h-1.5 w-full bg-slate-200 rounded"></div>
                                    <div class="h-1.5 w-2/3 bg-slate-200 rounded"></div>
                                </div>
                                <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[10px] border-r-indigo-600"></div>
                            </div>
                        </div>

                        <!-- C: KATEGORI & UNIT -->
                        <div class="flex flex-col md:flex-row gap-10 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-4">
                                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-lg shadow-lg shadow-indigo-200">C</span>
                                    <h6 class="font-bold text-slate-800 mt-1 uppercase">Kategori & Unit</h6>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed ml-14">Pilih kategori yang tepat. Unit kerja otomatis terkunci sesuai login akun Bapak.</p>
                            </div>
                            <div class="md:w-72 space-y-3 relative">
                                <div class="bg-white p-3 rounded-xl border border-slate-200 shadow-sm flex justify-between items-center text-[9px] font-black">INFORMASI BERKALA <i class="fas fa-chevron-down"></i></div>
                                <div class="bg-slate-200 p-3 rounded-xl border border-slate-300 opacity-60 text-[9px] italic font-bold">Unit Kerja Terkunci...</div>
                                <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[10px] border-r-indigo-600"></div>
                            </div>
                        </div>

                        <!-- D: JENIS DOKUMEN -->
                        <div class="flex flex-col md:flex-row gap-10 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-4">
                                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-lg shadow-lg shadow-indigo-200">D</span>
                                    <h6 class="font-bold text-slate-800 mt-1 uppercase">Jenis Dokumen</h6>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed ml-14">Menentukan folder tampilan di website. Pilih klasifikasi paling relevan (misal: Dokumen Keuangan).</p>
                            </div>
                            <div class="md:w-72 bg-white p-4 rounded-2xl border-2 border-blue-200 shadow-xl relative">
                                <div class="h-10 w-full border-blue-300 rounded-xl bg-blue-50 flex items-center px-4 justify-between text-[9px] text-blue-700 font-black italic uppercase">Informasi Keuangan <i class="fas fa-check-circle text-blue-500"></i></div>
                                <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[10px] border-r-indigo-600"></div>
                            </div>
                        </div>

                        <!-- E: TAHUN -->
                        <div class="flex flex-col md:flex-row gap-10 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-4">
                                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-lg shadow-lg shadow-indigo-200">E</span>
                                    <h6 class="font-bold text-slate-800 mt-1 uppercase">Tahun Dokumen</h6>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed ml-14">Gunakan format: <strong>YYYY-MM-DD</strong>. Sesuaikan dengan tahun terbit dokumen Bapak.</p>
                            </div>
                            <div class="md:w-72 bg-white p-4 rounded-2xl border border-slate-200 shadow-md relative flex items-center text-[10px] font-black text-slate-700">
                                <i class="fas fa-calendar-day mr-3 text-slate-400"></i> 2024-04-29
                                <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[10px] border-r-indigo-600"></div>
                            </div>
                        </div>

                        <!-- F: STATUS -->
                        <div class="flex flex-col md:flex-row gap-10 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-4">
                                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-lg shadow-lg shadow-indigo-200">F</span>
                                    <h6 class="font-bold text-slate-800 mt-1 uppercase">Status</h6>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed ml-14">Setel ke **BERLAKU** agar tampil di web. Setel ke **ARSIP** hanya untuk riwayat data lama.</p>
                            </div>
                            <div class="md:w-72 bg-white p-4 rounded-2xl border border-slate-200 shadow-md relative flex gap-6 items-center">
                                <div class="flex items-center gap-2"><div class="w-4 h-4 rounded-full border-2 border-indigo-600 flex items-center justify-center"><div class="w-2 h-2 bg-indigo-600 rounded-full"></div></div><span class="text-[10px] font-black text-indigo-700 uppercase">Berlaku</span></div>
                                <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[10px] border-r-indigo-600"></div>
                            </div>
                        </div>

                        <!-- G: FILE / LINK -->
                        <div class="flex flex-col md:flex-row gap-10 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-4">
                                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-lg shadow-lg shadow-indigo-200">G</span>
                                    <h6 class="font-bold text-slate-800 mt-1 uppercase">Upload / Link (Max 2MB)</h6>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed ml-14">Wajib format **PDF**. Jika file > 2MB, pilih **Link File** dan paste URL dari Google Drive.</p>
                            </div>
                            <div class="md:w-72 bg-white border-2 border-dashed border-indigo-100 p-6 rounded-[2rem] relative flex flex-col items-center gap-2 shadow-inner">
                                <i class="fas fa-file-pdf text-indigo-400 text-4xl"></i>
                                <span class="text-[8px] text-slate-400 font-black uppercase tracking-widest">PDF MAX 2MB</span>
                                <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[10px] border-r-indigo-600"></div>
                            </div>
                        </div>

                        <!-- H: FINALISASI (CHECK SIMILARITY) -->
                        <div class="flex flex-col md:flex-row gap-10 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-4">
                                    <span class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-black text-lg shadow-lg shadow-blue-200">H</span>
                                    <h6 class="font-bold text-blue-900 mt-1 italic uppercase tracking-tighter">Check & Simpan</h6>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed ml-14">Wajib klik tombol <span class="bg-yellow-500 text-white px-2 py-0.5 rounded font-black text-[10px] uppercase">CHECK INFORMASI</span> untuk deteksi data lama agar otomatis diarsipkan.</p>
                            </div>
                            <div class="md:w-72 bg-slate-100 p-4 rounded-2xl border border-slate-200 shadow-xl relative flex justify-center">
                                <div class="bg-yellow-500 text-white px-6 py-3 rounded-2xl text-[11px] font-black shadow-2xl animate-bounce uppercase tracking-widest border-2 border-white">CHECK INFORMASI</div>
                                <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[10px] border-r-yellow-500"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN: BANTUAN AI ANALIS (SETELAH TUTORIAL) -->
                <div class="bg-indigo-900 text-white p-10 rounded-[4rem] shadow-2xl relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 opacity-10"><i class="fas fa-microchip text-[12rem]"></i></div>
                    <div class="relative z-10">
                        <h5 class="text-2xl font-black mb-8 flex items-center gap-3">
                            <i class="fas fa-magic text-indigo-300"></i> Sulit Identifikasi Dokumen? Gunakan AI Analis!
                        </h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                            <div class="space-y-6">
                                <div class="flex gap-5 items-start">
                                    <span class="bg-indigo-500 text-white w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center font-black">1</span>
                                    <p class="text-sm text-indigo-50 leading-relaxed">Klik tombol <span class="bg-indigo-600 border border-indigo-400 px-3 py-1 rounded-lg text-xs font-bold inline-flex items-center gap-2"><i class="fas fa-question-circle"></i> TANYA PEDOMAN</span> di pojok kanan atas form.</p>
                                </div>
                                <div class="flex gap-5 items-start">
                                    <span class="bg-indigo-500 text-white w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center font-black">2</span>
                                    <p class="text-sm text-indigo-50 leading-relaxed">Ketik nama dokumen (Misal: <em>"RPJMD Dinas Kesehatan"</em>) pada kotak yang muncul.</p>
                                </div>
                                <div class="flex gap-5 items-start">
                                    <span class="bg-indigo-500 text-white w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center font-black">3</span>
                                    <p class="text-sm text-indigo-50 leading-relaxed">Klik tombol hijau <span class="bg-green-500 text-white px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest italic">TANYA AI</span> untuk mendapatkan jawaban klasifikasi instan.</p>
                                </div>
                            </div>
                            <!-- Visual AI -->
                            <div class="bg-white/10 backdrop-blur-md rounded-[3rem] p-8 border border-white/20 shadow-2xl">
                                <div class="bg-white rounded-3xl p-6 space-y-5 shadow-inner">
                                    <div class="h-3 w-32 bg-slate-100 rounded"></div>
                                    <div class="h-14 w-full border-2 border-slate-200 rounded-2xl bg-slate-50 flex items-center px-5 text-xs text-slate-400 italic">Ketik dokumen di sini...</div>
                                    <div class="flex justify-end relative">
                                        <div class="bg-green-600 text-white px-6 py-3 rounded-2xl text-xs font-black shadow-lg animate-pulse uppercase tracking-widest">TANYA AI</div>
                                        <div class="absolute -left-6 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[10px] border-y-transparent border-r-[15px] border-r-indigo-500"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN: DAFTAR DOKUMEN WAJIB PER UNIT (AKHIR) -->
                <div class="bg-white border-8 border-slate-100 rounded-[4rem] p-12 shadow-sm relative overflow-hidden">
                    <h5 class="text-2xl font-black text-slate-800 mb-12 text-center uppercase tracking-[0.3em] border-b pb-4">Dokumen Wajib Per Unit Kerja</h5>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-slate-500 font-medium">
                        <div class="space-y-4">
                            <p class="text-xs font-black text-blue-600 uppercase border-b-2 border-blue-100 pb-2">Dinas / Badan / RSUD</p>
                            <ul class="text-[11px] space-y-2 list-disc list-inside">
                                <li>Renstra & Renja (5 thn & thn)</li>
                                <li>DPA & RKA Anggaran</li>
                                <li>LRA & Neraca Keuangan</li>
                                <li>Tarif Layanan (RSUD)</li>
                                <li>LHKPN Pejabat Utama</li>
                            </ul>
                        </div>
                        <div class="space-y-4">
                            <p class="text-xs font-black text-indigo-600 uppercase border-b-2 border-indigo-100 pb-2">Inspektorat</p>
                            <ul class="text-[11px] space-y-2 list-disc list-inside">
                                <li>PKPT (Program Kerja Audit)</li>
                                <li>Ringkasan LHP Publik</li>
                                <li>SOP Audit Pengawasan</li>
                                <li>Laporan Akuntabilitas</li>
                            </ul>
                        </div>
                        <div class="space-y-4">
                            <p class="text-xs font-black text-green-600 uppercase border-b-2 border-green-100 pb-2">Kecamatan / Desa / Kel</p>
                            <ul class="text-[11px] space-y-2 list-disc list-inside">
                                <li>APBDes / RKPDes (Anggaran)</li>
                                <li>LPPD Penyelenggaraan</li>
                                <li>Monografi & Profil Wilayah</li>
                                <li>Laporan Pelayanan (Kecamatan)</li>
                            </ul>
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
                    <div class="bg-slate-900 rounded-3xl p-8 text-white relative overflow-hidden shadow-2xl">
                        <div class="absolute top-0 right-0 p-8 opacity-10">
                            <i class="fas fa-file-import text-9xl"></i>
                        </div>
                        <h5 class="text-xl font-bold mb-6 flex items-center gap-3">
                            <i class="fas fa-user-edit text-green-400"></i>
                            Mengarahkan Pemohon
                        </h5>
                        <div class="space-y-6">
                            <div class="flex gap-4">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-sm shadow-lg">1</div>
                                <div>
                                    <p class="font-bold text-green-400 text-sm uppercase">Login Pemohon</p>
                                    <p class="text-xs text-slate-300 mt-1">Minta warga login ke portal PPID.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-sm shadow-lg">2</div>
                                <div>
                                    <p class="font-bold text-green-400 text-sm uppercase">Isi Formulir</p>
                                    <p class="text-xs text-slate-300 mt-1">Arahkan ke menu <strong>Transparansi</strong> > <strong>Permohonan Informasi</strong>.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border-2 border-slate-100 rounded-3xl p-8 shadow-xl">
                        <h5 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                            <i class="fas fa-reply text-blue-600"></i>
                            Tugas Admin (Merespon)
                        </h5>
                        <div class="space-y-6">
                            <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100">
                                <p class="text-sm font-bold text-blue-800 mb-2 underline italic uppercase tracking-widest">Langkah Respon:</p>
                                <ol class="text-xs text-slate-600 space-y-3 list-decimal list-inside font-medium">
                                    <li>Pilih permohonan status <span class="text-orange-600 font-bold uppercase">Pending</span>.</li>
                                    <li>Klik tombol <span class="bg-blue-600 text-white px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest">Proses/Balas</span>.</li>
                                    <li>Tulis pesan balasan & upload/kirim dokumen jawaban.</li>
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

                <div class="bg-orange-50 p-6 rounded-2xl border border-orange-100 mb-8 flex gap-4 items-start shadow-sm">
                    <div class="bg-orange-500 text-white p-3 rounded-xl shadow-lg shadow-orange-200">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h6 class="font-black text-orange-800 uppercase tracking-tighter">Perhatian Khusus PBJ!</h6>
                        <p class="text-xs text-orange-700 leading-relaxed mt-1 font-bold">Wajib upload RUP, KAK, Kontrak, dan BAST secara berkala sesuai progres tender fisik.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-slate-700">
                    <div class="space-y-4">
                        <h5 class="font-bold flex items-center gap-2 text-lg">
                            <i class="fas fa-shopping-cart text-orange-500"></i>
                            Langkah Input Paket
                        </h5>
                        <ul class="text-sm space-y-4">
                            <li class="p-5 bg-white border border-slate-200 rounded-[1.5rem] shadow-sm flex gap-4 items-center">
                                <span class="text-orange-500 font-black text-lg">01.</span>
                                <span class="font-medium text-xs leading-relaxed">Klik menu <strong>PBJ</strong> > <strong>Input Data Paket</strong>. Masukkan Pagu, HPS, dan Pemenang.</span>
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
                    <img src="https://ui-avatars.com/api/?name=Admin+PPID&background=4f46e5&color=fff" class="w-8 h-8 rounded-full border-2 border-white shadow-md">
                    <img src="https://ui-avatars.com/api/?name=Super+Admin&background=1e1b4b&color=fff" class="w-8 h-8 rounded-full border-2 border-white shadow-md">
                </div>
                <div class="text-[10px] text-slate-400 font-black uppercase tracking-widest leading-none">
                    Dinas Kominfo & Persandian Sinjai
                </div>
            </div>
            
            <div class="flex gap-3 w-full md:w-auto">
                <button @click="$store.pedomanAdminModal.prevTab()" 
                        x-show="$store.pedomanAdminModal.activeTab > 0"
                        class="px-6 py-3 bg-white text-slate-600 font-bold rounded-2xl border border-slate-200 text-sm hover:bg-slate-100 transition-all flex items-center gap-2 shadow-sm">
                    <i class="fas fa-arrow-left"></i> SEBELUMNYA
                </button>

                <button @click="$store.pedomanAdminModal.nextTab()" 
                        class="flex-1 md:flex-none px-12 py-3 bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-700/20 text-sm transition-all hover:bg-indigo-800 hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2">
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
