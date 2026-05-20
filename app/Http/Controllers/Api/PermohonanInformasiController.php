<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PermohonanInformasi;
use App\Helpers\GeneralHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermohonanInformasiController extends Controller
{
    /**
     * Submit a new information request from Android.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_pemohon' => 'required|string|max:255',
                'alamat_pemohon' => 'required|string',
                'pekerjaan' => 'required|string|max:255',
                'nomor_telepon_pemohon' => 'required|string|max:20',
                'email_pemohon' => 'required|email|max:255',
                'detail_informasi' => 'required|string',
                'tujuan_penggunaan_informasi' => 'required|string',
                'cara_memperoleh_informasi' => 'required', // Bisa string atau array
                'cara_mendapatkan_salinan' => 'nullable', // Bisa string atau array
                'tempat_mendapatkan_salinan' => 'nullable|string',
                'privacy_status' => 'nullable|in:Publik,Anonim,Rahasia',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $validatedData = $validator->validated();

            // Penanganan cara_memperoleh_informasi (Konversi ke JSON jika array, pastikan format benar)
            if (is_array($validatedData['cara_memperoleh_informasi'])) {
                $validatedData['cara_memperoleh_informasi'] = json_encode($validatedData['cara_memperoleh_informasi']);
            } else {
                // Jika string, bungkus dalam array lalu JSON-kan agar konsisten dengan web
                $validatedData['cara_memperoleh_informasi'] = json_encode([$validatedData['cara_memperoleh_informasi']]);
            }

            // Penanganan cara_mendapatkan_salinan
            if (isset($validatedData['cara_mendapatkan_salinan'])) {
                if (is_array($validatedData['cara_mendapatkan_salinan'])) {
                    $validatedData['cara_mendapatkan_salinan'] = json_encode($validatedData['cara_mendapatkan_salinan']);
                } else {
                    $validatedData['cara_mendapatkan_salinan'] = json_encode([$validatedData['cara_mendapatkan_salinan']]);
                }
            }

            // Default privacy status if not provided
            $validatedData['privacy_status'] = $validatedData['privacy_status'] ?? 'Publik';

            // Link to user if authenticated via Sanctum
            if (auth('sanctum')->check()) {
                $validatedData['user_id'] = auth('sanctum')->id();
            }

            // Tambahkan unique_code (Sesuaikan dengan limit database: 5 karakter)
            $uniqueCode = '';
            do {
                $uniqueCode = GeneralHelper::generateUniqueCode(5);
            } while (PermohonanInformasi::where('unique_code', $uniqueCode)->exists());
            
            $validatedData['unique_code'] = $uniqueCode;

            $permohonan = PermohonanInformasi::create($validatedData);

            // Notifikasi Telegram
            $message = "<b>📄 Permohonan Informasi Baru (Mobile)</b>\n\n";
            $message .= "<b>🆔 Kode:</b> #{$permohonan->unique_code}\n";
            $message .= "<b>👤 Pemohon:</b> " . htmlspecialchars($permohonan->nama_pemohon) . "\n";
            $message .= "<b>💼 Pekerjaan:</b> " . htmlspecialchars($permohonan->pekerjaan) . "\n";
            $message .= "<b>📍 Alamat:</b> " . htmlspecialchars($permohonan->alamat_pemohon) . "\n";
            $message .= "<b>📝 Detail:</b>\n" . htmlspecialchars(substr($permohonan->detail_informasi, 0, 150)) . "...\n\n";
            $message .= "<b>🔒 Privasi:</b> {$permohonan->privacy_status}\n";
            $message .= '<a href="' . url('/admin/permohonan-informasi/' . $permohonan->id) . '">🔗 Lihat Detail di Website</a>';
            
            GeneralHelper::sendTelegramMessage($message);

            return response()->json([
                'success' => true,
                'message' => 'Permohonan berhasil dikirim',
                'data' => [
                    'unique_code' => $uniqueCode,
                    'permohonan' => $permohonan
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim permohonan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check status of a request using unique code.
     */
    public function checkStatus($code): JsonResponse
    {
        try {
            $permohonan = PermohonanInformasi::with('responses')
                ->where('unique_code', $code)
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'message' => 'Status permohonan berhasil ditemukan',
                'data' => $permohonan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Permohonan tidak ditemukan'
            ], 404);
        }
    }
}
