<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class RedisMonitorController extends Controller
{
    /**
     * Check Redis connection and status.
     */
    public function check()
    {
        // Keamanan: Hanya Superadmin yang bisa melihat detail ini
        if (!Auth::check() || Auth::user()->role !== 'superadmin') {
            abort(403, 'Akses terbatas untuk Superadmin.');
        }

        $results = [
            'status' => 'Unknown',
            'driver' => config('cache.default'),
            'php_version' => PHP_VERSION,
            'extensions' => [
                'redis' => extension_loaded('redis'),
                'igbinary' => extension_loaded('igbinary'),
            ],
            'redis_config' => [
                'client' => config('database.redis.client'),
                'host' => config('database.redis.default.host'),
                'port' => config('database.redis.default.port'),
                'database' => config('database.redis.default.database'),
            ],
            'test_results' => [],
            'possible_sockets' => [],
            'info' => null,
        ];

        // Diagnostic: Check for common cPanel redis sockets
        $user = get_current_user();
        $commonSockets = [
            "/home/$user/.redis/redis.sock",
            "/var/run/redis/redis.sock",
            "/tmp/redis.sock",
        ];
        foreach ($commonSockets as $socket) {
            if (file_exists($socket)) {
                $results['possible_sockets'][] = $socket;
            }
        }

        try {
            // Test 1: Ping Redis
            $ping = Redis::connection()->ping();
            $results['test_results']['ping'] = $ping ? 'PONG (Connected)' : 'Failed';
            
            // Test 2: Write & Read Cache
            $testKey = 'redis_monitor_test_' . time();
            Cache::store('redis')->put($testKey, 'Redis is Working!', 10);
            $results['test_results']['cache_write_read'] = Cache::store('redis')->get($testKey) === 'Redis is Working!' ? 'Success' : 'Failed';
            
            // Test 3: Get Redis Info
            $results['info'] = Redis::connection()->info();
            $results['status'] = 'Active & Connected';

        } catch (\Exception $e) {
            $results['status'] = 'Error / Disconnected';
            $results['error_message'] = $e->getMessage();
        }

        return response()->json($results, 200, [], JSON_PRETTY_PRINT);
    }
}
