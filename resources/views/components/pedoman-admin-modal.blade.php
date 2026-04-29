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
                                    <span>Cari OPD Anda, lalu klik tombol <span class="bg-white text-blue-600 border border-blue-200 px-2 py-0.5 rounded shadow-sm text-[10px] font-bold inline-flex items-center gap-1 uppercase tracking-tighter"><i class="fas fa-edit text-[8px]"></i> KELOLA PROFIL UNIT</span></span>
                                </li>
                                <li class="flex gap-3">
                                    <i class="fas fa-upload text-indigo-500 mt-1"></i>
                                    <span>Lengkapi form, lalu klik tombol <span class="bg-blue-600 text-white px-2 py-0.5 rounded shadow-sm text-[10px] font-bold inline-flex items-center gap-1 uppercase"><i class="fas fa-save text-[8px]"></i> SIMPAN PERUBAHAN</span>.</span>
                                </li>
                            </ul>

                            <!-- Detail Instruksi Formulir OPD -->
                            <div class="mt-6 p-5 bg-white border-2 border-indigo-50 rounded-2xl shadow-inner">
                                <h6 class="text-xs font-black text-indigo-900 uppercase mb-4 tracking-widest border-b pb-2 flex items-center gap-2">
                                    <i class="fas fa-list-check"></i> Panduan Form OPD (Visual):
                                </h6>
                                <div class="space-y-6">
                                    <!-- A: STRUKTUR -->
                                    <div class="flex flex-col md:flex-row gap-4">
                                        <div class="flex gap-3 flex-1">
                                            <div class="bg-indigo-600 text-white w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold mt-0.5">A</div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800">Upload Struktur (Gambar)</p>
                                                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">Format: <strong>JPG, PNG, atau WEBP</strong>. Gambar ini akan tampil di profil OPD Anda di halaman depan.</p>
                                            </div>
                                        </div>
                                        <div class="md:w-40 bg-slate-100 p-2 rounded-xl border border-slate-200 relative">
                                            <div class="h-14 w-full border-2 border-dashed border-slate-300 rounded-lg flex flex-col items-center justify-center bg-white gap-1">
                                                <i class="fas fa-cloud-upload-alt text-slate-300 text-xs"></i>
                                                <span class="text-[6px] text-slate-400 font-bold uppercase">Pilih File</span>
                                            </div>
                                            <div class="absolute -left-4 top-1/2 -translate-y-1/2">
                                                <div class="w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- B: WEBSITE -->
                                    <div class="flex flex-col md:flex-row gap-4">
                                        <div class="flex gap-3 flex-1">
                                            <div class="bg-indigo-600 text-white w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold mt-0.5">B</div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800">Tautan Website OPD</p>
                                                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">Gunakan format lengkap (HTTP/HTTPS). Contoh: <strong>https://dinas.sinjaikab.go.id</strong></p>
                                            </div>
                                        </div>
                                        <div class="md:w-40 space-y-1 bg-slate-100 p-3 rounded-xl border border-slate-200 relative">
                                            <div class="h-1.5 w-10 bg-slate-200 rounded"></div>
                                            <div class="h-6 w-full bg-white border border-slate-300 rounded shadow-sm flex items-center px-2">
                                                <span class="text-[7px] text-indigo-500 font-bold">https://...</span>
                                            </div>
                                            <div class="absolute -left-4 top-1/2 -translate-y-1/2">
                                                <div class="w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- C: SIMPAN -->
                                    <div class="flex flex-col md:flex-row gap-4">
                                        <div class="flex gap-3 flex-1">
                                            <div class="bg-blue-600 text-white w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold mt-0.5">C</div>
                                            <div>
                                                <p class="text-xs font-bold text-blue-800">Finalisasi</p>
                                                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">Pastikan semua data benar lalu tekan simpan.</p>
                                            </div>
                                        </div>
                                        <div class="md:w-40 bg-slate-100 p-2 rounded-xl border border-slate-200 relative flex justify-center">
                                            <div class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-[8px] font-black shadow-md animate-pulse">SIMPAN PERUBAHAN</div>
                                            <div class="absolute -left-4 top-1/2 -translate-y-1/2">
                                                <div class="w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-blue-500"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                    <span>Klik menu <strong>Profil</strong> > <strong>Pejabat Daerah</strong> (OPD) atau <strong>Unit Lokal</strong> (Desa/Kel)</span>
                                </li>
                                <li class="flex gap-3">
                                    <i class="fas fa-edit text-indigo-500 mt-1"></i>
                                    <span>Cari nama pimpinan Anda, lalu klik tombol <span class="bg-amber-500 text-white px-2 py-0.5 rounded shadow-sm text-[10px] font-bold inline-flex items-center gap-1 uppercase tracking-tighter"><i class="fas fa-pencil-alt text-[8px]"></i> KELOLA PIMPINAN</span> pada kartu profil.</span>
                                </li>
                                <li class="flex gap-3">
                                    <i class="fas fa-save text-indigo-500 mt-1"></i>
                                    <span>Lengkapi data pada <strong>Tab Identitas</strong> (Wajib), lalu klik tombol <span class="bg-blue-600 text-white px-3 py-1 rounded shadow-sm text-xs font-bold inline-flex items-center gap-1 uppercase"><i class="fas fa-save"></i> SIMPAN PROFIL</span>.</span>
                                </li>
                            </ul>

                            <!-- Detail Instruksi Formulir -->
                            <div class="mt-6 p-5 bg-white border-2 border-indigo-50 rounded-2xl shadow-inner">
                                <h6 class="text-xs font-black text-indigo-900 uppercase mb-4 tracking-widest border-b pb-2 flex items-center gap-2">
                                    <i class="fas fa-list-check"></i> Prioritas Pengisian (Tab Identitas):
                                </h6>
                                <div class="bg-amber-50 p-3 rounded-xl border border-amber-100 mb-6">
                                    <p class="text-[10px] text-amber-800 leading-relaxed font-medium">
                                        <i class="fas fa-info-circle mr-1"></i> Cukup isi <strong>Tab Identitas</strong> agar profil pimpinan tampil. Tab Biografi, Riwayat Karir, Pendidikan, & Penghargaan bersifat <strong>OPTIONAL (Boleh Dikosongkan)</strong>.
                                    </p>
                                </div>
                                <div class="space-y-8">
                                    <!-- A: FOTO -->
                                    <div class="flex flex-col md:flex-row gap-6">
                                        <div class="flex gap-3 flex-1">
                                            <div class="bg-indigo-600 text-white w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold mt-0.5">A</div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800">Foto (2MB)</p>
                                                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">Gunakan foto formal. Max 2MB. Format JPG, PNG, atau GIF.</p>
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
                                                <p class="text-xs font-bold text-slate-800">Nama & NIP (Wajib *)</p>
                                                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">Wajib isi <strong>Nama Lengkap + Gelar</strong>. NIP diisi tanpa spasi.</p>
                                            </div>
                                        </div>
                                        <div class="md:w-48 space-y-2 bg-slate-100 p-3 rounded-xl border border-slate-200 relative">
                                            <div class="h-2 w-24 bg-indigo-200 rounded"></div>
                                            <div class="h-6 w-full bg-white border border-slate-300 rounded shadow-sm flex items-center px-2">
                                                <span class="text-[8px] text-slate-400 font-bold">CONTOH: Dr. Nama, M.Si</span>
                                            </div>
                                            <div class="absolute -left-4 top-1/2 -translate-y-1/2">
                                                <div class="w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- D: STATUS -->
                                    <div class="flex flex-col md:flex-row gap-6">
                                        <div class="flex gap-3 flex-1">
                                            <div class="bg-indigo-600 text-white w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold mt-0.5">C</div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800">Status Aktif (Wajib *)</p>
                                                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">Pastikan Status disetel ke <strong>Aktif</strong> agar pimpinan muncul di web.</p>
                                            </div>
                                        </div>
                                        <div class="md:w-48 bg-slate-100 p-3 rounded-xl border border-slate-200 relative flex flex-col gap-2">
                                            <div class="h-6 w-full bg-white border border-slate-300 rounded shadow-sm flex items-center px-2 justify-between">
                                                <span class="text-[9px] font-bold text-green-600">Aktif</span>
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
                                            <div class="bg-blue-600 text-white w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold mt-0.5">D</div>
                                            <div>
                                                <p class="text-xs font-bold text-blue-800">Simpan Profil</p>
                                                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">Klik simpan untuk menerapkan perubahan identitas pimpinan.</p>
                                            </div>
                                        </div>
                                        <div class="md:w-48 bg-slate-100 p-3 rounded-xl border border-slate-200 relative flex justify-center">
                                            <div class="bg-blue-600 text-white px-4 py-2 rounded-lg text-[9px] font-black shadow-md shadow-blue-200 animate-bounce uppercase">SIMPAN PROFIL</div>
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
            <div x-show="$store.pedomanAdminModal.activeTab === 1" x-transition class="space-y-10">
                <div class="flex items-center gap-4 border-l-4 border-blue-600 pl-4 mb-6">
                    <h4 class="text-2xl font-bold text-slate-800">Panduan Manajemen & Standar Dokumen Wajib</h4>
                </div>

                <!-- BAGIAN 1: PENGERTIAN UMUM -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-blue-50 p-6 rounded-3xl border border-blue-100">
                        <h6 class="font-black text-blue-900 mb-3 uppercase tracking-tight flex items-center gap-2">
                            <i class="fas fa-history"></i> Informasi Berkala
                        </h6>
                        <p class="text-xs text-slate-700 leading-relaxed">
                            Informasi Berkala adalah dokumen yang wajib disediakan dan diumumkan secara rutin oleh Badan Publik. Sifat dokumen ini adalah <strong>"Update Terkini" atau Saling Menggantikan</strong>. Artinya, jika Anda mengupload data tahun terbaru (misal: LRA 2024), maka data tahun sebelumnya (LRA 2023) harus diubah statusnya menjadi <strong>ARSIP</strong> agar publik selalu mendapatkan informasi yang paling relevan dan valid saat ini.
                        </p>
                    </div>
                    <div class="bg-emerald-50 p-6 rounded-3xl border border-emerald-100">
                        <h6 class="font-black text-emerald-900 mb-3 uppercase tracking-tight flex items-center gap-2">
                            <i class="fas fa-layer-group"></i> Informasi Setiap Saat
                        </h6>
                        <p class="text-xs text-slate-700 leading-relaxed">
                            Informasi Setiap Saat adalah dokumen yang wajib tersedia dan diberikan kapan saja ketika ada pemohon informasi. Sifat dokumen ini adalah <strong>"Akumulatif" atau Katalog Arsip</strong>. Anda dapat mengupload dokumen dari tahun-tahun sebelumnya maupun tahun berjalan secara bersamaan. Semua dokumen disetel sebagai <strong>BERLAKU</strong> tanpa perlu mengarsipkan data lama, karena fungsinya adalah sebagai database sejarah operasional instansi.
                        </p>
                    </div>
                </div>

                <!-- BAGIAN 2: DAFTAR DOKUMEN WAJIB PER INSTANSI -->
                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-10 opacity-10"><i class="fas fa-file-invoice text-9xl"></i></div>
                    <h5 class="text-xl font-bold mb-8 flex items-center gap-3"><i class="fas fa-clipboard-list text-yellow-400"></i> Daftar Dokumen Wajib (Standar PERKI)</h5>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-4">
                            <div class="border-l-2 border-indigo-500 pl-4">
                                <p class="text-indigo-400 font-black text-[10px] uppercase tracking-widest mb-1">Dinas / Badan / Kantor</p>
                                <p class="text-[11px] text-slate-300 leading-relaxed">Renstra, Renja, DPA, RKA, LRA, Neraca, LKjIP, LKPJ, Profil Pimpinan, Struktur Organisasi, LHKPN/LHKASN.</p>
                            </div>
                            <div class="border-l-2 border-orange-500 pl-4">
                                <p class="text-orange-400 font-black text-[10px] uppercase tracking-widest mb-1">Inspektorat</p>
                                <p class="text-[11px] text-slate-300 leading-relaxed">PKPT (Program Kerja), Ringkasan LHP (yang sudah dipublikasi), Laporan Akuntabilitas, Standar Audit.</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="border-l-2 border-pink-500 pl-4">
                                <p class="text-pink-400 font-black text-[10px] uppercase tracking-widest mb-1">RSUD (Rumah Sakit)</p>
                                <p class="text-[11px] text-slate-300 leading-relaxed">Profil Layanan, Tarif Layanan, Standar Pelayanan Minimal (SPM), Maklumat Pelayanan Kesehatan, LRA BLUD.</p>
                            </div>
                            <div class="border-l-2 border-blue-400 pl-4">
                                <p class="text-blue-400 font-black text-[10px] uppercase tracking-widest mb-1">Kecamatan</p>
                                <p class="text-[11px] text-slate-300 leading-relaxed">Profil Wilayah, Data Monografi, DPA Kecamatan, Laporan Pelayanan PATEN, Laporan Trantibum.</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="border-l-2 border-green-500 pl-4">
                                <p class="text-green-400 font-black text-[10px] uppercase tracking-widest mb-1">Desa / Kelurahan</p>
                                <p class="text-[11px] text-slate-300 leading-relaxed">RPJMDes, RKPDes, APBDes, LPPD (Laporan Penyelenggaraan), Profil Desa, Daftar Inventaris Desa.</p>
                            </div>
                            <div class="bg-white/5 p-3 rounded-2xl border border-white/10">
                                <p class="text-[9px] text-slate-400 italic">"Gunakan bantuan <strong>AI Analis</strong> jika ragu menempatkan jenis dokumen di atas."</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 3: PANDUAN TEKNIS PENGISIAN FORM -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center shadow-lg"><i class="fas fa-edit"></i></div>
                        <div>
                            <h5 class="font-bold text-slate-800 leading-tight">Langkah-Langkah Pembuatan Informasi</h5>
                            <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">Tutorial Form Lengkap (A - H)</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-[2rem] border border-slate-200 p-8 space-y-10">
                        <!-- A: JUDUL -->
                        <div class="flex flex-col md:flex-row gap-8">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-3">
                                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-sm">A</span>
                                    <h6 class="font-bold text-slate-800 mt-1">Judul Informasi</h6>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed ml-12">Tuliskan judul yang spesifik dan mudah dicari. <br>Contoh: <strong>"Laporan Realisasi Anggaran (LRA) Tahun 2024"</strong>.</p>
                            </div>
                            <div class="md:w-64 bg-white p-3 rounded-2xl border border-slate-200 shadow-sm relative">
                                <div class="h-2 w-16 bg-slate-100 rounded mb-2"></div>
                                <div class="h-8 w-full border border-indigo-200 rounded-lg bg-indigo-50/30 flex items-center px-3">
                                    <span class="text-[8px] text-indigo-400 font-bold">LRA Tahun 2024...</span>
                                </div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                            </div>
                        </div>

                        <!-- B: DESKRIPSI -->
                        <div class="flex flex-col md:flex-row gap-8">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-3">
                                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-sm">B</span>
                                    <h6 class="font-bold text-slate-800 mt-1">Deskripsi Singkat & Konten</h6>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed ml-12">Berikan penjelasan ringkas mengenai isi dokumen agar pemohon paham kegunaan data tersebut sebelum mengunduh.</p>
                            </div>
                            <div class="md:w-64 bg-white p-3 rounded-2xl border border-slate-200 shadow-sm relative">
                                <div class="h-14 w-full border border-slate-200 rounded-lg bg-slate-50 flex flex-col p-2 gap-1">
                                    <div class="h-1 w-full bg-slate-200 rounded"></div>
                                    <div class="h-1 w-4/5 bg-slate-200 rounded"></div>
                                </div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                            </div>
                        </div>

                        <!-- C: KATEGORI & UNIT -->
                        <div class="flex flex-col md:flex-row gap-8">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-3">
                                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-sm">C</span>
                                    <h6 class="font-bold text-slate-800 mt-1">Kategori & Unit Kerja</h6>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed ml-12">Pilih kategori (Berkala/Setiap Saat). Untuk Unit Kerja akan terisi otomatis sesuai akun Anda.</p>
                            </div>
                            <div class="md:w-64 space-y-2 relative">
                                <div class="bg-white p-2 rounded-xl border border-slate-200 flex justify-between items-center">
                                    <span class="text-[8px] font-bold text-slate-700">Informasi Berkala</span>
                                    <i class="fas fa-chevron-down text-[7px] text-slate-400"></i>
                                </div>
                                <div class="bg-slate-100 p-2 rounded-xl border border-slate-200">
                                    <span class="text-[7px] font-bold text-slate-500 italic">Nama Unit Kerja Anda...</span>
                                </div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                            </div>
                        </div>

                        <!-- D: JENIS DOKUMEN -->
                        <div class="flex flex-col md:flex-row gap-8">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-3">
                                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-sm">D</span>
                                    <h6 class="font-bold text-slate-800 mt-1">Klasifikasi Jenis Dokumen</h6>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed ml-12">Sangat penting untuk pengelompokan otomatis. Pilih jenis yang paling sesuai (misal: Keuangan, Strategis).</p>
                            </div>
                            <div class="md:w-64 bg-white p-3 rounded-2xl border border-slate-200 shadow-sm relative">
                                <div class="h-8 w-full border border-blue-200 rounded-lg bg-blue-50/50 flex items-center px-3 justify-between">
                                    <span class="text-[8px] text-blue-600 font-black">Informasi Keuangan</span>
                                    <i class="fas fa-check-circle text-blue-500 text-[8px]"></i>
                                </div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                            </div>
                        </div>

                        <!-- E: TAHUN -->
                        <div class="flex flex-col md:flex-row gap-8">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-3">
                                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-sm">E</span>
                                    <h6 class="font-bold text-slate-800 mt-1">Tahun Dokumen</h6>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed ml-12">Pilih tanggal atau tahun terbit dokumen. Format yang digunakan adalah <strong>YYYY-MM-DD</strong>.</p>
                            </div>
                            <div class="md:w-64 bg-white p-3 rounded-2xl border border-slate-200 shadow-sm relative flex items-center">
                                <div class="h-8 w-full border border-slate-200 rounded-lg flex items-center px-3 gap-2">
                                    <i class="fas fa-calendar text-[8px] text-slate-400"></i>
                                    <span class="text-[8px] text-slate-700">2024-04-29</span>
                                </div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                            </div>
                        </div>

                        <!-- F: STATUS -->
                        <div class="flex flex-col md:flex-row gap-8">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-3">
                                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-sm">F</span>
                                    <h6 class="font-bold text-slate-800 mt-1">Status (Berlaku / Arsip)</h6>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed ml-12">Setel ke <strong>BERLAKU</strong> untuk data aktif. Setel ke <strong>ARSIP</strong> jika data tersebut sudah kedaluwarsa.</p>
                            </div>
                            <div class="md:w-64 bg-white p-3 rounded-2xl border border-slate-200 shadow-sm relative flex gap-4">
                                <div class="flex items-center gap-1">
                                    <div class="w-3 h-3 rounded-full border-2 border-indigo-600 flex items-center justify-center"><div class="w-1.5 h-1.5 bg-indigo-600 rounded-full"></div></div>
                                    <span class="text-[8px] font-bold text-indigo-700 uppercase">Berlaku</span>
                                </div>
                                <div class="flex items-center gap-1 opacity-40">
                                    <div class="w-3 h-3 rounded-full border-2 border-slate-300"></div>
                                    <span class="text-[8px] font-bold text-slate-500 uppercase">Arsip</span>
                                </div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                            </div>
                        </div>

                        <!-- G: FILE UPLOAD -->
                        <div class="flex flex-col md:flex-row gap-8">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-3">
                                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-black text-sm">G</span>
                                    <h6 class="font-bold text-slate-800 mt-1">Upload File atau Link</h6>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed ml-12">Upload file langsung (Max <strong>2MB</strong>). Jika file besar (misal Video/Laporan Tebal), pilih <strong>Link File</strong> dan masukkan URL Google Drive/Cloud.</p>
                            </div>
                            <div class="md:w-64 bg-white p-3 rounded-2xl border-2 border-dashed border-indigo-100 relative flex flex-col items-center justify-center gap-1 py-4">
                                <i class="fas fa-file-pdf text-indigo-400 text-xl"></i>
                                <span class="text-[7px] text-slate-400 font-bold uppercase">Maksimal 2MB</span>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-indigo-500"></div>
                            </div>
                        </div>

                        <!-- H: FINALISASI -->
                        <div class="flex flex-col md:flex-row gap-8">
                            <div class="flex-1">
                                <div class="flex gap-4 mb-3">
                                    <span class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-black text-sm">H</span>
                                    <h6 class="font-bold text-blue-900 mt-1 uppercase italic">Check & Simpan</h6>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-relaxed ml-12">Khusus <strong>Informasi Berkala</strong>, wajib klik tombol <span class="bg-yellow-500 text-white px-1.5 py-0.5 rounded font-bold text-[8px] uppercase tracking-tighter">CHECK INFORMASI</span> untuk mendeteksi data lama agar otomatis diarsipkan.</p>
                            </div>
                            <div class="md:w-64 bg-white p-3 rounded-2xl border border-slate-200 shadow-sm relative flex justify-center">
                                <div class="bg-yellow-500 text-white px-4 py-2 rounded-xl text-[9px] font-black shadow-lg shadow-yellow-100 animate-pulse uppercase tracking-tighter">CHECK INFORMASI</div>
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[8px] border-r-yellow-500"></div>
                            </div>
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
