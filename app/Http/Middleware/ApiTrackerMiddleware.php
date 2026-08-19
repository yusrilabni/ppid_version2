<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiLog;

class ApiTrackerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        $response = $next($request);

        $endTime = microtime(true);
        $responseTimeMs = (int) (($endTime - $startTime) * 1000);

        $payload = json_encode($request->all());
        $url = $request->fullUrl();

        $riskLevel = 'good';

        // Check for HARD risk
        $hardKeywords = [
            'union', 'select', 'drop table', // SQLi (case insensitive check)
            '<script>', // XSS
            '../' // Dir Traversal
        ];

        $payloadLower = strtolower($payload);
        $urlLower = strtolower($url);

        $isHard = false;
        foreach ($hardKeywords as $keyword) {
            if (str_contains($payloadLower, $keyword) || str_contains($urlLower, $keyword)) {
                $isHard = true;
                break;
            }
        }

        if ($request->has('per_page') && is_numeric($request->get('per_page')) && $request->get('per_page') > 100) {
            $isHard = true;
        }

        if ($isHard) {
            $riskLevel = 'hard';
        } elseif ($response->getStatusCode() >= 400) {
            $riskLevel = 'middle';
        }
        
        $originHeader = $request->header('origin') ?: $request->header('referer');
        $originType = 'Lainnya / Direct Access';
        
        if ($originHeader) {
            $parsed = parse_url($originHeader);
            $host = $parsed['host'] ?? '';
            $scheme = $parsed['scheme'] ?? '';
            $originClean = $scheme . '://' . $host;
            
            $allowedOrigins = config('cors.allowed_origins', []);
            if (in_array($originClean, $allowedOrigins) || in_array($originHeader, $allowedOrigins)) {
                $originType = 'Aplikasi Frontend Legal';
            } else {
                $originType = 'Aplikasi Eksternal / Bot';
            }
        }

        // Do not log very sensitive things in production, but here we just follow instructions
        ApiLog::create([
            'method' => $request->method(),
            'url' => $url,
            'ip_address' => $request->ip(),
            'origin' => $originType,
            'user_agent' => $request->userAgent(),
            'payload' => $payload,
            'user_id' => auth()->id(), // null if not logged in
            'response_status' => $response->getStatusCode(),
            'response_time' => $responseTimeMs,
            'risk_level' => $riskLevel,
        ]);

        return $response;
    }
}
