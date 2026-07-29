<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermohonanInformasi;
use App\Models\PermohonanResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GeneralHelper;

class PermohonanInformasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permohonanPending = PermohonanInformasi::with('user')->where('status_permohonan', 'pending')->get();
        $permohonanDiproses = PermohonanInformasi::with(['user', 'responses' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->where('status_permohonan', 'diproses')->get();
        $permohonanSelesai = PermohonanInformasi::with('user')->where('status_permohonan', 'selesai')->get();
        $permohonanDitolak = PermohonanInformasi::with('user')->where('status_permohonan', 'ditolak')->get();

        return view('admin.permohonan.index', compact('permohonanPending', 'permohonanDiproses', 'permohonanSelesai', 'permohonanDitolak'));
    }

    /**
     * Store a newly created resource in storage (Admin Response).
     */
    public function store(Request $request)
    {
        $request->validate([
            'permohonan_informasi_id' => 'required|exists:permohonan_informasi,id',
            'message' => 'required|string',
            'response_type' => 'required|string|in:Respon Awal,Tindaklanjut Permohonan,Pemberian Informasi,Penolakan,Klarifikasi',
            'file' => 'nullable|file|max:2048',
            'link' => 'nullable|url',
        ]);

        $data = [
            'permohonan_informasi_id' => $request->permohonan_informasi_id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'response_type' => $request->response_type,
            'link' => $request->link,
        ];

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('responses', 'public');
        }

        $response = PermohonanResponse::create($data);

        // Automatically update the status to 'diproses'
        $permohonan = PermohonanInformasi::find($request->permohonan_informasi_id);
        if ($permohonan) {
            $permohonan->status_permohonan = 'diproses';
            $permohonan->save();

            $admin = Auth::user();
            $adminName = GeneralHelper::escapeTelegramMarkdown($admin->name);
            $adminNip = GeneralHelper::escapeTelegramMarkdown($admin->nip ?? '-');
            
            // Masking pelapor jika Anonim/Rahasia
            $isPrivate = in_array($permohonan->privacy_status, ['Anonim', 'Rahasia']);
            $pelaporName = $isPrivate ? "Sesuai Prosedur Keamanan (" . $permohonan->privacy_status . ")" : $permohonan->nama_pemohon;
            $escPelapor = GeneralHelper::escapeTelegramMarkdown($pelaporName);
            $escMsg = GeneralHelper::escapeTelegramMarkdown($request->message);

            // Kirim Notifikasi Telegram dengan Tombol WhatsApp
            $tgMsg = "👨‍💼 *Admin Memberikan Tanggapan*\n\n"
                   . "🆔 *ID Permohonan:* #{$permohonan->unique_code}\n"
                   . "👤 *Kepada:* {$escPelapor}\n"
                   . "🏷️ *Tipe:* {$request->response_type}\n"
                   . "📩 *Pesan:* \n_{$escMsg}_\n\n";
            
            if ($request->link) {
                $tgMsg .= "🔗 *Tautan:* {$request->link}\n";
            }
            
            if ($request->hasFile('file')) {
                $tgMsg .= "📁 *Lampiran:* Tersedia di sistem\n";
            }

            $tgMsg .= "🛠️ *Oleh Admin:* {$adminName}\n"
                   . "📌 Status: *Diproses*.\n\n"
                   . "🔗 [Lihat Detail](" . route('admin.permohonan-informasi.show', $permohonan->id) . ")";
            
            // Siapkan URL WhatsApp untuk Pemohon
            $waPhone = GeneralHelper::formatPhoneNumber($permohonan->nomor_telepon_pemohon);
            $directLink = route('laporan.permohonan.show', $permohonan->unique_code);
            $adminPesan = strlen($request->message) > 300 
                ? "_Pesan admin terlalu panjang. Silakan klik tautan di bawah untuk membaca rincian tanggapan lengkap._" 
                : "_{$request->message}_";

            $waMessage = "*NOTIFIKASI PPID KABUPATEN SINJAI*\n\n"
                       . "Halo {$permohonan->nama_pemohon},\n"
                       . "Permohonan Informasi Anda dengan ID *#{$permohonan->unique_code}* telah mendapatkan tanggapan dari Admin.\n\n"
                       . "*Status:* Diproses\n"
                       . "*Pesan Admin:* \n{$adminPesan}\n\n";

            if ($request->link) {
                $waMessage .= "*Tautan Eksternal:* \n{$request->link}\n\n";
            }

            $waMessage .= "Silakan cek detail lengkap melalui tautan berikut:\n"
                       . $directLink . "\n\n"
                       . "Kami sangat menghargai jika Anda bersedia memberikan penilaian (rating) atas layanan dan informasi yang kami berikan melalui tautan di atas. Masukan Anda sangat berarti bagi kami untuk terus meningkatkan kualitas pelayanan ke depannya.\n\n"
                       . "Terima kasih.";
            
            $waUrl = "https://api.whatsapp.com/send?phone={$waPhone}&text=" . rawurlencode($waMessage);

            // Tambahkan tombol di Telegram
            $buttons = [
                [
                    ['text' => '📱 Kirim WhatsApp ke Pemohon', 'url' => $waUrl],
                ]
            ];
            
            GeneralHelper::sendTelegramMessage($tgMsg, $buttons);

            return redirect()->route('admin.permohonan-informasi.show', $permohonan)
                             ->with('success', 'Tanggapan berhasil disimpan.')
                             ->with('wa_url', $waUrl);
        }

        return redirect()->route('admin.permohonan-informasi.show', $permohonan)
                         ->with('success', 'Tanggapan berhasil disimpan.');
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
            'status_permohonan' => 'required|in:pending,diproses,selesai,ditolak',
        ]);

        $permohonan_informasi->update($request->only('status_permohonan'));

        return redirect()->route('admin.permohonan-informasi.index')
                         ->with('success', 'Status permohonan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PermohonanInformasi $permohonan_informasi)
    {
        $permohonan_informasi->delete();

        return redirect()->route('admin.permohonan-informasi.index')
                         ->with('success', 'Permohonan berhasil dihapus.');
    }

    /**
     * Mark the specified resource as completed.
     */
    public function complete(PermohonanInformasi $permohonan_informasi)
    {
        $permohonan_informasi->status_permohonan = 'selesai';
        $permohonan_informasi->save();

        $admin = Auth::user();
        $adminName = GeneralHelper::escapeTelegramMarkdown($admin->name);
        $adminNip = GeneralHelper::escapeTelegramMarkdown($admin->nip ?? '-');

        // Masking pelapor jika Anonim/Rahasia
        $isPrivate = in_array($permohonan_informasi->privacy_status, ['Anonim', 'Rahasia']);
        $pelaporName = $isPrivate ? "Sesuai Prosedur Keamanan (" . $permohonan_informasi->privacy_status . ")" : $permohonan_informasi->nama_pemohon;
        $escPelapor = GeneralHelper::escapeTelegramMarkdown($pelaporName);

        // Kirim Notifikasi Telegram
        $tgMsg = "✅ *Permohonan Selesai*\n\n"
               . "🆔 *ID Permohonan:* #{$permohonan_informasi->unique_code}\n"
               . "👤 *Pemohon:* {$escPelapor}\n"
               . "🛠️ *Oleh Admin:* {$adminName}\n"
               . "🪪 *NIP:* {$adminNip}\n"
               . "🏁 Permohonan telah ditandai sebagai *Selesai* oleh Admin.\n\n"
               . "🔗 [Lihat Detail](" . route('admin.permohonan-informasi.show', $permohonan_informasi->id) . ")";
        
        // Notifikasi WhatsApp Selesai
        $waPhone = GeneralHelper::formatPhoneNumber($permohonan_informasi->nomor_telepon_pemohon);
        $directLink = route('laporan.permohonan.show', $permohonan_informasi->unique_code);
        $waMessage = "*NOTIFIKASI PPID KABUPATEN SINJAI*\n\n"
                   . "Halo {$permohonan_informasi->nama_pemohon},\n"
                   . "Permohonan Informasi Anda (#{$permohonan_informasi->unique_code}) telah dinyatakan *SELESAI* oleh Admin.\n\n"
                   . "Silakan berikan penilaian Anda terhadap layanan kami melalui tautan berikut:\n"
                   . $directLink . "\n\n"
                   . "Kami sangat menghargai jika Anda bersedia memberikan penilaian (rating) atas layanan kami. Masukan Anda sangat berarti bagi kami untuk terus meningkatkan kualitas pelayanan.\n\n"
                   . "Terima kasih.";
        
        $waUrl = "https://api.whatsapp.com/send?phone={$waPhone}&text=" . rawurlencode($waMessage);

        // Tambahkan tombol di Telegram
        $buttons = [
            [
                ['text' => '📱 Kirim WhatsApp ke Pemohon', 'url' => $waUrl],
            ]
        ];

        GeneralHelper::sendTelegramMessage($tgMsg, $buttons);

        return redirect()->route('admin.permohonan-informasi.index')
                         ->with('success', 'Permohonan berhasil diselesaikan.')
                         ->with('wa_url', $waUrl);
    }

    /**
     * Mark the specified resource as rejected.
     */
    public function reject(PermohonanInformasi $permohonan_informasi)
    {
        $permohonan_informasi->status_permohonan = 'ditolak';
        $permohonan_informasi->save();

        $admin = Auth::user();
        $adminName = GeneralHelper::escapeTelegramMarkdown($admin->name);
        $adminNip = GeneralHelper::escapeTelegramMarkdown($admin->nip ?? '-');

        // Masking pelapor jika Anonim/Rahasia
        $isPrivate = in_array($permohonan_informasi->privacy_status, ['Anonim', 'Rahasia']);
        $pelaporName = $isPrivate ? "Sesuai Prosedur Keamanan (" . $permohonan_informasi->privacy_status . ")" : $permohonan_informasi->nama_pemohon;
        $escPelapor = GeneralHelper::escapeTelegramMarkdown($pelaporName);

        // Kirim Notifikasi Telegram
        $tgMsg = "❌ *Permohonan Ditolak*\n\n"
               . "🆔 *ID Permohonan:* #{$permohonan_informasi->unique_code}\n"
               . "👤 *Pemohon:* {$escPelapor}\n"
               . "🛠️ *Oleh Admin:* {$adminName}\n"
               . "🪪 *NIP:* {$adminNip}\n"
               . "🚫 Permohonan telah *Ditolak* oleh Admin.\n\n"
               . "🔗 [Lihat Detail](" . route('admin.permohonan-informasi.show', $permohonan_informasi->id) . ")";
        
        // Optionally, add a default rejection response
        PermohonanResponse::create([
            'permohonan_informasi_id' => $permohonan_informasi->id, // Tetap gunakan id internal untuk relasi
            'user_id' => Auth::id(),
            'message' => 'Permohonan ditolak oleh admin.',
            'response_type' => 'Tindaklanjut Permohonan', // Or a specific type for rejection
        ]);

        // Notifikasi WhatsApp Ditolak
        $waPhone = GeneralHelper::formatPhoneNumber($permohonan_informasi->nomor_telepon_pemohon);
        $directLink = route('laporan.permohonan.show', $permohonan_informasi->unique_code);
        $waMessage = "*NOTIFIKASI PPID KABUPATEN SINJAI*\n\n"
                   . "Mohon maaf {$permohonan_informasi->nama_pemohon},\n"
                   . "Permohonan Informasi Anda (#{$permohonan_informasi->unique_code}) telah *DITOLAK* oleh Admin.\n\n"
                   . "Silakan cek alasan penolakan melalui tautan berikut:\n"
                   . $directLink . "\n\n"
                   . "Meskipun demikian, kami tetap menghargai jika Anda bersedia memberikan penilaian atas respon layanan kami sebagai bahan evaluasi ke depannya.\n\n"
                   . "Terima kasih.";
        
        $waUrl = "https://api.whatsapp.com/send?phone={$waPhone}&text=" . rawurlencode($waMessage);

        // Tambahkan tombol di Telegram
        $buttons = [
            [
                ['text' => '📱 Kirim WhatsApp ke Pemohon', 'url' => $waUrl],
            ]
        ];

        GeneralHelper::sendTelegramMessage($tgMsg, $buttons);

        return redirect()->route('admin.permohonan-informasi.index')
                         ->with('success', 'Permohonan berhasil ditolak.')
                         ->with('wa_url', $waUrl);
    }

    /**
     * Resend notification for a specific response.
     */
    public function resendNotification(PermohonanResponse $response)
    {
        $permohonan = $response->permohonanInformasi;
        $admin = Auth::user();
        
        // Telegram Notification
        $adminName = GeneralHelper::escapeTelegramMarkdown($admin->name);
        $adminNip = GeneralHelper::escapeTelegramMarkdown($admin->nip ?? '-');
        
        $isPrivate = in_array($permohonan->privacy_status, ['Anonim', 'Rahasia']);
        $pelaporName = $isPrivate ? "Sesuai Prosedur Keamanan (" . $permohonan->privacy_status . ")" : $permohonan->nama_pemohon;
        $escPelapor = GeneralHelper::escapeTelegramMarkdown($pelaporName);
        $escMsg = GeneralHelper::escapeTelegramMarkdown($response->message ?? '(File/Tautan)');

        $tgMsg = "🔄 *Admin Mengirim Ulang Notifikasi*\n\n"
               . "🆔 *ID Permohonan:* #{$permohonan->unique_code}\n"
               . "👤 *Kepada:* {$escPelapor}\n"
               . "📩 *Pesan:* \n_{$escMsg}_\n\n"
               . "🛠️ *Oleh Admin:* {$adminName}\n"
               . "🪪 *NIP:* {$adminNip}\n"
               . "📢 Notifikasi dikirim ulang ke WhatsApp Pemohon.\n"
               . "🔗 [Lihat Detail](" . route('admin.permohonan-informasi.show', $permohonan->id) . ")";
        
        // WhatsApp Notification
        $waPhone = GeneralHelper::formatPhoneNumber($permohonan->nomor_telepon_pemohon);
        $directLink = route('laporan.permohonan.show', $permohonan->unique_code);
        $adminPesan = strlen($response->message) > 300 
            ? "_Pesan admin terlalu panjang. Silakan klik tautan di bawah untuk membaca rincian tanggapan lengkap._" 
            : "_{$response->message}_";

        $waMessage = "*PENGIRIMAN ULANG NOTIFIKASI PPID KABUPATEN SINJAI*\n\n"
                   . "Halo {$permohonan->nama_pemohon},\n"
                   . "Berikut adalah informasi terkait permohonan Anda (#{$permohonan->unique_code}):\n\n"
                   . "*Isi Balasan:* \n{$adminPesan}\n\n"
                   . "Silakan cek detail lengkap dan unduh file melalui tautan berikut:\n"
                   . $directLink . "\n\n"
                   . "Kami sangat menghargai jika Anda bersedia memberikan penilaian (rating) atas layanan dan informasi yang kami berikan. Masukan Anda sangat berarti bagi kami untuk terus meningkatkan kualitas pelayanan ke depannya.\n\n"
                   . "Terima kasih.";
        
        $waUrl = "https://api.whatsapp.com/send?phone={$waPhone}&text=" . rawurlencode($waMessage);

        // Tambahkan tombol di Telegram
        $buttons = [
            [
                ['text' => '📱 Kirim WhatsApp ke Pemohon', 'url' => $waUrl],
            ]
        ];

        GeneralHelper::sendTelegramMessage($tgMsg, $buttons);

        return redirect()->back()
                         ->with('success', 'Notifikasi berhasil dikirim ulang ke Telegram dan WhatsApp.')
                         ->with('wa_url', $waUrl);
    }
}
