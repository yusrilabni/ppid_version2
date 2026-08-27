# Instruksi Proyek PPID Version 2

## Batasan Operasional
- **HANYA** edit file di dalam folder `production_deployment/ppid_version2`.
- **DILARANG** menyentuh atau mengedit file apa pun di folder root `ppid_laravel`. File di sana hanya boleh dibaca sebagai referensi.
- Gunakan **Bahasa Indonesia** untuk semua komunikasi dan jawaban.

## Alur Kerja Git
- Setelah melakukan perubahan kode, jalankan perintah berikut dalam satu baris:
  `git add . && git status && git push`

## Konvensi Kode
- Ikuti standar Laravel yang sudah ada dalam proyek ini.
- Selalu lakukan riset sebelum melakukan perubahan besar.

## Informasi Migrasi & Deployment
- Proyek `ppid_version2` ini sekarang berperan sebagai backend (API) sekaligus menyimpan file-file `blade` frontend lama. Saat ini sedang dalam proses pemisahan tampilan ke frontend **Nuxt** secara bertahap (per proses tampilan).
- **SETELAH SELESAI MERUBAH KODE APAPUN** di dalam versi 2 ini, **WAJIB** di-*push* ke git dan **WAJIB** beritahukan User dengan kalimat untuk melakukan **"pull di production"**.
