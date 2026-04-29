<div x-show="$store.pedomanAdminModal.open" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 z-[110] bg-slate-900/90 backdrop-blur-sm flex items-center justify-center p-2 md:p-4" 
     style="display: none;">
    
    <div class="bg-white w-full max-w-6xl max-h-[95vh] rounded-xl shadow-2xl flex flex-col overflow-hidden border border-slate-200 font-sans text-slate-700">
        
        <!-- Header -->
        <div class="bg-indigo-900 px-4 py-3 flex-shrink-0 border-b border-indigo-950 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-500 p-1.5 rounded-lg shadow-lg">
                        <i class="fas fa-chalkboard-teacher text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-tight">Pedoman Operasional Admin</h3>
                        <p class="text-indigo-200 text-[9px] font-medium uppercase tracking-widest italic">Portal PPID v2.0</p>
                    </div>
                </div>
                <button @click="$store.pedomanAdminModal.close()" 
                        class="bg-white/10 hover:bg-white/20 text-white transition-all p-1.5 rounded-md">
                    <i class="fas fa-times text-base"></i>
                </button>
            </div>
        </div>

        <!-- Tab Navigation (STICKY) -->
        <div class="bg-slate-50 border-b border-slate-200 flex overflow-x-auto no-scrollbar sticky top-0 z-50 shadow-sm">
            <template x-for="(tab, index) in $store.pedomanAdminModal.tabs" :key="index">
                <button @click="$store.pedomanAdminModal.activeTab = index"
                        :class="$store.pedomanAdminModal.activeTab === index ? 'border-indigo-600 text-indigo-700 bg-white shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700'"
                        class="px-4 py-2.5 border-b-2 font-bold text-[11px] whitespace-nowrap transition-all flex items-center gap-1.5 uppercase">
                    <i :class="tab.icon"></i>
                    <span x-text="tab.title"></span>
                </button>
            </template>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-4 md:p-6 bg-white space-y-8">
            
            <!-- Tab 0: MENU PROFIL -->
            <div x-show="$store.pedomanAdminModal.activeTab === 0" x-transition class="space-y-8">
                <h4 class="text-base font-bold border-l-4 border-indigo-600 pl-3 uppercase tracking-tighter">Pengelolaan Profil OPD & Pimpinan</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 font-medium">
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 shadow-sm text-xs">
                        <h5 class="font-bold text-indigo-700 mb-3 flex items-center gap-2 uppercase text-[11px]">
                            <span class="bg-indigo-100 w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold">1</span>
                            Struktur & Website OPD
                        </h5>
                        <ul class="space-y-2 mb-4 leading-relaxed">
                            <li class="flex gap-2">
                                <i class="fas fa-mouse-pointer text-indigo-500 mt-0.5"></i>
                                <span>Menu <strong>Profil</strong> > <strong>Tentang OPD</strong></span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-search text-indigo-500 mt-0.5"></i>
                                <span>Cari unit Bapak, klik tombol <span class="bg-white text-blue-600 border border-blue-200 px-1 py-0.5 rounded text-[8px] font-bold uppercase">KELOLA PROFIL UNIT</span></span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-upload text-indigo-500 mt-0.5"></i>
                                <span>Upload Gambar & Input URL Website.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 shadow-sm text-xs">
                        <h5 class="font-bold text-indigo-700 mb-3 flex items-center gap-2 uppercase text-[11px]">
                            <span class="bg-indigo-100 w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold">2</span>
                            Data Pimpinan & Pejabat
                        </h5>
                        <ul class="space-y-2 mb-4 leading-relaxed">
                            <li class="flex gap-2">
                                <i class="fas fa-edit text-indigo-500 mt-0.5"></i>
                                <span>Klik tombol <span class="bg-amber-500 text-white px-1.5 py-0.5 rounded text-[9px] font-bold uppercase shadow-sm">KELOLA PIMPINAN</span>.</span>
                            </li>
                            <li class="bg-amber-100/50 p-2 rounded-lg border border-amber-200 text-[10px] font-bold text-amber-800">
                                <i class="fas fa-info-circle mr-1"></i> WAJIB: Isi Tab Identitas (Nama & Status Aktif).
                            </li>
                        </ul>
                        <div class="flex justify-center pt-1">
                            <div class="bg-blue-600 text-white px-4 py-1.5 rounded-lg text-[9px] font-bold animate-bounce shadow-md">SIMPAN PROFIL</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 1: JENIS INFORMASI (FULL RESTORED & COMPACT) -->
            <div x-show="$store.pedomanAdminModal.activeTab === 1" x-transition class="space-y-10 text-slate-700">
                <h4 class="text-base font-bold border-l-4 border-blue-600 pl-3 uppercase tracking-tighter">Klasifikasi & Panduan Operasional Informasi</h4>

                <!-- BAGIAN: LOGIKA MENDALAM -->
                <div class="space-y-5">
                    <h5 class="text-sm font-bold flex items-center gap-2 border-b pb-1 text-slate-800 uppercase tracking-widest italic">
                        <i class="fas fa-balance-scale text-blue-600"></i> Mengapa Dokumen Harus Diklasifikasikan?
                    </h5>
                    
                    <div class="grid grid-cols-1 gap-5 text-[11px] leading-relaxed">
                        <!-- BERKALA -->
                        <div class="bg-blue-50 p-6 rounded-2xl border border-blue-200 relative overflow-hidden shadow-sm">
                            <div class="absolute top-0 right-0 p-6 opacity-5"><i class="fas fa-history text-[5rem] text-blue-900"></i></div>
                            <h6 class="font-bold text-blue-900 mb-2 uppercase tracking-widest flex items-center gap-2 text-xs italic underline">
                                <i class="fas fa-calendar-alt"></i> 1. Informasi Berkala (Kewajiban Rutin)
                            </h6>
                            <p class="mb-4">Dokumen diklasifikasikan sebagai <strong>Informasi Berkala</strong> karena merupakan <strong>Representasi Kewajiban Rutin</strong>. Wajib ada dan diperbarui terjadwal (tahunan/semesteran) sesuai siklus anggaran. Sifatnya <strong>Update Terkini (Ganti Data)</strong>. Dokumen terbaru (2024) WAJIB mematikan validitas dokumen lama (2023).</p>
                            <div class="bg-white/80 p-3 rounded-xl border border-blue-100 text-[10px] italic font-bold text-blue-800 shadow-sm">
                                Studi Logika Rutin (Contoh): "Setiap dokumen dengan <strong>Siklus Waktu Tetap</strong> (seperti Renstra, Anggaran, Laporan Kinerja) WAJIB masuk kategori <strong>BERKALA</strong>. Gunakan fitur <strong>Check Informasi</strong> untuk mengarsipkan data lama."
                            </div>
                        </div>

                        <!-- SETIAP SAAT -->
                        <div class="bg-emerald-50 p-6 rounded-2xl border border-emerald-200 relative overflow-hidden shadow-sm">
                            <div class="absolute top-0 right-0 p-6 opacity-5"><i class="fas fa-folder-open text-[5rem] text-emerald-900"></i></div>
                            <h6 class="font-bold text-emerald-900 mb-2 uppercase tracking-widest flex items-center gap-2 text-xs italic underline">
                                <i class="fas fa-archive"></i> 2. Informasi Setiap Saat (Catatan Sejarah)
                            </h6>
                            <p class="mb-4">Dokumen masuk kategori ini karena merupakan <strong>Catatan Histori & Produk Kebijakan</strong>. Wajib sedia kapanpun diminta. Sifatnya <strong>Akumulatif (Menumpuk)</strong>. Semua data tahun lama hingga sekarang tetap BERLAKU sebagai sejarah unit Bapak.</p>
                            <div class="bg-white/80 p-3 rounded-xl border border-emerald-100 text-[10px] italic font-bold text-emerald-800 shadow-sm">
                                Studi Logika Kebijakan (Contoh): "Dokumen berupa <strong>Ketetapan Hukum</strong> (seperti SK Kadis, MoU Kerjasama) WAJIB masuk kategori <strong>SETIAP SAAT</strong>. Dokumen ini berlaku permanen."
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-red-50 p-4 rounded-xl border border-red-200 text-[10px] shadow-sm">
                                <h6 class="font-bold text-red-900 mb-1 uppercase underline italic">3. Serta Merta (Darurat)</h6>
                                <p class="font-medium text-slate-700 uppercase italic">Mendesak! Info Banjir, Wabah, Bencana. Wajib upload segera!</p>
                            </div>
                            <div class="bg-slate-900 p-4 rounded-xl border border-slate-700 text-[10px] shadow-sm text-white">
                                <h6 class="font-bold text-slate-300 mb-1 uppercase underline italic">4. Dikecualikan (Rahasia)</h6>
                                <p class="font-medium text-slate-400 uppercase italic">Data Rahasia (Pasal 17 UU KIP). Tidak tampil di publik.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TUTORIAL FORM A - H -->
                <div class="space-y-6">
                    <h5 class="text-sm font-bold flex items-center gap-2 border-b pb-1 uppercase text-slate-800">
                        <i class="fas fa-keyboard text-indigo-600"></i> Tutorial Pengisian Formulir (A - H)
                    </h5>

                    <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6 space-y-8 shadow-inner">
                        <!-- A: JUDUL -->
                        <div class="flex flex-col md:flex-row gap-6 items-start font-bold uppercase tracking-tighter">
                            <div class="flex-1 space-y-1">
                                <div class="flex gap-3 items-center">
                                    <span class="w-7 h-7 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-sm shadow-md">A</span>
                                    <h6 class="text-xs font-bold">Judul Informasi</h6>
                                </div>
                                <p class="ml-10 text-[10px] text-slate-500 italic underline underline-offset-2">Wajib: Nama Dokumen + Unit + Tahun.</p>
                            </div>
                            <div class="md:w-56 bg-white p-2.5 rounded-lg border border-indigo-100 shadow-md relative text-[8px]">
                                <div class="h-8 w-full border-2 border-indigo-200 rounded-lg bg-indigo-50/50 flex items-center px-3 text-indigo-400 italic">Renja Dinas... 2024...</div>
                                <div class="absolute -left-2 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[6px] border-y-transparent border-r-[10px] border-r-indigo-600 shadow-lg"></div>
                            </div>
                        </div>

                        <!-- B: DESKRIPSI -->
                        <div class="flex flex-col md:flex-row gap-6 items-start border-t pt-6 font-bold uppercase tracking-tighter">
                            <div class="flex-1 space-y-4">
                                <div class="flex gap-3 items-center">
                                    <span class="w-7 h-7 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-sm shadow-md">B</span>
                                    <h6 class="text-xs font-bold">Deskripsi & Lampiran</h6>
                                </div>
                                <div class="ml-10 space-y-4">
                                    <p class="text-[10px] text-slate-500 italic underline">Ringkasan isi dokumen bagi masyarakat.</p>
                                    <div class="bg-amber-100 p-4 rounded-xl border-2 border-amber-300 italic text-amber-900 text-[9px] font-black">
                                        <h6 class="uppercase mb-2 underline decoration-2 italic flex items-center gap-1"><i class="fas fa-exclamation-triangle"></i> Dokumen Pelengkap (WAJIB):</h6>
                                        <p class="leading-relaxed">"GABUNGKAN DALAM 1 PDF. Jika > 2MB, pilih opsi Link File Google Drive unit Bapak!"</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- H: FINALISASI -->
                        <div class="flex flex-col md:flex-row gap-6 items-start border-t-2 border-dashed border-slate-200 pt-8 font-bold uppercase tracking-tighter">
                            <div class="flex-1 space-y-2">
                                <div class="flex gap-4 items-center">
                                    <span class="w-7 h-7 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm shadow-md animate-bounce">H</span>
                                    <h6 class="text-xs font-bold underline decoration-blue-500 decoration-2 italic">Check & Simpan</h6>
                                </div>
                                <p class="ml-10 text-[9px] text-blue-700 italic font-black uppercase">"Khusus BERKALA, WAJIB klik CHECK INFORMASI untuk mengarsipkan data lama!"</p>
                            </div>
                            <div class="md:w-56 flex justify-center relative">
                                <div class="bg-yellow-500 text-white px-4 py-1.5 rounded-lg text-[8px] font-black shadow-lg animate-bounce border-2 border-white uppercase italic">CHECK INFORMASI</div>
                                <div class="absolute -left-2 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[5px] border-y-transparent border-r-[8px] border-r-yellow-500 shadow-lg"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BANTUAN AI (COMPACT) -->
                <div class="bg-indigo-900 text-white p-8 rounded-[2rem] shadow-xl relative overflow-hidden italic font-bold uppercase tracking-tighter">
                    <div class="absolute -right-6 -bottom-6 opacity-10"><i class="fas fa-microchip text-[6rem]"></i></div>
                    <h5 class="text-base font-bold mb-6 flex items-center gap-3 underline underline-offset-4 decoration-indigo-700">
                        <i class="fas fa-magic text-indigo-300"></i> Bingung Klasifikasi? Tanya AI!
                    </h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center text-[10px]">
                        <div class="space-y-3 font-black">
                            <p>1. Klik tombol <span class="bg-indigo-600 px-1.5 py-0.5 rounded border border-indigo-400">TANYA PEDOMAN</span> di pojok form.</p>
                            <p>2. Ketik Nama Dokumen & Klik Tombol Hijau <span class="bg-green-600 px-1.5 py-0.5 rounded animate-pulse">TANYA AI</span>!</p>
                        </div>
                    </div>
                </div>

                <!-- REKAPITULASI DOKUMEN -->
                <div class="bg-white border-2 border-slate-100 rounded-[2rem] p-8 shadow-md relative overflow-hidden font-bold italic uppercase tracking-tighter text-slate-500">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 via-indigo-600 to-emerald-600"></div>
                    <h5 class="text-sm font-bold text-slate-800 mb-6 text-center uppercase tracking-widest border-b pb-2 italic underline underline-offset-4 decoration-2">Dokumen Wajib Per Unit Kerja</h5>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-[9px] font-black uppercase">
                        <div class="space-y-2 border-r pr-2">
                            <p class="font-bold text-blue-600 border-b pb-1 italic underline underline-offset-2"><i class="fas fa-building mr-1"></i> Dinas / Badan / RSUD</p>
                            <ul class="space-y-1 list-disc list-inside">
                                <li>Renstra, Renja, DPA, LRA.</li>
                                <li>Tarif Layanan (RSUD).</li>
                                <li>LHKPN Pejabat Utama.</li>
                            </ul>
                        </div>
                        <div class="space-y-2 border-r pr-2">
                            <p class="font-bold text-indigo-600 border-b pb-1 italic underline underline-offset-2"><i class="fas fa-search-dollar mr-1"></i> Inspektorat</p>
                            <ul class="space-y-1 list-disc list-inside">
                                <li>PKPT (Audit Tahunan).</li>
                                <li>Ringkasan LHP Publik.</li>
                                <li>Laporan Akuntabilitas.</li>
                            </ul>
                        </div>
                        <div class="space-y-2">
                            <p class="font-bold text-green-600 border-b pb-1 italic underline underline-offset-2"><i class="fas fa-map-marked-alt mr-1"></i> Kecamatan / Desa / Kel</p>
                            <ul class="space-y-1 list-disc list-inside">
                                <li>APBDes / RKPDes (Anggaran).</li>
                                <li>LPPD & Monografi Wilayah.</li>
                                <li>Laporan PATEN (Kecamatan).</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: TRANSPARANSI -->
            <div x-show="$store.pedomanAdminModal.activeTab === 2" x-transition class="space-y-8 uppercase font-bold italic tracking-tighter text-slate-800">
                <h4 class="text-lg font-bold border-l-4 border-green-600 pl-4 underline underline-offset-4 tracking-tighter">Layanan Permohonan Informasi</h4>
                <div class="bg-white border-2 border-slate-100 rounded-2xl p-6 shadow-md relative overflow-hidden font-black">
                    <div class="absolute top-0 left-0 w-2 h-full bg-blue-600"></div>
                    <h5 class="text-xs font-bold mb-4 italic underline decoration-blue-500 decoration-2 uppercase">Admin Merespon (Langkah Pengiriman Jawaban):</h5>
                    <ol class="text-[10px] text-slate-600 space-y-4 list-decimal list-inside leading-relaxed uppercase tracking-tighter italic">
                        <li class="bg-white p-2 rounded-lg border border-blue-100 shadow-sm">Buka Dashboard Permohonan.</li>
                        <li class="bg-white p-2 rounded-lg border border-blue-100 shadow-sm">Cari status <span class="text-orange-600 underline">PENDING</span>.</li>
                        <li class="bg-white p-2 rounded-lg border-2 border-blue-200 shadow-md">Tombol Biru <span class="text-blue-600 uppercase">"PROSES / BALAS"</span>.</li>
                    </ol>
                </div>
            </div>

            <!-- Tab 3: PBJ -->
            <div x-show="$store.pedomanAdminModal.activeTab === 3" x-transition class="space-y-10 font-bold uppercase italic tracking-tighter text-slate-800">
                <h4 class="text-lg font-bold border-l-4 border-orange-600 pl-4 italic underline underline-offset-4 uppercase">Panduan Khusus PBJ</h4>
                <div class="bg-orange-50 p-6 rounded-2xl border border-orange-100 mb-6 flex gap-4 items-start shadow-sm font-black uppercase">
                    <div class="bg-orange-500 text-white p-4 rounded-xl shadow-md animate-bounce"><i class="fas fa-exclamation-triangle text-xl"></i></div>
                    <div class="relative z-10 pt-1 space-y-2">
                        <h6 class="text-sm font-bold text-orange-900 underline underline-offset-4 italic decoration-orange-300">Penting Bagi Bagian PBJ!</h6>
                        <p class="text-[10px] text-orange-800 leading-relaxed underline italic tracking-tighter decoration-orange-200">"UPDATE DATA PAKET TENDER RUTIN SESUAI PROGRES FISIK!"</p>
                    </div>
                </div>
                <div class="p-6 bg-white border-2 border-slate-100 rounded-2xl shadow-md font-black italic uppercase">
                    <ul class="text-xs space-y-6">
                        <li class="flex gap-3 items-center bg-slate-50 p-3 rounded-lg border border-orange-100">
                            <span class="text-orange-500 font-bold text-2xl tracking-tighter italic shadow-inner">01.</span>
                            <span class="text-[10px] tracking-tighter">Menu <strong>PBJ</strong> > <strong>Input Paket</strong>. Isi Pagu & Pemenang Tender.</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="bg-slate-50 p-4 border-t border-slate-200 flex flex-col md:flex-row gap-4 items-center justify-between flex-shrink-0 shadow-inner z-50">
            <div class="flex items-center gap-3 text-slate-400 font-bold uppercase tracking-widest text-[9px] italic font-black">
                <img src="https://ui-avatars.com/api/?name=Admin+PPID&background=4f46e5&color=fff" class="w-8 h-8 rounded-full border border-white shadow-md">
                <div>Portal PPID v2.0 <br><span class="text-[8px] text-indigo-500 underline decoration-indigo-100 uppercase tracking-widest">Dinas Kominfo Sinjai</span></div>
            </div>
            
            <div class="flex gap-3 w-full md:w-auto font-bold uppercase italic tracking-tighter font-black">
                <button @click="$store.pedomanAdminModal.prevTab()" x-show="$store.pedomanAdminModal.activeTab > 0" class="px-5 py-2 bg-white text-slate-600 rounded-lg border border-slate-200 text-[10px] hover:bg-slate-50 transition-all shadow-md active:scale-95 italic">
                    <i class="fas fa-arrow-left"></i> SEBELUMNYA
                </button>

                <button @click="$store.pedomanAdminModal.nextTab()" class="flex-1 md:flex-none px-10 py-2 bg-indigo-700 text-white rounded-lg shadow-lg text-[10px] transition-all hover:bg-indigo-800 hover:scale-[1.05] active:scale-95 border-b-4 border-indigo-900">
                    <span x-text="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'SAYA MENGERTI, TUTUP' : 'LANJUT KE BERIKUTNYA'"></span>
                    <i :class="$store.pedomanAdminModal.activeTab === $store.pedomanAdminModal.tabs.length - 1 ? 'fas fa-check-double' : 'fas fa-arrow-right'"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin'))
    <div class="fixed z-[105] bottom-6 right-6" x-data x-cloak>
        <button @click="$store.pedomanAdminModal.show()" 
                class="w-12 h-12 bg-indigo-700 hover:bg-indigo-800 text-white rounded-full shadow-xl flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 group relative border-2 border-white p-3 overflow-hidden shadow-indigo-600/30">
            <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/10 to-white/20 opacity-0 group-hover:opacity-100 transition-opacity shadow-inner"></div>
            <i class="fas fa-chalkboard-teacher text-xl group-hover:rotate-6 transition-transform shadow-indigo-950"></i>
            <div class="absolute bottom-full right-0 mb-4 px-3 py-1.5 bg-indigo-950 text-white text-[9px] font-bold rounded-lg opacity-0 group-hover:opacity-100 transition-all transform translate-y-4 group-hover:translate-y-0 whitespace-nowrap pointer-events-none shadow-2xl border-2 border-indigo-800 uppercase tracking-widest flex items-center gap-2 italic font-black shadow-indigo-950">
                <i class="fas fa-graduation-cap text-indigo-400"></i> Panduan Admin
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
