<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use App\Models\InformasiPemkab;
use App\Models\Organization;
use App\Models\SaqAnswer;
use App\Models\SaqIndicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaqController extends Controller
{
    /**
     * Daftar OPD untuk SAQ: unit tanpa kecamatan/desa/kelurahan,
     * beserta profil pimpinan & progres pengisian.
     * GET /api/v1/saq/opds
     */
    public function opds()
    {
        $opds = Organization::where('type', 'unit')
            ->where('name', 'not like', 'Kantor Kecamatan%')
            ->where('name', 'not like', 'Desa %')
            ->where('name', 'not like', 'Kelurahan %')
            ->with(['officials' => function ($q) {
                $q->where('status', 'active')->with('position')->limit(3);
            }])
            ->orderByRaw("CASE WHEN slug = 'kabupaten-sinjai' THEN 0 ELSE 1 END")
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'remote_id']);

        $data = $opds->map(function ($opd) {
            // Total pertanyaan sesuai scope OPD ini (dari mapping indicator_opd)
            $totalQuestions = DB::table('indicator_opd')
                ->where('organization_id', $opd->id)->count();
            // Terisi = sudah ada jawaban Ya/Tidak
            $answered = SaqAnswer::where('organization_id', $opd->id)
                ->whereNotNull('jawaban')->count();
            return [
                'id' => $opd->id,
                'name' => $opd->name,
                'slug' => $opd->slug,
                'is_ppid_utama' => $opd->slug === 'kabupaten-sinjai',
                'pimpinan' => $opd->officials->map(fn($o) => [
                    'nama' => $o->full_name,
                    'jabatan' => $o->position->name ?? null,
                    'foto' => $o->photo,
                ])->values(),
                'progres' => [
                    'terisi' => $answered,
                    'total' => $totalQuestions,
                    'persen' => $totalQuestions > 0 ? round($answered / $totalQuestions * 100) : 0,
                ],
            ];
        });

        return response()->json(['success' => true, 'data' => $data]);
    }

    /**
     * Struktur SAQ hirarkis: tab > seksi > pertanyaan.
     * Opsional ?organization_id= untuk menandai status terisi per pertanyaan.
     * GET /api/v1/saq/structure
     */
    public function structure(Request $request)
    {
        $orgId = $request->get('organization_id');

        $answeredIds = [];
        $jawabanMap = [];
        // Daftar indicator yang dipetakan ke org ini
        $mappedIds = [];
        if ($orgId) {
            $rows = SaqAnswer::where('organization_id', $orgId)
                ->whereNotNull('jawaban')
                ->get(['indicator_id', 'jawaban']);
            $answeredIds = $rows->pluck('indicator_id')->toArray();
            $jawabanMap = $rows->pluck('jawaban', 'indicator_id')->toArray();
            $mappedIds = DB::table('indicator_opd')
                ->where('organization_id', $orgId)
                ->pluck('indicator_id')->toArray();
        }

        // Semua tab, tanpa filter scope (scope hanya di level pertanyaan)
        $tabs = SaqIndicator::whereNull('parent_id')->orderBy('order')
            ->with(['children' => function ($q) {
                $q->orderBy('order')->with(['children' => function ($qq) {
                    $qq->orderBy('order');
                }]);
            }])
            ->get();

        $data = [];
        foreach ($tabs as $tab) {
            $sections = [];
            foreach ($tab->children as $sec) {
                $questions = [];
                foreach ($sec->children as $qu) {
                    // Hanya tampilkan pertanyaan yang dipetakan ke org ini
                    if ($orgId && !in_array($qu->id, $mappedIds)) continue;
                    $questions[] = [
                        'id' => $qu->id,
                        'kode' => $qu->kode,
                        'pertanyaan' => $qu->pertanyaan,
                        'dokumen_upload' => $qu->dokumen_upload,
                        'terisi' => in_array($qu->id, $answeredIds),
                        'jawaban' => $jawabanMap[$qu->id] ?? null,
                    ];
                }
                if (empty($questions)) continue; // seksi kosong -> sembunyikan
                $terisi = count(array_filter($questions, fn($x) => $x['terisi']));
                $sections[] = [
                    'kode' => $sec->kode,
                    'section' => $sec->section,
                    'questions' => $questions,
                    'terisi' => $terisi,
                    'total' => count($questions),
                ];
            }
            if (empty($sections)) continue; // tab kosong -> sembunyikan
            // Tandai tab PPID Utama bila semua pertanyaannya scope ppid_utama
            $isPpidUtamaTab = $tab->children->flatMap(fn($s) => $s->children)
                ->filter(fn($q) => !$orgId || in_array($q->id, $mappedIds))
                ->every(fn($q) => $q->scope === 'ppid_utama');
            $data[] = [
                'kode' => $tab->kode,
                'tab' => $tab->tab,
                'scope' => $isPpidUtamaTab ? 'ppid_utama' : 'semua_opd',
                'sections' => $sections,
            ];
        }

        return response()->json(['success' => true, 'data' => $data]);
    }

    /**
     * Jawaban SAQ per OPD.
     * GET /api/v1/saq/answers?organization_id=
     */
    public function answers(Request $request)
    {
        $request->validate(['organization_id' => 'required|integer']);

        $answers = SaqAnswer::where('organization_id', $request->organization_id)
            ->with(['indicator:id,kode,pertanyaan,tab', 'links'])
            ->orderBy('id')
            ->get();

        return response()->json(['success' => true, 'data' => $answers]);
    }

    /**
     * Simpan jawaban SAQ (admin login).
     * Bila `klasifikasi` diisi -> sekaligus tercatat sebagai Informasi (draft).
     * POST /api/v1/saq/answers (auth:sanctum)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_id' => 'required|integer|exists:organizations,id',
            'indicator_id' => 'required|integer|exists:saq_indicators,id',
            'jawaban' => 'required|in:ya,tidak',
            'visibility' => 'nullable|in:public,private',
            'links' => 'nullable|array|max:20',
            'links.*.judul' => 'required_with:links|string|max:255',
            'links.*.link' => 'required_with:links|string|max:2000',
            'links.*.deskripsi' => 'nullable|string',
        ]);

        $indicator = SaqIndicator::findOrFail($validated['indicator_id']);
        if ($indicator->is_category) {
            return response()->json([
                'success' => false,
                'message' => 'Indikator tidak valid (kategori, bukan pertanyaan).',
            ], 422);
        }

        $links = array_values(array_filter(
            $validated['links'] ?? [],
            fn($l) => !empty($l['judul']) && !empty($l['link'])
        ));

        if ($validated['jawaban'] === 'ya' && empty($links)) {
            return response()->json([
                'success' => false,
                'message' => 'Jawaban "Ya" wajib disertai minimal satu link dokumen.',
            ], 422);
        }

        $visibility = $validated['visibility'] ?? 'public';

        $answer = SaqAnswer::updateOrCreate(
            [
                'organization_id' => $validated['organization_id'],
                'indicator_id' => $validated['indicator_id'],
            ],
            [
                'jawaban' => $validated['jawaban'],
                'visibility' => $visibility,
                // Kolom lama dipertahankan untuk kompatibilitas (diisi link pertama)
                'judul' => $links[0]['judul'] ?? null,
                'link' => $links[0]['link'] ?? null,
                'created_by' => $request->user()->id,
            ]
        );

        // Sinkronkan daftar link (ganti total)
        $answer->links()->delete();
        $dokumenIds = [];
        if ($validated['jawaban'] === 'ya') {
            $org = Organization::find($validated['organization_id']);
            // Klasifikasi otomatis dari pertanyaan (tidak dipilih manual)
            $klasifikasi = $indicator->klasifikasi_otomatis ?? 'Informasi Berkala';

            foreach ($links as $i => $l) {
                $answer->links()->create([
                    'judul' => $l['judul'],
                    'link' => $l['link'],
                    'deskripsi' => $l['deskripsi'] ?? null,
                    'order' => $i,
                ]);

                // Simpan sebagai dokumen: ke informasi_pemkab (web utama) atau informasis (PPID)
                if ($indicator->target_upload === 'pemkab') {
                    $dok = InformasiPemkab::create([
                        'judul' => $l['judul'],
                        'kategori' => $klasifikasi,
                        'deskripsi' => $l['deskripsi'] ?? $indicator->pertanyaan,
                        'file_path' => $l['link'],
                        'status' => 'draft',
                        'visibility' => $visibility,
                        'unit_id' => $org->id,
                        'user_id' => $request->user()->id,
                    ]);
                } else {
                    $dok = Informasi::create([
                        'title' => $l['judul'],
                        'content' => $l['deskripsi'] ?? $indicator->pertanyaan,
                        'category' => $klasifikasi,
                        'deskripsi' => $l['deskripsi'] ?? null,
                        'published' => false,
                        'url' => $l['link'],
                        'unit_id' => $org->remote_id ?? null,
                        'user_id' => $request->user()->id,
                        'tanggal_upload' => now(),
                    ]);
                }
                $dokumenIds[] = $dok->id;
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Jawaban SAQ tersimpan.',
            'data' => $answer->load(['indicator:id,kode,pertanyaan', 'links']),
            'dokumen_ids' => $dokumenIds,
        ]);
    }

    /**
     * Hapus jawaban SAQ (admin login).
     * DELETE /api/v1/saq/answers/{id} (auth:sanctum)
     */
    public function destroy($id)
    {
        $answer = SaqAnswer::findOrFail($id);
        $answer->delete();

        return response()->json(['success' => true, 'message' => 'Jawaban dihapus.']);
    }

    /**
     * Auto-sync: cek apakah sebuah link sudah ada di data PPID.
     * Bila ada -> kembalikan judul/deskripsi/pengupload/tanggal untuk auto-fill form.
     * GET /api/v1/saq/sync?url= (auth:sanctum)
     */
    public function sync(Request $request)
    {
        $request->validate(['url' => 'required|string']);

        $url = trim($request->url);

        $info = Informasi::with(['user:id,name', 'organization:id,name'])
            ->where('url', $url)
            ->orWhere('file', $url)
            ->first();

        if ($info) {
            return response()->json([
                'success' => true,
                'found' => true,
                'data' => [
                    'judul' => $info->title,
                    'deskripsi' => $info->deskripsi ?? $info->content,
                    'kategori' => $info->category,
                    'pengupload' => $info->user->name ?? null,
                    'opd' => $info->organization->name ?? null,
                    'tanggal' => $info->tanggal_upload ?? $info->created_at,
                    'sumber' => 'informasi',
                ],
            ]);
        }

        $pemkab = InformasiPemkab::with(['user:id,name', 'organization:id,name'])
            ->where('file_path', 'like', '%' . basename($url) . '%')
            ->first();

        if ($pemkab) {
            return response()->json([
                'success' => true,
                'found' => true,
                'data' => [
                    'judul' => $pemkab->judul,
                    'deskripsi' => $pemkab->deskripsi,
                    'kategori' => $pemkab->kategori,
                    'jenis_dokumen' => $pemkab->jenis_dokumen,
                    'pengupload' => $pemkab->user->name ?? null,
                    'opd' => $pemkab->organization->name ?? null,
                    'tanggal' => $pemkab->published_at ?? $pemkab->created_at,
                    'sumber' => 'informasi_pemkab',
                ],
            ]);
        }

        return response()->json(['success' => true, 'found' => false]);
    }
}
