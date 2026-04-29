<div x-show="$store.pedomanAdminModal.activeTab === 1" x-transition class="space-y-12">
    <!-- Header Section -->
    <div class="flex items-center gap-4 border-l-8 border-blue-600 pl-4 uppercase tracking-tighter">
        <div>
            <h4 class="text-2xl font-black text-slate-800 italic leading-none">Klasifikasi & Panduan Operasional</h4>
            <p class="text-[10px] text-slate-400 font-bold tracking-[0.3em] mt-1">Standar Teknis Pengisian Informasi Publik</p>
        </div>
    </div>

    <!-- LOGIKA MENDALAM (WHY) - STYLISH CARDS -->
    <div class="space-y-6">
        <h5 class="text-base font-black flex items-center gap-3 border-b-2 border-slate-100 pb-2 uppercase text-slate-700 italic">
            <i class="fas fa-balance-scale text-blue-600"></i> Mengapa Harus Diklasifikasikan?
        </h5>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- BERKALA CARD -->
            <div class="group bg-white rounded-[2.5rem] border-2 border-slate-100 p-8 shadow-xl shadow-slate-200/50 hover:border-blue-200 transition-all relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-32 h-32 bg-blue-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-blue-600 text-white p-3 rounded-2xl shadow-lg shadow-blue-200">
                            <i class="fas fa-calendar-alt text-xl"></i>
                        </div>
                        <h6 class="font-black text-blue-900 uppercase tracking-widest text-sm italic">1. Informasi Berkala</h6>
                    </div>
                    <p class="text-[11px] text-slate-600 font-bold leading-relaxed mb-6 uppercase tracking-tighter">
                        Dokumen ini adalah <span class="text-blue-600 underline">Kewajiban Akuntabilitas Rutin</span>. Wajib diperbarui sesuai siklus anggaran (Tahunan). Sifatnya <strong>Ganti Data (Update)</strong>. Data 2024 menggantikan 2023.
                    </p>
                    <div class="bg-blue-50 p-4 rounded-2xl border-l-4 border-blue-500 italic text-[10px] font-black text-blue-800 leading-normal">
                        "Setiap dokumen dengan <span class="underline">Siklus Waktu Tetap</span> (Renstra, LRA) WAJIB masuk kategori ini. Data lama wajib masuk <strong>ARSIP</strong>."
                    </div>
                </div>
            </div>

            <!-- SETIAP SAAT CARD -->
            <div class="group bg-white rounded-[2.5rem] border-2 border-slate-100 p-8 shadow-xl shadow-slate-200/50 hover:border-emerald-200 transition-all relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-32 h-32 bg-emerald-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-emerald-600 text-white p-3 rounded-2xl shadow-lg shadow-emerald-200">
                            <i class="fas fa-archive text-xl"></i>
                        </div>
                        <h6 class="font-black text-emerald-900 uppercase tracking-widest text-sm italic">2. Informasi Setiap Saat</h6>
                    </div>
                    <p class="text-[11px] text-slate-600 font-bold leading-relaxed mb-6 uppercase tracking-tighter">
                        Dokumen ini adalah <span class="text-emerald-600 underline">Catatan Sejarah & Produk Kebijakan</span>. Wajib sedia kapanpun diminta. Sifatnya <strong>Menumpuk (Akumulatif)</strong>. Semua tahun tetap BERLAKU.
                    </p>
                    <div class="bg-emerald-50 p-4 rounded-2xl border-l-4 border-emerald-500 italic text-[10px] font-black text-emerald-800 leading-normal">
                        "Dokumen berupa <span class="underline">Ketetapan Hukum</span> (SK, MoU) WAJIB masuk kategori ini. Dokumen berlaku permanen selama tidak dicabut."
                    </div>
                </div>
            </div>
        </div>

        <!-- DARURAT & RAHASIA -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-red-50 p-5 rounded-3xl border-2 border-red-100 flex items-center gap-4 group">
                <div class="bg-white p-3 rounded-2xl text-red-600 shadow-sm group-hover:scale-110 transition-transform"><i class="fas fa-exclamation-triangle"></i></div>
                <div class="font-black uppercase tracking-tighter italic">
                    <h6 class="text-[10px] text-red-900 underline decoration-2">3. Serta Merta (Darurat)</h6>
                    <p class="text-[9px] text-red-700">Mendesak! Info Banjir/Wabah. Wajib upload detik itu juga!</p>
                </div>
            </div>
            <div class="bg-slate-900 p-5 rounded-3xl border-2 border-slate-800 flex items-center gap-4 group">
                <div class="bg-slate-800 p-3 rounded-2xl text-slate-400 shadow-sm group-hover:scale-110 transition-transform"><i class="fas fa-user-secret"></i></div>
                <div class="font-black uppercase tracking-tighter italic">
                    <h6 class="text-[10px] text-slate-300 underline decoration-2">4. Dikecualikan (Rahasia)</h6>
                    <p class="text-[9px] text-slate-500 text-indigo-400">Data Rahasia (Pasal 17). Tidak tampil di publik.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- TUTORIAL FORM A - H (PROFESSIONAL TIMELINE) -->
    <div class="space-y-8">
        <h5 class="text-base font-black flex items-center gap-3 border-b-2 border-slate-100 pb-2 uppercase text-slate-700 italic">
            <i class="fas fa-stream text-indigo-600"></i> Alur Pengisian Formulir (Langkah A - H)
        </h5>

        <div class="grid grid-cols-1 gap-12 font-black uppercase tracking-tighter">
            
            <!-- STEP A & B -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- A: JUDUL -->
                <div class="bg-slate-50 p-6 rounded-[2.5rem] border-2 border-slate-200 shadow-inner relative">
                    <div class="flex items-center gap-4 mb-4">
                        <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black shadow-lg">A</span>
                        <h6 class="text-xs font-black italic">Judul Informasi</h6>
                    </div>
                    <p class="text-[10px] text-slate-500 mb-4 ml-14 italic underline">Format Baku: Nama Dokumen + Unit + Tahun.</p>
                    <div class="ml-14 bg-white p-3 rounded-xl border-2 border-indigo-100 shadow-md relative group">
                        <div class="h-10 w-full border-2 border-indigo-200 rounded-lg bg-indigo-50/50 flex items-center px-4 text-[9px] text-indigo-400 italic">Renja Dinas Perumahan 2024...</div>
                        <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[12px] border-r-indigo-600 shadow-lg"></div>
                    </div>
                </div>

                <!-- B: DESKRIPSI -->
                <div class="bg-slate-50 p-6 rounded-[2.5rem] border-2 border-slate-200 shadow-inner">
                    <div class="flex items-center gap-4 mb-4">
                        <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black shadow-lg">B</span>
                        <h6 class="text-xs font-black italic">Deskripsi & Pelengkap</h6>
                    </div>
                    <div class="ml-14 space-y-4 text-[10px]">
                        <p class="text-slate-500 italic underline">Berikan Ringkasan Isi Dokumen.</p>
                        <div class="bg-amber-100 p-4 rounded-2xl border-4 border-amber-300 font-black text-amber-900 leading-tight italic shadow-lg">
                            <h6 class="uppercase mb-2 underline flex items-center gap-1 font-black"><i class="fas fa-exclamation-triangle"></i> Dokumen Pelengkap:</h6>
                            <p class="text-[9px]">"Jika lampiran banyak, GABUNGKAN DALAM 1 PDF atau gunakan Link Google Drive!"</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP C, D, E, F (GRID) -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 ml-14">
                <div class="space-y-3">
                    <div class="flex gap-3 items-center"><span class="w-8 h-8 bg-indigo-500 text-white rounded-full flex items-center justify-center text-xs shadow-md">C</span><p class="text-[10px] font-black italic">Pilih Kategori</p></div>
                    <div class="bg-white border-2 border-slate-200 rounded-lg p-2 text-[8px] italic text-slate-400">Berkala... <i class="fas fa-chevron-down float-right mt-0.5"></i></div>
                </div>
                <div class="space-y-3">
                    <div class="flex gap-3 items-center"><span class="w-8 h-8 bg-indigo-500 text-white rounded-full flex items-center justify-center text-xs shadow-md">D</span><p class="text-[10px] font-black italic">Pilih Jenis</p></div>
                    <div class="bg-white border-2 border-slate-200 rounded-lg p-2 text-[8px] italic text-slate-400 font-black text-blue-600 uppercase">Dokumen Keuangan... <i class="fas fa-search float-right mt-0.5"></i></div>
                </div>
                <div class="space-y-3">
                    <div class="flex gap-3 items-center"><span class="w-8 h-8 bg-indigo-500 text-white rounded-full flex items-center justify-center text-xs shadow-md">E</span><p class="text-[10px] font-black italic">Kata Kunci</p></div>
                    <div class="flex gap-1"><span class="bg-indigo-50 text-indigo-400 px-2 py-0.5 rounded border border-indigo-100 text-[7px] font-black">#2024</span><span class="bg-indigo-50 text-indigo-400 px-2 py-0.5 rounded border border-indigo-100 text-[7px] font-black">#RENJA</span></div>
                </div>
                <div class="space-y-3">
                    <div class="flex gap-3 items-center"><span class="w-8 h-8 bg-indigo-500 text-white rounded-full flex items-center justify-center text-xs shadow-md">F</span><p class="text-[10px] font-black italic">Thumbnail</p></div>
                    <div class="w-16 h-8 bg-slate-200 rounded border-2 border-dashed border-slate-300 flex items-center justify-center text-[7px] text-slate-400 italic">JPG/PNG</div>
                </div>
            </div>

            <!-- STEP G & H (FINAL ACTION) -->
            <div class="flex flex-col md:flex-row gap-10 items-stretch font-black border-t-4 border-dashed border-slate-100 pt-10">
                <div class="flex-1 space-y-4">
                    <div class="flex items-center gap-4 mb-4">
                        <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black shadow-lg">G</span>
                        <h6 class="text-xs font-black italic uppercase">Tanggal Terbit Dokumen</h6>
                    </div>
                    <div class="ml-14 bg-white p-3 rounded-xl border border-slate-200 text-[10px] font-black italic shadow-sm w-40">Pilih Tanggal... <i class="fas fa-calendar-alt float-right mt-0.5 text-indigo-600"></i></div>
                </div>
                <div class="flex-1 bg-indigo-900 rounded-[3rem] p-8 shadow-2xl relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/5 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                    <div class="relative z-10 space-y-5">
                        <div class="flex items-center gap-4">
                            <span class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center font-black text-xl shadow-2xl animate-bounce border-4 border-white/20">H</span>
                            <h6 class="text-sm font-black text-white italic underline underline-offset-4 decoration-blue-500 uppercase tracking-widest">Langkah Final: Check & Simpan</h6>
                        </div>
                        <p class="ml-16 text-[10px] text-indigo-100 font-black leading-loose uppercase tracking-widest italic">
                            "Khusus <strong>BERKALA</strong>, WAJIB klik tombol kuning <span class="underline">CHECK INFORMASI</span> untuk mematikan data tahun lama!"
                        </p>
                        <div class="flex justify-center pt-2 relative">
                            <div class="bg-yellow-500 text-white px-10 py-3 rounded-2xl text-[10px] font-black shadow-2xl animate-bounce border-4 border-white uppercase italic shadow-yellow-200/40 tracking-[0.2em]">CHECK INFORMASI</div>
                            <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[10px] border-y-transparent border-r-[18px] border-r-yellow-500 shadow-xl shadow-yellow-200"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BANTUAN AI ANALIS (PROFESSIONAL BOX) -->
    <div class="bg-slate-900 text-white p-10 rounded-[4rem] shadow-2xl relative overflow-hidden italic font-black uppercase tracking-tighter border-4 border-slate-800">
        <div class="absolute -right-10 -bottom-10 opacity-5 rotate-12"><i class="fas fa-microchip text-[18rem]"></i></div>
        <div class="relative z-10">
            <h5 class="text-xl font-black mb-10 flex items-center gap-5 italic tracking-widest underline decoration-[6px] decoration-indigo-600 underline-offset-8">
                <i class="fas fa-magic text-indigo-400 text-4xl shadow-2xl"></i> Bingung Klasifikasi? Tanya AI!
            </h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="space-y-8 text-xs font-black tracking-widest">
                    <div class="flex gap-6 items-center bg-white/5 p-5 rounded-[2rem] border-2 border-white/10 shadow-lg hover:bg-white/10 transition-all group">
                        <span class="bg-indigo-600 text-white w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform">1</span>
                        <p class="underline decoration-indigo-500">Klik "Tanya Pedoman" di pojok form.</p>
                    </div>
                    <div class="flex gap-6 items-center bg-white/5 p-5 rounded-[2rem] border-2 border-white/10 shadow-lg hover:bg-white/10 transition-all group">
                        <span class="bg-indigo-600 text-white w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform">2</span>
                        <p class="italic underline decoration-green-500 decoration-2 underline-offset-4">Ketik Nama & Klik <span class="bg-green-600 px-3 py-1 rounded-xl border border-white animate-pulse">TANYA AI</span>!</p>
                    </div>
                </div>
                <!-- Visual Mockup AI -->
                <div class="bg-white/5 backdrop-blur-xl rounded-[3rem] p-8 border-2 border-white/10 shadow-2xl group">
                    <div class="bg-white rounded-3xl p-6 space-y-6 shadow-2xl relative transition-transform duration-700 group-hover:scale-105">
                        <div class="h-4 w-32 bg-slate-100 rounded-full shadow-inner"></div>
                        <div class="h-14 w-full border-2 border-slate-200 rounded-xl bg-slate-50 flex items-center px-6 text-sm text-slate-400 italic font-black uppercase tracking-tighter shadow-inner">Laporan LRA Dinas...</div>
                        <div class="flex justify-end relative">
                            <div class="bg-green-600 text-white px-8 py-3 rounded-xl text-[10px] font-black shadow-2xl animate-bounce border-2 border-white uppercase italic tracking-widest italic shadow-green-900/50">TANYA AI</div>
                            <div class="absolute -left-6 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[12px] border-y-transparent border-r-[20px] border-r-indigo-500 shadow-xl shadow-indigo-600"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- REKAPITULASI DOKUMEN (MASTER TABLE) -->
    <div class="bg-white border-4 border-slate-50 rounded-[4rem] p-12 shadow-2xl relative overflow-hidden font-black italic uppercase tracking-tighter text-slate-500">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-600 via-indigo-600 to-emerald-600 shadow-md"></div>
        <h5 class="text-xl font-black text-slate-800 mb-12 text-center uppercase tracking-[0.4em] italic border-b pb-4">Standar Dokumen Wajib Per Unit Kerja</h5>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- DINAS -->
            <div class="space-y-6 border-r-2 border-dashed border-slate-100 pr-6">
                <p class="text-sm font-black text-blue-600 border-b-4 border-blue-50 pb-2 italic underline underline-offset-4 decoration-4 flex items-center gap-2 uppercase tracking-widest"><i class="fas fa-building text-2xl"></i> Dinas / Badan</p>
                <ul class="text-[10px] space-y-3 list-disc list-inside leading-loose font-black italic uppercase tracking-tighter">
                    <li class="hover:translate-x-2 transition-transform">Renstra & Renja (5 thn & thn)</li>
                    <li class="hover:translate-x-2 transition-transform">DPA & RKA Anggaran Unit</li>
                    <li class="hover:translate-x-2 transition-transform">LRA & Neraca Keuangan</li>
                    <li class="hover:translate-x-2 transition-transform">Tarif Layanan & SPM (RSUD)</li>
                    <li class="hover:translate-x-2 transition-transform">LHKPN Pejabat Utama</li>
                </ul>
            </div>
            <!-- INSPEKTORAT -->
            <div class="space-y-6 border-r-2 border-dashed border-slate-100 pr-6">
                <p class="text-sm font-black text-indigo-600 border-b-4 border-indigo-50 pb-2 italic underline underline-offset-4 decoration-4 flex items-center gap-2 uppercase tracking-widest"><i class="fas fa-search-dollar text-2xl"></i> Inspektorat</p>
                <ul class="text-[10px] space-y-3 list-disc list-inside leading-loose font-black italic uppercase tracking-tighter text-justify">
                    <li class="hover:translate-x-2 transition-transform">PKPT (Program Kerja Audit)</li>
                    <li class="hover:translate-x-2 transition-transform">Ringkasan LHP Publik</li>
                    <li class="hover:translate-x-2 transition-transform">SOP Audit Pengawasan</li>
                    <li class="hover:translate-x-2 transition-transform">Laporan Akuntabilitas</li>
                </ul>
            </div>
            <!-- KEC/DESA -->
            <div class="space-y-6">
                <p class="text-sm font-black text-green-600 border-b-4 border-green-50 pb-2 italic underline underline-offset-4 decoration-4 flex items-center gap-2 uppercase tracking-widest"><i class="fas fa-map-marked-alt text-2xl"></i> Desa / Kel / Kec</p>
                <ul class="text-[10px] space-y-3 list-disc list-inside leading-loose font-black italic uppercase tracking-tighter text-justify">
                    <li class="hover:translate-x-2 transition-transform">APBDes / RKPDes (Anggaran)</li>
                    <li class="hover:translate-x-2 transition-transform">LPPD Penyelenggaraan Desa</li>
                    <li class="hover:translate-x-2 transition-transform">Monografi & Profil Wilayah</li>
                    <li class="hover:translate-x-2 transition-transform">Data Inventaris Aset Desa</li>
                    <li class="hover:translate-x-2 transition-transform">Laporan PATEN (Kecamatan)</li>
                </ul>
            </div>
        </div>
    </div>
</div>