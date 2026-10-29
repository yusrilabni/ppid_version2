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
     * Daftar semua indikator SAQ.
     * GET /api/v1/saq-admin/indicators?tab=&section=&search=&organization_id=&similar_only=&per_page=
     */
    public function index(Request $request)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $query = SaqIndicator::withCount('organizations')
            ->with(['parent:id,kode,pertanyaan', 'organizations:id,name,slug']);

        if ($request->filled('tab')) {
            $query->where('tab', $request->get('tab'));
        }
        if ($request->filled('section')) {
            $query->where('section', $request->get('section'));
        }
        if ($request->filled('search')) {
            $s = $request->get('search');
            $query->where(function ($q) use ($s) {
                $q->where('pertanyaan', 'like', "%{$s}%")
                  ->orWhere('kode', 'like', "%{$s}%")
                  ->orWhere('section', 'like', "%{$s}%")
                  ->orWhere('unit_terkait', 'like', "%{$s}%");
            });
        }
        if ($request->filled('organization_id')) {
            $orgId = (int)$request->get('organization_id');
            if ($orgId > 0) {
                $query->whereHas('organizations', function ($q) use ($orgId) {
                    $q->where('organizations.id', $orgId);
                });
            }
        }
        if ($request->filled('input_type')) {
            $query->where('input_type', $request->get('input_type'));
        }
        if ($request->get('type') === 'question') {
            $query->whereNotNull('parent_id');
        } elseif ($request->get('type') === 'category') {
            $query->where('is_category', true);
        }

        // Deteksi pertanyaan serupa (duplikat teks pertanyaan)
        $duplicateCounts = DB::table('saq_indicators')
            ->whereNotNull('pertanyaan')
            ->where('pertanyaan', '!=', '')
            ->select(DB::raw('TRIM(LOWER(pertanyaan)) as q_norm'), DB::raw('COUNT(*) as total'))
            ->groupBy('q_norm')
            ->having('total', '>', 1)
            ->pluck('total', 'q_norm')
            ->toArray();

        if ($request->boolean('similar_only')) {
            $dupeKeys = array_keys($duplicateCounts);
            if (!empty($dupeKeys)) {
                $query->whereIn(DB::raw('TRIM(LOWER(pertanyaan))'), $dupeKeys);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        $query->orderBy('tab')->orderBy('order')->orderBy('id');

        // Mode all (tanpa pagination kaku)
        if ($request->get('per_page') === 'all' || (int)$request->get('per_page') === -1) {
            $items = $query->get();
            $items->transform(function ($item) use ($duplicateCounts) {
                $norm = trim(mb_strtolower($item->pertanyaan ?? ''));
                $item->similar_count = $duplicateCounts[$norm] ?? 1;
                return $item;
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'data' => $items,
                    'total' => $items->count(),
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => $items->count(),
                ],
                'meta' => [
                    'duplicate_groups_count' => count($duplicateCounts),
                ]
            ]);
        }

        $perPage = (int) $request->get('per_page', 50);
        $perPage = max(10, min(500, $perPage));

        $data = $query->paginate($perPage);

        $data->getCollection()->transform(function ($item) use ($duplicateCounts) {
            $norm = trim(mb_strtolower($item->pertanyaan ?? ''));
            $item->similar_count = $duplicateCounts[$norm] ?? 1;
            return $item;
        });

        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => [
                'duplicate_groups_count' => count($duplicateCounts),
            ]
        ]);
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
     * Ambil daftar pertanyaan serupa / identik dengan satu indikator.
     * GET /api/v1/saq-admin/indicators/{id}/similar
     */
    public function similar(Request $request, $id)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $indicator = SaqIndicator::findOrFail($id);
        $norm = trim(mb_strtolower($indicator->pertanyaan ?? ''));

        if (empty($norm)) {
            return response()->json(['success' => true, 'data' => [], 'count' => 0]);
        }

        $similars = SaqIndicator::withCount('organizations')
            ->with(['organizations:id,name,slug', 'parent:id,kode,pertanyaan'])
            ->where(DB::raw('TRIM(LOWER(pertanyaan))'), $norm)
            ->where('id', '!=', $indicator->id)
            ->orderBy('tab')
            ->orderBy('order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $similars,
            'count' => $similars->count(),
            'target_indicator' => $indicator->load('organizations:id,name,slug'),
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

        // Jika order belum diisi, tempatkan di akhir
        if (!isset($validated['order'])) {
            $maxOrder = SaqIndicator::where('tab', $validated['tab'])
                ->where('parent_id', $validated['parent_id'] ?? null)
                ->max('order');
            $validated['order'] = ($maxOrder ?? 0) + 1;
        }

        $indicator = SaqIndicator::create($validated);
        if (!empty($orgIds)) {
            $indicator->organizations()->sync($orgIds);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil ditambahkan.',
            'data' => $indicator->loadCount('organizations')->load(['parent:id,kode,pertanyaan', 'organizations:id,name,slug']),
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
            'data' => $indicator->fresh()->loadCount('organizations')->load(['parent:id,kode,pertanyaan', 'organizations:id,name,slug']),
        ]);
    }

    /**
     * Pindahkan pertanyaan (Ganti Tab / Seksi / Parent Induk / Urutan).
     * POST /api/v1/saq-admin/indicators/{id}/move
     */
    public function move(Request $request, $id)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $indicator = SaqIndicator::findOrFail($id);

        $validated = $request->validate([
            'target_tab' => 'nullable|string|max:100',
            'target_section' => 'nullable|string|max:255',
            'target_parent_id' => 'nullable|exists:saq_indicators,id',
            'direction' => 'nullable|in:up,down',
            'target_order' => 'nullable|integer',
        ]);

        // 1. Pindah Tab / Seksi / Parent
        if (!empty($validated['target_tab']) && $validated['target_tab'] !== $indicator->tab) {
            $indicator->tab = $validated['target_tab'];
        }
        if (array_key_exists('target_section', $validated) && $validated['target_section'] !== $indicator->section) {
            $indicator->section = $validated['target_section'];
        }
        if (array_key_exists('target_parent_id', $validated)) {
            $newParent = $validated['target_parent_id'] ? (int)$validated['target_parent_id'] : null;
            if ($newParent !== (int)$indicator->id) {
                $indicator->parent_id = $newParent;
            }
        }

        // 2. Geser Urutan (Reorder)
        if (!empty($validated['direction'])) {
            $dir = $validated['direction'];
            $neighborQuery = SaqIndicator::where('tab', $indicator->tab)
                ->where('parent_id', $indicator->parent_id)
                ->where('id', '!=', $indicator->id);

            if ($dir === 'up') {
                $neighbor = $neighborQuery->where('order', '<=', $indicator->order)
                    ->orderBy('order', 'desc')
                    ->orderBy('id', 'desc')
                    ->first();
            } else {
                $neighbor = $neighborQuery->where('order', '>=', $indicator->order)
                    ->orderBy('order', 'asc')
                    ->orderBy('id', 'asc')
                    ->first();
            }

            if ($neighbor) {
                $currentOrder = $indicator->order ?? 1;
                $neighborOrder = $neighbor->order ?? 1;

                if ($currentOrder === $neighborOrder) {
                    if ($dir === 'up') {
                        $indicator->order = max(1, $neighborOrder - 1);
                    } else {
                        $indicator->order = $neighborOrder + 1;
                    }
                } else {
                    $indicator->order = $neighborOrder;
                    $neighbor->order = $currentOrder;
                    $neighbor->save();
                }
            }
        } elseif (isset($validated['target_order'])) {
            $indicator->order = (int)$validated['target_order'];
        }

        $indicator->save();

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil dipindahkan.',
            'data' => $indicator->fresh()->loadCount('organizations')->load(['parent:id,kode,pertanyaan', 'organizations:id,name,slug']),
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
     * Lepaskan pertanyaan dari satu OPD.
     * DELETE /api/v1/saq-admin/indicators/{id}/opd/{opd_id}
     */
    public function detachOpd(Request $request, $indicatorId, $opdId)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $indicator = SaqIndicator::findOrFail($indicatorId);
        $indicator->organizations()->detach($opdId);

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil dihapus dari OPD tersebut.',
            'data' => [
                'indicator_id' => (int)$indicatorId,
                'organization_id' => (int)$opdId,
                'mapped_count' => $indicator->organizations()->count(),
            ]
        ]);
    }

    /**
     * Tambahkan / petakan pertanyaan ke satu OPD.
     * POST /api/v1/saq-admin/indicators/{id}/opd/{opd_id}
     */
    public function attachOpd(Request $request, $indicatorId, $opdId)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $indicator = SaqIndicator::findOrFail($indicatorId);
        $indicator->organizations()->syncWithoutDetaching([$opdId]);

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil dipetakan ke OPD tersebut.',
            'data' => [
                'indicator_id' => (int)$indicatorId,
                'organization_id' => (int)$opdId,
                'mapped_count' => $indicator->organizations()->count(),
            ]
        ]);
    }

    /**
     * Tambahkan batch pertanyaan ke satu OPD.
     * POST /api/v1/saq-admin/opd/{opd_id}/indicators
     */
    public function attachBatchOpd(Request $request, $opdId)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $opd = Organization::findOrFail($opdId);
        $validated = $request->validate([
            'indicator_ids' => 'required|array',
            'indicator_ids.*' => 'exists:saq_indicators,id',
        ]);

        $opd->saqIndicators()->syncWithoutDetaching($validated['indicator_ids']);

        return response()->json([
            'success' => true,
            'message' => count($validated['indicator_ids']) . ' pertanyaan berhasil ditambahkan ke OPD.',
            'data' => [
                'opd_id' => (int)$opdId,
                'attached_count' => count($validated['indicator_ids']),
                'total_mapped' => $opd->saqIndicators()->count(),
            ]
        ]);
    }

    /**
     * Atur mapping OPD untuk satu pertanyaan (Sync).
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
     * Daftar OPD untuk picker (ringkas dengan hitungan indikator).
     * GET /api/v1/saq-admin/opds
     */
    public function opds(Request $request)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $opds = Organization::where('type', 'unit')
            ->where('name', 'not like', 'Kantor Kecamatan%')
            ->where('name', 'not like', 'Desa %')
            ->where('name', 'not like', 'Kelurahan %')
            ->withCount('saqIndicators')
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

        $tabs = SaqIndicator::whereNotNull('tab')
            ->where('tab', '!=', '')
            ->select('tab')
            ->distinct()
            ->orderBy('tab')
            ->get()
            ->map(fn($t) => ['tab' => $t->tab]);

        return response()->json(['success' => true, 'data' => $tabs]);
    }

    /**
     * Daftar section yang tersedia (untuk filter/pindah seksi).
     * GET /api/v1/saq-admin/sections?tab=
     */
    public function sections(Request $request)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $query = SaqIndicator::whereNotNull('section')
            ->where('section', '!=', '');

        if ($request->filled('tab')) {
            $query->where('tab', $request->get('tab'));
        }

        $sections = $query->select('tab', 'section')
            ->distinct()
            ->orderBy('tab')
            ->orderBy('section')
            ->get();

        return response()->json(['success' => true, 'data' => $sections]);
    }
}
