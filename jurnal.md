# PENGEMBANGAN DAN OPTIMALISASI WEBSITE PPID DALAM MENINGKATKAN USABILITY LAYANAN INFORMASI PUBLIK PADA DISKOMINFO KABUPATEN SINJAI

**Muh. Yusril Abni¹\*, Sudirman²**
¹ Mahasiswa, Politeknik Lembaga Pendidikan dan Pengembangan Profesi Indonesia Makassar, Indonesia
² Dosen Pembimbing, Politeknik Lembaga Pendidikan dan Pengembangan Profesi Indonesia Makassar, Indonesia
\* Penulis Korespondensi: yusrilabni8877@gmail.com

---

## INFO ARTIKEL
*   **Riwayat Artikel**: Received: 06-07-2026; Revised: 06-07-2026; Accepted: 06-07-2026.
*   **Kata Kunci**: *Website PPID, Usability, Informasi Publik, Diskominfo Sinjai, Kepuasan Pengguna.*

---

## ABSTRAK
Keterbukaan informasi publik merupakan pilar utama dalam mewujudkan tata kelola pemerintahan yang bersih dan transparan. Dinas Komunikasi Informatika dan Persandian (Diskominfo) Kabupaten Sinjai melakukan optimalisasi pada website Pejabat Pengelola Informasi dan Dokumentasi (PPID) sebagai peningkatan dari sistem sebelumnya untuk memudahkan penginputan dan publikasi data informasi dari Organisasi Perangkat Daerah (OPD). Penelitian ini bertujuan untuk mengevaluasi *usability* (kemudahan penggunaan) website PPID Kabupaten Sinjai berdasarkan persepsi para operator/admin OPD. Metode penelitian yang digunakan adalah deskriptif kualitatif dan kuantitatif melalui penyebaran kuesioner kepada 28 responden admin PPID pembantu di lingkungan OPD Kabupaten Sinjai. Hasil analisis data menunjukkan bahwa secara umum sistem ini sangat berhasil meningkatkan produktivitas pelaporan (100% responden setuju) dibandingkan sistem sebelumnya dan sangat membantu dalam pengkategorian dokumen secara otomatis (100% responden setuju). Namun, terdapat beberapa temuan kritis terkait aspek *usability*, di antaranya adalah sistem penanganan kesalahan (*error handling*) yang dinilai belum jelas oleh 96,43% responden, serta antarmuka visual (*interface*) yang masih membutuhkan perbaikan (50% menilai cukup/kurang). Rekomendasi utama dari penelitian ini adalah perlunya optimalisasi sistem pesan kesalahan (*error message*), penyediaan fitur monitoring progres kelengkapan dokumen mandiri bagi admin OPD, serta pengembangan fitur pengunggahan luring (*offline upload*) untuk mengatasi kendala kestabilan jaringan internet di daerah.

**ABSTRACT**
*Public information disclosure is a key pillar in achieving clean and transparent governance. The Department of Communication, Informatics, and Media (Diskominfo) of Sinjai Regency optimized the PPID (Information and Documentation Management Officer) website as an upgrade to the previous system to facilitate the entry and publication of information from regional government agencies (OPD). This study aims to evaluate the usability of the Sinjai Regency PPID website based on the perception of OPD operators/admins. The research method used is descriptive qualitative and quantitative by distributing questionnaires to 28 respondents of assistant PPID admins within the Sinjai Regency government. The results of the data analysis show that, in general, this system has successfully increased reporting productivity (100% of respondents agree) compared to the previous system and is highly helpful in automatic document categorization (100% of respondents agree). However, there are some critical findings related to usability aspects, including the error handling system, which was rated as unclear by 96.43% of respondents, and the visual interface, which still needs improvement (50% rated as average/poor). The main recommendations of this study are the need to optimize the error messaging system, provide a self-monitoring feature for document completeness progress for OPD admins, and develop an offline upload feature to overcome internet connection stability constraints in the region.*

---

## 1. PENDAHULUAN
Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik (KIP) mewajibkan setiap badan publik untuk menyediakan, memberikan, dan/atau menerbitkan informasi publik yang berada di bawah kewenangannya kepada pemohon informasi secara cepat, tepat waktu, biaya ringan, dan dengan cara yang sederhana. Dinas Komunikasi Informatika dan Persandian (Diskominfo) Kabupaten Sinjai bertindak sebagai PPID Utama yang bertanggung jawab untuk mengelola dan mempublikasikan data informasi yang dihimpun dari seluruh Organisasi Perangkat Daerah (OPD) selaku PPID Pembantu di Kabupaten Sinjai.

