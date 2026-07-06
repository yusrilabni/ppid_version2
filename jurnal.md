# PENGEMBANGAN DAN OPTIMALISASI WEBSITE PPID DALAM MENINGKATKAN USABILITY LAYANAN INFORMASI PUBLIK PADA DISKOMINFO KABUPATEN SINJAI

**Muh. Yusril Abni¹\*, Sudirman²**
¹ Mahasiswa, Politeknik Lembaga Pendidikan dan Pengembangan Profesi Indonesia Makassar, Indonesia
² Dosen Pembimbing, Politeknik Lembaga Pendidikan dan Pengembangan Profesi Indonesia Makassar, Indonesia
\* Penulis Korespondensi: yusrilabni8877@gmail.com

---

## INFO ARTIKEL
*   **Riwayat Artikel**: Received: 06-07-2026; Revised: 06-07-2026; Accepted: 06-07-2026.
*   **Kata Kunci**: *Website PPID, Usability, Optimalisasi Sistem, Keterbukaan Informasi, Diskominfo Sinjai.*

---

## ABSTRAK
Keterbukaan informasi publik merupakan pilar utama dalam mewujudkan tata kelola pemerintahan yang bersih, transparan, dan akuntabel. Dinas Komunikasi Informatika dan Persandian (Diskominfo) Kabupaten Sinjai mengimplementasikan langkah optimalisasi dan pembaruan terhadap website Pejabat Pengelola Informasi dan Dokumentasi (PPID) sebagai peningkatan dari sistem web sebelumnya yang dirasa kurang efisien. Penelitian ini bertujuan untuk melakukan evaluasi secara mendalam terhadap aspek *usability* (ketergunaan) website PPID hasil pembaruan tersebut dari sudut pandang admin/operator OPD (Organisasi Perangkat Daerah) selaku kontributor data utama di lapangan. Evaluasi ini menggunakan pendekatan kombinasi kuantitatif deskriptif dan kualitatif. Data dikumpulkan melalui kuesioner terintegrasi kepada 28 responden admin pembantu PPID di lingkungan Pemerintah Kabupaten Sinjai. Hasil analisis kuantitatif menunjukkan peningkatan efisiensi yang sangat baik pada beberapa aspek kunci, antara lain kemudahan kategorisasi dokumen secara otomatis (100% respon positif) dan peningkatan produktivitas kerja secara signifikan dibandingkan website sebelumnya (100% respon setuju). Namun, pengujian usability ini berhasil mendeteksi kelemahan kritis pada aspek penanganan kesalahan (*error handling*), di mana 96,43% responden menilai kejelasan pesan kesalahan (*error message*) saat kegagalan input masih sangat kurang. Selain itu, aspek estetika visual antarmuka dashboard dinilai kurang optimal oleh 50% responden. Hasil penelitian ini memberikan rekomendasi konkret bagi pengembang untuk merancang sistem notifikasi error yang lebih komunikatif, mengimplementasikan dashboard monitoring kelengkapan dokumen mandiri bagi OPD, serta menambahkan fitur *upload caching* (pengunggahan offline) untuk mengantisipasi ketidakstabilan jaringan internet di kantor-kantor daerah.

**ABSTRACT**
*Public information disclosure is a key pillar in achieving clean, transparent, and accountable governance. The Department of Communication, Informatics, and Media (Diskominfo) of Sinjai Regency implemented an optimization and upgrade to the PPID (Information and Documentation Management Officer) website as an improvement from the previous web system which was deemed inefficient. This study aims to conduct an in-depth evaluation of the usability aspects of the upgraded PPID website from the perspective of OPD (Regional Government Agencies) admins/operators as the primary data contributors in the field. This evaluation uses a combined descriptive quantitative and qualitative approach. Data were collected through an integrated questionnaire distributed to 28 assistant PPID admin respondents within the Sinjai Regency Government. The results of the quantitative analysis showed excellent efficiency improvements in several key aspects, including the ease of automatic document categorization (100% positive response) and a significant increase in work productivity compared to the previous website (100% agreement). However, usability testing successfully detected a critical weakness in the error handling aspect, where 96.43% of respondents rated the clarity of error messages during input failure as very poor. In addition, the visual aesthetics of the dashboard interface were deemed less than optimal by 50% of respondents. The results of this study provide concrete recommendations for developers to design more communicative error notification systems, implement self-monitoring dashboards for document completeness for OPDs, and add an upload caching (offline upload) feature to anticipate internet connection instability in regional offices.*

