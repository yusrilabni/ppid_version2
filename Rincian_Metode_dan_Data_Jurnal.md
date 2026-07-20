# Analisis Kelayakan & Panduan Finalisasi Jurnal PPID

Dokumen ini berisi penjelasan detail mengenai metode penulisan jurnal Anda, rincian data yang digunakan di setiap bagian, serta rekomendasi apakah jurnal ini sudah siap untuk dipublikasi (di-submit) atau masih ada yang perlu ditambahkan.

---

## 1. Penjelasan Metode Penulisan: Kuanti, Kuali, atau Campuran?

**Apakah dalam jurnal perlu dituliskan secara eksplisit metodenya?**
**Ya, sangat perlu.** Dalam penulisan artikel ilmiah (jurnal), bagian "Metode Penelitian" wajib mencantumkan jenis pendekatan yang digunakan. Hal ini berfungsi sebagai bukti pertanggungjawaban ilmiah bahwa data Anda tidak dikarang, melainkan diambil melalui prosedur yang terstandar.

**Metode yang digunakan pada Jurnal Anda saat ini adalah:**
*Mixed Methods* (Metode Campuran), lebih spesifiknya **Kombinasi Deskriptif Kuantitatif dan Kualitatif**.
*   **Kuantitatif (Angka):** Anda menggunakan kuesioner dengan Skala Likert (Skor 1-4) untuk mengukur tingkat kepuasan (usability) dan menghitung persentasenya. Anda juga menggunakan perbandingan jumlah data di *database* (sebelum vs sesudah).
*   **Kualitatif (Teks/Narasi):** Anda menggunakan pertanyaan terbuka (esai) di survei untuk menanyakan keluhan pengguna dan usulan fitur baru, lalu merangkumnya menjadi tema-tema masalah (seperti masalah jaringan internet).

Pendekatan ini sangat disukai oleh *reviewer* jurnal (terutama jurnal rumpun IT / Sistem Informasi) karena tidak hanya menyajikan angka kepuasan, tetapi juga menjelaskan *alasan mengapa* angka tersebut muncul.

---

## 2. Rincian Pengambilan Data Per Paragraf / Poin dalam Jurnal

Berikut adalah bedah detail dari mana saja asal usul data yang dimasukkan ke dalam setiap bagian jurnal Anda:

### Bagian 3: Metode Penelitian
*   **Populasi dan Sampel:** Secara eksplisit disebutkan N=31 responden. Data ini diambil dari total admin OPD yang berpartisipasi dalam survei.
*   **Teknik Pengumpulan Data:** Menyebutkan bahwa survei memuat 11 indikator kuantitatif dan pertanyaan terbuka kualitatif.

### Bagian 4.1: Profil Karakteristik Responden
*   **Jabatan (Poin 1):** Diambil dari data demografi kuesioner (48,39% Admin Utama, dsb). Ini membuktikan bahwa yang dinilai adalah opini praktisi langsung, bukan atasan yang tidak menggunakan aplikasi.
*   **Lama Mengelola (Poin 2):** Diambil dari data kuesioner (51,61% di bawah 1 tahun).
*   **Pemahaman Teknologi (Poin 3):** Diambil dari data kuesioner (61,29% Menengah). *Analisis: Ini menjadi dasar alasan mengapa UI/UX yang simpel sangat dibutuhkan.*

### Bagian 4.2: Sebaran Kuantitatif (Tabel 1)
*   Ini adalah urat nadi jurnal Anda. Menampilkan tabel dari 11 indikator pertanyaan dengan sebaran skor 1 hingga 4.
*   **Fokus Data Utama:** Data menunjukkan lonjakan positif pada indikator nomor 2, 9, dan 11 yang mencapai **100% kepuasan/keberhasilan**. Ini adalah nilai jual (novelty) utama dari perbaikan sistem Diskominfo Sinjai.

