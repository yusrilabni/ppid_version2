<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ApiLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ApiLog::with('user')->latest();

        if ($request->filled('risk_level')) {
            $query->where('risk_level', $request->risk_level);
        }

        $apiLogs = $query->paginate(20);

        // Calculate statistics with caching to prevent DB overload
        $stats = Cache::remember('api_logs_stats', 60, function () {
            $now = now();
            
            return [
                'per_minute' => ApiLog::where('created_at', '>=', $now->copy()->subMinute())->count(),
                'per_hour' => ApiLog::where('created_at', '>=', $now->copy()->subHour())->count(),
                'per_day' => ApiLog::where('created_at', '>=', $now->copy()->subDay())->count(),
                'per_week' => ApiLog::where('created_at', '>=', $now->copy()->subWeek())->count(),
                'per_month' => ApiLog::where('created_at', '>=', $now->copy()->subMonth())->count(),
                'per_year' => ApiLog::where('created_at', '>=', $now->copy()->subYear())->count(),
            ];
        });

        return view('admin.api-logs.index', compact('apiLogs', 'stats'));
    }
}
