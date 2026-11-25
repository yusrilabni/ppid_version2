<?php

namespace App\Console\Commands;

use App\Models\InformasiPemkab;
use App\Observers\InformasiPemkabObserver;
use Illuminate\Console\Command;

class SyncPpidDocumentsToSupabase extends Command
{
    /**
     * Nama dan signature perintah Artisan.
     *
     * @var string
     */
    protected $signature = 'ppid:sync-supabase';

    /**
     * Deskripsi perintah Artisan.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi seluruh dokumen publik InformasiPemkab ke tabel Supabase ppid_documents';

    /**
     * Jalankan sinkronisasi massal dokumen publik ke Supabase.
     */
    public function handle(InformasiPemkabObserver $observer): int
    {
        if (!config('services.supabase.url') || !config('services.supabase.service_role_key')) {
            $this->error('SUPABASE_URL dan SUPABASE_SERVICE_ROLE_KEY belum dikonfigurasi.');
            return self::FAILURE;
        }

        $count = 0;

        InformasiPemkab::with('organization')
            ->where('visibility', 'public')
            ->where(function ($query) {
                $query->where('status', 'published')
                    ->orWhere(function ($scheduledQuery) {
                        $scheduledQuery->where('status', 'scheduled')
                            ->whereNotNull('published_at')
                            ->where('published_at', '<=', now());
                    });
            })
            ->orderBy('id')
            ->chunkById(50, function ($documents) use ($observer, &$count) {
                foreach ($documents as $document) {
                    $observer->saved($document);
                    $count++;
                }
            });

        $this->info("Berhasil menyinkronkan {$count} dokumen publik ke Supabase.");
        return self::SUCCESS;
    }
}