### Bagian 4.3: Pembahasan Temuan Kritis
Bagian ini menerjemahkan tabel angka ke dalam narasi bahasa manusia:
*   **Paragraf 1 (Error Handling):** Menjelaskan masalah pada indikator nomor 8 (awalnya 100% gagal paham).
*   **Paragraf 2 (UI/UX):** Menjelaskan keberhasilan pada indikator nomor 9 (100% puas dengan antarmuka).
*   **Paragraf 3 (Produktivitas):** Menjelaskan indikator nomor 11 (100% merasa lebih produktif).

### Bagian 4.4: Komparasi Database (Tabel 2)
*   **Sumber Data:** Ini murni dari analisis internal sistem (Dump SQL `ppid-local.sql` vs `ppidkab_version2.sql`).
*   **Tujuan:** Memberikan bukti *hard data* (data sistem) untuk mendukung hasil survei (data persepsi manusia). Menunjukkan peningkatan jumlah pengguna (dari 20 ke 60 akun), restrukturisasi dokumen yang lebih rapi (dari 1.100 menumpuk menjadi 275 terklasifikasi), dsb.

### Bagian 4.5 & 4.6: Analisis Kualitatif & Rekomendasi
*   **Sumber Data:** Diambil dari jawaban teks/esai bebas responden di kuesioner.
*   **Isi:** Mengungkap masalah di luar sistem (seperti jaringan internet yang lambat, dokumen fisik yang belum di-scan) dan melahirkan rekomendasi pengembangan lanjutan (fitur offline mode, aplikasi mobile, dsb).

---

## 3. Apa yang Perlu Anda Lakukan Selanjutnya? (Apakah Sudah Cukup Untuk Publish?)

Secara substansi, **jurnal ini SUDAH SANGAT CUKUP dan LAYAK UNTUK DI-PUBLISH** di jurnal nasional terakreditasi SINTA (seperti SINTA 4, 5, atau 6) untuk bidang Sistem Informasi atau E-Government. Isinya sudah lengkap mulai dari latar belakang, teori, metodologi yang jelas, hasil evaluasi survei (kuanti), evaluasi sistem (database), dan analisis keluhan (kuali).

Namun, ada **2 HAL KECIL** yang biasanya wajib disertakan sebelum Anda menekan tombol *Submit* ke portal jurnal:

### ✅ Tindakan 1: Masukkan Gambar (Screenshot) Aplikasi (Wajib)
Jurnal tentang *Usability* atau evaluasi antarmuka (UI/UX) hampir selalu akan diminta revisi oleh pihak reviewer jika **tidak ada gambar aplikasinya**.
*   **Yang harus Anda lakukan:** Buka file Word Anda (`jurnal.docx`), lalu di bagian "Hasil dan Pembahasan", sisipkan 1 atau 2 gambar/screenshot dari:
    *   Tampilan Dashboard Admin PPID yang baru (untuk membuktikan indikator antarmuka yang dinilai 100% memuaskan).
    *   Tampilan Form Input Dokumen (opsional).
    *   Tampilan Notifikasi Error (jika ada).
*   Berikan *Caption* (Keterangan Gambar) di bawah gambar tersebut (misalnya: *Gambar 1. Antarmuka Dashboard Admin PPID Sinjai*).

### ✅ Tindakan 2: Cek Format *Daftar Pustaka* (Referensi)
*   Pastikan referensi yang ada di daftar pustaka sudah disesuaikan dengan format yang diminta oleh pihak Jurnal (biasanya format APA Style atau IEEE).
*   Saat ini, penulisan daftar pustaka di file Anda sudah cukup rapi. Pastikan saja nama-nama yang ada di Daftar Pustaka benar-benar Anda kutip/sebut namanya di dalam teks paragraf.

### KESIMPULAN FINAL
Jika Anda sudah **memasukkan 1-2 gambar screenshot aplikasi** ke dalam file Word (`jurnal.docx`), maka **JURNAL ANDA SUDAH 100% SIAP PUBLISH!** Anda tidak perlu mengubah narasi atau datanya lagi karena strukturnya sudah sangat kuat dan ilmiah.
