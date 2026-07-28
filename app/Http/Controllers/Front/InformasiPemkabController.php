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

        // Pagination dinamis
        $perPage = request('per_page', 10);
        $informasi_pemkabs = $query->latest()->paginate($perPage);
        $kategori_jenis = InformasiPemkab::KATEGORI_JENIS_DOKUMEN;

        return view('frontend.informasi-pemkab.index', compact('informasi_pemkabs', 'kategori_jenis'));
    }

    public function show(InformasiPemkab $informasi_pemkab)
    {
        // Pastikan dokumen published dan jika public bisa dilihat siapa saja, jika private harus login
        if ($informasi_pemkab->status !== 'published' && $informasi_pemkab->status !== 'scheduled') {
            abort(404);
        }

        if ($informasi_pemkab->status === 'scheduled' && $informasi_pemkab->published_at > now()) {
            abort(404);
        }

        if ($informasi_pemkab->visibility === 'private' && !auth()->check()) {
            abort(403, 'Akses ditolak. Dokumen ini bersifat private dan hanya dapat dilihat oleh admin.');
        }

        // Increment view count
        $informasi_pemkab->increment('views_count');

        return view('frontend.informasi-pemkab.show', compact('informasi_pemkab'));
    }

    public function download(InformasiPemkab $informasi_pemkab)
    {
        // Validasi akses sama dengan method show
        if ($informasi_pemkab->status !== 'published' && $informasi_pemkab->status !== 'scheduled') {
            abort(404);
        }

        if ($informasi_pemkab->status === 'scheduled' && $informasi_pemkab->published_at > now()) {
            abort(404);
        }

        if ($informasi_pemkab->visibility === 'private' && !auth()->check()) {
            abort(403, 'Akses ditolak. Dokumen ini bersifat private dan hanya dapat diunduh oleh admin.');
        }

        // Increment download count
        $informasi_pemkab->increment('downloads_count');

        if (str_starts_with($informasi_pemkab->file_path, 'http')) {
            return redirect($informasi_pemkab->file_path);
        }

        return redirect(asset('storage/' . $informasi_pemkab->file_path));
    }
}
