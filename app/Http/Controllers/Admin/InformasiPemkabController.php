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
        $informasi_pemkabs = InformasiPemkab::with(['user', 'organization'])->latest()->get();
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

        if (in_array($jenis_dokumen, $berkala_jenis)) {
            return 'Informasi Berkala';
        } elseif (in_array($jenis_dokumen, $serta_merta_jenis)) {
            return 'Informasi Serta Merta';
        }
        
        // Sisanya (seperti Peraturan, Aset, Kepegawaian, SOP, MoU, Audit, dll) 
        // akan otomatis masuk ke "Informasi Setiap Saat"
        return 'Informasi Setiap Saat';
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
            'file' => 'nullable|required_if:upload_method,file|file|mimes:pdf,doc,docx,xls,xlsx,zip,rar,png,jpg,jpeg,webp,svg|max:10240',
            'link' => 'nullable|required_if:upload_method,link|url|max:2048',
            'status' => 'required|in:draft,published,scheduled',
            'visibility' => 'required|in:public,private',
            'published_at' => 'nullable|required_if:status,scheduled|date',
        ]);

        try {
            $user_id = Auth::id();
            $unit_id = Auth::user()->unit_id ?? null;

            // Server-side Double Submit Protection (Title + Unit check within 10 seconds)
            $existing = InformasiPemkab::where('judul', $request->judul)
                                 ->where('unit_id', $unit_id)
                                 ->where('created_at', '>=', now()->subSeconds(10))
                                 ->first();
            
            if ($existing) {
                return redirect()->route('frontend.informasi-pemkab.index')
                    ->with('success', 'Dokumen sudah berhasil ditambahkan sebelumnya.');
            }

            $data = $request->except(['file', 'link', 'upload_method']);
            
            if ($request->upload_method === 'file' && $request->hasFile('file')) {
                $file = $request->file('file');
                $extension = strtolower($file->getClientOriginalExtension());
                
                if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
                    $imageManager = new \Intervention\Image\ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);
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
                        'tanggal_upload' => date('Y-m-d H:i:s'),
                        'user_id' => $informasi_pemkab->user_id,
                        'unit_id' => $informasi_pemkab->unit_id,
                        'informasi_pemkab_id' => $informasi_pemkab->id,
                    ]);
                }
            });

            return redirect()->route('frontend.informasi-pemkab.index')->with('success', 'Dokumen berhasil ditambahkan');
        } catch (\Exception $e) {
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
        return view('admin.informasi-pemkab.edit', compact('informasi_pemkab', 'kategori_jenis'));
    }

    public function update(Request $request, InformasiPemkab $informasi_pemkab)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && $informasi_pemkab->organization_id != $user->unit_id) {
            abort(403, 'Akses ditolak. Anda tidak berhak memperbarui dokumen dinas lain.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'jenis_dokumen' => 'required|string',
            'tahun' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'upload_method' => 'required|in:file,link',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip,rar,png,jpg,jpeg,webp,svg|max:10240',
            'link' => 'nullable|url|max:2048',
            'status' => 'required|in:draft,published,scheduled',
            'visibility' => 'required|in:public,private',
            'published_at' => 'nullable|required_if:status,scheduled|date',
        ]);

        try {
            $data = $request->except(['file', 'link', 'upload_method']);
            
            $oldFilePath = null; // Simpan file lama untuk dihapus NANTI

            if ($request->upload_method === 'file' && $request->hasFile('file')) {
                if ($informasi_pemkab->file_path && !str_starts_with($informasi_pemkab->file_path, 'http')) {
                    $oldFilePath = $informasi_pemkab->file_path;
                }
                
                $file = $request->file('file');
                $extension = strtolower($file->getClientOriginalExtension());
                
                if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
                    $imageManager = new \Intervention\Image\ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);
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
                            'tanggal_upload' => $informasi_pemkab->created_at ? $informasi_pemkab->created_at->format('Y-m-d H:i:s') : date('Y-m-d H:i:s'),
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

            return redirect()->route('frontend.informasi-pemkab.index')->with('success', 'Dokumen berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function destroy(InformasiPemkab $informasi_pemkab)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && $informasi_pemkab->organization_id != $user->unit_id) {
            abort(403, 'Akses ditolak. Anda tidak berhak menghapus dokumen dinas lain.');
        }

        if ($informasi_pemkab->file_path && !str_starts_with($informasi_pemkab->file_path, 'http')) {
            Storage::disk('public')->delete($informasi_pemkab->file_path);
        }

        DB::transaction(function () use ($informasi_pemkab) {
            Informasi::where('informasi_pemkab_id', $informasi_pemkab->id)->delete();
            $informasi_pemkab->delete();
        });

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
