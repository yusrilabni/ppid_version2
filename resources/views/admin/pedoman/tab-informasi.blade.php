<div x-show="$store.pedomanAdminModal.activeTab === 1" x-transition 
     x-transition:enter="transition ease-out duration-300"
     class="space-y-12">
    
    <!-- Header Tab -->
    <div class="flex items-center gap-4 border-l-8 border-blue-600 pl-4 uppercase tracking-tighter">
        <div>
            <h4 class="text-2xl font-bold text-slate-800 leading-none">Manajemen Informasi Publik</h4>
            <p class="text-[10px] text-slate-400 font-medium tracking-[0.3em] mt-1 italic">Panduan Klasifikasi & Siklus Hidup Dokumen</p>
        </div>
    </div>

    <!-- LOGIKA MENDALAM (WHY) -->
    <div class="space-y-6">
        <h5 class="text-sm font-bold flex items-center gap-3 border-b-2 border-slate-100 pb-2 text-slate-700 italic uppercase">
            <i class="fas fa-balance-scale text-blue-600"></i> Mengapa Harus Diklasifikasikan?
        </h5>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 font-medium">
            <!-- BERKALA -->
            <div class="bg-blue-50 p-8 rounded-[2rem] border border-blue-100 relative overflow-hidden group">
                <div class="relative z-10">
                    <h6 class="font-bold text-blue-900 mb-3 flex items-center gap-3 text-sm italic underline decoration-blue-200 decoration-2">
                        <i class="fas fa-calendar-alt"></i> 1. Informasi Berkala
                    </h6>
                    <p class="text-[11px] text-justify mb-6 leading-relaxed text-slate-600">
                        Dokumen ini adalah <strong>Kewajiban Akuntabilitas Rutin</strong>. Wajib diperbarui sesuai siklus anggaran. Sifatnya <strong>Update Terkini (Ganti Data)</strong>. Data 2024 menggantikan data lama 2023.
                    </p>
                    <div class="bg-white/80 p-4 rounded-xl border-l-4 border-blue-500 shadow-sm text-[10px] text-blue-800">
                        <span class="font-bold uppercase block mb-1">Studi Logika:</span>
                        "Setiap dokumen dengan siklus waktu tetap (Renstra, LRA) masuk kategori ini. Data lama wajib masuk <strong>ARSIP</strong>."
                    </div>
                </div>
            </div>

            <!-- SETIAP SAAT -->
            <div class="bg-emerald-50 p-8 rounded-[2rem] border border-emerald-100 relative overflow-hidden group font-medium">
                <div class="relative z-10">
                    <h6 class="font-bold text-emerald-900 mb-3 flex items-center gap-3 text-sm italic underline decoration-emerald-200 decoration-2">
                        <i class="fas fa-archive"></i> 2. Informasi Setiap Saat
                    </h6>
                    <p class="text-[11px] text-justify mb-6 leading-relaxed text-slate-600">
                        Dokumen ini adalah <strong>Catatan Histori & Produk Kebijakan</strong>. Wajib sedia kapanpun diminta. Sifatnya <strong>Akumulatif (Menumpuk)</strong>. Semua data tahun lama tetap berlaku sebagai sejarah.
                    </p>
                    <div class="bg-white/80 p-4 rounded-xl border-l-4 border-emerald-500 shadow-sm text-[10px] text-emerald-800 font-medium">
                        <span class="font-bold uppercase block mb-1">Studi Logika:</span>
                        "Dokumen berupa ketetapan hukum (SK, MoU) masuk kategori ini. Dokumen berlaku permanen selama tidak dicabut."
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TUTORIAL FORM A - H (VERTICAL LIST) -->
    <div class="space-y-8">
        <h5 class="text-sm font-bold flex items-center gap-3 border-b-2 border-slate-100 pb-2 text-slate-700 italic uppercase">
            <i class="fas fa-list-ol text-indigo-600"></i> Langkah Pengisian Formulir (A - H)
        </h5>

        <div class="space-y-6">
            <!-- A: JUDUL -->
            <div class="flex flex-col md:flex-row gap-6 items-start bg-slate-50 p-6 rounded-2xl border border-slate-200 group">
                <div class="flex-1 flex gap-4">
                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg flex-shrink-0">A</span>
                    <div class="space-y-1">
                        <h6 class="text-[11px] font-bold uppercase text-slate-800">Judul Informasi</h6>
                        <p class="text-[10px] text-slate-500 leading-relaxed font-medium">Gunakan Format Baku: <strong>Nama Dokumen + Unit + Tahun</strong>. <br>Contoh: "Renja Dinas Perumahan 2024".</p>
                    </div>
                </div>
                <div class="w-full md:w-64 bg-white p-3 rounded-xl border border-indigo-100 shadow-sm text-[9px] text-indigo-400 italic font-medium">
                    Renja Dinas Perumahan 2024...
                </div>
            </div>

            <!-- B: DESKRIPSI -->
            <div class="flex flex-col md:flex-row gap-6 items-start bg-slate-50 p-6 rounded-2xl border border-slate-200">
                <div class="flex-1 flex gap-4">
                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg flex-shrink-0">B</span>
                    <div class="space-y-2">
                        <h6 class="text-[11px] font-bold uppercase text-slate-800">Deskripsi & Pelengkap</h6>
                        <p class="text-[10px] text-slate-500 font-medium">Berikan ringkasan isi dokumen bagi masyarakat.</p>
                        <div class="bg-amber-50 p-3 rounded-lg border border-amber-200 text-amber-800 text-[10px] font-medium italic">
                            <span class="font-bold underline uppercase block mb-1 tracking-tighter">Dokumen Pelengkap (WAJIB):</span>
                            "Jika lampiran banyak, <strong>GABUNGKAN DALAM 1 PDF</strong>. Jika file besar, gunakan opsi Link Google Drive!"
                        </div>
                    </div>
                </div>
            </div>

            <!-- C & D (Kategori & Jenis) -->
            <div class="flex flex-col md:flex-row gap-6 items-start bg-slate-50 p-6 rounded-2xl border border-slate-200">
                <div class="flex-1 flex gap-4">
                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg flex-shrink-0">C</span>
                    <div class="space-y-1">
                        <h6 class="text-[11px] font-bold uppercase text-slate-800">Kategori Klasifikasi</h6>
                        <p class="text-[10px] text-slate-500 font-medium">Pilih salah satu: <strong>Berkala</strong> atau <strong>Setiap Saat</strong>.</p>
                    </div>
                </div>
                <div class="flex-1 flex gap-4">
                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg flex-shrink-0">D</span>
                    <div class="space-y-1">
                        <h6 class="text-[11px] font-bold uppercase text-slate-800">Jenis Dokumen</h6>
                        <p class="text-[10px] text-slate-500 font-medium">Pilih jenis yang sesuai agar data masuk ke folder folder folder yang tepat di beranda.</p>
                    </div>
                </div>
            </div>

            <!-- E & F (Tags & Thumbnail) -->
            <div class="flex flex-col md:flex-row gap-6 items-start bg-slate-50 p-6 rounded-2xl border border-slate-200">
                <div class="flex-1 flex gap-4">
                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg flex-shrink-0">E</span>
                    <div class="space-y-1">
                        <h6 class="text-[11px] font-bold uppercase text-slate-800">Tags / Kata Kunci</h6>
                        <p class="text-[10px] text-slate-500 font-medium italic">Masukkan kata kunci pencarian (Opsional).</p>
                    </div>
                </div>
                <div class="flex-1 flex gap-4">
                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg flex-shrink-0">F</span>
                    <div class="space-y-1">
                        <h6 class="text-[11px] font-bold uppercase text-slate-800">Gambar Cover</h6>
                        <p class="text-[10px] text-slate-500 font-medium italic">Upload cover dokumen jika ingin lebih menarik (Opsional).</p>
                    </div>
                </div>
            </div>

            <!-- G: TANGGAL -->
            <div class="flex flex-col md:flex-row gap-6 items-start bg-slate-50 p-6 rounded-2xl border border-slate-200">
                <div class="flex-1 flex gap-4">
                    <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg flex-shrink-0">G</span>
                    <div class="space-y-1">
                        <h6 class="text-[11px] font-bold uppercase text-slate-800">Tanggal Terbit</h6>
                        <p class="text-[10px] text-slate-500 font-medium italic">Pilih tanggal sesuai dokumen resmi Bapak.</p>
                    </div>
                </div>
            </div>

            <!-- H: FINAL STEP -->
            <div class="flex flex-col md:flex-row gap-6 items-center bg-indigo-50 p-6 rounded-2xl border-2 border-indigo-100 shadow-md">
                <div class="flex-1 flex gap-4">
                    <span class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg animate-bounce border-2 border-white flex-shrink-0">H</span>
                    <div class="space-y-2 font-medium">
                        <h6 class="text-[11px] font-bold uppercase text-blue-900 underline decoration-2 underline-offset-4">Langkah Final: Check & Simpan</h6>
                        <p class="text-[10px] text-blue-700 leading-relaxed uppercase tracking-tighter">
                            "Khusus <strong>BERKALA</strong>, wajib klik tombol kuning <span class="font-bold underline">CHECK INFORMASI</span> untuk mematikan data tahun lama!"
                        </p>
                    </div>
                </div>
                <div class="flex-shrink-0 relative scale-90">
                    <div class="bg-yellow-500 text-white px-8 py-2.5 rounded-xl text-[10px] font-bold shadow-lg animate-pulse border-2 border-white uppercase italic tracking-wider">CHECK INFORMASI</div>
                    <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[10px] border-r-yellow-500 shadow-md"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- BANTUAN AI ANALIS (COMPACT) -->
    <div class="bg-slate-900 text-white p-8 rounded-[2rem] shadow-xl relative overflow-hidden font-medium border border-slate-800">
        <div class="absolute -right-6 -bottom-6 opacity-10 rotate-12"><i class="fas fa-microchip text-[6rem]"></i></div>
        <div class="relative z-10">
            <h5 class="text-base font-bold mb-6 flex items-center gap-3 underline underline-offset-4 decoration-indigo-500 decoration-2 uppercase">
                <i class="fas fa-magic text-indigo-400 text-2xl"></i> Bingung Klasifikasi? Tanya AI!
            </h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center text-[10px] uppercase font-bold tracking-widest">
                <div class="space-y-4">
                    <p>1. Klik tombol <span class="text-indigo-400 font-bold">"Tanya Pedoman"</span> di pojok kanan atas form.</p>
                    <p>2. Ketik Nama Dokumen & Klik Tombol Hijau <span class="text-green-400 font-bold underline decoration-2">TANYA AI</span>!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- REKAPITULASI DOKUMEN -->
    <div class="bg-white border-2 border-slate-100 rounded-[2rem] p-8 shadow-md relative overflow-hidden font-medium text-slate-500 uppercase tracking-tighter">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 via-indigo-600 to-emerald-600 shadow-sm"></div>
        <h5 class="text-sm font-bold text-slate-800 mb-8 text-center uppercase tracking-widest border-b pb-2 italic underline decoration-slate-200">Standar Dokumen Wajib Per Unit</h5>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-[10px] font-bold">
            <div class="space-y-3">
                <p class="text-blue-600 border-b pb-1 flex items-center gap-2"><i class="fas fa-building text-sm"></i> Dinas / Badan / RSUD</p>
                <ul class="space-y-1.5 list-disc list-inside leading-relaxed italic text-slate-500">
                    <li>Renstra & Renja</li>
                    <li>DPA & RKA</li>
                    <li>LRA & Neraca</li>
                    <li>Tarif Layanan (RSUD)</li>
                </ul>
            </div>
            <div class="space-y-3">
                <p class="text-indigo-600 border-b pb-1 flex items-center gap-2"><i class="fas fa-search-dollar text-sm"></i> Inspektorat</p>
                <ul class="space-y-1.5 list-disc list-inside leading-relaxed italic text-slate-500">
                    <li>PKPT (Audit)</li>
                    <li>Ringkasan LHP</li>
                    <li>Laporan Akuntabilitas</li>
                </ul>
            </div>
            <div class="space-y-3">
                <p class="text-green-600 border-b pb-1 flex items-center gap-2"><i class="fas fa-map-marked-alt text-sm"></i> Kec / Desa / Kel</p>
                <ul class="space-y-1.5 list-disc list-inside leading-relaxed italic text-slate-500">
                    <li>APBDes / RKPDes</li>
                    <li>LPPD & Monografi</li>
                    <li>Laporan PATEN</li>
                </ul>
            </div>
        </div>
    </div>
</div>