<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;
use App\Models\Informasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Galeri::query();
        
        if (\Illuminate\Support\Facades\Schema::hasColumn('galeris', 'is_pinned')) {
            $query->orderBy('is_pinned', 'desc');
        }
        
        $galeris = $query->orderBy('created_at', 'desc')->get();
        
        return view('admin.galeri.index', compact('galeris'));
    }

    /**
     * Toggle the pinned status of the specified resource.
     *
     * @param  \App\Models\Galeri  $galeri
     * @return \Illuminate\Http\Response
     */
    public function togglePin(Galeri $galeri)
    {
        if (!\Illuminate\Support\Facades\Schema::hasColumn('galeris', 'is_pinned')) {
            return back()->with('deleted', 'Fitur Pin belum aktif. Silakan hubungi admin server untuk menjalankan php artisan migrate.');
        }

        $galeri->update([
            'is_pinned' => !$galeri->is_pinned
        ]);

        $status = $galeri->is_pinned ? 'di-pin' : 'dilepas dari pin';
        return back()->with('success', "Foto berhasil $status.");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = [
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
        return view('admin.galeri.create', compact('categories', 'jenis_dokumen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:foto,video',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|url',
            'category' => 'nullable|string|in:Informasi Berkala,Informasi Setiap Saat,Informasi Serta Merta,Informasi Dikecualikan',
            'jenis_dokumen' => 'nullable|string',
        ]);

        $data = $request->except(['image']);
        $imagePathFinal = null;

        if ($request->hasFile('image')) {
            // Process the image: resize and convert to WebP
            $image = $request->file('image');

            // Use Intervention Image to process the image
            $imageManager = new \Intervention\Image\ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);
            $imageInstance = $imageManager->read($image->path());

            // Convert to WebP and reduce quality if needed to keep under 2MB
            $quality = 80; // Start with 80% quality
            $imageInstance = $imageInstance->toWebp($quality);

            // Check the file size and reduce quality if necessary
            $imagePath = tempnam(sys_get_temp_dir(), 'galeri_') . '.webp';
            $imageInstance->save($imagePath);

            while (filesize($imagePath) > 2 * 1024 * 1024 && $quality > 20) { // While file is larger than 2MB and quality > 20
                $quality -= 10;
                $imageInstance = $imageManager->read($image->path())->toWebp($quality);
                $imageInstance->save($imagePath);
            }

            // Store the processed image in the public/galeri directory
            $fileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
            $imagePathFinal = 'galeri/' . $fileName;
            Storage::disk('public')->put($imagePathFinal, file_get_contents($imagePath));

            // Clean up temporary file
            unlink($imagePath);

            $data['image'] = $imagePathFinal;
        }

        $galeri = Galeri::create($data);
        
        if ($galeri) {
            $user = Auth::user();
            $unit_id = $user->unit_id;

            if (!$unit_id) {
                // Optionally delete the just-created galeri to avoid orphaned records
                $galeri->delete();
                if ($imagePathFinal) {
                    Storage::disk('public')->delete($imagePathFinal);
                }
                return back()->withInput()->withErrors(['unit_id' => 'Unit kerja untuk pengguna ini tidak dapat ditemukan.']);
            }

            if ($request->filled('category') && $request->filled('jenis_dokumen')) {
                Informasi::create([
                    'title' => $galeri->title,
                    'content' => 'galeri',
                    'deskripsi' => $galeri->description,
                    'file' => $imagePathFinal,
                    'status' => 'aktif',
                    'category' => $galeri->category,
                    'jenis_dokumen' => $request->jenis_dokumen,
                    'user_id' => $user->id,
                    'unit_id' => $unit_id,
                    'tahun' => now()->year,
                    'tanggal_upload' => now()->toDateString(),
                ]);
            }
        }


        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Galeri  $galeri
     * @return \Illuminate\Http\Response
     */
    public function show(Galeri $galeri)
    {
        return view('admin.galeri.show', compact('galeri'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Galeri  $galeri
     * @return \Illuminate\Http\Response
     */
    public function edit(Galeri $galeri)
    {
        $categories = [
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
        return view('admin.galeri.edit', compact('galeri', 'categories', 'jenis_dokumen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Galeri  $galeri
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:foto,video',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|url',
            'category' => 'nullable|string|in:Informasi Berkala,Informasi Setiap Saat,Informasi Serta Merta,Informasi Dikecualikan',
            'jenis_dokumen' => 'nullable|string',
        ]);

        $informasi = Informasi::where('title', $galeri->title)->where('content', 'galeri')->first();

        $data = $request->except(['image']);
        $imagePathFinal = $galeri->image;

        if ($request->hasFile('image')) {
            // Process the image: resize and convert to WebP
            $image = $request->file('image');

            // Use Intervention Image to process the image
            $imageManager = new \Intervention\Image\ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);
            $imageInstance = $imageManager->read($image->path());

            // Convert to WebP and reduce quality if needed to keep under 2MB
            $quality = 80; // Start with 80% quality
            $imageInstance = $imageInstance->toWebp($quality);

            // Check the file size and reduce quality if necessary
            $imagePath = tempnam(sys_get_temp_dir(), 'galeri_') . '.webp';
            $imageInstance->save($imagePath);

            while (filesize($imagePath) > 2 * 1024 * 1024 && $quality > 20) { // While file is larger than 2MB and quality > 20
                $quality -= 10;
                $imageInstance = $imageManager->read($image->path())->toWebp($quality);
                $imageInstance->save($imagePath);
            }

            // Store the processed image in the public/galeri directory
            $fileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
            $imagePathFinal = 'galeri/' . $fileName;
            Storage::disk('public')->put($imagePathFinal, file_get_contents($imagePath));

            // Clean up temporary file
            unlink($imagePath);

            // If the galeri had an old image, delete it
            if ($galeri->image) {
                Storage::disk('public')->delete($galeri->image);
            }

            $data['image'] = $imagePathFinal;
        }

        $galeri->update($data);

        $user = Auth::user(); // Assuming Auth::user() is available here
        $unit_id = $user->unit_id; // Assuming unit_id is available from the user

        if ($request->filled('category') && $request->filled('jenis_dokumen')) {
            if ($informasi) {
                // Update existing Informasi record
                $informasi->update([
                    'title' => $request->title,
                    'deskripsi' => $request->description,
                    'file' => $imagePathFinal,
                    'category' => $request->category,
                    'jenis_dokumen' => $request->jenis_dokumen,
                ]);
            } else {
                // Create new Informasi record if it doesn't exist and categories are filled
                Informasi::create([
                    'title' => $request->title,
                    'content' => 'galeri',
                    'deskripsi' => $request->description,
                    'file' => $imagePathFinal,
                    'status' => 'aktif',
                    'category' => $request->category,
                    'jenis_dokumen' => $request->jenis_dokumen,
                    'user_id' => $user->id,
                    'unit_id' => $unit_id,
                    'tahun' => now()->year,
                    'tanggal_upload' => now()->toDateString(),
                ]);
            }
        } elseif ($informasi) {
            // If category or jenis_dokumen are not filled, and an Informasi record exists, delete it
            $informasi->delete();
        }


        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Galeri  $galeri
     * @return \Illuminate\Http\Response
     */
    public function destroy(Galeri $galeri)
    {
        $informasi = Informasi::where('title', $galeri->title)->where('content', 'galeri')->first();
        if($informasi){
            $informasi->delete();
        }
        
        // Delete associated image file if it exists
        if ($galeri->image) {
            Storage::disk('public')->delete($galeri->image);
        }

        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('deleted', 'Galeri berhasil dihapus.');
    }
}
