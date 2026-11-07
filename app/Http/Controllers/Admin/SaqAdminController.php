<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\SaqAnswer;
use App\Models\SaqIndicator;
use App\Models\Setting;
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

        $tabMapping = [
            'SARANA DAN PRASARANA' => 'Sarana dan Prasarana',
            'DIGITALISASI' => 'Digitalisasi',
            'JENIS INFORMASI' => 'Jenis Informasi',
            'KUALITAS INFORMASI' => 'Kualitas Informasi',
            'KOMITMEN ORGANISASI' => 'Komitmen Organisasi',
        ];

        $query = SaqIndicator::withCount('organizations')
            ->with(['parent.parent', 'organizations:id,name,slug']);

        // Filter tab case-insensitively
        if ($request->filled('tab')) {
            $tabVal = $request->get('tab');
            $query->where(function ($q) use ($tabVal) {
                $q->where('tab', $tabVal)
                  ->orWhere('tab', strtoupper($tabVal))
                  ->orWhere('tab', mb_convert_case($tabVal, MB_CASE_TITLE));
            });
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
            // Kabupaten Sinjai (127) memuat seluruh pertanyaan master (203 soal)
            if ($orgId > 0 && $orgId !== 127) {
                $query->whereHas('organizations', function ($q) use ($orgId) {
                    $q->where('organizations.id', $orgId);
                });
            }
        }
        if ($request->filled('input_type')) {
            $query->where('input_type', $request->get('input_type'));
        }

        // Tipe data: secara default tampilkan 203 pertanyaan nyata yang dapat diatur/dijawab
        if ($request->get('type') === 'category') {
            $query->where('is_category', true);
        } elseif ($request->get('type') === 'all') {
            // Semua indikator termasuk header/kategori
        } else {
            // Default 'question': Hanya pertanyaan aktual (bukan header tab atau kategori induk kosong)
            $query->whereNotNull('parent_id')
                  ->where(function ($q) {
                      $q->where('is_category', false)->orWhereNull('is_category');
                  });
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

        // Urutan tampil persis seperti hierarki form Pemkab Sinjai:
        // Tab (1 s/d 5) -> Section/Parent -> Order -> ID
        $query->orderByRaw("
            CASE 
                WHEN UPPER(tab) LIKE '%SARANA%' THEN 1
                WHEN UPPER(tab) LIKE '%DIGITAL%' THEN 2
                WHEN UPPER(tab) LIKE '%JENIS%' THEN 3
                WHEN UPPER(tab) LIKE '%KUALITAS%' THEN 4
                WHEN UPPER(tab) LIKE '%KOMITMEN%' THEN 5
                ELSE 6
            END
        ")
        ->orderBy('parent_id')
        ->orderBy('order')
        ->orderBy('id');

        $transformItem = function ($item) use ($duplicateCounts, $tabMapping) {
            $norm = trim(mb_strtolower($item->pertanyaan ?? ''));
            $item->similar_count = $duplicateCounts[$norm] ?? 1;

            // Normalisasi nama tab ke Title Case
            $item->tab = $tabMapping[$item->tab] ?? $item->tab;

            // Resolusi nama seksi dari parent/grandparent jika seksi kosong
            $sec = $item->section;
            $curr = $item;
            while ($curr && empty($sec) && $curr->parent_id) {
                $p = $curr->parent;
                if ($p && !empty($p->section)) {
                    $sec = $p->section;
                    break;
                }
                $curr = $p;
            }
            $item->section = $sec ?: 'A. Umum';

            // Resolusi informasi grup induk
            if ($item->parent && $item->parent->is_category) {
                $item->group_id = $item->parent->id;
                $item->group_kode = $item->parent->kode;
                $item->group_pertanyaan = $item->parent->pertanyaan;
                $item->group_order = $item->parent->order ?? 0;
            } else {
                $item->group_id = null;
                $item->group_kode = null;
                $item->group_pertanyaan = null;
                $item->group_order = null;
            }

            return $item;
        };

        // Mode all (tanpa pagination kaku)
        if ($request->get('per_page') === 'all' || (int)$request->get('per_page') === -1) {
            $items = $query->get();
            $items->transform($transformItem);

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
        $data->getCollection()->transform($transformItem);

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

        $totalMasterQuestions = SaqIndicator::whereNotNull('parent_id')
            ->where(function ($q) {
                $q->where('is_category', false)->orWhereNull('is_category');
            })->count();

        $opds = Organization::where('type', 'unit')
            ->where('name', 'not like', 'Kantor Kecamatan%')
            ->where('name', 'not like', 'Desa %')
            ->where('name', 'not like', 'Kelurahan %')
            ->withCount('saqIndicators')
            ->orderByRaw("CASE WHEN slug = 'kabupaten-sinjai' THEN 0 ELSE 1 END")
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        $opds->transform(function ($opd) use ($totalMasterQuestions) {
            if ($opd->slug === 'kabupaten-sinjai') {
                $opd->saq_indicators_count = $totalMasterQuestions;
            }
            return $opd;
        });

        return response()->json(['success' => true, 'data' => $opds]);
    }

    /**
     * Daftar tab yang tersedia (untuk filter/dropdown).
     * GET /api/v1/saq-admin/tabs
     */
    public function tabs(Request $request)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $standardTabs = [
            'Sarana dan Prasarana',
            'Digitalisasi',
            'Jenis Informasi',
            'Kualitas Informasi',
            'Komitmen Organisasi',
        ];

        // Hitung jumlah pertanyaan aktual per tab
        $questions = SaqIndicator::whereNotNull('parent_id')
            ->where(function ($q) {
                $q->where('is_category', false)->orWhereNull('is_category');
            })
            ->select('tab')
            ->get();

        $tabMapping = [
            'SARANA DAN PRASARANA' => 'Sarana dan Prasarana',
            'Sarana dan Prasarana' => 'Sarana dan Prasarana',
            'DIGITALISASI' => 'Digitalisasi',
            'Digitalisasi' => 'Digitalisasi',
            'JENIS INFORMASI' => 'Jenis Informasi',
            'Jenis Informasi' => 'Jenis Informasi',
            'KUALITAS INFORMASI' => 'Kualitas Informasi',
            'Kualitas Informasi' => 'Kualitas Informasi',
            'KOMITMEN ORGANISASI' => 'Komitmen Organisasi',
            'Komitmen Organisasi' => 'Komitmen Organisasi',
        ];

        $counts = [];
        foreach ($questions as $q) {
            $normalized = $tabMapping[$q->tab] ?? $q->tab;
            $counts[$normalized] = ($counts[$normalized] ?? 0) + 1;
        }

        $result = [];
        foreach ($standardTabs as $tabName) {
            $result[] = [
                'tab' => $tabName,
                'count' => $counts[$tabName] ?? 0,
            ];
        }

        return response()->json(['success' => true, 'data' => $result]);
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

    /**
     * Ambil status penguncian pengisian SAQ.
     * GET /api/v1/saq-admin/lock-status
     */
    public function getLockStatus(Request $request)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $val = Setting::where('key', 'saq_submissions_locked')->value('value');
        $locked = $val === null ? true : in_array((string)$val, ['1', 'true'], true);

        return response()->json([
            'success' => true,
            'data' => [
                'locked' => $locked,
            ]
        ]);
    }

    /**
     * Ubah status penguncian pengisian SAQ (Superadmin only).
     * POST /api/v1/saq-admin/toggle-lock
     * Body: { locked: true|false }
     */
    public function toggleLock(Request $request)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $validated = $request->validate([
            'locked' => 'required|boolean',
        ]);

        $newVal = $validated['locked'] ? '1' : '0';
        Setting::updateOrCreate(
            ['key' => 'saq_submissions_locked'],
            ['value' => $newVal]
        );

        return response()->json([
            'success' => true,
            'message' => $validated['locked']
                ? 'Pengisian SAQ berhasil DIKUNCI. Hanya Superadmin yang dapat mengisi jawaban.'
                : 'Pengisian SAQ berhasil DIBUKA untuk seluruh Admin OPD.',
            'data' => [
                'locked' => (bool)$validated['locked'],
            ]
        ]);
    }

    /**
     * Hapus / Reset seluruh jawaban SAQ (Superadmin only).
     * POST /api/v1/saq-admin/reset-answers
     * Body: { organization_id?: int, all_opds?: bool }
     */
    public function resetAnswers(Request $request)
    {
        if ($err = $this->checkSuperAdmin($request)) return $err;

        $allOpds = $request->boolean('all_opds');
        $orgId = $request->input('organization_id');

        if (!$allOpds && empty($orgId)) {
            return response()->json([
                'success' => false,
                'message' => 'Pilih OPD tertentu atau tentukan all_opds: true untuk mereset seluruh OPD.',
            ], 422);
        }

        DB::beginTransaction();
        try {
            $query = SaqAnswer::query();
            $targetLabel = 'seluruh OPD';

            if (!$allOpds) {
                $org = Organization::find($orgId);
                $targetLabel = $org ? "OPD {$org->name}" : "OPD ID {$orgId}";
                $query->where('organization_id', $orgId);
            }

            $answers = $query->get(['id']);
            $answerIds = $answers->pluck('id')->toArray();
            $totalDeleted = count($answerIds);

            if ($totalDeleted > 0) {
                // 1. Bersihkan file dokumen fisik di storage/saq
                $links = DB::table('saq_answer_links')
                    ->whereIn('saq_answer_id', $answerIds)
                    ->where('sumber_informasi', 'lampiran')
                    ->pluck('link');

                foreach ($links as $linkUrl) {
                    if (!empty($linkUrl)) {
                        $parsedPath = parse_url($linkUrl, PHP_URL_PATH);
                        $cleanPath = ltrim($parsedPath ?: '', '/');
                        $cleanPath = preg_replace('#^storage/#', '', $cleanPath);
                        if (str_starts_with($cleanPath, 'saq/')) {
                            \Illuminate\Support\Facades\Storage::disk('public')->delete($cleanPath);
                        }
                    }
                }

                // 2. Hapus Informasi & InformasiPemkab yang terkait jawaban SAQ
                \App\Models\Informasi::whereIn('saq_answer_id', $answerIds)->delete();
                \App\Models\InformasiPemkab::whereIn('saq_answer_id', $answerIds)->delete();

                // 3. Hapus Galeri yang terkait jawaban SAQ
                \App\Models\Galeri::whereIn('saq_answer_id', $answerIds)->delete();

                // 4. Hapus relasi link jawaban
                DB::table('saq_answer_links')->whereIn('saq_answer_id', $answerIds)->delete();

                // 5. Hapus records saq_answers
                SaqAnswer::whereIn('id', $answerIds)->delete();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Berhasil mereset {$totalDeleted} jawaban SAQ untuk {$targetLabel}.",
                'data' => [
                    'deleted_count' => $totalDeleted,
                    'target' => $targetLabel,
                ],
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Gagal reset jawaban SAQ: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mereset jawaban SAQ: ' . $e->getMessage(),
            ], 500);
        }
    }
}
