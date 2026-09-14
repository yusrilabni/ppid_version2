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
     * Get all requests belonging to the authenticated user.
     */
    public function myRequests(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $permohonan = PermohonanInformasi::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $permohonan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil riwayat permohonan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get detailed info of a specific request with responses.
     */
    public function show(Request $request, $id): JsonResponse
    {
        try {
            $user = $request->user();
            $permohonan = PermohonanInformasi::with(['responses.user'])
                ->where('user_id', $user->id)
                ->where('id', $id)
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => $permohonan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Permohonan tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update a pending request.
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $user = $request->user();
            $permohonan = PermohonanInformasi::where('user_id', $user->id)
                ->where('id', $id)
                ->firstOrFail();

            if ($permohonan->status_permohonan !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Permohonan yang sudah diproses tidak dapat diubah.'
                ], 403);
            }

            $validator = Validator::make($request->all(), [
                'nama_pemohon' => 'required|string|max:255',
                'alamat_pemohon' => 'required|string',
                'pekerjaan' => 'required|string|max:255',
                'nomor_telepon_pemohon' => 'required|string|max:20',
                'email_pemohon' => 'required|email|max:255',
                'detail_informasi' => 'required|string',
                'tujuan_penggunaan_informasi' => 'required|string',
                'cara_memperoleh_informasi' => 'required',
                'cara_mendapatkan_salinan' => 'nullable',
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

            // Handle arrays to JSON conversion
            if (is_array($validatedData['cara_memperoleh_informasi'])) {
                $validatedData['cara_memperoleh_informasi'] = json_encode($validatedData['cara_memperoleh_informasi']);
            }
            if (isset($validatedData['cara_mendapatkan_salinan']) && is_array($validatedData['cara_mendapatkan_salinan'])) {
                $validatedData['cara_mendapatkan_salinan'] = json_encode($validatedData['cara_mendapatkan_salinan']);
            }

            $permohonan->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Permohonan berhasil diperbarui',
                'data' => $permohonan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui permohonan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check status of a request using unique code.
     */
    public function getPekerjaanList(): JsonResponse
    {
        $defaultPekerjaan = [
            'ASN / Pegawai Negeri',
            'TNI / Polri',
            'Pegawai BUMN / BUMD',
            'Karyawan Swasta',
            'Wiraswasta / Pengusaha',
            'Pelajar / Mahasiswa',
            'Guru / Dosen',
            'Dokter / Tenaga Medis',
            'Wartawan / Jurnalis',
            'LSM / NGO',
            'Petani / Nelayan',
            'Pekerja Lepas / Freelancer',
            'Ibu Rumah Tangga',
            'Pensiunan',
            'Tidak / Belum Bekerja'
        ];

        try {
            $distinctPekerjaan = PermohonanInformasi::whereNotNull('pekerjaan')
                ->where('pekerjaan', '!=', '')
                ->distinct()
                ->pluck('pekerjaan')
                ->toArray();

            $merged = collect(array_merge($defaultPekerjaan, $distinctPekerjaan))
                ->map(function ($item) {
                    return ucwords(strtolower(trim($item)));
                })
                ->filter(function ($item) {
                    // Jangan masukkan jika hanya 'Lainnya' atau string kosong
                    return !empty($item) && strtolower($item) !== 'lainnya';
                })
                ->unique()
                ->sort()
                ->values();

            return response()->json([
                'success' => true,
                'data' => $merged
            ]);
        } catch (\Exception $e) {
            // Fallback ke default jika database error
            return response()->json([
                'success' => true,
                'data' => collect($defaultPekerjaan)->sort()->values()
            ]);
        }
    }

    public function checkStatus($code): JsonResponse
    {
        try {
            $permohonan = PermohonanInformasi::with('responses.user')
                ->where('unique_code', $code)
                ->firstOrFail();

            $user = auth('sanctum')->user();
            $isOwner = $user && $user->id == $permohonan->user_id;
            $isAdmin = $user && in_array($user->role, ['admin', 'superadmin']);
            $canViewSensitive = $isOwner || $isAdmin;

            if (!$canViewSensitive) {
                if ($permohonan->nomor_telepon_pemohon) {
                    $permohonan->nomor_telepon_pemohon = substr($permohonan->nomor_telepon_pemohon, 0, 3) . '********';
                }
                if ($permohonan->email_pemohon) {
                    $parts = explode('@', $permohonan->email_pemohon);
                    $permohonan->email_pemohon = substr($parts[0], 0, 3) . '***@' . ($parts[1] ?? '');
                }
                if ($permohonan->alamat_pemohon) {
                    $permohonan->alamat_pemohon = '*** (Disembunyikan untuk privasi) ***';
                }
                $permohonan->ktp_file_path = null;
            }

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

    public function downloadPdf(Request $request, $code)
    {
        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', '120');

        try {
            $permohonan = PermohonanInformasi::with('responses.user')
                ->where('unique_code', $code)
                ->firstOrFail();

            $user = auth('sanctum')->user();
            $isOwner = $user && $user->id == $permohonan->user_id;
            $isAdmin = $user && in_array($user->role, ['admin', 'superadmin']);
            $canViewSensitive = $isOwner || $isAdmin;

            $isPubliclyVisible = in_array($permohonan->privacy_status, ['Publik', 'Anonim']) &&
                                 in_array($permohonan->status_permohonan, ['selesai', 'ditolak']);

            // Jika tidak memiliki akses sensitif dan bukan permohonan yang boleh dipublish
            if (!$canViewSensitive && !$isPubliclyVisible) {
                return response()->json([
                    'success' => false,
                    'message' => 'Permohonan informasi tidak dapat diakses atau diunduh.'
                ], 403);
            }

            // Jika tidak punya akses sensitif, MASK data sebelum di-render ke PDF
            if (!$canViewSensitive) {
                if ($permohonan->nomor_telepon_pemohon) {
                    $permohonan->nomor_telepon_pemohon = substr($permohonan->nomor_telepon_pemohon, 0, 3) . '********';
                }
                if ($permohonan->email_pemohon) {
                    $parts = explode('@', $permohonan->email_pemohon);
                    $permohonan->email_pemohon = substr($parts[0], 0, 3) . '***@' . ($parts[1] ?? '');
                }
                if ($permohonan->alamat_pemohon) {
                    $permohonan->alamat_pemohon = '*** (Disembunyikan) ***';
                }
                $permohonan->ktp_file_path = null;
            }

            $ppidLogoBase64 = '';
            $logoPath = storage_path('app/public/logo/ppid.webp');
            
            if (file_exists($logoPath)) {
                try {
                    $logoContent = file_get_contents($logoPath);
                    $ppidLogoBase64 = 'data:image/webp;base64,' . base64_encode($logoContent);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Failed to encode PDF logo: " . $e->getMessage());
                }
            }

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.permohonan.pdf', [
                'permohonan' => $permohonan,
                'ppidLogoBase64' => $ppidLogoBase64
            ])->setPaper('a4', 'portrait')
              ->setWarnings(false)
              ->setOption([
                  'isRemoteEnabled' => false,
                  'isHtml5ParserEnabled' => true,
                  'defaultFont' => 'sans-serif'
              ]);
            
            $fileName = 'laporan-permohonan-' . $permohonan->unique_code . '.pdf';

            if ($request->query('action') === 'preview') {
                return $pdf->stream($fileName);
            }

            return $pdf->download($fileName);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunduh PDF: ' . $e->getMessage()
            ], 500);
        }
    }
}
