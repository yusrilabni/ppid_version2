<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Helpers\GeneralHelper;

class SliderController extends Controller
{
    private function getUnitData()
    {
        return GeneralHelper::getUnitData();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::all();
        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $isSuperAdmin = $user->isSuperAdmin();
        $units = [];
        if ($isSuperAdmin) {
            $units = $this->getUnitData();
        }

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

        return view('admin.sliders.create', compact('isSuperAdmin', 'units', 'categories', 'jenis_dokumen'));
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'link' => 'nullable|url',
            'order' => 'nullable|integer',
            'category' => 'nullable|string|in:Informasi Berkala,Informasi Setiap Saat,Informasi Serta Merta,Informasi Dikecualikan',
            'jenis_dokumen' => 'nullable|string',
        ]);

        $path = $request->file('image')->store('sliders', 'public');

        $slider = Slider::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $path,
            'link' => $request->link,
            'order' => $request->order ?? 0,
            'active' => $request->boolean('active'),
            'show_title' => $request->has('show_title'), // Checkbox: true if checked, false if unchecked
            'show_description' => $request->has('show_description'), // Checkbox: true if checked, false if unchecked
            'category' => $request->category,
            'jenis_dokumen' => $request->jenis_dokumen,
        ]);
        if ($slider) {
            $user = Auth::user();
            $unit_id = $user->unit_id;

            if (!$unit_id) {
                // Optionally delete the just-created slider to avoid orphaned records
                $slider->delete();
                Storage::disk('public')->delete($path);
                return back()->withInput()->withErrors(['unit_id' => 'Unit kerja untuk pengguna ini tidak dapat ditemukan.']);
            }

            if ($request->filled('category') && $request->filled('jenis_dokumen')) {
                Informasi::create([
                    'title' => $slider->title,
                    'content' => 'slider home page',
                    'deskripsi' => $slider->description,
                    'file' => $slider->image,
                    'status' => 'aktif',
                    'category' => $slider->category,
                    'jenis_dokumen' => $slider->jenis_dokumen,
                    'user_id' => $user->id,
                    'unit_id' => $unit_id,
                    'tahun' => now()->year,
                    'tanggal_upload' => now()->toDateString(),
                ]);
            }
        }

        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        $user = Auth::user();
        $isSuperAdmin = $user->isSuperAdmin();
        $units = [];
        if ($isSuperAdmin) {
            $units = $this->getUnitData();
        }

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

        return view('admin.sliders.edit', compact('slider', 'isSuperAdmin', 'units', 'categories', 'jenis_dokumen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'link' => 'nullable|url',
            'order' => 'nullable|integer',
            'category' => 'nullable|string|in:Informasi Berkala,Informasi Setiap Saat,Informasi Serta Merta,Informasi Dikecualikan',
            'jenis_dokumen' => 'nullable|string',
        ]);

        // Find the corresponding Informasi record before slider is updated
        $informasi = Informasi::where('title', $slider->title)->first();

        $path = $slider->image;

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($slider->image);

            $path = $request->file('image')->store('sliders', 'public');
        }

        $slider->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $path,
            'link' => $request->link,
            'order' => $request->order ?? 0,
            'active' => $request->boolean('active'),
            'show_title' => $request->has('show_title'), // Checkbox: true if checked, false if unchecked
            'show_description' => $request->has('show_description'), // Checkbox: true if checked, false if unchecked
            'category' => $request->category,
            'jenis_dokumen' => $request->jenis_dokumen,
        ]);        $user = Auth::user();
        $unit_id = $user->unit_id;

        if ($request->filled('category') && $request->filled('jenis_dokumen')) {
            if ($informasi) {
                // Update existing Informasi record
                $informasi->update([
                    'title' => $request->title,
                    'deskripsi' => $request->description,
                    'file' => $path,
                    'category' => $request->category,
                    'jenis_dokumen' => $request->jenis_dokumen,
                ]);
            } else {
                // Create new Informasi record if it doesn't exist and categories are filled
                Informasi::create([
                    'title' => $request->title,
                    'content' => 'slider home page',
                    'deskripsi' => $request->description,
                    'file' => $path,
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

        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        // Find and delete the corresponding Informasi record
        $informasi = Informasi::where('title', $slider->title)->first();
        if ($informasi) {
            $informasi->delete();
        }

        // Delete the associated image file if it exists
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('deleted', 'Slider berhasil dihapus.');
    }
}