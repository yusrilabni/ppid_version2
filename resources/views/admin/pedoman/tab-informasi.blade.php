<div x-show="$store.pedomanAdminModal.activeTab === 1" 
     class="space-y-12">
    
    <!-- Header Tab -->
    <div class="flex items-center gap-4 border-l-8 border-blue-600 pl-4 uppercase tracking-tighter">
        <div class="bg-blue-600 p-3 rounded-2xl text-white shadow-md">
            <i class="fas fa-folder-tree text-2xl"></i>
        </div>
        <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-10">
            <div>
                <h4 class="text-xl font-black text-slate-800 leading-none">Informasi Publik</h4>
                <p class="text-[10px] text-slate-400 font-bold tracking-[0.2em] mt-1 italic">Classification & Lifecycle</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <button @click="document.getElementById('panduan-teknis').scrollIntoView({ behavior: 'smooth' })" 
                        class="bg-white text-blue-600 border-2 border-blue-100 px-4 py-2 rounded-xl text-[9px] font-black hover:bg-blue-50 transition-all shadow-sm flex items-center gap-2 uppercase tracking-widest group">
                    Langkah Pengisian Form <i class="fas fa-arrow-down group-hover:translate-y-1 transition-transform"></i>
                </button>
                <button @click="document.getElementById('daftar-dokumen-wajib').scrollIntoView({ behavior: 'smooth' })" 
                        class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-[9px] font-black hover:bg-indigo-700 transition-all shadow-md flex items-center gap-2 uppercase tracking-widest group">
                    Cek Daftar Dokumen Wajib Upload <i class="fas fa-list-check"></i>
                </button>
            </div>
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

    <!-- TUTORIAL FORM (STEP BY STEP) -->
    <div class="space-y-12 pt-10" id="panduan-teknis">
        <div class="flex items-center gap-4 border-b-2 border-slate-100 pb-6">
            <div class="bg-indigo-600 p-3 rounded-2xl text-white shadow-lg">
                <i class="fas fa-terminal text-xl"></i>
            </div>
            <div>
                <h5 class="text-base font-black text-slate-800 uppercase italic leading-none">Panduan Teknis Pengisian Formulir</h5>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Langkah demi Langkah Menuju Publikasi Data Yang Sempurna</p>
            </div>
        </div>

        <div class="space-y-10 pl-4 border-l-4 border-slate-100">
            <!-- 1. Navigasi -->
            <div class="bg-white p-8 rounded-[2.5rem] border-2 border-slate-50 shadow-sm relative">
                <div class="flex gap-6 items-start">
                    <span class="w-12 h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center font-black flex-shrink-0">01</span>
                    <div class="space-y-4">
                        <h6 class="text-sm font-black uppercase text-indigo-700 italic">Navigasi Menu Utama</h6>
                        <p class="text-[11px] text-slate-500 font-bold leading-relaxed italic">
                            Akses Navbar (Menu Atas) > Pilih salah satu Kategori (Berkala/Setiap Saat/Serta Merta) > Klik Tombol Biru **+ TAMBAH INFORMASI**.
                        </p>
                    </div>
                </div>
            </div>

            <!-- 2. Identitas Dokumen -->
            <div class="bg-white p-8 rounded-[2.5rem] border-2 border-slate-50 shadow-sm relative">
                <div class="flex gap-6 items-start">
                    <span class="w-12 h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center font-black flex-shrink-0">02</span>
                    <div class="space-y-6 flex-1">
                        <h6 class="text-sm font-black uppercase text-indigo-700 italic">Identitas & Deskripsi Dokumen</h6>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <p class="text-[11px] font-black text-slate-700 uppercase italic">A. Judul Informasi <span class="text-red-500">*</span></p>
                                <div class="bg-slate-50 border-2 border-indigo-100 p-4 rounded-2xl text-[10px] text-indigo-600 font-black italic">Format: [Nama Dokumen] [Nama OPD] [Tahun]</div>
                                <p class="text-[9px] text-slate-400 italic leading-tight">Gunakan huruf kapital di setiap awal kata untuk kerapihan.</p>
                            </div>
                            <div class="space-y-3">
                                <p class="text-[11px] font-black text-slate-700 uppercase italic">B. Deskripsi Singkat</p>
                                <div class="bg-slate-50 border-2 border-slate-200 p-4 rounded-2xl text-[10px] text-slate-400 italic h-24">Jelaskan isi pokok dokumen di sini agar memudahkan warga...</div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <p class="text-[11px] font-black text-slate-700 uppercase italic">C. Konten Informasi Lengkap (Opsional)</p>
                            <div class="bg-slate-50 border-2 border-slate-200 p-4 rounded-2xl text-[10px] text-slate-400 italic h-20">Digunakan jika ada narasi panjang yang menyertai dokumen...</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Klasifikasi & Status -->
            <div class="bg-white p-8 rounded-[2.5rem] border-2 border-slate-50 shadow-sm relative">
                <div class="flex gap-6 items-start">
                    <span class="w-12 h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center font-black flex-shrink-0">03</span>
                    <div class="space-y-8 flex-1">
                        <h6 class="text-sm font-black uppercase text-indigo-700 italic">Klasifikasi, Jenis & Status Aktif</h6>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-3">
                                <p class="text-[10px] font-black text-slate-700 uppercase italic">Kategori Informasi <span class="text-red-500">*</span></p>
                                <div class="bg-indigo-50 border border-indigo-200 p-3 rounded-xl text-[9px] font-black text-indigo-700 uppercase text-center italic">Pilih Salah Satu</div>
                                <p class="text-[9px] text-slate-400 italic leading-tight text-center">Berkala / Setiap Saat / Serta Merta</p>
                            </div>
                            <div class="space-y-3">
                                <p class="text-[10px] font-black text-slate-700 uppercase italic">Jenis Dokumen</p>
                                <div class="bg-indigo-50 border border-indigo-200 p-3 rounded-xl text-[9px] font-black text-indigo-700 uppercase text-center italic">Pilih Sesuai Isi</div>
                                <p class="text-[9px] text-slate-400 italic leading-tight text-center">Keuangan / Profil / Regulasi / dsb</p>
                            </div>
                            <div class="space-y-3">
                                <p class="text-[10px] font-black text-slate-700 uppercase italic">Status Dokumen <span class="text-red-500">*</span></p>
                                <div class="flex justify-center gap-3">
                                    <div class="bg-green-600 text-white px-3 py-2 rounded-lg text-[8px] font-black shadow-md italic">BERLAKU</div>
                                    <div class="bg-slate-200 text-slate-400 px-3 py-2 rounded-lg text-[8px] font-black italic">ARSIP</div>
                                </div>
                                <p class="text-[9px] text-slate-400 italic leading-tight text-center">Wajib BERLAKU untuk data baru!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Waktu & Berkas -->
            <div class="bg-white p-8 rounded-[2.5rem] border-2 border-slate-50 shadow-sm relative">
                <div class="flex gap-6 items-start">
                    <span class="w-12 h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center font-black flex-shrink-0">04</span>
                    <div class="space-y-6 flex-1">
                        <h6 class="text-sm font-black uppercase text-indigo-700 italic">Tahun & File Sumber</h6>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <p class="text-[11px] font-black text-slate-700 uppercase italic">Tahun Dokumen <span class="text-red-500">*</span></p>
                                <div class="bg-slate-50 border-2 border-indigo-100 p-4 rounded-2xl text-[10px] text-slate-800 font-black italic">
                                    29 / 04 / 2024 <i class="fas fa-calendar-day ml-auto text-indigo-400"></i>
                                </div>
                                <p class="text-[9px] text-slate-400 italic leading-tight">Masukkan tanggal dokumen ditandatangani.</p>
                            </div>
                            <div class="space-y-3">
                                <p class="text-[11px] font-black text-slate-700 uppercase italic">Input Berkas (Pilih Salah Satu)</p>
                                <div class="bg-slate-900 p-5 rounded-2xl space-y-4 shadow-inner">
                                    <div class="flex gap-2 text-[8px] font-black text-white italic uppercase mb-2">
                                        <span class="bg-blue-600 px-2 py-1 rounded">UPLOAD FILE (MAX 2MB)</span>
                                        <span class="opacity-40 border border-white/20 px-2 py-1 rounded">LINK DRIVE (> 2MB)</span>
                                    </div>
                                    <div class="bg-white/10 p-3 rounded-xl border border-white/10 text-slate-300 text-[10px] leading-relaxed italic">
                                        <i class="fas fa-exclamation-triangle text-amber-400 mr-1"></i> Jika banyak file, **WAJIB MERGE PDF** jadi 1 file. <br>
                                        <i class="fas fa-cloud-upload-alt text-blue-400 mr-1 mt-2"></i> Jika file di atas 2MB, simpan ke Google Drive unit Bapak/Ibu, lalu pilih opsi **Link Drive** dan copas linknya.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Validasi Final -->
            <div class="bg-indigo-950 p-10 rounded-[3rem] shadow-2xl border-4 border-white/10 relative overflow-hidden group">
                <div class="flex gap-8 items-center">
                    <span class="w-16 h-16 bg-white text-indigo-950 rounded-2xl flex items-center justify-center font-black text-2xl flex-shrink-0">05</span>
                    <div class="space-y-4">
                        <h6 class="text-base font-black uppercase text-indigo-300 italic tracking-widest leading-none">Simpan & Check Similarity</h6>
                        <p class="text-[12px] text-white font-bold leading-relaxed italic">
                            Klik tombol kuning **CHECK INFORMASI**. Sistem akan menganalisis judul dokumen. Jika terdeteksi dokumen sejenis dari tahun lalu, klik **GANTI** agar data lama masuk arsip secara otomatis.
                        </p>
                        <div class="bg-yellow-500 text-indigo-950 px-8 py-3 rounded-xl text-[11px] font-black uppercase inline-flex items-center gap-2 italic">
                            <i class="fas fa-search"></i> CHECK INFORMASI
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BANTUAN AI: BINGUNG KLASIFIKASI -->
    <div class="bg-gradient-to-br from-slate-900 to-indigo-950 text-white p-10 rounded-[3.5rem] shadow-2xl relative overflow-hidden border-4 border-indigo-900/50">
        <div class="absolute -top-10 -right-10 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl"></div>
        <div class="relative z-10 space-y-8">
            <div class="flex flex-col md:flex-row gap-8 items-center border-b border-white/10 pb-8">
                <div class="bg-gradient-to-tr from-indigo-600 to-blue-500 p-5 rounded-[2rem] text-white shadow-xl rotate-3">
                    <i class="fas fa-magic text-3xl"></i>
                </div>
                <div class="text-center md:text-left">
                    <h5 class="text-lg font-black uppercase tracking-[0.3em] italic leading-none">Masih Bingung Klasifikasinya?</h5>
                    <p class="text-[11px] text-indigo-300 font-bold uppercase mt-2">Gunakan Asisten Kecerdasan Buatan (AI) Portal PPID</p>
                </div>
            </div>

            <div class="space-y-6">
                <p class="text-[12px] leading-relaxed text-slate-300 font-bold normal-case italic">Saat Bapak/Ibu sedang mengisi Form Tambah Informasi, Bapak/Ibu bisa langsung bertanya ke AI dengan alur berikut:</p>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                    <div class="bg-white/5 p-6 rounded-[2rem] border border-white/10 space-y-2 relative">
                        <span class="text-indigo-400 font-black text-[9px] uppercase tracking-widest">Tahap 1</span>
                        <p class="text-[10px] font-bold leading-relaxed italic">Klik tombol <strong class="text-indigo-400">"Tanya Pedoman"</strong> di bagian header biru pada form Tambah Informasi.</p>
                        <i class="fas fa-arrow-right absolute -right-3 top-1/2 -translate-y-1/2 text-slate-600 hidden md:block"></i>
                    </div>
                    <div class="bg-white/5 p-6 rounded-[2rem] border border-white/10 space-y-2 relative">
                        <span class="text-blue-400 font-black text-[9px] uppercase tracking-widest">Tahap 2</span>
                        <p class="text-[10px] font-bold leading-relaxed italic">Akan muncul Pop-Up Pedoman ini. Di bagian bawahnya, klik tombol <strong class="text-blue-400">"Tanya AI"</strong>.</p>
                        <i class="fas fa-arrow-right absolute -right-3 top-1/2 -translate-y-1/2 text-slate-600 hidden md:block"></i>
                    </div>
                    <div class="bg-white/5 p-6 rounded-[2rem] border border-white/10 space-y-2 relative">
                        <span class="text-emerald-400 font-black text-[9px] uppercase tracking-widest">Tahap 3</span>
                        <p class="text-[10px] font-bold leading-relaxed italic">Modal AI Analis akan terbuka. Ketikkan **Judul Dokumen** dan **Tahun** secara lengkap.</p>
                        <i class="fas fa-arrow-right absolute -right-3 top-1/2 -translate-y-1/2 text-slate-600 hidden md:block"></i>
                    </div>
                    <div class="bg-white/5 p-6 rounded-[2rem] border border-white/10 space-y-2">
                        <span class="text-amber-400 font-black text-[9px] uppercase tracking-widest">Tahap 4</span>
                        <p class="text-[10px] font-bold leading-relaxed italic">Tekan Tombol Biru <strong class="text-amber-400">"ANALISA DOKUMEN"</strong>. AI akan langsung memberikan klasifikasi yang tepat!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DAFTAR DOKUMEN WAJIB PER UNIT (NEW SECTION) -->
    <div class="space-y-10 pt-10" id="daftar-dokumen-wajib">
        <div class="flex items-center gap-4 border-b-2 border-slate-100 pb-6">
            <div class="bg-emerald-600 p-3 rounded-2xl text-white shadow-lg">
                <i class="fas fa-file-invoice text-xl"></i>
            </div>
            <div>
                <h5 class="text-base font-black text-slate-800 uppercase italic leading-none">Daftar Dokumen Wajib Unggah</h5>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Standar Layanan Informasi Publik per Unit Kerja (UU KIP)</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-12">
            <!-- 1. Dinas / Badan / RSUD -->
            <div class="bg-white p-8 rounded-[3rem] border-2 border-slate-50 shadow-sm space-y-8">
                <h6 class="text-sm font-black text-blue-700 uppercase italic border-l-4 border-blue-600 pl-4">Kelompok A: Dinas / Badan / RSUD</h6>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-[11px] font-bold uppercase italic tracking-tighter">
                    <!-- Berkala -->
                    <div class="bg-blue-50/50 p-6 rounded-[2rem] border border-blue-100 space-y-4">
                        <p class="text-blue-700 border-b border-blue-200 pb-2 flex items-center gap-2 font-black"><i class="fas fa-sync-alt"></i> INFORMASI BERKALA</p>
                        <ul class="space-y-3 list-none pl-1 text-slate-600">
                            <li class="flex gap-2 border-b border-blue-50 pb-2"><i class="fas fa-check text-blue-400 mt-0.5"></i> <span>Renstra & Renja <span class="text-blue-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Dokumen Strategis</span></li>
                            <li class="flex gap-2 border-b border-blue-50 pb-2"><i class="fas fa-check text-blue-400 mt-0.5"></i> <span>LRA & Neraca <span class="text-blue-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Informasi Keuangan</span></li>
                            <li class="flex gap-2 border-b border-blue-50 pb-2"><i class="fas fa-check text-blue-400 mt-0.5"></i> <span>DPA & RKA <span class="text-blue-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Program & Kegiatan</span></li>
                            <li class="flex gap-2 border-b border-blue-50 pb-2"><i class="fas fa-check text-blue-400 mt-0.5"></i> <span>LAKIP / LKjIP <span class="text-blue-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Laporan Kinerja Instansi</span></li>
                            <li class="flex gap-2 border-b border-blue-50 pb-2"><i class="fas fa-check text-blue-400 mt-0.5"></i> <span>Profil Pimpinan & Struktur <span class="text-blue-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Profil Badan Publik</span></li>
                        </ul>
                    </div>
                    <!-- Setiap Saat -->
                    <div class="bg-emerald-50/50 p-6 rounded-[2rem] border border-emerald-100 space-y-4">
                        <p class="text-emerald-700 border-b border-emerald-200 pb-2 flex items-center gap-2 font-black"><i class="fas fa-archive"></i> INFORMASI SETIAP SAAT</p>
                        <ul class="space-y-3 list-none pl-1 text-slate-600">
                            <li class="flex gap-2 border-b border-emerald-50 pb-2"><i class="fas fa-check text-emerald-400 mt-0.5"></i> <span>SK Pejabat & Pegawai <span class="text-emerald-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Regulasi & Peraturan</span></li>
                            <li class="flex gap-2 border-b border-emerald-50 pb-2">
                                <i class="fas fa-check text-emerald-400 mt-0.5"></i> 
                                <div class="flex flex-col gap-1">
                                    <span>SK Tim PPID Unit Kerja <span class="text-emerald-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Regulasi & Peraturan</span>
                                    <span class="text-[8px] text-red-500 normal-case font-black bg-white px-2 py-1 rounded-lg border border-red-100 shadow-sm leading-tight">
                                        PENTING: Jika SK ini diperbaharui setiap tahun, ia tetap masuk kategori **SETIAP SAAT** karena merupakan landasan hukum operasional yang akumulatif (rekam jejak kebijakan).
                                    </span>
                                </div>
                            </li>
                            <li class="flex gap-2 border-b border-emerald-50 pb-2"><i class="fas fa-check text-emerald-400 mt-0.5"></i> <span>MoU / Kerjasama <span class="text-emerald-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Peranjian Kerja Sama / MoU</span></li>
                            <li class="flex gap-2 border-b border-emerald-50 pb-2"><i class="fas fa-check text-emerald-400 mt-0.5"></i> <span>Daftar Aset & Inventaris <span class="text-emerald-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Daftar Aset dan Inventaris</span></li>
                            <li class="flex gap-2 border-b border-emerald-50 pb-2"><i class="fas fa-check text-emerald-400 mt-0.5"></i> <span>SOP & Standar Pelayanan <span class="text-emerald-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Standar Layanan & SOP PPID</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- 2. Inspektorat -->
            <div class="bg-white p-8 rounded-[3rem] border-2 border-slate-50 shadow-sm space-y-8">
                <h6 class="text-sm font-black text-indigo-700 uppercase italic border-l-4 border-indigo-600 pl-4">Kelompok B: Inspektorat</h6>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-[11px] font-bold uppercase italic tracking-tighter">
                    <div class="bg-indigo-50/50 p-6 rounded-[2rem] border border-indigo-100 space-y-4">
                        <p class="text-indigo-700 border-b border-indigo-200 pb-2 flex items-center gap-2 font-black"><i class="fas fa-sync-alt"></i> INFORMASI BERKALA</p>
                        <ul class="space-y-3 list-none pl-1 text-slate-600">
                            <li class="flex gap-2 border-b border-indigo-50 pb-2"><i class="fas fa-check text-indigo-400 mt-0.5"></i> <span>PKPT / Program Audit <span class="text-indigo-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Program & Kegiatan</span></li>
                            <li class="flex gap-2 border-b border-indigo-50 pb-2"><i class="fas fa-check text-indigo-400 mt-0.5"></i> <span>Ringkasan LHP <span class="text-indigo-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Laporan Kinerja Instansi</span></li>
                            <li class="flex gap-2 border-b border-indigo-50 pb-2"><i class="fas fa-check text-indigo-400 mt-0.5"></i> <span>Laporan Harta Kekayaan <span class="text-indigo-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Informasi Organisasi & Kepegawaian</span></li>
                        </ul>
                    </div>
                    <div class="bg-indigo-50/50 p-6 rounded-[2rem] border border-indigo-100 space-y-4 opacity-70">
                        <p class="text-slate-500 border-b border-slate-200 pb-2 flex items-center gap-2 font-black italic">Catatan Khusus</p>
                        <p class="normal-case font-medium text-slate-400 leading-relaxed italic text-[10px]">Data Laporan Hasil Pemeriksaan (LHP) bersifat Dikecualikan jika masih dalam proses hukum atau mengandung rahasia negara sesuai Pasal 17 UU KIP.</p>
                    </div>
                </div>
            </div>

            <!-- 3. Kecamatan / Kelurahan / Desa -->
            <div class="bg-white p-8 rounded-[3rem] border-2 border-slate-50 shadow-sm space-y-8">
                <h6 class="text-sm font-black text-orange-700 uppercase italic border-l-4 border-orange-600 pl-4">Kelompok C: Kecamatan / Kelurahan / Desa</h6>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-[11px] font-bold uppercase italic tracking-tighter">
                    <div class="bg-orange-50/50 p-6 rounded-[2rem] border border-orange-100 space-y-4">
                        <p class="text-orange-700 border-b border-orange-200 pb-2 flex items-center gap-2 font-black"><i class="fas fa-sync-alt"></i> INFORMASI BERKALA</p>
                        <ul class="space-y-3 list-none pl-1 text-slate-600">
                            <li class="flex gap-2 border-b border-orange-50 pb-2"><i class="fas fa-check text-orange-400 mt-0.5"></i> <span>APBDes / RKPDes <span class="text-orange-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Informasi Keuangan</span></li>
                            <li class="flex gap-2 border-b border-orange-50 pb-2"><i class="fas fa-check text-orange-400 mt-0.5"></i> <span>LPPD & Monografi <span class="text-orange-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Laporan Kinerja Instansi</span></li>
                            <li class="flex gap-2 border-b border-orange-50 pb-2"><i class="fas fa-check text-orange-400 mt-0.5"></i> <span>Laporan PATEN <span class="text-orange-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Laporan Kinerja Instansi</span></li>
                            <li class="flex gap-2 border-b border-orange-50 pb-2"><i class="fas fa-check text-orange-400 mt-0.5"></i> <span>Profil Desa & Sejarah <span class="text-orange-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Profil Badan Publik</span></li>
                        </ul>
                    </div>
                    <div class="bg-orange-50/50 p-6 rounded-[2rem] border border-orange-100 space-y-4">
                        <p class="text-orange-700 border-b border-orange-200 pb-2 flex items-center gap-2 font-black"><i class="fas fa-archive"></i> INFORMASI SETIAP SAAT</p>
                        <ul class="space-y-3 list-none pl-1 text-slate-600">
                            <li class="flex gap-2 border-b border-orange-50 pb-2"><i class="fas fa-check text-orange-400 mt-0.5"></i> <span>Peraturan Desa / Perdes <span class="text-orange-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Regulasi & Peraturan</span></li>
                            <li class="flex gap-2 border-b border-orange-50 pb-2"><i class="fas fa-check text-orange-400 mt-0.5"></i> <span>Daftar Penduduk & Statistik <span class="text-orange-400 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Pengumuman & Siaran Pers</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- KEADAAN DARURAT (ALL UNITS) -->
        <div class="bg-red-900 p-10 rounded-[3rem] text-white shadow-2xl border-4 border-white/10 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-10 opacity-10">
                <i class="fas fa-bolt text-[120px]"></i>
            </div>
            <div class="relative z-10 space-y-6">
                <h6 class="text-lg font-black uppercase italic leading-none border-b border-white/20 pb-4">Wajib Bagi Seluruh Unit (Informasi Serta Merta)</h6>
                <p class="text-sm font-bold leading-relaxed italic opacity-80 uppercase tracking-tighter">"Wajib Di-upload Seketika Terjadi Kejadian Darurat Tanpa Menunda!"</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-[11px] font-black uppercase italic">
                    <ul class="space-y-3">
                        <li class="flex gap-3 items-center bg-white/10 p-3 rounded-xl border border-white/10"><i class="fas fa-exclamation-triangle text-yellow-400"></i> Peringatan Bencana Alam <span class="text-white/50 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Informasi Serta Merta</li>
                        <li class="flex gap-3 items-center bg-white/10 p-3 rounded-xl border border-white/10"><i class="fas fa-exclamation-triangle text-yellow-400"></i> Informasi Wabah Penyakit <span class="text-white/50 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Informasi Serta Merta</li>
                    </ul>
                    <ul class="space-y-3">
                        <li class="flex gap-3 items-center bg-white/10 p-3 rounded-xl border border-white/10"><i class="fas fa-exclamation-triangle text-yellow-400"></i> Gangguan Layanan Vital <span class="text-white/50 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Informasi Serta Merta</li>
                        <li class="flex gap-3 items-center bg-white/10 p-3 rounded-xl border border-white/10"><i class="fas fa-exclamation-triangle text-yellow-400"></i> Jalur Evakuasi Darurat <span class="text-white/50 mx-1">→</span> <span class="text-[8px] opacity-70 italic">Jenis Dokumen:</span> Informasi Serta Merta</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>