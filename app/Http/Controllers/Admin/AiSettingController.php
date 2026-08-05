<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiSetting;
use App\Models\AiUsageLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AiSettingController extends Controller
{
    public function index()
    {
        $settings = AiSetting::all();
        return view('admin.ai_settings.index', compact('settings'));
    }

    public function create()
    {
        return view('admin.ai_settings.create');
    }

    private function detectBestModel($apiKey, $defaultModel = 'gemini-1.5-flash')
    {
        try {
            $response = Http::get("https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}");
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['models']) && is_array($data['models'])) {
                    $availableModels = [];
                    foreach ($data['models'] as $m) {
                        if (isset($m['supportedGenerationMethods']) && in_array('generateContent', $m['supportedGenerationMethods'])) {
                            $name = str_replace('models/', '', $m['name']);
                            $availableModels[] = $name;
                        }
                    }

                    // Prioritaskan model flash yang lebih baru
                    $priorities = [
                        'gemini-flash-latest', 
                        'gemini-3.6-flash', 
                        'gemini-3.5-flash', 
                        'gemini-3.1-flash-lite', 
                        'gemini-2.5-flash-lite',
                        'gemini-2.0-flash', 
                        'gemini-pro-latest'
                    ];
                    foreach ($priorities as $p) {
                        if (in_array($p, $availableModels)) {
                            return $p;
                        }
                    }

                    // Jika tidak ada di prioritas, ambil model flash pertama yang tersedia
                    foreach ($availableModels as $am) {
                        if (str_contains($am, 'flash')) {
                            return $am;
                        }
                    }

                    // Jika tidak ada flash, ambil model pertama yang bisa generateContent
                    if (count($availableModels) > 0) {
                        return $availableModels[0];
                    }
                }
            }
        } catch (\Exception $e) {
            // Abaikan jika error, kembalikan default
        }
        return $defaultModel;
    }

    public function store(Request $request)
    {
        $request->validate([
            'provider' => 'required|string|max:255',
            'api_key' => 'required|string',
            'is_active' => 'boolean'
        ]);

        if ($request->has('is_active')) {
            AiSetting::where('is_active', true)->update(['is_active' => false]);
        }

        $apiKey = trim($request->api_key);
        
        // Deteksi model otomatis jika form model kosong atau kita timpa saja
        $modelName = $request->filled('model') ? trim(str_replace('models/', '', $request->model)) : $this->detectBestModel($apiKey);
        // Jika user asal mengisi model yang salah, kita bisa perbaiki dengan detectBestModel
        if (empty($modelName) || $modelName === 'auto') {
            $modelName = $this->detectBestModel($apiKey);
        }

        AiSetting::create([
            'provider' => trim($request->provider),
            'model' => $modelName,
            'api_key' => $apiKey,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.ai-settings.index')->with('success', 'AI Setting created successfully with model: ' . $modelName);
    }

    public function edit(AiSetting $aiSetting)
    {
        return view('admin.ai_settings.edit', compact('aiSetting'));
    }

    public function update(Request $request, AiSetting $aiSetting)
    {
        $request->validate([
            'provider' => 'required|string|max:255',
            'api_key' => 'required|string',
            'is_active' => 'boolean'
        ]);

        if ($request->has('is_active')) {
            AiSetting::where('id', '!=', $aiSetting->id)->update(['is_active' => false]);
        }

        $apiKey = trim($request->api_key);
        
        $modelName = $request->filled('model') ? trim(str_replace('models/', '', $request->model)) : $this->detectBestModel($apiKey, $aiSetting->model);
        if (empty($modelName) || $modelName === 'auto') {
            $modelName = $this->detectBestModel($apiKey, $aiSetting->model);
        }

        $aiSetting->update([
            'provider' => trim($request->provider),
            'model' => $modelName,
            'api_key' => $apiKey,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.ai-settings.index')->with('success', 'AI Setting updated successfully.');
    }

    public function destroy(AiSetting $aiSetting)
    {
        $aiSetting->delete();
        return redirect()->route('admin.ai-settings.index')->with('success', 'AI Setting deleted successfully.');
    }

    public function generateInformasi(Request $request)
    {
        $user = Auth::user();

        // Cek limit penggunaan AI (5 kali dalam 24 jam untuk admin biasa)
        if (!$user->isSuperAdmin()) {
            $usageCount = AiUsageLog::where('user_id', $user->id)
                ->where('created_at', '>=', now()->subHours(24))
                ->count();

            if ($usageCount >= 5) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda telah mencapai batas maksimal penggunaan AI (5 kali) untuk 24 jam terakhir. Silakan coba lagi besok.'
                ], 429);
            }
        }

        $activeSetting = AiSetting::where('is_active', true)->first();

        if (!$activeSetting) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada API Key AI yang aktif. Hubungi Super Admin.'
            ], 500);
        }

        $promptTitle = $request->input('prompt');

        $categories = ['Informasi Berkala', 'Informasi Setiap Saat', 'Informasi Serta Merta', 'Informasi Dikecualikan'];
        $jenisDokumen = [
            'Profil Badan Publik', 'Informasi Organisasi & Kepegawaian', 'Dokumen Strategis',
            'Program & Kegiatan', 'Laporan Kinerja Instansi', 'Informasi Keuangan',
            'Pengadaan Barang/Jasa', 'Daftar Aset dan Inventaris', 'Standar Layanan & SOP PPID',
            'Daftar Informasi Publik & Laporan PPID', 'Regulasi & Peraturan', 'Perjanjian Kerja Sama / MoU',
            'Pengumuman & Siaran Pers', 'Informasi Serta Merta', 'Lainnya'
        ];

        $currentYear = date('Y');
        $systemPrompt = "Anda adalah asisten AI yang membantu admin PPID membuat detail informasi publik yang profesional dan sesuai aturan KIP (Keterbukaan Informasi Publik). 
