<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\SaqAnswer;
use App\Models\SaqIndicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaqAdminController extends Controller
{
    /**
     * Cek superadmin. Return response 403 atau null jika lolos.
     */
    private function checkSuperAdmin(Request $request)
    {
        $user = $request->user();
        if (!$user || !$user->isSuperAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya superadmin yang dapat mengelola SAQ.',
            ], 403);
        }
        return null;
    }

    /**
     * Daftar semua indikator SAQ (flat, dengan info mapping OPD).
     * GET /api/v1/saq-admin/indicators?tab=&search=&per_page=
     */
    public function index(Request $request)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $query = SaqIndicator::withCount('organizations');

        if ($request->filled('tab')) {
            $query->where('tab', $request->get('tab'));
        }
        if ($request->filled('search')) {
            $s = $request->get('search');
            $query->where(function ($q) use ($s) {
                $q->where('pertanyaan', 'like', "%{$s}%")
                  ->orWhere('kode', 'like', "%{$s}%");
            });
        }
        if ($request->get('type') === 'question') {
            $query->whereNotNull('parent_id');
        }

        $perPage = (int) $request->get('per_page', 50);
        $perPage = max(10, min(200, $perPage));

        $data = $query->orderBy('tab')->orderBy('order')->orderBy('id')
            ->paginate($perPage);

        return response()->json(['success' => true, 'data' => $data]);
    }

    /**
     * Detail satu indikator + daftar OPD yang dipetakan.
     * GET /api/v1/saq-admin/indicators/{id}
     */
    public function show(Request $request, $id)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $indicator = SaqIndicator::with(['organizations:id,name,slug', 'parent:id,kode,pertanyaan'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $indicator,
            'mapped_opd_ids' => $indicator->organizations->pluck('id')->toArray(),
        ]);
    }

    /**
     * Tambah pertanyaan baru.
     * POST /api/v1/saq-admin/indicators
     */
    public function store(Request $request)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $validated = $request->validate([
            'tab' => 'required|string|max:100',
            'pertanyaan' => 'required|string',
            'parent_id' => 'nullable|exists:saq_indicators,id',
            'kode' => 'nullable|string|max:50',
            'section' => 'nullable|string|max:255',
            'petunjuk' => 'nullable|string',
            'dokumen_upload' => 'nullable|string',
            'unit_terkait' => 'nullable|string',
            'is_category' => 'nullable|boolean',
            'order' => 'nullable|integer',
            'scope' => 'nullable|string|max:50',
            'klasifikasi_otomatis' => 'nullable|string|max:100',
            'target_upload' => 'nullable|string|max:50',
            'input_type' => 'nullable|string|max:50',
            'organization_ids' => 'nullable|array',
            'organization_ids.*' => 'exists:organizations,id',
        ]);

        $orgIds = $validated['organization_ids'] ?? [];
        unset($validated['organization_ids']);

        $indicator = SaqIndicator::create($validated);
        if (!empty($orgIds)) {
            $indicator->organizations()->sync($orgIds);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil ditambahkan.',
            'data' => $indicator->loadCount('organizations'),
        ], 201);
    }

    /**
     * Edit pertanyaan.
     * PUT /api/v1/saq-admin/indicators/{id}
     */
    public function update(Request $request, $id)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $indicator = SaqIndicator::findOrFail($id);

        $validated = $request->validate([
            'tab' => 'sometimes|required|string|max:100',
            'pertanyaan' => 'sometimes|required|string',
            'parent_id' => 'nullable|exists:saq_indicators,id',
            'kode' => 'nullable|string|max:50',
            'section' => 'nullable|string|max:255',
            'petunjuk' => 'nullable|string',
            'dokumen_upload' => 'nullable|string',
            'unit_terkait' => 'nullable|string',
            'is_category' => 'nullable|boolean',
            'order' => 'nullable|integer',
            'scope' => 'nullable|string|max:50',
            'klasifikasi_otomatis' => 'nullable|string|max:100',
            'target_upload' => 'nullable|string|max:50',
            'input_type' => 'nullable|string|max:50',
        ]);

        // Cegah parent_id menunjuk ke diri sendiri
        if (isset($validated['parent_id']) && (int)$validated['parent_id'] === (int)$indicator->id) {
            return response()->json([
                'success' => false,
                'message' => 'parent_id tidak boleh menunjuk ke diri sendiri.',
            ], 422);
        }

        $indicator->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil diperbarui.',
            'data' => $indicator->fresh()->loadCount('organizations'),
        ]);
    }

    /**
     * Hapus pertanyaan. Tolak jika sudah ada jawaban.
     * DELETE /api/v1/saq-admin/indicators/{id}
     */
    public function destroy(Request $request, $id)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $indicator = SaqIndicator::findOrFail($id);

        $answerCount = SaqAnswer::where('indicator_id', $indicator->id)->count();
        if ($answerCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "Tidak dapat menghapus: sudah ada {$answerCount} jawaban untuk pertanyaan ini.",
            ], 422);
        }

        $childCount = SaqIndicator::where('parent_id', $indicator->id)->count();
        if ($childCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "Tidak dapat menghapus: masih ada {$childCount} sub-pertanyaan di bawahnya.",
            ], 422);
        }

        $indicator->organizations()->detach();
        $indicator->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil dihapus.',
        ]);
    }

    /**
     * Atur mapping OPD untuk satu pertanyaan.
     * PUT /api/v1/saq-admin/indicators/{id}/mapping
     * Body: { organization_ids: [1,2,3] } atau { all_opds: true }
     */
    public function updateMapping(Request $request, $id)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $indicator = SaqIndicator::findOrFail($id);

        $request->validate([
            'organization_ids' => 'nullable|array',
            'organization_ids.*' => 'exists:organizations,id',
            'all_opds' => 'nullable|boolean',
        ]);

        if ($request->boolean('all_opds')) {
            // Semua OPD (tanpa kecamatan/desa/kelurahan/bagian)
            $orgIds = Organization::where('type', 'unit')
                ->where('name', 'not like', 'Kantor Kecamatan%')
                ->where('name', 'not like', 'Desa %')
                ->where('name', 'not like', 'Kelurahan %')
                ->where('slug', 'not like', 'bagian-%')
                ->pluck('id')->toArray();
        } else {
            $orgIds = $request->get('organization_ids', []);
        }

        $indicator->organizations()->sync($orgIds);

        return response()->json([
            'success' => true,
            'message' => 'Mapping OPD berhasil diperbarui.',
            'data' => ['mapped_count' => count($orgIds)],
        ]);
    }

    /**
     * Daftar OPD untuk picker (ringkas).
     * GET /api/v1/saq-admin/opds
     */
    public function opds(Request $request)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $opds = Organization::where('type', 'unit')
            ->where('name', 'not like', 'Kantor Kecamatan%')
            ->where('name', 'not like', 'Desa %')
            ->where('name', 'not like', 'Kelurahan %')
            ->orderByRaw("CASE WHEN slug = 'kabupaten-sinjai' THEN 0 ELSE 1 END")
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return response()->json(['success' => true, 'data' => $opds]);
    }

    /**
     * Daftar tab yang tersedia (untuk filter/dropdown).
     * GET /api/v1/saq-admin/tabs
     */
    public function tabs(Request $request)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $tabs = SaqIndicator::whereNull('parent_id')
            ->orderBy('order')
            ->get(['id', 'tab', 'kode'])
            ->map(fn($t) => ['id' => $t->id, 'tab' => $t->tab, 'kode' => $t->kode]);

        return response()->json(['success' => true, 'data' => $tabs]);
    }
}
