<?php

namespace App\Http\Controllers;

use App\Models\PermohonanInformasi;
use App\Models\PermohonanResponse;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Helpers\GeneralHelper;

class LaporanPermohonanController extends Controller
{
    private function getUnitData()
    {
        return GeneralHelper::getUnitData();
    }

    public function index(Request $request)
    {
        $query = PermohonanInformasi::query()
            ->whereIn('privacy_status', ['Publik', 'Anonim'])
            ->whereIn('status_permohonan', ['selesai', 'ditolak']);

        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_pemohon', 'like', '%' . $searchTerm . '%')
                    ->orWhere('unique_code', 'like', '%' . $searchTerm . '%')
                    ->orWhere('detail_informasi', 'like', '%' . $searchTerm . '%')
                    ->orWhere('status_permohonan', 'like', '%' . $searchTerm . '%')
                    ->orWhere('privacy_status', 'like', '%' . $searchTerm . '%');
            });
        }

        // Apply date filters
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply sorting
        $sort = $request->get('sort', 'created_at_desc');
        switch ($sort) {
            case 'nama_pemohon_asc':
                $query->orderBy('nama_pemohon', 'asc');
                break;
            case 'nama_pemohon_desc':
                $query->orderBy('nama_pemohon', 'desc');
                break;
            case 'created_at_asc':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $perPage = $request->get('per_page', 10);
        $permohonan = $query->paginate($perPage);

        return view('laporan.permohonan.index', compact('permohonan'));
    }

    public function show(PermohonanInformasi $permohonanInformasi)
    {
        // 1. Jika belum login, middleware 'auth' biasanya sudah menangani, 
        // tapi kita pastikan URL tujuan disimpan (Intended URL)
        if (!auth()->check()) {
            return redirect()->guest(route('login'));
        }

        $permohonan = $permohonanInformasi->load('user', 'responses.user');
        $isOwner = auth()->id() == $permohonan->user_id;

        // Public view conditions (untuk user lain jika status publik)
        $isPubliclyVisible = in_array($permohonan->privacy_status, ['Publik', 'Anonim']) &&
                             in_array($permohonan->status_permohonan, ['selesai', 'ditolak']);

        // 2. Cek Sinkronisasi Akun
        if (!$isOwner && !$isPubliclyVisible) {
            // Jika dia login tapi bukan pemilik dan data tidak publik
            abort(403, 'Akses Dibatasi: Akun Anda tidak tersinkronisasi dengan data permohonan ini. Silakan masuk menggunakan akun yang digunakan saat mengajukan permohonan agar dapat mengakses detail informasi ini.');
        }
        
        $units = $this->getUnitData();

        return view('laporan.permohonan.show', compact('permohonan', 'units', 'isOwner'));
    }

    public function edit(PermohonanInformasi $permohonanInformasi)
    {
        // Authorize: Ensure the user is the owner and status is 'pending'
        if (auth()->id() != $permohonanInformasi->user_id) {
            abort(403, 'Anda tidak diizinkan mengubah permohonan ini.');
        }
        if ($permohonanInformasi->status_permohonan != 'pending') {
            return redirect()->route('laporan.permohonan.show', $permohonanInformasi)
                            ->with('error', 'Permohonan tidak dapat diubah karena tidak lagi dalam status "pending".');
        }

        $units = $this->getUnitData();
        $permohonan = $permohonanInformasi; // for clarity in the view

        return view('laporan.permohonan.edit', compact('permohonan', 'units'));
    }

    public function update(Request $request, PermohonanInformasi $permohonanInformasi)
    {
        // Authorize: Ensure the user is the owner and status is 'pending'
        if (auth()->id() != $permohonanInformasi->user_id) {
            abort(403, 'Anda tidak diizinkan mengubah permohonan ini.');
        }
        if ($permohonanInformasi->status_permohonan != 'pending') {
            return redirect()->route('laporan.permohonan.show', $permohonanInformasi)
                            ->with('error', 'Permohonan tidak dapat diubah karena tidak lagi dalam status "pending".');
        }

        $validatedData = $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'alamat_pemohon' => 'required|string',
            'pekerjaan' => 'required|string|max:255',
            'nomor_telepon_pemohon' => 'required|string|max:20',
            'email_pemohon' => 'required|email|max:255',
            'detail_informasi' => 'required|string',
            'tujuan_penggunaan_informasi' => 'required|string',
            'cara_memperoleh_informasi' => 'required|array',
            'cara_memperoleh_informasi.*' => 'in:Melihat/Membaca/Mendengarkan,Mendapat Salinan Informasi',
            'cara_mendapatkan_salinan' => 'nullable|array',
            'cara_mendapatkan_salinan.*' => 'in:Mengambil,Kurir,Pos,Faksmail,E-Mail',
            'tempat_mendapatkan_salinan' => 'nullable|string|max:255', // unit_id from external API
            'privacy_status' => 'required|in:Publik,Anonim,Rahasia',
        ]);

        // Convert array fields to JSON strings
        $validatedData['cara_memperoleh_informasi'] = json_encode($validatedData['cara_memperoleh_informasi']);
        $validatedData['cara_mendapatkan_salinan'] = isset($validatedData['cara_mendapatkan_salinan']) ? json_encode($validatedData['cara_mendapatkan_salinan']) : null;

        // Set tempat_mendapatkan_salinan to null if "Mengambil" is not selected or if it's empty
        if (!isset($request->cara_mendapatkan_salinan) || !in_array('Mengambil', $request->cara_mendapatkan_salinan) || empty($validatedData['tempat_mendapatkan_salinan'])) {
            $validatedData['tempat_mendapatkan_salinan'] = null;
        }

        $permohonanInformasi->update($validatedData);

        // Kirim Notifikasi Telegram
        $tgMsg = "<b>🔄 Permohonan Informasi Diperbarui</b>\n\n"
               . "<b>🆔 ID:</b> #{$permohonanInformasi->unique_code}\n"
               . "<b>👤 Pemohon:</b> " . htmlspecialchars($permohonanInformasi->nama_pemohon) . "\n"
               . "<b>💼 Pekerjaan:</b> " . htmlspecialchars($permohonanInformasi->pekerjaan) . "\n"
               . "<b>📍 Alamat:</b> " . htmlspecialchars($permohonanInformasi->alamat_pemohon) . "\n"
               . "<b>📧 Email:</b> " . htmlspecialchars($permohonanInformasi->email_pemohon) . "\n"
               . "<b>📞 Telp:</b> " . htmlspecialchars($permohonanInformasi->nomor_telepon_pemohon) . "\n\n"
               . "<b>📝 Informasi (Baru):</b>\n" . htmlspecialchars($permohonanInformasi->detail_informasi) . "\n\n"
               . "<b>🎯 Tujuan:</b>\n" . htmlspecialchars($permohonanInformasi->tujuan_penggunaan_informasi) . "\n\n"
               . "<b>🔒 Privasi:</b> {$permohonanInformasi->privacy_status}\n\n"
               . '<a href="' . route('admin.permohonan-informasi.show', $permohonanInformasi->id) . '">🔗 Lihat Detail di Website</a>';
        
        $buttons = [
            [
                ['text' => '✅ Respon Awal (Auto)', 'callback_data' => "respond_awal_{$permohonanInformasi->id}"],
                ['text' => '❌ Tolak', 'callback_data' => "reject_permohonan_{$permohonanInformasi->id}"]
            ]
        ];

        GeneralHelper::sendTelegramMessage($tgMsg, $buttons);

        return redirect()->route('laporan.permohonan.saya')
                        ->with('success', 'Permohonan informasi berhasil diperbarui.');
    }

    public function destroy(PermohonanInformasi $permohonanInformasi)
    {
        // Authorize: Ensure the user is the owner and status is 'pending'
        if (auth()->id() != $permohonanInformasi->user_id) {
            abort(403, 'Anda tidak diizinkan menghapus permohonan ini.');
        }
        if ($permohonanInformasi->status_permohonan != 'pending') {
            return redirect()->route('laporan.permohonan.saya')
                            ->with('error', 'Permohonan tidak dapat dihapus karena tidak lagi dalam status "pending".');
        }

        $permohonanInformasi->delete();

        return redirect()->route('laporan.permohonan.saya')
                        ->with('success', 'Permohonan informasi berhasil dihapus.');
    }

    public function myRequests(Request $request)
    {
        $query = PermohonanInformasi::query()->where('user_id', auth()->id());

        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_pemohon', 'like', '%' . $searchTerm . '%')
                    ->orWhere('unique_code', 'like', '%' . $searchTerm . '%')
                    ->orWhere('detail_informasi', 'like', '%' . $searchTerm . '%')
                    ->orWhere('status_permohonan', 'like', '%' . $searchTerm . '%')
                    ->orWhere('privacy_status', 'like', '%' . $searchTerm . '%');
            });
        }

        // Apply date filters
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply sorting
        $sort = $request->get('sort', 'created_at_desc');
        switch ($sort) {
            case 'nama_pemohon_asc':
                $query->orderBy('nama_pemohon', 'asc');
                break;
            case 'nama_pemohon_desc':
                $query->orderBy('nama_pemohon', 'desc');
                break;
            case 'created_at_asc':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $perPage = $request->get('per_page', 10);
        $permohonan = $query->paginate($perPage);

        return view('laporan.permohonan.index', compact('permohonan'));
    }

    public function create()
    {
        $units = $this->getUnitData();
        return view('laporan.permohonan.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'alamat_pemohon' => 'required|string',
            'pekerjaan' => 'required|string|max:255',
            'nomor_telepon_pemohon' => 'required|string|max:20',
            'email_pemohon' => 'required|email|max:255',
            'detail_informasi' => 'required|string',
            'tujuan_penggunaan_informasi' => 'required|string',
            'cara_memperoleh_informasi' => 'required|array',
            'cara_memperoleh_informasi.*' => 'in:Melihat/Membaca/Mendengarkan,Mendapat Salinan Informasi',
            'cara_mendapatkan_salinan' => 'nullable|array',
            'cara_mendapatkan_salinan.*' => 'in:Mengambil,Kurir,Pos,Faksmail,E-Mail',
            'tempat_mendapatkan_salinan' => 'nullable|string|max:255', // unit_id from external API
            'privacy_status' => 'required|in:Publik,Anonim,Rahasia',
        ]);

        // Convert array fields to JSON strings
        $validatedData['cara_memperoleh_informasi'] = json_encode($validatedData['cara_memperoleh_informasi']);
        $validatedData['cara_mendapatkan_salinan'] = isset($validatedData['cara_mendapatkan_salinan']) ? json_encode($validatedData['cara_mendapatkan_salinan']) : null;

        // Set tempat_mendapatkan_salinan to null if "Mengambil" is not selected or if it's empty
        if (!isset($request->cara_mendapatkan_salinan) || !in_array('Mengambil', $request->cara_mendapatkan_salinan) || empty($validatedData['tempat_mendapatkan_salinan'])) {
            $validatedData['tempat_mendapatkan_salinan'] = null;
        }

        // Add the authenticated user's ID
        $validatedData['user_id'] = auth()->id();

        // Tambahkan unique_code
        $uniqueCode = '';
        do {
            $uniqueCode = GeneralHelper::generateUniqueCode(5);
        } while (PermohonanInformasi::where('unique_code', $uniqueCode)->exists());

        $validatedData['unique_code'] = $uniqueCode; // Tambahkan unique_code ke data yang divalidasi

        $permohonan = PermohonanInformasi::create($validatedData);

        // Kirim Notifikasi Telegram
        $tgMsg = "<b>📄 Permohonan Informasi Baru</b>\n\n"
               . "<b>🆔 ID:</b> #{$uniqueCode}\n"
               . "<b>👤 Pemohon:</b> " . htmlspecialchars($permohonan->nama_pemohon) . "\n"
               . "<b>💼 Pekerjaan:</b> " . htmlspecialchars($permohonan->pekerjaan) . "\n"
               . "<b>📍 Alamat:</b> " . htmlspecialchars($permohonan->alamat_pemohon) . "\n"
               . "<b>📧 Email:</b> " . htmlspecialchars($permohonan->email_pemohon) . "\n"
               . "<b>📞 Telp:</b> " . htmlspecialchars($permohonan->nomor_telepon_pemohon) . "\n\n"
               . "<b>📝 Informasi:</b>\n" . htmlspecialchars($permohonan->detail_informasi) . "\n\n"
               . "<b>🎯 Tujuan:</b>\n" . htmlspecialchars($permohonan->tujuan_penggunaan_informasi) . "\n\n"
               . "<b>🔒 Privasi:</b> {$permohonan->privacy_status}\n\n"
               . '<a href="' . route('admin.permohonan-informasi.show', $permohonan->id) . '">🔗 Lihat Detail di Website</a>';
        
        $buttons = [
            [
                ['text' => '✅ Respon Awal (Auto)', 'callback_data' => "respond_awal_{$permohonan->id}"],
                ['text' => '❌ Tolak', 'callback_data' => "reject_permohonan_{$permohonan->id}"]
            ]
        ];

        GeneralHelper::sendTelegramMessage($tgMsg, $buttons);

        return redirect()->route('laporan.permohonan.saya')->with('success', 'Permohonan informasi berhasil dikirim.');
    }

    public function addResponse(Request $request, PermohonanInformasi $permohonanInformasi)
    {
        // 1. Authorize: Ensure the authenticated user is the owner of the request
        if (auth()->id() != $permohonanInformasi->user_id) {
            abort(403, 'Anda tidak diizinkan menanggapi permohonan ini.');
        }

        // 2. Authorize: Ensure the status is 'diproses'
        if ($permohonanInformasi->status_permohonan != 'diproses') {
            return redirect()->back()->with('error', 'Anda hanya dapat menanggapi permohonan yang sedang dalam proses.');
        }

        // 3. Validate the request
        $validatedData = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        // 4. Create the response
        PermohonanResponse::create([
            'permohonan_informasi_id' => $permohonanInformasi->id,
            'user_id' => auth()->id(), // The user (applicant) is the one responding
            'message' => $validatedData['message'],
            'file_path' => null, // Not allowing file uploads for this user response for now
            'link' => null,
        ]);

        // Kirim Notifikasi Telegram
        $escNama = GeneralHelper::escapeTelegramMarkdown($permohonanInformasi->nama_pemohon);
        $escEmail = GeneralHelper::escapeTelegramMarkdown($permohonanInformasi->email_pemohon);
        $escMessage = GeneralHelper::escapeTelegramMarkdown($validatedData['message']);

        $tgMsg = "💬 *Tanggapan Baru dari Pemohon*\n\n"
               . "🆔 *ID Permohonan:* #{$permohonanInformasi->unique_code}\n"
               . "👤 *Dari:* {$escNama}\n"
               . "📧 *Email:* {$escEmail}\n"
               . "📩 *Pesan:* \n_{$escMessage}_\n\n"
               . "🔗 [Lihat Detail](" . route('admin.permohonan-informasi.show', $permohonanInformasi->id) . ")";
        
        GeneralHelper::sendTelegramMessage($tgMsg);

        // 5. Redirect back with a success message
        return redirect()->route('laporan.permohonan.show', $permohonanInformasi)
                         ->with('success', 'Tanggapan Anda berhasil dikirim.');
    }

    public function rate(Request $request, PermohonanInformasi $permohonanInformasi)
    {
        // 1. Authorize: Ensure the authenticated user is the owner of the request
        if (auth()->id() != $permohonanInformasi->user_id) {
            abort(403, 'Anda tidak diizinkan memberikan penilaian untuk permohonan ini.');
        }

        // 2. Authorize: Ensure there is a response
        if ($permohonanInformasi->responses->isEmpty()) {
            return redirect()->back()->with('error', 'Anda belum bisa memberikan penilaian karena belum ada tanggapan.');
        }

        $isFirstRating = is_null($permohonanInformasi->rating);

        // 3. Validate the request
        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'message' => ($isFirstRating ? 'required' : 'nullable') . '|string|max:5000',
        ]);
        
        // 4. Update the request
        $permohonanInformasi->rating = $validatedData['rating'];
        
        // Mark as 'selesai' only on the first rating
        if ($isFirstRating) {
            $permohonanInformasi->status_permohonan = 'selesai';
        }
        
        $permohonanInformasi->save();

        // Jika ada pesan tanggapan akhir, simpan ke responses
        if (!empty($validatedData['message'])) {
            PermohonanResponse::create([
                'permohonan_informasi_id' => $permohonanInformasi->id,
                'user_id' => auth()->id(),
                'message' => $validatedData['message'],
            ]);
        }

        // Kirim Notifikasi Telegram (Satu Pesan Terpadu)
        $escNama = GeneralHelper::escapeTelegramMarkdown($permohonanInformasi->nama_pemohon);
        $stars = str_repeat('⭐', $validatedData['rating']);
        
        $tgMsg = "🌟 *Penilaian & Tanggapan Akhir*\n\n"
               . "🆔 *ID Permohonan:* #{$permohonanInformasi->unique_code}\n"
               . "👤 *Nama:* {$escNama}\n"
               . "⭐ *Rating:* {$stars} ({$validatedData['rating']}/5)\n";

        if (!empty($validatedData['message'])) {
            $escMsg = GeneralHelper::escapeTelegramMarkdown($validatedData['message']);
            $tgMsg .= "📩 *Tanggapan Penutup:* \n_{$escMsg}_\n";
        }

        $tgMsg .= "\n" . ($isFirstRating ? "🏁 *Permohonan Selesai*" : "🔄 *Penilaian Diperbarui*") . "\n"
               . "🔗 [Lihat Detail](" . route('admin.permohonan-informasi.show', $permohonanInformasi->id) . ")";
        
        GeneralHelper::sendTelegramMessage($tgMsg);

        // 5. Redirect back with a success message
        $message = $isFirstRating 
            ? 'Terima kasih! Penilaian Anda telah kami terima dan permohonan ini telah ditandai sebagai selesai.'
            : 'Penilaian Anda berhasil diperbarui.';

        return redirect()->route('laporan.permohonan.show', $permohonanInformasi)
                         ->with('success', $message);
    }

    public function downloadPDF(Request $request, PermohonanInformasi $permohonanInformasi)
    {
        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', '120');

        // 1. Eager load relationships to prevent lazy loading in view
        $permohonanInformasi->load(['user', 'responses.user']);

        // 2. Access control
        $isOwner = auth()->check() && auth()->id() == $permohonanInformasi->user_id;
        $isPubliclyVisible = in_array($permohonanInformasi->privacy_status, ['Publik', 'Anonim']) &&
                             in_array($permohonanInformasi->status_permohonan, ['selesai', 'ditolak']);

        if (!$isOwner && !$isPubliclyVisible) {
            abort(404, 'Permohonan informasi tidak ditemukan atau tidak dapat diakses.');
        }

        // 3. Prepare Logo
        $ppidLogoBase64 = '';
        $logoPath = storage_path('app/public/logo/ppid.webp');
        
        if (file_exists($logoPath)) {
            try {
                $logoContent = file_get_contents($logoPath);
                $ppidLogoBase64 = 'data:image/webp;base64,' . base64_encode($logoContent);
            } catch (\Exception $e) {
                Log::error("Failed to encode PDF logo: " . $e->getMessage());
            }
        }

        // 4. Generate PDF
        try {
            $pdf = Pdf::loadView('laporan.permohonan.pdf', [
                'permohonan' => $permohonanInformasi,
                'ppidLogoBase64' => $ppidLogoBase64
            ])->setPaper('a4', 'portrait')
              ->setWarnings(false)
              ->setOption([
                  'isRemoteEnabled' => false, // Matikan remote agar tidak loading lama mencari aset luar
                  'isHtml5ParserEnabled' => true,
                  'defaultFont' => 'sans-serif'
              ]);
            
            $fileName = 'laporan-permohonan-' . $permohonanInformasi->unique_code . '.pdf';

            if ($request->query('action') === 'preview') {
                return $pdf->stream($fileName);
            }

            return $pdf->download($fileName);
        } catch (\Exception $e) {
            Log::error("PDF Generation Error: " . $e->getMessage());
            return back()->with('error', 'Gagal membuat file PDF. Silakan hubungi admin.');
        }
    }
}
