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

    public function store(Request $request)
    {
        $request->validate([
            'provider' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'api_key' => 'required|string',
            'is_active' => 'boolean'
        ]);

        if ($request->has('is_active')) {
            AiSetting::where('is_active', true)->update(['is_active' => false]);
        }

        AiSetting::create([
            'provider' => $request->provider,
            'model' => $request->model,
            'api_key' => $request->api_key,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.ai-settings.index')->with('success', 'AI Setting created successfully.');
    }

    public function edit(AiSetting $aiSetting)
    {
        return view('admin.ai_settings.edit', compact('aiSetting'));
    }

    public function update(Request $request, AiSetting $aiSetting)
    {
        $request->validate([
            'provider' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'api_key' => 'required|string',
            'is_active' => 'boolean'
        ]);

        if ($request->has('is_active')) {
            AiSetting::where('id', '!=', $aiSetting->id)->update(['is_active' => false]);
        }

        $aiSetting->update([
            'provider' => $request->provider,
            'model' => $request->model,
            'api_key' => $request->api_key,
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

        $systemPrompt = "Anda adalah asisten AI yang membantu admin PPID membuat detail informasi publik yang profesional dan sesuai aturan KIP (Keterbukaan Informasi Publik). 
Tugas Anda:
1. Perbaiki judul dokumen agar lebih baku dan profesional.
2. Buat deskripsi singkat yang mendeskripsikan dokumen tersebut (1-2 paragraf).
3. Buat konten/penjelasan yang lengkap terkait dokumen tersebut.
4. Pilih SATU kategori dari daftar berikut yang paling sesuai: " . implode(', ', $categories) . "
5. Pilih SATU jenis dokumen dari daftar berikut yang paling sesuai: " . implode(', ', $jenisDokumen) . "

Berikan jawaban HANYA dalam format JSON dengan kunci:
- title
- doc_desc
- doc_content
- category
- jenis_dokumen
Tanpa teks tambahan atau markdown block.";

        $userPrompt = "Topik/Judul singkat dari admin: " . $promptTitle;

        // Bersihkan prefix 'models/' jika user tidak sengaja memasukkannya
        $modelName = str_replace('models/', '', $activeSetting->model);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent?key={$activeSetting->api_key}", [
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
