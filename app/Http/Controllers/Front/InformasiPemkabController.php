<?php

namespace App\Http\Controllers\Front;

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

        // Filter visibility dan status
        $query->where(function ($q) {
            if (auth()->check()) {
                // Admin bisa melihat semuanya, jadi tidak ada filter
            } else {
                $q->where('visibility', 'public')
                  ->where(function ($sq) {
                      $sq->where('status', 'published')
                         ->orWhere(function ($ssq) {
                             $ssq->where('status', 'scheduled')
                                 ->where('published_at', '<=', now());
                         });
                  });
            }
        });

        $informasi_pemkabs = $query->latest()->paginate(15);
        $kategori_jenis = InformasiPemkab::KATEGORI_JENIS_DOKUMEN;

        return view('frontend.informasi-pemkab.index', compact('informasi_pemkabs', 'kategori_jenis'));
    }

    public function show(InformasiPemkab $informasi_pemkab)
    {
        // Pengecekan otorisasi
        if ($informasi_pemkab->visibility === 'private' || $informasi_pemkab->status === 'draft' || ($informasi_pemkab->status === 'scheduled' && $informasi_pemkab->published_at > now())) {
            if (!auth()->check()) {
                abort(404, 'Dokumen tidak ditemukan atau belum dipublikasikan.');
            }
        }

        return view('frontend.informasi-pemkab.show', compact('informasi_pemkab'));
    }
}
