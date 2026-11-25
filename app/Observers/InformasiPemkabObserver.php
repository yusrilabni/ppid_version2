<?php

namespace App\Observers;

use App\Models\InformasiPemkab;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InformasiPemkabObserver
{
    /**
     * Sinkronkan metadata dokumen publik ke Supabase saat dibuat atau diperbarui.
     */
    public function saved(InformasiPemkab $document): void
    {
        $url = rtrim((string) config('services.supabase.url'), '/');
        $key = (string) config('services.supabase.service_role_key');

        if ($url === '' || $key === '') {
            return;
        }

        $isPublished = $document->status === 'published';
        $isScheduledAndDue = $document->status === 'scheduled'
            && !empty($document->published_at)
            && now()->gte(Carbon::parse($document->published_at));

        $isPublic = $document->visibility === 'public' && ($isPublished || $isScheduledAndDue);

        if (!$isPublic) {
            $this->deleteFromSupabase((int) $document->id, $url, $key);
            return;
        }

        try {
            $document->loadMissing('organization');

            $publishedAt = $document->published_at instanceof \DateTimeInterface
                ? $document->published_at->toIso8601String()
                : ($document->published_at ?: $document->created_at?->toIso8601String());

            $updatedAt = $document->updated_at instanceof \DateTimeInterface
                ? $document->updated_at->toIso8601String()
                : ($document->updated_at ?: $publishedAt);

            Http::withHeaders([
                'apikey' => $key,
                'Authorization' => "Bearer {$key}",
                'Content-Type' => 'application/json',
                'Prefer' => 'resolution=merge-duplicates,return=minimal',
            ])
                ->timeout(3)
                ->post("{$url}/rest/v1/ppid_documents?on_conflict=id", [
                    'id' => (int) $document->id,
                    'slug' => (string) $document->slug,
                    'title' => (string) $document->judul,
                    'description' => $document->deskripsi,
                    'organization_name' => $document->organization?->name,
                    'published_at' => $publishedAt,
                    'updated_at' => $updatedAt,
                    'synced_at' => now()->toIso8601String(),
                ]);
        } catch (\Throwable $e) {
            // Jangan gagalkan penyimpanan dokumen PPID jika koneksi ke Supabase sedang bermasalah
            Log::warning('[Supabase Sync] Gagal menyinkronkan dokumen ' . $document->id . ': ' . $e->getMessage());
        }
    }

    /**
     * Hapus metadata dokumen dari Supabase saat dokumen dihapus.
     */
    public function deleted(InformasiPemkab $document): void
    {
        $url = rtrim((string) config('services.supabase.url'), '/');
        $key = (string) config('services.supabase.service_role_key');

        if ($url === '' || $key === '') {
            return;
        }

        $this->deleteFromSupabase((int) $document->id, $url, $key);
    }

    private function deleteFromSupabase(int $documentId, string $url, string $key): void
    {
        try {
            Http::withHeaders([
                'apikey' => $key,
                'Authorization' => "Bearer {$key}",
            ])
                ->timeout(3)
                ->delete("{$url}/rest/v1/ppid_documents?id=eq.{$documentId}");
        } catch (\Throwable $e) {
            Log::warning('[Supabase Sync] Gagal menghapus dokumen ' . $documentId . ': ' . $e->getMessage());
        }
    }
}
