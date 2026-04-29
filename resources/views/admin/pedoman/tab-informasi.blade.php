<div x-show="$store.pedomanAdminModal.activeTab === 1" 
     class="space-y-12">
    
    <!-- Header Tab -->
    <div class="flex items-center gap-4 border-l-8 border-blue-600 pl-4 uppercase tracking-tighter">
        <div class="bg-blue-600 p-3 rounded-2xl text-white shadow-md">
            <i class="fas fa-folder-tree text-2xl"></i>
        </div>
        <div>
            <h4 class="text-xl font-black text-slate-800 leading-none">Manajemen Informasi Publik</h4>
            <p class="text-[10px] text-slate-400 font-bold tracking-[0.2em] mt-1 italic">Panduan Komprehensif Klasifikasi & Siklus Hidup Dokumen</p>
        </div>
    </div>

    <!-- LOGIKA MENDALAM (WHY) -->
    <div class="space-y-10">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h5 class="text-xs font-black flex items-center gap-3 text-slate-700 uppercase tracking-widest italic">
                <span class="bg-slate-100 p-1.5 rounded-lg"><i class="fas fa-balance-scale text-blue-600"></i></span> 
                Mengapa Harus Diklasifikasikan?
            </h5>
            <span class="text-[9px] bg-blue-50 text-blue-600 px-3 py-1 rounded-full font-bold uppercase tracking-tighter">Pedoman Standar Layanan Informasi Publik (UU No. 14/2008)</span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- BERKALA -->
            <div class="group bg-white p-8 rounded-[2.5rem] border-2 border-slate-50 hover:border-blue-100 transition-all duration-300 shadow-sm relative">
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200">
                            <i class="fas fa-calendar-alt text-xl"></i>
                        </div>
                        <div>
                            <h6 class="font-black text-blue-900 uppercase tracking-tighter text-base">1. Informasi Berkala</h6>
                            <p class="text-[9px] text-blue-500 font-bold uppercase italic">Pasal 9 UU KIP - Akuntabilitas Rutin</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4 text-[11px] leading-relaxed text-slate-600 font-medium normal-case">
                        <p>Informasi Berkala adalah dokumen yang wajib disediakan dan diumumkan secara **rutin, terjadwal, dan berkala** (setiap 6 bulan atau 1 tahun sekali). Informasi ini merupakan cerminan kinerja keuangan dan operasional unit Bapak/Ibu dalam satu periode tertentu.</p>
                        
                        <div class="bg-blue-50/50 p-5 rounded-3xl border border-blue-100/50 space-y-3">
                            <span class="text-[10px] font-black text-blue-700 uppercase block italic tracking-widest border-b border-blue-200 pb-1">Logika: "Update & Replace"</span>
                            <p class="text-[10px] text-blue-900/80 italic">Setiap kali ada dokumen terbaru (misal: LRA 2024), maka dokumen tersebut akan **menggantikan posisi** dokumen tahun sebelumnya (LRA 2023) di daftar utama informasi publik. Dokumen lama tidak hilang, melainkan secara sistematis beralih fungsi menjadi **ARSIP HISTORIS** agar publik fokus pada capaian terkini organisasi.</p>
                        </div>
                        
                        <div class="space-y-2">
                            <p class="font-black text-slate-800 uppercase text-[9px] tracking-widest italic">Contoh Dokumen Wajib:</p>
                            <div class="flex flex-wrap gap-2 uppercase font-black text-[8px]">
                                <span class="bg-slate-100 text-slate-500 px-3 py-1.5 rounded-lg border border-slate-200">Laporan Keuangan (LRA/Neraca)</span>
                                <span class="bg-slate-100 text-slate-500 px-3 py-1.5 rounded-lg border border-slate-200">Rencana Strategis (RENSTRA)</span>
                                <span class="bg-slate-100 text-slate-500 px-3 py-1.5 rounded-lg border border-slate-200">Rencana Kerja (RENJA)</span>
                                <span class="bg-slate-100 text-slate-500 px-3 py-1.5 rounded-lg border border-slate-200">Laporan Akuntabilitas (LAKIP)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SETIAP SAAT -->
            <div class="group bg-white p-8 rounded-[2.5rem] border-2 border-slate-50 hover:border-emerald-100 transition-all duration-300 shadow-sm relative">
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-emerald-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200">
                            <i class="fas fa-file-signature text-xl"></i>
                        </div>
                        <div>
                            <h6 class="font-black text-emerald-900 uppercase tracking-tighter text-base">2. Informasi Setiap Saat</h6>
                            <p class="text-[9px] text-emerald-500 font-bold uppercase italic">Pasal 11 UU KIP - Rekam Jejak Kebijakan</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4 text-[11px] leading-relaxed text-slate-600 font-medium normal-case">
                        <p>Informasi Setiap Saat adalah kumpulan dokumen yang **wajib tersedia dan siap diberikan** kapanpun dibutuhkan oleh masyarakat. Informasi ini mencakup produk-produk hukum, keputusan pimpinan, serta riwayat administrasi yang mendasari jalannya organisasi.</p>
                        
                        <div class="bg-emerald-50/50 p-5 rounded-3xl border border-emerald-100/50 space-y-3">
                            <span class="text-[10px] font-black text-emerald-700 uppercase block italic tracking-widest border-b border-emerald-200 pb-1">Logika: "Historis & Akumulatif"</span>
                            <p class="text-[10px] text-emerald-900/80 italic">Berbeda dengan berkala, dokumen ini sifatnya **akumulatif (menumpuk)**. Semua riwayat dokumen tetap penting dan tidak saling menggantikan posisi hukumnya secara otomatis kecuali ada pencabutan. Data tahun-tahun lama tetap berlaku sebagai bukti otentik jalannya kebijakan organisasi dari waktu ke waktu.</p>
                        </div>

                        <div class="space-y-2">
                            <p class="font-black text-slate-800 uppercase text-[9px] tracking-widest italic">Contoh Dokumen Wajib:</p>
                            <div class="flex flex-wrap gap-2 uppercase font-black text-[8px]">
                                <span class="bg-slate-100 text-slate-500 px-3 py-1.5 rounded-lg border border-slate-200">Surat Keputusan (SK) Pimpinan</span>
                                <span class="bg-slate-100 text-slate-500 px-3 py-1.5 rounded-lg border border-slate-200">Peraturan & Instruksi</span>
                                <span class="bg-slate-100 text-slate-500 px-3 py-1.5 rounded-lg border border-slate-200">Daftar Aset & Inventaris</span>
                                <span class="bg-slate-100 text-slate-500 px-3 py-1.5 rounded-lg border border-slate-200">Dokumen Perjanjian (MoU/Kerjasama)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- LOWER GRID: SERTA MERTA & DIKECUALIKAN -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- SERTA MERTA -->
            <div class="bg-gradient-to-br from-red-50 to-white p-8 rounded-[2.5rem] border-2 border-red-100 shadow-sm space-y-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-600 text-white rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0">
                        <i class="fas fa-bolt text-xl"></i>
                    </div>
                    <div>
                        <h6 class="text-red-900 font-black text-sm uppercase italic">3. Informasi Serta Merta</h6>
                        <p class="text-[9px] text-red-600 font-bold uppercase italic leading-none mt-1">Pasal 10 UU KIP - Keadaan Darurat</p>
                    </div>
                </div>
                <p class="text-[11px] leading-relaxed text-slate-600 font-medium normal-case">Informasi yang wajib diumumkan **Seketika (Tanpa Tunda)** karena menyangkut hajat hidup orang banyak dan ketertiban umum. Jika terlambat, dapat berisiko pada keselamatan publik.</p>
                <div class="bg-white/60 p-4 rounded-2xl text-[10px] text-red-800 italic font-bold border border-red-100 uppercase tracking-tight leading-tight">
                    <i class="fas fa-exclamation-triangle mr-1"></i> Contoh: Peringatan Bencana Alam, Informasi Wabah Penyakit, Gangguan Layanan Publik Mendadak.
                </div>
            </div>

            <!-- DIKECUALIKAN -->
            <div class="bg-slate-900 p-8 rounded-[2.5rem] border-4 border-slate-800 shadow-2xl space-y-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-slate-700 text-slate-300 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0">
                        <i class="fas fa-user-secret text-xl"></i>
                    </div>
                    <div>
                        <h6 class="text-slate-100 font-black text-sm uppercase italic">4. Informasi Dikecualikan</h6>
                        <p class="text-[9px] text-slate-400 font-bold uppercase italic leading-none mt-1">Pasal 17 UU KIP - Rahasia Negara/Pribadi</p>
                    </div>
                </div>
                <p class="text-[11px] leading-relaxed text-slate-400 font-medium normal-case italic">Informasi yang bersifat **Rahasia** dan tidak dapat diakses publik karena dapat mengganggu keamanan negara, hak pribadi, rahasia bisnis, atau proses hukum yang sedang berjalan.</p>
                <div class="bg-slate-800 p-4 rounded-2xl text-[10px] text-slate-300 italic font-bold border border-slate-700 uppercase tracking-tight leading-tight">
                    <i class="fas fa-shield-alt mr-1"></i> Contoh: Data Medis Pribadi, Rahasia Militer, Dokumen Proses Penyelidikan Kepolisian.
                </div>
            </div>
        </div>
    </div>

    <!-- NEW SECTION: STUDI KASUS MENDALAM -->
    <div class="bg-slate-100/80 rounded-[3rem] p-10 md:p-12 border-2 border-slate-200 shadow-inner relative overflow-hidden">
        <div class="relative z-10 space-y-10">
            <div class="text-center space-y-3">
                <div class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-[0.4em] italic shadow-lg mb-2">STUDI KASUS PRAKTIS</div>
                <h5 class="text-xl font-black text-slate-800 uppercase italic leading-none">Bagaimana Cara Saya Menentukan Klasifikasi?</h5>
                <p class="text-[11px] text-slate-500 font-bold uppercase tracking-widest leading-relaxed">Gunakan skenario di bawah ini sebagai panduan pengambilan keputusan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Case 1 -->
                <div class="bg-white p-8 rounded-[2.5rem] border-2 border-slate-200 shadow-sm flex flex-col h-full hover:border-indigo-300 transition-all duration-300">
                    <div class="bg-blue-600 text-white text-[10px] font-black px-4 py-1.5 rounded-full self-start mb-6 uppercase shadow-md">SKENARIO A</div>
                    <div class="flex-1 space-y-4">
                        <p class="text-[12px] font-black text-slate-800 normal-case italic leading-relaxed">"Saya baru saja menyelesaikan **Laporan Realisasi Anggaran (LRA) Semester II Tahun 2024** untuk dinas saya. Di mana saya harus mengunggahnya?"</p>
                        <div class="bg-slate-50 p-5 rounded-2xl border-l-4 border-blue-600">
                            <p class="text-[10px] font-black text-blue-700 uppercase mb-2 tracking-widest italic leading-none">ANALISIS & KEPUTUSAN:</p>
                            <p class="text-[10px] text-slate-600 font-bold normal-case leading-relaxed italic">Ini adalah dokumen kinerja rutin tahunan. Karena bersifat update berkala, pilih klasifikasi **BERKALA**. Setelah upload, jangan lupa klik 'Check Informasi' agar data LRA 2023 otomatis terarsip.</p>
                        </div>
                    </div>
                </div>

                <!-- Case 2 -->
                <div class="bg-white p-8 rounded-[2.5rem] border-2 border-slate-200 shadow-sm flex flex-col h-full hover:border-emerald-300 transition-all duration-300">
                    <div class="bg-emerald-600 text-white text-[10px] font-black px-4 py-1.5 rounded-full self-start mb-6 uppercase shadow-md">SKENARIO B</div>
                    <div class="flex-1 space-y-4">
                        <p class="text-[12px] font-black text-slate-800 normal-case italic leading-relaxed">"Kepala Dinas mengeluarkan **SK Tim Pelaksana Kegiatan** yang menjadi dasar hukum tim kami bekerja selama setahun penuh atau lebih."</p>
                        <div class="bg-slate-50 p-5 rounded-2xl border-l-4 border-emerald-600">
                            <p class="text-[10px] font-black text-emerald-700 uppercase mb-2 tracking-widest italic leading-none">ANALISIS & KEPUTUSAN:</p>
                            <p class="text-[10px] text-slate-600 font-bold normal-case leading-relaxed italic">Ini adalah produk hukum/kebijakan pimpinan yang harus siap diakses sebagai riwayat hukum organisasi. Pilih klasifikasi **SETIAP SAAT**. Dokumen ini akan tetap tayang berdampingan dengan SK-SK lainnya secara akumulatif.</p>
                        </div>
                    </div>
                </div>

                <!-- Case 3 -->
                <div class="bg-white p-8 rounded-[2.5rem] border-2 border-slate-200 shadow-sm flex flex-col h-full hover:border-red-300 transition-all duration-300">
                    <div class="bg-red-600 text-white text-[10px] font-black px-4 py-1.5 rounded-full self-start mb-6 uppercase shadow-md">SKENARIO C</div>
                    <div class="flex-1 space-y-4">
                        <p class="text-[12px] font-black text-slate-800 normal-case italic leading-relaxed">"Terjadi **Kebakaran Hebat** di wilayah pasar yang mengancam keselamatan banyak warga. Humas ingin mengumumkan jalur evakuasi."</p>
                        <div class="bg-slate-50 p-5 rounded-2xl border-l-4 border-red-600">
                            <p class="text-[10px] font-black text-red-700 uppercase mb-2 tracking-widest italic leading-none">ANALISIS & KEPUTUSAN:</p>
                            <p class="text-[10px] text-slate-600 font-bold normal-case leading-relaxed italic">Keadaan darurat! Informasi ini bersifat vital untuk keselamatan jiwa. Wajib pilih klasifikasi **SERTA MERTA**. Upload segera tanpa menunggu persetujuan birokrasi yang panjang demi keamanan publik.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FINAL FORMULA -->
            <div class="bg-slate-900 p-8 rounded-[3rem] text-white flex flex-col md:flex-row items-center justify-between gap-10 shadow-2xl">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-gradient-to-tr from-indigo-600 to-blue-500 rounded-3xl flex items-center justify-center text-white shadow-xl flex-shrink-0 rotate-3">
                        <i class="fas fa-brain text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[14px] font-black uppercase tracking-widest leading-none italic mb-1">Rumus Cepat Penentuan:</p>
                        <p class="text-[11px] text-slate-400 font-bold uppercase italic leading-tight">Gunakan logika ini setiap kali Bapak/Ibu memegang dokumen baru:</p>
                    </div>
                </div>
                <div class="flex flex-wrap justify-center gap-4">
                    <div class="bg-white/10 px-5 py-3 rounded-2xl border border-white/10 text-center group hover:bg-white/20 transition-all">
                        <p class="text-[12px] font-black text-blue-400 italic leading-none">RUTIN/TERJADWAL</p>
                        <p class="text-[9px] font-bold text-white mt-1 uppercase tracking-widest">→ BERKALA</p>
                    </div>
                    <div class="bg-white/10 px-5 py-3 rounded-2xl border border-white/10 text-center group hover:bg-white/20 transition-all">
                        <p class="text-[12px] font-black text-emerald-400 italic leading-none">RIWAYAT/HUKUM/AKTIF</p>
                        <p class="text-[9px] font-bold text-white mt-1 uppercase tracking-widest">→ SETIAP SAAT</p>
                    </div>
                    <div class="bg-white/10 px-5 py-3 rounded-2xl border border-white/10 text-center group hover:bg-white/20 transition-all">
                        <p class="text-[12px] font-black text-red-400 italic leading-none">DARURAT/BAHAYA</p>
                        <p class="text-[9px] font-bold text-white mt-1 uppercase tracking-widest">→ SERTA MERTA</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TUTORIAL FORM A - H (VERTICAL TIMELINE) -->
    <div class="space-y-10">
        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <h5 class="text-xs font-black flex items-center gap-3 text-slate-700 uppercase tracking-widest italic">
                <span class="bg-slate-100 p-1.5 rounded-lg"><i class="fas fa-list-ol text-indigo-600"></i></span> 
                Panduan Teknis Pengisian Formulir Informasi
            </h5>
        </div>

        <div class="relative pl-8 space-y-8">
            <!-- Vertical Line Connector -->
            <div class="absolute left-[33px] top-8 bottom-8 w-1.5 bg-indigo-100 rounded-full opacity-50 shadow-inner"></div>

            <!-- A: JUDUL -->
            <div class="group relative flex flex-col md:flex-row gap-8 items-center bg-white p-8 rounded-[2.5rem] border-2 border-slate-50 shadow-sm transition-all hover:border-indigo-100 hover:shadow-xl">
                <div class="flex-1 flex gap-6 relative z-10">
                    <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center font-black shadow-lg shadow-indigo-200 flex-shrink-0 text-base">A</div>
                    <div class="space-y-2">
                        <h6 class="text-sm font-black uppercase text-slate-800 italic">Judul Informasi</h6>
                        <p class="text-[11px] text-slate-500 font-bold normal-case italic leading-relaxed">
                            Gunakan format standar yang seragam untuk memudahkan pencarian warga. <br>
                            <span class="text-indigo-600 font-black uppercase text-[10px]">Format: [Nama Dokumen] [Nama Unit Kerja] [Tahun Anggaran]</span> <br>
                            <span class="text-slate-400 italic mt-1 block">Contoh: "RKA Dinas Lingkungan Hidup Kabupaten Sinjai 2024"</span>
                        </p>
                    </div>
                </div>
                <div class="w-full md:w-80 bg-slate-50 p-4 rounded-2xl border-2 border-indigo-50 text-[10px] text-indigo-400 italic font-black uppercase tracking-tight overflow-hidden whitespace-nowrap shadow-inner">
                    RKA Dinas Lingkungan Hidup 2024...
                </div>
            </div>

            <!-- B: DESKRIPSI -->
            <div class="group relative flex flex-col md:flex-row gap-8 items-start bg-white p-8 rounded-[2.5rem] border-2 border-slate-50 shadow-sm transition-all hover:border-amber-100 hover:shadow-xl">
                <div class="flex-1 flex gap-6 relative z-10">
                    <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center font-black shadow-lg flex-shrink-0 text-base">B</div>
                    <div class="space-y-4">
                        <h6 class="text-sm font-black uppercase text-slate-800 italic">Deskripsi, File, & Link Drive</h6>
                        <div class="bg-amber-50 p-6 rounded-3xl border-2 border-amber-100 text-amber-900 leading-relaxed text-[11px] font-bold normal-case">
                            <div class="flex items-center gap-3 mb-3 border-b border-amber-200 pb-2">
                                <i class="fas fa-exclamation-circle text-amber-500 text-lg"></i>
                                <span class="uppercase tracking-[0.2em] text-[10px] font-black">Instruksi Penting Pengunggahan:</span>
                            </div>
                            <ul class="space-y-3 list-disc list-inside">
                                <li>Jika satu paket informasi memiliki banyak lampiran, **WAJIB gabungkan menjadi satu file PDF** (Merge PDF) sebelum di-upload agar rapi.</li>
                                <li>Jika ukuran file melebihi batas (misal > 20MB), Bapak/Ibu **DILARANG** memaksakan upload langsung. Gunakan kolom **Link Google Drive** resmi milik unit Bapak/Ibu dan pastikan akses link diset ke "Anyone with the link can view".</li>
                                <li>Isi deskripsi dengan ringkasan isi dokumen untuk mempermudah AI dalam mengindeks data Bapak/Ibu.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- C-F: GRID -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 relative z-10">
                <div class="bg-white p-6 rounded-[2rem] border-2 border-slate-50 flex flex-col items-center gap-4 text-center shadow-sm hover:border-indigo-100 transition-all">
                    <span class="w-10 h-10 bg-indigo-500 text-white rounded-2xl flex items-center justify-center text-xs font-black shadow-lg shadow-indigo-100">C</span>
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-tighter italic">Pilih Kategori (Berkala, Setiap Saat, dll)</span>
                </div>
                <div class="bg-white p-6 rounded-[2rem] border-2 border-slate-50 flex flex-col items-center gap-4 text-center shadow-sm hover:border-indigo-100 transition-all">
                    <span class="w-10 h-10 bg-indigo-500 text-white rounded-2xl flex items-center justify-center text-xs font-black shadow-lg shadow-indigo-100">D</span>
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-tighter italic">Pilih Jenis (Keuangan, Program, dll)</span>
                </div>
                <div class="bg-white p-6 rounded-[2rem] border-2 border-slate-50 flex flex-col items-center gap-4 text-center shadow-sm hover:border-indigo-100 transition-all">
                    <span class="w-10 h-10 bg-indigo-500 text-white rounded-2xl flex items-center justify-center text-xs font-black shadow-lg shadow-indigo-100">E</span>
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-tighter italic">Input Tagging (Kata Kunci Pencarian)</span>
                </div>
                <div class="bg-white p-6 rounded-[2rem] border-2 border-slate-50 flex flex-col items-center gap-4 text-center shadow-sm hover:border-indigo-100 transition-all">
                    <span class="w-10 h-10 bg-indigo-500 text-white rounded-2xl flex items-center justify-center text-xs font-black shadow-lg shadow-indigo-100">F</span>
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-tighter italic">Upload Cover (Wajib JPG/PNG Rapi)</span>
                </div>
            </div>

            <!-- H: FINAL -->
            <div class="relative flex flex-col md:flex-row gap-8 items-center bg-indigo-950 p-10 rounded-[3rem] shadow-2xl border-4 border-white/10 overflow-hidden group">
                <div class="flex-1 flex gap-8 relative z-10">
                    <div class="w-16 h-16 bg-white text-indigo-950 rounded-[1.5rem] flex items-center justify-center font-black shadow-2xl flex-shrink-0 text-2xl">H</div>
                    <div class="space-y-3">
                        <h6 class="text-base font-black uppercase text-indigo-300 italic tracking-[0.2em] leading-none">Langkah Terakhir: Simpan & Validasi</h6>
                        <p class="text-[12px] text-white font-bold normal-case leading-relaxed">
                            "Setelah menekan tombol simpan, Bapak/Ibu **BELUM SELESAI**. Khusus klasifikasi **BERKALA**, Bapak/Ibu wajib kembali ke daftar informasi dan menekan tombol kuning bertuliskan <span class="text-yellow-400 underline uppercase tracking-widest font-black italic">CHECK INFORMASI</span>. Hal ini untuk memastikan sistem secara otomatis mengarsipkan dokumen tahun sebelumnya dan menampilkan dokumen terbaru Bapak/Ibu sebagai informasi utama."
                        </p>
                    </div>
                </div>
                <div class="flex-shrink-0 relative z-10">
                    <div class="bg-yellow-500 text-indigo-950 px-8 py-4 rounded-2xl text-[12px] font-black shadow-2xl border-2 border-white/30 uppercase italic tracking-wider flex items-center gap-3 hover:scale-105 transition-transform cursor-default">
                        <i class="fas fa-check-double text-base"></i> CHECK INFORMASI
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- REKAPITULASI DOKUMEN (MASTER LIST) -->
    <div class="bg-white border-2 border-slate-100 rounded-[3rem] p-10 shadow-sm font-bold text-slate-400 uppercase tracking-tighter">
        <h5 class="text-xs text-slate-800 mb-8 text-center uppercase tracking-[0.3em] border-b border-slate-100 pb-4 italic font-black">Daftar Dokumen Wajib Berdasarkan Jenis Unit</h5>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-[10px] font-bold leading-loose">
            <div class="space-y-4">
                <p class="text-blue-600 border-b-2 border-blue-100 pb-2 flex items-center gap-3 uppercase font-black italic text-xs"><i class="fas fa-building"></i> Dinas / Badan / RSUD</p>
                <ul class="space-y-1 list-none pl-1 text-slate-500 font-bold uppercase italic tracking-tighter">
                    <li class="flex gap-2"><i class="fas fa-caret-right text-blue-300 mt-1"></i> Renstra & Renja (Berkala)</li>
                    <li class="flex gap-2"><i class="fas fa-caret-right text-blue-300 mt-1"></i> DPA & RKA (Berkala)</li>
                    <li class="flex gap-2"><i class="fas fa-caret-right text-blue-300 mt-1"></i> LRA & Neraca (Berkala)</li>
                    <li class="flex gap-2"><i class="fas fa-caret-right text-blue-300 mt-1"></i> Tarif & SPM (Setiap Saat)</li>
                </ul>
            </div>
            <div class="space-y-4">
                <p class="text-indigo-600 border-b-2 border-indigo-100 pb-2 flex items-center gap-3 uppercase font-black italic text-xs"><i class="fas fa-search-dollar"></i> Inspektorat</p>
                <ul class="space-y-1 list-none pl-1 text-slate-500 font-bold uppercase italic tracking-tighter">
                    <li class="flex gap-2"><i class="fas fa-caret-right text-indigo-300 mt-1"></i> PKPT / Program Audit (Berkala)</li>
                    <li class="flex gap-2"><i class="fas fa-caret-right text-indigo-300 mt-1"></i> Ringkasan LHP (Berkala)</li>
                    <li class="flex gap-2"><i class="fas fa-caret-right text-indigo-300 mt-1"></i> Laporan Akuntabilitas (Berkala)</li>
                </ul>
            </div>
            <div class="space-y-4">
                <p class="text-emerald-600 border-b-2 border-emerald-100 pb-2 flex items-center gap-3 uppercase font-black italic text-xs"><i class="fas fa-map-marked-alt"></i> Desa / Kel / Kec</p>
                <ul class="space-y-1 list-none pl-1 text-slate-500 font-bold uppercase italic tracking-tighter">
                    <li class="flex gap-2"><i class="fas fa-caret-right text-emerald-300 mt-1"></i> APBDes / RKPDes (Berkala)</li>
                    <li class="flex gap-2"><i class="fas fa-caret-right text-emerald-300 mt-1"></i> LPPD & Monografi (Berkala)</li>
                    <li class="flex gap-2"><i class="fas fa-caret-right text-emerald-300 mt-1"></i> Laporan PATEN (Berkala)</li>
                </ul>
            </div>
        </div>
    </div>
</div>