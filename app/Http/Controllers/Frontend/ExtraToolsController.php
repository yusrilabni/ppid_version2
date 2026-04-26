<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use App\Models\Organization;
use App\Models\ExternalLinkLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class ExtraToolsController extends Controller
{
    public function rssIndex()
    {
        $organizations = Organization::orderBy('name', 'asc')->get();
        $years = Informasi::select('tahun')->whereNotNull('tahun')->where('tahun', '!=', '')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        return view('frontend.extra.rss', [
            'pageTitle' => 'RSS Feed - PPID Sinjai', 
            'rssUrl' => route('extra.rss.generate'), 
            'organizations' => $organizations, 
            'years' => $years
        ]);
    }

    public function widgetIndex()
    {
        $organizations = Organization::orderBy('name', 'asc')->get();
        $years = Informasi::select('tahun')->whereNotNull('tahun')->where('tahun', '!=', '')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        return view('frontend.extra.widget', [
            'pageTitle' => 'Widget - PPID Sinjai', 
            'organizations' => $organizations, 
            'years' => $years
        ]);
    }

    public function rssGenerate(Request $request)
    {
        $this->trackAccess($request, 'rss');

        $query = Informasi::query();
        if ($request->filled('unit_id')) { $query->where('unit_id', $request->unit_id); }
        if ($request->filled('year')) { $query->where('tahun', $request->year); }

        // PAKSA LIMIT MENJADI INTEGER (PENTING!)
        $limit = (int) $request->get('limit', 50);

        $informasis = $query->orderBy('tanggal_upload', 'desc')->limit($limit)->get();

        $content = view('frontend.extra.widgets.rss-xml', compact('informasis'));
        return Response::make($content, 200, [
            'Content-Type' => 'application/xml',
            'Charset' => 'UTF-8',
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET'
        ]);
    }

    public function widgetLatest(Request $request)
    {
        $this->trackAccess($request, 'widget');

        $type = $request->get('type', 'latest');
        $display = $request->get('display', 'list'); 
        $mode = $request->get('mode', 'static'); 
        $columns = (int) $request->get('columns', 3); 
        $autoplay = $request->get('autoplay', 0); 
        $limit = $request->get('limit', 5);
        $category = $request->get('category');
        
        $query = Informasi::with(['user', 'organization']);
        if ($request->filled('unit_id')) { $query->where('unit_id', $request->unit_id); }
        if ($request->filled('year')) { $query->where('tahun', $request->year); }
        if ($request->filled('category')) { $query->where('category', $request->category); }
        
        if ($type === 'popular') { 
            $query->orderBy('views_count', 'desc'); 
        } else { 
            $query->orderBy('tanggal_upload', 'desc'); 
        }
        
        // Handle "all" limit
        if ($limit === 'all') {
            $informasis = $query->get();
        } else {
            $informasis = $query->take((int)$limit)->get();
        }

        $unitMap = collect(\App\Helpers\GeneralHelper::getUnitData());
        
        return Response::view('frontend.extra.widgets.embed-latest', compact('informasis', 'type', 'display', 'mode', 'columns', 'autoplay', 'unitMap'))
            ->header('Access-Control-Allow-Origin', '*');
    }

    private function trackAccess(Request $request, $type)
    {
        // Prioritas 1: Ambil dari Referer (Otomatis)
        $referer = $request->headers->get('referer');
        $domain = $referer ? parse_url($referer, PHP_URL_HOST) : null;

        // Prioritas 2: Ambil dari parameter 'origin' (Manual fallback)
        if (!$domain && $request->has('origin')) {
            $domain = parse_url($request->origin, PHP_URL_HOST) ?: $request->origin;
        }

        if (!$domain) return;

        // Bersihkan domain dari 'www.' agar unik
        $domain = str_replace('www.', '', strtolower($domain));

        try {
            // Check if record exists
            $log = ExternalLinkLog::where('domain', $domain)->where('type', $type)->first();
            
            if ($log) {
                $log->increment('access_count');
                $log->last_access = now();
                $log->save();
            } else {
                ExternalLinkLog::create([
                    'domain' => $domain,
                    'type' => $type,
                    'access_count' => 1,
                    'last_access' => now()
                ]);
            }
        } catch (\Exception $e) {
            \Log::error("Error tracking widget/rss access: " . $e->getMessage());
        }
    }
}
