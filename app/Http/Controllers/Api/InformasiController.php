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
                ->whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP']);

            // Pencarian Umum (Judul, Kategori, Dinas)
            if ($request->has('q')) {
                $search = $request->get('q');
                $query->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', '%' . $search . '%')
                      ->orWhere('category', 'LIKE', '%' . $search . '%')
                      ->orWhereHas('official.organization', function($org) use ($search) {
                          $org->where('name', 'LIKE', '%' . $search . '%');
                      });
                });
            }

            // Filter Kategori
            if ($request->has('category') && $request->get('category') !== 'Semua') {
                $query->where('category', $request->get('category'));
            }

            // Filter Status
            if ($request->has('status') && $request->get('status') !== 'Semua') {
                $query->where('status', $request->get('status'));
            }

            // Filter Tanggal (jika ada)
            if ($request->has('date')) {
                $query->whereDate('tanggal_upload', $request->get('date'));
            }

            $perPage = $request->get('per_page', 10);
            $informasi = $query->orderBy('tanggal_upload', 'desc')->paginate($perPage);

            $unitData = GeneralHelper::getUnitData();
            
            $informasi->getCollection()->transform(function ($item) use ($unitData) {
                $unit = $unitData->get((string)$item->unit_id);
                $item->organization_name = $unit['unit_nama'] ?? 'Unit Tidak Terdaftar';
                // ... rest of mapping
                if ($item->file) {
                    $item->file_url = url('storage/' . $item->file);
                }
                return $item;
            });

            return response()->json([
                'success' => true,
                'data' => $informasi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ambil detail informasi berdasarkan slug atau ID.
     */
    public function show($slug): JsonResponse
    {
        try {
            $item = Informasi::with(['user', 'official.position'])
                ->where('slug', $slug)
                ->orWhere('id', $slug)
                ->firstOrFail();

            $item->increment('views_count');

            $unitData = GeneralHelper::getUnitData();
            $unit = $unitData->get((string)$item->unit_id);
            $item->organization_name = $unit['unit_nama'] ?? 'Unit Tidak Terdaftar';
            
            if ($item->file) {
                $item->file_url = url('storage/' . $item->file);
            }

            // Fallback nama pengunggah jika user_id NULL
            if (!$item->user) {
                $item->uploader_name = 'Admin PPID ' . $item->organization_name;
            } else {
                $item->uploader_name = $item->user->name;
            }

            return response()->json([
                'success' => true,
                'data' => $item
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Dokumen tidak ditemukan'
            ], 404);
        }
    }
}