---

## 1. PENDAHULUAN
### 1.1. Latar Belakang Masalah
Keterbukaan informasi publik di Indonesia telah diatur secara formal melalui Undang-Undang Nomor 14 Tahun 2008. Undang-undang ini mengamanatkan setiap badan publik, baik di tingkat pusat maupun daerah, untuk membuka akses informasi yang dikelolanya kepada masyarakat. Di tingkat Kabupaten Sinjai, Dinas Komunikasi Informatika dan Persandian (Diskominfo) mengemban tugas sebagai PPID Utama yang bertugas menyinkronkan, memvalidasi, dan mempublikasikan dokumen informasi publik yang dikirim oleh seluruh Organisasi Perangkat Daerah (OPD) selaku PPID Pembantu.

Sebelumnya, Diskominfo Kabupaten Sinjai telah menyediakan platform website PPID awal. Namun, berdasarkan evaluasi internal, website sebelumnya tersebut memiliki berbagai kelemahan mendasar. Beberapa kendala utama pada website lama meliputi:
1.  **Klasifikasi Manual yang Rentan Salah**: Operator OPD harus mengidentifikasi dan memilih kategori klasifikasi informasi (Informasi Berkala, Serta-merta, atau Setiap Saat) secara manual tanpa adanya panduan sistem. Hal ini sering mengakibatkan kesalahan penempatan dokumen yang tidak sesuai dengan regulasi Komisi Informasi.
2.  **Ketiadaan Fitur Validasi**: Sistem lama tidak memiliki fungsi verifikasi kelengkapan atribut (seperti nomor surat, tanggal terbit, tipe dokumen) sebelum pengunggahan, sehingga PPID Utama seringkali menerima dokumen yang tidak lengkap dan harus dikembalikan secara manual melalui sarana komunikasi luar jaringan.
3.  **Responsivitas dan Antarmuka yang Kaku**: Antarmuka dashboard operator lama dirasa membingungkan dan memiliki performa *loading* yang lambat saat mengunggah berkas PDF berukuran besar.

Menyikapi keterbatasan tersebut, Diskominfo Kabupaten Sinjai merancang langkah pembaruan dengan mengoptimalkan dan meningkatkan fungsionalitas website PPID. Website hasil pembaruan ini mengintegrasikan pengelompokan dokumen otomatis dan fitur validasi instan. Namun, efektivitas pembaruan teknologi ini di lapangan sangat bergantung pada tingkat *usability* (ketergunaan) sistem dari sisi pengguna akhir, yaitu para operator OPD. 

### 1.2. Tujuan Penelitian
Penelitian ini bertujuan untuk:
1.  Mengukur tingkat *usability* website PPID Kabupaten Sinjai yang telah dioptimalkan berdasarkan perspektif operator OPD.
2.  Mengidentifikasi temuan kritis dan kendala teknis yang masih dihadapi operator selama menggunakan website hasil pembaruan.
3.  Merumuskan rekomendasi perbaikan fitur yang aplikatif bagi tim teknis Diskominfo Sinjai demi kelancaran pelayanan informasi publik.

---

