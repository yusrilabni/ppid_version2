<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KeberatanInformasi;
use App\Models\PermohonanInformasi;
use App\Helpers\GeneralHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class KeberatanInformasiController extends Controller
{
    /**
     * Submit pengajuan keberatan informasi publik (UU No. 14/2008 & Perki No. 1/2021).
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'nomor_pendaftaran_pemohon' => 'required|string|max:50',
                'nama_pemohon' => 'required|string|max:255',
                'alamat_pemohon' => 'required|string',
                'pekerjaan' => 'nullable|string|max:255',
                'nomor_telepon_pemohon' => 'required|string|max:25',
                'email_pemohon' => 'required|email|max:255',
                
                // Kuasa pemohon (opsional)
                'nama_kuasa' => 'nullable|string|max:255',
                'alamat_kuasa' => 'nullable|string',
                'nomor_telepon_kuasa' => 'nullable|string|max:25',
                'surat_kuasa' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                
                // Alasan & kasus posisi
                'alasan_keberatan' => 'required|string|max:255',
                'kasus_posisi' => 'required|string',
                'privacy_status' => 'nullable|in:Publik,Anonim,Rahasia',
            ], [
                'nomor_pendaftaran_pemohon.required' => 'Nomor pendaftaran permohonan wajib diisi.',
                'nama_pemohon.required' => 'Nama pemohon wajib diisi.',
                'alamat_pemohon.required' => 'Alamat pemohon wajib diisi.',
                'nomor_telepon_pemohon.required' => 'Nomor kontak telepon/WhatsApp wajib diisi.',
                'email_pemohon.required' => 'Alamat email pemohon wajib diisi.',
                'email_pemohon.email' => 'Format email pemohon tidak valid.',
                'alasan_keberatan.required' => 'Silakan pilih salah satu alasan keberatan.',
                'kasus_posisi.required' => 'Penjelasan kasus posisi / alasan keberatan wajib diisi.',
                'surat_kuasa.max' => 'Ukuran file surat kuasa maksimal 5MB.',
                'surat_kuasa.mimes' => 'Format surat kuasa harus berupa PDF, JPG, JPEG, atau PNG.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi formulir keberatan gagal.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $validatedData = $validator->validated();

            // Cek keterkaitan dengan permohonan informasi asal
            $permohonan = PermohonanInformasi::where('unique_code', $validatedData['nomor_pendaftaran_pemohon'])
                ->orWhere('id', $validatedData['nomor_pendaftaran_pemohon'])
                ->first();

            if ($permohonan) {
                $validatedData['permohonan_informasi_id'] = $permohonan->id;
            }

            // Upload Surat Kuasa jika dilampirkan
            if ($request->hasFile('surat_kuasa') && $request->file('surat_kuasa')->isValid()) {
                $filePath = $request->file('surat_kuasa')->store('keberatan_surat_kuasa', 'public');
                $validatedData['surat_kuasa_path'] = $filePath;
            }
            unset($validatedData['surat_kuasa']);

            // Default privacy status
            $validatedData['privacy_status'] = $validatedData['privacy_status'] ?? 'Publik';
            $validatedData['status_keberatan'] = 'pending';

            // Hubungkan dengan user jika login
            if (auth('sanctum')->check()) {
                $validatedData['user_id'] = auth('sanctum')->id();
            }

            // Generate unique code 5 karakter unik
            $uniqueCode = '';
            do {
                $uniqueCode = GeneralHelper::generateUniqueCode(5);
            } while (KeberatanInformasi::where('unique_code', $uniqueCode)->exists());

            $validatedData['unique_code'] = $uniqueCode;

            $keberatan = KeberatanInformasi::create($validatedData);

            // Daftar teks alasan keberatan resmi UU 14/2008
            $alasanLabels = [
                'a' => 'Permohonan Informasi ditolak',
                'b' => 'Informasi berkala tidak disediakan',
                'c' => 'Permintaan Informasi tidak ditanggapi',
                'd' => 'Permintaan Informasi ditanggapi tidak sebagaimana yang diminta',
                'e' => 'Permintaan Informasi tidak dipenuhi',
                'f' => 'Biaya yang dikenakan tidak wajar',
                'g' => 'Penyampaian Informasi melebihi jangka waktu yang ditentukan'
            ];
            $alasanText = $alasanLabels[$keberatan->alasan_keberatan] ?? $keberatan->alasan_keberatan;

            // Notifikasi Telegram untuk Petugas & Atasan PPID
            try {
                $message = "⚖️ <b>Pengajuan Keberatan Informasi Publik Baru</b>\n\n";
                $message .= "<b>🆔 Kode Keberatan:</b> #{$keberatan->unique_code}\n";
                $message .= "<b>📄 No. Registrasi Permohonan:</b> {$keberatan->nomor_pendaftaran_pemohon}\n";
                $message .= "<b>👤 Pemohon:</b> " . htmlspecialchars($keberatan->nama_pemohon) . "\n";
                if ($keberatan->pekerjaan) {
                    $message .= "<b>💼 Pekerjaan:</b> " . htmlspecialchars($keberatan->pekerjaan) . "\n";
                }
                $message .= "<b>📞 Telepon:</b> " . htmlspecialchars($keberatan->nomor_telepon_pemohon) . "\n";
                $message .= "<b>✉️ Email:</b> " . htmlspecialchars($keberatan->email_pemohon) . "\n";
                if ($keberatan->nama_kuasa) {
                    $message .= "<b>👥 Dikuasakan Kepada:</b> " . htmlspecialchars($keberatan->nama_kuasa) . "\n";
                }
                $message .= "<b>⚠️ Alasan Keberatan:</b> " . htmlspecialchars($alasanText) . "\n";
                $message .= "<b>📝 Kasus Posisi:</b>\n" . htmlspecialchars(substr($keberatan->kasus_posisi, 0, 160)) . "...\n\n";
                $message .= "<b>🔒 Status Privasi:</b> {$keberatan->privacy_status}\n";
                $message .= "<i>Tanggapan Atasan PPID wajib diberikan maksimal 30 hari kerja sesuai UU No. 14/2008.</i>";

                GeneralHelper::sendTelegramMessage($message);
            } catch (\Exception $te) {
                \Illuminate\Support\Facades\Log::warning("Telegram notification failed for Keberatan: " . $te->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Keberatan atas permohonan informasi publik berhasil diajukan.',
                'data' => [
                    'unique_code' => $uniqueCode,
                    'keberatan' => $keberatan
                ]
            ], 201);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Gagal submit keberatan: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim pengajuan keberatan. Silakan coba beberapa saat lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cek status detail pengajuan keberatan via Unique Code (Publik/Owner).
     */
    public function checkStatus($code): JsonResponse
    {
        try {
            $keberatan = KeberatanInformasi::with(['permohonan', 'user'])
                ->where('unique_code', $code)
                ->firstOrFail();

            $user = auth('sanctum')->user();
            $isOwner = $user && $user->id == $keberatan->user_id;
            $isAdmin = $user && in_array($user->role, ['admin', 'superadmin']);
            $canViewSensitive = $isOwner || $isAdmin;

            if (!$canViewSensitive) {
                // Sensor data sensitif untuk pengunjung publik umum
                if ($keberatan->privacy_status === 'Anonim') {
                    $keberatan->nama_pemohon = GeneralHelper::maskName($keberatan->nama_pemohon);
                    if ($keberatan->nama_kuasa) {
                        $keberatan->nama_kuasa = GeneralHelper::maskName($keberatan->nama_kuasa);
                    }
                }

                if ($keberatan->nomor_telepon_pemohon) {
                    $keberatan->nomor_telepon_pemohon = substr($keberatan->nomor_telepon_pemohon, 0, 3) . '********';
                }
                if ($keberatan->email_pemohon) {
                    $parts = explode('@', $keberatan->email_pemohon);
                    $keberatan->email_pemohon = substr($parts[0], 0, 3) . '***@' . ($parts[1] ?? '');
                }
                if ($keberatan->alamat_pemohon) {
                    $keberatan->alamat_pemohon = '*** (Disembunyikan untuk privasi) ***';
                }
                if ($keberatan->alamat_kuasa) {
                    $keberatan->alamat_kuasa = '*** (Disembunyikan untuk privasi) ***';
                }
                if ($keberatan->nomor_telepon_kuasa) {
                    $keberatan->nomor_telepon_kuasa = substr($keberatan->nomor_telepon_kuasa, 0, 3) . '********';
                }
                $keberatan->surat_kuasa_path = null;
            }

            return response()->json([
                'success' => true,
                'message' => 'Status keberatan berhasil ditemukan.',
                'data' => $keberatan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data keberatan tidak ditemukan.'
            ], 404);
        }
    }

    /**
     * Daftar Keberatan Publik (Halaman /laporan/keberatan).
     */
    public function indexPublic(Request $request): JsonResponse
    {
        try {
            $query = KeberatanInformasi::query()
                ->whereIn('privacy_status', ['Publik', 'Anonim']);

            if ($request->has('search') && $request->search != '') {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('nama_pemohon', 'like', '%' . $searchTerm . '%')
                        ->orWhere('unique_code', 'like', '%' . $searchTerm . '%')
                        ->orWhere('nomor_pendaftaran_pemohon', 'like', '%' . $searchTerm . '%')
                        ->orWhere('kasus_posisi', 'like', '%' . $searchTerm . '%');
                });
            }

            if ($request->has('date_from') && $request->date_from != '') {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->has('date_to') && $request->date_to != '') {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

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

            $perPage = min((int) $request->get('per_page', 10), 100);
            $keberatanList = $query->paginate($perPage);

            // Transformasi masking privasi
            $keberatanList->getCollection()->transform(function ($item) {
                if ($item->privacy_status === 'Anonim') {
                    $item->nama_pemohon = GeneralHelper::maskName($item->nama_pemohon);
                    if ($item->nama_kuasa) {
                        $item->nama_kuasa = GeneralHelper::maskName($item->nama_kuasa);
                    }
                }
                // Selalu sembunyikan kontak privat di daftar publik
                if ($item->nomor_telepon_pemohon) {
                    $item->nomor_telepon_pemohon = substr($item->nomor_telepon_pemohon, 0, 3) . '********';
                }
                if ($item->email_pemohon) {
                    $parts = explode('@', $item->email_pemohon);
                    $item->email_pemohon = substr($parts[0], 0, 3) . '***@' . ($parts[1] ?? '');
                }
                $item->alamat_pemohon = '*** (Disembunyikan) ***';
                $item->alamat_kuasa = null;
                $item->nomor_telepon_kuasa = null;
                $item->surat_kuasa_path = null;

                return $item;
            });

            return response()->json([
                'success' => true,
                'data' => $keberatanList
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil daftar keberatan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Riwayat keberatan milik user login.
     */
    public function myRequests(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $keberatan = KeberatanInformasi::with('permohonan')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $keberatan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil riwayat keberatan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Detail keberatan milik user login.
     */
    public function show(Request $request, $id): JsonResponse
    {
        try {
            $user = $request->user();
            $keberatan = KeberatanInformasi::with('permohonan')
                ->where('user_id', $user->id)
                ->where('id', $id)
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => $keberatan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data keberatan tidak ditemukan.'
            ], 404);
        }
    }
}
