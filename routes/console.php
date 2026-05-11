<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('permohonan:complete-old')->daily()->at('01:00');

// Refresh Redis Cache every hour
Schedule::job(new \App\Jobs\OptimizedCacheWarmup)->hourly();
