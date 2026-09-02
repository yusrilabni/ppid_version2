<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InformasiPemkab;
use App\Models\Informasi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InformasiPemkabController extends Controller
{
    public function index()
    {
        $informasi_pemkabs = InformasiPemkab::with(['user', 'organization'])
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->get();
        return view('admin.informasi-pemkab.index', compact('informasi_pemkabs'));
    }

    private function mapToPpidCategory($kategori, $jenis_dokumen)
    {
        // Daftar jenis dokumen yang otomatis masuk ke "Informasi Berkala"
        $berkala_jenis = [
            'RPJPD', 'RPJMD', 'RKPD', 'Renstra', 'Renja', 'RKA', 'KUA', 'PPAS', // Perencanaan
            'APBD', 'APBD Perubahan', 'DPA', 'DPPA', 'LKPD', 'LRA', 'LO', 'Neraca', 'CaLK', 'IPKD', 'Laporan Keuangan', // Keuangan
            'LKjIP', 'LKPJ', 'LPPD', 'SAKIP', 'Laporan Triwulan', 'Laporan Tahunan', // Pelaporan
            'Statistik Sektoral', 'Metadata Statistik', 'Buku Statistik', // Statistik
            'Pengumuman Lainnya'
        ];

        // Daftar jenis dokumen yang otomatis masuk ke "Informasi Serta Merta"
        // (Bisa ditambahkan jika ada edaran darurat dll)
        $serta_merta_jenis = [
            'Surat Edaran'
        ];

        $jenis_array = array_map('trim', explode(',', $jenis_dokumen));

        // Prioritize Serta Merta
        if (count(array_intersect($jenis_array, $serta_merta_jenis)) > 0) {
            return 'Informasi Serta Merta';
        }

        // Then Berkala
        if (count(array_intersect($jenis_array, $berkala_jenis)) > 0) {
            return 'Informasi Berkala';
        }
        
        // Sisanya (seperti Peraturan, Aset, Kepegawaian, SOP, MoU, Audit, dll) 
        // akan otomatis masuk ke "Informasi Setiap Saat"
        return 'Informasi Setiap Saat';
    }

    public function create()
    {
        $kategori_jenis = InformasiPemkab::KATEGORI_JENIS_DOKUMEN;
        $user = auth()->user();
        $isSuperAdmin = $user->isSuperAdmin();
        
        $units = [];
        if ($isSuperAdmin) {
            $units = \App\Helpers\GeneralHelper::getUnitData()->map(function($unit) {
                return [
                    'value' => (string)$unit['unit_id'],
                    'label' => $unit['unit_nama'],
                ];
            })->values()->toArray();
        }

        return view('admin.informasi-pemkab.create', compact('kategori_jenis', 'isSuperAdmin', 'units'));
    }

    public function store(Request $request)
    {
        $rules = [
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'jenis_dokumen' => 'required|array|min:1|max:3',
            'jenis_dokumen.*' => 'string',
            'tanggal_dokumen' => 'required|date',
            'deskripsi' => 'nullable|string',
            'upload_method' => 'required|in:file,link',
            'file' => 'nullable|required_if:upload_method,file|file|mimes:pdf,doc,docx,xls,xlsx,zip,rar,png,jpg,jpeg,webp,svg|max:10240',
            'link' => 'nullable|required_if:upload_method,link|url|max:2048',
            'status' => 'required|in:draft,published,scheduled',
            'visibility' => 'required|in:public,private',
        ];

        if (Auth::user()->isSuperAdmin()) {
            $rules['target_unit'] = 'required|string';
        }

        $request->validate($rules);

        try {
            $user = Auth::user();
            $user_id = $user->id;
            
            if ($user->isSuperAdmin() && $request->filled('target_unit')) {
                $unit_id = $request->input('target_unit');
            } else {
                $unit_id = $user->unit_id ?? null;
            }

            // Server-side Double Submit Protection (Title + Unit check within 10 seconds)
            $existing = InformasiPemkab::where('judul', $request->judul)
                                 ->where('unit_id', $unit_id)
                                 ->where('created_at', '>=', now()->subSeconds(10))
                                 ->first();
            
            if ($existing) {
                return redirect()->route('frontend.informasi-pemkab.index')
                    ->with('success', 'Dokumen sudah berhasil ditambahkan sebelumnya.');
            }

            $data = $request->except(['file', 'link', 'upload_method', 'target_unit']);
            // Implode array into comma-separated string
            $data['jenis_dokumen'] = implode(', ', $request->input('jenis_dokumen', []));
            
            if ($request->upload_method === 'file' && $request->hasFile('file')) {
                $file = $request->file('file');
                $extension = strtolower($file->getClientOriginalExtension());
                
                if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
                    // Increase memory limit to prevent OOM during WebP conversion of large images
                    ini_set('memory_limit', '512M');
                    $imageManager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                    $imageInstance = $imageManager->read($file->path());
                    $imageInstance = $imageInstance->toWebp(100);
                    
                    $imagePath = tempnam(sys_get_temp_dir(), 'informasi_pemkab_') . '.webp';
                    $imageInstance->save($imagePath);
                    
                    $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.webp';
                    $filePath = 'informasi_pemkab/' . $fileName;
                    \Illuminate\Support\Facades\Storage::disk('public')->put($filePath, file_get_contents($imagePath));
                    
                    unlink($imagePath);
                    $data['file_path'] = $filePath;
                } else {
                    $data['file_path'] = $file->store('informasi_pemkab', 'public');
                }
            } elseif ($request->upload_method === 'link' && $request->filled('link')) {
                $data['file_path'] = $request->input('link');
            }

            if (empty($data['file_path'])) {
                throw new \Exception('File atau Link dokumen gagal diproses.');
            }

            // Extract tahun and set published_at from tanggal_dokumen
            $tanggalDokumen = $request->input('tanggal_dokumen');
            if ($tanggalDokumen) {
                $data['tahun'] = date('Y', strtotime($tanggalDokumen));
                $data['published_at'] = $tanggalDokumen;
            } else {
                $data['tahun'] = $request->input('tahun', date('Y'));
            }

            $data['user_id'] = $user_id;
            $data['unit_id'] = $unit_id;
            $data['ip_address'] = $request->ip();

            DB::transaction(function () use ($data, $request) {
                $informasi_pemkab = InformasiPemkab::create($data);
                
                if ($informasi_pemkab->visibility !== 'private') {
                    $file = null;
                    $url = null;
                    if ($request->upload_method === 'link') {
                        $url = $informasi_pemkab->file_path;
                    } else {
                        $file = $informasi_pemkab->file_path;
                    }

                    Informasi::create([
                        'title' => $informasi_pemkab->judul,
                        'deskripsi' => $informasi_pemkab->deskripsi ?? 'Dokumen Pemkab Kategori ' . $informasi_pemkab->kategori,
                        'content' => 'Dokumen ini bersumber dari Informasi Pemkab.',
                        'file' => $file,
                        'url' => $url,
                        'category' => $this->mapToPpidCategory($informasi_pemkab->kategori, $informasi_pemkab->jenis_dokumen),
                        'jenis_dokumen' => $informasi_pemkab->jenis_dokumen,
                        'status' => 'BERLAKU',
                        'tahun' => $informasi_pemkab->tahun,
                        'tanggal_upload' => $informasi_pemkab->published_at ?? date('Y-m-d H:i:s'),
                        'user_id' => $informasi_pemkab->user_id,
                        'unit_id' => $informasi_pemkab->unit_id,
                        'informasi_pemkab_id' => $informasi_pemkab->id,
                    ]);
                }
            });

            if ($request->expectsJson() || $request->wantsJson() || $request->is('api/*')) {
                return response()->json(['success' => true, 'message' => 'Dokumen berhasil ditambahkan']);
            }
            return redirect()->route('frontend.informasi-pemkab.index')->with('success', 'Dokumen berhasil ditambahkan');
        } catch (\Throwable $e) {
            if ($request->expectsJson() || $request->wantsJson() || $request->is('api/*')) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function edit(InformasiPemkab $informasi_pemkab)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && $informasi_pemkab->organization_id != $user->unit_id) {
            abort(403, 'Akses ditolak. Anda tidak berhak mengedit dokumen dinas lain.');
        }

        $kategori_jenis = InformasiPemkab::KATEGORI_JENIS_DOKUMEN;
        $isSuperAdmin = $user->isSuperAdmin();
        
        $units = [];
        if ($isSuperAdmin) {
            $units = \App\Helpers\GeneralHelper::getUnitData()->map(function($unit) {
                return [
                    'value' => (string)$unit['unit_id'],
                    'label' => $unit['unit_nama'],
                ];
            })->values()->toArray();
        }

        return view('admin.informasi-pemkab.edit', compact('informasi_pemkab', 'kategori_jenis', 'isSuperAdmin', 'units'));
    }

    public function update(Request $request, InformasiPemkab $informasi_pemkab)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && $informasi_pemkab->organization_id != $user->unit_id) {
            abort(403, 'Akses ditolak. Anda tidak berhak memperbarui dokumen dinas lain.');
        }

        $rules = [
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'jenis_dokumen' => 'required|array|min:1|max:3',
            'jenis_dokumen.*' => 'string',
            'tanggal_dokumen' => 'required|date',
            'deskripsi' => 'nullable|string',
            'upload_method' => 'required|in:file,link',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip,rar,png,jpg,jpeg,webp,svg|max:10240',
            'link' => 'nullable|url|max:2048',
            'status' => 'required|in:draft,published,scheduled',
            'visibility' => 'required|in:public,private',
            'published_at' => 'nullable|required_if:status,scheduled|date',
        ];

        if ($user->isSuperAdmin()) {
            $rules['target_unit'] = 'required|string';
        }

        $request->validate($rules);

        try {
            $data = $request->except(['file', 'link', 'upload_method', 'target_unit']);
            
            if ($user->isSuperAdmin() && $request->filled('target_unit')) {
                $data['unit_id'] = $request->input('target_unit');
            }
            // Implode array into comma-separated string
            $data['jenis_dokumen'] = implode(', ', $request->input('jenis_dokumen', []));
            
            $oldFilePath = null; // Simpan file lama untuk dihapus NANTI

            if ($request->upload_method === 'file' && $request->hasFile('file')) {
                if ($informasi_pemkab->file_path && !str_starts_with($informasi_pemkab->file_path, 'http')) {
                    $oldFilePath = $informasi_pemkab->file_path;
                }
                
                $file = $request->file('file');
                $extension = strtolower($file->getClientOriginalExtension());
                
                if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
                    // Increase memory limit to prevent OOM during WebP conversion of large images
                    ini_set('memory_limit', '512M');
                    $imageManager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                    $imageInstance = $imageManager->read($file->path());
                    $imageInstance = $imageInstance->toWebp(100);
                    
                    $imagePath = tempnam(sys_get_temp_dir(), 'informasi_pemkab_') . '.webp';
                    $imageInstance->save($imagePath);
                    
                    $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.webp';
                    $filePath = 'informasi_pemkab/' . $fileName;
                    \Illuminate\Support\Facades\Storage::disk('public')->put($filePath, file_get_contents($imagePath));
                    
                    unlink($imagePath);
                    $data['file_path'] = $filePath;
                } else {
                    $data['file_path'] = $file->store('informasi_pemkab', 'public');
                }
            } elseif ($request->upload_method === 'link' && $request->filled('link')) {
                if ($informasi_pemkab->file_path && !str_starts_with($informasi_pemkab->file_path, 'http')) {
                    $oldFilePath = $informasi_pemkab->file_path;
                }
                $data['file_path'] = $request->input('link');
            }

            // Keep the old file_path if upload method is link but it was already a link and they left it blank (validation handles this mostly)
            if (empty($data['file_path']) && empty($request->file) && empty($request->link)) {
                $data['file_path'] = $informasi_pemkab->file_path;
                $oldFilePath = null; // Batal menghapus karena tidak ada file baru
            }
            
            if (empty($data['file_path'])) {
                throw new \Exception('File atau Link dokumen gagal diproses.');
            }

            // Extract tahun and set published_at from tanggal_dokumen
            $tanggalDokumen = $request->input('tanggal_dokumen');
            if ($tanggalDokumen) {
                $data['tahun'] = date('Y', strtotime($tanggalDokumen));
                $data['published_at'] = $tanggalDokumen;
            } else {
                $data['tahun'] = $request->input('tahun', date('Y'));
            }

            DB::transaction(function () use ($informasi_pemkab, $data, $request) {
                $informasi_pemkab->update($data);
                
                $informasi = Informasi::where('informasi_pemkab_id', $informasi_pemkab->id)->first();

                if ($informasi_pemkab->visibility === 'private') {
                    if ($informasi) {
                        $informasi->delete();
                    }
                } else {
                    $file = null;
                    $url = null;
                    if (str_starts_with($informasi_pemkab->file_path, 'http')) {
                        $url = $informasi_pemkab->file_path;
                    } else {
                        $file = $informasi_pemkab->file_path;
                    }

                    if ($informasi) {
                        $informasi->update([
                            'title' => $informasi_pemkab->judul,
                            'deskripsi' => $informasi_pemkab->deskripsi ?? 'Dokumen Pemkab Kategori ' . $informasi_pemkab->kategori,
                            'file' => $file,
                            'url' => $url,
                            'category' => $this->mapToPpidCategory($informasi_pemkab->kategori, $informasi_pemkab->jenis_dokumen),
                            'jenis_dokumen' => $informasi_pemkab->jenis_dokumen,
                            'tahun' => $informasi_pemkab->tahun,
                            'tanggal_upload' => $informasi_pemkab->published_at ?? $informasi->tanggal_upload,
                        ]);
                    } else {
                        Informasi::create([
                            'title' => $informasi_pemkab->judul,
                            'deskripsi' => $informasi_pemkab->deskripsi ?? 'Dokumen Pemkab Kategori ' . $informasi_pemkab->kategori,
                            'content' => 'Dokumen ini bersumber dari Informasi Pemkab.',
                            'file' => $file,
                            'url' => $url,
                            'category' => $this->mapToPpidCategory($informasi_pemkab->kategori, $informasi_pemkab->jenis_dokumen),
                            'jenis_dokumen' => $informasi_pemkab->jenis_dokumen,
                            'status' => 'BERLAKU',
                            'tahun' => $informasi_pemkab->tahun,
                            'tanggal_upload' => $informasi_pemkab->published_at ?? date('Y-m-d H:i:s'),
                            'user_id' => $informasi_pemkab->user_id,
                            'unit_id' => $informasi_pemkab->unit_id,
                            'informasi_pemkab_id' => $informasi_pemkab->id,
                        ]);
                    }
                }
            });

            // BERHASIL UPDATE DATABASE, HAPUS FILE LAMA DARI DISK
            if ($oldFilePath) {
                Storage::disk('public')->delete($oldFilePath);
            }

            if ($request->expectsJson() || $request->wantsJson() || $request->is('api/*')) {
                return response()->json(['success' => true, 'message' => 'Dokumen berhasil diperbarui']);
            }
            return redirect()->route('frontend.informasi-pemkab.index')->with('success', 'Dokumen berhasil diperbarui');
        } catch (\Throwable $e) {
            if ($request->expectsJson() || $request->wantsJson() || $request->is('api/*')) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function destroy(InformasiPemkab $informasi_pemkab)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && $informasi_pemkab->unit_id != $user->unit_id && $informasi_pemkab->organization_id != $user->unit_id) {
            if (request()->expectsJson() || request()->wantsJson() || request()->is('api/*')) {
                return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
            }
            abort(403, 'Akses ditolak. Anda tidak berhak menghapus dokumen dinas lain.');
        }

        if ($informasi_pemkab->file_path && !str_starts_with($informasi_pemkab->file_path, 'http')) {
            Storage::disk('public')->delete($informasi_pemkab->file_path);
        }

        DB::transaction(function () use ($informasi_pemkab) {
            Informasi::where('informasi_pemkab_id', $informasi_pemkab->id)->delete();
            $informasi_pemkab->delete();
        });

        if (request()->expectsJson() || request()->wantsJson() || request()->is('api/*')) {
            return response()->json(['success' => true, 'message' => 'Dokumen berhasil dihapus.']);
        }
        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }

    public function editApi($slug)
    {
        $informasi_pemkab = InformasiPemkab::where('slug', $slug)->orWhere('id', $slug)->firstOrFail();
        return response()->json([
            'success' => true,
            'data' => $informasi_pemkab
        ]);
    }
}
