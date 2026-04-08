<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermohonanInformasi;
use App\Models\PermohonanResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\TelegramService;

class PermohonanInformasiController extends Controller
{
    protected $telegram;

    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permohonanPending = PermohonanInformasi::with('user')->where('status_permohonan', 'pending')->get();
        $permohonanDiproses = PermohonanInformasi::with(['user', 'responses' => function($query) {
            $query->latest(); // Order by created_at DESC
        }])->where('status_permohonan', 'diproses')->get();
        $permohonanSelesai = PermohonanInformasi::with('user')->where('status_permohonan', 'selesai')->get();
        $permohonanDitolak = PermohonanInformasi::with('user')->where('status_permohonan', 'ditolak')->get();

        return view('admin.permohonan.index', compact('permohonanPending', 'permohonanDiproses', 'permohonanSelesai', 'permohonanDitolak'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'permohonan_informasi_id' => 'required|exists:permohonan_informasi,id',
            'response_type' => 'required|string|in:Respon Awal,Tindaklanjut',
            'message' => 'nullable|string',
            'file' => 'nullable|file|max:10240', // Max 10MB
            'link' => 'nullable|url',
        ]);

        $filePath = null;
        $file = $request->file('file');
        if ($file && $file->isValid()) {
            $filePath = $file->store('permohonan_files', 'public');
        }

        PermohonanResponse::create([
            'permohonan_informasi_id' => $request->permohonan_informasi_id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'response_type' => $request->response_type,
            'file_path' => $filePath,
            'link' => $request->link,
        ]);

        // Automatically update the status to 'diproses'
        $permohonan = PermohonanInformasi::find($request->permohonan_informasi_id);
        if ($permohonan) {
            $permohonan->status_permohonan = 'diproses';
            $permohonan->save();

            // Kirim Notifikasi Telegram
            $tgMessage = "👨‍💼 *Admin Memberikan Tanggapan*\n\n"
                     . "🆔 *ID Permohonan:* #{$permohonan->unique_code}\n"
                     . "👤 *Kepada:* {$permohonan->nama_pemohon}\n"
                     . "🏷️ *Tipe:* {$request->response_type}\n"
                     . "📩 *Pesan:* \n_{$request->message}_\n\n"
                     . "📌 Status diperbarui menjadi *Diproses*.\n"
                     . "🔗 [Lihat Detail](" . route('admin.permohonan-informasi.show', $permohonan->id) . ")";
            
            $this->telegram->sendMessage($tgMessage);
        }

        return redirect()->route('admin.permohonan-informasi.show', $permohonan)
                         ->with('success', 'Jawaban berhasil dikirim dan status otomatis diperbarui menjadi "Diproses".');
    }

    /**
     * Display the specified resource.
     */
    public function show(PermohonanInformasi $permohonan_informasi)
    {
        $permohonan_informasi->load('user', 'responses.user');
        return view('admin.permohonan.show', ['permohonan' => $permohonan_informasi]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PermohonanInformasi $permohonan_informasi)
    {
        return view('admin.permohonan.edit', ['permohonan' => $permohonan_informasi]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PermohonanInformasi $permohonan_informasi)
    {
        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'email_pemohon' => 'required|email|max:255',
            'detail_informasi' => 'required|string',
            'status_permohonan' => 'required|in:pending,diproses,selesai,ditolak',
        ]);

        $permohonan_informasi->update($request->all());

        return redirect()->route('admin.permohonan-informasi.show', $permohonan_informasi)
                         ->with('success', 'Permohonan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PermohonanInformasi $permohonan_informasi)
    {
        // Delete associated responses
        $permohonan_informasi->responses()->delete();

        // Delete the main request
        $permohonan_informasi->delete();

        return redirect()->route('admin.permohonan-informasi.index')
                         ->with('success', 'Permohonan berhasil dihapus.');
    }

    /**
     * Mark the specified resource as complete.
     */
    public function complete(PermohonanInformasi $permohonan_informasi)
    {
        $permohonan_informasi->status_permohonan = 'selesai';
        $permohonan_informasi->save();

        // Kirim Notifikasi Telegram
        $tgMessage = "✅ *Permohonan Selesai*\n\n"
                 . "🆔 *ID Permohonan:* #{$permohonan_informasi->unique_code}\n"
                 . "👤 *Pemohon:* {$permohonan_informasi->nama_pemohon}\n"
                 . "🏁 Permohonan telah ditandai sebagai *Selesai* oleh Admin.\n\n"
                 . "🔗 [Lihat Detail](" . route('admin.permohonan-informasi.show', $permohonan_informasi->id) . ")";
        
        $this->telegram->sendMessage($tgMessage);

        return redirect()->route('admin.permohonan-informasi.index')
                         ->with('success', 'Permohonan ditandai sebagai Selesai.');
    }

    /**
     * Mark the specified resource as rejected.
     */
    public function reject(PermohonanInformasi $permohonan_informasi)
    {
        $permohonan_informasi->status_permohonan = 'ditolak';
        $permohonan_informasi->save();

        // Kirim Notifikasi Telegram
        $tgMessage = "❌ *Permohonan Ditolak*\n\n"
                 . "🆔 *ID Permohonan:* #{$permohonan_informasi->unique_code}\n"
                 . "👤 *Pemohon:* {$permohonan_informasi->nama_pemohon}\n"
                 . "🚫 Permohonan telah *Ditolak* oleh Admin.\n\n"
                 . "🔗 [Lihat Detail](" . route('admin.permohonan-informasi.show', $permohonan_informasi->id) . ")";
        
        $this->telegram->sendMessage($tgMessage);

        // Optionally, add a default rejection response
        PermohonanResponse::create([
            'permohonan_informasi_id' => $permohonan_informasi->id, // Tetap gunakan id internal untuk relasi
            'user_id' => Auth::id(),
            'message' => 'Permohonan ditolak oleh admin.',
            'response_type' => 'Tindaklanjut Permohonan', // Or a specific type for rejection
        ]);

        return redirect()->route('admin.permohonan-informasi.index')
                         ->with('success', 'Permohonan ditandai sebagai Ditolak.');
    }
}
