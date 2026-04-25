<div x-show="$store.aiAnalisModal.open" x-transition
    class="fixed inset-0 z-[60] bg-black/50 flex items-center justify-center p-4" style="display: none;">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        .ai-analis-container {
            font-family: 'Inter', sans-serif;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div
        class="bg-[#f3f4f6] w-full max-w-4xl max-h-[90vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden ai-analis-container">

        <header class="w-full bg-white px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="bg-blue-600 p-2 rounded-lg text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">AI Analis Klasifikasi Informasi PPID</h1>
                    <p class="text-gray-500 text-xs mt-0.5">Identifikasi Kategori, Jenis, Sifat, dan Status Dokumen
                        Publik</p>
                </div>
            </div>
            <button @click="$store.aiAnalisModal.close()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </header>

        <main class="flex-1 overflow-y-auto p-6 md:p-8" x-data="aiAnalis()">

            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <form @submit.prevent="analyze()" class="space-y-6">
                    <div>
                        <label for="documentTitle" class="block text-sm font-semibold text-gray-700 mb-2">Judul Dokumen
                            <span class="text-red-500">*</span></label>
                        <input type="text" x-model="title" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Contoh: SK PPTK 2023, Laporan Keuangan 2024, SK Cagar Budaya">
                        <p class="text-xs text-gray-500 mt-2">Ketikkan judul dokumen secara lengkap untuk hasil analisa
                            yang lebih akurat.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="documentYear" class="block text-sm font-semibold text-gray-700 mb-2">Tahun
                                Terbit (Opsional)</label>
                            <input type="number" x-model="year" min="2000" max="2100"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Contoh: 2025">
                        </div>
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex justify-center items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                                Analisa Dokumen
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div x-show="showResult" class="mt-4 pt-4 border-t border-gray-200 fade-in" style="display: none;">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-green-100 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Hasil Analisa Klasifikasi</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-indigo-50 rounded-xl p-5 border border-indigo-100 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 opacity-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-indigo-900"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-indigo-600 uppercase tracking-wider mb-1">Sifat Informasi
                        </h3>
                        <p x-text="result.sifat" class="text-2xl font-bold text-indigo-900 mb-3">-</p>
                        <p class="text-sm text-indigo-800"><span class="font-semibold">Alasan:</span> <span
                                x-text="result.alasanSifat">-</span></p>
                    </div>

                    <div class="bg-blue-50 rounded-xl p-5 border border-blue-100 relative overflow-hidden transition-all duration-300" :class="result.logicType === 'uji_konsekuensi' ? 'ring-2 ring-red-500' : ''">
                        <div class="absolute -right-4 -top-4 opacity-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-blue-900" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-blue-600 uppercase tracking-wider mb-1">Status Dokumen
                        </h3>
                        <div class="flex items-center gap-2 mb-3">
                            <span x-text="result.status" :class="statusBadgeClass"
                                class="px-3 py-1 text-sm font-bold rounded-full border"></span>
                        </div>
                        <p class="text-sm text-blue-800"><span class="font-semibold">Alasan:</span> <span
                                x-text="result.alasanStatus">-</span></p>
                    </div>
                </div>

                <!-- Banner Peringatan Uji Konsekuensi -->
                <div x-show="result.logicType === 'uji_konsekuensi'" x-transition class="mb-6 p-4 bg-red-600 rounded-xl flex items-start gap-4 shadow-lg border-2 border-red-700 fade-in">
                    <div class="bg-white/20 p-2 rounded-lg text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-white font-bold text-lg">PROSEDUR HUKUM WAJIB!</h4>
                        <p class="text-red-50 text-sm leading-relaxed">
                            Dokumen ini masuk dalam kategori informasi yang dikecualikan. Berdasarkan <strong>Pasal 19 UU No. 14 Tahun 2008</strong>, akses terhadap dokumen ini hanya boleh ditutup <strong>setelah</strong> melalui proses Uji Konsekuensi secara tertulis oleh Pejabat Pengelola Informasi dan Dokumentasi (PPID).
                        </p>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-5 bg-gray-50 border-b border-gray-200">
                        <h3 class="font-bold text-gray-800 text-lg">Detail Struktur PPID</h3>
                    </div>

                    <div class="divide-y divide-gray-100">
                        <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="text-sm font-semibold text-gray-500">Kategori Utama</div>
                            <div class="md:col-span-2">
                                <p x-text="result.kategori" class="font-bold text-gray-800 mb-1">-</p>
                                <p class="text-sm text-gray-600"><span
                                        class="font-medium text-gray-700">Alasan:</span> <span
                                        x-text="result.alasanKategori">-</span></p>
                            </div>
                        </div>

                        <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="text-sm font-semibold text-gray-500">Jenis Dokumen</div>
                            <div class="md:col-span-2">
                                <p x-text="result.jenis" class="font-bold text-gray-800 mb-1">-</p>
                                <p class="text-sm text-gray-600"><span
                                        class="font-medium text-gray-700">Alasan:</span> <span
                                        x-text="result.alasanJenis">-</span></p>
                            </div>
                        </div>

                        <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="text-sm font-semibold text-gray-500">Analisa Deskripsi Umum</div>
                            <div class="md:col-span-2">
                                <p x-text="result.deskripsi" class="text-sm text-gray-700 leading-relaxed">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="button" @click="resetForm()"
                        class="text-sm text-gray-500 hover:text-gray-800 transition-colors underline">Reset / Coba
                        Judul Lain</button>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    function aiAnalis() {
        return {
            title: '',
            year: '',
            showResult: false,
            result: {
                sifat: '',
                alasanSifat: '',
                status: '',
                alasanStatus: '',
                kategori: '',
                alasanKategori: '',
                jenis: '',
                alasanJenis: '',
                deskripsi: '',
                logicType: ''
            },
            statusBadgeClass: '',

            knowledgeBase: [
                // 1. INFORMASI DIKECUALIKAN (Revisi Wajib Uji Konsekuensi)
                {
                    id: 'dikecualikan',
                    keywords: ['rahasia', 'dikecualikan', 'intelijen', 'sandi', 'data pribadi', 'rekam medis', 'penyelidikan', 'autopsi'],
                    kategori: 'Daftar Informasi Dikecualikan',
                    jenis: 'Informasi Dikecualikan',
                    sifat: 'Dikecualikan',
                    alasanSifat: 'Wajib melalui Uji Konsekuensi (Pasal 19 UU 14/2008) untuk menentukan apakah informasi ini benar-benar membahayakan kepentingan yang dilindungi.',
                    logicType: 'uji_konsekuensi'
                },
                // 2. INFORMASI SERTA MERTA
                {
                    id: 'sertamerta',
                    keywords: ['bencana', 'darurat', 'peringatan dini', 'wabah', 'gempa', 'banjir', 'tsunami', 'status awas'],
                    kategori: 'Informasi Serta Merta',
                    jenis: 'Informasi Serta Merta',
                    sifat: 'Serta Merta',
                    alasanSifat: 'Menyangkut hajat hidup orang banyak dan keselamatan jiwa yang wajib diumumkan seketika (Pasal 10 UU KIP).',
                    logicType: 'event_based'
                },
                // 3. PENGADAAN BARANG & JASA (Klaster Baru)
                {
                    id: 'pbj_rup',
                    keywords: ['rup', 'rencana umum pengadaan'],
                    kategori: 'Pengadaan Barang/Jasa',
                    jenis: 'Rencana Umum Pengadaan (RUP)',
                    sifat: 'Berkala',
                    alasanSifat: 'Rencana pengadaan wajib diumumkan secara rutin di awal tahun anggaran.',
                    logicType: 'year_based'
                },
                {
                    id: 'pbj_teknis',
                    keywords: ['kontrak', 'kak', 'kerangka acuan kerja', 'hps', 'harga perkiraan sendiri', 'pemenang tender', 'lelang'],
                    kategori: 'Pengadaan Barang/Jasa',
                    jenis: 'Dokumen Teknis & Kontrak',
                    sifat: 'Setiap Saat',
                    alasanSifat: 'Dokumen kontrak dan teknis pengadaan adalah informasi publik yang tersedia setiap saat setelah proses selesai.',
                    logicType: 'year_based'
                },
                // 4. LAYANAN PENGADUAN (Klaster Baru)
                {
                    id: 'pengaduan',
                    keywords: ['rekapitulasi pengaduan', 'statistik pengaduan', 'laporan pengaduan', 'jumlah aduan'],
                    kategori: 'Layanan & Laporan PPID',
                    jenis: 'Statistik Layanan Pengaduan',
                    sifat: 'Berkala',
                    alasanSifat: 'Rekapitulasi jumlah dan status penanganan pengaduan wajib dilaporkan secara berkala.',
                    logicType: 'year_based'
                },
                // 5. DIP / DIK (Klaster Baru)
                {
                    id: 'dip_dik',
                    keywords: ['dip', 'dik', 'daftar informasi publik', 'daftar informasi dikecualikan'],
                    kategori: 'Layanan & Laporan PPID',
                    jenis: 'Daftar Informasi Publik (DIP/DIK)',
                    sifat: 'Berkala',
                    alasanSifat: 'Daftar yang memuat seluruh kategori informasi wajib diperbarui dan diumumkan secara berkala.',
                    logicType: 'year_based'
                },
                // 6. PERENCANAAN
                {
                    id: 'renstra',
                    keywords: ['renstra', 'rpjmd', 'rencana strategis', 'peta jalan', 'roadmap'],
                    kategori: 'Dokumen Strategis',
                    jenis: 'Rencana Strategis',
                    sifat: 'Berkala',
                    alasanSifat: 'Dokumen perencanaan jangka menengah/panjang wajib dipublikasikan berkala.',
                    logicType: 'range_based'
                },
                // 7. KEUANGAN
                {
                    id: 'laporan_keuangan',
                    keywords: ['lra', 'neraca', 'realisasi anggaran', 'calk', 'laporan keuangan', 'rka', 'dpa'],
                    kategori: 'Informasi Keuangan',
                    jenis: 'Laporan Keuangan & Anggaran',
                    sifat: 'Berkala',
                    alasanSifat: 'Ringkasan Laporan Keuangan dan Anggaran wajib diumumkan secara berkala.',
                    logicType: 'year_based'
                },
                // 8. PROFIL & SOP
                {
                    id: 'profil_sop',
                    keywords: ['struktur organisasi', 'sotk', 'visi misi', 'tupoksi', 'sop', 'standar layanan', 'maklumat'],
                    kategori: 'Profil Badan Publik',
                    jenis: 'Profil / Standar Layanan',
                    sifat: 'Berkala',
                    alasanSifat: 'Profil, Struktur, dan SOP Layanan wajib diumumkan berkala agar publik dapat mengakses layanan dengan mudah.',
                    logicType: 'permanent_valid'
                }
            ],

            analyze() {
                const titleInput = this.title.toLowerCase();
                const currentYear = new Date().getFullYear();
                let startYear = null;
                let endYear = null;

                const rangeMatch = titleInput.match(/(19|20)\d{2}\s*(-|s\/d|sampai)\s*(19|20)\d{2}/);
                if (rangeMatch) {
                    const years = rangeMatch[0].match(/\d{4}/g).map(y => parseInt(y));
                    startYear = years[0];
                    endYear = years[1];
                } else {
                    const singleMatch = titleInput.match(/\b(19|20)\d{2}\b/);
                    if (singleMatch) {
                        startYear = parseInt(singleMatch[0]);
                        endYear = startYear;
                    }
                }

                if (this.year) {
                    const manualYear = parseInt(this.year);
                    if (!startYear) {
                        startYear = manualYear;
                        endYear = manualYear;
                    }
                }

                if (!startYear) {
                    startYear = currentYear;
                    endYear = currentYear;
                }

                let bestMatch = null;
                let maxScore = 0;

                for (const rule of this.knowledgeBase) {
                    let score = 0;
                    let matchedCount = 0;
                    for (const keyword of rule.keywords) {
                        if (titleInput.includes(keyword)) {
                            score += 10;
                            matchedCount++;
                            if (keyword.length > 5) score += 5;
                            if (titleInput.startsWith(keyword)) score += 5;
                        }
                    }
                    if (matchedCount > 0 && score > maxScore) {
                        maxScore = score;
                        bestMatch = rule;
                    }
                }

                if (!bestMatch) {
                    bestMatch = {
                        kategori: 'Lainnya',
                        jenis: 'Informasi Umum',
                        sifat: 'Setiap Saat',
                        alasanSifat: 'Dokumen publik pada prinsipnya terbuka dan tersedia setiap saat kecuali diatur lain.',
                        logicType: 'year_based'
                    };
                }

                let status = '';
                let alasanStatus = '';
                let colorClass = '';

                switch (bestMatch.logicType) {
                    case 'uji_konsekuensi':
                        status = 'Wajib Uji Konsekuensi';
                        alasanStatus = 'PERINGATAN: Status dokumen ini HANYA SAH menjadi "Dikecualikan" jika terdapat Surat Keputusan (SK) Uji Konsekuensi yang ditandatangani PPID Utama.';
                        colorClass = 'bg-red-100 text-red-900 border-red-400 ring-2 ring-red-500';
                        break;

                    case 'permanent_valid':
                        if (endYear < currentYear) {
                            status = 'Perlu Verifikasi (Berlaku / Arsip)';
                            alasanStatus = 'Dokumen secara hukum tetap berlaku, KECUALI jika sudah ada pembaruan dokumen dengan judul/substansi serupa pada tahun berjalan (maka otomatis turun menjadi ARSIP).';
                            colorClass = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                        } else {
                            status = 'Berlaku';
                            alasanStatus = 'Ini adalah versi dokumen yang aktif.';
                            colorClass = 'bg-green-100 text-green-800 border-green-200';
                        }
                        break;

                    case 'year_based':
                        if (endYear < currentYear) {
                            status = 'Arsip';
                            alasanStatus = `Dokumen tahun anggaran ${endYear} telah berakhir dan kini berstatus sebagai data sejarah/arsip.`;
                            colorClass = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                        } else {
                            status = 'Berlaku / Berjalan';
                            alasanStatus = `Dokumen operasional aktif untuk tahun anggaran ${currentYear}.`;
                            colorClass = 'bg-blue-100 text-blue-800 border-blue-200';
                        }
                        break;

                    case 'range_based':
                        if (currentYear >= startYear && currentYear <= endYear) {
                            status = 'Berlaku';
                            alasanStatus = `Periode dokumen (${startYear}-${endYear}) masih aktif pada tahun ${currentYear}.`;
                            colorClass = 'bg-green-100 text-green-800 border-green-200';
                        } else {
                            status = 'Arsip';
                            alasanStatus = `Periode masa berlaku dokumen (${startYear}-${endYear}) sudah terlewati.`;
                            colorClass = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                        }
                        break;

                    case 'event_based':
                        status = 'Insidental';
                        alasanStatus = 'Berlaku selama kejadian atau kondisi darurat masih berlangsung.';
                        colorClass = 'bg-orange-100 text-orange-800 border-orange-200';
                        break;

                    default:
                        status = 'Tinjau Manual';
                        alasanStatus = 'Perlu verifikasi kebijakan internal.';
                        colorClass = 'bg-gray-100 text-gray-800 border-gray-200';
                }

                this.result = {
                    sifat: bestMatch.sifat,
                    alasanSifat: bestMatch.alasanSifat,
                    status: status,
                    alasanStatus: alasanStatus,
                    kategori: bestMatch.kategori,
                    alasanKategori: 'Sesuai UU No. 14 Tahun 2008 & Perki No. 1 Tahun 2021.',
                    jenis: bestMatch.jenis,
                    alasanJenis: 'Identifikasi berdasarkan pola judul dokumen.',
                    deskripsi: `Analisis judul "${this.title}" menunjukkan dokumen ini bersifat ${bestMatch.sifat.toUpperCase()} dengan status ${status.toUpperCase()}.`,
                    logicType: bestMatch.logicType
                };
                this.statusBadgeClass = colorClass;
                this.showResult = true;
            },

            resetForm() {
                this.title = '';
                this.year = '';
                this.showResult = false;
            }
        };
    }
</script>
