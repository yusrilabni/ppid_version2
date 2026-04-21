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
     * Get list of information (DIP) for Android metadata.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Informasi::with('official.position')
                ->whereIn('status', ['AKTIF', 'BERLAKU']);

            // Optional filter by category (e.g., berkala, setiap-saat)
            if ($request->has('category')) {
                $query->where('category', $request->get('category'));
            }

            // Optional filter by organization
            if ($request->has('unit_id')) {
                $query->where('unit_id', $request->get('unit_id'));
            }

            $informasi = $query->orderBy('tanggal_upload', 'desc')
                ->paginate($request->get('per_page', 20));

            // Attach Organization Names from API Sync
            $unitData = GeneralHelper::getUnitData();
            
            $informasi->getCollection()->transform(function ($item) use ($unitData) {
                $unit = $unitData->get((string)$item->unit_id);
                $item->organization_name = $unit['unit_nama'] ?? 'Unit Tidak Terdaftar';
                $item->organization_address = $unit['unit_alamat'] ?? 'Alamat belum ditambahkan';
                
                // Add absolute URL for file if exists
                if ($item->file) {
                    $item->file_url = url('storage/' . $item->file);
                }
                
                return $item;
            });

            return response()->json([
                'success' => true,
                'message' => 'Data Informasi Publik berhasil diambil',
                'data' => $informasi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data informasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get detail of a specific information.
     */
    public function show($id): JsonResponse
    {
        try {
            $item = Informasi::with('official.position')->findOrFail($id);
            
            $unitData = GeneralHelper::getUnitData();
            $unit = $unitData->get((string)$item->unit_id);
            $item->organization_name = $unit['unit_nama'] ?? 'Unit Tidak Terdaftar';
            $item->organization_address = $unit['unit_alamat'] ?? 'Alamat belum ditambahkan';

            return response()->json([
                'success' => true,
                'message' => 'Detail Informasi berhasil diambil',
                'data' => $item
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Detail tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Placeholder for future store method from Android.
     */
    public function store(Request $request): JsonResponse
    {
        // Logic for uploading from Android will go here
        return response()->json(['message' => 'Endpoint ready for upload'], 200);
    }
}
