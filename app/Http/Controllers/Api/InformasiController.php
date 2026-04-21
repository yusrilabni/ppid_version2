<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use App\Helpers\GeneralHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    /**
     * Ambil daftar informasi publik (DIP) dengan paginasi lengkap.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Informasi::with('official.position')
                // Tampilkan semua: AKTIF, BERLAKU, dan ARSIP sesuai permintaan
                ->whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP']);

            if ($request->has('category')) {
                $query->where('category', $request->get('category'));
            }

            if ($request->has('q')) {
                $query->where('title', 'LIKE', '%' . $request->get('q') . '%');
            }

            // Paginasi: default 10 item per halaman
            $perPage = $request->get('per_page', 10);
            $informasi = $query->orderBy('tanggal_upload', 'desc')->paginate($perPage);

            $unitData = GeneralHelper::getUnitData();
            
            $informasi->getCollection()->transform(function ($item) use ($unitData) {
                $unit = $unitData->get((string)$item->unit_id);
                $item->organization_name = $unit['unit_nama'] ?? 'Unit Tidak Terdaftar';
                $item->organization_address = $unit['unit_alamat'] ?? 'Alamat belum ditambahkan';
                if ($item->file) {
                    $item->file_url = url('storage/' . $item->file);
                }
                return $item;
            });

            return response()->json([
                'success' => true,
                'message' => 'Data DIP berhasil diambil',
                'data' => $informasi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
