<?php

namespace App\Jobs;

use App\Models\Berita;
use App\Models\Informasi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OptimizedCacheWarmup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 60;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Starting Redis Cache Warmup...');

        try {
            // Warmup Home Sliders
            Cache::forget('home_sliders');
            Cache::remember('home_sliders', 3600, function () {
                $items = \App\Models\Slider::where('active', true)->orderBy('order', 'asc')->get();
                foreach ($items as $slider) {
                    $slider->informasi = Informasi::where('title', $slider->title)->first();
                }
                return $items;
            });

            // Warmup Latest Berita
            Cache::forget('berita_home_latest');
            Cache::remember('berita_home_latest', 3600, function () {
                return Berita::where('published', true)->orderBy('created_at', 'desc')->take(6)->get();
            });

            // Warmup Latest Informasi
            Cache::forget('informasi_latest_home');
            Cache::remember('informasi_latest_home', 3600, function () {
                return Informasi::with(['user', 'organization'])->latest()->take(16)->get();
            });

            Log::info('Redis Cache Warmup completed successfully.');
        } catch (\Exception $e) {
            Log::error('Redis Cache Warmup failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('OptimizedCacheWarmup Job permanently failed: ' . $exception->getMessage());
    }
}