## 2. LANDASAN TEORI
### 2.1. Usability (Ketergunaan)
Menurut standar **ISO 9241-11 (2018)**, *usability* adalah sejauh mana suatu produk, sistem, atau layanan dapat digunakan oleh pengguna tertentu untuk mencapai tujuan tertentu dengan efektif, efisien, dan memuaskan dalam konteks penggunaan yang ditentukan. Usability bukan hanya tentang fungsionalitas sistem yang berjalan tanpa error, melainkan bagaimana sistem tersebut berinteraksi secara harmonis dengan kapasitas kognitif manusia. Jakob Nielsen (1993) menguraikan rekayasa kegunaan (*usability engineering*) ke dalam beberapa komponen utama, antara lain:
*   *Learnability*: Kemudahan pengguna awam untuk memahami alur dasar sistem saat pertama kali berinteraksi.
*   *Efficiency*: Kecepatan pengguna dalam menyelesaikan tugas (*tasks*) setelah mereka terbiasa dengan antarmuka.
*   *Error Handling*: Kemampuan sistem dalam mencegah kesalahan input, memberikan pesan error yang jelas, dan menuntun pengguna memulihkan kesalahan tersebut (*error recovery*).
*   *Satisfaction*: Penilaian subjektif pengguna mengenai kenyamanan dan estetika visual antarmuka sistem.

### 2.2. Technology Acceptance Model (TAM)
**Technology Acceptance Model (TAM)** yang diperkenalkan oleh Davis (1989) adalah salah satu model penerimaan teknologi yang paling banyak divalidasi. TAM berasumsi bahwa minat dan perilaku pengguna untuk mengadopsi suatu sistem informasi dipengaruhi oleh dua variabel persepsi:
1.  *Perceived Usefulness* (Persepsi Kebermanfaatan): Tingkat keyakinan seseorang bahwa penggunaan sistem akan meningkatkan performa dan produktivitas kerjanya.
2.  *Perceived Ease of Use* (Persepsi Kemudahan Penggunaan): Tingkat keyakinan seseorang bahwa penggunaan sistem tidak memerlukan usaha yang berat atau bebas dari kesulitan teknis.

Dalam konteks penelitian ini, TAM digunakan untuk menganalisis hubungan antara fitur-fitur baru yang telah dioptimalkan pada website PPID (seperti kategorisasi otomatis) dengan produktivitas kerja admin OPD.

---

## 3. METODE PENELITIAN
### 3.1. Desain Penelitian dan Responden
Penelitian ini menggunakan metode kombinasi deskriptif kuantitatif dan kualitatif. Penelitian dilakukan di lingkungan Pemerintah Kabupaten Sinjai. Responden dalam penelitian ini berjumlah 28 orang (N = 28), yang merupakan seluruh populasi admin/operator PPID pembantu dari dinas, badan, kecamatan, kelurahan, dan desa di Kabupaten Sinjai yang secara aktif menginput berkas ke website PPID.

### 3.2. Instrumen Pengumpulan Data
Data dikumpulkan secara elektronik menggunakan modul survei terintegrasi pada aplikasi website PPID Kabupaten Sinjai. Instrumen survei dirancang menggunakan 11 butir pertanyaan skala Likert berbobot 1 hingga 4 (1 = Sangat Kurang/Tidak Setuju, 2 = Kurang/Cukup, 3 = Baik/Setuju, 4 = Sangat Baik/Sangat Setuju) untuk menangkap data kuantitatif, serta 2 pertanyaan terbuka untuk menghimpun data kualitatif mengenai keluhan operasional dan usulan fitur.

### 3.3. Teknik Analisis Data
Data kuantitatif dianalisis secara statistik deskriptif dengan menghitung persentase sebaran jawaban responden pada masing-masing indikator. Data kualitatif dianalisis menggunakan metode analisis interaktif **Miles, Huberman, & Saldaña (2014)** yang meliputi kondensasi data (pemilahan data mentah esai), penyajian data dalam bentuk poin-poin kesimpulan, dan verifikasi kesimpulan akhir.

---

## 4. HASIL DAN PEMBAHASAN

