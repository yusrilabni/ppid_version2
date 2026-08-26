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
            $query->where('jenis_dokumen', 'LIKE', '%' . $request->jenis_dokumen . '%');
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
        $informasi_pemkabs = $query->orderByRaw('COALESCE(published_at, created_at) DESC')->paginate($perPage);
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

        // Increment download count
        $informasi_pemkab->increment('downloads_count');

        if (str_starts_with($informasi_pemkab->file_path, 'http')) {
            $url = $informasi_pemkab->file_path;
            
            // Konversi link Google Drive menjadi Direct Download Link
            if (str_contains($url, 'drive.google.com')) {
                // Cek format /file/d/ID/view
                if (preg_match('/\/file\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
                    $fileId = $matches[1];
                    return redirect("https://drive.google.com/uc?export=download&id={$fileId}");
                }
                // Cek format /open?id=ID
                elseif (preg_match('/[?&]id=([a-zA-Z0-9_-]+)/', $url, $matches)) {
                    $fileId = $matches[1];
                    return redirect("https://drive.google.com/uc?export=download&id={$fileId}");
                }
            }
            
            return redirect($url);
        }

        return redirect(asset('storage/' . $informasi_pemkab->file_path));
    }
}
