<div x-show="$store.pedomanAdminModal.activeTab === 1" 
     class="space-y-12 animate-fadeIn">
    
    <!-- Header Tab -->
    <div class="flex items-center gap-4 border-l-8 border-blue-600 pl-4 uppercase tracking-tighter">
        <div class="bg-blue-600 p-3 rounded-2xl text-white shadow-lg shadow-blue-200">
            <i class="fas fa-folder-tree text-2xl"></i>
        </div>
        <div>
            <h4 class="text-xl font-black text-slate-800 leading-none">Manajemen Informasi Publik</h4>
            <p class="text-[10px] text-slate-400 font-bold tracking-[0.2em] mt-1 italic">Mastering Information Classification & Lifecycle</p>
        </div>
    </div>

    <!-- LOGIKA MENDALAM (WHY) -->
    <div class="space-y-8">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h5 class="text-xs font-black flex items-center gap-3 text-slate-700 uppercase tracking-widest italic">
                <span class="bg-slate-100 p-1.5 rounded-lg"><i class="fas fa-balance-scale text-blue-600"></i></span> 
                Mengapa Harus Diklasifikasikan?
            </h5>
            <span class="text-[9px] bg-blue-50 text-blue-600 px-3 py-1 rounded-full font-bold uppercase tracking-tighter">Berdasarkan UU No. 14 Tahun 2008</span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- BERKALA -->
            <div class="group bg-white p-6 rounded-[2rem] border-2 border-slate-50 hover:border-blue-100 transition-all duration-300 shadow-sm hover:shadow-lg relative">
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h6 class="font-black text-blue-900 uppercase tracking-tighter text-sm">1. Informasi Berkala</h6>
                    </div>
                    
                    <p class="text-[11px] leading-relaxed text-slate-600 mb-5 font-medium normal-case">
                        Diterbitkan secara **rutin & terjadwal** (Bulanan, Triwulan, atau Tahunan). Fokus utama adalah memberikan gambaran kinerja organisasi saat ini.
                    </p>

                    <div class="space-y-3">
                        <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-100/50">
                            <span class="text-[9px] font-black text-blue-700 uppercase block mb-1.5 italic tracking-widest">Karakteristik: "Update & Replace"</span>
                            <p class="text-[10px] text-blue-900/80 leading-relaxed italic normal-case">
                                Data terbaru **menggantikan** relevansi data lama di halaman utama. Contoh: Saat LRA 2024 naik, LRA 2023 menjadi arsip.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SETIAP SAAT -->
            <div class="group bg-white p-6 rounded-[2rem] border-2 border-slate-50 hover:border-emerald-100 transition-all duration-300 shadow-sm hover:shadow-lg relative">
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-emerald-600 text-white rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200">
                            <i class="fas fa-archive"></i>
                        </div>
                        <h6 class="font-black text-emerald-900 uppercase tracking-tighter text-sm">2. Informasi Setiap Saat</h6>
                    </div>
                    
                    <p class="text-[11px] leading-relaxed text-slate-600 mb-5 font-medium normal-case">
                        Dokumen yang **wajib tersedia setiap saat** jika diminta. Biasanya berupa produk hukum atau dokumen kebijakan yang memiliki masa berlaku panjang.
                    </p>

                    <div class="space-y-3">
                        <div class="bg-emerald-50/50 p-4 rounded-2xl border border-emerald-100/50">
                            <span class="text-[9px] font-black text-emerald-700 uppercase block mb-1.5 italic tracking-widest">Karakteristik: "Add & Accumulate"</span>
                            <p class="text-[10px] text-emerald-900/80 leading-relaxed italic normal-case">
                                Sifatnya **akumulatif (menumpuk)**. Semua riwayat dokumen tetap penting dan tidak saling menggantikan posisi hukumnya.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 uppercase font-black tracking-tighter text-[10px]">
            <div class="group bg-gradient-to-r from-red-50 to-white p-5 rounded-3xl border border-red-100 flex items-center gap-4 transition-all">
                <div class="bg-red-600 p-3 rounded-2xl text-white shadow-lg animate-pulse"><i class="fas fa-bolt"></i></div>
                <div>
                    <h6 class="text-red-900 font-black text-xs">3. Serta Merta (Darurat)</h6>
                    <p class="text-slate-500 font-bold italic lowercase mt-0.5 leading-tight">Wajib tayang INSTAN! Menyangkut hajat hidup & keamanan publik.</p>
                </div>
            </div>
            <div class="group bg-slate-900 p-5 rounded-3xl border border-slate-800 flex items-center gap-4 transition-all">
                <div class="bg-slate-700 p-3 rounded-2xl text-slate-300"><i class="fas fa-user-secret"></i></div>
                <div>
                    <h6 class="text-slate-200 font-black text-xs">4. Dikecualikan (Rahasia)</h6>
                    <p class="text-slate-500 font-bold italic lowercase mt-0.5 leading-tight">Terbatas & Rahasia. Hanya untuk internal atau atas izin hukum.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- NEW SECTION: STUDI KASUS -->
    <div class="bg-slate-50 rounded-[2.5rem] p-8 md:p-10 border border-slate-200 shadow-inner relative overflow-hidden">
        <div class="relative z-10 space-y-8">
            <div class="text-center space-y-2">
                <h5 class="text-sm font-black uppercase tracking-[0.3em] text-indigo-700 italic">STUDI KASUS KLASIFIKASI</h5>
                <p class="text-[10px] text-slate-400 font-bold uppercase">Panduan Praktis Menentukan Jenis Dokumen</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Case 1 -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col h-full">
                    <div class="bg-blue-50 text-blue-600 text-[9px] font-black px-3 py-1 rounded-full self-start mb-4 uppercase">Kasus A</div>
                    <p class="text-[11px] font-bold text-slate-700 mb-4 normal-case italic leading-relaxed">"Saya ingin upload **Laporan Realisasi Anggaran (LRA) Semester 1 2024**."</p>
                    <div class="mt-auto pt-4 border-t border-slate-50">
                        <p class="text-[9px] font-black text-blue-600 uppercase mb-1">Klasifikasi: BERKALA</p>
                    </div>
                </div>

                <!-- Case 2 -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col h-full">
                    <div class="bg-emerald-50 text-emerald-600 text-[9px] font-black px-3 py-1 rounded-full self-start mb-4 uppercase">Kasus B</div>
                    <p class="text-[11px] font-bold text-slate-700 mb-4 normal-case italic leading-relaxed">"Saya ingin upload **SK Penetapan Tim Pelaksana Kegiatan** yang berlaku selamanya."</p>
                    <div class="mt-auto pt-4 border-t border-slate-50">
                        <p class="text-[9px] font-black text-emerald-600 uppercase mb-1">Klasifikasi: SETIAP SAAT</p>
                    </div>
                </div>

                <!-- Case 3 -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col h-full">
                    <div class="bg-red-50 text-red-600 text-[9px] font-black px-3 py-1 rounded-full self-start mb-4 uppercase">Kasus C</div>
                    <p class="text-[11px] font-bold text-slate-700 mb-4 normal-case italic leading-relaxed">"Ada pengumuman **Penutupan Jalan Mendadak** karena tanah longsor."</p>
                    <div class="mt-auto pt-4 border-t border-slate-50">
                        <p class="text-[9px] font-black text-red-600 uppercase mb-1">Klasifikasi: SERTA MERTA</p>
                    </div>
                </div>
            </div>

            <div class="bg-indigo-950 p-6 rounded-[2rem] text-white flex items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-indigo-400 border border-white/10">
                        <i class="fas fa-question-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-widest leading-none">Masih Ragu?</p>
                        <p class="text-[9px] text-indigo-300 font-bold mt-1 uppercase italic">Gunakan rumus: Rutin = Berkala, Hukum = Setiap Saat, Bahaya = Serta Merta.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TUTORIAL FORM A - H (VERTICAL TIMELINE) -->
    <div class="space-y-8">
        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <h5 class="text-xs font-black flex items-center gap-3 text-slate-700 uppercase tracking-widest italic">
                <span class="bg-slate-100 p-1.5 rounded-lg"><i class="fas fa-list-ol text-indigo-600"></i></span> 
                Alur Detail Pengisian Formulir
            </h5>
        </div>

        <div class="relative pl-6 space-y-6">
            <!-- Vertical Line Connector -->
            <div class="absolute left-[29px] top-6 bottom-6 w-1 bg-gradient-to-b from-indigo-500 via-blue-400 to-indigo-500 rounded-full opacity-20"></div>

            <!-- A: JUDUL -->
            <div class="group relative flex flex-col md:flex-row gap-6 items-center bg-white p-6 rounded-[2rem] border-2 border-slate-50 hover:border-indigo-100 transition-all shadow-sm">
                <div class="flex-1 flex gap-5 relative z-10">
                    <div class="w-10 h-10 bg-indigo-600 text-white rounded-2xl flex items-center justify-center font-black shadow-lg shadow-indigo-200 flex-shrink-0 text-sm">A</div>
                    <div class="space-y-1">
                        <h6 class="text-xs font-black uppercase text-slate-800 italic">Judul Informasi</h6>
                        <p class="text-[10px] text-slate-400 font-bold normal-case italic leading-relaxed">
                            Format Standar: **[Nama Dokumen] [Nama Unit] [Tahun]**. <br>
                            <span class="text-indigo-500 italic">Contoh: "Laporan Keuangan Dinas Perhubungan 2024"</span>
                        </p>
                    </div>
                </div>
                <div class="w-full md:w-64 bg-slate-50 p-3 rounded-xl border border-indigo-50 text-[9px] text-indigo-400 italic font-black uppercase tracking-tight overflow-hidden whitespace-nowrap">
                    Laporan Keuangan Dishub 2024...
                </div>
            </div>

            <!-- B: DESKRIPSI -->
            <div class="group relative flex flex-col md:flex-row gap-6 items-start bg-white p-6 rounded-[2rem] border-2 border-slate-50 shadow-sm">
                <div class="flex-1 flex gap-5 relative z-10">
                    <div class="w-10 h-10 bg-indigo-600 text-white rounded-2xl flex items-center justify-center font-black shadow-lg flex-shrink-0 text-sm">B</div>
                    <div class="space-y-3">
                        <h6 class="text-xs font-black uppercase text-slate-800 italic">Deskripsi & Pelengkap</h6>
                        <div class="bg-amber-50 p-5 rounded-2xl border-2 border-amber-100/50 text-amber-900 leading-relaxed text-[10px] font-bold normal-case">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fas fa-exclamation-circle text-amber-500"></i>
                                <span class="uppercase tracking-widest text-[9px]">Penting!</span>
                            </div>
                            "Jika dokumen memiliki banyak lampiran, **WAJIB gabungkan menjadi 1 file PDF**. Jika ukuran file > 10MB, gunakan link Google Drive resmi unit Bapak!"
                        </div>
                    </div>
                </div>
            </div>

            <!-- C, D, E, F -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 relative z-10">
                <div class="bg-white p-5 rounded-2xl border-2 border-slate-50 flex flex-col items-center gap-3 text-center shadow-sm">
                    <span class="w-8 h-8 bg-indigo-500 text-white rounded-xl flex items-center justify-center text-[10px] font-black shadow-lg shadow-indigo-100">C</span>
                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-tighter italic">Kategori</span>
                </div>
                <div class="bg-white p-5 rounded-2xl border-2 border-slate-50 flex flex-col items-center gap-3 text-center shadow-sm">
                    <span class="w-8 h-8 bg-indigo-500 text-white rounded-xl flex items-center justify-center text-[10px] font-black shadow-lg shadow-indigo-100">D</span>
                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-tighter italic">Jenis Info</span>
                </div>
                <div class="bg-white p-5 rounded-2xl border-2 border-slate-50 flex flex-col items-center gap-3 text-center shadow-sm">
                    <span class="w-8 h-8 bg-indigo-500 text-white rounded-xl flex items-center justify-center text-[10px] font-black shadow-lg shadow-indigo-100">E</span>
                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-tighter italic">Tagging</span>
                </div>
                <div class="bg-white p-5 rounded-2xl border-2 border-slate-50 flex flex-col items-center gap-3 text-center shadow-sm">
                    <span class="w-8 h-8 bg-indigo-500 text-white rounded-xl flex items-center justify-center text-[10px] font-black shadow-lg shadow-indigo-100">F</span>
                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-tighter italic">Cover</span>
                </div>
            </div>

            <!-- H: FINAL -->
            <div class="relative flex flex-col md:flex-row gap-6 items-center bg-indigo-900 p-6 rounded-[2.5rem] shadow-2xl border-4 border-white/10 overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-950 to-indigo-800 opacity-50"></div>
                <div class="flex-1 flex gap-5 relative z-10">
                    <div class="w-12 h-12 bg-white text-indigo-900 rounded-2xl flex items-center justify-center font-black shadow-xl animate-bounce flex-shrink-0 text-lg">H</div>
                    <div class="space-y-1">
                        <h6 class="text-xs font-black uppercase text-indigo-300 italic tracking-widest">Langkah Final: Simpan</h6>
                        <p class="text-[10px] text-white font-bold normal-case leading-relaxed">
                            "Khusus klasifikasi **BERKALA**, pastikan klik tombol kuning <span class="text-yellow-400 underline uppercase tracking-widest">CHECK INFORMASI</span> setelah simpan. Ini penting untuk menonaktifkan data lama secara otomatis agar publik hanya melihat data terbaru!"
                        </p>
                    </div>
                </div>
                <div class="flex-shrink-0 relative z-10 scale-90 md:scale-100">
                    <div class="bg-yellow-500 text-indigo-950 px-6 py-3 rounded-2xl text-[10px] font-black shadow-xl border-2 border-white/20 uppercase italic tracking-wider flex items-center gap-2">
                        <i class="fas fa-check-double"></i> CHECK INFORMASI
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BANTUAN AI (CLEAN) -->
    <div class="bg-slate-900 text-white p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden border border-slate-800 group">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl -mr-32 -mt-32 transition-all group-hover:bg-indigo-500/20"></div>
        <div class="relative z-10 flex flex-col md:flex-row gap-8 items-center">
            <div class="flex items-center gap-4">
                <div class="bg-gradient-to-tr from-indigo-600 to-blue-500 p-4 rounded-2xl text-white shadow-xl rotate-3 group-hover:rotate-0 transition-transform duration-500">
                    <i class="fas fa-magic text-xl"></i>
                </div>
                <div>
                    <h5 class="text-xs font-black uppercase tracking-[0.2em] italic">Bingung Klasifikasi?</h5>
                    <p class="text-[9px] text-slate-400 font-bold uppercase mt-1">Gunakan asisten AI untuk memandu Anda</p>
                </div>
            </div>
            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4 text-[10px] tracking-widest uppercase font-black">
                <div class="bg-white/5 p-4 rounded-2xl border border-white/10 flex items-center gap-3">
                    <span class="text-indigo-400">01</span>
                    <span>Klik <span class="text-indigo-400">"Tanya Pedoman"</span></span>
                </div>
                <div class="bg-white/5 p-4 rounded-2xl border border-white/10 flex items-center gap-3">
                    <span class="text-green-400">02</span>
                    <span>Ketik & Klik <span class="text-green-400 underline underline-offset-4">TANYA AI</span></span>
                </div>
            </div>
        </div>
    </div>
</div>