Untuk mendigitalisasi dan mempercepat alur koordinasi serta publikasi berkas informasi publik, Diskominfo Kabupaten Sinjai mengimplementasikan pengembangan dan optimalisasi aplikasi berbasis web PPID sebagai langkah peningkatan layanan dari sistem sebelumnya. Aplikasi ini dirancang agar setiap admin pembantu di masing-masing OPD dapat mengunggah dan mengelola dokumen informasi publik mereka sendiri secara mandiri. Meskipun sistem ini telah diimplementasikan, keberhasilan adopsi teknologi sangat bergantung pada aspek *usability* (ketergunaan) sistem bagi para penggunanya di lapangan. 

Pengguna sistem ini memiliki karakteristik tingkat pemahaman teknologi yang beragam serta rentang pengalaman kelola data yang berbeda. Jika sistem sulit digunakan, memiliki alur yang rumit, atau tidak ramah pengguna (*user-friendly*), maka proses penginputan data informasi publik akan terhambat, yang pada akhirnya akan menurunkan kinerja keterbukaan informasi di Kabupaten Sinjai. 

Berdasarkan latar belakang tersebut, penelitian ini dilakukan untuk menganalisis dan mengukur *usability* website PPID Kabupaten Sinjai berdasarkan pengalaman langsung para admin OPD. Hasil evaluasi ini diharapkan dapat menjadi rujukan ilmiah dan panduan praktis bagi tim pengembang Diskominfo Kabupaten Sinjai dalam melakukan langkah optimalisasi fitur dan antarmuka sistem di masa mendatang.

---

## 2. LANDASAN TEORI
1.  **Usability (Ketergunaan)**: Usability didefinisikan sebagai tingkat kemampuan suatu produk (dalam hal ini aplikasi web) untuk digunakan oleh pengguna tertentu guna mencapai tujuan tertentu secara efektif, efisien, dan memberikan kepuasan dalam konteks penggunaan tertentu (ISO 9241-11). Aspek penting usability meliputi *learnability* (kemudahan dipelajari), *efficiency* (efisiensi alur), *error handling* (penanganan kesalahan), dan *satisfaction* (kepuasan).
2.  **Technology Acceptance Model (TAM)**: Teori penerimaan teknologi yang dikembangkan oleh Davis (1989) menyatakan bahwa penerimaan pengguna terhadap sistem informasi dipengaruhi oleh dua variabel utama: *Perceived Usefulness* (persepsi kemanfaatan) dan *Perceived Ease of Use* (persepsi kemudahan penggunaan).
3.  **Sistem Informasi Pelaporan Publik**: Penerapan teknologi informasi pada sektor pemerintahan (*e-Government*) bertujuan untuk meningkatkan efisiensi internal dan transparansi layanan eksternal kepada masyarakat luas.

---

## 3. METODE PENELITIAN
Penelitian ini menggunakan pendekatan kombinasi deskriptif kuantitatif dan kualitatif.
*   **Populasi dan Sampel**: Responden penelitian berjumlah 28 orang yang merupakan seluruh admin/operator PPID pembantu dari berbagai dinas, badan, kecamatan, kelurahan, dan desa di Kabupaten Sinjai yang aktif menggunakan website PPID.
*   **Pengumpulan Data**: Data dikumpulkan melalui fitur kuesioner internal terintegrasi pada website PPID Kabupaten Sinjai. Kuesioner ini mengukur tanggapan pengguna terhadap alur kerja, verifikasi, antarmuka visual, pesan kesalahan, kecepatan respons, tingkat keamanan, serta peningkatan produktivitas kerja dengan skala Likert (1 hingga 4) dan pertanyaan terbuka terkait kendala serta usulan fitur baru.
*   **Analisis Data**: Data kuantitatif diolah dengan teknik persentase deskriptif untuk mengetahui tingkat kesetujuan responden pada setiap indikator. Data kualitatif dianalisis secara tematik untuk mengelompokkan kendala utama dan kebutuhan fitur baru yang diusulkan oleh responden.

---

## 4. HASIL DAN PEMBAHASAN

### 4.1. Profil Karakteristik Responden
Berdasarkan data yang dihimpun dari 28 responden admin OPD, berikut adalah karakteristik profil pengguna:

1.  **Jabatan/Peran dalam Pengelola PPID**:
    *   Admin Utama OPD / Operator: **50,00%** (14 orang)
    *   Pejabat Fungsional / Struktural: **17,86%** (5 orang)
    *   Lainnya: **32,14%** (9 orang)
    *   *Analisis*: Sebagian besar pengguna aktif di dashboard adalah staf operator teknis yang memegang tanggung jawab langsung dalam input data harian.
