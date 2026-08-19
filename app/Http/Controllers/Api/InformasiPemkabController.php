<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InformasiPemkab;

class InformasiPemkabController extends Controller
{
    public function index(Request $request)
    {
        $query = InformasiPemkab::with(['user', 'organization']);

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('jenis_dokumen')) {
            $query->where('jenis_dokumen', $request->jenis_dokumen);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // Filter visibility dan status (hanya public dan published/scheduled yg valid)
        $query->where('visibility', 'public')
              ->where(function ($sq) {
                  $sq->where('status', 'published')
                     ->orWhere(function ($ssq) {
                         $ssq->where('status', 'scheduled')
                             ->where('published_at', '<=', now());
                     });
              });

        $perPage = $request->get('per_page', 10);
        $data = $query->latest()->paginate($perPage);
        $kategori_jenis = InformasiPemkab::KATEGORI_JENIS_DOKUMEN;

        return response()->json([
            'data' => $data,
            'kategori_jenis' => $kategori_jenis
        ]);
    }

    public function show($slug)
    {
        $informasi_pemkab = InformasiPemkab::where('slug', $slug)->orWhere('id', $slug)->firstOrFail();

        if ($informasi_pemkab->status !== 'published' && $informasi_pemkab->status !== 'scheduled') {
            abort(404);
        }

        if ($informasi_pemkab->status === 'scheduled' && $informasi_pemkab->published_at > now()) {
            abort(404);
        }

        $informasi_pemkab->increment('views_count');

        return response()->json($informasi_pemkab);
    }
}
