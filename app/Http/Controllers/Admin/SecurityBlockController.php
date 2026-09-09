<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SecurityBlock;

class SecurityBlockController extends Controller
{
    public function index()
    {
        $blocks = SecurityBlock::latest()->paginate(15);
        return view('admin.security.index', compact('blocks'));
    }

    public function destroy($id)
    {
        $block = SecurityBlock::findOrFail($id);
        $block->delete();
        return redirect()->route('admin.security.index')->with('success', 'IP berhasil dihapus dari daftar blokir.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ip_address' => 'required|ip|unique:security_blocks,ip_address',
            'reason' => 'nullable|string'
        ]);

        SecurityBlock::create([
            'ip_address' => $request->ip_address,
            'reason' => $request->reason ?? 'Diblokir secara manual oleh Super Admin'
        ]);

        return redirect()->route('admin.security.index')->with('success', 'IP berhasil diblokir.');
    }

    public function scan(Request $request)
    {
        $request->validate([
            'ip_address' => 'required|ip'
        ]);

        $ip = $request->ip_address;
        $locationData = 'Tidak diketahui';
        $fullData = null;
        $errorMessage = '';

        try {
            // Coba pakai ip-api.com
            $response = \Illuminate\Support\Facades\Http::timeout(10)->get("http://ip-api.com/json/{$ip}");
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['status']) && $data['status'] === 'success') {
                    $locationData = ($data['city'] ?? '') . ', ' . ($data['regionName'] ?? '') . ', ' . ($data['country'] ?? '');
                    $fullData = $data;
                } else {
                    $errorMessage = 'ip-api error: ' . ($data['message'] ?? 'Unknown');
                }
            } else {
                $errorMessage = 'ip-api HTTP status ' . $response->status();
            }
            
            // Jika gagal, pakai ipwho.is sebagai fallback (HTTPS)
            if (!$fullData) {
                $responseFallback = \Illuminate\Support\Facades\Http::timeout(10)->get("https://ipwho.is/{$ip}");
                if ($responseFallback->successful()) {
                    $dataF = $responseFallback->json();
                    if (isset($dataF['success']) && $dataF['success'] == true) {
                        $locationData = ($dataF['city'] ?? '') . ', ' . ($dataF['region'] ?? '') . ', ' . ($dataF['country'] ?? '');
                        $fullData = [
                            'isp' => $dataF['connection']['isp'] ?? 'N/A',
                            'org' => $dataF['connection']['org'] ?? 'N/A',
                            'timezone' => $dataF['timezone']['id'] ?? 'N/A'
                        ];
                        $errorMessage = ''; // Sukses pakai fallback
                    }
                }
            }

        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
        }

        if (!$fullData && $errorMessage) {
            $locationData = 'Error: ' . substr($errorMessage, 0, 100);
        }

        return redirect()->route('admin.security.index')->with('scanResult', [
            'ip' => $ip,
            'location' => $locationData,
            'isp' => $fullData['isp'] ?? 'N/A',
            'org' => $fullData['org'] ?? 'N/A',
            'timezone' => $fullData['timezone'] ?? 'N/A'
        ]);
    }
}
