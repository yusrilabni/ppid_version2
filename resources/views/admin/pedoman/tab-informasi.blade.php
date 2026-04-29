<div x-show="$store.pedomanAdminModal.activeTab === 1" x-transition class="space-y-10">
    <div class="flex items-center gap-3 border-l-4 border-blue-600 pl-3 uppercase tracking-tighter">
        <h4 class="text-base font-bold text-slate-800 italic">Klasifikasi & Panduan Operasional Informasi</h4>
    </div>

    <!-- LOGIKA MENDALAM (WHY) -->
    <div class="space-y-4">
        <h5 class="text-xs font-bold flex items-center gap-2 border-b pb-1 text-slate-800 uppercase italic">
            <i class="fas fa-balance-scale text-blue-600"></i> Mengapa Harus Diklasifikasikan?
        </h5>
        
        <div class="grid grid-cols-1 gap-5 text-[10px] font-bold uppercase tracking-tighter leading-relaxed">
            <!-- BERKALA -->
            <div class="bg-blue-50 p-5 rounded-2xl border border-blue-100 relative overflow-hidden shadow-sm">
                <h6 class="font-black text-blue-900 mb-2 uppercase flex items-center gap-2 italic underline decoration-blue-200 decoration-2">
                    <i class="fas fa-calendar-alt"></i> 1. Informasi Berkala (Kewajiban Rutin)
                </h6>
                <p class="mb-3 text-justify">Dokumen diklasifikasikan sebagai <strong>Informasi Berkala</strong> berdasarkan <strong>Pasal 9 UU KIP</strong> karena merupakan <strong>Representasi Akuntabilitas Rutin</strong>. Wajib ada dan diperbarui terjadwal (tahunan/semesteran) sesuai siklus anggaran. Sifatnya <strong>Update Terkini (Ganti Data)</strong>. Dokumen terbaru (2024) WAJIB mematikan validitas dokumen lama (2023) menjadi <strong>ARSIP</strong>.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 italic">
                    <div class="bg-white/80 p-3 rounded-xl border border-blue-100 text-blue-800 shadow-sm leading-tight">
                        <p class="uppercase underline mb-1 font-black">Studi Logika Rutin:</p>
                        <span>"Setiap dokumen dengan <strong>Siklus Waktu Tetap</strong> (Renstra, Anggaran, Laporan Kinerja) WAJIB masuk kategori <strong>BERKALA</strong>. Data lama wajib masuk <strong>ARSIP</strong>."</span>
                    </div>
                    <div class="bg-white/80 p-3 rounded-xl border border-red-100 text-red-700 shadow-sm leading-tight">
                        <p class="uppercase underline mb-1 font-black">Penting:</p>
                        <span>"Wajib mengubah status data lama menjadi ARSIP ketika ada dokumen baru yang BERLAKU, agar publik selalu mendapatkan referensi yang akurat."</span>
                    </div>
                </div>
            </div>

            <!-- SETIAP SAAT -->
            <div class="bg-emerald-50 p-5 rounded-2xl border border-emerald-100 relative overflow-hidden shadow-sm text-emerald-900">
                <h6 class="font-black mb-2 uppercase flex items-center gap-2 italic underline decoration-emerald-200 decoration-2">
                    <i class="fas fa-archive"></i> 2. Informasi Setiap Saat (Catatan Sejarah)
                </h6>
                <p class="mb-3 text-justify font-bold">Dokumen masuk kategori ini berdasarkan <strong>Pasal 11 UU KIP</strong> karena merupakan <strong>Catatan Histori & Produk Kebijakan</strong>. Wajib sedia kapanpun diminta. Sifatnya <strong>Akumulatif (Menumpuk)</strong>. Semua data tahun lama hingga sekarang tetap BERLAKU sebagai database sejarah kebijakan unit Bapak.</p>
                <div class="bg-white/80 p-3 rounded-xl border border-emerald-100 text-emerald-800 shadow-sm leading-tight italic font-black">
                    <p class="uppercase underline mb-1">Studi Logika Kebijakan:</p>
                    <span>"Dokumen berupa <strong>Ketetapan Hukum</strong> (seperti SK Kadis, MoU Kerjasama) WAJIB masuk kategori <strong>SETIAP SAAT</strong> karena berlaku permanen selama belum dicabut pimpinan."</span>
                </div>
            </div>

            <!-- SERTA MERTA & DIKECUALIKAN -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 uppercase font-black tracking-tighter italic">
                <div class="bg-red-50 p-4 rounded-xl border border-red-200 shadow-sm leading-tight">
                    <h6 class="font-black text-red-900 mb-1 uppercase underline italic">3. Serta Merta (Darurat)</h6>
                    <p>Mendesak! Wajib upload detik itu juga! <span class="text-red-600">(Contoh: Info Banjir, Wabah).</span></p>
                </div>
                <div class="bg-slate-900 p-4 rounded-xl border border-slate-700 text-white shadow-sm leading-tight">
                    <h6 class="font-black text-slate-300 mb-1 uppercase underline italic">4. Dikecualikan (Rahasia)</h6>
                    <p>Data Rahasia (Pasal 17 UU KIP). Tidak tampil. <span class="text-indigo-400">(Contoh: Rekam Medis).</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- TUTORIAL FORM LENGKAP A - H -->
    <div class="space-y-6">
        <h5 class="text-xs font-bold flex items-center gap-2 border-b pb-1 uppercase text-slate-800 italic">
            <i class="fas fa-edit text-indigo-600 shadow-sm"></i> Tutorial Pengisian Formulir (A - H)
        </h5>

        <div class="bg-slate-50 rounded-2xl border border-slate-200 p-5 space-y-6 shadow-inner font-bold uppercase tracking-tighter">
            
            <!-- A: JUDUL -->
            <div class="flex flex-col md:flex-row gap-4 items-start font-black">
                <div class="flex-1 space-y-1">
                    <div class="flex gap-2 items-center">
                        <span class="w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-[10px] shadow-md">A</span>
                        <h6 class="text-[10px] font-black italic underline decoration-indigo-200 underline-offset-2">Judul Informasi</h6>
                    </div>
                    <p class="ml-8 text-[9px] text-slate-500 italic">Baku: Nama Dokumen + Unit + Tahun.</p>
                </div>
                <div class="md:w-56 bg-white p-2.5 rounded-lg border border-indigo-100 shadow-md relative">
                    <div class="h-8 w-full border-2 border-indigo-200 rounded-lg bg-indigo-50/50 flex items-center px-3 text-[8px] text-indigo-400 italic shadow-inner">Renja Dinas... 2024...</div>
                    <div class="absolute -left-2 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[10px] border-r-indigo-600 shadow-lg"></div>
                </div>
            </div>

            <!-- B: DESKRIPSI -->
            <div class="flex flex-col md:flex-row gap-4 items-start border-t pt-5 font-black">
                <div class="flex-1 space-y-3">
                    <div class="flex gap-2 items-center">
                        <span class="w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-[10px] shadow-md">B</span>
                        <h6 class="text-[10px] font-black italic underline decoration-indigo-200 underline-offset-2">Deskripsi & Lampiran</h6>
                    </div>
                    <div class="ml-8 space-y-3">
                        <p class="text-[9px] text-slate-500 italic">Ringkasan isi dokumen bagi masyarakat.</p>
                        <div class="bg-amber-100 p-4 rounded-xl border border-amber-300 italic text-amber-900 font-black text-[9px] leading-normal shadow-sm">
                            <h6 class="uppercase mb-1 underline italic flex items-center gap-1 font-black"><i class="fas fa-exclamation-triangle"></i> Dokumen Pelengkap (WAJIB):</h6>
                            <p>"GABUNGKAN DALAM 1 PDF. Jika > 2MB, pilih opsi Link File Google Drive unit Bapak!"</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- C, D, E, F -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t pt-5 font-black">
                <div class="space-y-4">
                    <div class="flex gap-2 items-center">
                        <span class="w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-[10px] shadow-md">C</span>
                        <p class="text-[9px] uppercase italic">Kategori Klasifikasi (Berkala/Setiap Saat)</p>
                    </div>
                    <div class="flex gap-2 items-center">
                        <span class="w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-[10px] shadow-md">D</span>
                        <p class="text-[9px] uppercase italic">Jenis Dokumen (Sesuai Folder Beranda)</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex gap-2 items-center">
                        <span class="w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-[10px] shadow-md">E</span>
                        <p class="text-[9px] uppercase italic">Tags / Kata Kunci Pencarian</p>
                    </div>
                    <div class="flex gap-2 items-center">
                        <span class="w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-[10px] shadow-md">F</span>
                        <p class="text-[9px] uppercase italic">Gambar Cover / Thumbnail Dokumen</p>
                    </div>
                </div>
            </div>

            <!-- H: FINALISASI -->
            <div class="flex flex-col md:flex-row gap-4 items-start border-t pt-5 font-black">
                <div class="flex-1 space-y-2">
                    <div class="flex gap-2 items-center">
                        <span class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-xs shadow-lg animate-bounce border-2 border-white">H</span>
                        <h6 class="text-[10px] font-black underline decoration-blue-500 decoration-2 italic text-blue-900">Check & Simpan</h6>
                    </div>
                    <p class="ml-10 text-[9px] text-blue-700 italic font-black leading-normal uppercase">"Khusus BERKALA, WAJIB klik <strong>CHECK INFORMASI</strong> untuk mengarsipkan data lama otomatis!"</p>
                </div>
                <div class="md:w-56 flex justify-center relative scale-90">
                    <div class="bg-yellow-500 text-white px-6 py-2 rounded-xl text-[9px] font-black shadow-xl animate-bounce border-2 border-white uppercase italic">CHECK INFORMASI</div>
                    <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[10px] border-r-yellow-500 shadow-md"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- BANTUAN AI (STYLISH) -->
    <div class="bg-indigo-900 text-white p-6 rounded-[2.5rem] shadow-xl relative overflow-hidden italic font-bold uppercase tracking-tighter border-2 border-indigo-950">
        <div class="absolute -right-6 -bottom-6 opacity-10 rotate-12"><i class="fas fa-microchip text-[6rem]"></i></div>
        <div class="relative z-10">
            <h5 class="text-sm font-black mb-4 flex items-center gap-3 underline decoration-4 decoration-indigo-700 underline-offset-4">
                <i class="fas fa-magic text-indigo-300 text-2xl shadow-indigo-950"></i> Bingung Klasifikasi? Tanya AI!
            </h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center text-[9px] font-black tracking-widest">
                <div class="space-y-2">
                    <div class="flex gap-3 items-center bg-white/5 p-2.5 rounded-xl border border-white/10 shadow-sm hover:bg-white/10 transition-all group">
                        <span class="bg-indigo-500 text-white w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">1</span>
                        <p class="underline decoration-indigo-400">Klik "Tanya Pedoman" di pojok form.</p>
                    </div>
                    <div class="flex gap-3 items-center bg-white/5 p-2.5 rounded-xl border border-white/10 shadow-sm hover:bg-white/10 transition-all group">
                        <span class="bg-indigo-500 text-white w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">2</span>
                        <p class="italic underline decoration-green-500 decoration-2 underline-offset-2">Ketik Nama & Klik <span class="bg-green-600 px-1.5 py-0.5 rounded border border-white">TANYA AI</span>!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- REKAPITULASI DOKUMEN (FINAL SECTION) -->
    <div class="bg-white border-2 border-slate-100 rounded-[2.5rem] p-8 shadow-2xl relative overflow-hidden font-black italic uppercase tracking-tighter text-slate-500 shadow-inner">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 via-indigo-600 to-emerald-600 shadow-md"></div>
        <h5 class="text-sm font-black text-slate-800 mb-6 text-center uppercase tracking-widest border-b-2 border-slate-50 pb-1 underline underline-offset-4 decoration-4">Dokumen Wajib Per Unit Kerja</h5>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-[9px] font-black leading-loose">
            <div class="space-y-2 border-r border-slate-100 pr-2">
                <p class="font-black text-blue-600 border-b pb-1 italic underline underline-offset-2 decoration-2 flex items-center gap-1"><i class="fas fa-building text-sm"></i> Dinas / Badan / RSUD</p>
                <ul class="space-y-1 list-disc list-inside">
                    <li>Renstra & Renja (5 thn & thn)</li>
                    <li>DPA & RKA Anggaran Unit</li>
                    <li>LRA & Neraca Keuangan</li>
                    <li>Tarif Layanan & SPM (RSUD)</li>
                    <li>LHKPN Pejabat Utama</li>
                </ul>
            </div>
            <div class="space-y-2 border-r border-slate-100 pr-2">
                <p class="font-black text-indigo-600 border-b pb-1 italic underline underline-offset-2 decoration-2 flex items-center gap-1"><i class="fas fa-search-dollar text-sm"></i> Inspektorat</p>
                <ul class="space-y-1 list-disc list-inside text-justify">
                    <li>PKPT (Program Kerja Audit)</li>
                    <li>Ringkasan LHP Publik</li>
                    <li>SOP Audit Pengawasan</li>
                    <li>Laporan Akuntabilitas</li>
                </ul>
            </div>
            <div class="space-y-2">
                <p class="font-black text-green-600 border-b pb-1 italic underline underline-offset-2 decoration-2 flex items-center gap-1"><i class="fas fa-map-marked-alt text-sm"></i> Kecamatan / Desa / Kel</p>
                <ul class="space-y-1 list-disc list-inside text-justify">
                    <li>APBDes / RKPDes (Anggaran)</li>
                    <li>LPPD Penyelenggaraan Desa</li>
                    <li>Monografi & Profil Wilayah</li>
                    <li>Data Inventaris Aset Desa</li>
                    <li>Laporan PATEN (Kecamatan)</li>
                </ul>
            </div>
        </div>
    </div>
</div>