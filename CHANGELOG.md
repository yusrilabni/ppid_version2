# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Konfigurasi layanan Supabase (`services.supabase.url` dan `services.supabase.service_role_key`) pada `config/services.php`.
- Observer `app/Observers/InformasiPemkabObserver.php` dan registrasinya di `app/Providers/AppServiceProvider.php` untuk sinkronisasi otomatis metadata dokumen publik `InformasiPemkab` ke tabel Supabase `ppid_documents` saat disimpan atau dihapus.
- Perintah Artisan `ppid:sync-supabase` (`app/Console/Commands/SyncPpidDocumentsToSupabase.php`) untuk sinkronisasi massal dokumen publik lama ke Supabase.

### Changed
- Penambahan aturan ignore direktori unggahan dan runtime storage Laravel (`storage/app/public/*`, `storage/logs/*`, `storage/framework/{cache,sessions,views}/*`) pada `.gitignore`.

### Fixed
- Pengetatan filter status `scheduled` (`published_at <= now()`) pada `InformasiPemkabObserver` dan perintah `ppid:sync-supabase` agar dokumen terjadwal masa depan tidak tersinkronisasi lebih awal ke Supabase, serta penambahan `error_log` ke `.gitignore`.
