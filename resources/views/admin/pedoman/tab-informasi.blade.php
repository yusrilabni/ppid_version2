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
            <div class="bg-blue-50 p-12 rounded-[4rem] border-2 border-blue-200 relative overflow-hidden shadow-sm font-bold">
                <div class="absolute top-0 right-0 p-12 opacity-5"><i class="fas fa-history text-[10rem] text-blue-900"></i></div>
                <h6 class="font-black text-blue-900 mb-6 uppercase tracking-[0.2em] flex items-center gap-3 text-lg italic underline decoration-blue-200 underline-offset-8 decoration-4">
                    <i class="fas fa-calendar-alt"></i> 1. Informasi Berkala (Kewajiban Rutin)
                </h6>
                <p class="mb-8 text-base text-justify leading-loose">Dokumen diklasifikasikan sebagai <strong>Informasi Berkala</strong> berdasarkan <strong>Pasal 9 UU KIP</strong> karena merupakan <strong>Representasi Akuntabilitas Rutin</strong>. Wajib ada dan diperbarui terjadwal (tahunan/semesteran) sesuai siklus anggaran. Sifatnya <strong>Update Terkini (Ganti Data)</strong>. Dokumen terbaru (2024) WAJIB mematikan validitas dokumen lama (2023) menjadi <strong>ARSIP</strong>.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white/80 p-6 rounded-[2.5rem] border-4 border-blue-100 shadow-xl italic text-blue-800 text-xs font-black uppercase tracking-tighter leading-relaxed">
                        <p class="uppercase underline decoration-4 mb-3 italic tracking-widest">Studi Logika Rutin:</p>
                        <span>"Setiap dokumen dengan <strong>Siklus Waktu Tetap</strong> (seperti Renstra, Anggaran, atau Laporan Kinerja) WAJIB masuk kategori <strong>BERKALA</strong>. Data lama wajib masuk <strong>ARSIP</strong>."</span>
                    </div>
                    <div class="bg-white/80 p-6 rounded-[2.5rem] border-4 border-red-100 shadow-xl italic text-red-700 text-xs font-black uppercase tracking-tighter leading-relaxed">
                        <p class="uppercase underline decoration-4 mb-3 italic tracking-widest">Penting:</p>
                        <span>"Wajib mengubah status data lama menjadi ARSIP ketika ada dokumen baru yang BERLAKU, agar publik selalu mendapatkan referensi yang akurat."</span>
                    </div>
                </div>
            </div>

            <!-- SETIAP SAAT -->
            <div class="bg-emerald-50 p-12 rounded-[4rem] border-2 border-emerald-200 relative overflow-hidden shadow-sm text-emerald-900 font-bold uppercase">
                <div class="absolute top-0 right-0 p-12 opacity-5"><i class="fas fa-folder-open text-[10rem] text-emerald-900"></i></div>
                <h6 class="font-black mb-4 uppercase tracking-[0.2em] flex items-center gap-3 text-lg italic underline decoration-emerald-200 underline-offset-8 decoration-4">
                    <i class="fas fa-archive"></i> 2. Informasi Setiap Saat (Catatan Sejarah)
                </h6>
                <p class="mb-8 text-base text-justify leading-loose">Dokumen masuk kategori ini berdasarkan <strong>Pasal 11 UU KIP</strong> karena merupakan <strong>Catatan Histori & Produk Kebijakan</strong>. Wajib sedia kapanpun diminta. Sifatnya <strong>Akumulatif (Menumpuk)</strong>. Semua data tahun lama hingga sekarang tetap BERLAKU sebagai database sejarah unit Bapak.</p>
                <div class="bg-white/80 p-8 rounded-[2.5rem] border-4 border-emerald-100 shadow-xl italic text-emerald-800 text-xs font-black leading-loose tracking-tighter">
                    <p class="uppercase underline decoration-4 mb-3 italic tracking-widest">Studi Logika Kebijakan:</p>
                    <span>"Dokumen berupa <strong>Ketetapan Hukum</strong> (seperti SK Kadis, MoU Kerjasama) WAJIB masuk kategori <strong>SETIAP SAAT</strong> karena berlaku permanen selama belum dicabut pimpinan."</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="bg-red-50 p-8 rounded-[3rem] border-4 border-red-200 text-xs font-black shadow-lg">
                    <h6 class="text-red-900 mb-4 uppercase underline underline-offset-4 decoration-4 italic text-sm">3. Serta Merta (Darurat)</h6>
                    <p class="leading-relaxed text-slate-700">Mendesak & Mengancam Nyawa. Wajib upload detik itu juga! <br><span class="text-red-600 underline decoration-2 italic">(Contoh: Info Banjir, Wabah, Bencana Alam).</span></p>
                </div>
                <div class="bg-slate-900 p-8 rounded-[3rem] border-4 border-slate-700 text-xs font-black shadow-lg text-white">
                    <h6 class="text-slate-300 mb-4 uppercase underline underline-offset-4 decoration-4 italic text-sm">4. Dikecualikan (Rahasia)</h6>
                    <p class="leading-relaxed text-slate-400">Data Rahasia (Pasal 17 UU KIP). Tidak tampil di publik. <br><span class="text-indigo-400 italic underline decoration-2 italic">(Contoh: Rekam Medis, Rahasia Bisnis, Dokumen Hukum).</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- BAGIAN: TUTORIAL FORM LENGKAP A - H -->
    <div class="space-y-12">
        <h5 class="text-xl font-black flex items-center gap-4 border-b-4 border-slate-100 pb-4 uppercase text-slate-800 italic tracking-widest">
            <i class="fas fa-edit text-indigo-600 text-2xl shadow-sm"></i> Tutorial Pengisian Formulir (A - H)
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
                    <div class="ml-16 space-y-6 text-sm font-black italic uppercase tracking-tighter">
                        <p class="text-slate-500 italic underline decoration-2 underline-offset-4">Ringkasan isi dokumen bagi masyarakat.</p>
                        <div class="bg-amber-100 p-8 rounded-[3rem] border-4 border-amber-300 shadow-xl shadow-amber-200/50 relative overflow-hidden italic text-amber-900 font-black">
                            <div class="absolute top-0 right-0 p-8 opacity-10"><i class="fas fa-file-pdf text-7xl"></i></div>
                            <h6 class="font-black uppercase mb-4 underline decoration-4 decoration-amber-500 italic flex items-center gap-2 tracking-widest"><i class="fas fa-exclamation-triangle text-xl"></i> Dokumen Pelengkap (WAJIB):</h6>
                            <p class="leading-loose uppercase tracking-tighter underline underline-offset-4 decoration-2 decoration-amber-300 italic">"Jika laporan Bapak memiliki lampiran banyak (DPA + Lampiran A-Z), wajib GABUNGKAN DALAM 1 PDF atau gunakan opsi Link File Google Drive unit Bapak!"</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- C - G (Ringkas) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 border-b-2 border-dashed border-slate-200 pb-12">
                <div class="space-y-4 font-black">
                    <div class="flex gap-4 items-center">
                        <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm shadow-lg">C</span>
                        <p class="text-xs uppercase">Kategori Klasifikasi (Berkala/Setiap Saat)</p>
                    </div>
                    <div class="flex gap-4 items-center">
                        <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm shadow-lg">D</span>
                        <p class="text-xs uppercase">Jenis Dokumen (Sesuai Folder Folder Folder)</p>
                    </div>
                </div>
                <div class="space-y-4 font-black">
                    <div class="flex gap-4 items-center">
                        <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm shadow-lg">E</span>
                        <p class="text-xs uppercase">Tags / Kata Kunci Pencarian</p>
                    </div>
                    <div class="flex gap-4 items-center">
                        <span class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm shadow-lg">F</span>
                        <p class="text-xs uppercase">Gambar Cover / Thumbnail Dokumen</p>
                    </div>
                </div>
            </div>

            <!-- H: FINALISASI (CHECK SIMILARITY) -->
            <div class="flex flex-col md:flex-row gap-10 items-start pt-4 font-black uppercase tracking-tighter">
                <div class="flex-1 space-y-6 border-l-8 border-indigo-600 pl-10 bg-indigo-50/30 p-8 rounded-r-3xl">
                    <div class="flex gap-5 items-center">
                        <span class="w-14 h-14 bg-blue-600 text-white rounded-full flex items-center justify-center font-black text-2xl shadow-2xl shadow-blue-200 animate-bounce border-4 border-white">H</span>
                        <h6 class="text-xl font-black underline decoration-blue-500 decoration-8 underline-offset-8 italic">Check & Simpan</h6>
                    </div>
                    <p class="ml-16 text-sm text-blue-700 italic font-black leading-loose uppercase tracking-tighter italic">"Khusus BERKALA, WAJIB klik <strong>CHECK INFORMASI</strong> untuk mematikan data tahun lama secara otomatis agar publik tidak bingung!"</p>
                    <div class="flex justify-center relative pt-4">
                        <div class="bg-yellow-500 text-white px-16 py-5 rounded-[2.5rem] text-sm font-black shadow-[0_25px_60px_rgba(234,179,8,0.5)] animate-bounce border-8 border-white uppercase italic shadow-yellow-200/50 tracking-widest italic decoration-white/20 underline">CHECK INFORMASI</div>
                        <div class="absolute -left-10 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[20px] border-y-transparent border-r-[35px] border-r-yellow-500 shadow-2xl"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BANTUAN AI -->
    <div class="bg-indigo-900 text-white p-16 rounded-[6rem] shadow-2xl relative overflow-hidden italic font-black uppercase tracking-tighter">
        <div class="absolute -right-10 -bottom-10 opacity-10"><i class="fas fa-microchip text-[18rem]"></i></div>
        <div class="relative z-10">
            <h5 class="text-3xl font-black mb-12 flex items-center gap-10 italic underline decoration-[12px] decoration-indigo-700 underline-offset-[16px]">
                <i class="fas fa-magic text-indigo-300 text-6xl shadow-indigo-950"></i> Bingung Klasifikasi? Tanya AI!
            </h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-20 items-center">
                <div class="space-y-12 text-lg font-black italic">
                    <div class="flex gap-8 items-start bg-white/5 p-10 rounded-[3rem] border-4 border-white/10 shadow-2xl transition-all hover:bg-white/10 group">
                        <span class="bg-indigo-500 text-white w-14 h-14 rounded-full flex-shrink-0 flex items-center justify-center font-black text-2xl shadow-xl shadow-indigo-900/50">1</span>
                        <p class="pt-2 uppercase underline decoration-indigo-400 decoration-4">Klik tombol "Tanya Pedoman" di pojok kanan atas form.</p>
                    </div>
                    <div class="flex gap-8 items-start bg-white/5 p-10 rounded-[3rem] border-4 border-white/10 shadow-2xl transition-all hover:bg-white/10 group">
                        <span class="bg-indigo-500 text-white w-14 h-14 rounded-full flex-shrink-0 flex items-center justify-center font-black text-2xl shadow-xl shadow-indigo-900/50">2</span>
                        <p class="pt-2 italic uppercase italic underline decoration-green-500 decoration-[6px] underline-offset-[10px]">Ketik Nama Dokumen & Klik Tombol Hijau <span class="bg-green-600 px-6 py-2 rounded-2xl animate-pulse shadow-green-900/50 border-4 border-white">TANYA AI</span>!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- REKAPITULASI DOKUMEN WAJIB PER UNIT -->
    <div class="bg-white border-[16px] border-slate-100 rounded-[6rem] p-20 shadow-2xl relative overflow-hidden font-black italic uppercase tracking-tighter text-slate-500 shadow-inner uppercase">
        <div class="absolute top-0 left-0 w-full h-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-emerald-600 shadow-lg"></div>
        <h5 class="text-3xl font-black text-slate-800 mb-16 text-center uppercase tracking-[0.6em] italic underline decoration-8 decoration-slate-100 underline-offset-[20px] uppercase">Dokumen Wajib Per Unit Kerja</h5>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-20">
            <!-- DINAS -->
            <div class="space-y-8 border-r-4 border-dashed border-slate-50 pr-10">
                <p class="text-lg font-black text-blue-600 border-b-8 border-blue-50 pb-4 italic underline underline-offset-8 decoration-4"><i class="fas fa-building text-3xl mr-3"></i> Dinas / Badan / RSUD</p>
                <ul class="text-xs space-y-6 list-disc list-inside leading-loose italic uppercase font-black">
                    <li>Renstra & Renja (5 thn & thn)</li>
                    <li>DPA & RKA Anggaran Unit</li>
                    <li>LRA & Neraca Keuangan</li>
                    <li>Tarif Layanan & SPM (RSUD)</li>
                    <li>LHKPN Pejabat Utama</li>
                </ul>
            </div>
            <!-- INSPEKTORAT -->
            <div class="space-y-8 border-r-4 border-dashed border-slate-50 pr-10">
                <p class="text-lg font-black text-indigo-600 border-b-8 border-indigo-50 pb-4 italic underline underline-offset-8 decoration-4"><i class="fas fa-search-dollar text-3xl mr-3"></i> Inspektorat</p>
                <ul class="text-xs space-y-6 list-disc list-inside leading-loose italic uppercase font-black">
                    <li>PKPT (Program Kerja Audit)</li>
                    <li>Ringkasan LHP Publik</li>
                    <li>SOP Audit Pengawasan</li>
                    <li>Laporan Akuntabilitas</li>
                </ul>
            </div>
            <!-- KEC/DESA -->
            <div class="space-y-8">
                <p class="text-lg font-black text-green-600 border-b-8 border-green-50 pb-4 italic underline underline-offset-8 decoration-4"><i class="fas fa-map-marked-alt text-3xl mr-3"></i> Kecamatan / Desa / Kel</p>
                <ul class="text-xs space-y-6 list-disc list-inside leading-loose italic uppercase font-black">
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