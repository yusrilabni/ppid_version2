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
    /**
     * Halaman panduan RSS Feed
     */
    public function rssIndex()
    {
        $organizations = Organization::orderBy('name', 'asc')->get();
        
        // Ambil daftar tahun unik dari kolom 'tahun' yang diisi manual oleh user
        $years = Informasi::select('tahun')
            ->whereNotNull('tahun')
            ->where('tahun', '!=', '')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('frontend.extra.rss', [
            'pageTitle' => 'RSS Feed - PPID Kabupaten Sinjai',
            'rssUrl' => route('extra.rss.generate'),
            'organizations' => $organizations,
            'years' => $years
        ]);
    }

    /**
     * Halaman panduan Widget
     */
    public function widgetIndex()
    {
        $organizations = Organization::orderBy('name', 'asc')->get();
        
        // Ambil daftar tahun unik dari kolom 'tahun' yang diisi manual oleh user
        $years = Informasi::select('tahun')
            ->whereNotNull('tahun')
            ->where('tahun', '!=', '')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('frontend.extra.widget', [
            'pageTitle' => 'Widget Informasi - PPID Kabupaten Sinjai',
            'organizations' => $organizations,
            'years' => $years
        ]);
    }

    /**
     * Generator RSS XML
     */
    public function rssGenerate(Request $request)
    {
        $query = Informasi::where('status', '!=', 'arsip');

        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        // Filter berdasarkan kolom 'tahun' (input manual)
        if ($request->filled('year')) {
            $query->where('tahun', $request->year);
        }

        $informasis = $query->orderBy('tanggal_upload', 'desc')
            ->limit(50)
            ->get();

        $content = view('frontend.extra.widgets.rss-xml', compact('informasis'));

        return Response::make($content, 200, [
            'Content-Type' => 'application/xml',
            'Charset' => 'UTF-8'
        ]);
    }

    /**
     * Widget khusus untuk iframe (Manual Year Logic)
     */
    public function widgetLatest(Request $request)
    {
        $type = $request->get('type', 'latest');
        $limit = (int) $request->get('limit', 5);
        $unit_id = $request->get('unit_id');
        $year = $request->get('year');

        $query = Informasi::query()->where('status', '!=', 'arsip');

        if ($request->filled('unit_id')) {
            $query->where('unit_id', $unit_id);
        }

        // Filter berdasarkan kolom 'tahun' (input manual)
        if ($request->filled('year')) {
            $query->where('tahun', $year);
        }

        if ($type === 'popular') {
            $query->orderBy('views_count', 'desc');
        } else {
            $query->orderBy('tanggal_upload', 'desc');
        }

        $informasis = $query->take($limit)->get();

        return view('frontend.extra.widgets.embed-latest', compact('informasis', 'type'));
    }
}
