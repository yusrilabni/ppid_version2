<div x-show="$store.pedomanModal.open" x-transition
    class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4" style="display: none;">
    <div class="bg-white w-full max-w-6xl max-h-[90vh] rounded-2xl shadow-2xl flex flex-col">
        <!-- Header -->
        <div
            class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-5 rounded-t-2xl flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-white/20 rounded-full p-3 mr-4">
                    <i class="fas fa-info-circle text-white text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-white">PEDOMAN UMUM KLASIFIKASI INFORMASI PUBLIK</h3>
                    <p class="text-blue-100 text-sm mt-1">(Dengan Contoh Spesifik untuk Admin PPID)</p>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-6 space-y-8"
            @scroll="
                if ($el.scrollTop + $el.clientHeight >= $el.scrollHeight - 5) {
                    $store.pedomanModal.enableClose()
                }
            ">
            <!-- Section I: Prinsip Dasar dan Ringkasan Cepat -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Kolom Kiri: Prinsip Dasar -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-lightbulb text-yellow-500 mr-3 text-xl"></i>
                        I. PRINSIP DASAR (WAJIB DIPAHAMI)
                    </h4>

                    <div class="space-y-4">
                        <div
                            class="flex items-start p-3 rounded-lg hover:bg-blue-50/30 transition-colors border border-transparent hover:border-blue-100">
                            <div
                                class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-tags text-blue-600 text-sm"></i>
                            </div>
                            <div class="pt-1">
                                <p class="text-gray-800">Klasifikasi ditentukan oleh <span
                                        class="font-semibold text-blue-600">jenis informasi</span>, bukan tahun.</p>
                            </div>
                        </div>

                        <div
                            class="flex items-start p-3 rounded-lg hover:bg-blue-50/30 transition-colors border border-transparent hover:border-blue-100">
                            <div
                                class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-exchange-alt text-blue-600 text-sm"></i>
                            </div>
                            <div class="pt-1">
                                <p class="text-gray-800"><span class="font-semibold text-blue-600">Informasi
                                        Berkala</span> tidak berubah menjadi <span
                                        class="font-semibold text-green-600">Setiap Saat</span>.</p>
                            </div>
                        </div>

                        <div
                            class="flex items-start p-3 rounded-lg hover:bg-blue-50/30 transition-colors border border-transparent hover:border-blue-100">
                            <div
                                class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-archive text-blue-600 text-sm"></i>
                            </div>
                            <div class="pt-1">
                                <p class="text-gray-800">Informasi lama menjadi arsip, bukan dipindahkan.</p>
                            </div>
                        </div>

                        <div
                            class="flex items-start p-3 rounded-lg hover:bg-blue-50/30 transition-colors border border-transparent hover:border-blue-100">
                            <div
                                class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-question-circle text-blue-600 text-sm"></i>
                            </div>
                            <div class="pt-1">
                                <p class="text-gray-800">Jika ragu, jangan memutuskan sendiri.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Ringkasan Cepat -->
                <div
                    class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl border border-purple-200 p-6 shadow-sm">
                    <h4 class="text-lg font-bold text-purple-800 mb-4 flex items-center">
                        <i class="fas fa-brain text-purple-500 mr-3 text-xl"></i>
                        RINGKASAN CEPAT
                    </h4>

                    <div class="space-y-3">
                        <div
                            class="bg-white rounded-lg p-3 shadow-xs border border-gray-100 hover:shadow-sm transition-all">
                            <div class="flex items-center">
                                <div
                                    class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-globe-americas text-blue-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800 text-sm">Untuk publik & diumumkan</p>
                                    <p class="text-blue-600 font-semibold text-sm mt-0.5">Berkala</p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="bg-white rounded-lg p-3 shadow-xs border border-gray-100 hover:shadow-sm transition-all">
                            <div class="flex items-center">
                                <div
                                    class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-inbox text-green-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800 text-sm">Untuk internal & diberikan jika diminta
                                    </p>
                                    <p class="text-green-600 font-semibold text-sm mt-0.5">Setiap Saat</p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="bg-white rounded-lg p-3 shadow-xs border border-gray-100 hover:shadow-sm transition-all">
                            <div class="flex items-center">
                                <div
                                    class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-orange-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800 text-sm">Darurat & harus cepat</p>
                                    <p class="text-orange-600 font-semibold text-sm mt-0.5">Serta-Merta</p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="bg-white rounded-lg p-3 shadow-xs border border-gray-100 hover:shadow-sm transition-all">
                            <div class="flex items-center">
                                <div
                                    class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-lock text-gray-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800 text-sm">Berisiko jika dibuka</p>
                                    <p class="text-gray-600 font-semibold text-sm mt-0.5">Dikecualikan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section II: Jenis Informasi & Contohnya -->
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-200">
                    II. JENIS INFORMASI & CONTOHNYA
                </h3>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- A. INFORMASI BERKALA -->
                    <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl border border-blue-200 p-6 shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-calendar-alt text-blue-600 text-lg"></i>
                            </div>
                            <h4 class="text-lg font-bold text-blue-800">A. INFORMASI BERKALA</h4>
                        </div>
                        <p class="text-gray-700 mb-4 text-sm">Informasi yang wajib disediakan dan diumumkan secara rutin (minimal setiap 6 bulan atau 1 tahun sekali) tanpa perlu diminta.</p>
                        
                        <h5 class="text-sm font-semibold text-gray-700 mb-2">Ciri Utama:</h5>
                        <ul class="list-disc list-inside space-y-1 text-sm text-gray-600 mb-4">
                            <li>Informasi tentang kinerja, anggaran, dan kegiatan yang sudah selesai/terealisasi.</li>
                            <li>Bersifat "Ringkasan" atau "Laporan Jadi" yang mudah dipahami publik.</li>
                            <li>Produk hukum/regulasi yang mengikat publik.</li>
                            <li>Wajib "dipajang" (website/papan pengumuman).</li>
                        </ul>

                        <h5 class="text-sm font-semibold text-gray-700 mb-2">Contoh Dokumen:</h5>
                        <ul class="list-disc list-inside space-y-1 text-sm text-gray-600 mb-4">
                            <li>Profil Badan Publik (Struktur, Visi Misi, Tugas & Fungsi).</li>
                            <li>Ringkasan Program Kerja & Anggaran (RKA/DPA).</li>
                            <li>Laporan Keuangan Tahunan (Audited).</li>
                            <li>Laporan Kinerja Instansi (LAKIP/LPPD).</li>
                            <li>Ringkasan Standar Pelayanan (Maklumat, Alur, Tarif, Jadwal).</li>
                            <li>Daftar Peraturan (Perbup, Perda, SK).</li>
                        </ul>

                        <div class="bg-blue-100/30 p-4 rounded-lg border border-blue-200">
                            <p class="text-sm text-gray-700 font-medium">📝 CATATAN PENTING UNTUK ADMIN:</p>
                            <p class="text-xs text-gray-600 mt-1">Jangan meng-upload dokumen mentah yang terlalu tebal di sini. Fokuslah pada dokumen yang "Siap Baca". Jika laporannya 500 halaman, buatlah ringkasan eksekutif atau infografisnya untuk ditampilkan di menu Berkala, sementara dokumen tebalnya disimpan sebagai arsip (Setiap Saat).</p>
                        </div>
                    </div>

                    <!-- B. INFORMASI TERSEDIA SETIAP SAAT -->
                    <div class="bg-gradient-to-br from-green-50 to-white rounded-xl border border-green-200 p-6 shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-clock text-green-600 text-lg"></i>
                            </div>
                            <h4 class="text-lg font-bold text-green-800">B. INFORMASI TERSEDIA SETIAP SAAT</h4>
                        </div>
                        <p class="text-gray-700 mb-4 text-sm">Informasi yang wajib disimpan, didokumentasikan, dan disediakan oleh Badan Publik, serta diberikan hanya jika ada permohonan dari pemohon informasi.</p>

                        <h5 class="text-sm font-semibold text-gray-700 mb-2">Ciri Utama:</h5>
                        <ul class="list-disc list-inside space-y-1 text-sm text-gray-600 mb-4">
                            <li>Merupakan "Dokumen Sumber" atau "Naskah Asli".</li>
                            <li>Bersifat pasif (disimpan di lemari arsip/database, dikeluarkan saat diminta).</li>
                            <li>Berisi detail teknis, administratif, atau bukti pendukung.</li>
                            <li>Dokumen penunjang kebijakan.</li>
                        </ul>

                        <h5 class="text-sm font-semibold text-gray-700 mb-2">Contoh Dokumen:</h5>
                        <ul class="list-disc list-inside space-y-1 text-sm text-gray-600 mb-4">
                            <li>Dokumen Naskah SOP Lengkap (SK SOP, Lampiran Teknis).</li>
                            <li>Daftar Informasi Publik (DIP).</li>
                            <li>Surat Perjanjian Kerja Sama (MoU/PKS).</li>
                            <li>Dokumen Kontrak Pengadaan (SPK/Kontrak).</li>
                            <li>Notula/Catatan Rapat Pimpinan.</li>
                            <li>Surat Masuk dan Surat Keluar (Arsip Umum).</li>
                        </ul>

                        <div class="bg-green-100/30 p-4 rounded-lg border border-green-200">
                                <p class="text-sm text-gray-700 font-medium">📝 CATATAN PENTING UNTUK ADMIN:</p>
                                <p class="text-xs text-gray-600 mt-1">Kategori ini adalah "Gudang Data". Anda tidak wajib memajang semua file PDF SOP atau Kontrak di halaman depan website. Cukup buatkan DAFTAR JUDULNYA saja (DIP). Jika ada warga yang butuh isinya, mereka harus mengisi formulir permohonan informasi terlebih dahulu.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- C. INFORMASI SERTA MERTA -->
                    <div class="bg-gradient-to-br from-orange-50 to-white rounded-xl border border-orange-200 p-6 shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-exclamation-triangle text-orange-600 text-lg"></i>
                            </div>
                            <h4 class="text-lg font-bold text-orange-800">C. INFORMASI SERTA MERTA</h4>
                        </div>
                        <p class="text-gray-700 mb-4 text-sm">Informasi yang wajib diumumkan secara serta merta (seketika) tanpa penundaan karena menyangkut keselamatan dan hajat hidup orang banyak.</p>

                        <h5 class="text-sm font-semibold text-gray-700 mb-2">Ciri Utama:</h5>
                        <ul class="list-disc list-inside space-y-1 text-sm text-gray-600 mb-4">
                            <li>Bersifat mendesak (Urgent).</li>
                            <li>Menyangkut potensi ancaman jiwa, harta benda, atau ketertiban umum.</li>
                            <li>Harus disebarkan masif (Website, Medsos, Speaker Masjid, Radio).</li>
                        </ul>

                        <h5 class="text-sm font-semibold text-gray-700 mb-2">Contoh Dokumen:</h5>
                        <ul class="list-disc list-inside space-y-1 text-sm text-gray-600 mb-4">
                            <li>Peringatan dini bencana alam (Banjir, Longsor, Tsunami).</li>
                            <li>Informasi wabah penyakit menular (Pandemi).</li>
                            <li>Peringatan gangguan layanan vital (Pemadaman Listrik/Air bergilir).</li>
                            <li>Peringatan kerusuhan atau pengalihan arus lalu lintas mendadak.</li>
                        </ul>

                        <div class="bg-orange-100/30 p-4 rounded-lg border border-orange-200">
                                <p class="text-sm text-gray-700 font-medium">📝 CATATAN PENTING UNTUK ADMIN:</p>
                                <p class="text-xs text-gray-600 mt-1">Jangan memasukkan berita kegiatan seremonial (seperti "Bupati Membuka Acara") ke kategori ini. Serta Merta khusus untuk Peringatan Bahaya/Darurat. Jika tidak ada bencana, kategori ini boleh kosong atau berisi informasi kesiapsiagaan.</p>
                        </div>
                    </div>

                    <!-- D. INFORMASI DIKECUALIKAN -->
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-300 p-6 shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-lock text-gray-600 text-lg"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800">D. INFORMASI DIKECUALIKAN</h4>
                        </div>
                        <p class="text-gray-700 mb-4 text-sm">Informasi yang tidak dapat diberikan kepada publik karena dilindungi oleh Undang-Undang (Pasal 17 UU KIP).</p>

                        <h5 class="text-sm font-semibold text-gray-700 mb-2">Ciri Utama:</h5>
                        <ul class="list-disc list-inside space-y-1 text-sm text-gray-600 mb-4">
                            <li>Bersifat Rahasia (Tertutup).</li>
                            <li>Melindungi hak pribadi, persaingan usaha, rahasia negara, atau proses hukum.</li>
                            <li>Wajib melalui Uji Konsekuensi (Ada Berita Acara Pengecualian).</li>
                            <li>Memiliki batas waktu (retensi).</li>
                        </ul>

                        <h5 class="text-sm font-semibold text-gray-700 mb-2">Contoh Dokumen:</h5>
                        <ul class="list-disc list-inside space-y-1 text-sm text-gray-600 mb-4">
                            <li>Data Pribadi (NIK, KK, Rekam Medis, Nomor Rekening Pegawai).</li>
                            <li>Rincian teknis keamanan siber/sandi (Password, Enkripsi).</li>
                            <li>Dokumen penyelidikan tindak pidana yang sedang berjalan.</li>
                            <li>Soal ujian seleksi pegawai yang belum dilaksanakan.</li>
                        </ul>

                        <div class="bg-gray-100/30 p-4 rounded-lg border border-gray-200">
                                <p class="text-sm text-gray-700 font-medium">📝 CATATAN PENTING UNTUK ADMIN:</p>
                                <p class="text-xs text-gray-600 mt-1">Anda tidak boleh menetapkan informasi "Rahasia" hanya berdasarkan perasaan atau perintah lisan atasan. Wajib ada dokumen tertulis bernama "Hasil Uji Konsekuensi" yang ditandatangani PPID. Tanpa dokumen uji tersebut, informasi dianggap terbuka jika disengketakan di Komisi Informasi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-200">
            <div class="flex justify-end items-center">
                <!-- Tanya PPID Button with Hint -->
                <div class="group relative mr-3">
                    <button @click="$store.aiAnalisModal.show()"
                        class="inline-flex items-center px-6 py-3 bg-indigo-500 text-white font-semibold rounded-lg hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class="fas fa-robot mr-2"></i>
                        Tanya PPID?
                    </button>
                    <!-- Tooltip/Hint -->
                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 hidden group-hover:block w-72 p-3 bg-gray-800 text-white text-xs rounded-xl shadow-xl z-50 pointer-events-none">
                        <p class="text-center font-medium">Klik jika Anda bingung menentukan klasifikasi!</p>
                        <p class="mt-1 text-gray-300 text-center">AI akan membantu menganalisa kategori yang tepat berdasarkan judul dokumen Anda.</p>
                        <div class="absolute top-full left-1/2 -translate-x-1/2 border-8 border-transparent border-t-gray-800"></div>
                    </div>
                </div>

                <button x-show="$store.pedomanModal.allowClose" x-transition @click="$store.pedomanModal.close()"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg"
                    style="display: none;">
                    <i class="fas fa-check-circle mr-2"></i>
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>
</div>