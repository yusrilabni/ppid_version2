<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use App\Models\InformasiPemkab;
use App\Models\Organization;
use App\Models\SaqAnswer;
use App\Models\SaqIndicator;
use Illuminate\Http\Request;

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
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'remote_id']);

        $totalQuestions = SaqIndicator::where('is_category', false)->count();

        $data = $opds->map(function ($opd) use ($totalQuestions) {
            $answered = SaqAnswer::where('organization_id', $opd->id)->count();
            return [
                'id' => $opd->id,
                'name' => $opd->name,
                'slug' => $opd->slug,
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
        if ($orgId) {
            $answeredIds = SaqAnswer::where('organization_id', $orgId)
                ->pluck('indicator_id')->toArray();
        }

        $tabs = SaqIndicator::whereNull('parent_id')
            ->orderBy('order')
            ->with(['children' => function ($q) {
                $q->orderBy('order')->with(['children' => function ($qq) {
                    $qq->orderBy('order');
                }]);
            }])
            ->get();

        $data = $tabs->map(function ($tab) use ($answeredIds) {
            return [
                'kode' => $tab->kode,
                'tab' => $tab->tab,
                'sections' => $tab->children->map(function ($sec) use ($answeredIds) {
                    $questions = $sec->children->map(function ($qu) use ($answeredIds) {
                        return [
                            'id' => $qu->id,
                            'kode' => $qu->kode,
                            'pertanyaan' => $qu->pertanyaan,
                            'dokumen_upload' => $qu->dokumen_upload,
                            'terisi' => in_array($qu->id, $answeredIds),
                        ];
                    });
                    return [
                        'kode' => $sec->kode,
                        'section' => $sec->section,
                        'questions' => $questions,
                        'terisi' => $questions->where('terisi', true)->count(),
                        'total' => $questions->count(),
                    ];
                })->values(),
            ];
        });

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
            ->with('indicator:id,kode,pertanyaan,tab')
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
            'judul' => 'required|string|max:255',
            'link' => 'nullable|string|max:2000',
            'klasifikasi' => 'nullable|in:Informasi Berkala,Informasi Tersedia Setiap Saat,Informasi Serta Merta,Informasi Dikecualikan',
            'deskripsi' => 'nullable|string',
        ]);

        $indicator = SaqIndicator::findOrFail($validated['indicator_id']);
        if ($indicator->is_category) {
            return response()->json([
                'success' => false,
                'message' => 'Indikator tidak valid (kategori, bukan pertanyaan).',
            ], 422);
        }

        $answer = SaqAnswer::updateOrCreate(
            [
                'organization_id' => $validated['organization_id'],
                'indicator_id' => $validated['indicator_id'],
            ],
            [
                'judul' => $validated['judul'],
                'link' => $validated['link'] ?? null,
                'created_by' => $request->user()->id,
            ]
        );

        // Opsional: catat juga sebagai Informasi (draft, tidak tampil publik)
        $informasi = null;
        if (!empty($validated['klasifikasi'])) {
            $org = Organization::find($validated['organization_id']);
            $informasi = Informasi::create([
                'title' => $validated['judul'],
                'content' => $validated['deskripsi'] ?? $indicator->pertanyaan,
                'category' => $validated['klasifikasi'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'published' => false,
                'url' => $validated['link'] ?? null,
                'unit_id' => $org->remote_id ?? null,
                'user_id' => $request->user()->id,
                'tanggal_upload' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Jawaban SAQ tersimpan.',
            'data' => $answer->load('indicator:id,kode,pertanyaan'),
            'informasi_id' => $informasi?->id,
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
