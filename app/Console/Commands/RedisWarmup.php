<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\OptimizedCacheWarmup;

class RedisWarmup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:warmup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually reset and warmup Redis cache';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting manual Redis cache warmup...');
        
        // Menjalankan job secara sinkron untuk manual reset
        (new OptimizedCacheWarmup())->handle();

        $this->info('Redis cache has been manually reset and warmed up successfully!');
    }
}
