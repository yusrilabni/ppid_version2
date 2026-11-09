<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermohonanInformasi;
use App\Models\PermohonanResponse;
use App\Models\KeberatanInformasi;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PermohonanKeberatanAdminController extends Controller
{
    /**
     * Pastikan hanya user berwenang (admin OPD / superadmin) yang dapat mengakses.
     */
    private function checkAdminAccess(Request $request): ?JsonResponse
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        // Cek role admin / superadmin
        $role = strtolower($user->role ?? '');
        $isSuperAdmin = method_exists($user, 'isSuperAdmin') ? $user->isSuperAdmin() : ($role === 'superadmin');
        $isAdmin = in_array($role, ['admin', 'superadmin', 'opd', 'petugas']);

        if (!$isAdmin && !$isSuperAdmin) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak. Halaman khusus pengelola PPID.'], 403);
        }

        return null;
    }

    /**
     * ==========================================
     * 1. MANAJEMEN PERMOHONAN INFORMASI
     * ==========================================
     */

    /**
     * Daftar Permohonan Informasi Masuk
     */
    public function getPermohonan(Request $request): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;

        try {
            $user = $request->user();
            $query = PermohonanInformasi::with(['user:id,name,email,nip,unit_id', 'responses.user:id,name']);

            // Jika admin OPD non-superadmin, batasi sesuai unit kerja jika ada relasi
            if (method_exists($user, 'isSuperAdmin') && !$user->isSuperAdmin() && $user->unit_id) {
                $query->where(function ($q) use ($user) {
                    $q->whereHas('user', function ($uq) use ($user) {
                        $uq->where('unit_id', $user->unit_id);
                    })->orWhereNull('user_id');
                });
            }

            // Filter Status
            if ($request->filled('status') && $request->status !== 'all') {
                $query->where('status_permohonan', $request->status);
            }

            // Filter Pencarian
            if ($request->filled('search')) {
                $s = trim($request->search);
                $query->where(function ($q) use ($s) {
                    $q->where('unique_code', 'like', "%{$s}%")
                      ->orWhere('nama_pemohon', 'like', "%{$s}%")
                      ->orWhere('detail_informasi', 'like', "%{$s}%")
                      ->orWhere('email_pemohon', 'like', "%{$s}%");
                });
            }

            $perPage = min((int) ($request->per_page ?? 15), 100);
            $data = $query->orderBy('created_at', 'desc')->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $data,
                'stats' => [
                    'total' => PermohonanInformasi::count(),
                    'pending' => PermohonanInformasi::where('status_permohonan', 'pending')->count(),
                    'diproses' => PermohonanInformasi::where('status_permohonan', 'diproses')->count(),
                    'selesai' => PermohonanInformasi::where('status_permohonan', 'selesai')->count(),
                    'ditolak' => PermohonanInformasi::where('status_permohonan', 'ditolak')->count(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Admin getPermohonan error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memuat data permohonan.'], 500);
        }
    }

    /**
     * Detail Permohonan Informasi
     */
    public function showPermohonan(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;

        try {
            $permohonan = PermohonanInformasi::with(['user', 'responses.user'])
                ->where('id', $id)
                ->orWhere('unique_code', $id)
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => $permohonan
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Data permohonan tidak ditemukan.'], 404);
        }
    }

    /**
     * Berikan Tanggapan / Jawaban Resmi Permohonan
     */
    public function respondPermohonan(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;

        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
            'response_type' => 'nullable|string|in:jawaban,penolakan,klarifikasi,dokumen',
            'link' => 'nullable|url',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
            'update_status' => 'nullable|in:pending,diproses,selesai,ditolak',
        ], [
            'message.required' => 'Pesan tanggapan wajib diisi.',
            'link.url' => 'Format tautan/URL tidak valid.',
            'file.max' => 'Ukuran berkas maksimal 10 MB.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $permohonan = PermohonanInformasi::where('id', $id)
                ->orWhere('unique_code', $id)
                ->firstOrFail();

            $filePath = null;
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $filePath = $request->file('file')->store('permohonan_responses', 'public');
            }

            $response = PermohonanResponse::create([
                'permohonan_informasi_id' => $permohonan->id,
                'user_id' => $request->user()->id,
                'message' => $request->message,
                'response_type' => $request->response_type ?? 'jawaban',
                'file_path' => $filePath,
                'link' => $request->link,
            ]);

            // Update status permohonan jika dipilih
            if ($request->filled('update_status')) {
                $permohonan->status_permohonan = $request->update_status;
                $permohonan->save();
            } elseif ($permohonan->status_permohonan === 'pending') {
                $permohonan->status_permohonan = 'diproses';
                $permohonan->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Tanggapan berhasil disimpan.',
                'data' => $response->load('user:id,name'),
                'current_status' => $permohonan->status_permohonan
            ]);
        } catch (\Exception $e) {
            Log::error('Admin respondPermohonan error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan tanggapan.'], 500);
        }
    }

    /**
     * Update Status Permohonan (misal langsung Selesai / Tolak)
     */
    public function updatePermohonanStatus(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'alasan_penolakan' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $permohonan = PermohonanInformasi::where('id', $id)
                ->orWhere('unique_code', $id)
                ->firstOrFail();

            $permohonan->status_permohonan = $request->status;
            if ($request->filled('alasan_penolakan')) {
                $permohonan->alasan_penolakan = $request->alasan_penolakan;
            }
            $permohonan->save();

            return response()->json([
                'success' => true,
                'message' => "Status permohonan berhasil diperbarui menjadi {$request->status}.",
                'data' => $permohonan
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengubah status.'], 500);
        }
    }

    /**
     * ==========================================
     * 2. MANAJEMEN KEBERATAN INFORMASI
     * ==========================================
     */

    /**
     * Daftar Permohonan Keberatan Masuk
     */
    public function getKeberatan(Request $request): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;

        try {
            $query = KeberatanInformasi::with(['user:id,name,email', 'permohonan']);

            // Filter Status Keberatan
            if ($request->filled('status') && $request->status !== 'all') {
                $query->where('status_keberatan', $request->status);
            }

            // Filter Pencarian
            if ($request->filled('search')) {
                $s = trim($request->search);
                $query->where(function ($q) use ($s) {
                    $q->where('unique_code', 'like', "%{$s}%")
                      ->orWhere('nama_pemohon', 'like', "%{$s}%")
                      ->orWhere('nomor_pendaftaran_pemohon', 'like', "%{$s}%")
                      ->orWhere('alasan_keberatan', 'like', "%{$s}%")
                      ->orWhere('email_pemohon', 'like', "%{$s}%");
                });
            }

            $perPage = min((int) ($request->per_page ?? 15), 100);
            $data = $query->orderBy('created_at', 'desc')->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $data,
                'stats' => [
                    'total' => KeberatanInformasi::count(),
                    'pending' => KeberatanInformasi::where('status_keberatan', 'pending')->count(),
                    'diproses' => KeberatanInformasi::where('status_keberatan', 'diproses')->count(),
                    'selesai' => KeberatanInformasi::where('status_keberatan', 'selesai')->count(),
                    'ditolak' => KeberatanInformasi::where('status_keberatan', 'ditolak')->count(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Admin getKeberatan error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memuat data keberatan.'], 500);
        }
    }

    /**
     * Detail Keberatan Informasi
     */
    public function showKeberatan(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;

        try {
            $keberatan = KeberatanInformasi::with(['user', 'permohonan.responses.user'])
                ->where('id', $id)
                ->orWhere('unique_code', $id)
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => $keberatan
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Data keberatan tidak ditemukan.'], 404);
        }
    }

    /**
     * Berikan Tanggapan / Putusan Atasan PPID Terhadap Keberatan
     */
    public function respondKeberatan(Request $request, $id): JsonResponse
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;

        $validator = Validator::make($request->all(), [
            'status_keberatan' => 'required|in:diproses,selesai,ditolak',
            'tanggapan_atasan' => 'nullable|string',
            'surat_tanggapan' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ], [
            'status_keberatan.required' => 'Pilih status tindak lanjut keberatan.',
            'surat_tanggapan.max' => 'Ukuran berkas surat tanggapan maksimal 10 MB.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $keberatan = KeberatanInformasi::where('id', $id)
                ->orWhere('unique_code', $id)
                ->firstOrFail();

            $keberatan->status_keberatan = $request->status_keberatan;
            $keberatan->tanggal_tanggapan = Carbon::now();

            if ($request->filled('tanggapan_atasan')) {
                // Simpan uraian tanggapan ke kolom atau log
                $keberatan->kasus_posisi = $keberatan->kasus_posisi . "\n\n[Tanggapan Atasan PPID (" . Carbon::now()->format('d/m/Y H:i') . ")]: " . $request->tanggapan_atasan;
            }

            if ($request->hasFile('surat_tanggapan') && $request->file('surat_tanggapan')->isValid()) {
                $filePath = $request->file('surat_tanggapan')->store('keberatan_tanggapan', 'public');
                $keberatan->surat_kuasa_path = $filePath; // atau lampiran hasil
            }

            $keberatan->save();

            return response()->json([
                'success' => true,
                'message' => 'Tanggapan dan status keberatan berhasil diperbarui.',
                'data' => $keberatan
            ]);
        } catch (\Exception $e) {
            Log::error('Admin respondKeberatan error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memproses tanggapan keberatan.'], 500);
        }
    }

    /**
     * ==========================================
     * 3. CETAK / GENERATE LAPORAN PPID (PDF)
     * ==========================================
     */
    public function exportLaporanPdf(Request $request)
    {
        if ($denied = $this->checkAdminAccess($request)) return $denied;

        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', '180');

        try {
            $year = $request->input('year', date('Y'));
            $startDate = $request->input('start_date', "{$year}-01-01");
            $endDate = $request->input('end_date', "{$year}-12-31 23:59:59");

            // Rekap Permohonan Informasi
            $totalPermohonan = PermohonanInformasi::whereBetween('created_at', [$startDate, $endDate])->count();
            $permohonanSelesai = PermohonanInformasi::whereBetween('created_at', [$startDate, $endDate])->where('status_permohonan', 'selesai')->count();
            $permohonanProses = PermohonanInformasi::whereBetween('created_at', [$startDate, $endDate])->where('status_permohonan', 'diproses')->count();
            $permohonanPending = PermohonanInformasi::whereBetween('created_at', [$startDate, $endDate])->where('status_permohonan', 'pending')->count();
            $permohonanDitolak = PermohonanInformasi::whereBetween('created_at', [$startDate, $endDate])->where('status_permohonan', 'ditolak')->count();

            // Rekap Keberatan Informasi
            $totalKeberatan = KeberatanInformasi::whereBetween('created_at', [$startDate, $endDate])->count();
            $keberatanSelesai = KeberatanInformasi::whereBetween('created_at', [$startDate, $endDate])->where('status_keberatan', 'selesai')->count();
            $keberatanProses = KeberatanInformasi::whereBetween('created_at', [$startDate, $endDate])->where('status_keberatan', 'diproses')->count();
            $keberatanPending = KeberatanInformasi::whereBetween('created_at', [$startDate, $endDate])->where('status_keberatan', 'pending')->count();
            $keberatanDitolak = KeberatanInformasi::whereBetween('created_at', [$startDate, $endDate])->where('status_keberatan', 'ditolak')->count();

            // Data Sampel Permohonan Terbaru untuk Tabel Lampiran
            $recentPermohonan = PermohonanInformasi::whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();

            // Data Sampel Keberatan Terbaru
            $recentKeberatan = KeberatanInformasi::whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();

            // Logo PPID Base64
            $logoBase64 = null;
            $logoPath = public_path('images/sinjai.png');
            if (!file_exists($logoPath)) {
                $logoPath = public_path('logo.png');
            }
            if (file_exists($logoPath)) {
                $type = pathinfo($logoPath, PATHINFO_EXTENSION);
                $data = file_get_contents($logoPath);
                $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }

            $pdfData = [
                'year' => $year,
                'period' => Carbon::parse($startDate)->format('d M Y') . ' s/d ' . Carbon::parse($endDate)->format('d M Y'),
                'generatedAt' => Carbon::now()->isoFormat('D MMMM Y, HH:mm'),
                'logo' => $logoBase64,
                'stats' => [
                    'permohonan_total' => $totalPermohonan,
                    'permohonan_selesai' => $permohonanSelesai,
                    'permohonan_proses' => $permohonanProses,
                    'permohonan_pending' => $permohonanPending,
                    'permohonan_ditolak' => $permohonanDitolak,
                    'keberatan_total' => $totalKeberatan,
                    'keberatan_selesai' => $keberatanSelesai,
                    'keberatan_proses' => $keberatanProses,
                    'keberatan_pending' => $keberatanPending,
                    'keberatan_ditolak' => $keberatanDitolak,
                ],
                'permohonanList' => $recentPermohonan,
                'keberatanList' => $recentKeberatan
            ];

            // Render view PDF
            $pdf = Pdf::loadView('admin.reports.laporan_ppid_pdf', $pdfData)
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'sans-serif'
                ]);

            $fileName = "Laporan-Layanan-PPID-Sinjai-{$year}.pdf";

            return $pdf->download($fileName);
        } catch (\Exception $e) {
            Log::error('Admin exportLaporanPdf error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal membuat file PDF laporan: ' . $e->getMessage()], 500);
        }
    }
}
