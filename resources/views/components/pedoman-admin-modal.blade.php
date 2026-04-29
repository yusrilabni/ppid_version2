<div x-show="$store.pedomanAdminModal.open" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 z-[110] bg-slate-900/95 backdrop-blur-sm flex items-center justify-center p-4 md:p-6" 
     style="display: none;">
    
    <div class="bg-white w-full max-w-7xl max-h-[95vh] rounded-3xl shadow-2xl flex flex-col overflow-hidden border border-slate-200 font-sans text-slate-700">
        
        <!-- Header -->
        <div class="bg-indigo-900 px-6 py-5 flex-shrink-0 border-b border-indigo-950 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-5">
                    <div class="bg-indigo-500 p-2.5 rounded-xl shadow-lg">
                        <i class="fas fa-chalkboard-teacher text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black uppercase tracking-tight">Pedoman Operasional Admin</h3>
                        <p class="text-indigo-200 text-xs font-bold uppercase tracking-[0.2em] opacity-80 italic">Panduan Langkah-demi-Langkah Pengelolaan Portal PPID v2.0</p>
                    </div>
                </div>
                <button @click="$store.pedomanAdminModal.close()" 
                        class="bg-white/10 hover:bg-white/20 text-white transition-all p-3 rounded-xl">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Tab Navigation (FIXED STICKY) -->
        <div class="bg-slate-50 border-b border-slate-200 flex overflow-x-auto no-scrollbar sticky top-0 z-50 shadow-md">
            <template x-for="(tab, index) in $store.pedomanAdminModal.tabs" :key="index">
                <button @click="$store.pedomanAdminModal.activeTab = index"
                        :class="$store.pedomanAdminModal.activeTab === index ? 'border-indigo-600 text-indigo-700 bg-white shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700'"
                        class="px-8 py-4 border-b-4 font-black text-xs whitespace-nowrap transition-all flex items-center gap-3 min-h-[64px] uppercase tracking-widest">
                    <i :class="tab.icon" class="text-base"></i>
                    <span x-text="tab.title"></span>
                </button>
            </template>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-6 md:p-12 bg-white space-y-16">
            
            <!-- Tab 0: MENU PROFIL -->
            <div x-show="$store.pedomanAdminModal.activeTab === 0" x-transition class="space-y-12">
                <div class="flex items-center gap-4 border-l-8 border-indigo-600 pl-4 uppercase tracking-tighter">
                    <h4 class="text-2xl font-black text-slate-800">Pengelolaan Profil OPD & Pimpinan</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Struktur & Website -->
                    <div class="bg-slate-50 p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
                        <h5 class="font-black text-indigo-700 mb-6 flex items-center gap-3 uppercase text-sm tracking-widest">
                            <span class="bg-indigo-100 w-8 h-8 rounded-full flex items-center justify-center font-black shadow-sm text-xs">1</span>
                            Struktur & Website OPD
                        </h5>
                        <ul class="space-y-4 text-sm mb-8 leading-relaxed font-bold">
                            <li class="flex gap-3">
                                <i class="fas fa-mouse-pointer text-indigo-500 mt-0.5"></i>
                                <span>Klik menu <strong>Profil</strong> > <strong>Tentang OPD</strong></span>
                            </li>
                            <li class="flex gap-3">
                                <i class="fas fa-search text-indigo-500 mt-0.5"></i>
                                <span>Cari unit, klik tombol <span class="bg-white text-blue-600 border-2 border-blue-200 px-2 py-0.5 rounded-lg text-[10px] font-black uppercase shadow-sm">KELOLA PROFIL UNIT</span></span>
                            </li>
                        </ul>
                        <div class="space-y-4 border-t pt-6">
                            <div class="flex gap-4 bg-white p-4 rounded-2xl border border-slate-100 shadow-inner items-center font-black uppercase italic text-[10px]">
                                <div class="flex-1 text-slate-500 tracking-tighter">A. Upload Gambar Struktur (JPG/PNG).</div>
                                <div class="w-32 bg-slate-50 border-2 border-dashed border-slate-300 rounded-xl flex items-center justify-center relative py-4">
                                    <i class="fas fa-sitemap text-slate-300 text-xl"></i>
                                    <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[10px] border-r-indigo-500 shadow-lg"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Pimpinan -->
                    <div class="bg-slate-50 p-8 rounded-[2.5rem] border border-slate-200 shadow-sm text-sm font-bold uppercase tracking-tighter">
                        <h5 class="font-black text-indigo-700 mb-6 flex items-center gap-3 uppercase text-sm tracking-widest">
                            <span class="bg-indigo-100 w-8 h-8 rounded-full flex items-center justify-center font-black shadow-sm text-xs">2</span>
                            Data Pimpinan & Pejabat
                        </h5>
                        <ul class="space-y-4 mb-8 leading-relaxed">
                            <li class="flex gap-3">
                                <i class="fas fa-edit text-indigo-500 mt-0.5"></i>
                                <span>Cari nama, klik tombol <span class="bg-amber-500 text-white px-2 py-0.5 rounded-lg text-[10px] font-black uppercase shadow-md">KELOLA PIMPINAN</span>.</span>
                            </li>
                            <li class="bg-amber-100/50 p-4 rounded-2xl border-2 border-amber-200 text-[11px] font-black text-amber-800 italic flex items-start gap-3 leading-loose">
                                <i class="fas fa-info-circle text-lg"></i> 
                                <span>WAJIB: Isi Tab Identitas (Nama Lengkap + Gelar & Status Aktif). Riwayat/Penghargaan Opsional.</span>
                            </li>
                        </ul>
                        <div class="flex justify-center pt-2">
                            <div class="bg-blue-600 text-white px-10 py-3 rounded-2xl text-xs font-black animate-bounce shadow-2xl border-4 border-white uppercase tracking-widest">SIMPAN PROFIL</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 1: JENIS INFORMASI (FULL RESTORED & DETAILED) -->
            <div x-show="$store.pedomanAdminModal.activeTab === 1" x-transition class="space-y-16">
                <div class="flex items-center gap-4 border-l-8 border-blue-600 pl-4 uppercase tracking-tighter">
                    <h4 class="text-2xl font-black text-slate-800 italic underline underline-offset-4 decoration-blue-100">Klasifikasi & Panduan Operasional Informasi</h4>
                </div>

                <!-- BAGIAN: LOGIKA MENDALAM -->
                <div class="space-y-10">
                    <h5 class="text-xl font-black flex items-center gap-3 border-b-4 border-blue-100 pb-3 uppercase text-slate-800 italic tracking-widest">
                        <i class="fas fa-balance-scale text-blue-600 text-2xl"></i> Mengapa Harus Diklasifikasikan?
                    </h5>
                    
                    <div class="grid grid-cols-1 gap-10 text-sm leading-relaxed font-bold uppercase tracking-tighter">
                        <!-- BERKALA -->
                        <div class="bg-blue-50 p-12 rounded-[4rem] border-2 border-blue-200 relative overflow-hidden shadow-sm">
                            <div class="absolute top-0 right-0 p-12 opacity-5"><i class="fas fa-history text-[10rem] text-blue-900"></i></div>
                            <h6 class="font-black text-blue-900 mb-6 uppercase tracking-[0.2em] flex items-center gap-3 text-lg italic underline decoration-blue-200 underline-offset-8 decoration-4">
                                <i class="fas fa-calendar-alt"></i> 1. Informasi Berkala (Kewajiban Rutin)
                            </h6>
                            <p class="mb-8 text-base text-justify leading-loose">Dokumen diklasifikasikan sebagai <strong>Informasi Berkala</strong> karena merupakan <strong>Kewajiban Akuntabilitas Rutin</strong>. Wajib ada dan diperbarui terjadwal (tahunan/semesteran) sesuai siklus anggaran. Sifatnya <strong>Ganti Data (Update)</strong>. Dokumen terbaru (2024) WAJIB mematikan validitas dokumen lama (2023) menjadi <strong>ARSIP</strong>.</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="bg-white/80 p-6 rounded-[2.5rem] border-4 border-blue-100 shadow-xl italic text-blue-800 text-xs font-black">
                                    <p class="uppercase underline decoration-4 mb-3 italic tracking-widest">Studi Logika Rutin:</p>
                                    <span class="leading-relaxed">"Setiap dokumen dengan <strong>Siklus Waktu Tetap</strong> (seperti Renstra, Anggaran, atau Laporan Kinerja) WAJIB masuk kategori <strong>BERKALA</strong>. Data lama wajib masuk <strong>ARSIP</strong>."</span>
                                </div>
                                <div class="bg-white/80 p-6 rounded-[2.5rem] border-4 border-red-100 shadow-xl italic text-red-700 text-xs font-black">
                                    <p class="uppercase underline decoration-4 mb-3 italic tracking-widest">Penting:</p>
                                    <span class="leading-relaxed">"Wajib mengubah status data lama menjadi ARSIP ketika ada dokumen baru yang BERLAKU, agar publik selalu mendapatkan referensi yang akurat."</span>
                                </div>
                            </div>
                        </div>

                        <!-- SETIAP SAAT -->
                        <div class="bg-emerald-50 p-12 rounded-[4rem] border-2 border-emerald-200 relative overflow-hidden shadow-sm text-emerald-900">
                            <div class="absolute top-0 right-0 p-12 opacity-5"><i class="fas fa-folder-open text-[10rem] text-emerald-900"></i></div>
                            <h6 class="font-black mb-6 uppercase tracking-[0.2em] flex items-center gap-3 text-lg italic underline decoration-emerald-200 underline-offset-8 decoration-4">
                                <i class="fas fa-archive"></i> 2. Informasi Setiap Saat (Catatan Sejarah)
                            </h6>
                            <p class="mb-8 text-base text-justify leading-loose">Dokumen masuk kategori ini berdasarkan <strong>Pasal 11 UU KIP</strong> karena merupakan <strong>Catatan Histori & Produk Kebijakan</strong>. Wajib sedia kapanpun diminta. Sifatnya <strong>Akumulatif (Menumpuk)</strong>. Semua data tahun lama hingga sekarang tetap BERLAKU sebagai database sejarah kebijakan unit Bapak.</p>
                            <div class="bg-white/80 p-8 rounded-[2.5rem] border-4 border-emerald-100 shadow-xl italic text-emerald-800 text-xs font-black leading-loose">
                                <p class="uppercase underline decoration-4 mb-3 italic tracking-widest">Studi Logika Kebijakan:</p>
                                <span>"Dokumen berupa <strong>Ketetapan Hukum</strong> (seperti SK Kadis, MoU Kerjasama) WAJIB masuk kategori <strong>SETIAP SAAT</strong> karena berlaku permanen selama belum dicabut pimpinan."</span>
                            </div>
                        </div>

                        <!-- SERTA MERTA & DIKECUALIKAN -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="bg-red-50 p-8 rounded-[3rem] border-4 border-red-200 text-xs font-black shadow-lg">
                                <h6 class="text-red-900 mb-4 uppercase underline underline-offset-4 decoration-4 italic text-sm">3. Serta Merta (Darurat)</h6>
                                <p class="leading-relaxed text-slate-700">Mendesak & Mengancam Nyawa. Wajib upload detik itu juga! <br><span class="text-red-600 underline decoration-2">(Contoh: Info Banjir, Wabah, Bencana Alam).</span></p>
                            </div>
                            <div class="bg-slate-900 p-8 rounded-[3rem] border-4 border-slate-700 text-xs font-black shadow-lg text-white">
                                <h6 class="text-slate-300 mb-4 uppercase underline underline-offset-4 decoration-4 italic text-sm">4. Dikecualikan (Rahasia)</h6>
                                <p class="leading-relaxed text-slate-400">Data Rahasia (Pasal 17 UU KIP). Tidak tampil di publik. <br><span class="text-indigo-400 italic underline decoration-2">(Contoh: Rekam Medis, Rahasia Bisnis, Dokumen Hukum).</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN: TUTORIAL FORM LENGKAP A - H (RESTORED 100%) -->
                <div class="space-y-12">
                    <h5 class="text-xl font-black flex items-center gap-4 border-b-4 border-slate-100 pb-4 uppercase text-slate-800 italic tracking-widest">
                        <i class="fas fa-keyboard text-indigo-600 text-2xl"></i> Tutorial Pengisian Formulir (A - H)
                    </h5>

                    <div class="bg-slate-50 rounded-[4rem] border-4 border-slate-200 p-12 space-y-16 shadow-inner font-black uppercase tracking-tighter">
                        <!-- A: JUDUL -->
                        <div class="flex flex-col md:flex-row gap-10 items-start border-b-2 border-dashed border-slate-200 pb-12">
                            <div class="flex-1 space-y-4">
                                <div class="flex gap-5 items-center">
                                    <span class="w-12 h-12 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-xl shadow-xl shadow-indigo-200">A</span>
                                    <h6 class="text-lg font-black tracking-tight">Judul Informasi</h6>
                                </div>
                                <p class="ml-16 text-sm text-slate-500 italic underline underline-offset-4 decoration-2">Wajib Baku: Nama Dokumen + Unit + Tahun.</p>
                                <p class="ml-16 text-[11px] text-indigo-600 italic leading-relaxed font-black">Contoh: "Renja Dinas Perumahan 2024".</p>
                            </div>
                            <div class="md:w-80 bg-white p-5 rounded-2xl border-4 border-indigo-100 shadow-2xl relative">
                                <div class="h-12 w-full border-2 border-indigo-200 rounded-xl bg-indigo-50/50 flex items-center px-5 text-[10px] text-indigo-400 italic font-black shadow-inner">Renja Dinas... 2024...</div>
                                <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[12px] border-y-transparent border-r-[18px] border-r-indigo-600 shadow-xl"></div>
                            </div>
                        </div>

                        <!-- B: DESKRIPSI & PELENGKAP -->
                        <div class="flex flex-col md:flex-row gap-10 items-start border-b-2 border-dashed border-slate-200 pb-12">
                            <div class="flex-1 space-y-6">
                                <div class="flex gap-5 items-center">
                                    <span class="w-12 h-12 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-xl shadow-xl shadow-indigo-200">B</span>
                                    <h6 class="text-lg font-black tracking-tight">Deskripsi & Lampiran</h6>
                                </div>
                                <div class="ml-16 space-y-6 text-sm">
                                    <p class="text-slate-500 italic underline decoration-2 underline-offset-4">Ringkasan isi dokumen bagi masyarakat.</p>
                                    <div class="bg-amber-100 p-8 rounded-[3rem] border-4 border-amber-300 shadow-xl shadow-amber-200/50 relative overflow-hidden italic text-amber-900 font-black">
                                        <div class="absolute top-0 right-0 p-8 opacity-10"><i class="fas fa-file-pdf text-7xl"></i></div>
                                        <h6 class="font-black uppercase mb-4 underline decoration-4 decoration-amber-500 italic flex items-center gap-2 tracking-widest"><i class="fas fa-exclamation-triangle"></i> Dokumen Pelengkap (WAJIB):</h6>
                                        <p class="leading-loose uppercase tracking-tighter underline underline-offset-4 decoration-2 decoration-amber-300">"Jika laporan Bapak memiliki lampiran banyak (DPA + Lampiran A-Z), wajib GABUNGKAN DALAM 1 PDF atau gunakan opsi Link File Google Drive unit Bapak!"</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- C: KATEGORI & D: JENIS -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 border-b-2 border-dashed border-slate-200 pb-12">
                            <div class="space-y-6">
                                <div class="flex gap-5 items-center">
                                    <span class="w-12 h-12 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-xl shadow-xl shadow-indigo-200">C</span>
                                    <h6 class="text-lg font-black tracking-tight uppercase">Kategori (Klasifikasi)</h6>
                                </div>
                                <p class="ml-16 text-xs text-slate-500 leading-relaxed italic">"Pilih Klasifikasi (Berkala/Setiap Saat/Serta Merta) sesuai sifat dokumen Bapak."</p>
                                <div class="ml-16 bg-white p-3 rounded-xl border border-slate-200 text-[10px] font-black italic shadow-sm">INFORMASI BERKALA <i class="fas fa-chevron-down float-right mt-1"></i></div>
                            </div>
                            <div class="space-y-6">
                                <div class="flex gap-5 items-center">
                                    <span class="w-12 h-12 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-xl shadow-xl shadow-indigo-200">D</span>
                                    <h6 class="text-lg font-black tracking-tight uppercase">Jenis Dokumen</h6>
                                </div>
                                <p class="ml-16 text-xs text-slate-500 leading-relaxed italic">"Pilih Jenis (misal: Dokumen Keuangan) agar data Bapak muncul otomatis di folder yang tepat di beranda."</p>
                                <div class="ml-16 bg-white p-3 rounded-xl border border-slate-200 text-[10px] font-black italic shadow-sm text-indigo-600 uppercase tracking-widest">DOKUMEN KEUANGAN <i class="fas fa-folder-open float-right mt-1"></i></div>
                            </div>
                        </div>

                        <!-- E: TAGS & F: THUMBNAIL -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 border-b-2 border-dashed border-slate-200 pb-12">
                            <div class="space-y-6">
                                <div class="flex gap-5 items-center">
                                    <span class="w-12 h-12 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-xl shadow-xl shadow-indigo-200">E</span>
                                    <h6 class="text-lg font-black tracking-tight uppercase">Tag / Kata Kunci</h6>
                                </div>
                                <p class="ml-16 text-xs text-slate-500 leading-relaxed italic">"Opsional: Masukkan kata kunci pencarian (misal: Renja, 2024, Unit Bapak)."</p>
                                <div class="ml-16 flex gap-2 flex-wrap">
                                    <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-[9px] font-bold">#2024</span>
                                    <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-[9px] font-bold">#DPA</span>
                                </div>
                            </div>
                            <div class="space-y-6">
                                <div class="flex gap-5 items-center">
                                    <span class="w-12 h-12 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-xl shadow-xl shadow-indigo-200">F</span>
                                    <h6 class="text-lg font-black tracking-tight uppercase">Thumbnail / Cover</h6>
                                </div>
                                <p class="ml-16 text-xs text-slate-500 leading-relaxed italic">"Opsional: Upload gambar cover depan dokumen agar lebih visual di beranda."</p>
                                <div class="ml-16 w-20 h-10 bg-slate-200 rounded-lg border-2 border-dashed border-slate-300 flex items-center justify-center italic text-[8px] text-slate-400 uppercase">COVER JPG</div>
                            </div>
                        </div>

                        <!-- G: TANGGAL & H: FINALISASI (CHECK SIMILARITY) -->
                        <div class="flex flex-col md:flex-row gap-10 items-start pt-4 font-black">
                            <div class="flex-1 space-y-6">
                                <div class="flex gap-5 items-center">
                                    <span class="w-12 h-12 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-xl shadow-xl shadow-indigo-200">G</span>
                                    <h6 class="text-lg font-black tracking-tight uppercase">Tanggal Terbit</h6>
                                </div>
                                <p class="ml-16 text-xs text-slate-500 leading-relaxed italic">"Sesuaikan dengan tanggal pengesahan dokumen Bapak."</p>
                                <div class="ml-16 bg-white p-3 rounded-xl border border-slate-200 text-[10px] font-black italic shadow-sm">29-04-2024 <i class="fas fa-calendar-alt float-right mt-1"></i></div>
                            </div>
                            <div class="flex-1 space-y-8 border-l-8 border-indigo-600 pl-10 bg-indigo-50/30 p-8 rounded-r-3xl">
                                <div class="flex gap-5 items-center">
                                    <span class="w-14 h-14 bg-blue-600 text-white rounded-full flex items-center justify-center font-black text-2xl shadow-2xl shadow-blue-200 animate-bounce border-4 border-white">H</span>
                                    <h6 class="text-xl font-black underline decoration-blue-500 decoration-8 underline-offset-8 italic">Langkah Final: Check & Simpan</h6>
                                </div>
                                <p class="ml-16 text-sm text-blue-700 italic font-black leading-loose uppercase tracking-tighter">"Khusus BERKALA, WAJIB klik <strong>CHECK INFORMASI</strong> untuk mematikan data tahun lama secara otomatis agar publik tidak bingung!"</p>
                                <div class="flex justify-center relative pt-4">
                                    <div class="bg-yellow-500 text-white px-16 py-5 rounded-[2.5rem] text-sm font-black shadow-[0_25px_60px_rgba(234,179,8,0.5)] animate-bounce border-8 border-white uppercase italic tracking-widest italic decoration-white/20 underline">CHECK INFORMASI</div>
                                    <div class="absolute -left-10 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[20px] border-y-transparent border-r-[35px] border-r-yellow-500 shadow-2xl"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BANTUAN AI -->
                <div class="bg-indigo-900 text-white p-16 rounded-[6rem] shadow-2xl relative overflow-hidden italic font-black">
                    <div class="absolute -right-10 -bottom-10 opacity-10"><i class="fas fa-microchip text-[18rem]"></i></div>
                    <div class="relative z-10">
                        <h5 class="text-3xl font-black mb-12 flex items-center gap-10 italic tracking-tighter uppercase underline decoration-[12px] decoration-indigo-700 underline-offset-[16px]">
                            <i class="fas fa-magic text-indigo-300 text-6xl shadow-indigo-950"></i> Bingung Klasifikasi? Tanya AI!
                        </h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-20 items-center text-lg">
                            <div class="space-y-12">
                                <div class="flex gap-8 items-start bg-white/5 p-10 rounded-[3rem] border-4 border-white/10 shadow-2xl transition-all hover:bg-white/10 group">
                                    <span class="bg-indigo-500 text-white w-14 h-14 rounded-full flex-shrink-0 flex items-center justify-center font-black text-2xl shadow-xl shadow-indigo-900/50 group-hover:scale-110 transition-transform">1</span>
                                    <p class="pt-2 uppercase underline decoration-indigo-400 decoration-4 underline-offset-8">Klik tombol <span class="bg-indigo-600 px-4 py-1.5 rounded-2xl border-2 border-indigo-300">Tanya Pedoman</span> di pojok kanan atas form.</p>
                                </div>
                                <div class="flex gap-8 items-start bg-white/5 p-10 rounded-[3rem] border-4 border-white/10 shadow-2xl transition-all hover:bg-white/10 group">
                                    <span class="bg-indigo-500 text-white w-14 h-14 rounded-full flex-shrink-0 flex items-center justify-center font-black text-2xl shadow-xl shadow-indigo-900/50 group-hover:scale-110 transition-transform">2</span>
                                    <p class="pt-2 italic uppercase italic underline decoration-green-500 decoration-[6px] underline-offset-[10px]">Ketik Nama Dokumen & Klik Tombol Hijau <span class="bg-green-600 px-6 py-2 rounded-2xl animate-pulse shadow-green-900/50 border-4 border-white">TANYA AI</span>!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- REKAPITULASI DOKUMEN WAJIB PER UNIT -->
                <div class="bg-white border-[16px] border-slate-100 rounded-[6rem] p-20 shadow-2xl relative overflow-hidden font-black italic uppercase tracking-tighter text-slate-500 shadow-inner">
                    <div class="absolute top-0 left-0 w-full h-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-emerald-600 shadow-lg"></div>
                    <h5 class="text-3xl font-black text-slate-800 mb-16 text-center uppercase tracking-[0.6em] italic underline decoration-8 decoration-slate-100 underline-offset-[20px]">Dokumen Wajib Per Unit Kerja</h5>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-20">
                        <!-- DINAS/RSUD -->
                        <div class="space-y-8 border-r-4 border-dashed border-slate-50 pr-10">
                            <p class="text-lg font-black text-blue-600 uppercase border-b-8 border-blue-50 pb-4 italic underline underline-offset-8 decoration-4"><i class="fas fa-building text-3xl mr-3"></i> Dinas / Badan / RSUD</p>
                            <ul class="text-xs space-y-6 list-disc list-inside leading-loose italic uppercase tracking-tighter font-black shadow-indigo-50">
                                <li class="transition-all hover:translate-x-3 hover:text-blue-700">Renstra & Renja (5 thn & thn)</li>
                                <li class="transition-all hover:translate-x-3 hover:text-blue-700">DPA & RKA Anggaran Unit</li>
                                <li class="transition-all hover:translate-x-3 hover:text-blue-700">LRA & Neraca Keuangan</li>
                                <li class="transition-all hover:translate-x-3 hover:text-blue-700">Tarif Layanan & SPM (RSUD)</li>
                                <li class="transition-all hover:translate-x-3 hover:text-blue-700">LHKPN Pejabat Utama</li>
                            </ul>
                        </div>
                        <!-- INSPEKTORAT -->
                        <div class="space-y-8 border-r-4 border-dashed border-slate-50 pr-10">
                            <p class="text-lg font-black text-indigo-600 uppercase border-b-8 border-indigo-50 pb-4 italic underline underline-offset-8 decoration-4"><i class="fas fa-search-dollar text-3xl mr-3"></i> Inspektorat</p>
                            <ul class="text-xs space-y-6 list-disc list-inside leading-loose italic uppercase tracking-tighter font-black shadow-indigo-50">
                                <li class="transition-all hover:translate-x-3 hover:text-indigo-700">PKPT (Program Kerja Audit)</li>
                                <li class="transition-all hover:translate-x-3 hover:text-indigo-700">Ringkasan LHP Publik</li>
                                <li class="transition-all hover:translate-x-3 hover:text-indigo-700">SOP Audit Pengawasan</li>
                                <li class="transition-all hover:translate-x-3 hover:text-indigo-700">Laporan Akuntabilitas</li>
                            </ul>
                        </div>
                        <!-- DESA/KEC -->
                        <div class="space-y-8">
                            <p class="text-lg font-black text-green-600 uppercase border-b-8 border-green-50 pb-4 italic underline underline-offset-8 decoration-4"><i class="fas fa-map-marked-alt text-3xl mr-3"></i> Kecamatan / Desa / Kel</p>
                            <ul class="text-xs space-y-6 list-disc list-inside leading-loose italic uppercase tracking-tighter font-black shadow-green-50">
                                <li class="transition-all hover:translate-x-3 hover:text-green-700">APBDes / RKPDes (Anggaran)</li>
                                <li class="transition-all hover:translate-x-3 hover:text-green-700">LPPD Penyelenggaraan Desa</li>
                                <li class="transition-all hover:translate-x-3 hover:text-green-700">Monografi & Profil Wilayah</li>
                                <li class="transition-all hover:translate-x-3 hover:text-green-700">Data Inventaris Aset Desa</li>
                                <li class="transition-all hover:translate-x-3 hover:text-green-700">Laporan PATEN (Kecamatan)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: TRANSPARANSI -->
            <div x-show="$store.pedomanAdminModal.activeTab === 2" x-transition class="space-y-12 uppercase font-black italic tracking-tighter text-slate-800">
                <div class="flex items-center gap-4 border-l-8 border-green-600 pl-4 uppercase tracking-tighter">
                    <h4 class="text-2xl font-black italic underline underline-offset-4 decoration-green-100 decoration-8">Alur Layanan Permohonan Informasi</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 font-black uppercase italic tracking-tighter">
                    <div class="bg-slate-900 rounded-[4rem] p-12 text-white relative overflow-hidden shadow-2xl transition-all hover:scale-[1.02] border-8 border-slate-800">
                        <h5 class="text-xl font-black mb-10 underline decoration-indigo-500 decoration-8 underline-offset-8">Mengarahkan Pemohon</h5>
                        <div class="space-y-8">
                            <div class="flex gap-6 items-start bg-white/10 p-6 rounded-[2.5rem] border-4 border-white/20">
                                <span class="bg-green-500 text-white w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center font-black">1</span>
                                <p class="text-xs leading-loose pt-1 uppercase">Minta warga login ke portal PPID.</p>
                            </div>
                            <div class="flex gap-6 items-start bg-white/10 p-6 rounded-[2.5rem] border-4 border-white/20">
                                <span class="bg-green-500 text-white w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center font-black">2</span>
                                <p class="text-xs leading-loose pt-1 uppercase italic underline decoration-green-400">Pilih menu Transparansi > Permohonan.</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border-[12px] border-slate-100 rounded-[5rem] p-12 shadow-2xl">
                        <h5 class="text-xl font-black text-slate-800 mb-10 underline decoration-blue-500 decoration-8 underline-offset-8">Admin Merespon</h5>
                        <div class="p-10 bg-blue-50 rounded-[4rem] border-8 border-blue-100 shadow-inner">
                            <ol class="text-xs text-slate-600 space-y-6 list-decimal list-inside font-black italic tracking-tighter uppercase leading-loose">
                                <li class="bg-white p-5 rounded-[2rem] shadow-xl border-4 border-blue-100">Buka Dashboard Permohonan.</li>
                                <li class="bg-white p-5 rounded-[2rem] shadow-xl border-4 border-blue-100">Cari status <span class="text-orange-600 underline">PENDING</span>.</li>
                                <li class="bg-white p-5 rounded-[2.5rem] shadow-2xl border-8 border-blue-200 transition-all hover:scale-105 font-black text-blue-700 italic">Klik tombol biru <span class="underline">"PROSES / BALAS"</span>.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: PBJ -->
            <div x-show="$store.pedomanAdminModal.activeTab === 3" x-transition class="space-y-12 font-black italic uppercase tracking-tighter text-slate-800 uppercase italic">
                <div class="flex items-center gap-4 border-l-8 border-orange-600 pl-4 uppercase tracking-tighter">
                    <h4 class="text-2xl font-black italic underline underline-offset-8 decoration-orange-100 decoration-8">Panduan Khusus PBJ</h4>
                </div>
                <div class="bg-orange-50 p-16 rounded-[6rem] border-[12px] border-orange-100 mb-12 flex gap-12 items-start shadow-2xl relative overflow-hidden">
                    <div class="bg-orange-500 text-white p-12 rounded-[4rem] shadow-2xl animate-bounce border-8 border-white flex-shrink-0 italic shadow-orange-300">
                        <i class="fas fa-exclamation-triangle text-6xl text-white"></i>
                    </div>
                    <div class="relative z-10 pt-6 space-y-8 font-black uppercase tracking-tighter">
                        <h6 class="text-4xl font-black text-orange-900 italic underline decoration-orange-300 decoration-8 underline-offset-8">WAJIB BAGI BAGIAN PBJ!</h6>
                        <p class="text-xl text-orange-800 leading-loose font-black underline decoration-[6px] decoration-orange-100 underline-offset-[12px] italic uppercase tracking-widest">"UPDATE DATA PAKET TENDER RUTIN SESUAI PROGRES FISIK!"</p>
                    </div>
                </div>
                <ul class="text-lg space-y-12 font-black italic uppercase">
                    <li class="p-16 bg-white border-[16px] border-slate-50 rounded-[6rem] shadow-2xl flex gap-12 items-center transition-all hover:scale-105 hover:border-orange-200">
                        <span class="text-orange-500 font-black text-8xl italic tracking-tighter shadow-orange-100 text-shadow-2xl">01.</span>
                        <span class="text-2xl uppercase tracking-tighter font-black italic underline decoration-orange-100 decoration-8 underline-offset-[14px] leading-loose">Menu <strong>PBJ</strong> > <strong>Input Paket</strong>. Isi Pagu & Pemenang.</span>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Footer -->
        <div class="bg-slate-50 p-12 border-t-[12px] border-slate-100 flex flex-col md:flex-row gap-12 items-center justify-between flex-shrink-0 shadow-[0_-25px_80px_rgba(0,0,0,0.1)] relative z-50">
            <div class="flex items-center gap-10 text-slate-400 font-black uppercase tracking-[0.6em] leading-tight text-sm italic">
                <div class="flex -space-x-10">
                    <img src="https://ui-avatars.com/api/?name=Admin+PPID&background=4f46e5&color=fff" class="w-24 h-24 rounded-full border-[10px] border-white shadow-2xl shadow-indigo-200 transition-transform hover:scale-110">
                    <img src="https://ui-avatars.com/api/?name=Super+Admin&background=1e1b4b&color=fff" class="w-24 h-24 rounded-full border-[10px] border-white shadow-2xl shadow-indigo-900 transition-transform hover:scale-110">
                </div>
                <div>Portal PPID v2.0 <br><span class="text-xs font-black text-indigo-500 italic underline decoration-8 decoration-indigo-100 underline-offset-8 uppercase tracking-[0.4em]">Dinas Kominfo & Persandian Sinjai</span></div>
            </div>
            
            <div class="flex gap-10 w-full md:w-auto font-black uppercase italic tracking-tighter">
                <button @click="$store.pedomanAdminModal.prevTab()" 
                        x-show="$store.pedomanAdminModal.activeTab > 0" 
                        class="px-16 py-6 bg-white text-slate-600 rounded-[3rem] border-8 border-slate-200 text-lg hover:bg-slate-50 transition-all flex items-center gap-8 shadow-3xl active:scale-95 italic shadow-inner font-black group">
                    <i class="fas fa-arrow-left group-hover:-translate-x-3 transition-transform text-2xl"></i> SEBELUMNYA
                </button>

                <button @click="$store.pedomanAdminModal.nextTab()" 
                        class="flex-1 md:flex-none px-32 py-6 bg-indigo-700 text-white rounded-[3rem] shadow-[0_40px_100px_rgba(67,56,202,0.6)] text-xl transition-all hover:bg-indigo-800 hover:scale-[1.1] active:scale-95 border-b-[16px] border-indigo-950 uppercase italic tracking-widest italic decoration-white/20 underline decoration-4 underline-offset-8 font-black group">
                    <span x-text="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'SAYA MENGERTI, TUTUP PANDUAN' : 'LANJUT KE BERIKUTNYA'"></span>
                    <i :class="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'fas fa-check-double' : 'fas fa-arrow-right'" class="group-hover:translate-x-3 transition-transform text-2xl"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin'))
    <div class="fixed z-[105] bottom-8 right-8" x-data x-cloak>
        <button @click="$store.pedomanAdminModal.show()" 
                class="w-24 h-24 bg-indigo-700 hover:bg-indigo-800 text-white rounded-full shadow-[0_30px_80px_rgba(67,56,202,0.7)] flex items-center justify-center transition-all duration-500 hover:scale-110 active:scale-95 group relative border-[8px] border-white p-6 overflow-hidden transition-all duration-700 shadow-indigo-600/50">
            <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/10 to-white/20 opacity-0 group-hover:opacity-100 transition-opacity shadow-inner"></div>
            <i class="fas fa-chalkboard-teacher text-5xl group-hover:rotate-12 transition-transform shadow-indigo-950"></i>
            <div class="absolute bottom-full right-0 mb-10 px-8 py-5 bg-indigo-950 text-white text-[16px] font-black rounded-[3rem] opacity-0 group-hover:opacity-100 transition-all transform translate-y-12 group-hover:translate-y-0 whitespace-nowrap pointer-events-none shadow-[0_50px_120px_rgba(0,0,0,0.8)] border-[6px] border-indigo-800 uppercase tracking-widest flex items-center gap-6 italic font-black shadow-indigo-950 shadow-2xl italic underline decoration-8 decoration-indigo-700">
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
