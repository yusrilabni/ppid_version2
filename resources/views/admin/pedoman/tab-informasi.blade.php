<div x-show="$store.pedomanAdminModal.activeTab === 1" 
     class="space-y-10">
    
    <!-- Header Tab -->
    <div class="flex items-center gap-3 border-l-4 border-blue-600 pl-3 uppercase tracking-tighter">
        <div>
            <h4 class="text-base font-bold text-slate-800 leading-none">Manajemen Informasi Publik</h4>
            <p class="text-[9px] text-slate-400 font-medium tracking-widest mt-0.5 italic">Panduan Klasifikasi & Siklus Hidup Dokumen</p>
        </div>
    </div>

    <!-- LOGIKA MENDALAM (WHY) -->
    <div class="space-y-6">
        <h5 class="text-[11px] font-bold flex items-center gap-2 border-b pb-1 text-slate-700 uppercase italic">
            <i class="fas fa-balance-scale text-blue-600"></i> Mengapa Harus Diklasifikasikan?
        </h5>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-[10px] font-medium leading-relaxed text-slate-600 uppercase tracking-tighter">
            <!-- BERKALA -->
            <div class="bg-blue-50/30 p-5 rounded-2xl border border-blue-100 relative overflow-hidden shadow-sm">
                <h6 class="font-bold text-blue-900 mb-2 uppercase underline underline-offset-4 decoration-1 decoration-blue-200">1. Informasi Berkala</h6>
                <p class="mb-4 text-justify font-normal normal-case">Dokumen diklasifikasikan sebagai Informasi Berkala karena merupakan kewajiban akuntabilitas rutin (Pasal 9 UU KIP). Wajib diperbarui terjadwal. Sifatnya <strong>Update Terkini</strong>, di mana data terbaru (2024) menggantikan data lama (2023).</p>
                <div class="space-y-3 italic normal-case">
                    <div class="bg-white/80 p-3 rounded-xl border border-blue-100 text-blue-800 shadow-sm leading-tight">
                        <span class="font-bold block mb-1 uppercase text-[9px]">Studi Logika:</span>
                        "Setiap dokumen dengan siklus waktu tetap (Renstra, LRA) wajib masuk kategori ini. Data lama wajib masuk <strong>ARSIP</strong>."
                    </div>
                </div>
            </div>

            <!-- SETIAP SAAT -->
            <div class="bg-emerald-50/30 p-5 rounded-2xl border border-emerald-100 relative overflow-hidden shadow-sm text-emerald-900">
                <h6 class="font-bold mb-2 uppercase underline underline-offset-4 decoration-1 decoration-emerald-200">2. Informasi Setiap Saat</h6>
                <p class="mb-4 text-justify font-normal normal-case">Dokumen masuk kategori ini karena merupakan catatan histori & produk kebijakan (Pasal 11 UU KIP). Wajib sedia kapanpun diminta. Sifatnya <strong>Akumulatif (Menumpuk)</strong>. Semua data tahun lama tetap berlaku sebagai sejarah unit.</p>
                <div class="bg-white/80 p-3 rounded-xl border border-emerald-100 text-emerald-800 shadow-sm leading-tight italic normal-case">
                    <span class="font-bold block mb-1 uppercase text-[9px]">Studi Logika:</span>
                    "Dokumen berupa ketetapan hukum (SK, MoU) wajib masuk kategori ini karena berlaku permanen selama belum dicabut pimpinan."
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 uppercase font-medium tracking-tighter text-[9px]">
            <div class="bg-red-50/50 p-4 rounded-xl border border-red-100 flex items-center gap-3">
                <div class="bg-white p-2 rounded-lg text-red-600 shadow-sm"><i class="fas fa-bolt"></i></div>
                <div>
                    <h6 class="text-red-900 font-bold">3. Serta Merta (Darurat)</h6>
                    <p class="text-slate-500 font-normal italic lowercase">Mendesak! Wajib upload detik itu juga! (Contoh: Info Banjir).</p>
                </div>
            </div>
            <div class="bg-slate-900 p-4 rounded-xl border border-slate-800 flex items-center gap-3 text-white">
                <div class="bg-slate-800 p-2 rounded-lg text-slate-400 shadow-sm"><i class="fas fa-user-secret"></i></div>
                <div>
                    <h6 class="text-slate-300 font-bold">4. Dikecualikan (Rahasia)</h6>
                    <p class="text-slate-500 font-normal italic lowercase">Data rahasia (Pasal 17). Tidak tampil di publik.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- TUTORIAL FORM A - H (VERTICAL TIMELINE) -->
    <div class="space-y-6">
        <h5 class="text-[11px] font-bold flex items-center gap-2 border-b pb-1 uppercase text-slate-700 italic">
            <i class="fas fa-list-ol text-indigo-600"></i> Alur Detail Pengisian Formulir (Langkah A - H)
        </h5>

        <div class="relative pl-4 space-y-4">
            <!-- Vertical Line Connector -->
            <div class="absolute left-[23px] top-4 bottom-4 w-0.5 bg-slate-100"></div>

            <!-- A: JUDUL -->
            <div class="relative flex flex-col md:flex-row gap-4 items-center bg-white p-4 rounded-2xl border border-slate-100 hover:border-indigo-100 transition-colors shadow-sm">
                <div class="flex-1 flex gap-4 relative z-10">
                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold shadow-md flex-shrink-0 text-xs">A</span>
                    <div class="space-y-0.5">
                        <h6 class="text-[10px] font-bold uppercase text-slate-800">Judul Informasi</h6>
                        <p class="text-[9px] text-slate-400 font-normal normal-case italic">Gunakan format: Nama Dokumen + Unit + Tahun. Contoh: "Renja Dinas Perumahan 2024".</p>
                    </div>
                </div>
                <div class="w-full md:w-56 bg-slate-50 p-2 rounded-lg border border-indigo-50 text-[8px] text-indigo-400 italic font-medium">
                    Renja Dinas Perumahan 2024...
                </div>
            </div>

            <!-- B: DESKRIPSI -->
            <div class="relative flex flex-col md:flex-row gap-4 items-start bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                <div class="flex-1 flex gap-4 relative z-10">
                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold shadow-md flex-shrink-0 text-xs">B</span>
                    <div class="space-y-2">
                        <h6 class="text-[10px] font-bold uppercase text-slate-800">Deskripsi & Pelengkap</h6>
                        <div class="bg-amber-50/50 p-3 rounded-xl border border-amber-100 text-amber-800 italic leading-relaxed text-[9px] font-medium normal-case">
                            <span class="font-bold underline uppercase block mb-1 text-[8px] tracking-widest italic">Dokumen Pelengkap (WAJIB):</span>
                            "Jika lampiran banyak, <strong>gabungkan dalam 1 PDF</strong>. Jika file besar, gunakan opsi link Google Drive unit Bapak!"
                        </div>
                    </div>
                </div>
            </div>

            <!-- C, D, E, F -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 relative z-10">
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 bg-indigo-500 text-white rounded-full flex items-center justify-center text-[9px] font-bold">C</span>
                    <span class="text-[8px] font-medium text-slate-500 uppercase tracking-tighter italic">Pilih Kategori</span>
                </div>
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 bg-indigo-500 text-white rounded-full flex items-center justify-center text-[9px] font-bold">D</span>
                    <span class="text-[8px] font-medium text-slate-500 uppercase tracking-tighter italic">Pilih Jenis</span>
                </div>
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 bg-indigo-500 text-white rounded-full flex items-center justify-center text-[9px] font-bold">E</span>
                    <span class="text-[8px] font-medium text-slate-500 uppercase tracking-tighter italic">Input Tagging</span>
                </div>
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 bg-indigo-500 text-white rounded-full flex items-center justify-center text-[9px] font-bold">F</span>
                    <span class="text-[8px] font-medium text-slate-500 uppercase tracking-tighter italic">Upload Cover</span>
                </div>
            </div>

            <!-- G: TANGGAL -->
            <div class="relative flex flex-col md:flex-row gap-4 items-center bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                <div class="flex-1 flex gap-4 relative z-10">
                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold shadow-md flex-shrink-0 text-xs">G</span>
                    <div class="space-y-0.5">
                        <h6 class="text-[10px] font-bold uppercase text-slate-800">Tanggal Terbit</h6>
                        <p class="text-[9px] text-slate-400 font-normal italic">Pilih tanggal sesuai dokumen resmi Bapak.</p>
                    </div>
                </div>
            </div>

            <!-- H: FINAL -->
            <div class="relative flex flex-col md:flex-row gap-4 items-center bg-indigo-50/50 p-4 rounded-2xl border-2 border-indigo-100 shadow-sm">
                <div class="flex-1 flex gap-4 relative z-10">
                    <span class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg animate-pulse border-2 border-white flex-shrink-0 text-xs">H</span>
                    <div class="space-y-1">
                        <h6 class="text-[10px] font-bold uppercase text-blue-900 italic">Langkah Final: Simpan</h6>
                        <p class="text-[9px] text-blue-700 font-medium normal-case tracking-tight">"Khusus <strong>BERKALA</strong>, wajib klik tombol kuning <span class="font-bold underline uppercase">Check Informasi</span> untuk mematikan data lama otomatis!"</p>
                    </div>
                </div>
                <div class="flex-shrink-0 relative scale-75 origin-right">
                    <div class="bg-yellow-500 text-white px-5 py-2 rounded-lg text-[9px] font-bold shadow-md border-2 border-white uppercase italic">CHECK INFORMASI</div>
                    <div class="absolute -left-2 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[5px] border-y-transparent border-r-[8px] border-r-yellow-500"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- BANTUAN AI (CLEAN) -->
    <div class="bg-slate-900 text-white p-6 rounded-3xl shadow-lg relative overflow-hidden border border-slate-800">
        <div class="relative z-10 flex flex-col md:flex-row gap-6 items-center">
            <div class="flex items-center gap-3">
                <div class="bg-indigo-500 p-2 rounded-xl text-white shadow-lg"><i class="fas fa-magic text-sm"></i></div>
                <h5 class="text-[11px] font-bold uppercase tracking-widest italic">Bingung Klasifikasi? Tanya AI!</h5>
            </div>
            <div class="flex-1 grid grid-cols-2 gap-4 text-[9px] tracking-wider uppercase font-medium">
                <p>1. Klik <span class="text-indigo-400 font-bold">"Tanya Pedoman"</span>.</p>
                <p>2. Ketik & Klik <span class="text-green-400 font-bold underline">TANYA AI</span>!</p>
            </div>
        </div>
    </div>

    <!-- REKAPITULASI DOKUMEN -->
    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm font-medium text-slate-400 uppercase tracking-tighter">
        <h5 class="text-[10px] text-slate-800 mb-4 text-center uppercase tracking-widest border-b pb-2 italic font-bold">Standar Dokumen Wajib Per Unit</h5>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-[8px] font-normal leading-loose">
            <div class="space-y-1.5">
                <p class="text-blue-500 border-b pb-0.5 flex items-center gap-2 uppercase font-bold italic"><i class="fas fa-building text-[10px]"></i> Dinas / RSUD</p>
                <ul class="list-disc list-inside text-slate-500"><li>Renstra & Renja</li><li>DPA & RKA</li><li>LRA & Neraca</li><li>Tarif & SPM (RSUD)</li></ul>
            </div>
            <div class="space-y-1.5">
                <p class="text-indigo-500 border-b pb-0.5 flex items-center gap-2 uppercase font-bold italic"><i class="fas fa-search-dollar text-[10px]"></i> Inspektorat</p>
                <ul class="list-disc list-inside text-slate-500"><li>PKPT (Audit)</li><li>Ringkasan LHP</li><li>Laporan Akuntabilitas</li></ul>
            </div>
            <div class="space-y-1.5">
                <p class="text-green-500 border-b pb-0.5 flex items-center gap-2 uppercase font-bold italic"><i class="fas fa-map-marked-alt text-[10px]"></i> Desa / Kel / Kec</p>
                <ul class="list-disc list-inside text-slate-500"><li>APBDes / RKPDes</li><li>LPPD & Monografi</li><li>Laporan PATEN</li></ul>
            </div>
        </div>
    </div>
</div>