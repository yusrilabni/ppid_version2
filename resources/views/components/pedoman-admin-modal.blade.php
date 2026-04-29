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
        <div class="bg-slate-50 border-b border-slate-200 flex overflow-x-auto no-scrollbar scroll-smooth px-6 sticky top-0 z-40 shadow-md">
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
                    <h4 class="text-2xl font-bold">Master Class: Manajemen & Klasifikasi Informasi</h4>
                </div>

                <!-- BAGIAN 1: PENGERTIAN UMUM -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-blue-50 p-6 rounded-[2.5rem] border border-blue-100 shadow-sm">
                        <h6 class="font-black text-blue-900 mb-3 uppercase tracking-tight flex items-center gap-2">
                            <i class="fas fa-sync-alt"></i> Informasi Berkala
                        </h6>
                        <p class="text-xs text-slate-700 leading-relaxed italic">
                            Informasi yang wajib disediakan secara rutin. Sifatnya adalah <strong>Update Terkini (Ganti)</strong>. Jika Bapak mengupload data 2024, maka data 2023 harus diarsipkan menggunakan fitur "Check Informasi" agar publik tidak bingung.
                        </p>
                    </div>
                    <div class="bg-emerald-50 p-6 rounded-[2.5rem] border border-emerald-100 shadow-sm">
                        <h6 class="font-black text-emerald-900 mb-3 uppercase tracking-tight flex items-center gap-2">
                            <i class="fas fa-layer-group"></i> Informasi Setiap Saat
                        </h6>
                        <p class="text-xs text-slate-700 leading-relaxed italic">
                            Informasi historis yang wajib tersedia kapan saja. Sifatnya <strong>Akumulatif (Menumpuk)</strong>. Bapak boleh mengupload semua tahun sekaligus dengan status "Berlaku" sebagai database sejarah unit kerja.
                        </p>
                    </div>
                </div>

                <!-- BAGIAN: BANTUAN AI ANALIS (LENGKAP) -->
                <div class="bg-indigo-900 text-white p-8 rounded-[3rem] shadow-2xl relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 opacity-10"><i class="fas fa-microchip text-[12rem]"></i></div>
                    <div class="relative z-10">
                        <h5 class="text-xl font-black mb-6 flex items-center gap-3">
                            <i class="fas fa-magic text-indigo-300"></i> Sulit Identifikasi Dokumen? Gunakan AI Analis!
                        </h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                            <div class="space-y-5">
                                <div class="flex gap-4 items-start">
                                    <span class="bg-indigo-500 text-white w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center text-[11px] font-black">1</span>
                                    <p class="text-xs text-indigo-50 leading-relaxed">Klik tombol <span class="bg-indigo-600 border border-indigo-400 px-2 py-0.5 rounded text-[10px] font-bold inline-flex items-center gap-1"><i class="fas fa-question-circle"></i> TANYA PEDOMAN</span> di pojok kanan atas form tambah informasi.</p>
                                </div>
                                <div class="flex gap-4 items-start">
                                    <span class="bg-indigo-500 text-white w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center text-[11px] font-black">2</span>
                                    <p class="text-xs text-indigo-50 leading-relaxed">Ketik nama dokumen Bapak di kolom input (Misal: <em>"RPJMD Dinas Kesehatan"</em>).</p>
                                </div>
                                <div class="flex gap-4 items-start">
                                    <span class="bg-indigo-500 text-white w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center text-[11px] font-black">3</span>
                                    <p class="text-xs text-indigo-50 leading-relaxed">Klik tombol hijau <span class="bg-green-500 text-white px-2 py-0.5 rounded text-[10px] font-black tracking-widest uppercase italic">TANYA AI</span> untuk klasifikasi otomatis.</p>
                                </div>
                            </div>
                            <!-- Mockup Visual AI -->
                            <div class="bg-white/10 backdrop-blur-md rounded-[2rem] p-6 border border-white/20 shadow-xl">
                                <div class="bg-white rounded-2xl p-4 space-y-4 shadow-2xl">
                                    <div class="h-2 w-20 bg-slate-100 rounded"></div>
                                    <div class="h-12 w-full border border-slate-200 rounded-xl bg-slate-50 flex items-center px-4 text-[10px] text-slate-400 italic">Ketik nama dokumen di sini...</div>
                                    <div class="flex justify-end relative">
                                        <div class="bg-green-600 text-white px-4 py-2 rounded-xl text-[10px] font-black shadow-lg animate-pulse uppercase tracking-widest">TANYA AI</div>
                                        <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN: STUDI KASUS UMUM VS INTERNAL -->
                <div class="space-y-8">
                    <h5 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                        <i class="fas fa-project-diagram text-blue-600"></i> Klasifikasi: Dokumen Umum vs Dokumen Internal
                    </h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-white border-2 border-slate-100 rounded-[2.5rem] p-8 shadow-sm hover:shadow-xl transition-all group">
                            <h6 class="font-black text-indigo-700 text-sm mb-4 uppercase tracking-[0.15em] border-b pb-2 flex items-center gap-2">
                                <i class="fas fa-globe"></i> Dokumen Umum (Level Kabupaten)
                            </h6>
                            <p class="text-xs text-slate-600 leading-relaxed mb-6">Diterbitkan oleh Bupati/Sekda dan berlaku untuk seluruh instansi atau wilayah Kabupaten Sinjai.</p>
                            <div class="bg-indigo-50 p-5 rounded-2xl border border-indigo-100">
                                <p class="text-[10px] font-bold text-indigo-800 mb-2 uppercase underline">Contoh & Alur:</p>
                                <ul class="text-[10px] text-slate-600 space-y-3">
                                    <li class="flex gap-2"><i class="fas fa-check-circle text-indigo-500"></i> <span><strong>SK Bupati:</strong> Masuk kategori <strong>Setiap Saat</strong> sebagai Katalog Regulasi Daerah.</span></li>
                                    <li class="flex gap-2"><i class="fas fa-check-circle text-indigo-500"></i> <span><strong>RPJMD:</strong> Masuk kategori <strong>Berkala</strong> (Data Strategis 5 Tahunan).</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="bg-white border-2 border-slate-100 rounded-[2.5rem] p-8 shadow-sm hover:shadow-xl transition-all group">
                            <h6 class="font-black text-orange-700 text-sm mb-4 uppercase tracking-[0.15em] border-b pb-2 flex items-center gap-2">
                                <i class="fas fa-building"></i> Dokumen Internal (Level Dinas/Desa)
                            </h6>
                            <p class="text-xs text-slate-600 leading-relaxed mb-6">Diterbitkan secara mandiri oleh Kadis/Camat/Kades untuk operasional kantor tersebut saja.</p>
                            <div class="bg-orange-50 p-5 rounded-2xl border border-orange-100">
                                <p class="text-[10px] font-bold text-orange-800 mb-2 uppercase underline">Contoh & Alur:</p>
                                <ul class="text-[10px] text-slate-600 space-y-3">
                                    <li class="flex gap-2"><i class="fas fa-check-circle text-orange-500"></i> <span><strong>SK Tim Teknis Dinas:</strong> Masuk kategori <strong>Setiap Saat</strong> untuk riwayat operasional unit.</span></li>
                                    <li class="flex gap-2"><i class="fas fa-check-circle text-orange-500"></i> <span><strong>SOP Layanan Kantor:</strong> Masuk kategori <strong>Setiap Saat</strong> (Update berkala jika ada revisi).</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN: TUTORIAL FORM LENGKAP A - H (VISUAL) -->
                <div class="space-y-10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-2xl"><i class="fas fa-keyboard text-xl"></i></div>
                        <div>
                            <h5 class="text-xl font-black text-slate-800 leading-tight">Tutorial Detail Pengisian Formulir</h5>
                            <p class="text-[11px] text-slate-500 uppercase font-black tracking-widest">Wajib Diikuti Agar Data Akurat (Poin A - H)</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-[3rem] border-2 border-slate-200 p-10 space-y-12 shadow-inner">
                        <!-- A: JUDUL -->
                        <div class="flex flex-col md:flex-row gap-10 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-4">
                                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-lg shadow-lg shadow-indigo-200">A</span>
                                    <h6 class="text-lg font-bold text-slate-800 mt-1">Judul Informasi</h6>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed ml-14">Gunakan Judul Formal: <strong>Nama Dokumen + Unit + Tahun</strong>. <br>Contoh: <span class="bg-white px-2 py-1 rounded border border-slate-200 text-indigo-600 font-bold italic">Renja Dinas Pekerjaan Umum Tahun 2024</span>.</p>
                            </div>
                            <div class="md:w-72 bg-white p-4 rounded-2xl border border-slate-200 shadow-md relative group">
                                <div class="h-2 w-20 bg-slate-100 rounded mb-3"></div>
                                <div class="h-10 w-full border-2 border-indigo-200 rounded-xl bg-indigo-50/50 flex items-center px-4">
                                    <span class="text-[9px] text-indigo-400 font-black italic tracking-tighter uppercase">Ketik Judul Di Sini...</span>
                                </div>
                                <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[10px] border-r-indigo-600"></div>
                            </div>
                        </div>

                        <!-- B: DESKRIPSI & SKENARIO DOKUMEN PELENGKAP -->
                        <div class="flex flex-col md:flex-row gap-10 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-4">
                                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-lg shadow-lg shadow-indigo-200">B</span>
                                    <h6 class="text-lg font-bold text-slate-800 mt-1">Deskripsi & Skenario Pelengkap</h6>
                                </div>
                                <div class="ml-14 space-y-4">
                                    <p class="text-xs text-slate-600 leading-relaxed">Berikan ringkasan isi dokumen (Maks 1 Paragraf).</p>
                                    <div class="bg-amber-100 p-5 rounded-3xl border-2 border-amber-300 shadow-lg shadow-amber-100">
                                        <h6 class="text-[11px] font-black text-amber-900 uppercase tracking-widest mb-2 flex items-center gap-2"><i class="fas fa-exclamation-circle text-lg"></i> Skenario Dokumen Pelengkap:</h6>
                                        <p class="text-[11px] text-amber-800 leading-relaxed font-bold">"Jika laporan Bapak memiliki lampiran banyak (Misal: Laporan Keuangan + Lampiran A, B, C), disarankan GABUNGKAN DALAM 1 FILE PDF. Jika file sangat berat, gunakan fitur Link File (URL Google Drive) yang memuat SATU FOLDER penuh lampiran tersebut."</p>
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
                                    <h6 class="text-lg font-bold text-slate-800 mt-1">Kategori & Unit Kerja</h6>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed ml-14">Unit kerja otomatis terkunci sesuai akun Bapak. Pilih kategori **Informasi Berkala** atau **Informasi Setiap Saat**.</p>
                            </div>
                            <div class="md:w-72 space-y-3 relative">
                                <div class="bg-white p-3 rounded-xl border border-slate-200 shadow-sm flex justify-between items-center">
                                    <span class="text-[9px] font-black text-slate-700 uppercase">Informasi Berkala</span>
                                    <i class="fas fa-chevron-down text-slate-400 text-[8px]"></i>
                                </div>
                                <div class="bg-slate-200 p-3 rounded-xl border border-slate-300 flex items-center opacity-60">
                                    <span class="text-[9px] font-bold text-slate-500 uppercase italic">Unit Kerja Terkunci...</span>
                                </div>
                                <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[10px] border-r-indigo-600"></div>
                            </div>
                        </div>

                        <!-- D: JENIS DOKUMEN -->
                        <div class="flex flex-col md:flex-row gap-10 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-4">
                                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-lg shadow-lg shadow-indigo-200">D</span>
                                    <h6 class="text-lg font-bold text-slate-800 mt-1">Klasifikasi Jenis Dokumen</h6>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed ml-14">Sangat krusial untuk filter website. Pilih klasifikasi paling relevan (Contoh: **Dokumen Keuangan** untuk RKA/LRA).</p>
                            </div>
                            <div class="md:w-72 bg-white p-4 rounded-2xl border-2 border-blue-200 shadow-xl relative">
                                <div class="h-10 w-full border border-blue-300 rounded-xl bg-blue-50 flex items-center px-4 justify-between">
                                    <span class="text-[9px] text-blue-700 font-black uppercase italic tracking-widest">Informasi Keuangan</span>
                                    <i class="fas fa-check-double text-blue-600 text-sm"></i>
                                </div>
                                <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[10px] border-r-indigo-600"></div>
                            </div>
                        </div>

                        <!-- E: TAHUN -->
                        <div class="flex flex-col md:flex-row gap-10 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-4">
                                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-lg shadow-lg shadow-indigo-200">E</span>
                                    <h6 class="text-lg font-bold text-slate-800 mt-1">Tahun Dokumen</h6>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed ml-14">Masukkan tanggal upload atau tahun terbit dokumen. <br>Format wajib: <strong>YYYY-MM-DD</strong> (Tahun-Bulan-Hari).</p>
                            </div>
                            <div class="md:w-72 bg-white p-4 rounded-2xl border border-slate-200 shadow-md relative flex items-center">
                                <div class="h-10 w-full border border-slate-200 rounded-xl flex items-center px-4 gap-3">
                                    <i class="fas fa-calendar-day text-slate-400"></i>
                                    <span class="text-[10px] text-slate-700 font-black">2024-04-29</span>
                                </div>
                                <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[10px] border-r-indigo-600"></div>
                            </div>
                        </div>

                        <!-- F: STATUS -->
                        <div class="flex flex-col md:flex-row gap-10 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-4">
                                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-lg shadow-lg shadow-indigo-200">F</span>
                                    <h6 class="text-lg font-bold text-slate-800 mt-1">Status (Berlaku / Arsip)</h6>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed ml-14">Gunakan **BERLAKU** agar dokumen Bapak tampil di halaman depan. Gunakan **ARSIP** jika Bapak mengunggah data lama yang sudah tidak aktif.</p>
                            </div>
                            <div class="md:w-72 bg-white p-4 rounded-2xl border border-slate-200 shadow-md relative flex gap-6 items-center">
                                <div class="flex items-center gap-2"><div class="w-4 h-4 rounded-full border-2 border-indigo-600 flex items-center justify-center shadow-inner shadow-indigo-100"><div class="w-2 h-2 bg-indigo-600 rounded-full animate-pulse"></div></div><span class="text-[10px] font-black text-indigo-700 uppercase tracking-widest">Berlaku</span></div>
                                <div class="flex items-center gap-2 opacity-30 grayscale"><div class="w-4 h-4 rounded-full border-2 border-slate-400"></div><span class="text-[10px] font-bold text-slate-500 uppercase">Arsip</span></div>
                                <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[10px] border-r-indigo-600"></div>
                            </div>
                        </div>

                        <!-- G: UPLOAD FILE / LINK -->
                        <div class="flex flex-col md:flex-row gap-10 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-4">
                                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-lg shadow-lg shadow-indigo-200">G</span>
                                    <h6 class="text-lg font-bold text-slate-800 mt-1">Upload File (Max 2MB)</h6>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed ml-14">Format Wajib: **PDF**. Jika file Bapak berukuran raksasa, pilih opsi **Link File** dan tempelkan link Google Drive dokumen tersebut.</p>
                            </div>
                            <div class="md:w-72 bg-white border-2 border-dashed border-indigo-100 p-6 rounded-[2rem] relative flex flex-col items-center justify-center gap-3 shadow-inner group">
                                <i class="fas fa-file-pdf text-indigo-400 text-4xl group-hover:scale-110 transition-transform"></i>
                                <span class="text-[9px] text-slate-400 font-black uppercase tracking-[0.2em]">MAX 2MB PDF</span>
                                <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[10px] border-r-indigo-600"></div>
                            </div>
                        </div>

                        <!-- H: FINALISASI (CHECK INFORMASI) -->
                        <div class="flex flex-col md:flex-row gap-10 items-start">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-4">
                                    <span class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-black text-lg shadow-lg shadow-blue-200">H</span>
                                    <h6 class="text-lg font-bold text-blue-900 mt-1 italic uppercase tracking-tighter">Check Similarity & Simpan</h6>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed ml-14">Khusus **Informasi Berkala**, Bapak wajib klik tombol <span class="bg-yellow-500 text-white px-2 py-0.5 rounded font-black text-[10px] uppercase">CHECK INFORMASI</span> untuk mendeteksi dokumen lama. Sistem akan menawarkan untuk mengarsipkan dokumen tahun lalu secara otomatis.</p>
                            </div>
                            <div class="md:w-72 bg-slate-100 p-4 rounded-2xl border border-slate-200 shadow-xl relative flex justify-center">
                                <div class="bg-yellow-500 text-white px-6 py-3 rounded-2xl text-[11px] font-black shadow-2xl shadow-yellow-200 animate-bounce uppercase tracking-widest border-2 border-white">CHECK INFORMASI</div>
                                <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[10px] border-r-yellow-500"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t-4 border-dashed border-slate-100 py-10"></div>

                <!-- BAGIAN: SERTA MERTA & DIKECUALIKAN -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="bg-red-600 text-white p-10 rounded-[3rem] shadow-2xl relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-10 opacity-10 group-hover:rotate-12 transition-transform duration-700"><i class="fas fa-bolt text-9xl"></i></div>
                        <h6 class="text-xl font-black mb-4 uppercase tracking-[0.2em] flex items-center gap-3"><i class="fas fa-exclamation-triangle"></i> Serta Merta</h6>
                        <p class="text-xs text-red-50 leading-relaxed mb-6 italic">"Informasi darurat yang mengancam hajat hidup orang banyak."</p>
                        <div class="bg-white/10 p-5 rounded-2xl border border-white/20">
                            <p class="text-[10px] font-bold text-white mb-2 underline">STUDI KASUS:</p>
                            <p class="text-[10px] text-red-50 leading-relaxed">Terjadi Banjir Bandang atau Wabah Penyakit. Dokumen pengumuman darurat wajib diupload menit itu juga agar warga waspada. Langsung set **BERLAKU**.</p>
                        </div>
                    </div>
                    <div class="bg-slate-900 text-white p-10 rounded-[3rem] shadow-2xl relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-10 opacity-10 group-hover:rotate-12 transition-transform duration-700"><i class="fas fa-lock text-9xl"></i></div>
                        <h6 class="text-xl font-black mb-4 uppercase tracking-[0.2em] flex items-center gap-3"><i class="fas fa-shield-alt"></i> Dikecualikan</h6>
                        <p class="text-xs text-slate-400 leading-relaxed mb-6 italic">"Informasi Rahasia Sesuai Pasal 17 UU KIP."</p>
                        <div class="bg-white/10 p-5 rounded-2xl border border-white/20">
                            <p class="text-[10px] font-bold text-indigo-300 mb-2 underline">STUDI KASUS:</p>
                            <p class="text-[10px] text-slate-400 leading-relaxed">Rekam Medis Pegawai, Rahasia Bisnis, atau Data Pribadi Warga. Dokumen ini Bapak upload tapi **TIDAK AKAN MUNCUL** di publik (hanya simpanan internal).</p>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN: DAFTAR DOKUMEN WAJIB PER UNIT (DETAIL) -->
                <div class="bg-white border-8 border-slate-50 rounded-[4rem] p-12 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-600 via-indigo-600 to-emerald-600"></div>
                    <h5 class="text-2xl font-black text-slate-800 mb-12 text-center uppercase tracking-[0.3em]">Dokumen Wajib Per Unit Kerja</h5>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                        <div class="space-y-4">
                            <p class="text-xs font-black text-blue-600 uppercase border-b-2 border-blue-100 pb-2 flex items-center gap-2"><i class="fas fa-building"></i> Dinas / Badan / RSUD</p>
                            <ul class="text-[11px] text-slate-500 space-y-2 list-disc list-inside font-medium leading-relaxed">
                                <li><strong>Renstra & Renja:</strong> Program 5 thn & tahunan.</li>
                                <li><strong>DPA & RKA:</strong> Anggaran unit kerja.</li>
                                <li><strong>LRA & Neraca:</strong> Laporan keuangan resmi.</li>
                                <li><strong>Tarif Layanan (RSUD):</strong> Wajib publikasi.</li>
                                <li><strong>LHKPN Pejabat:</strong> Transparansi harta.</li>
                            </ul>
                        </div>
                        <div class="space-y-4">
                            <p class="text-xs font-black text-indigo-600 uppercase border-b-2 border-indigo-100 pb-2 flex items-center gap-2"><i class="fas fa-search-dollar"></i> Inspektorat</p>
                            <ul class="text-[11px] text-slate-500 space-y-2 list-disc list-inside font-medium leading-relaxed">
                                <li><strong>PKPT:</strong> Program Kerja Tahunan.</li>
                                <li><strong>Ringkasan LHP:</strong> Laporan hasil pemeriksaan.</li>
                                <li><strong>SOP Audit:</strong> Prosedur pengawasan.</li>
                                <li><strong>Laporan Akuntabilitas:</strong> Kinerja internal.</li>
                            </ul>
                        </div>
                        <div class="space-y-4">
                            <p class="text-xs font-black text-green-600 uppercase border-b-2 border-green-100 pb-2 flex items-center gap-2"><i class="fas fa-map-marked-alt"></i> Kecamatan / Desa / Kel</p>
                            <ul class="text-[11px] text-slate-500 space-y-2 list-disc list-inside font-medium leading-relaxed">
                                <li><strong>APBDes / RKPDes:</strong> Anggaran pembangunan desa.</li>
                                <li><strong>LPPD:</strong> Laporan penyelenggaraan pimp.</li>
                                <li><strong>Monografi & Profil:</strong> Statistik wilayah.</li>
                                <li><strong>Data Inventaris Desa:</strong> Aset-aset desa.</li>
                                <li><strong>Laporan Pelayanan:</strong> Khusus Kecamatan.</li>
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
                                    <p class="text-xs text-slate-300 mt-1">Minta warga login ke portal PPID (bisa pakai Google).</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-sm shadow-lg">2</div>
                                <div>
                                    <p class="font-bold text-green-400 text-sm uppercase">Isi Formulir</p>
                                    <p class="text-xs text-slate-300 mt-1">Arahkan ke menu <strong>Transparansi</strong> > <strong>Permohonan Informasi</strong>.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-sm shadow-lg">3</div>
                                <div>
                                    <p class="font-bold text-green-400 text-sm uppercase">Kirim Formulir</p>
                                    <p class="text-xs text-slate-300 mt-1">Klik tombol <span class="border border-green-500 px-2 py-0.5 rounded text-[10px] font-black uppercase">Buat Permohonan</span>.</p>
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
                            <div class="p-5 bg-blue-50 rounded-[2rem] border border-blue-100">
                                <p class="text-sm font-bold text-blue-800 mb-3 underline italic uppercase tracking-widest">Langkah Pengiriman Dokumen:</p>
                                <ol class="text-xs text-slate-600 space-y-4 list-decimal list-inside font-medium leading-relaxed">
                                    <li>Masuk ke Dashboard Admin Permohonan.</li>
                                    <li>Pilih permohonan dengan status <span class="text-orange-600 font-black uppercase">Pending</span>.</li>
                                    <li>Klik tombol <span class="bg-blue-600 text-white px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest">Proses/Balas</span>.</li>
                                    <li>Tulis pesan balasan, lampirkan link file dokumen, atau upload dokumen langsung.</li>
                                    <li>Klik <strong>Kirim Jawaban</strong>. Status akan berubah menjadi <span class="text-green-600 font-black uppercase">Selesai</span>.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: PBJ (PU & Sekretariat) -->
            <div x-show="$store.pedomanAdminModal.activeTab === 3" x-transition class="space-y-8">
                <div class="flex items-center gap-4 border-l-4 border-orange-600 pl-4 mb-6">
                    <h4 class="text-2xl font-bold text-slate-800">Panduan Khusus PBJ (PU & Sekretariat)</h4>
                </div>

                <div class="bg-orange-50 p-6 rounded-2xl border border-orange-100 mb-8 flex gap-4 items-start shadow-sm">
                    <div class="bg-orange-500 text-white p-3 rounded-xl shadow-lg shadow-orange-200">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h6 class="font-black text-orange-800 uppercase tracking-tighter">Perhatian Khusus Bagian PBJ!</h6>
                        <p class="text-xs text-orange-700 leading-relaxed mt-1">Data PBJ wajib diupdate secara berkala sesuai progres tender yang berjalan untuk menjaga transparansi anggaran daerah.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <h5 class="font-bold text-slate-800 flex items-center gap-2 text-lg">
                            <i class="fas fa-shopping-cart text-orange-500"></i>
                            Langkah Input PBJ
                        </h5>
                        <ul class="text-sm text-slate-600 space-y-4">
                            <li class="p-5 bg-white border border-slate-200 rounded-[1.5rem] shadow-sm flex gap-4 items-center">
                                <span class="text-orange-500 font-black text-lg">01.</span>
                                <span class="font-medium text-xs leading-relaxed">Klik menu <strong>PBJ</strong> pada Dashboard Admin, lalu pilih <span class="bg-blue-600 text-white px-2 py-0.5 rounded text-[10px] font-black uppercase">Input Data Paket</span>.</span>
                            </li>
                            <li class="p-5 bg-white border border-slate-200 rounded-[1.5rem] shadow-sm flex gap-4 items-center">
                                <span class="text-orange-500 font-black text-lg">02.</span>
                                <span class="font-medium text-xs leading-relaxed">Masukkan Nama Paket, Pagu, HPS, dan Nama Pemenang Tender sesuai kontrak fisik.</span>
                            </li>
                        </ul>
                    </div>
                    <div class="space-y-4">
                        <h5 class="font-bold text-slate-800 flex items-center gap-2 text-lg">
                            <i class="fas fa-file-pdf text-orange-500"></i>
                            Dokumen Pendukung
                        </h5>
                        <div class="p-6 bg-slate-50 border border-slate-200 rounded-[2rem] shadow-inner">
                            <p class="text-xs text-slate-500 mb-4 italic font-bold">Dokumen yang wajib disertakan untuk setiap paket:</p>
                            <ul class="text-xs space-y-3 font-black text-slate-700">
                                <li class="flex items-center gap-2"><i class="fas fa-check-circle text-green-500"></i> <span>Rencana Umum Pengadaan (RUP)</span></li>
                                <li class="flex items-center gap-2"><i class="fas fa-check-circle text-green-500"></i> <span>Kerangka Acuan Kerja (KAK)</span></li>
                                <li class="flex items-center gap-2"><i class="fas fa-check-circle text-green-500"></i> <span>Ringkasan Kontrak Kerja</span></li>
                                <li class="flex items-center gap-2"><i class="fas fa-check-circle text-green-500"></i> <span>Berita Acara Serah Terima (BAST)</span></li>
                            </ul>
                            <div class="mt-6 p-4 bg-white rounded-xl border border-orange-100 shadow-md">
                                <p class="text-[10px] text-orange-600 font-black uppercase underline italic">⚠️ Catatan Sekretariat PBJ:</p>
                                <p class="text-[10px] text-slate-500 mt-2 font-medium">Pastikan file PDF tidak dikunci password agar bisa dibaca oleh pemohon informasi.</p>
                            </div>
                        </div>
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
