<div x-show="$store.pedomanModal.open" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 z-[100] bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-4 md:p-8" 
     style="display: none;">
    
    <div class="bg-white w-full max-w-6xl max-h-[90vh] rounded-3xl shadow-2xl flex flex-col overflow-hidden border border-white/20">
        
        <!-- Header Premium -->
        <div class="bg-gradient-to-r from-blue-800 via-indigo-900 to-slate-900 px-8 py-6 relative overflow-hidden">
            <!-- Dekorasi Background -->
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-24 h-24 bg-blue-500/20 rounded-full blur-2xl"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <div class="flex items-center gap-5">
                    <div class="bg-white/15 backdrop-blur-md p-3.5 rounded-2xl border border-white/20 shadow-inner">
                        <i class="fas fa-book-reader text-2xl text-blue-100"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl md:text-3xl font-black text-white tracking-tight leading-tight uppercase">
                            PEDOMAN KLASIFIKASI INFORMASI PUBLIK
                        </h3>
                        <p class="text-blue-200/80 text-sm font-medium flex items-center gap-2 mt-1">
                            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                            Standar Baku Penentuan Kategori Dokumen PPID
                        </p>
                    </div>
                </div>
                
                <!-- Close Button (Only visible if canClose is true) -->
                <button x-show="$store.pedomanModal.canClose" 
                        @click="$store.pedomanModal.close()" 
                        class="bg-white/10 hover:bg-white/20 text-white p-2.5 rounded-xl transition-all"
                        x-transition>
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Progress Bar Reading -->
        <div class="w-full h-1.5 bg-gray-100 overflow-hidden">
            <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 transition-all duration-300" 
                 :style="`width: ${$store.pedomanModal.scrollProgress}%` text-white"></div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-8 bg-slate-50/50 scroll-smooth"
             @scroll="$store.pedomanModal.updateProgress($el)">
            
            <!-- Prinsip Dasar Section -->
            <div class="mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full text-xs font-bold uppercase tracking-widest mb-4">
                    <i class="fas fa-star text-[10px]"></i> Prinsip Utama
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/60">
                        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-3 text-lg">
                            <i class="fas fa-fingerprint"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-800 mb-1">Identitas Dokumen</p>
                        <p class="text-xs text-slate-500 leading-relaxed">Klasifikasi ditentukan oleh <strong>jenis/sifat informasi</strong>, bukan berdasarkan tahun terbit.</p>
                    </div>
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/60">
                        <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-3 text-lg">
                            <i class="fas fa-history"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-800 mb-1">Logika Arsip</p>
                        <p class="text-xs text-slate-500 leading-relaxed">Informasi lama tetap pada kategorinya, hanya <strong>statusnya</strong> yang berubah menjadi <strong>Arsip</strong>.</p>
                    </div>
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/60">
                        <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-3 text-lg">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-800 mb-1">Keamanan Data</p>
                        <p class="text-xs text-slate-500 leading-relaxed">Jangan mengunci data tanpa <strong>Surat Keputusan Uji Konsekuensi</strong> yang sah.</p>
                    </div>
                </div>
            </div>

            <!-- Grid Kategori Card Premium -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                
                <!-- A. INFORMASI BERKALA -->
                <div class="group flex flex-col bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:border-blue-200 transition-all duration-500">
                    <div class="bg-blue-600 px-8 py-6 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white text-xl">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <h4 class="text-white font-black text-lg uppercase tracking-tight">Informasi Berkala</h4>
                        </div>
                        <span class="text-blue-200 text-[10px] font-bold px-2.5 py-1 bg-white/10 rounded-lg uppercase">Wajib Publish</span>
                    </div>
                    <div class="p-8 flex-1 flex flex-col">
                        <p class="text-sm text-slate-500 leading-relaxed mb-6">Wajib diumumkan secara rutin (minimal 6-12 bulan sekali) tanpa perlu diminta oleh warga.</p>
                        
                        <div class="space-y-6 flex-1">
                            <div>
                                <h5 class="text-xs font-black text-blue-600 uppercase tracking-widest mb-3">Daftar Dokumen Lengkap:</h5>
                                <div class="grid grid-cols-1 gap-2.5">
                                    <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl hover:bg-blue-50 transition-colors border border-transparent hover:border-blue-100">
                                        <i class="fas fa-check-circle text-blue-400 mt-0.5"></i>
                                        <span class="text-sm text-slate-700 font-medium">Profil Badan Publik (Visi, Misi, Struktur, Tugas & Fungsi)</span>
                                    </div>
                                    <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl hover:bg-blue-50 transition-colors border border-transparent hover:border-blue-100">
                                        <i class="fas fa-check-circle text-blue-400 mt-0.5"></i>
                                        <span class="text-sm text-slate-700 font-medium">Ringkasan Program Kerja & Anggaran (RKA/DPA/DPA-SKPD)</span>
                                    </div>
                                    <div class="flex items-start gap-3 p-3 bg-blue-100/50 rounded-xl border-2 border-blue-400/30">
                                        <i class="fas fa-star text-blue-600 mt-0.5"></i>
                                        <span class="text-sm text-blue-900 font-black underline italic">Daftar Informasi Publik (DIP) & DIK</span>
                                    </div>
                                    <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl hover:bg-blue-50 transition-colors border border-transparent hover:border-blue-100">
                                        <i class="fas fa-check-circle text-blue-400 mt-0.5"></i>
                                        <span class="text-sm text-slate-700 font-medium">Laporan Keuangan Tahunan Audited & LRA</span>
                                    </div>
                                    <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl hover:bg-blue-50 transition-colors border border-transparent hover:border-blue-100">
                                        <i class="fas fa-check-circle text-blue-400 mt-0.5"></i>
                                        <span class="text-sm text-slate-700 font-medium">Laporan Kinerja Instansi (LAKIP / LPPD / LKPJ)</span>
                                    </div>
                                    <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl hover:bg-blue-50 transition-colors border border-transparent hover:border-blue-100">
                                        <i class="fas fa-check-circle text-blue-400 mt-0.5"></i>
                                        <span class="text-sm text-slate-700 font-medium">Regulasi: Perda, Perbup, & SK yang Mengikat Umum</span>
                                    </div>
                                    <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl hover:bg-blue-50 transition-colors border border-transparent hover:border-blue-100">
                                        <i class="fas fa-check-circle text-blue-400 mt-0.5"></i>
                                        <span class="text-sm text-slate-700 font-medium">Ringkasan Pemenang Tender & RUP Pengadaan</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modern Alert Box -->
                        <div class="mt-8 p-5 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-[1.5rem] border border-blue-100 relative group-hover:scale-[1.02] transition-transform">
                            <div class="absolute -top-3 -right-3 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <h5 class="text-xs font-black text-blue-900 uppercase tracking-tighter mb-1">Tips Admin Cerdas</h5>
                            <p class="text-[11px] text-blue-800 leading-relaxed italic">
                                Jangan upload file PDF mentah yang terlalu tebal. Gunakan ringkasan eksekutif atau infografis agar warga mudah memahami data kinerja Anda.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- B. INFORMASI SETIAP SAAT -->
                <div class="group flex flex-col bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:border-green-200 transition-all duration-500">
                    <div class="bg-green-600 px-8 py-6 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white text-xl">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h4 class="text-white font-black text-lg uppercase tracking-tight">Informasi Setiap Saat</h4>
                        </div>
                        <span class="text-green-200 text-[10px] font-bold px-2.5 py-1 bg-white/10 rounded-lg uppercase">Gudang Data</span>
                    </div>
                    <div class="p-8 flex-1 flex flex-col">
                        <p class="text-sm text-slate-500 leading-relaxed mb-6">Informasi yang wajib disediakan, namun diberikan hanya jika ada permohonan resmi dari warga.</p>
                        
                        <div class="space-y-6 flex-1">
                            <div>
                                <h5 class="text-xs font-black text-green-600 uppercase tracking-widest mb-3">Daftar Dokumen Lengkap:</h5>
                                <div class="grid grid-cols-1 gap-2.5 text-sm">
                                    <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl hover:bg-green-50 transition-colors">
                                        <i class="fas fa-file-pdf text-green-400 mt-1"></i>
                                        <span class="text-slate-700">Naskah Lengkap SOP & Lampiran Teknis Administrasi</span>
                                    </div>
                                    <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl hover:bg-green-50 transition-colors">
                                        <i class="fas fa-file-pdf text-green-400 mt-1"></i>
                                        <span class="text-slate-700">Dokumen Kontrak Pengadaan (SPK/Kontrak/HPS Lengkap)</span>
                                    </div>
                                    <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl hover:bg-green-50 transition-colors">
                                        <i class="fas fa-file-pdf text-green-400 mt-1"></i>
                                        <span class="text-slate-700">Surat Perjanjian Kerja Sama (MoU / PKS Antar Lembaga)</span>
                                    </div>
                                    <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl hover:bg-green-50 transition-colors">
                                        <i class="fas fa-file-pdf text-green-400 mt-1"></i>
                                        <span class="text-slate-700">Surat Keputusan (SK) Jabatan / SK PPTK / SK Panitia</span>
                                    </div>
                                    <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl hover:bg-green-50 transition-colors">
                                        <i class="fas fa-file-pdf text-green-400 mt-1"></i>
                                        <span class="text-slate-700">Bukti Transaksi Keuangan (Kuitansi / Bukti Bayar / SPJ)</span>
                                    </div>
                                    <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl hover:bg-green-50 transition-colors">
                                        <i class="fas fa-file-pdf text-green-400 mt-1"></i>
                                        <span class="text-slate-700">Notula Rapat Pimpinan & Catatan Rapat Internal</span>
                                    </div>
                                    <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl hover:bg-green-50 transition-colors">
                                        <i class="fas fa-file-pdf text-green-400 mt-1"></i>
                                        <span class="text-slate-700">Informasi Kepegawaian & Administrasi Perkantoran</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Premium Note Box -->
                        <div class="mt-8 p-5 bg-gradient-to-br from-green-50 to-emerald-50 rounded-[1.5rem] border border-green-100 shadow-inner group-hover:scale-[1.02] transition-transform">
                            <h5 class="text-xs font-black text-green-900 uppercase flex items-center gap-2 mb-2">
                                <span class="p-1 bg-green-200 rounded-lg">📝</span> CATATAN PENTING
                            </h5>
                            <p class="text-[11px] text-green-800 leading-relaxed italic">
                                Kategori ini adalah Gudang Data. Anda tidak wajib memajang semua file PDF SOP atau Kontrak di halaman depan website. Cukup pastikan judul dokumen tersebut tercatat di dalam <strong>Daftar Informasi Publik (DIP)</strong> yang diunggah di menu Berkala. Jika ada warga yang butuh isinya, mereka harus mengisi formulir permohonan informasi terlebih dahulu.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- C. INFORMASI SERTA MERTA -->
                <div class="group flex flex-col bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:border-orange-200 transition-all duration-500">
                    <div class="bg-orange-500 px-8 py-6 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white text-xl">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <h4 class="text-white font-black text-lg uppercase tracking-tight">Informasi Serta Merta</h4>
                        </div>
                        <span class="text-orange-200 text-[10px] font-bold px-2.5 py-1 bg-white/10 rounded-lg uppercase">Segera</span>
                    </div>
                    <div class="p-8 flex-1 flex flex-col">
                        <p class="text-sm text-slate-500 leading-relaxed mb-6">Wajib diumumkan seketika demi keselamatan jiwa publik.</p>
                        
                        <div class="space-y-6 flex-1">
                            <div>
                                <h5 class="text-xs font-black text-orange-600 uppercase tracking-widest mb-3">Daftar Contoh Dokumen:</h5>
                                <div class="grid grid-cols-1 gap-2.5 text-sm text-slate-700">
                                    <div class="p-3 bg-slate-50 rounded-xl flex items-center gap-3"><i class="fas fa-exclamation-triangle text-orange-400"></i> Peringatan Dini Bencana Alam (Banjir, Gempa, Tsunami)</div>
                                    <div class="p-3 bg-slate-50 rounded-xl flex items-center gap-3"><i class="fas fa-exclamation-triangle text-orange-400"></i> Informasi Darurat Kesehatan (Wabah / Pandemi)</div>
                                    <div class="p-3 bg-slate-50 rounded-xl flex items-center gap-3"><i class="fas fa-exclamation-triangle text-orange-400"></i> Peringatan Gangguan Layanan Vital (Mati Listrik/Air Massal)</div>
                                    <div class="p-3 bg-slate-50 rounded-xl flex items-center gap-3"><i class="fas fa-exclamation-triangle text-orange-400"></i> Pengalihan Arus Lalu Lintas Mendadak / Darurat Keamanan</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 p-5 bg-orange-50 rounded-[1.5rem] border border-orange-100 italic">
                            <p class="text-[11px] text-orange-800 leading-relaxed text-center">
                                Jangan masukkan berita seremonial. Serta Merta khusus untuk ancaman bahaya yang butuh respons cepat masyarakat.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- D. INFORMASI DIKECUALIKAN -->
                <div class="group flex flex-col bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:border-slate-400 transition-all duration-500">
                    <div class="bg-slate-800 px-8 py-6 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white text-xl">
                                <i class="fas fa-lock"></i>
                            </div>
                            <h4 class="text-white font-black text-lg uppercase tracking-tight">Informasi Dikecualikan</h4>
                        </div>
                        <span class="text-slate-400 text-[10px] font-bold px-2.5 py-1 bg-white/5 rounded-lg uppercase">Rahasia</span>
                    </div>
                    <div class="p-8 flex-1 flex flex-col">
                        <p class="text-sm text-slate-500 leading-relaxed mb-6">Informasi yang dilarang diberikan kepada publik karena dilindungi UU (Pasal 17 UU KIP).</p>
                        
                        <div class="space-y-6 flex-1">
                            <div>
                                <h5 class="text-xs font-black text-slate-600 uppercase tracking-widest mb-3">Daftar Contoh Dokumen:</h5>
                                <div class="grid grid-cols-1 gap-2.5 text-sm text-slate-700 font-medium">
                                    <div class="p-3 bg-slate-50 rounded-xl border-l-4 border-slate-400 flex items-center gap-2"><i class="fas fa-user-shield text-slate-400"></i> Data Pribadi (NIK, Rekam Medis, Rekening Bank)</div>
                                    <div class="p-3 bg-slate-50 rounded-xl border-l-4 border-slate-400 flex items-center gap-2"><i class="fas fa-key text-slate-400"></i> Rincian Teknis Keamanan Siber / Sandi / Password</div>
                                    <div class="p-3 bg-slate-50 rounded-xl border-l-4 border-slate-400 flex items-center gap-2"><i class="fas fa-gavel text-slate-400"></i> Dokumen Penyelidikan Pidana yang Sedang Berjalan</div>
                                    <div class="p-3 bg-slate-50 rounded-xl border-l-4 border-slate-400 flex items-center gap-2"><i class="fas fa-file-signature text-slate-400"></i> Soal Ujian Seleksi yang Belum Dilaksanakan</div>
                                    <div class="p-3 bg-slate-50 rounded-xl border-l-4 border-slate-400 flex items-center gap-2"><i class="fas fa-handshake-slash text-slate-400"></i> Rahasia Bisnis / Persaingan Usaha Tidak Sehat</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 p-5 bg-red-50 rounded-[1.5rem] border-2 border-dashed border-red-200 group-hover:bg-red-600 group-hover:border-red-600 transition-all duration-500">
                            <p class="text-[11px] text-red-800 group-hover:text-white leading-relaxed font-black uppercase text-center">
                                WAJIB ADA SK UJI KONSEKUENSI TERULIS!
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Scroll Indicator -->
            <div x-show="!$store.pedomanModal.canClose" class="mt-16 flex flex-col items-center animate-bounce text-slate-300">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] mb-2">Terus Baca Hingga Selesai</p>
                <i class="fas fa-chevron-down text-lg"></i>
            </div>
            
            <div class="h-20"></div> <!-- Spacer -->

        </div>

        <!-- Footer Glassmorphism Style -->
        <div class="bg-white/80 backdrop-blur-md px-8 py-6 border-t border-slate-100 flex flex-col md:flex-row gap-4 items-center justify-between relative z-[110]">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl text-xs">
                    <i class="fas fa-balance-scale"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-slate-400 text-[10px] font-bold tracking-widest uppercase">Kepatuhan Hukum</span>
                    <span class="text-slate-600 text-xs font-medium">UU No. 14 Tahun 2008 & Perki 1/2021</span>
                </div>
            </div>
            
            <div class="flex gap-4 items-center w-full md:w-auto">
                <button @click="$store.aiAnalisModal.show()" 
                        class="flex-1 md:flex-none items-center justify-center gap-3 px-6 py-4 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold rounded-2xl transition-all border border-indigo-200 shadow-sm flex">
                    <i class="fas fa-robot"></i>
                    <span>Tanya AI</span>
                </button>

                <!-- Saya Mengerti Button -->
                <button @click="$store.pedomanModal.close()" 
                        class="group relative flex-1 md:flex-none inline-flex items-center justify-center px-12 py-4 font-black text-white transition-all duration-300 bg-blue-700 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-200 disabled:opacity-40 disabled:cursor-not-allowed overflow-hidden shadow-xl shadow-blue-900/20"
                        :disabled="!$store.pedomanModal.canClose">
                    <div x-show="!$store.pedomanModal.canClose" 
                         class="absolute inset-y-0 left-0 bg-white/20 transition-all duration-300" 
                         :style="`width: ${$store.pedomanModal.scrollProgress}%` text-white"></div>
                    <span class="relative z-10 flex items-center gap-2 whitespace-nowrap">
                        <i class="fas fa-check-circle text-lg" x-show="$store.pedomanModal.canClose"></i>
                        <span x-text="$store.pedomanModal.canClose ? 'SAYA MENGERTI & LANJUT' : `BACA DAHULU (${$store.pedomanModal.scrollProgress}%)` text-white"></span>
                    </span>
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
                
                // Reset scroll position when showing
                setTimeout(() => {
                    const contentArea = document.querySelector('[x-data] .overflow-y-auto');
                    if (contentArea) contentArea.scrollTop = 0;
                }, 100);
            },
            
            close() { 
                if(this.canClose) {
                    this.open = false; 
                }
            },
            
            updateProgress(el) {
                const scrolled = el.scrollTop;
                const totalHeight = el.scrollHeight - el.clientHeight;
                if (totalHeight <= 0) {
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