Tugas Anda:
1. Perbaiki judul dokumen agar lebih baku dan profesional.
2. Buat deskripsi singkat yang mendeskripsikan dokumen tersebut (1-2 paragraf).
3. Buat konten/penjelasan yang lengkap terkait dokumen tersebut.
4. Pilih SATU kategori dari daftar berikut yang paling sesuai: " . implode(', ', $categories) . "
5. Pilih SATU jenis dokumen dari daftar berikut yang paling sesuai: " . implode(', ', $jenisDokumen) . "
6. Tentukan tahun dokumen ('tahun') dalam format 'YYYY-MM-DD' berdasarkan konteks di judul (jika hanya tahu tahunnya, gunakan 'YYYY-01-01'). Jika tidak ada, gunakan tahun sekarang (" . $currentYear . "-01-01).
7. Tentukan status ('status'). Jika dokumen tersebut merujuk pada " . ($currentYear - 2) . " atau lebih lama, isi dengan 'ARSIP'. Jika lebih baru atau tahun ini, isi dengan 'BERLAKU'.

Berikan jawaban HANYA dalam format JSON dengan kunci persis seperti berikut:
{
  \"title\": \"...\",
  \"doc_desc\": \"...\",
  \"doc_content\": \"...\",
  \"category\": \"...\",
  \"jenis_dokumen\": \"...\",
  \"tahun\": \"YYYY-MM-DD\",
  \"status\": \"BERLAKU atau ARSIP\"
}
Tanpa teks tambahan atau markdown block di luar JSON.";

        $userPrompt = "Topik/Judul singkat dari admin: " . $promptTitle;

        // Bersihkan prefix 'models/' jika user tidak sengaja memasukkannya dan buang spasi berlebih
        $modelName = trim(str_replace('models/', '', $activeSetting->model));
        $apiKey = trim($activeSetting->api_key);

        // Paksa ganti ke model terbaru jika database masih merekam model lawas yang ditolak
        if ($modelName === 'gemini-2.5-flash' || $modelName === 'auto') {
            $modelName = 'gemini-flash-latest';
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => $systemPrompt . "\n\n" . $userPrompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'responseMimeType' => 'application/json'
                ]
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $generatedText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
                
                // Bersihkan text dari markdown code blocks jika ada (misal: ```json ... ```)
                $cleanText = preg_replace('/```json\s*/i', '', $generatedText);
                $cleanText = preg_replace('/```\s*/', '', $cleanText);
                $cleanText = trim($cleanText);

                // Parse JSON
                $data = json_decode($cleanText, true);

                if ($data) {
                    // Catat penggunaan
                    AiUsageLog::create([
                        'user_id' => $user->id,
                        'endpoint' => 'generate-informasi'
                    ]);

                    return response()->json([
                        'success' => true,
                        'data' => $data
                    ]);
                }
                
                return response()->json([
                    'success' => false,
                    'message' => 'Format balasan AI tidak sesuai (bukan JSON yang valid). Silakan coba lagi.'
                ], 500);
            }

            $errorResult = $response->json();
            $errorMessage = $errorResult['error']['message'] ?? 'API Key atau Model tidak valid.';

            return response()->json([
                'success' => false,
                'message' => 'Gagal memanggil AI: ' . $errorMessage
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
}
