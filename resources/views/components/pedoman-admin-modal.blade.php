<div x-show="$store.pedomanAdminModal.open" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 z-[110] bg-slate-900/95 backdrop-blur-sm flex items-center justify-center p-2 md:p-6" 
     style="display: none;">
    
    <div class="bg-white w-full max-w-7xl max-h-[95vh] rounded-3xl shadow-2xl flex flex-col overflow-hidden border border-slate-200 font-sans">
        
        <!-- Header -->
        <div class="bg-indigo-900 px-6 py-6 flex-shrink-0 border-b border-indigo-950">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-5">
                    <div class="bg-indigo-500 p-3 rounded-2xl text-white shadow-lg shadow-indigo-500/30">
                        <i class="fas fa-chalkboard-teacher text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl md:text-3xl font-black text-white leading-tight uppercase tracking-tight">Pedoman Operasional Admin</h3>
                        <p class="text-indigo-200 text-sm mt-1 font-medium">Panduan Langkah-demi-Langkah Pengelolaan Portal PPID v2</p>
                    </div>
                </div>
                <button @click="$store.pedomanAdminModal.close()" 
                        class="bg-white/10 hover:bg-white/20 text-white transition-all p-3 rounded-xl">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="bg-slate-50 border-b border-slate-200 flex overflow-x-auto no-scrollbar scroll-smooth px-6">
            <template x-for="(tab, index) in $store.pedomanAdminModal.tabs" :key="index">
                <button @click="$store.pedomanAdminModal.activeTab = index"
                        :class="$store.pedomanAdminModal.activeTab === index ? 'border-indigo-600 text-indigo-700 bg-white shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700'"
                        class="px-6 py-4 border-b-4 font-bold text-sm whitespace-nowrap transition-all flex items-center gap-2">
                    <i :class="tab.icon"></i>
                    <span x-text="tab.title"></span>
                </button>
            </template>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-6 md:p-10 bg-white">
            
            <!-- Tab 0: Menu Profil -->
            <div x-show="$store.pedomanAdminModal.activeTab === 0" x-transition class="space-y-8">
                <div class="flex items-center gap-4 border-l-4 border-indigo-600 pl-4 mb-6">
                    <h4 class="text-2xl font-bold text-slate-800">Pengelolaan Profil OPD & Pimpinan</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-6">
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200">
                            <h5 class="font-bold text-indigo-700 mb-4 flex items-center gap-2">
                                <span class="bg-indigo-100 w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span>
                                Mengelola Struktur & Website OPD
                            </h5>
                            <ul class="space-y-4 text-sm text-slate-600">
                                <li class="flex gap-3">
                                    <i class="fas fa-mouse-pointer text-indigo-500 mt-1"></i>
                                    <span>Klik menu <strong>Profil</strong> > <strong>Tentang OPD</strong></span>
                                </li>
                                <li class="flex gap-3">
                                    <i class="fas fa-search text-indigo-500 mt-1"></i>
                                    <span>Cari OPD Anda di daftar, lalu klik tombol <span class="bg-blue-600 text-white px-2 py-0.5 rounded text-[10px] uppercase font-bold">Kelola Profil</span></span>
                                </li>
                                <li class="flex gap-3">
                                    <i class="fas fa-upload text-indigo-500 mt-1"></i>
                                    <span>Unggah Gambar Struktur & masukkan URL Website OPD, lalu klik <strong>Simpan Perubahan</strong>.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200">
                            <h5 class="font-bold text-indigo-700 mb-4 flex items-center gap-2">
                                <span class="bg-indigo-100 w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span>
                                Mengelola Data Pimpinan
                            </h5>
                            <ul class="space-y-4 text-sm text-slate-600">
                                <li class="flex gap-3">
                                    <i class="fas fa-mouse-pointer text-indigo-500 mt-1"></i>
                                    <span>Klik menu <strong>Profil</strong> > <strong>Pejabat Daerah</strong> (untuk OPD) atau <strong>Unit Lokal</strong> (untuk Desa/Kel)</span>
                                </li>
                                <li class="flex gap-3">
                                    <i class="fas fa-edit text-indigo-500 mt-1"></i>
                                    <span>Klik icon <i class="fas fa-edit text-yellow-600"></i> pada nama pimpinan yang ingin diperbarui.</span>
                                </li>
                                <li class="flex gap-3">
                                    <i class="fas fa-save text-indigo-500 mt-1"></i>
                                    <span>Lengkapi formulir, lalu klik tombol <span class="bg-blue-600 text-white px-3 py-1 rounded shadow-sm text-xs font-bold inline-flex items-center gap-1"><i class="fas fa-save"></i> SIMPAN PROFIL</span> di bawah.</span>
                                </li>
                            </ul>

                            <!-- Detail Instruksi Formulir -->
                            <div class="mt-6 p-5 bg-white border-2 border-indigo-50 rounded-2xl shadow-inner">
                                <h6 class="text-xs font-black text-indigo-900 uppercase mb-4 tracking-widest border-b pb-2 flex items-center gap-2">
                                    <i class="fas fa-list-check"></i> Panduan Isi Formulir (Visual):
                                </h6>
                                <div class="space-y-8">
                                    <!-- A: FOTO -->
                                    <div class="flex flex-col md:flex-row gap-6">
                                        <div class="flex gap-3 flex-1">
                                            <div class="bg-indigo-600 text-white w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold mt-0.5">A</div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800">Foto Resmi & Ukuran</p>
                                                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">Gunakan foto berseragam dinas dengan latar belakang polos. Max <strong>2MB</strong> (Format JPG/PNG).</p>
                                            </div>
                                        </div>
                                        <div class="md:w-48 bg-slate-100 p-2 rounded-xl border border-slate-200 relative">
                                            <div class="h-16 w-full border-2 border-dashed border-slate-300 rounded-lg flex items-center justify-center bg-white">
                                                <i class="fas fa-camera text-slate-300"></i>
                                            </div>
                                            <div class="absolute -left-4 top-1/2 -translate-y-1/2">
                                                <div class="w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- B: BIODATA -->
                                    <div class="flex flex-col md:flex-row gap-6">
                                        <div class="flex gap-3 flex-1">
                                            <div class="bg-indigo-600 text-white w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold mt-0.5">B</div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800">Biodata & NIP</p>
                                                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">Isi <strong>Nama Lengkap Beserta Gelar</strong> yang benar. Isi <strong>NIP</strong> tanpa menggunakan spasi.</p>
                                            </div>
                                        </div>
                                        <div class="md:w-48 space-y-2 bg-slate-100 p-3 rounded-xl border border-slate-200 relative">
                                            <div class="h-2 w-24 bg-indigo-200 rounded"></div>
                                            <div class="h-6 w-full bg-white border border-slate-300 rounded shadow-sm flex items-center px-2">
                                                <span class="text-[8px] text-slate-400 font-bold">CONTOH: Dr. Nama Lengkap, M.Si</span>
                                            </div>
                                            <div class="absolute -left-4 top-1/2 -translate-y-1/2">
                                                <div class="w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- C: RIWAYAT -->
                                    <div class="flex flex-col md:flex-row gap-6">
                                        <div class="flex gap-3 flex-1">
                                            <div class="bg-indigo-600 text-white w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold mt-0.5">C</div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800">Riwayat Karir & Pendidikan</p>
                                                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">Gunakan tombol <span class="text-green-600 font-bold">+ Tambah</span>. Masukkan tahun 4 digit (contoh: 2024).</p>
                                            </div>
                                        </div>
                                        <div class="md:w-48 bg-slate-100 p-3 rounded-xl border border-slate-200 relative flex justify-center">
                                            <div class="bg-green-600 text-white px-3 py-1.5 rounded-lg text-[9px] font-bold shadow-sm">+ TAMBAH DATA</div>
                                            <div class="absolute -left-4 top-1/2 -translate-y-1/2">
                                                <div class="w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- D: STATUS -->
                                    <div class="flex flex-col md:flex-row gap-6">
                                        <div class="flex gap-3 flex-1">
                                            <div class="bg-indigo-600 text-white w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold mt-0.5">D</div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800">Status Jabatan</p>
                                                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">Pilih <strong>Aktif</strong> agar profil muncul di website publik.</p>
                                            </div>
                                        </div>
                                        <div class="md:w-48 bg-slate-100 p-3 rounded-xl border border-slate-200 relative flex flex-col gap-2">
                                            <div class="h-6 w-full bg-white border border-slate-300 rounded shadow-sm flex items-center px-2 justify-between">
                                                <span class="text-[9px] font-bold text-slate-800">Aktif</span>
                                                <i class="fas fa-chevron-down text-[8px] text-slate-400"></i>
                                            </div>
                                            <div class="absolute -left-4 top-1/2 -translate-y-1/2">
                                                <div class="w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- E: SIMPAN -->
                                    <div class="flex flex-col md:flex-row gap-6">
                                        <div class="flex gap-3 flex-1">
                                            <div class="bg-blue-600 text-white w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold mt-0.5">E</div>
                                            <div>
                                                <p class="text-xs font-bold text-blue-800">Simpan Perubahan</p>
                                                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">Setelah semua selesai, pastikan klik tombol simpan di paling bawah.</p>
                                            </div>
                                        </div>
                                        <div class="md:w-48 bg-slate-100 p-3 rounded-xl border border-slate-200 relative flex justify-center">
                                            <div class="bg-blue-600 text-white px-4 py-2 rounded-lg text-[9px] font-black shadow-md shadow-blue-200 animate-bounce">SIMPAN PROFIL</div>
                                            <div class="absolute -left-4 top-1/2 -translate-y-1/2">
                                                <div class="w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-blue-500"></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 1: Jenis Informasi -->
            <div x-show="$store.pedomanAdminModal.activeTab === 1" x-transition class="space-y-8">
                <div class="flex items-center gap-4 border-l-4 border-blue-600 pl-4 mb-6">
                    <h4 class="text-2xl font-bold text-slate-800">Manajemen Dokumen & Jenis Informasi</h4>
                </div>
                
                <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100 mb-8">
                    <p class="text-sm text-blue-800 font-medium leading-relaxed">
                        <i class="fas fa-info-circle mr-2"></i> Dokumen yang diupload akan otomatis terbagi menjadi 4 Kategori Utama: 
                        <strong>Berkala, Setiap Saat, Serta Merta,</strong> dan <strong>Dikecualikan</strong>.
                    </p>
                </div>

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-2xl border-2 border-slate-100 hover:border-indigo-200 transition-all shadow-sm">
                            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-4">
                                <i class="fas fa-plus text-xl"></i>
                            </div>
                            <h6 class="font-bold text-slate-800 mb-2">Langkah 1: Tambah</h6>
                            <p class="text-xs text-slate-500 leading-relaxed">Klik tombol <span class="text-blue-600 font-bold">+ Tambah Informasi</span> di halaman kategori yang dituju.</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl border-2 border-slate-100 hover:border-indigo-200 transition-all shadow-sm">
                            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-4">
                                <i class="fas fa-file-signature text-xl"></i>
                            </div>
                            <h6 class="font-bold text-slate-800 mb-2">Langkah 2: Klasifikasi</h6>
                            <p class="text-xs text-slate-500 leading-relaxed">Pilih <strong>Jenis Dokumen</strong> (misal: RKA, Renstra) agar sistem mengelompokkan data secara otomatis.</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl border-2 border-slate-100 hover:border-indigo-200 transition-all shadow-sm">
                            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-4">
                                <i class="fas fa-upload text-xl"></i>
                            </div>
                            <h6 class="font-bold text-slate-800 mb-2">Langkah 3: Publish</h6>
                            <p class="text-xs text-slate-500 leading-relaxed">Upload file (Max 2MB) atau masukkan URL jika file besar. Set status <strong>BERLAKU</strong> lalu Simpan.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Transparansi & Permohonan -->
            <div x-show="$store.pedomanAdminModal.activeTab === 2" x-transition class="space-y-8">
                <div class="flex items-center gap-4 border-l-4 border-green-600 pl-4 mb-6">
                    <h4 class="text-2xl font-bold text-slate-800">Alur Layanan Permohonan Informasi</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="bg-slate-900 rounded-3xl p-8 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-8 opacity-10">
                            <i class="fas fa-file-import text-9xl"></i>
                        </div>
                        <h5 class="text-xl font-bold mb-6 flex items-center gap-3">
                            <i class="fas fa-user-edit text-green-400"></i>
                            Mengarahkan Pemohon
                        </h5>
                        <div class="space-y-6">
                            <div class="flex gap-4">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-sm">1</div>
                                <div>
                                    <p class="font-bold text-green-400 text-sm uppercase">Login Pemohon</p>
                                    <p class="text-xs text-slate-300 mt-1">Minta warga login ke portal PPID (bisa pakai Google).</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-sm">2</div>
                                <div>
                                    <p class="font-bold text-green-400 text-sm uppercase">Isi Formulir</p>
                                    <p class="text-xs text-slate-300 mt-1">Arahkan ke menu <strong>Transparansi</strong> > <strong>Permohonan Informasi</strong>.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-sm">3</div>
                                <div>
                                    <p class="font-bold text-green-400 text-sm uppercase">Kirim Formulir</p>
                                    <p class="text-xs text-slate-300 mt-1">Klik tombol <span class="border border-green-500 px-2 py-0.5 rounded text-[10px]">BUAT PERMOHONAN</span>.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border-2 border-slate-100 rounded-3xl p-8">
                        <h5 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                            <i class="fas fa-reply text-blue-600"></i>
                            Tugas Admin (Merespon)
                        </h5>
                        <div class="space-y-6">
                            <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100">
                                <p class="text-sm font-bold text-blue-800 mb-2 underline italic">Langkah Pengiriman Dokumen:</p>
                                <ol class="text-xs text-slate-600 space-y-3 list-decimal list-inside">
                                    <li>Masuk ke Dashboard Admin Permohonan.</li>
                                    <li>Pilih permohonan dengan status <span class="text-orange-600 font-bold uppercase">Pending</span>.</li>
                                    <li>Klik tombol <span class="bg-blue-600 text-white px-2 py-0.5 rounded text-[10px] uppercase font-bold">Proses/Balas</span>.</li>
                                    <li>Tulis pesan balasan, lampirkan link file dokumen yang diminta, atau upload dokumen langsung.</li>
                                    <li>Klik <strong>Kirim Jawaban</strong>. Status akan berubah menjadi <span class="text-green-600 font-bold uppercase">Selesai</span>.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: PBJ (PU & Sekretariat) -->
            <div x-show="$store.pedomanAdminModal.activeTab === 3" x-transition class="space-y-8">
                <div class="flex items-center gap-4 border-l-4 border-orange-600 pl-4 mb-6">
                    <h4 class="text-2xl font-bold text-slate-800">Panduan Khusus PBJ (PU & Sekretariat)</h4>
                </div>

                <div class="bg-orange-50 p-6 rounded-2xl border border-orange-100 mb-8 flex gap-4 items-start">
                    <div class="bg-orange-500 text-white p-3 rounded-xl">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h6 class="font-bold text-orange-800">Perhatian Khusus Bagian PBJ!</h6>
                        <p class="text-xs text-orange-700 leading-relaxed mt-1">Data PBJ wajib diupdate secara berkala sesuai progres tender yang berjalan untuk menjaga transparansi anggaran daerah.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <h5 class="font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-shopping-cart text-orange-500"></i>
                            Langkah Input PBJ
                        </h5>
                        <ul class="text-sm text-slate-600 space-y-4">
                            <li class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm flex gap-3">
                                <span class="text-orange-500 font-bold">01.</span>
                                <span>Klik menu <strong>PBJ</strong> pada Dashboard Admin.</span>
                            </li>
                            <li class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm flex gap-3">
                                <span class="text-orange-500 font-bold">02.</span>
                                <span>Klik <span class="bg-blue-600 text-white px-2 py-0.5 rounded text-[10px] uppercase font-bold">Input Data Paket</span>.</span>
                            </li>
                            <li class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm flex gap-3">
                                <span class="text-orange-500 font-bold">03.</span>
                                <span>Masukkan Nama Paket, Pagu, HPS, dan Nama Pemenang Tender.</span>
                            </li>
                        </ul>
                    </div>
                    <div class="space-y-4">
                        <h5 class="font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-file-pdf text-orange-500"></i>
                            Dokumen Pendukung
                        </h5>
                        <div class="p-5 bg-slate-50 border border-slate-200 rounded-2xl">
                            <p class="text-xs text-slate-500 mb-3 italic">Dokumen yang wajib disertakan untuk setiap paket:</p>
                            <ul class="text-xs space-y-3">
                                <li class="flex items-center gap-2"><i class="fas fa-check-circle text-green-500"></i> <span>Rencana Umum Pengadaan (RUP)</span></li>
                                <li class="flex items-center gap-2"><i class="fas fa-check-circle text-green-500"></i> <span>Kerangka Acuan Kerja (KAK)</span></li>
                                <li class="flex items-center gap-2"><i class="fas fa-check-circle text-green-500"></i> <span>Ringkasan Kontrak Kerja</span></li>
                                <li class="flex items-center gap-2"><i class="fas fa-check-circle text-green-500"></i> <span>Berita Acara Serah Terima (BAST)</span></li>
                            </ul>
                            <div class="mt-4 p-3 bg-white rounded-xl border border-orange-100">
                                <p class="text-[10px] text-orange-600 font-bold leading-tight uppercase">⚠️ Catatan Sekjretariat PBJ:</p>
                                <p class="text-[10px] text-slate-500 mt-1">Pastikan file PDF tidak dikunci password agar bisa dibaca oleh pemohon.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="bg-slate-50 p-6 border-t border-slate-100 flex flex-col md:flex-row gap-6 items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="flex -space-x-2">
                    <img src="https://ui-avatars.com/api/?name=Admin+PPID&background=4f46e5&color=fff" class="w-8 h-8 rounded-full border-2 border-white">
                    <img src="https://ui-avatars.com/api/?name=Super+Admin&background=1e1b4b&color=fff" class="w-8 h-8 rounded-full border-2 border-white">
                </div>
                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none">
                    Dinas Kominfo & Persandian Sinjai
                </div>
            </div>
            
            <div class="flex gap-3 w-full md:w-auto">
                <button @click="$store.pedomanAdminModal.prevTab()" 
                        x-show="$store.pedomanAdminModal.activeTab > 0"
                        class="px-6 py-3 bg-white text-slate-600 font-bold rounded-2xl border border-slate-200 text-sm hover:bg-slate-100 transition-all flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> SEBELUMNYA
                </button>

                <button @click="$store.pedomanAdminModal.nextTab()" 
                        class="flex-1 md:flex-none px-12 py-3 bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-700/20 text-sm transition-all hover:bg-indigo-800 hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2">
                    <span x-text="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'SAYA MENGERTI, TUTUP PANDUAN' : 'LANJUT KE LANGKAH BERIKUTNYA'"></span>
                    <i :class="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'fas fa-check-double' : 'fas fa-arrow-right'"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin'))
    <div class="fixed z-[105] bottom-6 right-6" x-data x-cloak>
        <button @click="$store.pedomanAdminModal.show()" 
                class="w-16 h-16 bg-indigo-700 hover:bg-indigo-800 text-white rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 group relative border-4 border-white">
            <i class="fas fa-book-reader text-2xl"></i>
            <div class="absolute bottom-full right-0 mb-4 px-4 py-2 bg-indigo-900 text-white text-[10px] font-bold rounded-xl opacity-0 group-hover:opacity-100 transition-all transform translate-y-2 group-hover:translate-y-0 whitespace-nowrap pointer-events-none shadow-xl border border-indigo-800 uppercase tracking-widest">
                <i class="fas fa-chalkboard-teacher mr-2"></i> Panduan Operasional Admin
            </div>
        </button>
    </div>
@endif

<script>
    document.addEventListener('alpine:init', () => {
        const store = Alpine.store('pedomanAdminModal');
        if (store) {
            store.tabs = [
                { title: 'MENU PROFIL', icon: 'fas fa-user-shield' },
                { title: 'JENIS INFORMASI', icon: 'fas fa-folder-open' },
                { title: 'TRANSPARANSI', icon: 'fas fa-chart-line' },
                { title: 'PBJ', icon: 'fas fa-shopping-cart' }
            ];
        }
    })
</script>