2.  **Lama Mengelola Data PPID**:
    *   < 1 Tahun: **57,14%** (16 orang)
    *   1 - 3 Tahun: **21,43%** (6 orang)
    *   > 3 Tahun: **21,43%** (6 orang)
    *   *Analisis*: Mayoritas operator merupakan staf baru (kurang dari 1 tahun), yang menegaskan pentingnya sistem memiliki tingkat kemudahan dipelajari (*learnability*) yang tinggi tanpa perlu pelatihan intensif yang lama.
3.  **Tingkat Pemahaman Teknologi (Self-Assessment)**:
    *   Menengah (Paham web & aplikasi): **64,29%** (18 orang)
    *   Pemula: **35,71%** (10 orang)
    *   *Analisis*: Lebih dari sepertiga pengguna menganggap diri mereka pemula dalam teknologi, sehingga petunjuk penggunaan dan antarmuka sistem harus dirancang sesederhana mungkin.

---

### 4.2. Analisis Dimensi Usability Layanan PPID
Evaluasi usability diukur melalui serangkaian indikator performa sistem yang dinilai oleh responden dengan rentang skor 1 (sangat kurang/tidak setuju) hingga 4 (sangat baik/sangat setuju).

#### Tabel 1. Hasil Evaluasi Indikator Usability Website PPID
| No | Indikator Usability / Pertanyaan Evaluasi | Skor 1 (%) | Skor 2 (%) | Skor 3 (%) | Skor 4 (%) | Interpretasi Kinerja |
|:--:|:---|:---:|:---:|:---:|:---:|:---|
| 1 | Mandiri dalam penginputan pasca Bimbingan Teknis (Bimtek) | 14,29% | 14,29% | 50,00% | 21,43% | Cukup Baik (71,43% setuju) |
| 2 | Kemudahan pengelompokan dokumen otomatis (kategori Berkala/Serta-merta/Setiap Saat) | 0,00% | 0,00% | 60,71% | 39,29% | Sangat Baik (100% setuju) |
| 3 | Keakuratan fitur verifikasi dalam mendeteksi kelengkapan dokumen | 0,00% | 14,29% | 50,00% | 35,71% | Baik (85,71% setuju) |
| 4 | Keringkasan alur kerja (*workflow*) dari login hingga publikasi | 0,00% | 28,57% | 42,86% | 28,57% | Cukup Baik (71,43% setuju) |
| 5 | Kecepatan respons (*loading speed*) saat mengunggah file/link | 0,00% | 28,57% | 46,43% | 25,00% | Cukup (71,43% setuju) |
| 6 | Kemudahan pengelolaan (edit/hapus) data terpublikasi | 0,00% | 25,00% | 53,57% | 21,43% | Baik (75,00% setuju) |
| 7 | Kemudahan memahami menu dan label instruksi di dashboard | 3,57% | 32,14% | 39,29% | 25,00% | Cukup (64,29% setuju) |
| 8 | Kejelasan pesan kesalahan (*error message*) saat input salah | 96,43% | 0,00% | 0,00% | 0,00% | **Sangat Kurang (96,43% menilai tidak jelas)** |
| 9 | Kemudahan visual antarmuka dashboard admin | 0,00% | 50,00% | 25,00% | 25,00% | **Kurang Optimal (50% menilai skor 2)** |
| 10| Tingkat rasa aman penyimpanan dokumen instansi di website | 0,00% | 39,29% | 35,71% | 25,00% | Cukup (60,71% merasa aman) |
| 11| Peningkatan produktivitas dibanding sistem lama | 0,00% | 0,00% | 0,00% | 100%* | **Sangat Baik (100% merasa lebih produktif)** |

*\* Catatan: Pertanyaan produktivitas menggunakan jawaban pilihan tunggal (Ya = 100%).*

---

### 4.3. Pembahasan Temuan Kritis
1.  **Sistem Pesan Kesalahan (Error Handling) yang Buruk (Temuan Utama)**:
    Sebanyak **96,43%** responden memberikan skor terendah (skor 1) pada kejelasan pesan kesalahan yang dimunculkan oleh sistem saat terjadi kekeliruan pengisian. Hal ini menunjukkan bahwa sistem tidak memberikan instruksi perbaikan yang jelas ketika terjadi kegagalan validasi formulir (misalnya format file salah atau ukuran melebihi batas). Dampak dari temuan ini adalah admin OPD mengalami kebingungan dan frustrasi karena harus menebak-nebak letak kesalahan input data mereka.
2.  **Kebutuhan Optimalisasi Tampilan Visual (Dashboard UI)**:
    Sebanyak **50,00%** responden menilai visual antarmuka dengan skor 2 (cukup/kurang). Evaluasi estetika dashboard dinilai kurang membantu fokus kerja operator dalam menginput data secara harian, sehingga memerlukan pembaruan desain antarmuka yang lebih rapi, modern, dan intuitif.
