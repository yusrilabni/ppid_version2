# Blueprint Fitur "Informasi Pemkab"

## 1. Pendahuluan
Fitur "Informasi Pemkab" adalah sub-menu baru di bawah menu "Transparansi". Fitur ini berfungsi untuk menampilkan dan mengelola dokumen-dokumen milik Pemerintah Kabupaten (Pemkab) berdasarkan kategori dan jenis dokumen.

## 2. Struktur Database
Dibutuhkan tabel baru (atau modifikasi tabel informasi publik jika bisa digabung, namun disarankan tabel terpisah untuk memudahkan manajemen spesifik pemkab).
Nama tabel: `informasi_pemkabs`
Kolom:
- `id` (primary key)
- `judul` (string)
- `kategori` (string) - Contoh: Perencanaan, Keuangan, dll
- `jenis_dokumen` (string) - Contoh: RPJMD, APBD, dll
- `tahun` (integer) - Tahun dokumen
- `deskripsi` (text, nullable)
- `file_path` (string) - Path file yang diupload (PDF, dll)
- `user_id` (unsigned big integer, nullable) - Menyimpan ID admin yang mengupload
- `unit_id` (string/integer, nullable) - Menyimpan ID OPD / Unit dari admin yang mengupload (mengikuti referensi dari `informasis`)
- `created_at`, `updated_at`

*Catatan: Kita akan membuat konstanta kategori dan jenis dokumen di Model atau menggunakan config agar mudah dikelola. Selain itu, pada Model `InformasiPemkab` akan ditambahkan relasi `user()` dan `organization()` layaknya pada model `Informasi` standar.*

## 3. Kategori dan Jenis Dokumen
| No | Kategori | Jenis Dokumen |
|---|---|---|
| 1 | Perencanaan | RPJPD, RPJMD, RKPD, Renstra, Renja, RKA, KUA, PPAS |
| 2 | Keuangan | APBD, APBD Perubahan, DPA, DPPA, LKPD, LRA, LO, Neraca, CaLK, IPKD, Laporan Keuangan |
| 3 | Peraturan dan Kebijakan | Perda, Perbup, Keputusan Bupati, Surat Edaran, Instruksi |
| 4 | Organisasi dan Tata Laksana | SOP, Standar Pelayanan, Maklumat Pelayanan, Peta Proses Bisnis, SOTK |
| 5 | Pelayanan Publik | Formulir, Panduan, Persyaratan, Alur Pelayanan |
| 6 | Kepegawaian | SK, SKP, Diklat, Mutasi, Kenaikan Pangkat |
| 7 | Monitoring, Evaluasi dan Pelaporan | LKjIP, LKPJ, LPPD, SAKIP, Laporan Triwulan, Laporan Tahunan |
| 8 | Pengawasan dan Audit | LHP BPK, LHP Inspektorat, Tindak Lanjut Audit |
| 9 | Kerja Sama | MoU, PKS |
| 10 | Statistik dan Data | Statistik Sektoral, Metadata Statistik, Buku Statistik |
| 11 | Teknologi Informasi | SPBE, Arsitektur SPBE, Masterplan TIK, Keamanan Informasi |
| 12 | Aset Daerah | KIB, Inventaris Barang, Penghapusan Barang |
| 13 | Pengumuman Lainnya | Pengumuman Lainnya |

## 4. Kebutuhan Fitur Admin (Back-End)
### a. Halaman Daftar Dokumen (Index)
- Tabel yang menampilkan daftar dokumen Informasi Pemkab.
- Tombol Tambah, Edit, Hapus.
- Form pencarian dan filter data dasar.
- Route: `/admin/informasi-pemkab`

### b. Halaman Form Tambah/Edit (Create/Edit)
- **Form Fields:**
  - Judul Dokumen (Input Text)
  - Kategori (Select/Dropdown berdasarkan tabel kategori di atas)
  - Jenis Dokumen (Select/Dropdown, opsi akan muncul dan bisa diakses **hanya** jika Kategori sudah dipilih. Jika Kategori kosong, dropdown ini akan terkunci / disabled).
  - Tahun (Input Number)
  - Deskripsi (Textarea / Rich Text Editor)
  - Upload File Dokumen (File Upload - .pdf, .docx, dll)
- *Catatan UI/UX:* Gunakan plugin dropdown kustom yang ada di template (misal Select2) untuk input Kategori dan Jenis Dokumen, jangan gunakan `<select>` bawaan browser. Pastikan `z-index` diatur dengan baik.
- *Referensi Upload:* Menggunakan referensi dari `/admin/galeri/create` atau form `Informasi` standar yang sudah ada.
- Route: `/admin/informasi-pemkab/create` & `/admin/informasi-pemkab/{id}/edit`

## 5. Kebutuhan Fitur Pengunjung (Front-End)
### a. Menu Navigasi
- Tambahkan submenu "Informasi Pemkab" di bawah menu "Transparansi" pada Navigation Bar atau Header.

### b. Halaman Daftar Informasi Pemkab
- Tampilan (UI) mirip dengan halaman daftar dokumen seperti "Informasi Berkala".
- **Filter Pencarian Lengkap (Di bagian atas sebelum daftar dokumen):**
  - Dropdown "Kategori"
  - Dropdown "Jenis Dokumen" (Terkunci/Disabled jika Kategori belum dipilih, list opsinya menyesuaikan Kategori yang dipilih).
  - Dropdown "Tahun" *(Catatan: Filter berdasarkan field `tahun` dokumen, bukan berdasarkan `created_at`)*
  - Input teks untuk pencarian berdasarkan judul (Opsional)
  - Tombol Terapkan Filter
  - *Catatan UI/UX:* Gunakan plugin select custom (seperti Select2 atau plugin custom lain yang ada di template web saat ini) untuk dropdown, jangan menggunakan `<select>` default bawaan browser. Perhatikan pengaturan `z-index` agar dropdown tidak saling tertumpuk dengan elemen lain, dan berikan sedikit penyesuaian gaya agar tampilannya beda/segar namun tetap serasi dengan tema website.
- **Daftar Dokumen:**
  - Menampilkan daftar yang bisa didownload atau dilihat file-nya.
- Route: `/transparansi/informasi-pemkab`

## 6. Langkah Kerja (To-Do)
1. **Migration & Model:** Buat `create_informasi_pemkabs_table` dan model `InformasiPemkab`.
2. **Backend (Admin):** 
   - Buat `InformasiPemkabController` untuk fungsi CRUD admin.
   - Buat View `index`, `create`, `edit` di folder `resources/views/admin/informasi-pemkab/`.
   - Implementasikan Javascript agar opsi "Jenis Dokumen" berubah berdasarkan pilihan "Kategori".
3. **Frontend (Publik):**
   - Buat route publik `/transparansi/informasi-pemkab`.
   - Buat `FrontInformasiPemkabController` untuk melayani halaman depan dan logika filternya.
   - Buat View untuk publik (menyesuaikan tampilan informasi berkala yang sudah ada).
4. **Update Navigasi:** Tambahkan menu di layout frontend (Header/Navbar).
