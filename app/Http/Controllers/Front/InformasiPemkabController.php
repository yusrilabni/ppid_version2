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

        $informasi_pemkabs = $query->latest()->paginate(15);
        $kategori_jenis = InformasiPemkab::KATEGORI_JENIS_DOKUMEN;

        return view('frontend.informasi-pemkab.index', compact('informasi_pemkabs', 'kategori_jenis'));
    }
}
