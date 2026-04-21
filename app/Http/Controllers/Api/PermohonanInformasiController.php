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
                'cara_memperoleh_informasi' => 'required|string',
                'cara_mendapatkan_salinan' => 'required|string',
                'tempat_mendapatkan_salinan' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Generate Unique Code (e.g., REQ-XXXXX)
            $uniqueCode = 'REQ-' . strtoupper(GeneralHelper::generateUniqueCode(6));

            $permohonan = PermohonanInformasi::create(array_merge(
                $validator->validated(),
                ['unique_code' => $uniqueCode]
            ));

            // Optional: Send Notification to Telegram (using existing helper)
            $message = "<b>🔔 Permohonan Informasi Baru (via Android)</b>\n\n";
            $message .= "Nama: {$permohonan->nama_pemohon}\n";
            $message .= "Kode: <code>{$permohonan->unique_code}</code>\n";
            $message .= "Tujuan: {$permohonan->tujuan_penggunaan_informasi}";
            
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
