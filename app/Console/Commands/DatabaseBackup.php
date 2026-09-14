<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ppid:backup-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database MySQL, kirim ke Telegram, dan hapus backup lokal yang lebih tua dari 5 hari';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses backup database...');

        // 1. Persiapan Folder & Nama File
        $backupPath = storage_path('app/backups');
        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        $date = Carbon::now()->format('Y-m-d_H-i-s');
        $filename = "backup_ppid_{$date}.sql.gz";
        $filePath = $backupPath . '/' . $filename;

        // 2. Mengambil Kredensial Database
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $database = config('database.connections.mysql.database');

        // 3. Eksekusi MySQL Dump
        // Membungkus password dengan escapeshellarg agar karakter khusus (seperti $) aman di terminal Linux
        $passwordOption = $password ? "-p" . escapeshellarg($password) : "";
        $command = "mysqldump -h " . escapeshellarg($host) . " -P " . escapeshellarg($port) . " -u " . escapeshellarg($username) . " {$passwordOption} " . escapeshellarg($database) . " | gzip > " . escapeshellarg($filePath);

        $returnVar = NULL;
        $output = NULL;
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            $this->error('Gagal melakukan backup database. Pastikan mysqldump tersedia di server.');
            return Command::FAILURE;
        }

        $this->info("Backup berhasil dibuat di: {$filePath}");

        // 4. Kirim ke Telegram
        $this->sendToTelegram($filePath, $filename, $date);

        // 5. Hapus File Lokal yang Lebih Tua dari 5 Hari
        $this->cleanOldBackups($backupPath);

        $this->info('Proses backup selesai.');
        return Command::SUCCESS;
    }

    /**
     * Kirim file ke Telegram
     */
    protected function sendToTelegram($filePath, $filename, $date)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        if (!$token || !$chatId) {
            $this->warn('Token atau Chat ID Telegram belum diatur di .env. Melewati pengiriman Telegram.');
            return;
        }

        $this->info('Mengirim file ke Telegram...');

        $caption = "🟢 *AUTO BACKUP DATABASE*\n\n"
                 . "📅 Tanggal: " . Carbon::now()->translatedFormat('l, d F Y H:i:s') . "\n"
                 . "📁 File: `{$filename}`\n\n"
                 . "_Pesan otomatis oleh Sistem PPID._";

        $response = Http::attach(
            'document', file_get_contents($filePath), $filename
        )->post("https://api.telegram.org/bot{$token}/sendDocument", [
            'chat_id' => $chatId,
            'caption' => $caption,
            'parse_mode' => 'Markdown',
        ]);

        if ($response->successful()) {
            $this->info('Berhasil dikirim ke Telegram.');
        } else {
            $this->error('Gagal mengirim ke Telegram: ' . $response->body());
        }
    }

    /**
     * Hapus backup lokal > 5 hari
     */
    protected function cleanOldBackups($backupPath)
    {
        $this->info('Membersihkan file backup lama (lebih dari 5 hari)...');
        
        $files = File::files($backupPath);
        $now = Carbon::now();
        $deletedCount = 0;

        foreach ($files as $file) {
            $fileDate = Carbon::createFromTimestamp(File::lastModified($file));
            
            // Jika file lebih tua dari 5 hari
            if ($now->diffInDays($fileDate) >= 5) {
                File::delete($file);
                $deletedCount++;
                $this->line("Dihapus: " . $file->getFilename());
            }
        }

        $this->info("Pembersihan selesai. {$deletedCount} file dihapus.");
    }
}
