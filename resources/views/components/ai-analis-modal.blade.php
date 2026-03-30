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

                    <div class="bg-blue-50 rounded-xl p-5 border border-blue-100 relative overflow-hidden">
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
                deskripsi: ''
            },
            statusBadgeClass: '',

            // DATABASE PENGETAHUAN "SEMPURNA" (Sesuai UU KIP & PERKI 1/2021)
            knowledgeBase: [
                // 1. INFORMASI DIKECUALIKAN
                {
                    id: 'dikecualikan',
                    keywords: ['rahasia', 'dikecualikan', 'intelijen', 'sandi', 'data pribadi', 'rekam medis',
                        'penyelidikan', 'autopsi'
                    ],
                    kategori: 'Layanan & Laporan PPID',
                    jenis: 'Daftar Informasi Dikecualikan',
                    sifat: 'Dikecualikan',
                    alasanSifat: 'Sesuai Pasal 17 UU KIP, informasi ini berpotensi membahayakan negara, perlindungan data pribadi, atau proses penegakan hukum.',
                    logicType: 'stateless'
                },
                // 2. INFORMASI SERTA MERTA
                {
                    id: 'sertamerta',
                    keywords: ['bencana', 'darurat', 'peringatan dini', 'wabah', 'gempa', 'banjir', 'tsunami',
                        'status awas'
                    ],
                    kategori: 'Lainnya',
                    jenis: 'Informasi Serta Merta',
                    sifat: 'Serta Merta',
                    alasanSifat: 'Menyangkut hajat hidup orang banyak dan keselamatan jiwa yang wajib diumumkan seketika (Pasal 10 UU KIP).',
                    logicType: 'event_based'
                },
                // 3. PERJANJIAN (KINERJA vs KONTRAK)
                {
                    id: 'pk_kinerja',
                    keywords: ['perjanjian kinerja', 'pk dinas', 'pk kepala', 'sasaran kerja', 'penetapan kinerja',
                        'janji kinerja'
                    ],
                    kategori: 'Kinerja & Strategis',
                    jenis: 'Dokumen Strategis (PK)',
                    sifat: 'Berkala',
                    alasanSifat: 'Merupakan dokumen target/janji kinerja tahunan yang wajib dipublikasikan di awal tahun.',
                    logicType: 'year_based'
                },
                {
                    id: 'mou_kontrak',
                    keywords: ['mou', 'nota kesepahaman', 'perjanjian kerja sama', 'pks', 'kontrak kerja'],
                    kategori: 'Regulasi & Kerja Sama',
                    jenis: 'Perjanjian Kerja Sama / MoU',
                    sifat: 'Setiap Saat',
                    alasanSifat: 'Dokumen kontrak adalah arsip legal. Ringkasannya di Berkala, naskah lengkapnya tersedia Setiap Saat.',
                    logicType: 'contract_based'
                },
                // 4. REGULASI & SK (DIPISAHKAN AGAR AKURAT)
                {
                    id: 'peraturan',
                    keywords: ['peraturan daerah', 'perda', 'peraturan bupati', 'perbup', 'peraturan walikota',
                        'perwali', 'undang-undang', 'pp'
                    ],
                    kategori: 'Regulasi & Kerja Sama',
                    jenis: 'Regulasi & Peraturan',
                    sifat: 'Berkala',
                    alasanSifat: 'Produk hukum yang bersifat mengatur umum (Regeling) wajib diumumkan secara berkala.',
                    logicType: 'permanent_valid' // Selalu Berlaku
                },
                {
                    id: 'sk_kegiatan',
                    keywords: ['sk pptk', 'pejabat pelaksana teknis', 'sk tim', 'sk panitia', 'sk penunjukan',
                        'sk honorarium', 'sk bendahara'
                    ],
                    kategori: 'Regulasi & Kerja Sama',
                    jenis: 'Regulasi & Peraturan (SK Kegiatan)',
                    sifat: 'Setiap Saat',
                    alasanSifat: 'Merupakan SK penetapan personil/administrasi kegiatan internal yang bersifat sementara (ad hoc).',
                    logicType: 'year_based' // Arsip jika tahun lewat
                },
                {
                    id: 'sk_status',
                    keywords: ['penetapan status', 'penetapan cagar budaya', 'penetapan desa wisata',
                        'sk penetapan lokasi'
                    ],
                    kategori: 'Regulasi & Kerja Sama',
                    jenis: 'Regulasi & Peraturan (SK Penetapan)',
                    sifat: 'Setiap Saat',
                    alasanSifat: 'SK Penetapan status hukum melekat pada objek selamanya.',
                    logicType: 'permanent_valid' // Selalu Berlaku
                },
                {
                    id: 'sk_umum',
                    keywords: ['keputusan bupati', 'sk bupati', 'keputusan kepala', 'sk kepala'],
                    kategori: 'Regulasi & Kerja Sama',
                    jenis: 'Regulasi & Peraturan (SK)',
                    sifat: 'Setiap Saat',
                    alasanSifat: 'Surat Keputusan (SK) bersifat penetapan administratif. Naskah aslinya adalah arsip.',
                    logicType: 'sk_context' // Cek Konteks
                },
                // 5. PERENCANAAN
                {
                    id: 'renstra',
                    keywords: ['renstra', 'rpjmd', 'rencana strategis', 'peta jalan', 'roadmap'],
                    kategori: 'Kinerja & Strategis',
                    jenis: 'Dokumen Strategis',
                    sifat: 'Berkala',
                    alasanSifat: 'Dokumen perencanaan jangka menengah/panjang wajib dipublikasikan berkala.',
                    logicType: 'range_based'
                },
                {
                    id: 'renja',
                    keywords: ['renja', 'rencana kerja', 'rkt', 'rencana aksi'],
                    kategori: 'Kinerja & Strategis',
                    jenis: 'Dokumen Strategis',
                    sifat: 'Berkala',
                    alasanSifat: 'Rencana kerja tahunan wajib diumumkan di awal tahun anggaran.',
                    logicType: 'year_based'
                },
                // 6. KEUANGAN
                {
                    id: 'laporan_keuangan',
                    keywords: ['lra', 'neraca', 'realisasi anggaran', 'calk', 'laporan keuangan', 'rka', 'dpa',
                        'anggaran kas'
                    ],
                    kategori: 'Keuangan & Aset',
                    jenis: 'Informasi Keuangan',
                    sifat: 'Berkala',
                    alasanSifat: 'Ringkasan Laporan Keuangan dan Anggaran wajib diumumkan secara berkala.',
                    logicType: 'year_based'
                },
                {
                    id: 'bukti_transaksi',
                    keywords: ['sp2d', 'spm', 'kuitansi', 'buku kas', 'bku', 'spj', 'bukti bayar'],
                    kategori: 'Keuangan & Aset',
                    jenis: 'Informasi Keuangan (Bukti)',
                    sifat: 'Setiap Saat',
                    alasanSifat: 'Dokumen sumber/bukti transaksi detail (raw data) disimpan sebagai arsip.',
                    logicType: 'year_based'
                },
                // 7. PROFIL & SOP
                {
                    id: 'profil_sop',
                    keywords: ['struktur organisasi', 'sotk', 'visi misi', 'tupoksi', 'sop', 'standar layanan',
                        'maklumat', 'alur permohonan'
                    ],
                    kategori: 'Profil & Organisasi',
                    jenis: 'Profil / SOP',
                    sifat: 'Berkala',
                    alasanSifat: 'Profil, Struktur, dan SOP Layanan wajib diumumkan berkala agar publik tahu tanpa bertanya.',
                    logicType: 'permanent_valid'
                },
                // 8. LAINNYA
                {
                    id: 'laporan_kinerja',
                    keywords: ['lkjip', 'lkpj', 'laporan kinerja', 'laporan tahunan'],
                    kategori: 'Kinerja & Strategis',
                    jenis: 'Laporan Kinerja Instansi',
                    sifat: 'Berkala',
                    alasanSifat: 'Laporan pertanggungjawaban wajib diumumkan rutin.',
                    logicType: 'year_based'
                }
            ],

            analyze() {
                const titleInput = this.title.toLowerCase();
                const currentYear = new Date().getFullYear();
                let startYear = null;
                let endYear = null;

                // --- 1. DETEKSI TAHUN (Range & Single) ---
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

                // --- 2. MATCHING CERDAS (Weighted Scoring) ---
                let bestMatch = null;
                let maxScore = 0;

                for (const rule of this.knowledgeBase) {
                    let score = 0;
                    let matchedCount = 0;
                    for (const keyword of rule.keywords) {
                        if (titleInput.includes(keyword)) {
                            score += 10;
                            matchedCount++;
                            if (keyword.length > 5) score += 5; // Keyword panjang lebih berbobot
                            if (titleInput.startsWith(keyword)) score += 5; // Posisi di depan lebih berbobot
                        }
                    }
                    if (matchedCount > 0 && score > maxScore) {
                        maxScore = score;
                        bestMatch = rule;
                    }
                }

                // Fallback
                if (!bestMatch) {
                    bestMatch = {
                        kategori: 'Lainnya',
                        jenis: 'Informasi Umum',
                        sifat: 'Setiap Saat',
                        alasanSifat: 'Tidak ditemukan klasifikasi spesifik. Secara default dokumen publik dianggap terbuka setiap saat.',
                        alasanKategori: 'Dokumen umum.',
                        alasanJenis: 'Dokumen kedinasan umum.',
                        logicType: 'year_based'
                    };
                }

                // --- 3. LOGIKA PENENTUAN STATUS (FINAL - SWITCH CASE) ---
                let status = '';
                let alasanStatus = '';
                let colorClass = '';

                switch (bestMatch.logicType) {
                    case 'permanent_valid':
                        status = 'Berlaku';
                        alasanStatus =
                            'Dokumen ini adalah Regulasi, Penetapan Status Hukum, atau Profil/SOP yang BERLAKU SELAMANYA sampai ada revisi/pencabutan baru, terlepas dari tahun terbitnya.';
                        colorClass = 'bg-green-100 text-green-800 border-green-200';
                        break;

                    case 'year_based':
                        if (endYear < currentYear) {
                            status = 'Arsip';
                            alasanStatus =
                                `Dokumen ini terikat pada Tahun Anggaran ${endYear} yang sudah berakhir/tutup buku.`;
                            colorClass = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                        } else {
                            status = 'Berlaku / Berjalan';
                            alasanStatus = `Dokumen ini relevan untuk operasional tahun berjalan (${currentYear}).`;
                            colorClass = 'bg-blue-100 text-blue-800 border-blue-200';
                        }
                        break;

                    case 'range_based': // Renstra
                        if (currentYear >= startYear && currentYear <= endYear) {
                            status = 'Berlaku';
                            alasanStatus =
                                `Saat ini tahun ${currentYear}, masih berada dalam periode berlaku dokumen (${startYear}-${endYear}).`;
                            colorClass = 'bg-green-100 text-green-800 border-green-200';
                        } else if (currentYear > endYear) {
                            status = 'Arsip';
                            alasanStatus = `Periode berlaku dokumen (${startYear}-${endYear}) sudah berakhir.`;
                            colorClass = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                        } else {
                            status = 'Arsip / Belum Berlaku';
                            alasanStatus = 'Saat ini berada di luar rentang periode berlaku dokumen tersebut.';
                            colorClass = 'bg-gray-100 text-gray-800 border-gray-200';
                        }
                        break;

                    case 'contract_based': // MoU
                        if (endYear < currentYear) {
                            status = 'Arsip';
                            alasanStatus = `Masa berlaku kontrak/MoU tahun ${endYear} dipastikan sudah berakhir.`;
                            colorClass = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                        } else {
                            status = 'Berlaku';
                            alasanStatus = 'Kontrak/MoU diasumsikan masih aktif pada tahun berjalan.';
                            colorClass = 'bg-green-100 text-green-800 border-green-200';
                        }
                        break;

                    case 'sk_context': // SK Umum (Smart Check)
                        if (titleInput.includes('penetapan') || titleInput.includes('status') || titleInput.includes(
                                'cagar budaya')) {
                            status = 'Berlaku';
                            alasanStatus = 'SK Penetapan status hukum suatu objek/situs melekat selamanya (Berlaku).';
                            colorClass = 'bg-green-100 text-green-800 border-green-200';
                        } else {
                            // Asumsi SK Kegiatan Tahunan
                            if (endYear < currentYear) {
                                status = 'Arsip';
                                alasanStatus =
                                    `SK kegiatan/kepanitiaan untuk Tahun Anggaran ${endYear} sudah berakhir.`;
                                colorClass = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                            } else {
                                status = 'Berlaku';
                                alasanStatus = 'SK kegiatan untuk tahun berjalan.';
                                colorClass = 'bg-blue-100 text-blue-800 border-blue-200';
                            }
                        }
                        break;

                    case 'stateless':
                        status = '-';
                        alasanStatus = 'Status Berlaku/Arsip tidak relevan untuk informasi yang dikecualikan.';
                        colorClass = 'bg-red-100 text-red-800 border-red-200';
                        break;

                    case 'event_based':
                        status = 'Insidental';
                        alasanStatus = 'Berlaku selama masa darurat atau insiden berlangsung.';
                        colorClass = 'bg-orange-100 text-orange-800 border-orange-200';
                        break;

                    default:
                        status = 'Tinjau Manual';
                        alasanStatus = 'Perlu verifikasi lebih lanjut.';
                        colorClass = 'bg-gray-100 text-gray-800 border-gray-200';
                }

                // --- 4. RENDER HASIL ---
                this.result = {
                    sifat: bestMatch.sifat,
                    alasanSifat: bestMatch.alasanSifat,
                    status: status,
                    alasanStatus: alasanStatus,
                    kategori: bestMatch.kategori,
                    alasanKategori: bestMatch.alasanKategori || 'Sesuai standar klasifikasi PPID.',
                    jenis: bestMatch.jenis,
                    alasanJenis: bestMatch.alasanJenis || 'Sesuai jenis dokumen yang teridentifikasi.',
                    deskripsi: `Dokumen "${this.title}" teridentifikasi sebagai ${bestMatch.jenis} (${bestMatch.kategori}). Berdasarkan analisis tahun (${startYear === endYear ? startYear : startYear + '-' + endYear}), dokumen ini berstatus ${status.toUpperCase()}. Sifat informasinya adalah ${bestMatch.sifat.toUpperCase()}.`
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
