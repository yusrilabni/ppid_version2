<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ExtraToolsController extends Controller
{
    /**
     * Halaman panduan RSS Feed
     */
    public function rssIndex()
    {
        $organizations = Organization::orderBy('name', 'asc')->get();
        return view('frontend.extra.rss', [
            'pageTitle' => 'RSS Feed - PPID Kabupaten Sinjai',
            'rssUrl' => route('extra.rss.generate'),
            'organizations' => $organizations
        ]);
    }

    /**
     * Halaman panduan Widget
     */
    public function widgetIndex()
    {
        $organizations = Organization::orderBy('name', 'asc')->get();
        return view('frontend.extra.widget', [
            'pageTitle' => 'Widget Informasi - PPID Kabupaten Sinjai',
            'organizations' => $organizations
        ]);
    }

    /**
     * Generator RSS XML (Dukungan Filter OPD)
     */
    public function rssGenerate(Request $request)
    {
        $query = Informasi::where('status', '!=', 'arsip');

        // Filter per OPD
        if ($request->has('unit_id')) {
            $query->where('unit_id', $request->unit_id);
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
     * Widget khusus untuk iframe (Tampilan dipercantik + Dukungan Filter OPD)
     */
    public function widgetLatest(Request $request)
    {
        $type = $request->get('type', 'latest');
        $limit = $request->get('limit', 5);
        $category = $request->get('category');
        $unit_id = $request->get('unit_id');

        $query = Informasi::where('status', '!=', 'arsip');

        if ($category) {
            $query->where('category', $category);
        }

        if ($unit_id) {
            $query->where('unit_id', $unit_id);
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