3.  **Peningkatan Produktivitas Kerja**:
    Sisi positif yang sangat menonjol adalah **100%** responden sepakat bahwa keberadaan website PPID hasil optimalisasi yang baru ini meningkatkan produktivitas pelaporan berkas publik mereka secara signifikan dibandingkan sistem pengumpulan manual sebelumnya. Hal ini membuktikan pentingnya kelanjutan operasional aplikasi ini demi efisiensi birokrasi.

---

### 4.4. Analisis Kualitatif Kendala Utama
Melalui pertanyaan terbuka, peneliti mengidentifikasi beberapa kendala utama yang sering dikeluhkan oleh para operator OPD:
1.  **Infrastruktur Jaringan**: Koneksi internet yang tidak stabil dan lambat di lingkungan kantor dinas merupakan penghambat utama ketika melakukan proses pengunggahan file dokumen berukuran besar (PDF).
2.  **Ketersediaan Berkas Fisik**: Berkas-berkas penting yang akan diunggah seringkali masih dalam format fisik, sehingga operator harus meluangkan waktu ekstra untuk memindai (*scan*) dokumen menjadi berkas digital terlebih dahulu.
3.  **Keterbatasan Pemahaman Operator Baru**: Operator baru masih memerlukan pendampingan berkelanjutan dari admin utama Diskominfo Sinjai karena instruksi teks pada antarmuka sistem dinilai masih minim informasi bantu.

---

### 4.5. Usulan Solusi dan Fitur Baru
Untuk meningkatkan usability sistem, responden mengajukan beberapa usulan fitur baru yang dirangkum sebagai berikut:
1.  **Fitur Pemantau Kelengkapan Dokumen Mandiri (Self-Monitoring Progress)**:
    Admin OPD mengharapkan adanya dashboard khusus untuk memantau status persentase kelengkapan dokumen instansi mereka sendiri. Dengan fitur ini, admin OPD dapat mengetahui secara langsung dokumen mana yang belum diunggah atau perlu diperbarui tanpa harus menunggu evaluasi manual dari PPID Utama Diskominfo.
2.  **Integrasi Satu Pintu**:
    Terkoneksinya dashboard PPID secara langsung dengan website internal OPD masing-masing agar operator tidak perlu melakukan proses unggah dokumen yang sama sebanyak dua kali.
3.  **Fitur Sinkronisasi Luring (Offline Mode / Buffer Upload)**:
    Penyediaan fitur yang memungkinkan operator untuk menginput data secara luring (*offline*) terlebih dahulu di kala jaringan buruk, kemudian sistem otomatis mengunggah data tersebut ke server pusat setelah koneksi kembali stabil.

---

## 5. SIMPULAN DAN SARAN

### 5.1. Simpulan
Optimalisasi website PPID oleh Diskominfo Kabupaten Sinjai secara empiris terbukti sukses meningkatkan produktivitas kerja admin OPD dalam melaporkan data keterbukaan informasi publik (100% respon positif) dibandingkan sistem sebelumnya. Sistem pengkategorian dokumen otomatis juga berjalan dengan sangat baik dan memudahkan operator. Namun, dari aspek *usability*, sistem ini masih memiliki kelemahan kritis pada fitur **penanganan kesalahan (error handling)** yang tidak informatif bagi pengguna (96,43% tidak setuju) serta tampilan antarmuka visual dashboard admin yang dirasa kurang mempermudah pekerjaan (50% respon netral/negatif). 

### 5.2. Saran untuk Pengembangan Website PPID
Berdasarkan hasil analisis usability, berikut adalah rekomendasi aksi nyata yang perlu segera dilakukan pada website PPID Kabupaten Sinjai:
1.  **Perbaikan Error Handling**: Memodifikasi sistem validasi formulir agar memberikan notifikasi pesan error yang spesifik dan langsung menunjuk pada elemen input yang bermasalah (misalnya: *"File PDF Anda melebihi batas 2MB, silakan kompres terlebih dahulu"*).
2.  **Pengembangan Dashboard Progress OPD**: Membangun modul pemantauan progres berkas untuk memberikan visualisasi ceklis kelengkapan data wajib masing-masing OPD.
3.  **Optimasi UI/UX Dashboard**: Memperbarui desain visual dashboard admin agar lebih bersih, modern, dan menyertakan panduan petunjuk/tooltip di setiap menu penting.
4.  **Fitur Upload Caching**: Mengembangkan mekanisme penyimpanan lokal sementara (*local storage cache*) untuk memfasilitasi penginputan data saat koneksi internet operator tidak stabil.

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
