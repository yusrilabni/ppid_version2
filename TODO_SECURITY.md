# TODO: Keamanan & Rotasi Kredensial

Karena file `.env` sebelumnya sempat ter-push ke repositori publik, semua kredensial yang ada di dalamnya harus dianggap sudah terkompromi. 

**Berikut adalah daftar tugas mendesak yang HARUS DIKERJAKAN saat laptop Anda sudah siap:**

- [ ] **Ganti Password Database**: Ubah kata sandi untuk pengguna database MySQL/MariaDB yang digunakan oleh aplikasi ini (sesuaikan di file `.env`).
- [ ] **Generate Ulang APP_KEY**: Jalankan `php artisan key:generate` di terminal. (Catatan: ini mungkin akan membuat sesi pengguna saat ini ter-logout).
- [ ] **Ganti Password Email / SMTP**: Jika menggunakan layanan pengiriman email (Gmail, Mailtrap, dll), segera ganti password atau buat App Password baru.
- [ ] **Ganti API Keys Pihak Ketiga**: Jika ada kredensial untuk layanan eksternal lain (misalnya API untuk sinkronisasi data dinas/pegawai), segera buat ulang kunci (API key) tersebut.
- [ ] **(Opsional) Bersihkan Riwayat Git**: Setelah semua kredensial diganti, pertimbangkan untuk menggunakan *BFG Repo-Cleaner* atau `git filter-repo` untuk menghapus jejak `.env` secara permanen dari seluruh riwayat komit (git history) di Github.

*File ini dibuat agar Anda tidak lupa langkah-langkah mitigasi yang perlu dilakukan setelah baterai laptop Anda terisi.*