### 4.1. Analisis Karakteristik Responden
Analisis profil responden (N = 28) menggambarkan latar belakang pengguna website PPID sebagai berikut:
1.  **Peran/Jabatan**: Sebanyak 50,00% (14 orang) adalah Admin Utama OPD/Operator teknis, 17,86% (5 orang) adalah Pejabat Fungsional/Struktural, dan 32,14% (9 orang) memegang peran lainnya. Hal ini mengonfirmasi bahwa mayoritas pengakses dashboard adalah staf tingkat operator yang bersentuhan langsung dengan aktivitas input data berkas.
2.  **Masa Pengelolaan Data PPID**: Sebanyak 57,14% (16 orang) memiliki masa kerja kurang dari 1 tahun, 21,43% (6 orang) antara 1-3 tahun, dan 21,43% (6 orang) lebih dari 3 tahun. Tingginya persentase operator baru (di atas 50%) menuntut sistem memiliki tingkat *learnability* yang sangat ramah terhadap pengguna pemula.
3.  **Tingkat Pemahaman Teknologi (Self-Assessment)**: Mayoritas responden menilai kemampuan teknologi mereka berada pada tingkat Menengah (*Intermediate*) sebesar 64,29% (18 orang), sedangkan 35,71% (10 orang) masih mengkategorikan diri mereka sebagai Pemula (*Beginner*).

---

### 4.2. Sebaran Kuantitatif Indikator Usability
Pengukuran tingkat *usability* website PPID hasil pembaruan disajikan secara rinci pada tabel di bawah ini:

#### Tabel 1. Distribusi Respon Evaluasi Usability Website PPID (N = 28)
| No | Indikator Usability yang Dievaluasi | Skor 1 (n / %) | Skor 2 (n / %) | Skor 3 (n / %) | Skor 4 (n / %) | Total Respon Setuju (Skor 3+4) |
|:--:|:---|:---:|:---:|:---:|:---:|:---:|
| 1 | Kemandirian mengunggah dokumen pasca mengikuti Bimbingan Teknis (Bimtek) | 4 (14,29%) | 4 (14,29%) | 14 (50,00%) | 6 (21,43%) | **71,43%** |
| 2 | Kemanfaatan fitur pengelompokan dokumen otomatis (kategori Berkala/Serta-merta/Setiap Saat) | 0 (0,00%) | 0 (0,00%) | 17 (60,71%) | 11 (39,29%) | **100,00%** |
| 3 | Keakuratan verifikasi kelengkapan atribut dokumen yang diinput | 0 (0,00%) | 4 (14,29%) | 14 (50,00%) | 10 (35,71%) | **85,71%** |
| 4 | Keringkasan alur kerja (*workflow*) penginputan dari login hingga publikasi | 0 (0,00%) | 8 (28,57%) | 12 (42,86%) | 8 (28,57%) | **71,43%** |
| 5 | Kecepatan respons (*loading speed*) server saat unggah file/link PDF | 0 (0,00%) | 8 (28,57%) | 13 (46,43%) | 7 (25,00%) | **71,43%** |
| 6 | Kemudahan dalam mengelola (edit/hapus) data informasi yang sudah terbit | 0 (0,00%) | 7 (25,00%) | 15 (53,57%) | 6 (21,43%) | **75,00%** |
| 7 | Kemudahan memahami petunjuk menu dan label instruksi pada dashboard | 1 (3,57%) | 9 (32,14%) | 11 (39,29%) | 7 (25,00%) | **64,29%** |
| 8 | Kejelasan pesan kesalahan (*error message*) ketika terjadi kegagalan input | 27 (96,43%) | 0 (0,00%) | 0 (0,00%) | 0 (0,00%)* | **3,57%** |
| 9 | Kenyamanan estetika tampilan antarmuka visual dashboard admin | 0 (0,00%) | 14 (50,00%) | 7 (25,00%) | 7 (25,00%) | **50,00%** |
| 10| Tingkat jaminan keamanan penyimpanan dokumen OPD pada server website | 0 (0,00%) | 11 (39,29%) | 10 (35,71%) | 7 (25,00%) | **60,71%** |
| 11| Peningkatan produktivitas kerja pelaporan berkas dibanding website sebelumnya | 0 (0,00%) | 0 (0,00%) | 0 (0,00%) | 28 (100%)** | **100,00%** |

*\*Catatan: 1 responden menjawab "Tidak" (di luar skala 1-4).*
*\*\*Catatan: Indikator produktivitas diukur menggunakan pilihan biner Ya/Tidak (Ya = 100%).*

---

### 4.3. Pembahasan Temuan Kritis Evaluasi Usability
Berdasarkan data kuantitatif pada Tabel 1, peneliti memetakan tiga aspek temuan kritis yang harus segera ditindaklanjuti oleh pengembang sistem:

