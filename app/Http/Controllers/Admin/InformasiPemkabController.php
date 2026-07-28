<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InformasiPemkab;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class InformasiPemkabController extends Controller
{
    public function index()
    {
        $informasi_pemkabs = InformasiPemkab::with(['user', 'organization'])->latest()->get();
        return view('admin.informasi-pemkab.index', compact('informasi_pemkabs'));
    }

    public function create()
    {
        $kategori_jenis = InformasiPemkab::KATEGORI_JENIS_DOKUMEN;
        return view('admin.informasi-pemkab.create', compact('kategori_jenis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'jenis_dokumen' => 'required|string',
            'tahun' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'upload_method' => 'required|in:file,link',
            'file' => 'required_if:upload_method,file|file|mimes:pdf,doc,docx,xls,xlsx,zip,rar|max:10240',
            'link' => 'required_if:upload_method,link|url|max:2048',
            'status' => 'required|in:draft,published,scheduled',
            'visibility' => 'required|in:public,private',
            'published_at' => 'nullable|required_if:status,scheduled|date',
        ]);

        try {
            $data = $request->except(['file', 'link', 'upload_method']);
            
            if ($request->upload_method === 'file' && $request->hasFile('file')) {
                $data['file_path'] = $request->file('file')->store('informasi_pemkab', 'public');
            } elseif ($request->upload_method === 'link' && $request->filled('link')) {
                $data['file_path'] = $request->input('link');
            }

            if (empty($data['file_path'])) {
                throw new \Exception('File atau Link dokumen gagal diproses.');
            }

            $data['user_id'] = Auth::id();
            $data['unit_id'] = Auth::user()->unit_id ?? null;
            $data['ip_address'] = $request->ip();

            InformasiPemkab::create($data);

            return redirect()->route('admin.informasi-pemkab.index')->with('success', 'Dokumen berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $informasi_pemkab = InformasiPemkab::findOrFail($id);
        $kategori_jenis = InformasiPemkab::KATEGORI_JENIS_DOKUMEN;
        return view('admin.informasi-pemkab.edit', compact('informasi_pemkab', 'kategori_jenis'));
    }

    public function update(Request $request, $id)
    {
        $informasi_pemkab = InformasiPemkab::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'jenis_dokumen' => 'required|string',
            'tahun' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'upload_method' => 'required|in:file,link',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip,rar|max:10240',
            'link' => 'nullable|url|max:2048',
            'status' => 'required|in:draft,published,scheduled',
            'visibility' => 'required|in:public,private',
            'published_at' => 'nullable|required_if:status,scheduled|date',
        ]);

        try {
            $data = $request->except(['file', 'link', 'upload_method']);
            
            if ($request->upload_method === 'file' && $request->hasFile('file')) {
                // Delete old file if it exists and is not a link
                if ($informasi_pemkab->file_path && !str_starts_with($informasi_pemkab->file_path, 'http')) {
                    Storage::disk('public')->delete($informasi_pemkab->file_path);
                }
                $data['file_path'] = $request->file('file')->store('informasi_pemkab', 'public');
            } elseif ($request->upload_method === 'link' && $request->filled('link')) {
                // Delete old file if it exists and is not a link
                if ($informasi_pemkab->file_path && !str_starts_with($informasi_pemkab->file_path, 'http')) {
                    Storage::disk('public')->delete($informasi_pemkab->file_path);
                }
                $data['file_path'] = $request->input('link');
            }

            // Keep the old file_path if upload method is link but it was already a link and they left it blank (validation handles this mostly)
            if (empty($data['file_path']) && empty($request->file) && empty($request->link)) {
                $data['file_path'] = $informasi_pemkab->file_path;
            }
            
            if (empty($data['file_path'])) {
                throw new \Exception('File atau Link dokumen gagal diproses.');
            }

            $informasi_pemkab->update($data);

            return redirect()->route('admin.informasi-pemkab.index')->with('success', 'Dokumen berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $informasi_pemkab = InformasiPemkab::findOrFail($id);
        if ($informasi_pemkab->file_path) {
            Storage::disk('public')->delete($informasi_pemkab->file_path);
        }
        $informasi_pemkab->delete();

        return redirect()->route('admin.informasi-pemkab.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
