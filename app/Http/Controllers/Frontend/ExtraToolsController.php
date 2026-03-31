<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ExtraToolsController extends Controller
{
    /**
     * Halaman panduan RSS Feed
     */
    public function rssIndex()
    {
        return view('frontend.extra.rss', [
            'pageTitle' => 'RSS Feed - PPID Kabupaten Sinjai',
            'rssUrl' => route('extra.rss.generate')
        ]);
    }

    /**
     * Halaman panduan Widget
     */
    public function widgetIndex()
    {
        return view('frontend.extra.widget', [
            'pageTitle' => 'Widget Informasi - PPID Kabupaten Sinjai'
        ]);
    }

    /**
     * Generator RSS XML (Auto Update dari Database)
     */
    public function rssGenerate()
    {
        $informasis = Informasi::where('status', '!=', 'arsip')
            ->orderBy('tanggal_upload', 'desc')
            ->limit(50)
            ->get();

        $content = view('frontend.extra.widgets.rss-xml', compact('informasis'));

        return Response::make($content, 200, [
            'Content-Type' => 'application/xml',
            'Charset' => 'UTF-8'
        ]);
    }

    /**
     * Widget khusus untuk iframe (Tampilan bersih)
     */
    public function widgetLatest(Request $request)
    {
        $type = $request->get('type', 'latest');
        $limit = $request->get('limit', 5);
        $category = $request->get('category');

        $query = Informasi::where('status', '!=', 'arsip');

        if ($category) {
            $query->where('category', $category);
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