1.  **Kegagalan Sistem Penanganan Kesalahan (Error Handling)**:
    Temuan paling kritis dalam penelitian ini ditunjukkan oleh indikator kejelasan pesan kesalahan (Poin 8). Sebanyak **96,43%** (27 dari 28 operator) memberikan penilaian terendah (Skor 1). Ketika sistem mendeteksi kegagalan input (seperti ukuran dokumen melebihi batas atau ekstensi tidak valid), sistem tidak menampilkan notifikasi kesalahan yang deskriptif. Hal ini bertentangan dengan teori *Usability Engineering* Jakob Nielsen yang menekankan pentingnya komunikasi sistem yang jelas untuk membantu pengguna mengenali, mendiagnosis, dan memulihkan diri dari kesalahan (*error recovery*). Ketiadaan panduan error menyebabkan operator menghabiskan banyak waktu secara tidak efisien untuk mencoba-coba input kembali tanpa mengetahui letak kesalahan pasti.
2.  **Desain Antarmuka Visual (UI/UX) Kurang Ergonomis**:
    Indikator kepuasan visual dashboard (Poin 9) menunjukkan bahwa **50,00%** (14 orang) responden memberikan penilaian netral/rendah (Skor 2). Antarmuka dashboard admin saat ini dinilai kurang ergonomis dan belum sepenuhnya memfasilitasi kenyamanan mata operator saat mengelola data dalam waktu lama. Pembenahan desain dengan menerapkan warna kontras yang ramah mata dan pengaturan tata letak informasi yang lebih teratur sangat diperlukan.
3.  **Peningkatan Produktivitas Kerja Pengguna**:
    Di sisi lain, berdasarkan variabel *Perceived Usefulness* pada teori TAM (Davis, 1989), website hasil optimalisasi ini terbukti sukses memberikan manfaat nyata. Sebanyak **100,00%** (28 responden) menyatakan bahwa mereka jauh lebih produktif mengunggah dokumen menggunakan website baru ini dibandingkan website sebelumnya. Keberhasilan ini didorong oleh fungsionalitas baru seperti **fitur pengkategorian dokumen otomatis** (meraih 100% respon positif pada Poin 2), yang menghemat waktu berpikir operator dalam menentukan kategori hukum berkas (Berkala, Serta-merta, atau Setiap Saat).

---

### 4.4. Analisis Keluhan Kualitatif Operator
Melalui pertanyaan terbuka, diidentifikasi beberapa kendala utama yang dirasakan operator OPD saat mengoperasikan website PPID Kabupaten Sinjai:
1.  **Masalah Kestabilan Akses Jaringan Internet**:
    Sebagian besar kantor OPD di Kabupaten Sinjai mengalami keterbatasan kecepatan dan kestabilan koneksi internet. Ketika operator harus mengunggah file dokumen PDF berukuran besar, sistem sering mengalami *timeout* atau gagal di tengah proses pengunggahan.
2.  **Kurangnya Arsip Digital Siap Unggah**:
    Operator seringkali menerima berkas dalam bentuk dokumen fisik (*hardcopy*) dari sub-bagian kerja di OPD mereka, sehingga harus melakukan pemindaian (*scanning*) manual terlebih dahulu sebelum diunggah ke website PPID.
3.  **Prosedur Koordinasi Evaluasi Kelengkapan**:
    Operator tidak memiliki cara untuk melihat apakah dokumen yang mereka unggah sudah memenuhi standar PPID Utama secara mandiri. Mereka harus menunggu konfirmasi manual via aplikasi WhatsApp atau surat dari Diskominfo.

---

### 4.5. Rekomendasi Aksi Pembenahan Website PPID
Untuk meningkatkan usability sistem, dirumuskan beberapa rekomendasi peningkatan fitur sebagai berikut:
1.  **Implementasi Pesan Error Informatif (Notifikasi Validasi)**:
    Mengganti pesan error sistem yang kosong dengan teks notifikasi yang jelas dan terarah (contoh: *"Pengunggahan gagal. Format berkas wajib PDF dan ukuran maksimal adalah 2 MB. Silakan kompres berkas Anda"*).
