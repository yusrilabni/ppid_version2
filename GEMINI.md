# Instruksi Proyek PPID Version 2

## Batasan Operasional
- **HANYA** edit file di dalam folder `production_deployment/ppid_version2`.
- **DILARANG** menyentuh atau mengedit file apa pun di folder root `ppid_laravel`. File di sana hanya boleh dibaca sebagai referensi.
- Gunakan **Bahasa Indonesia** untuk semua komunikasi dan jawaban.

## Alur Kerja Git
- Setelah melakukan perubahan kode, jalankan perintah berikut dalam satu baris:
  `git add . && git status && git push`

## Kebijakan Penyaringan File Sebelum Push (Git Hygiene)
- **DILARANG** meng-commit atau me-push file/folder uji coba sementara, skrip scratch, atau dump data tes AI (contoh: skrip `.ps1`, file dump `models.json`, file teks output sementara).
- **Pengecualian Fitur Resmi AI:** File kode sumber yang merupakan bagian dari fitur resmi aplikasi (seperti `AiSettingController.php`, Model `AiSetting`, Migration resmi) **tetap di-upload**.
- **Pengecualian Tes Production:** File uji coba (seperti file `.php` mandiri) HANYA boleh di-push jika memang ada instruksi khusus untuk diuji di server *production*. Jika tidak diharuskan, jangan pernah di-upload ke Git.
- Sebelum menjalankan `git add .` dan `git push`, selalu lakukan verifikasi status (`git status`) untuk memastikan tidak ada file uji coba/scratch yang ikut terbawa. Masukkan ke `.gitignore` jika file tersebut diperlukan secara lokal.

## Konvensi Kode
- Ikuti standar Laravel yang sudah ada dalam proyek ini.
- Selalu lakukan riset sebelum melakukan perubahan besar.

## Informasi Migrasi & Deployment
- Proyek `ppid_version2` ini sekarang berperan sebagai backend (API) sekaligus menyimpan file-file `blade` frontend lama. Saat ini sedang dalam proses pemisahan tampilan ke frontend **Nuxt** secara bertahap (per proses tampilan).
- **SETELAH SELESAI MERUBAH KODE APAPUN** di dalam versi 2 ini, **WAJIB** di-*push* ke git dan **WAJIB** beritahukan User dengan kalimat untuk melakukan **"pull di production"**.
