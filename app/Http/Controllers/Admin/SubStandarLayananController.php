<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubStandarLayanan;
use App\Models\StandarLayanan;
use App\Models\Informasi;
use App\Models\Statistik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GeneralHelper;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class SubStandarLayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = SubStandarLayanan::with(['standarLayanan', 'informasi'])->latest()->get();
        return view('admin.standar-layanan.index', compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = StandarLayanan::all();
        $informasi_categories = [
            'Informasi Berkala',
            'Informasi Setiap Saat',
            'Informasi Serta Merta',
            'Informasi Dikecualikan',
        ];
        $jenis_dokumen = [
            'Profil Badan Publik' => 'Profil Badan Publik (Sejarah, Visi Misi, Tupoksi, Struktur Organisasi, Profil Pimpinan, Domisili)',
            'Informasi Organisasi & Kepegawaian' => 'Informasi Organisasi & Kepegawaian (Data Statistik Pegawai, Daftar Pejabat Struktural, LHKPN/LHKASN)',
            'Dokumen Strategis' => 'Dokumen Strategis (RPJMD, Renstra, Renja, Indikator Kinerja Utama/IKU)',
            'Program & Kegiatan' => 'Program & Kegiatan (DPA, Kalender Kegiatan Tahunan, Ringkasan Program Kerja)',
            'Laporan Kinerja Instansi' => 'Laporan Kinerja Instansi (LKjIP, LKPJ, Laporan Tahunan Instansi)',
            'Informasi Keuangan' => 'Informasi Keuangan (RKA, LRA, Neraca, Laporan Arus Kas, CALK, Opini BPK)',
            'Pengadaan Barang/Jasa' => 'Pengadaan Barang/Jasa (RUP, Kerangka Acuan Kerja/KAK, Ringkasan Kontrak, Daftar Pemenang Tender)',
            'Daftar Aset dan Inventaris' => 'Daftar Aset dan Inventaris (Buku Inventaris Barang, Rekapitulasi Aset Daerah)',
            'Standar Layanan & SOP PPID' => 'Standar Layanan & SOP PPID (Maklumat Pelayanan, SOP Permohonan Informasi, SOP Sengketa, Standar Pelayanan Minimal/SPM)',
            'Daftar Informasi Publik & Laporan PPID' => 'Daftar Informasi Publik & Laporan PPID (Buku DIP Tahunan, Register Permohonan, Daftar Informasi Dikecualikan, Laporan Layanan Informasi)',
            'Regulasi & Peraturan' => 'Regulasi & Peraturan (Undang-Undang, Peraturan Pemerintah, Perda, Perbup, SK Kepala Daerah/Dinas)',
            'Perjanjian Kerja Sama / MoU' => 'Perjanjian Kerja Sama / MoU (Nota Kesepahaman Antar Lembaga, Kontrak Kerja Sama Pihak Ketiga)',
            'Pengumuman & Siaran Pers' => 'Pengumuman & Siaran Pers (Pengumuman Resmi, Siaran Pers, Surat Edaran, Hasil Survei Kepuasan Masyarakat/SKM)',
            'Informasi Serta Merta' => 'Informasi Serta Merta (Peringatan Dini Bencana, Informasi Gangguan Layanan Massal, Protokol Darurat)',
            'Lainnya' => 'Lainnya',
        ];

        $user = Auth::user();
        $isSuperAdmin = $user->isSuperAdmin();
        $units = collect();
        $userUnitId = null;
        $userUnitName = 'Unit Tidak Diketahui';

        $allUnits = $this->getUnitData();

        if ($isSuperAdmin) {
            $units = $allUnits;
        } else {
            $userUnitId = $user->unit_id;
            $unitMap = collect($allUnits)->keyBy('unit_id');
            $userUnitName = $unitMap->get($userUnitId)['unit_nama'] ?? 'Unit Tidak Diketahui';
        }

        return view('admin.standar-layanan.create', compact('categories', 'informasi_categories', 'jenis_dokumen', 'isSuperAdmin', 'units', 'userUnitId', 'userUnitName'));
    }

    private function getUnitData()
    {
        return GeneralHelper::getUnitData();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'standar_layanan_id' => 'required|exists:standar_layanans,id',
            'tahun_dokumen' => 'required|date',
            'file_type' => 'required|in:upload,url',
            'url' => 'nullable|url|required_if:file_type,url',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:10240|required_if:file_type,upload',
            'category' => 'required|string',
            'jenis_dokumen' => 'nullable|string',
            'status' => 'required|string|in:BERLAKU,ARSIP',
            'replacement_id' => 'nullable|integer|exists:informasis,id'
        ], [
            'file.max' => 'Ukuran file maksimal 10MB.',
        ]);

        // Prevent double submission (same title, same category, within 10 seconds)
        $duplicate = SubStandarLayanan::where('title', $request->title)
            ->where('standar_layanan_id', $request->standar_layanan_id)
            ->where('created_at', '>=', now()->subSeconds(10))
            ->first();

        if ($duplicate) {
            return redirect()->route('admin.standar-layanan.index')->with('success', 'File berhasil ditambahkan.');
        }

        DB::transaction(function () use ($request) {
            if ($request->filled('replacement_id')) {
                $informasiToArchive = Informasi::find($request->replacement_id);
                if ($informasiToArchive) {
                    $informasiToArchive->status = 'ARSIP';
                    $informasiToArchive->save();
                }
            }

            $data = $request->only(['title', 'standar_layanan_id', 'category', 'jenis_dokumen', 'tahun_dokumen', 'file_type']);

            if ($request->file_type == 'url') {
                $data['url'] = $request->url;
                $data['file'] = '';
            } elseif ($request->file_type == 'upload' && $request->hasFile('file')) {
                $file = $request->file('file');
                $extension = strtolower($file->getClientOriginalExtension());
                $imageExtensions = ['jpg', 'jpeg', 'png'];

                if (in_array($extension, $imageExtensions)) {
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($file->getRealPath());
                    $webpPath = 'standar_layanan_files/' . pathinfo($file->hashName(), PATHINFO_FILENAME) . '.webp';
                    
                    $encoded = $image->toWebp(80);
                    Storage::disk('public')->put($webpPath, (string) $encoded);

                    $data['file'] = $webpPath;
                } else {
                    $data['file'] = $file->store('standar_layanan_files', 'public');
                }
                $data['url'] = null;
            }

            $subStandarLayanan = SubStandarLayanan::create($data);
            
            $this->updateStatusTampil($request->standar_layanan_id);

            $sl = StandarLayanan::find($subStandarLayanan->standar_layanan_id);
            $deskripsi = 'Dokumen ini berasal dari standar layanan yang berisi tentang "' . $sl->title . '"';

            $user = Auth::user();
            $unit_id = $request->unit_id ?? $user->unit_id;

            Informasi::create([
                'title' => $subStandarLayanan->title,
                'deskripsi' => $deskripsi,
                'content' => 'sub standar layanan',
                'file' => $subStandarLayanan->file,
                'category' => $subStandarLayanan->category,
                'jenis_dokumen' => $subStandarLayanan->jenis_dokumen,
                'status' => $request->status,
                'tahun' => date('Y', strtotime($request->tahun_dokumen)),
                'tanggal_upload' => $request->tahun_dokumen,
                'user_id' => $user->id,
                'unit_id' => $unit_id,
                'url' => $subStandarLayanan->url,
                'sub_standar_layanan_id' => $subStandarLayanan->id,
            ]);
        });

        return redirect()->route('admin.standar-layanan.index')->with('success', 'File berhasil ditambahkan.');
    }

    public function edit(SubStandarLayanan $standarLayanan)
    {
        $categories = StandarLayanan::all();
        $informasi_categories = [
            'Informasi Berkala',
            'Informasi Setiap Saat',
            'Informasi Serta Merta',
            'Informasi Dikecualikan',
        ];
        $jenis_dokumen = [
            'Profil Badan Publik' => 'Profil Badan Publik (Sejarah, Visi Misi, Tupoksi, Struktur Organisasi, Profil Pimpinan, Domisili)',
            'Informasi Organisasi & Kepegawaian' => 'Informasi Organisasi & Kepegawaian (Data Statistik Pegawai, Daftar Pejabat Struktural, LHKPN/LHKASN)',
            'Dokumen Strategis' => 'Dokumen Strategis (RPJMD, Renstra, Renja, Indikator Kinerja Utama/IKU)',
            'Program & Kegiatan' => 'Program & Kegiatan (DPA, Kalender Kegiatan Tahunan, Ringkasan Program Kerja)',
            'Laporan Kinerja Instansi' => 'Laporan Kinerja Instansi (LKjIP, LKPJ, Laporan Tahun Instansi)',
            'Informasi Keuangan' => 'Informasi Keuangan (RKA, LRA, Neraca, Laporan Arus Kas, CALK, Opini BPK)',
            'Pengadaan Barang/Jasa' => 'Pengadaan Barang/Jasa (RUP, Kerangka Acuan Kerja/KAK, Ringkasan Kontrak, Daftar Pemenang Tender)',
            'Daftar Aset dan Inventaris' => 'Daftar Aset dan Inventaris (Buku Inventaris Barang, Rekapitulasi Aset Daerah)',
            'Standar Layanan & SOP PPID' => 'Standar Layanan & SOP PPID (Maklumat Pelayanan, SOP Permohonan Informasi, SOP Sengketa, Standar Pelayanan Minimal/SPM)',
            'Daftar Informasi Publik & Laporan PPID' => 'Daftar Informasi Publik & Laporan PPID (Buku DIP Tahunan, Register Permohonan, Daftar Informasi Dikecualikan, Laporan Layanan Informasi)',
            'Regulasi & Peraturan' => 'Regulasi & Peraturan (Undang-Undang, Peraturan Pemerintah, Perda, Perbup, SK Kepala Daerah/Dinas)',
            'Perjanjian Kerja Sama / MoU' => 'Perjanjian Kerja Sama / MoU (Nota Kesepahaman Antar Lembaga, Kontrak Kerja Sama Pihak Ketiga)',
            'Pengumuman & Siaran Pers' => 'Pengumuman & Siaran Pers (Pengumuman Resmi, Siaran Pers, Surat Edaran, Hasil Survei Kepuasan Masyarakat/SKM)',
            'Informasi Serta Merta' => 'Informasi Serta Merta (Peringatan Dini Bencana, Informasi Gangguan Layanan Massal, Protokol Darurat)',
            'Lainnya' => 'Lainnya',
        ];
        $informasi = Informasi::where('sub_standar_layanan_id', $standarLayanan->id)->first();

        $user = Auth::user();
        $isSuperAdmin = $user->isSuperAdmin();
        $units = collect();
        $userUnitId = null;
        $userUnitName = 'Unit Tidak Diketahui';

        $allUnits = $this->getUnitData();

        $unitMap = collect($allUnits)->keyBy('unit_id');
        if ($isSuperAdmin) {
            $units = $allUnits;
        } else {
            $userUnitId = $informasi->unit_id ?? $user->unit_id;
            $userUnitName = $unitMap->get($userUnitId)['unit_nama'] ?? 'Unit Tidak Diketahui';
        }

        return view('admin.standar-layanan.edit', compact('standarLayanan', 'categories', 'informasi_categories', 'jenis_dokumen', 'informasi', 'isSuperAdmin', 'units', 'userUnitId', 'userUnitName'));
    }

    public function update(Request $request, SubStandarLayanan $standarLayanan)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'standar_layanan_id' => 'required|exists:standar_layanans,id',
            'tahun_dokumen' => 'required|date',
            'file_type' => 'required|in:upload,url',
            'url' => 'nullable|url|required_if:file_type,url',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:10240',
            'category' => 'required|string',
            'jenis_dokumen' => 'nullable|string',
            'status' => 'required|string|in:BERLAKU,ARSIP',
            'replacement_id' => 'nullable|integer|exists:informasis,id'
        ], [
            'file.max' => 'Ukuran file maksimal 10MB.',
        ]);

        DB::transaction(function () use ($request, $standarLayanan) {
            if ($request->filled('replacement_id')) {
                $informasiToArchive = Informasi::find($request->replacement_id);
                if ($informasiToArchive) {
                    $informasiToArchive->status = 'ARSIP';
                    $informasiToArchive->save();
                }
            }

            $original_standar_layanan_id = $standarLayanan->standar_layanan_id;
            
            $standarLayanan->title = $request->title;
            $standarLayanan->standar_layanan_id = $request->standar_layanan_id;
            $standarLayanan->tahun_dokumen = $request->tahun_dokumen;
            $standarLayanan->category = $request->category;
            $standarLayanan->jenis_dokumen = $request->jenis_dokumen;

            if ($request->file_type == 'url') {
                if ($standarLayanan->file) {
                    Storage::disk('public')->delete($standarLayanan->file);
                }
                $standarLayanan->file_type = 'url';
                $standarLayanan->file = '';
                $standarLayanan->url = $request->url;
            } elseif ($request->file_type == 'upload') {
                if ($request->hasFile('file')) {
                    if ($standarLayanan->file) {
                        Storage::disk('public')->delete($standarLayanan->file);
                    }
                    $standarLayanan->file_type = 'upload';
                    
                    $file = $request->file('file');
                    $extension = strtolower($file->getClientOriginalExtension());
                    $imageExtensions = ['jpg', 'jpeg', 'png'];

                    if (in_array($extension, $imageExtensions)) {
                        $manager = new ImageManager(new Driver());
                    $image = $manager->read($file->getRealPath());
                        $webpPath = 'standar_layanan_files/' . pathinfo($file->hashName(), PATHINFO_FILENAME) . '.webp';
                        
                        $encoded = $image->toWebp(80);
                        Storage::disk('public')->put($webpPath, (string) $encoded);

                        $standarLayanan->file = $webpPath;
                    } else {
                        $standarLayanan->file = $file->store('standar_layanan_files', 'public');
                    }
                    $standarLayanan->url = null;
                }
            }
            
            $standarLayanan->save();

            $this->updateStatusTampil($request->standar_layanan_id);
            if ($original_standar_layanan_id != $request->standar_layanan_id) {
                $this->updateStatusTampil($original_standar_layanan_id);
            }
            
            $sl = StandarLayanan::find($standarLayanan->standar_layanan_id);
            $deskripsi = 'Dokumen ini berasal dari standar layanan yang berisi tentang "' . $sl->title . '"';

            $user = Auth::user();
            $unit_id = $request->unit_id ?? $user->unit_id;

            $informasi = Informasi::where('sub_standar_layanan_id', $standarLayanan->id)->first();
            if ($informasi) {
                $informasi->update([
                    'title' => $standarLayanan->title,
                    'deskripsi' => $deskripsi,
                    'category' => $standarLayanan->category,
                    'jenis_dokumen' => $standarLayanan->jenis_dokumen,
                    'file' => $standarLayanan->file,
                    'url' => $standarLayanan->url,
                    'status' => $request->status,
                    'tahun' => date('Y', strtotime($request->tahun_dokumen)),
                    'tanggal_upload' => $request->tahun_dokumen,
                    'unit_id' => $unit_id,
                    'user_id' => $user->id,
                ]);
            }
        });

        return redirect()->route('admin.standar-layanan.index')->with('success', 'File berhasil diperbarui.');
    }

    public function destroy(SubStandarLayanan $standarLayanan)

    {
        $standar_layanan_id = $standarLayanan->standar_layanan_id;
        $informasi = Informasi::where('sub_standar_layanan_id', $standarLayanan->id)->first();
        if ($informasi) {
            $informasi->delete();
        }
        Storage::disk('public')->delete($standarLayanan->file);

        $standarLayanan->delete();

        $this->updateStatusTampil($standar_layanan_id);

        return redirect()->route('admin.standar-layanan.index')->with('success', 'File berhasil dihapus.');

    }

    private function updateStatusTampil($standar_layanan_id)
    {
        $standarLayanan = StandarLayanan::find($standar_layanan_id);
        $categoryTitle = $standarLayanan->title;

        if (in_array(strtolower($categoryTitle), ['dasar hukum', 'sop'])) {
            SubStandarLayanan::where('standar_layanan_id', $standar_layanan_id)->update(['status_tampil' => 'aktif']);
        } else {
            $latestSub = SubStandarLayanan::where('standar_layanan_id', $standar_layanan_id)->orderBy('tahun_dokumen', 'desc')->first();
            if ($latestSub) {
                SubStandarLayanan::where('standar_layanan_id', $standar_layanan_id)->where('id', '!=', $latestSub->id)->update(['status_tampil' => 'draft']);
                $latestSub->update(['status_tampil' => 'aktif']);
            }
        }
    }
}