2.  **Pembangunan Dashboard Monitoring Progres Dokumen Mandiri (OPD Progress Dashboard)**:
    Menyediakan diagram persentase atau ceklis kelengkapan berkas wajib pada halaman dashboard admin pembantu. Fitur ini memungkinkan setiap admin OPD memantau status dokumen mana saja yang belum lengkap atau sudah kedaluwarsa secara mandiri tanpa menunggu evaluasi manual dari PPID Utama Diskominfo.
3.  **Mekanisme Cache Penyimpanan Sementara (Offline Mode Upload)**:
    Mengembangkan fitur penyimpanan data lokal sementara (*client-side caching*) berbasis browser. Fitur ini memungkinkan operator tetap menginput data secara luring (*offline*) saat internet terputus, dan data tersebut akan diunggah otomatis ke server ketika jaringan kembali stabil.

---

## 5. SIMPULAN DAN SARAN

### 5.1. Simpulan
Optimalisasi website PPID oleh Diskominfo Kabupaten Sinjai secara empiris terbukti sukses meningkatkan produktivitas pelaporan berkas informasi publik (100% respon positif) dibandingkan website sebelumnya. Fitur klasifikasi berkas otomatis sangat mempermudah efisiensi kerja operator OPD. Namun, dari segi ketergunaan (*usability*), website ini masih memiliki kelemahan kritis utama pada aspek **penanganan kesalahan (error handling)** yang dinilai tidak informatif (96,43% respon negatif) serta tampilan estetika visual antarmuka dashboard yang perlu ditingkatkan (50% respon kurang puas).

### 5.2. Saran
Berdasarkan temuan di atas, disarankan kepada tim teknis Diskominfo Kabupaten Sinjai untuk:
1.  Melakukan pembaruan kode pada sisi penanganan error validasi agar menampilkan pesan kesalahan yang eksplisit di antarmuka operator.
2.  Mendesain ulang antarmuka visual dashboard admin pembantu agar lebih bersih, modern, dan menyertakan tooltip panduan interaktif.
3.  Membangun modul mandiri pemantau kelengkapan dokumen (*OPD Progress Check*) guna mempercepat alur evaluasi data berkas.

---

## DAFTAR PUSTAKA
1.  **Bakhri, S., Haidir, A., & Simamora, S. S. (2025)**. Evaluasi Usability Website PPID Kabupaten Bogor dengan Metode System Usability Scale (SUS) di Diskominfo Kabupaten Bogor. *JISAMAR (Journal of Information System, Applied, Management, Accounting and Research)*, 9(4), 512-520.
2.  **Davis, F. D. (1989)**. Perceived Usefulness, Perceived Ease of Use, and User Acceptance of Information Technology. *MIS Quarterly*, 13(3), 319-340.
3.  **ISO 9241-11. (2018)**. *Ergonomics of human-system interaction — Part 11: Usability: Definitions and concepts*. Geneva: International Organization for Standardization.
4.  **Miles, M. B., Huberman, A. M., & Saldaña, J. (2014)**. *Qualitative Data Analysis: A Methods Sourcebook* (3rd ed.). Thousand Oaks, CA: Sage Publications.
5.  **Nielsen, J. (1993)**. *Usability Engineering*. Boston: Academic Press.
6.  **Peraturan Komisi Informasi Nomor 1 Tahun 2021** tentang Standar Layanan Informasi Publik.
7.  **Pratama, I. P. A. (2014)**. *Handbook E-Government*. Bandung: Informatika.
8.  **Sadewa, M. Y., Sujaya, M. A. P., Gunawan, I M. A. O., & Indrawan, G. (2024)**. Evaluasi Pengalaman Pengguna Website PPID Undiksha Dengan Metode User Experience Questionnaire (UEQ). *INSERT: Information System and Emerging Technology Journal*, 5(1), 12-21. DOI: https://doi.org/10.23887/insert.v5i1.70383.
9.  **Undang-Undang Republik Indonesia Nomor 14 Tahun 2008** tentang Keterbukaan Informasi Publik.
