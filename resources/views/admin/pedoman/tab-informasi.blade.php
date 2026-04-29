<div x-show="$store.pedomanAdminModal.activeTab === 1" 
     class="space-y-10 animate-fadeIn">
    
    <!-- Header Tab -->
    <div class="flex items-center gap-3 border-l-4 border-blue-600 pl-3 uppercase tracking-tighter">
        <div>
            <h4 class="text-lg font-bold text-slate-800 leading-none">Klasifikasi & Panduan Operasional Informasi</h4>
            <p class="text-[9px] text-slate-400 font-medium tracking-widest mt-0.5 italic">Pedoman Siklus Hidup Dokumen Sesuai PERKI 1/2021</p>
        </div>
    </div>

    <!-- LOGIKA MENDALAM (WHY) -->
    <div class="space-y-6">
        <h5 class="text-xs font-bold flex items-center gap-2 border-b pb-1 text-slate-700 uppercase italic">
            <i class="fas fa-balance-scale text-blue-600"></i> Mengapa Harus Diklasifikasikan?
        </h5>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-[10px] font-medium leading-relaxed text-slate-600 uppercase tracking-tighter">
            <!-- BERKALA -->
            <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-100 relative overflow-hidden shadow-sm">
                <h6 class="font-bold text-blue-900 mb-2 uppercase underline underline-offset-4 decoration-2 decoration-blue-200">1. Informasi Berkala</h6>
                <p class="mb-4 text-justify">Dokumen diklasifikasikan sebagai <strong>Informasi Berkala</strong> karena merupakan <strong>Kewajiban Akuntabilitas Rutin</strong>. Wajib diperbarui terjadwal (tahunan). Sifatnya <strong>Ganti Data (Update)</strong>. Dokumen terbaru (2024) WAJIB mematikan validitas dokumen lama (2023).</p>
                <div class="space-y-3 italic">
                    <div class="bg-white/80 p-3 rounded-xl border border-blue-200 text-blue-800 shadow-sm leading-tight">
                        <span class="font-bold block mb-1">Studi Logika:</span>
                        "Setiap dokumen dengan <strong>Siklus Waktu Tetap</strong> (Renstra, LRA) WAJIB masuk kategori ini. Data lama wajib masuk <strong>ARSIP</strong>."
                    </div>
                    <div class="bg-red-50 p-3 rounded-xl border border-red-200 text-red-700 shadow-sm leading-tight">
                        <span class="font-bold block mb-1">Penting:</span>
                        "Wajib mengubah status data lama menjadi ARSIP ketika ada dokumen baru yang BERLAKU."
                    </div>
                </div>
            </div>

            <!-- SETIAP SAAT -->
            <div class="bg-emerald-50/50 p-6 rounded-3xl border border-emerald-100 relative overflow-hidden shadow-sm text-emerald-900">
                <h6 class="font-bold mb-2 uppercase underline underline-offset-4 decoration-2 decoration-emerald-200 font-bold">2. Informasi Setiap Saat</h6>
                <p class="mb-4 text-justify">Dokumen masuk kategori ini karena merupakan <strong>Catatan Histori & Produk Kebijakan</strong>. Wajib sedia kapanpun diminta. Sifatnya <strong>Akumulatif (Menumpuk)</strong>. Semua data tahun lama tetap BERLAKU sebagai sejarah unit Bapak.</p>
                <div class="bg-white/80 p-3 rounded-xl border border-emerald-100 text-emerald-800 shadow-sm leading-tight italic">
                    <span class="font-bold block mb-1">Studi Logika:</span>
                    "Dokumen berupa <strong>Ketetapan Hukum</strong> (SK, MoU) WAJIB masuk kategori ini karena berlaku permanen selama belum dicabut."
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 uppercase font-bold tracking-tighter text-[9px]">
            <div class="bg-red-50 p-4 rounded-2xl border border-red-100 flex items-center gap-3">
                <div class="bg-white p-2 rounded-lg text-red-600 shadow-sm"><i class="fas fa-bolt"></i></div>
                <div>
                    <h6 class="text-red-900 font-bold">3. Serta Merta (Darurat)</h6>
                    <p class="text-slate-500 italic">Mendesak! Wajib upload detik itu juga! (Contoh: Info Banjir, Wabah).</p>
                </div>
            </div>
            <div class="bg-slate-900 p-4 rounded-2xl border border-slate-800 flex items-center gap-3 text-white">
                <div class="bg-slate-800 p-2 rounded-lg text-slate-400 shadow-sm"><i class="fas fa-user-secret"></i></div>
                <div>
                    <h6 class="text-slate-300 font-bold">4. Dikecualikan (Rahasia)</h6>
                    <p class="text-slate-500 italic">Data Rahasia (Pasal 17). Tidak tampil. (Contoh: Rekam Medis).</p>
                </div>
            </div>
        </div>
    </div>

    <!-- TUTORIAL FORM A - H (VERTICAL LIST) -->
    <div class="space-y-6">
        <h5 class="text-xs font-bold flex items-center gap-2 border-b pb-1 uppercase text-slate-700 italic">
            <i class="fas fa-list-ol text-indigo-600"></i> Alur Detail Pengisian Formulir (Langkah A - H)
        </h5>

        <div class="space-y-4 font-bold uppercase tracking-tighter text-[10px]">
            
            <!-- A: JUDUL -->
            <div class="flex flex-col md:flex-row gap-4 items-center bg-slate-50 p-4 rounded-2xl border border-slate-200">
                <div class="flex-1 flex gap-3">
                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold shadow-md flex-shrink-0">A</span>
                    <div class="space-y-0.5 pt-0.5">
                        <h6 class="text-slate-800 font-bold">Judul Informasi</h6>
                        <p class="text-[9px] text-slate-400 italic">Baku: Nama Dokumen + Unit + Tahun.</p>
                    </div>
                </div>
                <div class="w-full md:w-56 bg-white p-2 rounded-lg border border-indigo-100 text-[8px] text-indigo-400 italic shadow-sm">
                    Renja Dinas Perumahan 2024...
                </div>
            </div>

            <!-- B: DESKRIPSI -->
            <div class="flex flex-col md:flex-row gap-4 items-start bg-slate-50 p-4 rounded-2xl border border-slate-200">
                <div class="flex-1 flex gap-3">
                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold shadow-md flex-shrink-0">B</span>
                    <div class="space-y-2 pt-0.5">
                        <h6 class="text-slate-800 font-bold">Deskripsi & Pelengkap</h6>
                        <div class="bg-amber-100 p-3 rounded-xl border border-amber-200 text-amber-800 italic leading-relaxed text-[9px]">
                            <span class="font-bold underline uppercase block mb-1 tracking-widest italic">Dokumen Pelengkap (WAJIB):</span>
                            "Jika lampiran banyak, <strong>GABUNGKAN DALAM 1 PDF</strong>. Jika file besar, gunakan opsi Link Google Drive!"
                        </div>
                    </div>
                </div>
            </div>

            <!-- C, D, E, F -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 bg-indigo-500 text-white rounded-full flex items-center justify-center text-[9px] font-bold">C</span>
                    <span class="text-[8px] italic">Pilih Kategori</span>
                </div>
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 bg-indigo-500 text-white rounded-full flex items-center justify-center text-[9px] font-bold">D</span>
                    <span class="text-[8px] italic">Pilih Jenis</span>
                </div>
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 bg-indigo-500 text-white rounded-full flex items-center justify-center text-[9px] font-bold">E</span>
                    <span class="text-[8px] italic">Input Tagging</span>
                </div>
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 bg-indigo-500 text-white rounded-full flex items-center justify-center text-[9px] font-bold">F</span>
                    <span class="text-[8px] italic">Upload Cover</span>
                </div>
            </div>

            <!-- H: FINAL -->
            <div class="flex flex-col md:flex-row gap-4 items-center bg-indigo-50 p-4 rounded-2xl border-2 border-indigo-100 shadow-md">
                <div class="flex-1 flex gap-3">
                    <span class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg animate-bounce border-2 border-white flex-shrink-0">H</span>
                    <div class="space-y-1 pt-0.5">
                        <h6 class="text-blue-900 font-bold uppercase italic">Langkah Final: Check & Simpan</h6>
                        <p class="text-[9px] text-blue-700 italic tracking-tight">"Khusus BERKALA, wajib klik tombol kuning <span class="font-bold underline uppercase">CHECK INFORMASI</span> untuk mematikan data tahun lama!"</p>
                    </div>
                </div>
                <div class="flex-shrink-0 relative scale-75 origin-right">
                    <div class="bg-yellow-500 text-white px-6 py-2 rounded-lg text-[9px] font-bold shadow-lg border-2 border-white uppercase italic">CHECK INFORMASI</div>
                    <div class="absolute -left-2 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[5px] border-y-transparent border-r-[8px] border-r-yellow-500"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- BANTUAN AI (MINIMALIST) -->
    <div class="bg-slate-900 text-white p-6 rounded-3xl shadow-xl relative overflow-hidden font-bold border-2 border-slate-800">
        <div class="relative z-10 flex flex-col md:flex-row gap-6 items-center">
            <div class="flex items-center gap-3">
                <i class="fas fa-magic text-indigo-400 text-2xl"></i>
                <h5 class="text-xs uppercase tracking-widest">Bingung Klasifikasi? Tanya AI!</h5>
            </div>
            <div class="flex-1 grid grid-cols-2 gap-4 text-[9px] tracking-widest uppercase italic">
                <p>1. Klik <span class="text-indigo-400 font-black">"Tanya Pedoman"</span>.</p>
                <p>2. Ketik & Klik <span class="text-green-400 font-black underline">TANYA AI</span>!</p>
            </div>
        </div>
    </div>

    <!-- REKAPITULASI DOKUMEN -->
    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm font-bold text-slate-400 uppercase tracking-tighter">
        <h5 class="text-[10px] text-slate-800 mb-4 text-center uppercase tracking-widest border-b pb-2 italic underline decoration-slate-100">Standar Dokumen Wajib Per Unit</h5>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-[8px] italic leading-loose">
            <div class="space-y-1">
                <p class="text-blue-500 border-b pb-0.5 flex items-center gap-2 uppercase font-black"><i class="fas fa-building text-xs"></i> Dinas / Badan / RSUD</p>
                <ul class="list-disc list-inside"><li>Renstra & Renja</li><li>DPA & RKA</li><li>LRA & Neraca</li><li>Tarif & SPM (RSUD)</li></ul>
            </div>
            <div class="space-y-1">
                <p class="text-indigo-500 border-b pb-0.5 flex items-center gap-2 uppercase font-black"><i class="fas fa-search-dollar text-xs"></i> Inspektorat</p>
                <ul class="list-disc list-inside"><li>PKPT (Audit)</li><li>Ringkasan LHP</li><li>Laporan Akuntabilitas</li></ul>
            </div>
            <div class="space-y-1">
                <p class="text-green-500 border-b pb-0.5 flex items-center gap-2 uppercase font-black"><i class="fas fa-map-marked-alt text-xs"></i> Kec / Desa / Kel</p>
                <ul class="list-disc list-inside"><li>APBDes / RKPDes</li><li>LPPD & Monografi</li><li>Laporan PATEN</li></ul>
            </div>
        </div>
    </div>
</div>