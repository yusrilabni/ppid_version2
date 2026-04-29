<div x-show="$store.pedomanAdminModal.activeTab === 1" x-transition 
     x-transition:enter="transition ease-out duration-300"
     class="space-y-12">
    
    <!-- Header Tab -->
    <div class="flex items-center gap-4 border-l-8 border-blue-600 pl-4 uppercase tracking-tighter">
        <div>
            <h4 class="text-2xl font-black text-slate-800 leading-none">Manajemen Informasi Publik</h4>
            <p class="text-[10px] text-slate-400 font-bold tracking-[0.3em] mt-1 italic">Panduan Klasifikasi & Siklus Hidup Dokumen</p>
        </div>
    </div>

    <!-- LOGIKA MENDALAM (WHY) -->
    <div class="space-y-8 font-black uppercase">
        <h5 class="text-sm font-black flex items-center gap-3 border-b-2 border-slate-100 pb-2 text-slate-700 italic">
            <i class="fas fa-balance-scale text-blue-600"></i> Mengapa Harus Diklasifikasikan?
        </h5>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 leading-relaxed font-black tracking-tighter uppercase">
            <!-- BERKALA -->
            <div class="bg-blue-50 p-10 rounded-[3rem] border-2 border-blue-100 relative overflow-hidden shadow-xl shadow-blue-100/50 group">
                <div class="absolute -right-8 -top-8 w-40 h-40 bg-blue-100 rounded-full opacity-30 group-hover:scale-110 transition-transform duration-1000"></div>
                <div class="relative z-10">
                    <h6 class="font-black text-blue-900 mb-4 flex items-center gap-3 text-base italic underline underline-offset-8 decoration-4 decoration-blue-200">
                        <i class="fas fa-calendar-alt"></i> 1. Informasi Berkala
                    </h6>
                    <p class="text-[11px] text-justify mb-8 leading-loose tracking-widest font-black">
                        Dokumen ini adalah <strong>Kewajiban Akuntabilitas Rutin</strong> (Pasal 9 UU KIP). Wajib diperbarui sesuai siklus anggaran. Sifatnya <strong>Update Terkini (Ganti Data)</strong>. Data 2024 menggantikan 2023.
                    </p>
                    <div class="space-y-4">
                        <div class="bg-white/80 p-5 rounded-[2rem] border-l-8 border-blue-500 shadow-md italic text-[10px] text-blue-800">
                            <span class="block font-black underline mb-1 uppercase">Studi Logika Rutin:</span>
                            "Setiap dokumen dengan <strong>Siklus Waktu Tetap</strong> (Renstra, LRA) WAJIB masuk kategori ini. Data lama wajib masuk <strong>ARSIP</strong>."
                        </div>
                        <div class="bg-red-50 p-5 rounded-[2rem] border-l-8 border-red-500 shadow-md italic text-[10px] text-red-800">
                            <span class="block font-black underline mb-1 uppercase tracking-widest">Wajib Dipatuhi:</span>
                            "Segera ubah status data lama menjadi ARSIP saat ada data baru, agar publik tidak salah ambil referensi!"
                        </div>
                    </div>
                </div>
            </div>

            <!-- SETIAP SAAT -->
            <div class="bg-emerald-50 p-10 rounded-[3rem] border-2 border-emerald-100 relative overflow-hidden shadow-xl shadow-emerald-100/50 group">
                <div class="absolute -right-8 -top-8 w-40 h-40 bg-emerald-100 rounded-full opacity-30 group-hover:scale-110 transition-transform duration-1000"></div>
                <div class="relative z-10">
                    <h6 class="font-black text-emerald-900 mb-4 flex items-center gap-3 text-base italic underline underline-offset-8 decoration-4 decoration-emerald-200">
                        <i class="fas fa-archive"></i> 2. Informasi Setiap Saat
                    </h6>
                    <p class="text-[11px] text-justify mb-8 leading-loose tracking-widest font-black">
                        Dokumen ini adalah <strong>Catatan Histori & Produk Kebijakan</strong> (Pasal 11 UU KIP). Wajib sedia kapanpun diminta. Sifatnya <strong>Akumulatif (Menumpuk)</strong>. Semua data tahun lama tetap BERLAKU.
                    </p>
                    <div class="bg-white/80 p-5 rounded-[2rem] border-l-8 border-emerald-500 shadow-md italic text-[10px] text-emerald-800">
                        <span class="block font-black underline mb-1 uppercase">Studi Logika Kebijakan:</span>
                        "Dokumen berupa <strong>Ketetapan Hukum</strong> (SK, MoU) WAJIB masuk kategori ini. Dokumen berlaku permanen selama tidak dicabut pimpinan."
                    </div>
                </div>
            </div>
        </div>

        <!-- DARURAT & RAHASIA -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 font-black tracking-widest italic uppercase">
            <div class="bg-red-50 p-6 rounded-[2.5rem] border-2 border-red-100 flex items-center gap-5 shadow-lg">
                <div class="bg-white p-4 rounded-2xl text-red-600 shadow-md"><i class="fas fa-bolt text-xl"></i></div>
                <div>
                    <h6 class="text-xs text-red-900 font-black underline underline-offset-4 decoration-4 mb-1">3. Serta Merta (Darurat)</h6>
                    <p class="text-[10px] text-red-700">Mendesak! Wajib upload detik itu juga! <br>(Contoh: Banjir, Wabah).</p>
                </div>
            </div>
            <div class="bg-slate-900 p-6 rounded-[2.5rem] border-2 border-slate-800 flex items-center gap-5 shadow-lg text-white">
                <div class="bg-slate-800 p-4 rounded-2xl text-slate-400 shadow-md"><i class="fas fa-user-secret text-xl"></i></div>
                <div>
                    <h6 class="text-xs text-slate-300 font-black underline underline-offset-4 decoration-4 mb-1">4. Dikecualikan (Rahasia)</h6>
                    <p class="text-[10px] text-slate-400 text-indigo-400">Data Rahasia (Pasal 17). Tidak tampil di publik. <br>(Contoh: Rekam Medis).</p>
                </div>
            </div>
        </div>
    </div>

    <!-- TUTORIAL FORM A - H (DETAILED TIMELINE) -->
    <div class="space-y-12 font-black uppercase">
        <h5 class="text-sm font-black flex items-center gap-3 border-b-2 border-slate-100 pb-2 text-slate-700 italic">
            <i class="fas fa-stream text-indigo-600"></i> Alur Detail Pengisian Formulir (Langkah A - H)
        </h5>

        <div class="bg-slate-50 rounded-[4rem] border-4 border-slate-100 p-12 space-y-16 shadow-inner relative overflow-hidden font-black">
            <!-- A: JUDUL -->
            <div class="flex flex-col md:flex-row gap-12 items-start group">
                <div class="flex-1 space-y-4">
                    <div class="flex gap-6 items-center">
                        <span class="w-14 h-14 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-2xl shadow-xl shadow-indigo-200">A</span>
                        <h6 class="text-xl font-black italic tracking-tighter">Judul Informasi</h6>
                    </div>
                    <p class="ml-20 text-[11px] text-slate-500 italic underline decoration-2 underline-offset-4 font-black">Format Baku: Nama Dokumen + Unit + Tahun.</p>
                </div>
                <div class="md:w-80 bg-white p-5 rounded-3xl border-4 border-indigo-50 shadow-2xl relative transition-transform group-hover:scale-105">
                    <div class="h-12 w-full border-2 border-indigo-200 rounded-2xl bg-indigo-50/30 flex items-center px-5 text-[10px] text-indigo-400 italic font-black shadow-inner">Renja Dinas Perumahan 2024...</div>
                    <div class="absolute -left-6 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[15px] border-y-transparent border-r-[25px] border-r-indigo-600 shadow-xl shadow-indigo-600/30"></div>
                </div>
            </div>

            <!-- B: DESKRIPSI -->
            <div class="flex flex-col md:flex-row gap-12 items-start border-t-2 border-dashed border-slate-200 pt-16">
                <div class="flex-1 space-y-6">
                    <div class="flex gap-6 items-center">
                        <span class="w-14 h-14 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-2xl shadow-xl shadow-indigo-200">B</span>
                        <h6 class="text-xl font-black italic tracking-tighter">Deskripsi & Lampiran</h6>
                    </div>
                    <div class="ml-20 space-y-6">
                        <p class="text-xs text-slate-500 italic underline decoration-2 font-black">Berikan Ringkasan Isi Dokumen.</p>
                        <div class="bg-amber-100 p-8 rounded-[3rem] border-4 border-amber-300 shadow-2xl shadow-amber-200/50 italic text-amber-900 leading-relaxed font-black">
                            <h6 class="uppercase mb-4 underline decoration-4 decoration-amber-500 italic tracking-widest flex items-center gap-2"><i class="fas fa-exclamation-triangle"></i> Dokumen Pelengkap (WAJIB):</h6>
                            <p class="text-[11px] underline underline-offset-4 decoration-2 leading-loose">"Jika lampiran banyak (LRA + Lampiran A-Z), wajib GABUNGKAN DALAM 1 PDF atau gunakan opsi Link File Google Drive unit Bapak!"</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- C, D, E, F (GRID MOCKUP) -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-10 ml-20 border-t-2 border-dashed border-slate-200 pt-16 font-black tracking-widest">
                <div class="space-y-4">
                    <div class="flex gap-4 items-center"><span class="w-10 h-10 bg-indigo-500 text-white rounded-full flex items-center justify-center text-sm shadow-xl shadow-indigo-200">C</span><h6 class="text-[11px] font-black italic underline">Kategori</h6></div>
                    <div class="bg-white border-4 border-slate-200 rounded-2xl p-3 text-[9px] italic text-slate-400 shadow-lg font-black uppercase">INFORMASI BERKALA <i class="fas fa-chevron-down float-right mt-1 text-indigo-400"></i></div>
                </div>
                <div class="space-y-4">
                    <div class="flex gap-4 items-center"><span class="w-10 h-10 bg-indigo-500 text-white rounded-full flex items-center justify-center text-sm shadow-xl shadow-indigo-200">D</span><h6 class="text-[11px] font-black italic underline">Jenis Dokumen</h6></div>
                    <div class="bg-white border-4 border-slate-200 rounded-2xl p-3 text-[9px] italic text-blue-600 shadow-lg font-black uppercase tracking-widest">Dokumen Keuangan <i class="fas fa-search float-right mt-1 text-indigo-400"></i></div>
                </div>
                <div class="space-y-4">
                    <div class="flex gap-4 items-center"><span class="w-10 h-10 bg-indigo-500 text-white rounded-full flex items-center justify-center text-sm shadow-xl shadow-indigo-200">E</span><h6 class="text-[11px] font-black italic underline">Tagging</h6></div>
                    <div class="flex gap-2 flex-wrap"><span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-[8px] font-black shadow-sm">#2024</span><span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-[8px] font-black shadow-sm">#RENJA</span></div>
                </div>
                <div class="space-y-4">
                    <div class="flex gap-4 items-center"><span class="w-10 h-10 bg-indigo-500 text-white rounded-full flex items-center justify-center text-sm shadow-xl shadow-indigo-200">F</span><h6 class="text-[11px] font-black italic underline">Thumbnail</h6></div>
                    <div class="w-24 h-12 bg-slate-200 rounded-xl border-4 border-dashed border-slate-300 flex items-center justify-center text-[9px] text-slate-400 font-black italic uppercase shadow-inner">UPLOAD JPG</div>
                </div>
            </div>

            <!-- G & H (FINAL ACTION CARD) -->
            <div class="flex flex-col md:flex-row gap-12 items-stretch border-t-2 border-dashed border-slate-200 pt-16 font-black tracking-widest italic">
                <div class="flex-1 space-y-6">
                    <div class="flex gap-6 items-center">
                        <span class="w-14 h-14 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-2xl shadow-xl shadow-indigo-200">G</span>
                        <h6 class="text-xl font-black italic">Tanggal Terbit</h6>
                    </div>
                    <div class="ml-20 bg-white p-4 rounded-2xl border-4 border-slate-100 text-xs font-black shadow-2xl w-56 flex justify-between items-center group cursor-pointer hover:border-indigo-100">
                        <span>PILIH TANGGAL...</span> <i class="fas fa-calendar-day text-indigo-500 text-xl group-hover:scale-125 transition-transform"></i>
                    </div>
                </div>
                <div class="flex-1 bg-gradient-to-br from-indigo-900 to-indigo-950 rounded-[4rem] p-10 shadow-3xl relative overflow-hidden group">
                    <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-white/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                    <div class="relative z-10 space-y-8">
                        <div class="flex items-center gap-6">
                            <span class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center font-black text-3xl shadow-2xl animate-bounce border-8 border-white/10 ring-4 ring-blue-400/20">H</span>
                            <h6 class="text-2xl font-black text-white italic underline underline-offset-8 decoration-blue-500 decoration-8 uppercase tracking-widest shadow-blue-900">Langkah Final!</h6>
                        </div>
                        <p class="ml-20 text-sm text-indigo-100 font-black leading-loose uppercase tracking-widest italic decoration-white/20 underline decoration-2">
                            "Khusus <strong>BERKALA</strong>, WAJIB klik tombol kuning <span class="text-yellow-400 underline decoration-4">CHECK INFORMASI</span> untuk mematikan data tahun lama!"
                        </p>
                        <div class="flex justify-center pt-4 relative">
                            <div class="bg-yellow-500 text-white px-16 py-6 rounded-[3rem] text-sm font-black shadow-[0_30px_80px_rgba(234,179,8,0.5)] animate-bounce border-8 border-white uppercase italic tracking-widest italic shadow-inner hover:scale-110 transition-transform">CHECK INFORMASI</div>
                            <div class="absolute -left-12 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[20px] border-y-transparent border-r-[40px] border-r-yellow-500 shadow-2xl shadow-yellow-200"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BANTUAN AI ANALIS (HIGH-TECH BOX) -->
    <div class="bg-slate-900 text-white p-12 rounded-[6rem] shadow-3xl relative overflow-hidden italic font-black uppercase tracking-tighter border-[12px] border-slate-800">
        <div class="absolute -right-20 -bottom-20 opacity-10 rotate-12 scale-150"><i class="fas fa-microchip text-[30rem]"></i></div>
        <div class="relative z-10">
            <h5 class="text-3xl font-black mb-12 flex items-center gap-6 italic tracking-[0.4em] underline decoration-[10px] decoration-indigo-600 underline-offset-[16px]">
                <i class="fas fa-magic text-indigo-400 text-6xl shadow-3xl shadow-indigo-950 animate-pulse"></i> Bingung Klasifikasi? Tanya AI!
            </h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div class="space-y-10 text-base font-black tracking-[0.2em] italic">
                    <div class="flex gap-8 items-center bg-white/5 p-8 rounded-[3rem] border-4 border-white/10 shadow-2xl hover:bg-white/10 transition-all group cursor-help">
                        <span class="bg-indigo-500 text-white w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center shadow-3xl group-hover:scale-125 transition-transform border-4 border-indigo-400 ring-4 ring-indigo-500/20">1</span>
                        <p class="underline decoration-indigo-500 decoration-4 underline-offset-4">Klik "Tanya Pedoman" di pojok form.</p>
                    </div>
                    <div class="flex gap-8 items-center bg-white/5 p-8 rounded-[3rem] border-4 border-white/10 shadow-2xl hover:bg-white/10 transition-all group cursor-help">
                        <span class="bg-indigo-500 text-white w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center shadow-3xl group-hover:scale-125 transition-transform border-4 border-indigo-400 ring-4 ring-indigo-500/20">2</span>
                        <p class="italic underline decoration-green-500 decoration-4 underline-offset-4">Ketik Nama & Klik <span class="bg-green-600 px-4 py-1 rounded-2xl border-4 border-white animate-pulse shadow-green-500/50">TANYA AI</span>!</p>
                    </div>
                </div>
                <!-- Visual Mockup AI -->
                <div class="bg-white/5 backdrop-blur-3xl rounded-[5rem] p-10 border-4 border-white/10 shadow-3xl group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500/10 via-transparent to-emerald-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
                    <div class="bg-white rounded-[4rem] p-10 space-y-8 shadow-3xl relative z-10 transition-transform duration-1000 group-hover:scale-105 group-hover:rotate-1">
                        <div class="h-6 w-48 bg-slate-100 rounded-full shadow-inner mb-8 animate-pulse"></div>
                        <div class="h-20 w-full border-8 border-slate-200 rounded-[2.5rem] bg-slate-50 flex items-center px-10 text-2xl text-slate-400 italic font-black uppercase tracking-tighter shadow-inner">Laporan LRA Dinas...</div>
                        <div class="flex justify-end relative mt-8">
                            <div class="bg-green-600 text-white px-12 py-6 rounded-[2.5rem] text-xl font-black shadow-[0_35px_100px_rgba(22,163,74,0.6)] animate-bounce border-8 border-white uppercase italic tracking-widest italic shadow-green-900/40">TANYA AI</div>
                            <div class="absolute -left-16 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[25px] border-y-transparent border-r-[45px] border-r-indigo-500 drop-shadow-3xl shadow-indigo-600"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- REKAPITULASI DOKUMEN (FINAL SECTION) -->
    <div class="bg-white border-[16px] border-slate-50 rounded-[6rem] p-20 shadow-3xl relative overflow-hidden font-black italic uppercase tracking-tighter text-slate-500 shadow-inner">
        <div class="absolute top-0 left-0 w-full h-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-emerald-600 shadow-2xl"></div>
        <h5 class="text-3xl font-black text-slate-800 mb-16 text-center uppercase tracking-[0.5em] italic border-b-8 border-slate-50 pb-6 underline underline-offset-[20px] decoration-slate-100">Standar Dokumen Wajib Per Unit</h5>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-16 font-black tracking-widest">
            <!-- DINAS -->
            <div class="space-y-8 border-r-4 border-dashed border-slate-100 pr-10">
                <p class="text-xl font-black text-blue-600 border-b-8 border-blue-50 pb-4 italic underline underline-offset-8 decoration-8 flex items-center gap-3 uppercase"><i class="fas fa-building text-4xl"></i> Dinas / RSUD</p>
                <ul class="text-[11px] space-y-6 list-disc list-inside leading-loose font-black italic shadow-indigo-50">
                    <li class="hover:translate-x-3 transition-transform hover:text-blue-700">Renstra & Renja (5 thn & thn)</li>
                    <li class="hover:translate-x-3 transition-transform hover:text-blue-700">DPA & RKA Anggaran Unit</li>
                    <li class="hover:translate-x-3 transition-transform hover:text-blue-700">LRA & Neraca Keuangan</li>
                    <li class="hover:translate-x-3 transition-transform hover:text-blue-700">Tarif Layanan & SPM (RSUD)</li>
                    <li class="hover:translate-x-3 transition-transform hover:text-blue-700">LHKPN Pejabat Utama</li>
                </ul>
            </div>
            <!-- INSPEKTORAT -->
            <div class="space-y-8 border-r-4 border-dashed border-slate-100 pr-10">
                <p class="text-xl font-black text-indigo-600 border-b-8 border-indigo-50 pb-4 italic underline underline-offset-8 decoration-8 flex items-center gap-3 uppercase"><i class="fas fa-search-dollar text-4xl"></i> Inspektorat</p>
                <ul class="text-[11px] space-y-6 list-disc list-inside leading-loose font-black italic text-justify shadow-indigo-50">
                    <li class="hover:translate-x-3 transition-transform hover:text-indigo-700">PKPT (Program Kerja Audit)</li>
                    <li class="hover:translate-x-3 transition-transform hover:text-indigo-700">Ringkasan LHP Publik</li>
                    <li class="hover:translate-x-3 transition-transform hover:text-indigo-700">SOP Audit Pengawasan</li>
                    <li class="hover:translate-x-3 transition-transform hover:text-indigo-700">Laporan Akuntabilitas</li>
                </ul>
            </div>
            <!-- KEC/DESA -->
            <div class="space-y-8">
                <p class="text-xl font-black text-green-600 border-b-8 border-green-50 pb-4 italic underline underline-offset-8 decoration-8 flex items-center gap-3 uppercase"><i class="fas fa-map-marked-alt text-4xl"></i> Desa / Kec</p>
                <ul class="text-[11px] space-y-6 list-disc list-inside leading-loose font-black italic text-justify shadow-green-50">
                    <li class="hover:translate-x-3 transition-transform hover:text-green-700">APBDes / RKPDes (Anggaran)</li>
                    <li class="hover:translate-x-3 transition-transform hover:text-green-700">LPPD Penyelenggaraan Desa</li>
                    <li class="hover:translate-x-3 transition-transform hover:text-green-700">Monografi & Profil Wilayah</li>
                    <li class="hover:translate-x-3 transition-transform hover:text-green-700">Data Inventaris Aset Desa</li>
                    <li class="hover:translate-x-3 transition-transform hover:text-green-700">Laporan PATEN (Kecamatan)</li>
                </ul>
            </div>
        </div>
    </div>
</div>