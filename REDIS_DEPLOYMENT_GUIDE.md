# Panduan Integrasi Redis - PPID Version 2

Dokumen ini menjelaskan cara kerja, implementasi, dan langkah deployment untuk integrasi Redis pada aplikasi PPID.

## 1. Arsitektur Terintegrasi
- **MySQL**: Database utama (Source of Truth).
- **Redis**: Layer Cache, Session, dan Queue.
- **Failover Mechanism**: Jika Redis down, aplikasi otomatis beralih ke Database/File tanpa crash.

## 2. Perubahan Konfigurasi (.env)
Tambahkan baris berikut ke file `.env` di production:

```env
# Gunakan failover untuk keamanan maksimal
CACHE_STORE=failover
QUEUE_CONNECTION=failover

# Konfigurasi Redis Server
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_CACHE_DB=1

# Opsional: Aktifkan Redis untuk Session
# SESSION_DRIVER=redis
```

## 3. Fitur Utama yang Diimplementasikan
- **Auto-Invalidation**: Menggunakan `BeritaObserver` dan `InformasiObserver`. Cache otomatis dihapus saat data di MySQL berubah.
- **Optimized Home**: Halaman depan menggunakan `Cache::remember` untuk slider, berita, dan statistik.
- **Background Jobs**: Tersedia `OptimizedCacheWarmup` untuk memproses antrian via Redis.

## 4. Langkah Deployment
1. **Lokal**:
   - Jalankan `composer install` (pastikan ekstensi `php-redis` aktif).
   - Jalankan `php artisan queue:work` untuk mengetes Job.
2. **Push Git**:
   - Lakukan push ke repository (otomatis ter-pull di cPanel jika sudah di-set).
3. **Server Production**:
   - Pastikan Redis Server terinstall dan berjalan (`redis-cli ping`).
   - Jalankan `php artisan config:cache` dan `php artisan route:cache`.
   - Setup Supervisor (lihat poin 5).

## 5. Konfigurasi Supervisor (VPS)
Jika menggunakan VPS, buat file `/etc/supervisor/conf.d/ppid-worker.conf`:

```ini
[program:ppid-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan queue:work failover --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/your/project/storage/logs/worker.log
stopwaitsecs=3600
```

## 6. Penanganan Masalah (Troubleshooting)
- **Redis Down**: Aplikasi akan otomatis menggunakan database untuk cache dan queue karena driver `failover`.
- **Data Stale**: Jalankan `php artisan cache:clear` jika data di frontend tidak sinkron (seharusnya otomatis via Observer).
- **Queue Macet**: Cek log di `storage/logs/worker.log`.

## 7. Rollback
Jika ingin mematikan Redis sepenuhnya:
1. Ubah `CACHE_STORE=database` di `.env`.
2. Ubah `QUEUE_CONNECTION=database` di `.env`.
3. Jalankan `php artisan config:clear`.
