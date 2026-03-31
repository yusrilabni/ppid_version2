<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use App\Models\Organization;
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
        $type = $request->get('type', 'latest');
        $limit = (int) $request->get('limit', 5);
        $query = Informasi::query();
        if ($request->filled('unit_id')) { $query->where('unit_id', $request->unit_id); }
        if ($request->filled('year')) { $query->where('tahun', $request->year); }
        if ($type === 'popular') { $query->orderBy('views_count', 'desc'); } else { $query->orderBy('tanggal_upload', 'desc'); }
        $informasis = $query->take($limit)->get();
        return Response::view('frontend.extra.widgets.embed-latest', compact('informasis', 'type'))->header('Access-Control-Allow-Origin', '*');
    }
}
