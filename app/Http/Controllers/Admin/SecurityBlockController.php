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

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(5)->get("http://ip-api.com/json/{$ip}");
            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'success') {
                    $locationData = ($data['city'] ?? '') . ', ' . ($data['regionName'] ?? '') . ', ' . ($data['country'] ?? '');
                    $fullData = $data;
                } else {
                    $locationData = 'Gagal Melacak: ' . ($data['message'] ?? 'Unknown Error');
                }
            }
        } catch (\Exception $e) {
            $locationData = 'Error Koneksi API Pencarian IP';
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
