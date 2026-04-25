<div x-show="$store.pedomanModal.open" 
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     class="fixed inset-0 z-[100] bg-slate-900/90 flex items-center justify-center p-2 md:p-6" 
     style="display: none;">
    
    <div class="bg-white w-full max-w-6xl max-h-[95vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden border border-slate-200">
        
        <!-- Header (Fixed & Optimized) -->
        <div class="bg-blue-800 px-6 py-5 flex-shrink-0 border-b border-blue-900/20">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-white/10 p-2.5 rounded-xl text-white">
                        <i class="fas fa-book-open text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl md:text-2xl font-bold text-white leading-none uppercase">Pedoman Klasifikasi Informasi</h3>
                        <p class="text-blue-200 text-xs mt-1 font-medium">Standar Operasional Penentuan Kategori Dokumen PPID</p>
                    </div>
                </div>
                <!-- Tombol X Muncul Jika Sudah Baca -->
                <button x-show="$store.pedomanModal.canClose" 
                        @click="$store.pedomanModal.close()" 
                        class="text-white/60 hover:text-white transition-colors p-2"
                        x-transition>
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="w-full h-1 bg-slate-100 flex-shrink-0">
            <div class="h-full bg-blue-500 transition-all duration-200" 
                 :style="{ width: $store.pedomanModal.scrollProgress + '%' }"></div>
        </div>

        <!-- Content Area (Scrollable) -->
        <div class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50"
             @scroll="$store.pedomanModal.updateProgress($el)">
            
            <!-- Prinsip Utama -->
            <div class="mb-10 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                    <div class="text-blue-600 mb-2"><i class="fas fa-tag"></i> <span class="font-bold text-slate-800 ml-1">Sifat Dokumen</span></div>
                    <p class="text-xs text-slate-500 leading-relaxed">Klasifikasi ditentukan oleh <strong>jenis informasi</strong>, bukan tahun terbit.</p>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                    <div class="text-indigo-600 mb-2"><i class="fas fa-archive"></i> <span class="font-bold text-slate-800 ml-1">Logika Arsip</span></div>
                    <p class="text-xs text-slate-500 leading-relaxed">Data lama tetap di kategorinya, hanya statusnya yang menjadi <strong>Arsip</strong>.</p>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                    <div class="text-red-600 mb-2"><i class="fas fa-gavel"></i> <span class="font-bold text-slate-800 ml-1">Uji Konsekuensi</span></div>
                    <p class="text-xs text-slate-500 leading-relaxed">Pengecualian data wajib didasari oleh <strong>SK Uji Konsekuensi</strong> yang sah.</p>
                </div>
            </div>

            <!-- Grid Kategori -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- A. BERKALA -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                    <div class="bg-blue-600 px-5 py-3 text-white font-bold flex justify-between items-center text-sm">
                        <span>A. INFORMASI BERKALA</span>
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="p-5 flex-1">
                        <p class="text-xs text-slate-500 mb-4 italic">Diumumkan rutin tanpa perlu diminta.</p>
                        <ul class="text-xs space-y-2.5 text-slate-700">
                            <li class="flex items-start gap-2"><i class="fas fa-check text-blue-500 mt-0.5"></i> <span>Profil Badan Publik (Visi, Misi, Struktur, Tupoksi)</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-check text-blue-500 mt-0.5"></i> <span>Ringkasan Program & Anggaran (RKA/DPA/DPA-SKPD)</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-check text-blue-500 mt-0.5"></i> <span>Daftar Informasi Publik (DIP) & DIK</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-check text-blue-500 mt-0.5"></i> <span>Laporan Keuangan Tahunan Audited & LRA</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-check text-blue-500 mt-0.5"></i> <span>Laporan Kinerja (LKjIP / LPPD / LKPJ)</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-check text-blue-500 mt-0.5"></i> <span>Regulasi: Perda, Perbup, & SK Umum</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-check text-blue-500 mt-0.5"></i> <span>Ringkasan Pemenang Tender & RUP Pengadaan</span></li>
                        </ul>
                    </div>
                </div>

                <!-- B. SETIAP SAAT -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                    <div class="bg-green-600 px-5 py-3 text-white font-bold flex justify-between items-center text-sm">
                        <span>B. INFORMASI SETIAP SAAT</span>
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="p-5 flex-1">
                        <p class="text-xs text-slate-500 mb-4 italic">Tersedia via permohonan informasi.</p>
                        <ul class="text-xs space-y-2.5 text-slate-700">
                            <li class="flex items-start gap-2"><i class="fas fa-file-pdf text-green-500 mt-0.5"></i> <span>Naskah Lengkap SOP & Lampiran Teknis</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-file-pdf text-green-500 mt-0.5"></i> <span>Dokumen Kontrak Pengadaan & HPS Lengkap</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-file-pdf text-green-500 mt-0.5"></i> <span>Surat Perjanjian Kerja Sama (MoU / PKS)</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-file-pdf text-green-500 mt-0.5"></i> <span>SK Jabatan / SK PPTK / SK Panitia</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-file-pdf text-green-500 mt-0.5"></i> <span>Bukti Transaksi (Kuitansi / Bukti Bayar / SPJ)</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-file-pdf text-green-500 mt-0.5"></i> <span>Notula Rapat Pimpinan & Catatan Internal</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-file-pdf text-green-500 mt-0.5"></i> <span>Informasi Kepegawaian & Administrasi</span></li>
                        </ul>
                    </div>
                </div>

                <!-- C. SERTA MERTA -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                    <div class="bg-orange-500 px-5 py-3 text-white font-bold flex justify-between items-center text-sm">
                        <span>C. INFORMASI SERTA MERTA</span>
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div class="p-5 flex-1">
                        <p class="text-xs text-slate-500 mb-4 italic">Diumumkan seketika demi keselamatan jiwa.</p>
                        <ul class="text-xs space-y-2.5 text-slate-700">
                            <li class="flex items-start gap-2"><i class="fas fa-exclamation-triangle text-orange-500 mt-0.5"></i> <span>Peringatan Dini Bencana Alam</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-exclamation-triangle text-orange-500 mt-0.5"></i> <span>Informasi Darurat Kesehatan / Wabah</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-exclamation-triangle text-orange-500 mt-0.5"></i> <span>Gangguan Layanan Vital (Listrik/Air Massal)</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-exclamation-triangle text-orange-500 mt-0.5"></i> <span>Darurat Keamanan / Arus Lalu Lintas</span></li>
                        </ul>
                    </div>
                </div>

                <!-- D. DIKECUALIKAN -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                    <div class="bg-slate-800 px-5 py-3 text-white font-bold flex justify-between items-center text-sm">
                        <span>D. INFORMASI DIKECUALIKAN</span>
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="p-5 flex-1">
                        <p class="text-xs text-slate-500 mb-4 italic">Akses tertutup karena dilindungi UU.</p>
                        <ul class="text-xs space-y-2.5 text-slate-700">
                            <li class="flex items-start gap-2"><i class="fas fa-user-shield text-slate-400 mt-0.5"></i> <span>Data Pribadi (NIK, Rekam Medis, Rekening)</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-key text-slate-400 mt-0.5"></i> <span>Rincian Teknis Keamanan Siber / Password</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-gavel text-slate-400 mt-0.5"></i> <span>Dokumen Penyelidikan Pidana Berjalan</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-file-signature text-slate-400 mt-0.5"></i> <span>Soal Ujian Seleksi Pegawai (Belum Digelar)</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-handshake-slash text-slate-400 mt-0.5"></i> <span>Rahasia Bisnis / Persaingan Tidak Sehat</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Catatan Gudang Data -->
            <div class="mt-8 p-5 bg-blue-50 border border-blue-100 rounded-xl">
                <div class="flex items-start gap-3">
                    <span class="text-xl">📝</span>
                    <div>
                        <h5 class="text-xs font-bold text-blue-900 uppercase mb-1">Catatan Penting: Gudang Data</h5>
                        <p class="text-[11px] text-blue-800 leading-relaxed italic">
                            Kategori <strong>Setiap Saat</strong> adalah Gudang Data. Anda tidak wajib memajang semua file PDF di website. Cukup pastikan judulnya tercatat di <strong>Daftar Informasi Publik (DIP)</strong> yang diunggah di menu <strong>Berkala</strong>. Warga harus mengisi formulir permohonan untuk melihat isinya.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Scroll Hint -->
            <div x-show="!$store.pedomanModal.canClose" class="mt-12 flex flex-col items-center animate-bounce text-slate-400">
                <p class="text-[10px] font-bold uppercase tracking-widest mb-1">Scroll Hingga Bawah</p>
                <i class="fas fa-chevron-down"></i>
            </div>
            
            <div class="h-10"></div>
        </div>

        <!-- Footer -->
        <div class="bg-white p-5 border-t border-slate-100 flex flex-col md:flex-row gap-4 items-center justify-between flex-shrink-0">
            <div class="text-[10px] text-slate-400 font-medium uppercase tracking-wide">
                Patuh UU No. 14 Tahun 2008 & Perki 1/2021
            </div>
            
            <div class="flex gap-3 w-full md:w-auto">
                <button @click="$store.aiAnalisModal.show()" 
                        class="flex-1 md:flex-none px-5 py-3 bg-indigo-50 text-indigo-700 font-bold rounded-xl border border-indigo-100 text-sm flex items-center justify-center gap-2 hover:bg-indigo-100 transition-colors">
                    <i class="fas fa-robot text-base"></i> Tanya AI
                </button>

                <button @click="$store.pedomanModal.close()" 
                        class="flex-1 md:flex-none px-8 py-3 bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-700/20 disabled:opacity-30 text-sm transition-all"
                        :disabled="!$store.pedomanModal.canClose">
                    <span x-text="$store.pedomanModal.canClose ? 'SAYA MENGERTI & LANJUT' : `BACA DAHULU (${$store.pedomanModal.scrollProgress}%)` text-white"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('pedomanModal', {
            open: false,
            canClose: false,
            scrollProgress: 0,
            
            show() { 
                this.open = true; 
                this.canClose = false;
                this.scrollProgress = 0;
            },
            
            close() { 
                if(this.canClose) {
                    this.open = false; 
                }
            },
            
            updateProgress(el) {
                const scrolled = el.scrollTop;
                const totalHeight = el.scrollHeight - el.clientHeight;
                if (totalHeight <= 5) {
                    this.scrollProgress = 100;
                } else {
                    this.scrollProgress = Math.round((scrolled / totalHeight) * 100);
                }
                
                if (this.scrollProgress >= 95) {
                    this.canClose = true;
                }
            }
        })
    })
</script>
