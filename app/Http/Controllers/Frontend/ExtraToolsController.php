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
        
        // Ambil daftar tahun unik dari tahun inputan atau dari tanggal upload
        $years = Informasi::select(DB::raw('DISTINCT(CASE WHEN tahun IS NOT NULL AND tahun != 0 THEN tahun ELSE YEAR(tanggal_upload) END) as year'))
            ->whereNotNull('tanggal_upload')
            ->orderBy('year', 'desc')
            ->pluck('year');

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
        
        // Ambil daftar tahun unik dari tahun inputan atau dari tanggal upload
        $years = Informasi::select(DB::raw('DISTINCT(CASE WHEN tahun IS NOT NULL AND tahun != 0 THEN tahun ELSE YEAR(tanggal_upload) END) as year'))
            ->whereNotNull('tanggal_upload')
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('frontend.extra.widget', [
            'pageTitle' => 'Widget Informasi - PPID Kabupaten Sinjai',
            'organizations' => $organizations,
            'years' => $years
        ]);
    }

    /**
     * Generator RSS XML (Dukungan Filter OPD & Tahun)
     */
    public function rssGenerate(Request $request)
    {
        $query = Informasi::where('status', '!=', 'arsip');

        // Filter per OPD
        if ($request->has('unit_id') && $request->unit_id != '') {
            $query->where('unit_id', $request->unit_id);
        }

        // Filter per Tahun (Cek kolom tahun atau tahun dari tanggal_upload)
        if ($request->has('year') && $request->year != '') {
            $year = $request->year;
            $query->where(function($q) use ($year) {
                $q->where('tahun', $year)
                  ->orWhereYear('tanggal_upload', $year);
            });
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
     * Widget khusus untuk iframe (Dukungan Filter OPD & Tahun)
     */
    public function widgetLatest(Request $request)
    {
        $type = $request->get('type', 'latest');
        $limit = $request->get('limit', 5);
        $category = $request->get('category');
        $unit_id = $request->get('unit_id');
        $year = $request->get('year');

        $query = Informasi::where('status', '!=', 'arsip');

        if ($category) {
            $query->where('category', $category);
        }

        if ($unit_id && $unit_id != '') {
            $query->where('unit_id', $unit_id);
        }

        if ($year && $year != '') {
            $query->where(function($q) use ($year) {
                $q->where('tahun', $year)
                  ->orWhereYear('tanggal_upload', $year);
            });
        }

        if ($type === 'popular') {
            $query->orderBy('views_count', 'desc');
        } else {
            $query->orderBy('tanggal_upload', 'desc');
        }

        $informasis = $query->limit($limit)->get();

        return view('frontend.extra.widgets.embed-latest', compact('informasis', 'type'));
    }
}
