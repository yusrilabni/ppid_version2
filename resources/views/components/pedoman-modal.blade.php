<div x-show="$store.pedomanModal.open" x-transition
    class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4" style="display: none;">
    <div class="bg-white w-full max-w-6xl max-h-[90vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden font-sans">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-700 to-indigo-800 px-8 py-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 p-3 rounded-xl text-white">
                    <i class="fas fa-book-open text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-white tracking-tight uppercase">Pedoman Umum Klasifikasi Informasi Publik</h3>
                    <p class="text-blue-100 text-sm font-medium">Standar Operasional Prosedur Penentuan Kategori Dokumen</p>
                </div>
            </div>
            <button @click="$store.pedomanModal.close()" class="text-white/70 hover:text-white transition-colors">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-8 bg-gray-50">
            
            <div class="mb-10">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-r-xl shadow-sm">
                    <h4 class="text-blue-900 font-bold flex items-center gap-2 mb-2">
                        <i class="fas fa-info-circle"></i> 
                        PRINSIP UTAMA
                    </h4>
                    <p class="text-blue-800 text-sm leading-relaxed">
                        Klasifikasi informasi ditentukan berdasarkan <strong>Sifat/Jenis Dokumen</strong>, bukan berdasarkan tahun terbitnya. Dokumen yang bersifat rutin wajib masuk kategori <strong>Berkala</strong>, sedangkan dokumen teknis mendalam disimpan sebagai <strong>Setiap Saat</strong>.
                    </p>
                </div>
            </div>

            <!-- Grid Kategori -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- A. INFORMASI BERKALA -->
                <div class="bg-white rounded-2xl shadow-sm border border-blue-100 flex flex-col">
                    <div class="bg-blue-600 px-6 py-4 flex items-center gap-3">
                        <i class="fas fa-calendar-alt text-white"></i>
                        <h4 class="text-white font-bold uppercase tracking-wider">A. Informasi Berkala</h4>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <p class="text-sm text-gray-600 mb-4">Wajib disediakan dan diumumkan secara rutin tanpa perlu diminta.</p>
                        
                        <div class="space-y-4 flex-1">
                            <div>
                                <h5 class="text-xs font-bold text-blue-600 uppercase mb-2">Contoh Dokumen:</h5>
                                <ul class="text-sm space-y-2 text-gray-700">
                                    <li class="flex items-start gap-2"><span class="text-blue-500">•</span> Profil Badan Publik (Visi, Misi, Struktur)</li>
                                    <li class="flex items-start gap-2"><span class="text-blue-500">•</span> Ringkasan Program & Anggaran (RKA/DPA)</li>
                                    <li class="flex items-start gap-2 font-bold underline text-blue-800"><span class="text-blue-500">•</span> Daftar Informasi Publik (DIP)</li>
                                    <li class="flex items-start gap-2"><span class="text-blue-500">•</span> Laporan Keuangan & Kinerja (LAKIP)</li>
                                    <li class="flex items-start gap-2"><span class="text-blue-500">•</span> Regulasi / Perda / Perbup</li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                            <h5 class="text-xs font-bold text-blue-800 uppercase flex items-center gap-2 mb-1">
                                <span>📝</span> CATATAN PENTING UNTUK ADMIN
                            </h5>
                            <p class="text-xs text-blue-700 leading-relaxed italic">
                                Jangan upload file PDF yang terlalu tebal (ratusan halaman). Gunakan ringkasan eksekutif atau infografis agar mudah dibaca warga.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- B. INFORMASI SETIAP SAAT -->
                <div class="bg-white rounded-2xl shadow-sm border border-green-100 flex flex-col">
                    <div class="bg-green-600 px-6 py-4 flex items-center gap-3">
                        <i class="fas fa-file-invoice"></i>
                        <h4 class="text-white font-bold uppercase tracking-wider">B. Informasi Setiap Saat</h4>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <p class="text-sm text-gray-600 mb-4">Wajib didokumentasikan, namun diberikan hanya jika ada permohonan resmi.</p>
                        
                        <div class="space-y-4 flex-1">
                            <div>
                                <h5 class="text-xs font-bold text-green-600 uppercase mb-2">Contoh Dokumen:</h5>
                                <ul class="text-sm space-y-2 text-gray-700">
                                    <li class="flex items-start gap-2"><span class="text-green-500">•</span> Naskah SOP Lengkap</li>
                                    <li class="flex items-start gap-2"><span class="text-green-500">•</span> Dokumen Kontrak & KAK Pengadaan</li>
                                    <li class="flex items-start gap-2"><span class="text-green-500">•</span> Surat Perjanjian / MoU</li>
                                    <li class="flex items-start gap-2"><span class="text-green-500">•</span> Notula Rapat Internal</li>
                                    <li class="flex items-start gap-2"><span class="text-green-500">•</span> Arsip Surat Masuk & Keluar</li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-green-50 rounded-xl border border-green-200 shadow-sm">
                            <h5 class="text-xs font-bold text-green-800 uppercase flex items-center gap-2 mb-1">
                                <span>📝</span> CATATAN PENTING UNTUK ADMIN
                            </h5>
                            <p class="text-xs text-green-700 leading-relaxed italic">
                                Kategori ini adalah Gudang Data. Anda tidak wajib memajang semua file PDF SOP atau Kontrak di halaman depan website. Cukup pastikan judul dokumen tersebut tercatat di dalam Daftar Informasi Publik (DIP) yang diunggah di menu Berkala. Jika ada warga yang butuh isinya, mereka harus mengisi formulir permohonan informasi terlebih dahulu.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- C. INFORMASI SERTA MERTA -->
                <div class="bg-white rounded-2xl shadow-sm border border-orange-100 flex flex-col">
                    <div class="bg-orange-500 px-6 py-4 flex items-center gap-3">
                        <i class="fas fa-bullhorn"></i>
                        <h4 class="text-white font-bold uppercase tracking-wider">C. Informasi Serta Merta</h4>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <p class="text-sm text-gray-600 mb-4">Wajib diumumkan seketika demi keselamatan jiwa publik.</p>
                        
                        <div class="space-y-4 flex-1">
                            <div>
                                <h5 class="text-xs font-bold text-orange-600 uppercase mb-2">Contoh Dokumen:</h5>
                                <ul class="text-sm space-y-2 text-gray-700">
                                    <li class="flex items-start gap-2"><span class="text-orange-500">•</span> Peringatan Dini Bencana Alam</li>
                                    <li class="flex items-start gap-2"><span class="text-orange-500">•</span> Informasi Wabah Penyakit</li>
                                    <li class="flex items-start gap-2"><span class="text-orange-500">•</span> Gangguan Layanan Vital (Listrik/Air)</li>
                                    <li class="flex items-start gap-2"><span class="text-orange-500">•</span> Darurat Keamanan Masyarakat</li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-orange-50 rounded-xl border border-orange-200">
                            <h5 class="text-xs font-bold text-orange-800 uppercase flex items-center gap-2 mb-1">
                                <span>📝</span> CATATAN PENTING UNTUK ADMIN
                            </h5>
                            <p class="text-xs text-orange-700 leading-relaxed italic">
                                Jangan masukkan berita seremonial. Serta Merta khusus untuk ancaman bahaya/darurat yang butuh respons cepat masyarakat.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- D. INFORMASI DIKECUALIKAN -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 flex flex-col">
                    <div class="bg-gray-700 px-6 py-4 flex items-center gap-3">
                        <i class="fas fa-lock text-white"></i>
                        <h4 class="text-white font-bold uppercase tracking-wider">D. Informasi Dikecualikan</h4>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <p class="text-sm text-gray-600 mb-4">Tertutup karena dilindungi oleh Undang-Undang.</p>
                        
                        <div class="space-y-4 flex-1">
                            <div>
                                <h5 class="text-xs font-bold text-gray-600 uppercase mb-2">Contoh Dokumen:</h5>
                                <ul class="text-sm space-y-2 text-gray-700">
                                    <li class="flex items-start gap-2"><span class="text-gray-500">•</span> Data Pribadi (NIK, Rekam Medis)</li>
                                    <li class="flex items-start gap-2"><span class="text-gray-500">•</span> Detail Keamanan Siber / Sandi</li>
                                    <li class="flex items-start gap-2"><span class="text-gray-500">•</span> Dokumen Proses Hukum yang Berjalan</li>
                                    <li class="flex items-start gap-2"><span class="text-gray-500">•</span> Rahasia Negara / Persaingan Usaha</li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-gray-100 rounded-xl border border-gray-300">
                            <h5 class="text-xs font-bold text-gray-800 uppercase flex items-center gap-2 mb-1">
                                <span>📝</span> CATATAN PENTING UNTUK ADMIN
                            </h5>
                            <p class="text-xs text-gray-700 leading-relaxed italic">
                                Wajib ada dokumen "Hasil Uji Konsekuensi" tertulis. Anda tidak boleh mengunci dokumen hanya berdasarkan perasaan atau perintah lisan.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <div class="bg-white px-8 py-6 border-t border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-2 text-gray-400 text-xs italic">
                <i class="fas fa-balance-scale"></i>
                <span>Berdasarkan UU No. 14 Tahun 2008 & Perki No. 1 Tahun 2021</span>
            </div>
            <div class="flex gap-4">
                <button @click="$store.aiAnalisModal.show()" class="px-6 py-2.5 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-xl transition-all shadow-md flex items-center gap-2">
                    <i class="fas fa-robot text-lg"></i>
                    Tanya AI Analis
                </button>
                <button @click="$store.pedomanModal.close()" class="px-8 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded-xl transition-all shadow-lg">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('pedomanModal', {
            open: false,
            show() { this.open = true; },
            close() { this.open = false; }
        })
    })
</script>
